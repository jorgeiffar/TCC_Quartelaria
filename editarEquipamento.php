<?php
include("conecta.php");
session_start();
if (!isset($_SESSION['id_usuario']) || $_SESSION['perfil_usuario'] != 1) {
    header("Location: login.php?status=nao_autorizado");
    exit();
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "SELECT * FROM equipamentos WHERE id_equipamento = '$id'";
    $result = mysqli_query($conexao, $query);
    $dados = mysqli_fetch_assoc($result);
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Equipamento - Quartelaria</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
<header>
  <nav>
    <div class="logo"><a href="homeQuarteleiro.php">Commander</a></div>
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
  <?php if ($dados['tipo_equipamento'] != "Municao") { ?>
    <!-- EDITAR EQUIPAMENTO -->
    <div class="card">
      <h1>Editar Equipamento</h1>
      <form action="" method="post" class="formulario">
<?php
  $tipo = $dados['tipo_equipamento'];
if ($tipo == 'Outros') {
    $nome = $dados['nome_equipamento'];
    $partes = explode(' ',$nome);
    array_shift($partes);
    $nomeSemTipo = implode(' ', $partes);
    ?>
   <label>Nome do Equipamento:</label> <input type="text" name="nome_equipamento" value="<?=$nomeSemTipo?>" required>
   <?php
} else {
  $nome = $dados['nome_equipamento'];
}?>

        <label>Tipo de Equipamento:</label>
        <select name="equipamento" required>
          <option value="">Selecione</option>

          <optgroup label="Operação de Controle de Distúrbios">
            <option value="Disturbios|Escudo"     <?= ($dados['tipo_equipamento'] == 'Disturbios' && $dados['nome_equipamento'] == 'Escudo') ? 'selected' : '' ?>>Escudo</option>
            <option value="Disturbios|Capacete"   <?= ($dados['tipo_equipamento'] == 'Disturbios' && $dados['nome_equipamento'] == 'Capacete') ? 'selected' : '' ?>>Capacete</option>
            <option value="Disturbios|Bastão"     <?= ($dados['tipo_equipamento'] == 'Disturbios' && $dados['nome_equipamento'] == 'Bastão') ? 'selected' : '' ?>>Bastão</option>
            <option value="Disturbios|Granada"    <?= ($dados['tipo_equipamento'] == 'Disturbios' && $dados['nome_equipamento'] == 'Granada') ? 'selected' : '' ?>>Granada</option>
          </optgroup>

          <optgroup label="Outros">
            <option value="Outros|Carregador"     <?= ($dados['tipo_equipamento'] == 'Outros' && strpos($dados['nome_equipamento'], 'Carregador') !== false) ? 'selected' : '' ?>>Carregador</option>
            <option value="Outros|Bandoleira"     <?= ($dados['tipo_equipamento'] == 'Outros' && $dados['nome_equipamento'] == 'Bandoleira') ? 'selected' : '' ?>>Bandoleira</option>
          </optgroup>

        </select>

        <label>Quantidade Total:</label>
        <input type="number" name="quantidadeEquip" value="<?=$dados['quantidade_equipamento']?>" required>

        <input type="hidden" name="EouM" value="E">

        <div class="botoes-form">
          <input type="submit" value="Salvar Alterações" class="btn primario">
          <a href="verDetalhesItens.php" class="btn secundario">Cancelar</a>
        </div>
      </form>
    </div>

  <?php } else { ?>
    <!-- EDITAR MUNIÇÃO -->
    <div class="card">
      <h1>Editar Munição</h1>
      <form action="" method="post" class="formulario">

        <label>Calibre:</label>
        <select name="equipamento" required>
          <option value="">Selecione</option>
          <option value="Municao|7,62x51mm" <?= ($dados['tipo_equipamento'] == 'Municao' && $dados['nome_equipamento'] == '7,62x51mm') ? 'selected' : '' ?>>7,62x51mm</option>
          <option value="Municao|5,56x45mm" <?= ($dados['tipo_equipamento'] == 'Municao' && $dados['nome_equipamento'] == '5,56x45mm') ? 'selected' : '' ?>>5,56x45mm</option>
          <option value="Municao|9mm"       <?= ($dados['tipo_equipamento'] == 'Municao' && $dados['nome_equipamento'] == '9mm') ? 'selected' : '' ?>>9mm</option>
          <option value="Municao|12GA"      <?= ($dados['tipo_equipamento'] == 'Municao' && $dados['nome_equipamento'] == '12GA') ? 'selected' : '' ?>>12GA</option>
          <option value="Municao|Spark"     <?= ($dados['tipo_equipamento'] == 'Municao' && $dados['nome_equipamento'] == 'Spark') ? 'selected' : '' ?>>Spark</option>
        </select>

        <label>Quantidade Total:</label>
        <input type="number" name="quantidadeEquip" value="<?=$dados['quantidade_equipamento']?>" required>

        <input type="hidden" name="EouM" value="M">

        <div class="botoes-form">
          <input type="submit" value="Salvar Alterações" class="btn primario">
          <a href="verDetalhesItens.php" class="btn secundario">Cancelar</a>
        </div>
      </form>
    </div>
  <?php } ?>
</main>

<footer>
  &copy; <?php echo date("Y"); ?> COMMANDER - Sistema de Gerenciamento de Quartelaria
</footer>

<?php
// ===== PROCESSAMENTO =====
if (isset($_POST['EouM']) && $_POST['EouM'] == 'E') {
    $tipoMaisEquipamento = $_POST['equipamento'];
    list($nomeClasse, $tipo) = explode("|", $tipoMaisEquipamento);
    $nome = $_POST['nome_equipamento'];
    $quantidade = $_POST['quantidadeEquip'];

    $query = "UPDATE equipamentos 
              SET nome_equipamento='$tipo $nome', tipo_equipamento='$nomeClasse', quantidade_equipamento='$quantidade'
              WHERE id_equipamento = $id";
    mysqli_query($conexao, $query);

    header("Location: verDetalhesItens.php?statusEdit=1");
    exit();

} elseif (isset($_POST['EouM']) && $_POST['EouM'] == 'M') {
    $tipoMaisEquipamento = $_POST['equipamento'];
    list($tipo, $nome) = explode("|", $tipoMaisEquipamento);
    $quantidade = $_POST['quantidadeEquip'];

    $query = "UPDATE equipamentos 
              SET nome_equipamento='$nome', tipo_equipamento='$tipo', quantidade_equipamento='$quantidade'
              WHERE id_equipamento = $id";
    mysqli_query($conexao, $query);

    header("Location: verDetalhesItens.php?statusEdit=1");
    exit();
}
?>
</body>
</html>
