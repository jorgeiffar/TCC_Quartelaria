<?php
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
    <title>Adicionar Equipamento - Quartelaria</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
<div class="icone-lateral">
        <img src="./img/logobatalhao.png" alt="Ícone Batalhão de Choque BM">
    </div>
<header>
  <nav>
    <div class="logo" ><a href="homeQuarteleiro.php">Commander</a></div>
    <ul>
      <li><a href="equipamentos.php" class="ativo">Equipamentos / Armamentos</a></li>
      <li><a href="operacoes.php">Operações</a></li>
      <li><a href="solicitacoesQuarteleiro.php">Solicitações</a></li>
      <li><a href="solicitacoesVtr.php">Solicitações Viatura</a></li>
      <li><a href="solicitarSolicitante.php">Solicitação Direta</a></li>
      <li><a href="listarUsuarios.php">Usuários</a></li>
      <li><a href="cadastrarQuarteleiro.php">Cadastrar Quarteleiro</a></li>
      <li><a href="editarPerfil.php">Perfil</a></li>
      <li><a href="logout.php">Logout</a></li>
    </ul>
  </nav>
</header>

<main class="container">
  <section>
    <h1>Adicionar Equipamento</h1>
    <div class="card">
      <form action="inserirEquipamento.php" method="post" class="formulario">
        <label for="equipamento">Equipamento:</label>
        <select name="equipamento" id="equipamento" required>
            <option value="">Selecione</option>
            <optgroup label="Operação de Controle de Distúrbios">
                <option value="Disturbios|Escudo">Escudo</option>
                <option value="Disturbios|Capacete">Capacete</option>
                <option value="Disturbios|Bastao">Bastão</option>
                <option value="Disturbios|Granada">Granada</option>
            </optgroup>
            <optgroup label="Outros">
                <option value="Outros|Carregador">Carregador</option>
                <option value="Outros|Bandoleira">Bandoleira</option>
            </optgroup>
        </select>

        <label for="nomeEquip">Nome específico (opcional):</label>
        <input type="text" name="nomeEquip" id="nomeEquip">

        <label for="quantidadeEquip">Quantidade:</label>
        <input type="number" name="quantidadeEquip" id="quantidadeEquip" required>

        <button type="submit" class="btn">Adicionar Equipamento</button>
      </form>
    </div>
  </section>

  <section>
    <h2>Adicionar Munições</h2>
    <div class="card">
      <form action="inserirEquipamento.php" method="post" class="formulario">
        <label for="calibre">Calibre:</label>
        <select name="equipamento" id="calibre" required>
            <option value="">Selecione</option>
            <option value="Municao|7,62x51mm">7,62x51mm</option>
            <option value="Municao|5,56x45mm">5,56x45mm</option>
            <option value="Municao|9mm">9mm</option>
            <option value="Municao|12GA">12GA</option>
            <option value="Municao|Spark">Spark</option>
        </select>

        <label for="quantidadeMun">Quantidade:</label>
        <input type="number" name="quantidadeEquip" id="quantidadeMun" required>

        <button type="submit" class="btn">Adicionar Munições</button>
      </form>
    </div>
  </section>

  <div class="voltar">
    <a href="equipamentos.php" class="btn secundario">← Voltar</a>
  </div>

  <?php
  if (isset($_GET['status'])) {
      $status = $_GET['status'];
      echo "<div id='mensagem'>";
      if ($status == 0) {
          echo "<p style='color: #ff5c5c;'>Falha ao adicionar equipamento no sistema.</p>";
      } elseif ($status == 1) {
          echo "<p style='color: #00ff99;'>Equipamento adicionado com sucesso!</p>";
      } else {
          echo "<p style='color: orange;'>Erro não identificado.</p>";
      }
      echo "</div>";
  }
  ?>
</main>

<footer>
  &copy; 2025 COMMANDER - Sistema de Gerenciamento de Quartelaria
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
