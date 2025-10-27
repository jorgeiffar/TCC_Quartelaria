<?php
session_start();
if(!isset($_SESSION['id_usuario'])){
    header("Location: login.php?status=nao_autorizado");
    exit();
}
include("conecta.php");
if ($_SESSION['perfil_usuario'] == 1 && !empty($_SESSION['usuario_selecionado'])) {
    $usuario = (int) $_SESSION['usuario_selecionado'];
    $sql = "SELECT nome_usuario, identidade_funcional_usuario FROM usuarios WHERE id_usuario = $usuario";
    $result = mysqli_query($conexao, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $dados = mysqli_fetch_assoc($result);
        echo "Solicitante Selecionado: {$dados['nome_usuario']}<br>";
        echo "Identidade Funcional: {$dados['identidade_funcional_usuario']}";
    } else {
        echo "Usuário selecionado não encontrado.";
    }
} elseif($_SESSION['perfil_usuario'] == 1 && empty($_SESSION['usuario_selecionado'])) {
    echo "Nenhum usuário selecionado.";
}
if (isset($_POST['operacao'])){ $_SESSION['operacao'] = $_POST['operacao'];
$sql = "SELECT nome_operacao FROM operacoes WHERE id_operacao = {$_SESSION['operacao']}";
$queryOperacao = mysqli_query($conexao,$sql);
$operacao = mysqli_fetch_assoc($queryOperacao);}
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

echo "<hr><h3>Operação:</h3>" . ($operacao['nome_operacao'] ?? 'Não informada');
echo "<h3>Devolução prevista:</h3>" . ($_SESSION['data_devolucao_item'] ?? 'Não informada');

echo '<br><br><a href="solicitarSolicitante.php">Voltar</a>';

if (!empty($_SESSION['carrinho_armamentos']) || !empty($_SESSION['carrinho_equipamentos'])) {

    if (!empty($_SESSION['carrinho_armamentos']) || !empty($_SESSION['carrinho_equipamentos'])) {
    if (!empty($_SESSION['operacao']) && !empty($_SESSION['data_devolucao_item'])) {
        echo '<form method="post" action="processaSolicitacao.php">
                <input type="submit" value="Enviar Solicitação">
              </form>';
    } else {
        echo "<p style='color:red;'>⚠️ Preencha o motivo e a data de devolução antes de enviar a solicitação.</p>";
    }
}
}
?>
