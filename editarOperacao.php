<?php
include("conecta.php");
session_start();
if(!isset($_SESSION['id_usuario']) || $_SESSION['perfil_usuario'] !=1){
    header("Location: login.php?status=nao_autorizado");
    exit();
}
if(isset($_GET['id'])){
    $id = $_GET['id'];
    $query = "SELECT * FROM operacoes WHERE id_operacao = '$id'";
    $result = mysqli_query($conexao,$query);
    $dados = mysqli_fetch_assoc($result);
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Editar Operação - Quartelaria</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>

<header>
  <nav>
          <div class="logo"><a href="homeQuarteleiro.php"><img src="./img/home.png" alt="Home" style="width: 28px; vertical-align: middle-top;"><span> COMMANDER</span></a></div>

    <ul>
      <li><a href="equipamentos.php">Equipamentos / Armamentos</a></li>
      <li><a href="operacoes.php">Operações</a></li>
      <li><a href="solicitacoesQuarteleiro.php">Solicitações</a></li>
      <li><a href="solicitacoesVtr.php">Solicitações Viatura</a></li>
      <li><a href="solicitarSolicitante.php">Solicitação Direta</a></li>
      <li><a href="listarUsuarios.php">Visualizar Usuários</a></li>
      <li><a href="cadastrarQuarteleiro.php">Cadastrar Quarteleiro</a></li>
      <li><a href="editarPerfil.php">Editar Perfil</a></li>
      <li><a href="logout.php"><img src="./img/logout.png" alt="Logout" style="width: 30px; height: 30px; vertical-align: middle;"></a></li>
    </ul>
  </nav>
</header>

<main class="container">
  <section>
    <h1>Editar Operação</h1>
    <hr>

    <div class="card">
      <div class="form-area">

        <form action="" method="post">
          <div class="form-grid">
            <div>
              <label>Nome da Operação:</label>
              <input type="text" name="nome" value="<?=$dados['nome_operacao']?>">
            </div>

            <div>
              <label>Tipo de Operação:</label>
              <select name="tipo" required>
                <option value="">Selecione</option>
                <option value="Patrulhamento" <?= ($dados['tipo_operacao'] == 'Patrulhamento') ? 'selected' : '' ?>>Patrulhamento</option>
                <option value="Cerco" <?= ($dados['tipo_operacao'] == 'Cerco') ? 'selected' : '' ?>>Cerco</option>
                <option value="Blitz" <?= ($dados['tipo_operacao'] == 'Blitz') ? 'selected' : '' ?>>Blitz</option>
                <option value="Reintegração de Posse" <?= ($dados['tipo_operacao'] == 'Reintegração de Posse') ? 'selected' : '' ?>>Reintegração de Posse</option>
                <option value="Apoio a Outro Órgão" <?= ($dados['tipo_operacao'] == 'Apoio a Outro Órgão') ? 'selected' : '' ?>>Apoio a Outro Órgão</option>
                <option value="Outros" <?= ($dados['tipo_operacao'] == 'Outros') ? 'selected' : '' ?>>Outros</option>
              </select>
            </div>

            <div>
              <label>Local da Operação:</label>
              <input type="text" name="local" value="<?=$dados['local_operacao']?>">
            </div>

            <div>
              <label>Data e Hora:</label>
              <input type="datetime-local" name="data_hora" value="<?=$dados['data_inicio_operacao']?>">
            </div>

            <div>
              <label>Status da Operação:</label>
              <select name="status" required>
                <option value="Planejada" <?= ($dados['status_operacao'] == 'Planejada') ? 'selected' : '' ?>>Planejada</option>
                <option value="Em Andamento" <?= ($dados['status_operacao'] == 'Em Andamento') ? 'selected' : '' ?>>Em Andamento</option>
                <option value="Concluída" <?= ($dados['status_operacao'] == 'Concluída') ? 'selected' : '' ?>>Concluída</option>
                <option value="Cancelada" <?= ($dados['status_operacao'] == 'Cancelada') ? 'selected' : '' ?>>Cancelada</option>
              </select>
            </div>

            <div class="full">
              <label>Descrição Detalhada:</label>
              <textarea name="descricao" rows="6"><?=$dados['descricao_operacao']?></textarea>
            </div>

            <div class="form-buttons">
              <input type="submit" value="Registrar Alterações" class="btn primario">
            </div>
          </div>
        </form>

      </div>
    </div>
  </section>
</main>

<footer>
&copy; <?php echo date("Y"); ?> COMMANDER - Sistema de Gerenciamento de Quartelaria</footer>

</body>
</html>

<?php
if(isset($_POST['nome'])){
    $nome = $_POST['nome'];
    $tipo = $_POST['tipo'];
    $local = $_POST['local'];
    $descricao = $_POST['descricao'];
    $dataInicio = $_POST['data_hora'];
    $status = $_POST['status'];

    $query = "UPDATE `operacoes` SET 
        `nome_operacao`='$nome',
        `tipo_operacao`='$tipo',
        `local_operacao`='$local',
        `descricao_operacao`='$descricao',
        `data_inicio_operacao`='$dataInicio',
        `status_operacao`='$status' 
        WHERE id_operacao = '$id'";
    
    $result = mysqli_query($conexao, $query);
    header("Location: operacoes.php");
    exit();
}
?>
