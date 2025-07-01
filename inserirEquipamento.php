<?php
include("conecta.php");
$tipoMaisEquipamento = $_POST['equipamento'];
$quantidadeMin = $_POST['quantidadeMin'];
list($tipoEquipamento, $nomeEquipamento) = explode("|", $tipoMaisEquipamento);
$quantidadeEquipamento = $_POST['quantidadeEquip'];
$queryVerify = "SELECT * FROM equipamentos where nome_equipamento = '$nomeEquipamento' AND tipo_equipamento = '$tipoEquipamento'";
$resultVerify = mysqli_query($conexao, $queryVerify);

if (mysqli_num_rows($resultVerify) > 0) {
$equipamento = mysqli_fetch_array($resultVerify);
$novaQuantidade = $equipamento['quantidade_equipamento'] + $quantidadeEquipamento;
$sqlUpdate = "UPDATE equipamentos SET quantidade_equipamento = $novaQuantidade WHERE id_equipamento = {$equipamento['id_equipamento']}";
$queryUpdate = mysqli_query($conexao, $sqlUpdate);
if (!$queryUpdate) {
        $i = 0;
    } else {
        $i = 1;
    }}
    else{


$sql = "INSERT INTO equipamentos(nome_equipamento,tipo_equipamento,quantidade_equipamento,estoque_minimo_equipamento) VALUE 
(\"$nomeEquipamento\",\"$tipoEquipamento\",\"$quantidadeEquipamento\",\"$quantidadeMin\")";
$query = mysqli_query($conexao, $sql);
if (!$query) {
    $i = 0;
} else {
    $i = 1;
}}
header("Location: addEquipamento.php?status=$i");
exit();
?>