<?php
session_start();

if (isset($_POST['tipo']) && isset($_POST['id_item'])) {
    $tipo = $_POST['tipo'];
    $id = $_POST['id_item'];

    if (!in_array($tipo, ['armamento', 'equipamento'])) {
        die("Tipo inválido.");
    }

    $key = "carrinho_" . $tipo . "s"; //carrinho_armamentos ou carrinho_equipamentos

    if (!isset($_SESSION[$key])) {
        $_SESSION[$key] = [];
    }

    if (!in_array($id, $_SESSION[$key])) {
        $_SESSION[$key][] = $id;
    }
}

header("Location: solicitarSolicitante.php");
exit;
