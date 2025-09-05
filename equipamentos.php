<?php
include ("conecta.php");
session_start();
if(!isset($_SESSION['id_usuario'])){
    header("Location: login.php?status=nao_autorizado");
    exit();
}
$queryEquip = "SELECT * FROM equipamentos GROUP BY nome_equipamento ORDER BY tipo_equipamento";
$queryArma = "SELECT * FROM armamentos GROUP BY nome_armamento ";
$resultEquip = mysqli_query($conexao, $queryEquip);
$resultArma = mysqli_query($conexao, $queryArma);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Equipamentos/Armamentos - Quartelaria</title>
</head>
<body>
    <a href="homeQuarteleiro.php">Voltar - Home</a>
    <h1>==========================</h1>
    <a href="addEquipamento.php">Adicionar Equipamento - Munição</a> |
    <a href="addArmamento.php">Adicionar Armamento</a> |
    <a href="verDetalhesItens.php">Ver detalhes</a><br><br>

    <h1>Equipamentos</h1>
    <?php
    echo "<table border='1'>
        <thead>
            <tr>
                <th>Nome</th>
                <th>Tipo</th>
                <th>Quantidade Disponível</th>
            </tr>
        </thead>
        <tbody>";

    while ($dadosEquip = mysqli_fetch_array($resultEquip)) {
        $nome = $dadosEquip['nome_equipamento'];
        $tipo = $dadosEquip['tipo_equipamento'];
        $quantidadeTotal = $dadosEquip['quantidade_equipamento'];
        $quantidadeDisponivel = $quantidadeTotal - $dadosEquip['quantidade_disponivel_equipamento'];
        echo "<tr>
            <td>$nome</td>
            <td>$tipo</td>
            <td>$quantidadeDisponivel</td>
        </tr>";
    }

    echo "</tbody></table>";

    ?>

    <h1>Armamentos</h1>
    <?php
    echo "<table border='1'>
        <thead>
            <tr>
                <th>Nome</th>
                <th>Tipo</th>
                <th>Quantidade Disponível</th>
            </tr>
        </thead>
        <tbody>";

    while ($dadosArma = mysqli_fetch_array($resultArma)) {
        $nome = $dadosArma['nome_armamento'];
        $tipo = $dadosArma['tipo_armamento'];
        $quantidadeDisponivel = '(definir codigo)';
        
        echo "<tr>
            <td>$nome</td>
            <td>$tipo</td>
            <td>$quantidadeDisponivel</td>
        </tr>";
    }

    echo "</tbody></table>";
    ?>

</body>
</html>
