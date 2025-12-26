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

    <!-- RESPONSIVIDADE -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Verificação da Solicitação</title>
    <link rel="stylesheet" href="style.css?v=2">
</head>
<body>

<div class="bg-fallback"></div>

<header>
    <nav>
        <div class="logo"><a href="homeSolicitante.php"><img src="./img/home.png" alt="Home" style="width: 28px; vertical-align: middle-top;"><span> COMMANDER</span></a></div>
          <ul>
            <li><a href="solicitarSolicitante.php">Solicitar Itens</a></li>
            <li><a href="checkListVtr.php">Solicitar Viatura</a></li>
            <li><a href="solicitacoesAnterioresSolicitante.php" class="ativo">Solicitações Anteriores</a></li>
            <li><a href="editarPerfil.php">Perfil</a></li>
            <li><a href="logout.php"><img src="./img/logout.png" alt="Logout" style="width: 30px; height: 30px; vertical-align: middle;"></a></li>
          </ul>
    </nav>
</header>

<div class="container">

    <h2>Confirme os dados antes de enviar</h2>
    
    <div class="card">
        <p><strong>Usuário:</strong> <?= $usuario ?></p>
        <p><strong>Data e Hora:</strong> <?= $agora ?></p>
        <p><strong>Quilometragem:</strong> <?= $km ?></p>
        <p><strong>Placa:</strong> <?= $placa ?></p>
    </div>

    <h3>Itens verificados:</h3>

    <!-- RESPONSIVO -->
    <div class="table-responsive">
        <table class="tabela">
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
    </div>

    <form action="processaViatura.php" method="post">
        <input type="hidden" name="km" value="<?=  $km ?>">
        <input type="hidden" name="placa" value="<?=  $placa ?>">
        <input type="hidden" name="datahora" value="<?=  $agora ?>">

        <?php foreach($itens as $nome => $dados): ?>
            <input type="hidden" name="itens[<?=  $nome ?>][qap]" value="<?= isset($dados['qap']) ? '1' : '0' ?>">
            <input type="hidden" name="itens[<?=  $nome ?>][obs]" value="<?=  $dados['obs'] ?? '' ?>">
        <?php endforeach; ?>

        <div class="form-buttons">
            <input type="submit" value="Confirmar e Enviar" class="btn">
        </div>
    </form>

</div>

<footer>
    &copy; <?= date("Y") ?> COMMANDER - Sistema de Gerenciamento de Quartelaria
</footer>

</body>
</html>
