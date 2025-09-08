<?php
session_start();
if(!isset($_SESSION['id_usuario'])){
    header("Location: login.php?status=nao_autorizado");
    exit();
}
include("conecta.php");

// Verifica se o carrinho está vazio
if (empty($_SESSION['carrinho_armamentos']) && empty($_SESSION['carrinho_equipamentos'])) {
    die("Carrinho vazio. Nada para enviar.");
}


$operacao = $_SESSION['operacao'] ?? '';
$data_devolucao = $_SESSION['data_devolucao_item'] ?? '';
$id_usuario = $_SESSION['id_usuario']; 
$armamentos = $_SESSION['carrinho_armamentos'] ?? [];
$equipamentos = $_SESSION['carrinho_equipamentos'] ?? [];
$idSolicitacao  = time();


$data_solicitacao = date("Y-m-d");



if (empty($operacao) || empty($data_devolucao)) {
    die("Erro: motivo e data de devolução são obrigatórios.");
}


// Insere cada armamento como uma linha separada
foreach ($_SESSION['carrinho_armamentos'] as $idArmamento) {
    $sql = "INSERT INTO solicitacao_itens (
                id_solicitacao,id_usuario, id_item, tipo_item, quantidade, motivo_solicitacao, data_solicitacao, data_devolucao_item, status_solicitacao
            ) VALUES (
                $idSolicitacao, $id_usuario, $idArmamento, 'armamento', 1, '$operacao', '$data_solicitacao', '$data_devolucao', 'Pendente'
            )";
    
    $resultado = mysqli_query($conexao, $sql);
    if (!$resultado) {
    die("Erro na query: " . mysqli_error($conexao));}
}

// Insere cada equipamento como uma linha separada
foreach ($_SESSION['carrinho_equipamentos'] as $equipamento) {
    $idEquipamento = $equipamento['id'];
    $quantidade = $equipamento['quantidade'];
    $sql = "INSERT INTO solicitacao_itens (
                id_solicitacao,id_usuario, id_item, tipo_item, quantidade, motivo_solicitacao, data_solicitacao, data_devolucao_item, status_solicitacao
            ) VALUES (
                $idSolicitacao,$id_usuario, $idEquipamento, 'equipamento', $quantidade, '$operacao', '$data_solicitacao', '$data_devolucao', 'Pendente'
            )";
    $resultado = mysqli_query($conexao, $sql);
    if (!$resultado) {
    die("Erro na query: " . mysqli_error($conexao));
}

}
// Limpa a sessão
unset($_SESSION['carrinho_armamentos'], $_SESSION['carrinho_equipamentos'], $_SESSION['operacao'], $_SESSION['data_devolucao_item']);

// Redireciona
header("Location: verCarrinho.php");
exit;

