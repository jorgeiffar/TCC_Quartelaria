<?php
include("conecta.php");

session_start();
if(!isset($_SESSION['id_usuario']) || $_SESSION['perfil_usuario'] !=1){
    header("Location: login.php?status=nao_autorizado");
    exit();
}

$query = "SELECT si.id_solicitacao, si.data_solicitacao, si.data_devolucao_item, si.status_solicitacao,
                 u.nome_usuario, si.tipo_item, si.id_item,
                 e.nome_equipamento, e.tipo_equipamento,
                 a.nome_armamento, a.tipo_armamento
          FROM solicitacao_itens si
          JOIN usuarios u ON si.id_usuario = u.id_usuario
          LEFT JOIN equipamentos e ON si.id_item = e.id_equipamento AND si.tipo_item = 'equipamento'
          LEFT JOIN armamentos a ON si.id_item = a.id_armamento AND si.tipo_item = 'armamento'
          WHERE si.status_solicitacao = 'Aceito'
          ORDER BY si.id_solicitacao";

$resultado = mysqli_query($conexao, $query);

$id_atual = 0;
$equipamentos = "";
$armamentos = "";

// VTR
$query_vtr = "SELECT 
                sv.id_solicitacao_viatura, 
                sv.data_solicitacao_viatura, 
                sv.quilometragem, 
                sv.placa_veiculo,
                sv.status_solicitacao_viatura,
                u.nome_usuario
              FROM solicitacao_viatura sv
              JOIN usuarios u ON sv.id_usuario = u.id_usuario
              WHERE sv.status_solicitacao_viatura = 'Ativo'
              ORDER BY sv.data_solicitacao_viatura ASC";

$resultado_vtr = mysqli_query($conexao, $query_vtr);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Empréstimos - Quartelaria</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

  <!-- CAMADA DE FUNDO CLARO (OBRIGATÓRIA) -->
  

  <header>
    <nav>
      <div class="logo"><a href="homeQuarteleiro.php">Commander</a></div>
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
  </header>

  <main class="container">
    <section>
      <h1>Empréstimos</h1>
      <hr>

      <div class="card">
        <?php
        if(mysqli_num_rows($resultado) <= 0){
            echo "<p>Nenhum Empréstimo Ativo.</p>";
        } else {
            echo "<table>
                    <tr>
                        <th>Usuário</th>
                        <th>Equipamentos</th>
                        <th>Armamentos</th>
                        <th>Datas</th>
                        <th>Status</th>
                        <th>Opções</th>
                    </tr>";

            while ($dados = mysqli_fetch_assoc($resultado)) {
                $id = $dados['id_solicitacao'];

                if ($id != $id_atual && $id_atual != 0) {
                    echo "<tr>
                            <td>$nome</td>
                            <td>$equipamentos</td>
                            <td>$armamentos</td>
                            <td>$data_solicitacao - $data_devolucao</td>
                            <td>$status</td>
                            <td><a href='verDetalhesEmprestimo.php?id=$id_atual'>Ver detalhes</a></td>
                          </tr>";
                    $equipamentos = "";
                    $armamentos = "";
                }

                if ($id != $id_atual) {
                    $id_atual = $id;
                    $nome = $dados['nome_usuario'];
                    $data_solicitacao = date("d/m/Y", strtotime($dados['data_solicitacao']));
                    $data_devolucao = date("d/m/Y", strtotime($dados['data_devolucao_item']));
                    $status = $dados['status_solicitacao'];
                }

                if ($dados['tipo_item'] == 'equipamento') {
                    $equipamentos .= $dados['tipo_equipamento'] . " - " . $dados['nome_equipamento'] . "<br>";
                } elseif ($dados['tipo_item'] == 'armamento') {
                    $armamentos .= $dados['tipo_armamento'] . " - " . $dados['nome_armamento'] . "<br>";
                }
            }

            if ($id_atual != 0) {
                echo "<tr>
                        <td>$nome</td>
                        <td>$equipamentos</td>
                        <td>$armamentos</td>
                        <td>$data_solicitacao - $data_devolucao</td>
                        <td>$status</td>
                        <td><a href='verDetalhesEmprestimo.php?id=$id_atual'>Ver detalhes</a></td>
                      </tr>";
            }

            echo "</table>";
        }
        ?>
      </div>
    </section>

    <section>
      <h2>Empréstimos de Viatura</h2>
      <hr>

      <div class="card">
        <?php
        if(mysqli_num_rows($resultado_vtr) <= 0){
            echo "<p>Nenhum Checklist de Viatura Ativo.</p>";
        } else {
            echo "<table>
                    <tr>
                      <th>Usuário</th>
                      <th>Placa / KM</th>
                      <th>Data/Hora Solicitação</th>
                      <th>Status</th>
                      <th>Opções</th>
                    </tr>";

            while ($dados_vtr = mysqli_fetch_assoc($resultado_vtr)) {
                $id_vtr = $dados_vtr['id_solicitacao_viatura'];
                $nome_vtr = $dados_vtr['nome_usuario'];
                $placa_km = $dados_vtr['placa_veiculo'] . " / " . $dados_vtr['quilometragem'] . " km";
                $data_solicitacao_vtr = date("d/m/Y H:i", strtotime($dados_vtr['data_solicitacao_viatura']));
                $status_vtr = $dados_vtr['status_solicitacao_viatura'];

                echo "<tr>
                        <td>$nome_vtr</td>
                        <td>$placa_km</td>
                        <td>$data_solicitacao_vtr</td>
                        <td>$status_vtr</td>
                        <td>
                            <a href='detalhesVtr.php?id=$id_vtr&status=6'>Ver detalhes</a> |
                            <a href='processaDeliberacaoVtr.php?id=$id_vtr&fim=1'>Finalizar</a>
                        </td>
                      </tr>";
            }

            echo "</table>";
        }
        ?>
      </div>
    </section>
  </main>

  <footer>
   &copy; <?php echo date("Y"); ?> COMMANDER - Sistema de Gerenciamento de Quartelaria
  </footer>

</body>
</html>