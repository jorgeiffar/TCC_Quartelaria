<?php
include("conecta.php");

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastre-se - Quartelaria</title>
</head>
<body>
    <form action="inserirUsuario.php" method="post">
        Nome: <input type="text" name="nome" required><br>
        Identidade Funcional: <input type="number" name="idFuncional" required><br>
        E-mail institucional: <input type="email" name="email" required><br>
        Perfil: <label><input type="radio" name="perfil" value="1" required>Quarteleiro</label> <label><input type="radio" name="perfil" value="2">Solicitante</label><br>
        Senha: <input type="password" name="senha" required><br>
        <input type="submit" value="Cadastrar">
<br>
         Já é cadastrado no sistema? <a href="login.php">Realizar login!</a>
    </form>
</body>
</html>