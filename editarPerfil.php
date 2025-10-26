<?php
session_start();
include("conecta.php");


if (!isset($_SESSION['id_usuario'])) {
    header("Location: login.php?erro=nao_autorizado");
    exit();
}

$id = $_SESSION['id_usuario'];
$query = "SELECT * FROM usuarios WHERE id_usuario = $id";
$resultado = mysqli_query($conexao, $query);
$usuario = mysqli_fetch_assoc($resultado);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar Perfil - Quartelaria</title>
</head>
<body>
    <h2>Editar Perfil</h2>
    <form action="registrarEdicaoPerfil.php" method="post">
        Nome: <input type="text" name="nome" value="<?php echo $usuario['nome_usuario']; ?>" required><br>
        Identidade Funcional: <input type="number" name="idFuncional" value="<?php echo $usuario['identidade_funcional_usuario']; ?>" required><br>
        E-mail: <input type="email" name="email" value="<?php echo $usuario['email_usuario']; ?>" required><br>
        <input type="submit" value="Salvar alterações">
    </form>

    <br>
    <a href="homeQuarteleiro.php">Voltar</a>
</body>
</html>
