<?php
include ("conecta.php");
$nomeArma = $_POST['nomeArma'];
$tipoArma = $_POST['tipoArma'];
$calibreArma = $_POST['calibreArma'];
$codigoArma = $_POST['codigoArma'];

$sql = "INSERT INTO armamentos(nome_armamento,tipo_armamento,calibre_armamento,codigo_armamento) VALUE 
(\"$nomeArma\",\"$tipoArma\",\"$calibreArma\",\"$codigoArma\")";
$query = mysqli_query($conexao,$sql);
if(!$query){
    $i=0;
}else{
    $i=1;
}
header("Location: addArmamento.php?status=$i");
exit();
?>