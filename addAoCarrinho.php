<?php
session_start();
if(!isset($_SESSION['id_usuario'])){
    header("Location: login.php?status=nao_autorizado");
    exit();
}

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
    if ($tipo === 'equipamento') {
        $quantidade = $_POST['quantidade_municao'];
    
    $jaExiste = false;
    foreach($_SESSION[$key] as $item){
        if($item['id'] == $id){
        $jaExiste = true;
        break;
        }
    }
    if(!$jaExiste){
        $_SESSION[$key][] =[
            'id' => $id,
            'quantidade' => $quantidade];
        }
    }
    else{
        if (!in_array($id, $_SESSION[$key])){
            $_SESSION[$key][] = $id;
        }
    }
}

header("Location: solicitarSolicitante.php");
exit;
