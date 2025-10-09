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
$dados = mysqli_fetch_assoc($result);}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Operação - Quartelaria</title>
</head>
<body>
  <a href="operacoes.php">Voltar</a> | 
  <a href="homeQuarteleiro.php">Home</a>
  <form action="" method="post">
    Nome da Operação:
      <input type="text" name="nome" value="<?=$dados['nome_operacao']?>"><br>

      Tipo de Operação
      <select name="tipo" required>
        <option value="">Selecione</option>
        <option value="Patrulhamento" <?= ($dados['tipo_operacao'] == 'Patrulhamento') ? 'selected' : '' ?>>Patrulhamento</option>
        <option value="Cerco" <?= ($dados['tipo_operacao'] == 'Cerco') ? 'selected' : '' ?>>Cerco</option>
        <option value="Blitz" <?= ($dados['tipo_operacao'] == 'Blitz') ? 'selected' : '' ?>>Blitz</option>
        <option value="Reintegração de Posse" <?= ($dados['tipo_operacao'] == 'Reintegração de Posse') ? 'selected' : '' ?>>Reintegração de Posse</option>
        <option value="Apoio a Outro Órgão" <?= ($dados['tipo_operacao'] == 'Apoio a Outro Órgão') ? 'selected' : '' ?>>Apoio a Outro Órgão</option>
        <option value="Outros" <?= ($dados['tipo_operacao'] == 'Outros') ? 'selected' : '' ?>>Outros</option>
      </select>
<br>

     Local da Operação:
      <input type="text"  name="local" value="<?=$dados['local_operacao']?>"><br>
      Data e Hora:
      <input type="datetime-local"  name="data_hora" value="<?=$dados['data_inicio_operacao']?>"><br>

      Descrição Detalhada: <br>
      <textarea name="descricao" rows="6" ><?=$dados['descricao_operacao']?></textarea><br>

      Status da Operação:
      <select name="status" required>
        <option value="Planejada" <?= ($dados['status_operacao'] == 'Planejada') ? 'selected' : '' ?>>Planejada</option>
        <option value="Em Andamento" <?= ($dados['status_operacao'] == 'Em Andamento') ? 'selected' : '' ?>>Em Andamento</option>
        <option value="Concluída" <?= ($dados['status_operacao'] == 'Concluída') ? 'selected' : '' ?>>Concluída</option>
        <option value="Cancelada" <?= ($dados['status_operacao'] == 'Cancelada') ? 'selected' : '' ?>>Cancelada</option>
      </select><br>


      <input type="submit" value="Registrar Alterações">
    </form>
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

  $query = "UPDATE `operacoes` SET `nome_operacao`='$nome',`tipo_operacao`='$tipo',
  `local_operacao`='$local',`descricao_operacao`='$descricao',`data_inicio_operacao`='$dataInicio',`status_operacao`='$status' WHERE id_operacao = '$id'";
  $result = mysqli_query($conexao, $query);
  header("Location: operacoes.php");
  exit();
}
?>