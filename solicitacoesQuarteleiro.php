<?php
include("conecta.php");

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
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solicitações - Quartelaria</title>
</head>

<body>
    <a href="homeQuarteleiro.php">Voltar</a><br>
    <a href="homeQuarteleiro.php">Home</a><br>
    <strong><a href="solicitacoesAnterioresQuarteleiro.php">Solicitações Anteriores</a></strong>
    <h1>Solicitações</h1>

    <?php
    echo "<hr>";
    if (isset($_GET['status'])) {
        $status = $_GET['status'];
        if ($status == 2) {
            echo "<div id='mensagem' style=\"color: red;\"> Solicitação negada. </div>";
        } elseif ($status == 1) {
            echo "<div id='mensagem' style=\"color: green;\"> Solicitação aceita. </div>";
        } else {
            echo "<div id='mensagem' style=\"color: orange;\"> Erro não identificado. </div>";
        }
    }
    echo "<hr>";
    ?>

    <script>
        setTimeout(function () {
            var msg = document.getElementById('mensagem');
            if (msg) {
                msg.style.display = 'none';
            }
            const url = new URL(window.location);
            url.searchParams.delete('status');
            window.history.replaceState({}, document.title, url);
        }, 3000);
    </script>

    <?php
    $estoqueInsuficiente = false;
$armamentoOcupado = false;

    while ($dadosSolicitacao = mysqli_fetch_assoc($resultListarSolicitacao)) {
        if ($dadosSolicitacao['status_solicitacao'] == 'Pendente') {
            $estoqueInsuficiente = false;
            $id_solicitacao = $dadosSolicitacao['id_solicitacao'];

            echo "Solicitante: {$dadosSolicitacao['nome_usuario']}<br>";
            echo "Datas:<br>";
            echo "Solicitação: {$dadosSolicitacao['data_solicitacao']}<br>";
            echo "Devolução prevista: {$dadosSolicitacao['data_devolucao_item']} <br>";
            echo "Motivo: {$dadosSolicitacao['motivo_solicitacao']} <br>";
            echo "<strong>Itens:</strong>";
            echo "<table border='1'>
                    <tr>
                        <th>Nome</th>
                        <th>Código</th>
                        <th>Quantidade</th>
                        <th>Tipo</th>
                    </tr>";

            $queryListarItens = "SELECT solicitacao_itens.*, equipamentos.id_equipamento,equipamentos.nome_equipamento,
                                 armamentos.id_armamento,armamentos.nome_armamento, armamentos.codigo_armamento 
                                 FROM solicitacao_itens 
                                 LEFT JOIN equipamentos ON solicitacao_itens.id_item = equipamentos.id_equipamento 
                                     AND solicitacao_itens.tipo_item = 'equipamento'
                                 LEFT JOIN armamentos ON solicitacao_itens.id_item = armamentos.id_armamento 
                                     AND solicitacao_itens.tipo_item = 'armamento'
                                 WHERE solicitacao_itens.id_solicitacao = $id_solicitacao";
            $resultListarItens = mysqli_query($conexao, $queryListarItens);

            if (!$resultListarItens) {
                die("Erro na query de itens (solicitação $id_solicitacao): " . mysqli_error($conexao));
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
                    if (!$resStatus) {
                        die("Erro ao buscar status do armamento ID $idArmamento: " . mysqli_error($conexao));
                    }

                    $dadosStatus = mysqli_fetch_assoc($resStatus);
                    $statusArmamento = $dadosStatus['status_armamento'];

                    if ($statusArmamento == 1) {
                        $armamentoOcupado = true;
                        echo "<tr style='background-color: #ffdddd;'>
                <td>$nome</td>
                <td>$codigo</td>
                <td>$quant</td>
                <td>$tipo (em uso)</td>
              </tr>";
                    } else {
                        echo "<tr>
                <td>$nome</td>
                <td>$codigo</td>
                <td>$quant</td>
                <td>$tipo</td>
              </tr>";
                    }
                } elseif ($item['tipo_item'] == 'equipamento') {
                    $idEquipamento = $item['id_equipamento'];
                    $nome = $item['nome_equipamento'];
                    $codigo = $item['id_equipamento'];
                    $quant = $item['quantidade'];
                    $tipo = 'Equipamento';

                    // Consulta de estoque
                    $estoque = "SELECT quantidade_equipamento, quantidade_disponivel_equipamento 
                                FROM equipamentos WHERE id_equipamento = $idEquipamento";
                    $resEstoque = mysqli_query($conexao, $estoque);
                    if (!$resEstoque) {
                        die("Erro ao buscar estoque do equipamento ID $idEquipamento: " . mysqli_error($conexao));
                    }

                    $dadosEstoque = mysqli_fetch_assoc($resEstoque);
                    if (!$dadosEstoque) {
                        die("Equipamento com ID $idEquipamento não encontrado no banco de dados.");
                    }

                    $total = $dadosEstoque['quantidade_equipamento'];
                    $emprestado = $dadosEstoque['quantidade_disponivel_equipamento'];
                    $disponivel = $total - $emprestado;

                    if ($quant > $disponivel) {
                        $estoqueInsuficiente = true;
                        echo "<tr style='background-color: #ffdddd;'>
                                <td>$nome</td>
                                <td>$codigo</td>
                                <td>$quant</td>
                                <td>$tipo</td>
                              </tr>";
                    } else {
                        echo "<tr>
                                <td>$nome</td>
                                <td>$codigo</td>
                                <td>$quant</td>
                                <td>$tipo</td>
                              </tr>";
                    }
                }
            }

            echo "</table><br>";

if ($estoqueInsuficiente || $armamentoOcupado) {
    echo "<p style='color:red;'>⚠️ Não é possível aceitar esta solicitação: há itens sem disponibilidade.<br>
    <a href='deliberarSolicitacao.php?status=2&id=$id_solicitacao'>Negar</a></p>";
} else {
    echo "<a href='deliberarSolicitacao.php?status=1&id=$id_solicitacao'>Aceitar</a> | 
          <a href='deliberarSolicitacao.php?status=2&id=$id_solicitacao'>Negar</a>";
            echo "<hr>";
        }
    }}
    ?>
</body>

</html>