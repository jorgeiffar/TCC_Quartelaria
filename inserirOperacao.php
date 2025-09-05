<?php
include ("conecta.php");
session_start();
if(!isset($_SESSION['id_usuario']) || $_SESSION['perfil_usuario'] != 1){
    header("Location: login.php?status=nao_autorizado");
    exit();
}
$nomeOperacao = $_POST['nome'];
$tipoOperacao = $_POST['tipo'];
$localOperacao = $_POST['local'];
$dataOperacao = $_POST['data_hora'];
$descricaoOperacao = $_POST['descricao'];
$statusOperacao = $_POST['status'];

$sql = "INSERT INTO operacoes(nome_operacao,tipo_operacao,local_operacao,descricao_operacao,data_inicio_operacao,status_operacao) VALUE 
(\"$nomeOperacao\",\"$tipoOperacao\",\"$localOperacao\",\"$descricaoOperacao\",\"$dataOperacao\",\"$statusOperacao\")";
$query = mysqli_query($conexao,$sql);
if(!$query){
    $i=0;
}else{
    $i=1;
}
header("Location: addOperacao.php?status=$i");
exit();
?>