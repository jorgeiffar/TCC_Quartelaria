<?php
include("conecta.php");

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Quarteleiro - Quartelaria</title>
     <script>
        function validarSenha() {
            const senha = document.getElementById("senha").value;
            const confirmar = document.getElementById("confirmar_senha").value;

            if (senha !== confirmar) {
                alert("As senhas não coincidem!");
                return false; // impede o envio do formulário
            }
            return true;
        }
    </script>
</head>
<body>
    <form action="inserirUsuario.php" method="post" onsubmit="return validarSenha()">
        Nome: <input type="text" name="nome" required><br>
        Identidade Funcional: <input type="number" name="idFuncional" required><br>
        E-mail institucional: <input type="email" name="email" required><br>
        <input type="hidden" name="perfil" value="1">
         Senha: <input type="password" name="senha" id="senha" required><br>
        Confirmar senha: <input type="password" name="confSenha" id="confirmar_senha" required><br>
        <input type="submit" value="Cadastrar">
<br>
         Já é cadastrado no sistema? <a href="login.php">Realizar login!</a>
    </form>
</body>
</html>