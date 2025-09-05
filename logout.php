<?php
session_start();

// remove todas as variáveis de sessão
$_SESSION = array();

// destrói a sessão no servidor
session_destroy();

// redireciona para o login
header("Location: login.php?status=logout");
exit();
?>
