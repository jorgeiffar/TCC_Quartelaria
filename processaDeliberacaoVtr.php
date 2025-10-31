<?php
include("conecta.php");
session_start();

if (!isset($_SESSION['id_usuario']) || $_SESSION['perfil_usuario'] != 1) {
    header("Location: login.php?status=nao_autorizado");
    exit();
}



$statusNovo = $_GET['status'];
if($statusNovo == 1){
    $statusNovo = "Ativo";
}else{
    $statusNovo = "Negado";

}
$idSolicitacao = $_GET['id'];

$query = "UPDATE solicitacao_viatura SET status_solicitacao_viatura = '{$statusNovo}' WHERE id_solicitacao_viatura = {$idSolicitacao}";
$result = mysqli_query($conexao,$query);
header("Location: homeQuarteleiro.php");

if(isset($_GET['fim']) and $_GET['fim']==1){
    $query = "UPDATE solicitacao_viatura SET status_solicitacao_viatura = 'Devolvido' WHERE id_solicitacao_viatura = {$idSolicitacao}";
$result = mysqli_query($conexao,$query);
header("Location: homeQuarteleiro.php");
}

?>