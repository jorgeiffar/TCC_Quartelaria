<?php
include("conecta.php");
session_start();

if(!isset($_SESSION['id_usuario'])){
    header("Location: login.php?status=nao_autorizado");
    exit();
}

$sql = "SELECT id_item, nome_item, descricao_item FROM itens_checklist ORDER BY id_item";
$itens = mysqli_query($conexao, $sql);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checklist da Viatura</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="bg-fallback"></div>

<!-- NAVBAR -->
<nav>
    <div class="logo"><a href="homeSolicitante.php"><img src="./img/home.png" alt="Home" style="width: 28px; vertical-align: middle-top;"><span> COMMANDER</span></a></div>
    <ul>
        <li><a href="solicitarSolicitante.php">Solicitar Itens</a></li>
        <li><a href="checkListVtr.php">Solicitar Viatura</a></li>
        <li><a href="solicitacoesAnterioresSolicitante.php">Solicitações Anteriores</a></li>
        <li><a href="editarPerfil.php">Perfil</a></li>
<li><a href="logout.php"><img src="./img/logout.png" alt="Logout" style="width: 30px; height: 30px; vertical-align: middle;"></a></li>    </ul>
</nav>

<!-- CONTEÚDO -->
<div class="container">
    <h2>Checklist de Viatura</h2>

    <form action="visualizar_chkvtr.php" method="post" class="form-area">

        <div class="form-grid">
            <div>
                <label>Quilometragem:</label>
                <input type="number" name="km" required>
            </div>
            <div>
                <label>Placa do veículo:</label>
                <input type="text" name="placa" required>
            </div>
        </div>

        <br>

        <!-- WRAPPER COM ROLAGEM HORIZONTAL SOMENTE NA TABELA -->
        <div class="table-wrapper">
            <table class="tabela">
                <thead>
                    <tr>
                        <th>Item</th>
                        <th>QAP</th>
                        <th>Observações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($item = mysqli_fetch_assoc($itens)): ?>
                        <tr>
                            <td><?= htmlspecialchars($item['nome_item']) ?></td>
                            <td class="td-checkbox">
                                <input type="checkbox" name="itens[<?= htmlspecialchars($item['nome_item']) ?>][qap]" value="1">
                            </td>
                            <td>
                                <input type="text" name="itens[<?= htmlspecialchars($item['nome_item']) ?>][obs]" placeholder="Opcional">
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>

        <div class="form-buttons">
            <input type="submit" value="Verificar Solicitação">
        </div>

    </form>
</div>

<footer>
    Quartelaria - Sistema de Solicitações
</footer>

</body>
</html>