<?php
include ("conecta.php");
$tipoMaisEquipamento = $_POST['equipamento'];
list($tipoEquipamento,$nomeEquipamento) = explode("|",$tipoMaisEquipamento);
$quantidadeEquipamento = $_POST['quantidadeEquip'];
$sql = "INSERT INTO equipamentos(nome_equipamento,tipo_equipamento,quantidade_equipamento) VALUE 
(\"$nomeEquipamento\",\"$tipoEquipamento\",\"$quantidadeEquipamento\")";
$query = mysqli_query($conexao,$sql);
if(!$query){
    $i=0;
}else{
    $i=1;
}
header("Location: addEquipamento.php?status=$i");
exit();
?>