<?php
session_start();
if (!isset($_SESSION['id_usuario'])) {
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
$data_solicitacao = date("Y-m-d");

// Se for quartelário (perfil 1), usa o usuário selecionado no select
if ($_SESSION['perfil_usuario'] == 1 && !empty($_SESSION['usuario_selecionado'])) {
    $id_destinatario = $_SESSION['usuario_selecionado'];
} else {
    $id_destinatario = $_SESSION['id_usuario'];
}

// Determina o status da solicitação com base na regra
if (!empty($_SESSION['auto_aprovar']) && $_SESSION['auto_aprovar'] === true) {
    $status = 'Aceito'; // quarteleiro solicitando em nome de outro
} else {
    $status = 'Pendente'; // qualquer outro caso
}
$idSolicitacao = time();




if (empty($operacao) || empty($data_devolucao)) {
    die("Erro: motivo e data de devolução são obrigatórios.");
}

// Insere cada armamento como uma linha separada
foreach ($_SESSION['carrinho_armamentos'] as $idArmamento) {
    $sql = "INSERT INTO solicitacao_itens (
                id_solicitacao, id_usuario, id_item, tipo_item, quantidade, motivo_solicitacao, data_solicitacao, data_devolucao_item, status_solicitacao
            ) VALUES (
                $idSolicitacao, $id_destinatario, $idArmamento, 'armamento', 1, '$operacao', '$data_solicitacao', '$data_devolucao', '$status'
            )";
    
    $resultado = mysqli_query($conexao, $sql);
    if (!$resultado) {
        die("Erro na query de armamento: " . mysqli_error($conexao));
    }
}

// Insere cada equipamento como uma linha separada
foreach ($_SESSION['carrinho_equipamentos'] as $equipamento) {
    $idEquipamento = $equipamento['id'];
    $quantidade = $equipamento['quantidade'];
    $sql = "INSERT INTO solicitacao_itens (
                id_solicitacao, id_usuario, id_item, tipo_item, quantidade, motivo_solicitacao, data_solicitacao, data_devolucao_item, status_solicitacao
            ) VALUES (
                $idSolicitacao, $id_destinatario, $idEquipamento, 'equipamento', $quantidade, '$operacao', '$data_solicitacao', '$data_devolucao', '$status'
            )";
    
    $resultado = mysqli_query($conexao, $sql);
    if (!$resultado) {
        die("Erro na query de equipamento: " . mysqli_error($conexao));
    }
}

// Limpa a sessão (mantendo login e perfil)
unset($_SESSION['carrinho_armamentos'], $_SESSION['carrinho_equipamentos'], $_SESSION['operacao'], $_SESSION['data_devolucao_item'], $_SESSION['usuario_selecionado']);

// Redireciona
if ($_SESSION['perfil_usuario'] == 1) {
    header("Location: deliberarSolicitacao.php?statusDest=1&idDest=$idSolicitacao&destinatario=$id_destinatario");
}else{
header("Location: verCarrinho.php");
exit;}
