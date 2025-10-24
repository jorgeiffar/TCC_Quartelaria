<?php
session_start();
if(!isset($_SESSION['id_usuario'])){
    header("Location: login.php?status=nao_autorizado");
    exit();
}

// Se for quarteleiro e ele selecionou um solicitante, guarda o ID
if ($_SESSION['perfil_usuario'] == 1 && isset($_POST['usuario'])) {
   $_SESSION['usuario_selecionado'] = (int) $_POST['usuario'];
}

// === NOVA LÓGICA: marcar se deve auto-aprovar ===
if ($_SESSION['perfil_usuario'] == 1) {
    $id_logado = $_SESSION['id_usuario'];
    $id_destinatario = $_SESSION['usuario_selecionado'] ?? $id_logado;

    // Se o quarteleiro fez a solicitação em nome de OUTRO usuário,
    // então marcamos para ser automaticamente aprovada depois.
    if ($id_logado != $id_destinatario) {
        $_SESSION['auto_aprovar'] = true;
    } else {
        $_SESSION['auto_aprovar'] = false;
    }
} else {
    $_SESSION['auto_aprovar'] = false;
}
// === FIM DA NOVA LÓGICA ===

if (isset($_POST['tipo']) && isset($_POST['id_item'])) {
    $tipo = $_POST['tipo'];
    $id = $_POST['id_item'];

    if (!in_array($tipo, ['armamento', 'equipamento'])) {
        die("Tipo inválido.");
    }

    $key = "carrinho_" . $tipo . "s"; // carrinho_armamentos ou carrinho_equipamentos

    if (!isset($_SESSION[$key])) {
        $_SESSION[$key] = [];
    }

    if ($tipo === 'equipamento') {
        $quantidade = $_POST['quantidade_municao'];

        $jaExiste = false;
        foreach ($_SESSION[$key] as $item) {
            if ($item['id'] == $id) {
                $jaExiste = true;
                break;
            }
        }

        if (!$jaExiste) {
            $_SESSION[$key][] = [
                'id' => $id,
                'quantidade' => $quantidade
            ];
        }
    } else { // armamento
        if (!in_array($id, $_SESSION[$key])) {
            $_SESSION[$key][] = $id;
        }
    }
}

header("Location: solicitarSolicitante.php");
exit;
