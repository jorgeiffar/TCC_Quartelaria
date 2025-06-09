<?php
session_start();
include("conecta.php");

if (isset($_POST['operacao']) && isset($_POST['data_devolucao_item'])) {
    $_SESSION['operacao'] = $_POST['operacao'];
    $_SESSION['data_devolucao_item'] = $_POST['data_devolucao_item'];
}

echo "<h2>Carrinho</h2>";

function mostrarItens($conexao, $ids, $tabela, $id_coluna, $nome_coluna, $titulo) {
    if (empty($ids)) return;

    $ids_str = implode(',', array_map('intval', $ids));
    $sql = "SELECT * FROM $tabela WHERE $id_coluna IN ($ids_str)";
    $res = mysqli_query($conexao, $sql);

    echo "<h3>$titulo</h3>";
    while ($row = mysqli_fetch_assoc($res)) {
        echo "• " . htmlspecialchars($row[$nome_coluna]) . "<br>";
    }
}

// Mostrar armamentos e equipamentos
if (empty($_SESSION['carrinho_armamentos']) && empty($_SESSION['carrinho_equipamentos'])) {
    echo "Carrinho vazio.<br>";
} else {
    mostrarItens($conexao, $_SESSION['carrinho_armamentos'] ?? [], 'armamentos', 'id_armamento', 'nome_armamento', 'Armamentos');
    mostrarItens($conexao, $_SESSION['carrinho_equipamentos'] ?? [], 'equipamentos', 'id_equipamento', 'nome_equipamento', 'Equipamentos');
}

// Mostrar operação e data
echo "<hr>";
echo "<h3>Operação/motivo:</h3>";
echo isset($_SESSION['operacao']) ? htmlspecialchars($_SESSION['operacao']) : 'Não informado';

echo "<h3>Data de Devolução Prevista:</h3>";
echo isset($_SESSION['data_devolucao_item']) ? htmlspecialchars($_SESSION['data_devolucao_item']) : 'Não informada';

echo '<br><br><a href="solicitarSolicitante.php">Voltar</a>';



if (!empty($_SESSION['carrinho_armamentos']) || !empty($_SESSION['carrinho_equipamentos'])): ?>
    <form method="post" action="processaSolicitacao.php">
        <input type="submit" value="Enviar Solicitação">
    </form>
<?php endif; ?>

