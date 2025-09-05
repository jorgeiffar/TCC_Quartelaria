<?php
include("conecta.php");
session_start();
if(!isset($_SESSION['id_usuario']) || $_SESSION['perfil_usuario'] != 1){
    header("Location: login.php?status=nao_autorizado");
    exit();
}
$sqlArmamentos = "SELECT * FROM armamentos  ORDER BY nome_armamento DESC";
$sqlEquipamentos = "SELECT * FROM equipamentos";
$queryArmamentos = mysqli_query($conexao, $sqlArmamentos);
$queryEquipamentos = mysqli_query($conexao, $sqlEquipamentos);
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalhes Itens - Quartelaria</title>
</head>

<body>
    <a href="equipamentos.php">Voltar</a><br>
    <a href="homeQuarteleiro.php">Home</a>
    <h1>Itens - Detalhes</h1>
    <hr>
      <h1>Equipamentos</h1>
    <?php
   

//Equipamentos
 echo "<table border='1'>
        <thead>
            <tr>
                <th>Nome</th>
                <th>Tipo</th>
                <th>Quantidade Disponível</th>
                <th>Quantidade Total</th>
                <th>Última Atualização do Estoque</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>";

    while ($dadosEquip = mysqli_fetch_array($queryEquipamentos)) {
        $nome = $dadosEquip['nome_equipamento'];
        $tipo = $dadosEquip['tipo_equipamento'];
        $quantidadeTotal = $dadosEquip['quantidade_equipamento'];
        $quantidadeDisponivel = $quantidadeTotal - $dadosEquip['quantidade_disponivel_equipamento'];
        $dataCadastro = $dadosEquip['data_cadastro_equipamento'];
        $statusEquip = $dadosEquip['status_equipamento'];
        
        echo "<tr>
            <td>$nome</td>
            <td>$tipo</td>
            <td>$quantidadeDisponivel</td>
            <td>$quantidadeTotal</td>
            <td>$dataCadastro</td>
            <td>$statusEquip</td>
        </tr>";
    }

    echo "</tbody></table>";

    
    // Armamentos
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
            </tr>
        </thead>
        <tbody>";

    while ($dadosArma = mysqli_fetch_array($queryArmamentos)) {
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
        </tr>";
    }

    echo "</tbody></table>";
    ?>

</body>

</html>