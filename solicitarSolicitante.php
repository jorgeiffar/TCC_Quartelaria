<?php
//adicionar algo sobre"if usuario == quarteleiro" ele mostra a opção de selecionar um solicitante(para o RF-15)

session_start();
if(!isset($_SESSION['id_usuario'])){
    header("Location: login.php?status=nao_autorizado");
    exit();
}
include("conecta.php");
// armamentos
$sqlArmamentos = "SELECT * FROM armamentos where status_armamento != 1";
$resultadoArmamentos = mysqli_query($conexao, $sqlArmamentos);
$armamentos_por_tipo = [];
while ($row = mysqli_fetch_assoc($resultadoArmamentos)) {
    $tipo = $row['tipo_armamento'];
    $armamentos_por_tipo[$tipo][] = $row;
}

// equipamentos
$sqlEquipamentos = "SELECT * FROM equipamentos";
$resultadoEquipamentos = mysqli_query($conexao, $sqlEquipamentos);
$equipamentos_por_tipo = [];
while ($row = mysqli_fetch_assoc($resultadoEquipamentos)) {
    $tipo = $row['tipo_equipamento'];
    $equipamentos_por_tipo[$tipo][] = $row;
}

$id_solicitacao = mysqli_insert_id($conexao);
$sql = "SELECT identidade_funcional_usuario, nome_usuario FROM usuarios";
$result = $conexao->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Solicitação</title>
</head>
<body>
<?php
if ($_SESSION['perfil_usuario'] == 1) {
    
echo "<a href=\"homeQuarteleiro.php\">Voltar - Home</a> | 
<a href=\"verCarrinho.php\">Ver Carrinho</a>";
}else{
echo "<a href=\"homeSolicitante.php\">Voltar - Home</a> | 
<a href=\"verCarrinho.php\">Ver Carrinho</a>";
}
?>

<?php
if ($_SESSION['perfil_usuario'] == 1) {
    echo "<br><br><hr><strong style=\"font-size: 25px;\">Solicitante:</strong>";


    $sqldireta = "SELECT * FROM usuarios";
    $resultado = mysqli_query($conexao, $sqldireta);

    echo '<form method="post" action="addAoCarrinho.php">';
    echo '<select name="usuario" required>';
    echo "<option value=''>====Selecione====</option>";

   while ($row = mysqli_fetch_assoc($resultado)) {
    echo "<option value='{$row['id_usuario']}'>{$row['nome_usuario']} | {$row['identidade_funcional_usuario']}</option>";
}


    echo '</select>';
    echo '<button type="submit">Enviar</button>';
    echo '</form><hr>';
}?>
<?php
if ($_SESSION['perfil_usuario'] == 1 and !empty($_SESSION['usuario_selecionado']) or $_SESSION['perfil_usuario'] != 1) {?>
<h1>Armamentos</h1>
<?php foreach ($armamentos_por_tipo as $tipo => $armamentos): ?>
    <h3><?= htmlspecialchars($tipo) ?></h3>
    <?php foreach ($armamentos as $arma): ?>
        <form method="post" action="addAoCarrinho.php" style="display:inline-block;">
            <input type="hidden" name="tipo" value="armamento">
            <input type="hidden" name="id_item" value="<?= $arma['id_armamento'] ?>">
             <?php
             echo "<table border='1'> <tr><th>Nome</th><th>Código</th></tr>
             <tr><td>{$arma['nome_armamento']}</td> <td>{$arma['codigo_armamento']}</td></tr></table>"; ?>
            <input type="submit" value="Adicionar ao Carrinho">
        </form><br><br>
    <?php endforeach; echo "<hr>";?>
<?php endforeach; ?>

<hr>

<h1>Equipamentos</h1>
<?php foreach ($equipamentos_por_tipo as $tipo => $equipamentos): ?>
    <h3><?= htmlspecialchars($tipo) ?></h3>
    <?php foreach ($equipamentos as $equipa): ?>
        <form method="post" action="addAoCarrinho.php" style="display:inline-block;">
            <input type="hidden" name="tipo" value="equipamento">
            <input type="hidden" name="id_item" value="<?= $equipa['id_equipamento'] ?>">
            <?= $equipa['nome_equipamento'] ?>

            <?php
            echo "<br>
        Quantidade:
        <input type='number' name='quantidade_municao' required>";
            ?>
            <input type="submit" value="Adicionar ao Carrinho">
        </form><br>
    <?php endforeach; ?>
<?php endforeach; ?>

<hr>
<form method="post" action="verCarrinho.php">
    <input type="hidden" name="id_solicitacao_itens" value="<?= $id_solicitacao ?>">

    <h2>Operação/motivo</h2>
    <select name="operacao" required>
        <option value="">Selecione</option>
        <option value="a">A</option>
        <option value="b">B</option>
    </select>

    <hr>
    Data de devolução prevista:
    <input type="date" name="data_devolucao_item" required>

    <br><br>
    <input type="submit" value="Salvar e Ver Carrinho">
</form>

</body>
</html>
<?php
}?>