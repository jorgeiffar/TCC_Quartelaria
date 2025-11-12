<?php
include("conecta.php");
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cadastre-se - Quartelaria</title>
  <link rel="stylesheet" href="style.css">
  <script>
    function validarSenha() {
      const senha = document.getElementById("senha").value;
      const confirmar = document.getElementById("confirmar_senha").value;

      if (senha !== confirmar) {
        alert("As senhas não coincidem!");
        return false;
      }
      return true;
    }
  </script>
</head>
<body>
  <div class="bg-fallback"></div>

  <nav>
    <div class="logo">Commander</div>
    <ul>
      <li><a href="login.php">Login</a></li>
    </ul>
  </nav>

  <div class="container">
    <div class="form-area">
      <h2 style="margin-bottom: 20px; text-align:center;">Cadastro de Usuário</h2>

      <form action="inserirUsuario.php" method="post" onsubmit="return validarSenha()">
        <div class="form-grid">
          <div>
            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="nome" required>
          </div>

          <div>
            <label for="idFuncional">Identidade Funcional:</label>
            <input type="number" id="idFuncional" name="idFuncional" required>
          </div>

          <div>
            <label for="email">E-mail institucional:</label>
            <input type="email" id="email" name="email" required>
          </div>

          <input type="hidden" name="perfil" value="2">

          <div>
            <label for="senha">Senha:</label>
            <input type="password" id="senha" name="senha" required>
          </div>

          <div>
            <label for="confirmar_senha">Confirmar senha:</label>
            <input type="password" id="confirmar_senha" name="confSenha" required>
          </div>
        </div>

        <div class="form-buttons">
          <input type="submit" value="Cadastrar">
        </div>

        <p style="text-align:center; margin-top:15px;">
          Já é cadastrado no sistema? 
          <a href="login.php" class="btn">Realizar login!</a>
        </p>
      </form>
    </div>
  </div>

  <footer>
    &copy; <?php echo date("Y"); ?> COMMANDER - Sistema de Gerenciamento de Quartelaria.
  </footer>
</body>
</html>
