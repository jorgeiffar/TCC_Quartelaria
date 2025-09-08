<?php
session_start();
if(!isset($_SESSION['id_usuario'])){
    header("Location: login.php?status=nao_autorizado");
    exit();
}

include("conecta.php");

$id_solicitacao = $_GET['id'] ?? null;

if(!$id_solicitacao){
    echo "Empréstimo não especificado!";
    exit();
}


$sql_itens = "SELECT * FROM solicitacao_itens WHERE id_solicitacao = $id_solicitacao";
$result_itens = mysqli_query($conexao, $sql_itens);

if(mysqli_num_rows($result_itens) == 0){
    echo "Nenhum empréstimo encontrado!";
    exit();
}

// 1° item p descobrir o id_usuario da solicitação
$item_exemplo = mysqli_fetch_assoc($result_itens);
$id_usuario_solicitante = $item_exemplo['id_usuario'];


$sql_usuario = "SELECT nome_usuario FROM usuarios WHERE id_usuario = $id_usuario_solicitante";
$result_usuario = mysqli_query($conexao, $sql_usuario);
$usuario = mysqli_fetch_assoc($result_usuario);


$result_itens = mysqli_query($conexao, $sql_itens);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalhes Empréstimo - Quartelaria</title>
</head>
<body>
    <a href="homeQuarteleiro.php">Voltar</a><br>
    <a href="homeQuarteleiro.php">Home</a>

    <h1>Detalhes do Empréstimo</h1>
    <h2>Solicitante: <i><?= $usuario['nome_usuario'] ?></i></h2>

    <strong>Itens:</strong><br>
    <table border='1'>
        <tr>
            <th>Nome do Item</th>
            <th>Código</th>
            <th>Quantidade</th>
            <th>Tipo</th>
        </tr>
        <?php while($item = mysqli_fetch_assoc($result_itens)){
            
            
            if($item['tipo_item'] == 'armamento'){
                $sqlQtd = "SELECT quantidade FROM solicitacao_itens WHERE id_item = ".$item['id_item'];
                $resultQtd = mysqli_query($conexao, $sqlQtd);
                $detalheQtd = mysqli_fetch_assoc($resultQtd);


                $sql_det = "SELECT nome_armamento, codigo_armamento FROM armamentos WHERE id_armamento = ".$item['id_item'];
                $result_det = mysqli_query($conexao, $sql_det);
                $detalhe = mysqli_fetch_assoc($result_det);
            
            echo "<tr>
                <td> {$detalhe['nome_armamento']} </td>
                <td> {$detalhe['codigo_armamento']} </td>
                <td> {$detalheQtd['quantidade']} </td>
                <td> {$item['tipo_item']}</td>
            </tr>"; 
        
        } else {
            $sqlQtd = "SELECT quantidade FROM solicitacao_itens WHERE id_item = ".$item['id_item'];
                $resultQtd = mysqli_query($conexao, $sqlQtd);
                $detalheQtd = mysqli_fetch_assoc($resultQtd);

                
                $sql_det = "SELECT nome_equipamento FROM equipamentos WHERE id_equipamento = ".$item['id_item'];
                $result_det = mysqli_query($conexao, $sql_det);
                $detalhe = mysqli_fetch_assoc($result_det);

                echo "<tr>
                <td> {$detalhe['nome_equipamento']} </td>
                <td> X </td>
                <td> {$detalheQtd['quantidade']} </td>
                <td> {$item['tipo_item']}</td>
            </tr>"; 
            }
        }
        ?>
    </table>

    <form action="" method="get">
        <input type="hidden" name="observacao" value="1">
        <input type="hidden" name="id" value="<?= $id_solicitacao ?>">
        <input type="submit" value="Marcar como devolvido">
    </form>

    <?php
    if(isset($_GET['observacao'])){
        $result_itens = mysqli_query($conexao, $sql_itens);
        ?>
        <br><hr><br>
        <form action="registrarDevolucao.php" method="post">
            <table border='1'>
                <tr>
                    <th>Nome do Item</th>
                    <th>Código</th>
                    <th>Observação</th>
                </tr>
                <?php while($item = mysqli_fetch_assoc($result_itens))
                   if($item['tipo_item'] == 'armamento'){
                $sqlQtd = "SELECT quantidade FROM solicitacao_itens WHERE id_item = ".$item['id_item'];
                $resultQtd = mysqli_query($conexao, $sqlQtd);
                $detalheQtd = mysqli_fetch_assoc($resultQtd);
                //
                $sql_det = "SELECT nome_armamento, codigo_armamento FROM armamentos WHERE id_armamento = ".$item['id_item'];
                $result_det = mysqli_query($conexao, $sql_det);
                $detalhe = mysqli_fetch_assoc($result_det);

                echo "<tr>
                        <td> {$detalhe['nome_armamento']} </td>
                        <td> {$detalhe['codigo_armamento']}</td>
                        <td><input type=\"text\" name=\"observacao[]\"></td>
                    </tr>
                    <input type=\"hidden\" name=\"id_solicitacao_itens[]\" value=\" {$item['id_solicitacao_itens']}\">
                    </table>
            <input type=\"hidden\" name=\"id_solicitacao\" value=\"$id_solicitacao\">
            <button>Registrar</button>
        </form>";}}
          
?>
</body>
</html>