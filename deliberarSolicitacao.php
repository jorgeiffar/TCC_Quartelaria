<?php
include("conecta.php");

$status = $_GET['status'];
$id = $_GET['id'];
if ($status == 1) {
    $statusFinal = 'Aceito';
} elseif ($status == 2) {
    $statusFinal = 'Negado';
}
$query = "UPDATE solicitacao_itens SET status_solicitacao='$statusFinal' WHERE id_solicitacao = $id";
$result = mysqli_query($conexao, $query);
if (!$result) {
    die("Erro na query: " . mysqli_error($conexao));
}
if ($statusFinal == 'Aceito') {
    header("Location: solicitacoesQuarteleiro.php?status=1");
} elseif ($statusFinal == 'Negado') {
    header("Location: solicitacoesQuarteleiro.php?status=2");
}
?>