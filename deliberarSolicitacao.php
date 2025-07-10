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
    header("Location: solicitacoesQuarteleiro.php?status=1");
} elseif ($statusFinal == 'Negado') {
    header("Location: solicitacoesQuarteleiro.php?status=2");
}
?>