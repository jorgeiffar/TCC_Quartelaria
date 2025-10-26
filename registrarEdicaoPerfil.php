<?php
session_start();
include("conecta.php");

if (!isset($_SESSION['id_usuario'])) {
    header("Location: login.php?erro=nao_autorizado");
    exit();
}

$id = $_SESSION['id_usuario'];
$nome = $_POST['nome'];
$idFuncional = $_POST['idFuncional'];
$email = $_POST['email'];
$query = "UPDATE usuarios SET nome_usuario='$nome', identidade_funcional_usuario='$idFuncional', email_usuario='$email' WHERE id_usuario=$id";

if (mysqli_query($conexao, $query)) {
    echo "Dados atualizados com sucesso!<br>";
    echo "<a href='homeQuarteleiro.php'>Voltar</a>";
} else {
    echo "Erro ao atualizar: " . mysqli_error($conexao);
}
?>
