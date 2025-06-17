<?php
session_start();
include("conecta.php");

// Verifica se o carrinho está vazio
if (empty($_SESSION['carrinho_armamentos']) && empty($_SESSION['carrinho_equipamentos'])) {
    die("Carrinho vazio. Nada para enviar.");
}

// Dados da sessão
$operacao = $_SESSION['operacao'] ?? '';
$data_devolucao = $_SESSION['data_devolucao_item'] ?? '';
$id_usuario = $_SESSION['id_usuario'] ?? 1; 
$armamentos = $_SESSION['carrinho_armamentos'] ?? [];
$equipamentos = $_SESSION['carrinho_equipamentos'] ?? [];

// Data atual
$data_solicitacao = date("Y-m-d");

// Insere cada armamento como uma linha separada
foreach ($_SESSION['carrinho_armamentos'] as $idArmamento) {
    $sql = "INSERT INTO solicitacao_itens (
                id_usuario, id_item, tipo_item, motivo_solicitacao, data_solicitacao, data_devolucao_item, status_solicitacao
            ) VALUES (
                $id_usuario, $idArmamento, 'armamento', '$operacao', '$data_solicitacao', '$data_devolucao', 'Pendente'
            )";
    $resultado = mysqli_query($conexao, $sql);
    if (!$resultado) {
    die("Erro na query: " . mysqli_error($conexao));
}

}

// Insere cada equipamento como uma linha separada
foreach ($_SESSION['carrinho_equipamentos'] as $idEquipamento) {
    $sql = "INSERT INTO solicitacao_itens (
                id_usuario, id_item, tipo_item, motivo_solicitacao, data_solicitacao, data_devolucao_item, status_solicitacao
            ) VALUES (
                $id_usuario, $idEquipamento, 'equipamento', '$operacao', '$data_solicitacao', '$data_devolucao', 'Pendente'
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

