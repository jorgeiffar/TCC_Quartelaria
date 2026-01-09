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
        foreach ($_SESSION['carrinho_equipamentos'] as $key => $equip) {
            if ($equip['id'] == $id) {
                unset($_SESSION['carrinho_equipamentos'][$key]);
                break;
            }
        }
        $_SESSION['carrinho_equipamentos'] = array_values($_SESSION['carrinho_equipamentos']);
    }
}

header("Location: verCarrinho.php");
exit;
