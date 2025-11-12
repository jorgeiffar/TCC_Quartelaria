<?php
include("conecta.php");
$status = $_GET['status'] ?? null;
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login - Quartelaria</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="bg-fallback"></div>

  <nav>
    <div class="logo">Commander</div>
    <ul>
      <li><a href="cadastrar.php">Cadastro</a></li>
    </ul>
  </nav>

  <div class="container">
    <div class="form-area">
      <h2 style="margin-bottom: 20px; text-align:center;">Acesso ao Sistema</h2>

      <?php
      if ($status == "nao_autorizado") {
          echo "<div class='alert info'><strong>Realize o login para acessar o sistema.</strong></div>";
      } elseif ($status == 1) {
          echo "<div class='alert success'>Usuário cadastrado com sucesso!</div>";
      } elseif ($status == "logout") {
          echo "<div class='alert info'><strong>Sessão finalizada.</strong> Faça login novamente para acessar o sistema.</div>";
      }
      ?>

      <form action="login.php" method="post">
        <div class="form-grid">
          <div>
            <label for="idFuncional">Identidade Funcional:</label>
            <input type="number" id="idFuncional" name="idFuncional" required>
          </div>

          <div>
            <label for="senha">Senha:</label>
            <input type="password" id="senha" name="senha" required>
          </div>
        </div>

        <div class="form-buttons">
          <input type="submit" value="Entrar">
        </div>

        <p style="text-align:center; margin-top:15px;">
          Ainda não é cadastrado? 
          <a href="cadastrar.php" class="btn">Cadastre-se!</a>
        </p>
      </form>
    </div>
  </div>

  <footer>
    &copy; <?php echo date("Y"); ?> Quartelaria - Todos os direitos reservados.
  </footer>

  <script>
    setTimeout(function () {
      var msg = document.getElementById('mensagem') || document.querySelector('.alert');
      if (msg) msg.style.display = 'none';

      const url = new URL(window.location);
      url.searchParams.delete('status');
      window.history.replaceState({}, document.title, url);
    }, 3000);
  </script>
</body>
</html>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  session_start();

  $idFuncional = $_POST['idFuncional'];
  $senha = $_POST['senha'];

  $sqlSelect = "SELECT * FROM usuarios WHERE identidade_funcional_usuario = '$idFuncional'";
  $querySelect = mysqli_query($conexao, $sqlSelect);

  if (mysqli_num_rows($querySelect) == 0) {
      echo "<div class='container'><div class='alert error'>Usuário ainda <strong>não</strong> cadastrado!</div></div>";
  } else {
      $dadosUser = mysqli_fetch_assoc($querySelect);
      $senhaCript = $dadosUser['senha_usuario'];

      if (password_verify($senha, $senhaCript)) {
          $_SESSION['id_usuario'] = $dadosUser['id_usuario'];
          $_SESSION['nome_usuario'] = $dadosUser['nome_usuario'];
          $_SESSION['perfil_usuario'] = $dadosUser['perfil_usuario'];

          if ($dadosUser['perfil_usuario'] == 1) {
              header("Location: homeQuarteleiro.php");
              exit;
          } elseif ($dadosUser['perfil_usuario'] == 2) {
              header("Location: homeSolicitante.php");
              exit;
          }
      } else {
          echo "<div class='container'><div class='alert error'>Senha incorreta!</div></div>";
      }
  }
}
?>
