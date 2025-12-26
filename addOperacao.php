<?php
session_start();
if(!isset($_SESSION['id_usuario']) || $_SESSION['perfil_usuario'] != 1){
    header("Location: login.php?status=nao_autorizado");
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Adicionar Operação Policial</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>

<header>
  <nav>
          <div class="logo"><a href="homeQuarteleiro.php"><img src="./img/home.png" alt="Home" style="width: 28px; vertical-align: middle-top;"><span> COMMANDER</span></a></div>

    <ul>
      <li><a href="equipamentos.php">Equipamentos / Armamentos</a></li>
      <li><a href="operacoes.php" class="ativo">Operações</a></li>
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
  <section>
    <h1>Adicionar Operação</h1>
    <hr>

    <div class="card">
      <div class="form-area">

        <form action="inserirOperacao.php" method="post">
          <div class="form-grid">
            <div>
              <label>Nome da Operação:</label>
              <input type="text" name="nome" required>
            </div>

            <div>
              <label>Tipo de Operação:</label>
              <select name="tipo" required>
                <option value="">Selecione</option>
                <option value="Patrulhamento">Patrulhamento</option>
                <option value="Cerco">Cerco</option>
                <option value="Blitz">Blitz</option>
                <option value="Reintegração de Posse">Reintegração de Posse</option>
                <option value="Apoio a Outro Órgão">Apoio a Outro Órgão</option>
                <option value="Outros">Outros</option>
              </select>
            </div>

            <div>
              <label>Local da Operação:</label>
              <input type="text" name="local" required>
            </div>

            <div>
              <label>Data e Hora:</label>
              <input type="datetime-local" name="data_hora" required>
            </div>

            <div>
              <label>Status da Operação:</label>
              <select name="status" required>
                <option value="Planejada">Planejada</option>
                <option value="Em Andamento">Em Andamento</option>
                <option value="Concluída">Concluída</option>
                <option value="Cancelada">Cancelada</option>
              </select>
            </div>

            <div>
              <label>Descrição Detalhada:</label>
              <textarea name="descricao" rows="6" required></textarea>
            </div>
          </div>

          <div class="form-buttons">
            <input type="submit" value="Registrar Operação">
          </div>
        </form>

        <?php
        if (isset($_GET['status'])) {
            $status = $_GET['status'];
            echo "<hr>";
            if ($status == 0) {
                echo "<div id='mensagem' style='color: red;'>Falha ao adicionar operação no sistema.</div>";
            } elseif ($status == 1) {
                echo "<div id='mensagem' style='color: green;'>Operação adicionada com sucesso.</div>";
            } else {
                echo "<div id='mensagem' style='color: orange;'>Erro não identificado.</div>";
            }
        }
        ?>
      </div>
    </div>
  </section>
</main>

<footer>
&copy; <?php echo date("Y"); ?> COMMANDER - Sistema de Gerenciamento de Quartelaria</footer>

<script>
  setTimeout(function () {
      var msg = document.getElementById('mensagem');
      if (msg) {
          msg.style.display = 'none';
      }
  }, 3000);
</script>

</body>
</html>
