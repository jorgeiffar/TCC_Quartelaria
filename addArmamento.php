<?php
include("conecta.php");
session_start();
if (!isset($_SESSION['id_usuario']) || $_SESSION['perfil_usuario'] != 1) {
    header("Location: login.php?status=nao_autorizado");
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adicionar Armamento - Quartelaria</title>
    <link rel="stylesheet" href="style.css?v=2">
</head>

<body>

<header>
  <nav>
          <div class="logo"><a href="homeQuarteleiro.php"><img src="./img/home.png" alt="Home" style="width: 28px; vertical-align: middle-top;"><span> COMMANDER</span></a></div>

    <ul>
      <li><a href="equipamentos.php" class="ativo">Equipamentos / Armamentos</a></li>
      <li><a href="operacoes.php">Operações</a></li>
      <li><a href="solicitacoesQuarteleiro.php">Solicitações</a></li>
      <li><a href="solicitacoesVtr.php">Solicitações Viatura</a></li>
      <li><a href="solicitarSolicitante.php">Solicitação Direta</a></li>
      <li><a href="listarUsuarios.php">Usuários</a></li>
      <li><a href="cadastrarQuarteleiro.php">Cadastrar Quarteleiro</a></li>
      <li><a href="editarPerfil.php">Perfil</a></li>
      <li><a href="logout.php"><img src="./img/logout.png" alt="Logout" style="width: 30px; height: 30px; vertical-align: middle;"></a></li>
    </ul>
  </nav>
</header>

<main class="container">
    <?php
    if (isset($_GET['status'])) {
        $status = $_GET['status'];
        echo "<div id='mensagem'>";
        if ($status == 0) {
            echo "<div class='alert error'>Falha ao adicionar armamento no sistema.</div>";
        } elseif ($status == 1) {
            echo "<div class='alert success'>Armamento adicionado com sucesso!</div>";
        } else {
            echo "<div class='alert info'>Erro não identificado.</div>";
        }
        echo "</div>";
    }
    ?>
  <section>
    <h1>Adicionar Armamento</h1>
    <div class="card">
      <form action="inserirArmamento.php" method="post" class="formulario">
        <label for="nomeArma">Nome do Armamento:</label>
        <input type="text" name="nomeArma" id="nomeArma" required>

        <label for="tipoArma">Tipo:</label>
        <select name="tipoArma" id="tipoArma" required>
            <option value="">Selecione</option>
            <option value="Fuzil">Fuzil</option>
            <option value="Pistola">Pistola</option>
            <option value="Espingarda">Espingarda</option>
            <option value="Lancador">Lançador</option>
            <option value="Spark">Spark</option>
            <option value="Granada">Granada</option>
        </select>

        <label for="calibreArma">Calibre:</label>
        <select name="calibreArma" id="calibreArma" required>
            <option value="">Selecione</option>
            <option value="7,62x51mm">7,62x51mm</option>
            <option value="5,56x45mm">5,56x45mm</option>
            <option value="9mm">9mm</option>
            <option value="12GA">12GA</option>
            <option value="Spark">Spark</option>
        </select>

        <label for="codigoArma">Número de Série:</label>
        <input type="text" name="codigoArma" id="codigoArma" required>

        <button type="submit" class="btn">Adicionar Armamento</button>
      </form>
    </div>

    <div class="voltar">
      <a href="equipamentos.php" class="btn secundario">← Voltar</a>
    </div>

  
  </section>
</main>

<footer>
&copy; <?php echo date("Y"); ?> COMMANDER - Sistema de Gerenciamento de Quartelaria
</footer>

<script>
  setTimeout(() => {
      const msg = document.getElementById('mensagem');
      if (msg) msg.style.display = 'none';
      const url = new URL(window.location);
      url.searchParams.delete('status');
      window.history.replaceState({}, document.title, url);
  }, 3000);
</script>

</body>
</html>
