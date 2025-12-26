<?php
include("conecta.php");
session_start();

if (!isset($_SESSION['id_usuario']) || $_SESSION['perfil_usuario'] != 1) {
    header("Location: login.php?status=nao_autorizado");
    exit();
}

$queryListarSolicitacao = "SELECT DISTINCT solicitacao_itens.id_solicitacao, 
       solicitacao_itens.data_solicitacao,
       solicitacao_itens.data_devolucao_item,
       solicitacao_itens.motivo_solicitacao,
       solicitacao_itens.id_usuario,
       solicitacao_itens.status_solicitacao,
       usuarios.nome_usuario
FROM solicitacao_itens 
JOIN usuarios ON solicitacao_itens.id_usuario = usuarios.id_usuario
ORDER BY solicitacao_itens.data_solicitacao ASC";

$resultListarSolicitacao = mysqli_query($conexao, $queryListarSolicitacao);
if (!$resultListarSolicitacao) {
    die("Erro ao listar solicitações: " . mysqli_error($conexao));
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Solicitações - Quartelaria</title>
  <link rel="stylesheet" href="style.css?v=2">
</head>
<body>
  <div class="bg-fallback"></div>

  <nav>
         <div class="logo"><a href="homeQuarteleiro.php"><img src="./img/home.png" alt="Home" style="width: 28px; vertical-align: middle-top;"><span> COMMANDER</span></a></div>

      <ul>
        <li><a href="equipamentos.php" class="ativo">Equipamentos / Armamentos</a></li>
        <li><a href="operacoes.php">Operações</a></li>
        <li><a href="solicitacoesQuarteleiro.php">Solicitações</a></li>
        <li><a href="solicitacoesVtr.php">Solicitações Viatura</a></li>
        <li><a href="solicitarSolicitante.php">Solicitação Direta</a></li>
        <li><a href="listarUsuarios.php">Usuários</a></li>
        <li><a href="cadastrarQuarteleiro.php">Cadastrar Quarteleiro</a></li>
        <li><a href="editarPerfil.php">Perfil</a></li>
        <li><a href="logout.php"><img src="./img/logout.png" alt="Logout" style="width: 30px; height: 30px; vertical-align: middle;"></a></li>
      </ul>
  </nav>

  <div class="container">
            <?php echo "<a href='solicitacoesAnterioresQuarteleiro.php' class=\"btn\">Solicitações Anteriores </a>";?>

    <h1>Solicitações</h1>
    <hr>

    <?php
    if (isset($_GET['status'])) {
        $status = $_GET['status'];
        if ($status == 2) {
            echo "<div id='mensagem' class='alert error'>Solicitação negada.</div>";
        } elseif ($status == 1) {
            echo "<div id='mensagem' class='alert success'>Solicitação aceita.</div>";
        } else {
            echo "<div id='mensagem' class='alert info'>Erro não identificado.</div>";
        }
    }
    ?>

    <script>
      setTimeout(function() {
          var msg = document.getElementById('mensagem');
          if (msg) msg.style.display = 'none';
          const url = new URL(window.location);
          url.searchParams.delete('status');
          window.history.replaceState({}, document.title, url);
      }, 3000);
    </script>

    <hr>

    <?php
    $estoqueInsuficiente = false;
    $armamentoOcupado = false;

    while ($dadosSolicitacao = mysqli_fetch_assoc($resultListarSolicitacao)) {
        $queryOperacao = "SELECT * FROM operacoes WHERE id_operacao = '{$dadosSolicitacao['motivo_solicitacao']}'";
        $resultOperacao = mysqli_query($conexao,$queryOperacao);
        $motivoOperacao = mysqli_fetch_assoc($resultOperacao);
 
        if ($dadosSolicitacao['status_solicitacao'] == 'Pendente') {
            $estoqueInsuficiente = false;
            $armamentoOcupado = false;

            $id_solicitacao = $dadosSolicitacao['id_solicitacao'];

            if (empty($id_solicitacao) || !is_numeric($id_solicitacao)) {
                continue;
            }

            $id_solicitacao = (int)$id_solicitacao;

            echo "<div class='card'>";
            echo "<p><strong>Solicitante:</strong> {$dadosSolicitacao['nome_usuario']}</p>";
            echo "<p><strong>Datas:</strong><br>
                  Solicitação: {$dadosSolicitacao['data_solicitacao']}<br>
                  Devolução prevista: {$dadosSolicitacao['data_devolucao_item']}</p>";
            echo "<p><strong>Motivo:</strong> {$motivoOperacao['nome_operacao']}</p>";
            echo "<strong>Itens:</strong>";

            echo "<table class='tabela'>
                    <tr>
                        <th>Nome</th>
                        <th>Código</th>
                        <th>Quantidade</th>
                        <th>Tipo</th>
                    </tr>";
                    
            $queryListarItens = "
                SELECT solicitacao_itens.*, 
                       equipamentos.id_equipamento, equipamentos.nome_equipamento,
                       armamentos.id_armamento, armamentos.nome_armamento, armamentos.codigo_armamento 
                FROM solicitacao_itens 
                LEFT JOIN equipamentos 
                    ON solicitacao_itens.id_item = equipamentos.id_equipamento 
                    AND solicitacao_itens.tipo_item = 'equipamento'
                LEFT JOIN armamentos 
                    ON solicitacao_itens.id_item = armamentos.id_armamento 
                    AND solicitacao_itens.tipo_item = 'armamento'
                WHERE solicitacao_itens.id_solicitacao = $id_solicitacao
            ";

            $resultListarItens = mysqli_query($conexao, $queryListarItens);
            if (!$resultListarItens) {
                echo "<tr><td colspan='4' style='color:red;'>Erro ao carregar itens: " . mysqli_error($conexao) . "</td></tr>";
                echo "</table></div><br><hr>";
                continue;
            }

            while ($item = mysqli_fetch_assoc($resultListarItens)) {
                if ($item['tipo_item'] == 'armamento') {
                    $idArmamento = $item['id_armamento'];
                    $nome = $item['nome_armamento'];
                    $codigo = $item['codigo_armamento'];
                    $quant = $item['quantidade'];
                    $tipo = 'Armamento';

                    $queryStatus = "SELECT status_armamento FROM armamentos WHERE id_armamento = $idArmamento";
                    $resStatus = mysqli_query($conexao, $queryStatus);
                    if ($resStatus && $dadosStatus = mysqli_fetch_assoc($resStatus)) {
                        if ($dadosStatus['status_armamento'] == 1) {
                            $armamentoOcupado = true;
                            echo "<tr style='background-color: rgba(255, 0, 0, 0.15);'>
                                    <td>$nome</td><td>$codigo</td><td>$quant</td><td>$tipo (em uso)</td>
                                  </tr>";
                        } else {
                            echo "<tr><td>$nome</td><td>$codigo</td><td>$quant</td><td>$tipo</td></tr>";
                        }
                    } else {
                        echo "<tr><td colspan='4' style='color:red;'>Erro ao buscar status do armamento ID $idArmamento.</td></tr>";
                    }

                } elseif ($item['tipo_item'] == 'equipamento') {
                    $idEquipamento = $item['id_equipamento'];
                    $nome = $item['nome_equipamento'];
                    $codigo = $item['id_equipamento'];
                    $quant = $item['quantidade'];
                    $tipo = 'Equipamento';

                    $estoque = "SELECT quantidade_equipamento, quantidade_disponivel_equipamento 
                                FROM equipamentos WHERE id_equipamento = $idEquipamento";
                    $resEstoque = mysqli_query($conexao, $estoque);

                    if ($resEstoque && $dadosEstoque = mysqli_fetch_assoc($resEstoque)) {
                        $total = $dadosEstoque['quantidade_equipamento'];
                        $emprestado = $dadosEstoque['quantidade_disponivel_equipamento'];
                        $disponivel = $total - $emprestado;

                        if ($quant > $disponivel) {
                            $estoqueInsuficiente = true;
                            echo "<tr style='background-color: rgba(255, 0, 0, 0.15);'>
                                    <td>$nome</td><td>$codigo</td><td>$quant</td><td>$tipo</td>
                                  </tr>";
                        } else {
                            echo "<tr><td>$nome</td><td>$codigo</td><td>$quant</td><td>$tipo</td></tr>";
                        }
                    } else {
                        echo "<tr><td colspan='4' style='color:red;'>Erro ao buscar estoque do equipamento ID $idEquipamento.</td></tr>";
                    }
                }
            }

            echo "</table><br>";

            if ($estoqueInsuficiente || $armamentoOcupado) {
                echo "<div class='alert error'>⚠️ Não é possível aceitar esta solicitação: há itens sem disponibilidade.<br>
                      <a href='deliberarSolicitacao.php?status=2&id=$id_solicitacao' class='btn'style='background-color: #ff0019ff; color: white;'>Negar</a></div>";
            } else {
                echo "<div class='form-buttons'>
                        <a href='deliberarSolicitacao.php?status=1&id=$id_solicitacao' class='btn' >Aceitar</a>
                        <a href='deliberarSolicitacao.php?status=2&id=$id_solicitacao' class='btn' style='background-color: #ff0019ff; color: white;'>Negar</a>
                      </div>";
            }

            echo "</div><hr>";
        }
    }
    ?>
  </div>

  <footer>
    &copy; <?php echo date("Y"); ?> COMMANDER - Todos os direitos reservados.
  </footer>
</body>
</html>
