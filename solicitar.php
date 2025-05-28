<?php
include("conecta.php");

//armamentos
$sqlArmamentos = "SELECT * FROM armamentos";
$resultadoArmamentos = mysqli_query($conexao, $sqlArmamentos);
$armamentos_por_tipo = [];
while ($row = mysqli_fetch_assoc($resultadoArmamentos)) {
    $tipo = $row['tipo_armamento'];
    if (!isset($armamentos_por_tipo[$tipo])) {
        $armamentos_por_tipo[$tipo] = [];
    }
    $armamentos_por_tipo[$tipo][] = $row;
}
//equipamentos
$sqlEquipamentos = "SELECT * FROM equipamentos";
$resultadoEquipamentos = mysqli_query($conexao, $sqlEquipamentos);
$equipamentos_por_tipo = [];
while ($row = mysqli_fetch_assoc($resultadoEquipamentos)) {
    $tipo = $row['tipo_equipamento'];
    if (!isset($equipamentos_por_tipo[$tipo])) {
        $equipamentos_por_tipo[$tipo] = [];
    }
    $equipamentos_por_tipo[$tipo][] = $row;
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solicitação</title>
</head>

<body>
    <form method="post" action="">
        <!-- ARMAMENTO -->
        <a href="homeSolicitante.php">Voltar - Home</a>
        <h1> Armamentos </h1>
        <?php foreach ($armamentos_por_tipo as $tipo => $armamentos): ?>
    <h3><?= htmlspecialchars($tipo) ?></h3>
    <?php foreach ($armamentos as $arma): ?>
        <label>
            <input type="checkbox" name="armas_selecionados[]" value="<?= $arma['id_armamento'] ?>">
            <?= htmlspecialchars($arma['nome_armamento']) ?>
        </label><br>
    <?php endforeach; ?>
<?php endforeach; ?>
<hr>
<!-- EQUIPAMENTO -->
         <h1> Equipamentos </h1>
        <?php foreach ($equipamentos_por_tipo as $tipo => $equipamentos): ?>
    <h3><?= htmlspecialchars($tipo) ?></h3>
    <?php foreach ($equipamentos as $equipa): ?>
        <label>
            <input type="checkbox" name="equipamentos_selecionados[]" value="<?= $equipa['id_equipamento'] ?>">
            <?= htmlspecialchars($equipa['nome_equipamento']) ?>
        </label><br>
    <?php endforeach; ?>
<?php endforeach; ?>
        <hr>
        <h2>Operação/motivo</h2>
        <select name="operacao">
            <option value="">Selecione</option>
            <option value="a">A</option>
            <option value="b">B</option>
        </select>
        <br><input type="submit" value="Solicitar">
    </form>
</body>

</html>