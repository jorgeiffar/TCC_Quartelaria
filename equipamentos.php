<?php
include ("conecta.php");

// Consultas para equipamentos e armamentos
$queryEquip = "SELECT * FROM equipamentos";
$queryArma = "SELECT * FROM armamentos";

// Executa as consultas
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
                <th>Quantidade Total</th>
                <th>Estoque Mínimo</th>
                <th>Data de Cadastro</th>
                <th>Status</th>
                <th>Opções</th>
            </tr>
        </thead>
        <tbody>";

    while ($dadosEquip = mysqli_fetch_array($resultEquip)) {
        $nome = $dadosEquip['nome_equipamento'];
        $tipo = $dadosEquip['tipo_equipamento'];
        $quantidadeTotal = $dadosEquip['quantidade_equipamento'];
        $quantidadeDisponivel = $dadosEquip['quantidade_disponivel_equipamento'];
        $estoqueMin = $dadosEquip['estoque_minimo_equipamento'];
        $dataCadastro = $dadosEquip['data_cadastro_equipamento'];
        $statusEquip = $dadosEquip['status_equipamento'];
        
        echo "<tr>
            <td>$nome</td>
            <td>$tipo</td>
            <td>$quantidadeDisponivel</td>
            <td>$quantidadeTotal</td>
            <td>$estoqueMin</td>
            <td>$dataCadastro</td>
            <td>$statusEquip</td>
            <td>Editar | Excluir</td>
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
                <th>Calibre</th>
                <th>Código</th>
                <th>Status</th>
                <th>Opções</th>
            </tr>
        </thead>
        <tbody>";

    while ($dadosArma = mysqli_fetch_array($resultArma)) {
        $nome = $dadosArma['nome_armamento'];
        $tipo = $dadosArma['tipo_armamento'];
        $calibre = $dadosArma['calibre_armamento'];
        $codigo = $dadosArma['codigo_armamento'];
        $statusArma = $dadosArma['status_armamento'];
        
        echo "<tr>
            <td>$nome</td>
            <td>$tipo</td>
            <td>$calibre</td>
            <td>$codigo</td>
            <td>$statusArma</td>
            <td>Editar | Excluir</td>
        </tr>";
    }

    echo "</tbody></table>";
    ?>

</body>
</html>
