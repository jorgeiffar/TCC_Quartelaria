<?php
include("conecta.php");

$sqlOperacao = "SELECT * FROM operacoes";
$queryOperacao = mysqli_query($conexao, $sqlOperacao);

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Operações - Quartelaria</title>
</head>

<body>
    <a href="homeQuarteleiro.php">Voltar</a><br>
    <a href="homeQuarteleiro.php">Home</a><br>
    <button><a href="addOperacao.php">Adicionar operação</a></button>
    
    <?php
    echo "<tbody> <h1>Operações</h1><table border='1'> 
            <tr>
                <th>Nome</th>
                <th>Local</th>
                <th>Descrição</th>
                <th>Tipo</th>
                <th>Data de início</th>
                <th>Status</th>
                <th>Opções</th>
                
            </tr>";
    while ($operacao = mysqli_fetch_assoc($queryOperacao)) {
        $nome = $operacao['nome_operacao'];
        $local = $operacao['local_operacao'];
        $tipo = $operacao['tipo_operacao'];
        $descricao = $operacao['descricao_operacao'];
        $data = $operacao['data_inicio_operacao'];
        $status = $operacao['status_operacao'];
        echo "<tr>";
        echo "<td>$nome</td>
    <td>$local</td>
    <td>$descricao</td>
    <td>$tipo</td>
    <td>$data</td>
    <td>$status</td>
    <td>Editar | Excluir</td>";
        echo "</tr>";
    }echo "</table> </tbody>";?>
</body>

</html>