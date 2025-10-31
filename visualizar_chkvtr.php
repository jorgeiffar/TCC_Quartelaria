<?php
session_start();
if(!isset($_SESSION['id_usuario'])){
    header("Location: login.php?status=nao_autorizado");
    exit();
}

$km = $_POST['km'];
$placa = $_POST['placa'];
$itens = $_POST['itens'] ?? [];
$agora = date('d/m/Y H:i:s', time());
$usuario = $_SESSION['nome_usuario'];
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Verificação da Solicitação</title>
</head>
<body>
    <a href="javascript:history.back()">Voltar e Editar</a>
    <h2>Confirme os dados antes de enviar</h2>
    <p><strong>Usuário:</strong> <?= $usuario ?></p>
    <p><strong>Data e Hora:</strong> <?= $agora ?></p>
    <p><strong>Quilometragem:</strong> <?= $km ?></p>
    <p><strong>Placa:</strong> <?= $placa ?></p>

    <h3>Itens verificados:</h3>
    <table border="1" cellpadding="5">
        <thead>
            <tr>
                <th>Item</th>
                <th>QAP</th>
                <th>Observações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($itens as $nome => $dados): ?>
                <tr>
                    <td><?= $nome ?></td>
                    <td><?= isset($dados['qap']) ? 'Sim' : 'Não' ?></td>
                    <td><?= $dados['obs'] ?? '' ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <form action="processaViatura.php" method="post">
        <input type="hidden" name="km" value="<?=  $km ?>">
        <input type="hidden" name="placa" value="<?=  $placa ?>">
        <input type="hidden" name="datahora" value="<?=  $agora ?>">

        <?php foreach($itens as $nome => $dados): ?>
            <input type="hidden" name="itens[<?=  $nome ?>][qap]" value="<?= isset($dados['qap']) ? '1' : '0' ?>">
            <input type="hidden" name="itens[<?=  $nome ?>][obs]" value="<?=  $dados['obs'] ?? '' ?>">
        <?php endforeach; ?>

        <br>
        <input type="submit" value="Confirmar e Enviar">
    </form>
</body>
</html>
