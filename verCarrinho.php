<?php
session_start();
if(!isset($_SESSION['id_usuario'])){
    header("Location: login.php?status=nao_autorizado");
    exit();
}
include("conecta.php");

if (isset($_POST['operacao'])) $_SESSION['operacao'] = $_POST['operacao'];
if (isset($_POST['data_devolucao_item'])) $_SESSION['data_devolucao_item'] = $_POST['data_devolucao_item'];

echo "<h2>Carrinho</h2>";

if (empty($_SESSION['carrinho_armamentos']) && empty($_SESSION['carrinho_equipamentos'])) {
    echo "Carrinho vazio.";
} else {
    if (!empty($_SESSION['carrinho_armamentos'])) {
        $ids = implode(',', $_SESSION['carrinho_armamentos']);
        $q = mysqli_query($conexao, "SELECT id_armamento, nome_armamento, codigo_armamento FROM armamentos WHERE id_armamento IN ($ids)");
        echo "<h3>Armamentos</h3>";
        while ($r = mysqli_fetch_assoc($q)){
        echo "• {$r['nome_armamento']} - {$r['codigo_armamento']}<br>";
        echo " <a href='removerItemCarrinho.php?tipo=armamento&id_item=" . $r['id_armamento'] . "'>Remover</a><br><br>";}

    }

    if (!empty($_SESSION['carrinho_equipamentos'])) {
        $idsArray = array_column($_SESSION['carrinho_equipamentos'], 'id');
        $ids = implode(',', $idsArray);
        $q = mysqli_query($conexao, "SELECT id_equipamento, nome_equipamento, tipo_equipamento FROM equipamentos WHERE id_equipamento IN ($ids)");
        echo "<h3>Equipamentos</h3>";
        while ($r = mysqli_fetch_assoc($q)) {
            $quantidade = 1;
            foreach ($_SESSION['carrinho_equipamentos'] as $item){
                if($item['id'] == $r['id_equipamento']){
                    $quantidade = $item['quantidade'];
                    break;
                }
            }
        echo "• {$r['nome_equipamento']} - {$r['tipo_equipamento']} | Quantidade: $quantidade<br>";
        echo " <a href='removerItemCarrinho.php?tipo=equipamento&id_item=" . $r['id_equipamento'] . "'>Remover</a><br><br>";}

    }
}

echo "<hr><h3>Operação:</h3>" . ($_SESSION['operacao'] ?? 'Não informada');
echo "<h3>Devolução prevista:</h3>" . ($_SESSION['data_devolucao_item'] ?? 'Não informada');

echo '<br><br><a href="solicitarSolicitante.php">Voltar</a>';

if (!empty($_SESSION['carrinho_armamentos']) || !empty($_SESSION['carrinho_equipamentos'])) {
    echo '<form method="post" action="processaSolicitacao.php"><input type="submit" value="Enviar Solicitação"></form>';
}
?>
