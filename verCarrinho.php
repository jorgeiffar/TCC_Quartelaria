<?php
session_start();
include("conecta.php");

if (isset($_POST['operacao'])) $_SESSION['operacao'] = $_POST['operacao'];
if (isset($_POST['data_devolucao_item'])) $_SESSION['data_devolucao_item'] = $_POST['data_devolucao_item'];

echo "<h2>Carrinho</h2>";

if (empty($_SESSION['carrinho_armamentos']) && empty($_SESSION['carrinho_equipamentos'])) {
    echo "Carrinho vazio.";
} else {
    if (!empty($_SESSION['carrinho_armamentos'])) {
        $ids = implode(',', $_SESSION['carrinho_armamentos']);
        $q = mysqli_query($conexao, "SELECT nome_armamento, codigo_armamento FROM armamentos WHERE id_armamento IN ($ids)");
        echo "<h3>Armamentos</h3>";
        while ($r = mysqli_fetch_assoc($q)) echo "• {$r['nome_armamento']} - {$r['codigo_armamento']}<br>";
    }

    if (!empty($_SESSION['carrinho_equipamentos'])) {
        $ids = implode(',', $_SESSION['carrinho_equipamentos']);
        $q = mysqli_query($conexao, "SELECT nome_equipamento FROM equipamentos WHERE id_equipamento IN ($ids)");
        echo "<h3>Equipamentos</h3>";
        while ($r = mysqli_fetch_assoc($q)) echo "• {$r['nome_equipamento']}<br>";
    }
}

echo "<hr><h3>Operação:</h3>" . ($_SESSION['operacao'] ?? 'Não informada');
echo "<h3>Devolução prevista:</h3>" . ($_SESSION['data_devolucao_item'] ?? 'Não informada');

echo '<br><br><a href="solicitarSolicitante.php">Voltar</a>';

if (!empty($_SESSION['carrinho_armamentos']) || !empty($_SESSION['carrinho_equipamentos'])) {
    echo '<form method="post" action="processaSolicitacao.php"><input type="submit" value="Enviar Solicitação"></form>';
}
?>
