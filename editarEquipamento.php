<?php
include("conecta.php");
session_start();
if(!isset($_SESSION['id_usuario']) || $_SESSION['perfil_usuario'] != 1){
    header("Location: login.php?status=nao_autorizado");
    exit();
}

if(isset($_GET['id'])){
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
</head>

<body>
    <a href="verDetalhesItens.php">Voltar</a><br>
    <a href="homeQuarteleiro.php">Home</a>

<?php if($dados['tipo_equipamento'] != "Municao"){ ?>
    <h1>Editar Equipamento</h1>
    <form action="" method="post">

    Nome do Equipamento: 
    <input type="text" name="nome_equipamento" value="<?=$dados['nome_equipamento']?>"><br>
        Tipo de Equipamento:
        <select name="equipamento" required>
            <option value="">Selecione</option>

            <optgroup label="Operação de Controle de Distúrbios">
                <option value="Disturbios|Escudo" <?= ($dados['tipo_equipamento'] == 'Escudo') ? 'selected' : '' ?>>Escudo</option>
                <option value="Disturbios|Capacete" <?= ($dados['tipo_equipamento'] == 'Capacete') ? 'selected' : '' ?>>Capacete</option>
                <option value="Disturbios|Bastao" <?= ($dados['tipo_equipamento'] == 'Bastao') ? 'selected' : '' ?>>Bastão</option>
                <option value="Disturbios|Granada" <?= ($dados['tipo_equipamento'] == 'Granada') ? 'selected' : '' ?>>Granada</option>
            </optgroup>

            <optgroup label="Outros">
                <option value="Outros|Carregador" <?= ($dados['tipo_equipamento'] == 'Carregador') ? 'selected' : '' ?>>Carregador</option>
                <option value="Outros|Bandoleira" <?= ($dados['tipo_equipamento'] == 'Bandoleira') ? 'selected' : '' ?>>Bandoleira</option>
            </optgroup>
        </select>
        <br>

        Quantidade Total:
        <input type="number" name="quantidadeEquip" value="<?=$dados['quantidade_equipamento']?>" required><br>
<input type="hidden" name="EouM" value="E">
        <input type="submit" value="Salvar Alterações">
    </form>

<?php } else { ?>
    <h1>Editar Munição</h1>
    <form action="" method="post">
        Calibre:
        <select name="equipamento" required>
            <option value="">Selecione</option>
            <option value="Municao|7,62x51mm" <?= ($dados['nome_equipamento'] == '7,62x51mm') ? 'selected' : '' ?>>7,62x51mm</option>
            <option value="Municao|5,56x45mm" <?= ($dados['nome_equipamento'] == '5,56x45mm') ? 'selected' : '' ?>>5,56x45mm</option>
            <option value="Municao|9mm" <?= ($dados['nome_equipamento'] == '9mm') ? 'selected' : '' ?>>9mm</option>
            <option value="Municao|12GA" <?= ($dados['nome_equipamento'] == '12GA') ? 'selected' : '' ?>>12GA</option>
            <option value="Municao|Spark" <?= ($dados['nome_equipamento'] == 'Spark') ? 'selected' : '' ?>>Spark</option>
        </select>
        <br>

        Quantidade Total:
        <input type="number" name="quantidadeEquip" value="<?=$dados['quantidade_equipamento']?>" required><br>
<input type="hidden" name="EouM" value="M">
        <input type="submit" value="Salvar Alterações">
    </form>
<?php } ?>

<?php
if(isset($_POST['EouM']) AND $_POST['EouM'] == 'E'){
$tipoMaisEquipamento = $_POST['equipamento'];
list( $nomeClasse,$tipo) = explode("|", $tipoMaisEquipamento);
$nome = $_POST['nome_equipamento'];
$quantidade = $_POST['quantidadeEquip'];

  $query = "UPDATE `equipamentos` SET `nome_equipamento`='$nome',`tipo_equipamento`='$tipo',`quantidade_equipamento`='$quantidade'
  WHERE id_equipamento = $id";
  $result = mysqli_query($conexao, $query);
  header("Location: verDetalhesItens.php");
  exit();
}elseif(isset($_POST['EouM']) AND $_POST['EouM'] == 'M'){
$tipoMaisEquipamento = $_POST['equipamento'];
list($tipo, $nome) = explode("|", $tipoMaisEquipamento);
$quantidade = $_POST['quantidadeEquip'];

    $query = "UPDATE `equipamentos` SET `tipo_equipamento`='$tipo',`quantidade_equipamento`='$quantidade'
    WHERE id_equipamento = $id";
    $result = mysqli_query($conexao, $query);
    header("Location: verDetalhesItens.php");
    exit();
}
?>
</body>
</html>
