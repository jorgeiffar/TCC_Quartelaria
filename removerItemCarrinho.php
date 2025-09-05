<?php
session_start();
if(!isset($_SESSION['id_usuario'])){
    header("Location: login.php?status=nao_autorizado");
    exit();
}

if (isset($_GET['tipo']) && isset($_GET['id_item'])) {
    $tipo = $_GET['tipo'];
    $id = $_GET['id_item'];

    if ($tipo === 'armamento' && isset($_SESSION['carrinho_armamentos'])) {
        $_SESSION['carrinho_armamentos'] = array_diff($_SESSION['carrinho_armamentos'], [$id]);
    }

    if ($tipo === 'equipamento' && isset($_SESSION['carrinho_equipamentos'])) {
        $_SESSION['carrinho_equipamentos'] = array_diff($_SESSION['carrinho_equipamentos'], [$id]);
    }
}

// Redireciona de volta para o carrinho
header("Location: verCarrinho.php");
exit;
