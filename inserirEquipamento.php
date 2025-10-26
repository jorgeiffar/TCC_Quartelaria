<?php
include("conecta.php");
session_start();
if(!isset($_SESSION['id_usuario']) || $_SESSION['perfil_usuario'] != 1){
    header("Location: login.php?status=nao_autorizado");
    exit();
}

$nomeEquip = $_POST['nomeEquip'] ?? '';
$tipoMaisEquipamento = $_POST['equipamento'];
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
    }
} else {

if (!empty($nomeEquip)) {
    $nomeEquipamento =  $nomeEquipamento . " " . $nomeEquip;
}

    $sql = "INSERT INTO equipamentos(nome_equipamento,tipo_equipamento,quantidade_equipamento) VALUE 
(\"$nomeEquipamento\",\"$tipoEquipamento\",\"$quantidadeEquipamento\")";
    $query = mysqli_query($conexao, $sql);
    if (!$query) {
        $i = 0;
    } else {
        $i = 1;
    }
}
header("Location: addEquipamento.php?status=$i");
exit();
?>