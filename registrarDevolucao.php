<?php
session_start();
if(!isset($_SESSION['id_usuario'])){
    header("Location: login.php?status=nao_autorizado");
    exit();
}

include("conecta.php");

if($_SERVER['REQUEST_METHOD'] != 'POST'){
    echo "Acesso inválido.";
    exit();
}

$id_solicitacao   = (int)($_POST['id_solicitacao'] ?? 0);
$observacoes      = $_POST['observacao'] ?? [];
$qtd_utilizada    = $_POST['qtd_utilizada'] ?? [];
$qtd_extraviada   = $_POST['qtd_extraviada'] ?? [];
$ids_solic_itens  = $_POST['id_solicitacao_itens'] ?? [];
$ids_item         = $_POST['id_item'] ?? [];

if($id_solicitacao <= 0 || empty($ids_solic_itens)){
    echo "Dados incompletos.";
    exit();
}

mysqli_autocommit($conexao, false);
$errors = [];

/* Marca todos os itens como devolvidos */
$sql = "
UPDATE solicitacao_itens 
SET status_solicitacao = 'Devolvido',
    data_devolucao_real_item = NOW()
WHERE id_solicitacao = $id_solicitacao
";
mysqli_query($conexao, $sql);

/* Loop dos itens */
foreach($ids_solic_itens as $i => $id_solic_itens){

    $id_solic_itens = (int)$id_solic_itens;
    $id_item = (int)($ids_item[$i] ?? 0);

    if($id_solic_itens <= 0 || $id_item <= 0){
        $errors[] = "ID inválido.";
        continue;
    }

    /* Busca tipo e quantidade */
    $sql = "
    SELECT tipo_item, quantidade 
    FROM solicitacao_itens 
    WHERE id_solicitacao_itens = $id_solic_itens
    ";
    $res = mysqli_query($conexao, $sql);
    if(mysqli_num_rows($res) == 0) continue;

    $row = mysqli_fetch_assoc($res);
    $tipo = strtolower(trim($row['tipo_item']));
    $qtd_emprestada = (int)$row['quantidade'];

    /* Salva observação */
    $obs = trim($observacoes[$id_solic_itens] ?? '');
    if($obs != ''){
        $obs = mysqli_real_escape_string($conexao, $obs);
        $sql = "
        UPDATE solicitacao_itens
        SET observacao_item = '$obs'
        WHERE id_solicitacao_itens = $id_solic_itens
        ";
        mysqli_query($conexao, $sql);
    }

    /* Armamento: só libera */
    if(strpos($tipo, 'arm') !== false){
        $sql = "
        UPDATE armamentos
        SET status_armamento = 0
        WHERE id_armamento = $id_item
        ";
        mysqli_query($conexao, $sql);
        continue;
    }

    /* Equipamento */
    if($tipo != 'equipamento') continue;

    $utilizada  = (int)($qtd_utilizada[$id_solic_itens] ?? 0);
    $extraviada = (int)($qtd_extraviada[$id_solic_itens] ?? 0);
    $total_perdido = $utilizada + $extraviada;

    if($total_perdido > $qtd_emprestada){
        $errors[] = "Quantidade inválida no item $id_solic_itens";
        continue;
    }

    /* Devolve tudo do campo */
    $sql = "
    UPDATE equipamentos
    SET quantidade_disponivel_equipamento =
        quantidade_disponivel_equipamento - $qtd_emprestada
    WHERE id_equipamento = $id_item
    AND quantidade_disponivel_equipamento >= $qtd_emprestada
    ";
    mysqli_query($conexao, $sql);

    if(mysqli_affected_rows($conexao) == 0){
        $errors[] = "Erro ao devolver equipamento ID $id_item";
    }

    /* Dá baixa no patrimônio se perdeu algo */
    if($total_perdido > 0){
        $sql = "
        UPDATE equipamentos
        SET quantidade_equipamento = quantidade_equipamento - $total_perdido
        WHERE id_equipamento = $id_item
        AND quantidade_equipamento >= $total_perdido
        ";
        mysqli_query($conexao, $sql);

        if(mysqli_affected_rows($conexao) == 0){
            $errors[] = "Erro ao dar baixa no patrimônio ID $id_item";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Registrar Devolução</title>
    <link rel="stylesheet" href="style.css?v=2">
</head>
<body>
    <main class="container">
        <header class="page-header">
            <h1>Registrar Devolução</h1>
        </header>

        <section class="content">
            <?php
            if(!empty($errors)){
                mysqli_rollback($conexao);
                mysqli_autocommit($conexao, true);
                echo "<div class='error-box'>";
                echo "<h3>Ocorreram erros — transação revertida:</h3><ul>";
                foreach($errors as $e){
                    echo "<li>" . htmlspecialchars($e) . "</li>";
                }
                echo "</ul>";
                echo "<a href='javascript:history.back()' class='btn'>Voltar</a>";
                echo "</div>";
                exit();
            } else {
                mysqli_commit($conexao);
                mysqli_autocommit($conexao, true);
                echo "<div class='success-box'>";
                echo "<p>Devolução registrada com sucesso!</p><br>";
                echo "<a href='homeQuarteleiro.php' class='btn'>Voltar</a>";
                echo "</div>";
                exit();
            }
            ?>
