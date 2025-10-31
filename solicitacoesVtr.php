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
</head>
<body>
    <a href="homeQuarteleiro.php">Voltar - Home</a><br>
    <a href="solicitacoesAnterioresVtr.php">Solicitações Anteriores Viatura</a><br>
    <h1>Checklists de Viatura Pendentes</h1>
    <hr>

    <?php
    if (isset($_GET['status'])) {
        $status = (int)$_GET['status'];
        if ($status == 2) {
            echo "<div id='mensagem' style='color:red;'> Checklist de viatura negado. </div>";
        } elseif ($status == 1) {
            echo "<div id='mensagem' style='color:green;'> Checklist de viatura aceito. </div>";
        } else {
            echo "<div id='mensagem' style='color:orange;'> Erro não identificado na deliberação. </div>";
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
        echo "<p>Nenhum checklist de viatura Pendente no momento.</p>";
    }

    // Loop para exibir cada solicitação de viatura pendente
    while ($dadosVtr = mysqli_fetch_assoc($resultListarVtr)) {
        $id_solicitacao = $dadosVtr['id_solicitacao_viatura'];

        echo "<h2>Checklist #{$id_solicitacao}</h2>";
        echo "Solicitante: {$dadosVtr['nome_usuario']}<br>";
        echo "Data/Hora da Solicitação: {$dadosVtr['data_solicitacao_viatura']}<br>";
        echo "Placa: <strong>{$dadosVtr['placa_veiculo']}</strong><br>";
        echo "Quilometragem: {$dadosVtr['quilometragem']} km<br>";
        echo "Status: {$dadosVtr['status_solicitacao_viatura']}<br>";

        // Link para ver os itens detalhadamente
        echo "<a href='detalhesVtr.php?id={$id_solicitacao}'>Visualizar Detalhes do Checklist</a><br><br>";


        // Links de Deliberação
        echo "
        <a href='processaDeliberacaoVtr.php?status=1&id={$id_solicitacao}'>Aceitar</a> | 
        <a href='processaDeliberacaoVtr.php?status=2&id={$id_solicitacao}'>Negar</a>
        ";

        echo "<hr style='border-top: 2px solid #bbb;'><br>";
    }
    ?>
</body>
</html>