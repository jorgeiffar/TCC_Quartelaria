<?php
include("conecta.php");
session_start();

if (!isset($_SESSION['id_usuario']) || $_SESSION['perfil_usuario'] != 1) {
    header("Location: login.php?status=nao_autorizado");
    exit();
}

$queryListarVtrPendente = "SELECT 
    vtr.id_solicitacao_viatura, 
    vtr.data_solicitacao_viatura,
    vtr.quilometragem,
    vtr.placa_veiculo,
    vtr.status_solicitacao_viatura,
    u.nome_usuario
FROM solicitacao_viatura vtr
JOIN usuarios u ON vtr.id_usuario = u.id_usuario
WHERE vtr.status_solicitacao_viatura = 'Pendente'
ORDER BY vtr.data_solicitacao_viatura ASC";

$resultListarVtr = mysqli_query($conexao, $queryListarVtrPendente);
if (!$resultListarVtr) {
    die("Erro ao listar checklists de viatura: " . mysqli_error($conexao));
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checklists de Viatura Pendentes</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="bg-fallback"></div>

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
        <li><a href="logout.php">Logout</a></li>
      </ul>
    </nav>

    <div class="container">
        <?php echo "<a href='solicitacoesAnterioresVtr.php' class=\"btn\">Solicitações Anteriores </a>";?>
        <h1>Checklists de Viatura Pendentes</h1>
        <hr>

        <?php
        if (isset($_GET['status'])) {
            $status = (int)$_GET['status'];
            if ($status == 2) {
                echo "<div id='mensagem' class='alert error'>Checklist de viatura negado.</div>";
            } elseif ($status == 1) {
                echo "<div id='mensagem' class='alert success'>Checklist de viatura aceito.</div>";
            } else {
                echo "<div id='mensagem' class='alert info'>Erro não identificado na deliberação.</div>";
            }
        }
        ?>

        <script>
            setTimeout(function() {
                var msg = document.getElementById('mensagem');
                if (msg) msg.style.display = 'none';
                const url = new URL(window.location);
                url.searchParams.delete('status');
                window.history.replaceState({}, document.title, url);
            }, 3000);
        </script>

        <hr>

        <?php
        if (mysqli_num_rows($resultListarVtr) == 0) {
            echo "<p>Nenhum checklist de viatura pendente no momento.</p>";
        }

        while ($dadosVtr = mysqli_fetch_assoc($resultListarVtr)) {
            $id_solicitacao = $dadosVtr['id_solicitacao_viatura'];
            ?>

            <div class="card">
                <h2>Checklist #<?= $id_solicitacao ?></h2>
                <p><strong>Solicitante:</strong> <?= $dadosVtr['nome_usuario'] ?></p>
                <p><strong>Data/Hora da Solicitação:</strong> <?= $dadosVtr['data_solicitacao_viatura'] ?></p>
                <p><strong>Placa:</strong> <?= $dadosVtr['placa_veiculo'] ?></p>
                <p><strong>Quilometragem:</strong> <?= $dadosVtr['quilometragem'] ?> km</p>
                <p><strong>Status:</strong> <?= $dadosVtr['status_solicitacao_viatura'] ?></p>

                <a href="detalhesVtr.php?id=<?= $id_solicitacao ?>" class="btn">Visualizar Detalhes do Checklist</a>
                <br><br>

                <div class="form-buttons">
                    <a href="processaDeliberacaoVtr.php?status=1&id=<?= $id_solicitacao ?>" class="btn">Aceitar</a>
                    <a href="processaDeliberacaoVtr.php?status=2&id=<?= $id_solicitacao ?>" class="btn" style="background:#c62828;">Negar</a>
                </div>
            </div>

            <?php
        }
        ?>
    </div>

    <footer>
        <p>&copy; 2025 Quartelaria - Sistema Interno</p>
    </footer>
</body>
</html>
