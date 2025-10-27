<?php
include("conecta.php");
session_start();
if(!isset($_SESSION['id_usuario']) || $_SESSION['perfil_usuario'] != 1){
    header("Location: login.php?status=nao_autorizado");
    exit();
}
$status = $_GET['status'];
$id = $_GET['id'];

if(isset($_GET['destinatario'])){
$id = $_GET['idDest'];
$status = $_GET['statusDest'];


}
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
    $queryItens = "SELECT id_item, quantidade FROM solicitacao_itens WHERE id_solicitacao = $id AND tipo_item = 'equipamento'";
    $resultItens = mysqli_query($conexao, $queryItens);
    if(!$resultItens){
        die("Erro ao buscar itens da solicitação: " . mysqli_error($conexao));
    }
    while ($item = mysqli_fetch_assoc($resultItens)){
        $idEquipamento = $item['id_item'];
        $quantidade = $item['quantidade'];
        $queryUpdateQuant = "UPDATE equipamentos SET quantidade_disponivel_equipamento = quantidade_disponivel_equipamento + $quantidade WHERE id_equipamento = $idEquipamento";
        $resultUpdateQuant = mysqli_query($conexao, $queryUpdateQuant);

        if(!$resultUpdateQuant){
            echo "Erro ao atualizar quantidade do equipamento ID $idEquipamento: ". mysqli_error($conexao);
        }
    }
    $sqlUpdateStatus = "
        UPDATE armamentos a
        JOIN solicitacao_itens si ON si.id_item = a.id_armamento
        SET a.status_armamento = 1
        WHERE si.status_solicitacao = 'Aceito'
        AND si.tipo_item = 'armamento'
        AND si.id_solicitacao = $id
    ";
    $resultadoUpdateStatus = mysqli_query($conexao, $sqlUpdateStatus);
    if (!$resultadoUpdateStatus) {
        die("Erro ao atualizar status dos armamentos: " . mysqli_error($conexao));
    }
if(isset($_GET['destinatario'])){
    header("Location: verCarrinho.php");
}else{

    header("Location: solicitacoesQuarteleiro.php?status=1");}


} elseif ($statusFinal == 'Negado') {
    header("Location: solicitacoesQuarteleiro.php?status=2");
}
?>
