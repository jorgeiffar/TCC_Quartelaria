<?php
session_start();
if(!isset($_SESSION['id_usuario'])){
    header("Location: login.php?status=nao_autorizado");
    exit();
}

include("conecta.php");

if($_SERVER['REQUEST_METHOD'] !== 'POST'){
    echo "Acesso inválido.";
    exit();
}

$id_solicitacao = (int)($_POST['id_solicitacao'] ?? 0);
$observacoes      = $_POST['observacao'] ?? [];
$qtd_utilizada    = $_POST['qtd_utilizada'] ?? [];
$qtd_extraviada   = $_POST['qtd_extraviada'] ?? [];
$ids_solic_itens  = $_POST['id_solicitacao_itens'] ?? [];
$ids_item         = $_POST['id_item'] ?? [];

if($id_solicitacao <= 0 || empty($ids_solic_itens) || empty($ids_item)){
    echo "Dados incompletos.";
    exit();
}

mysqli_autocommit($conexao, false);
$errors = [];

// Marca todos os itens como devolvidos
$sql = "UPDATE solicitacao_itens SET status_solicitacao = 'Devolvido', data_devolucao_real_item = NOW() WHERE id_solicitacao = ?";
$stmt = mysqli_prepare($conexao, $sql);
mysqli_stmt_bind_param($stmt, "i", $id_solicitacao);
mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);

// Prepara statements que vamos usar
$stmt_select = mysqli_prepare($conexao, "SELECT tipo_item, quantidade FROM solicitacao_itens WHERE id_solicitacao_itens = ?");
$stmt_arm    = mysqli_prepare($conexao, "UPDATE armamentos SET status_armamento = 0 WHERE id_armamento = ?");

// Loop principal
foreach($ids_solic_itens as $i => $id_solic_itens){
    $id_solic_itens = (int)$id_solic_itens;
    $id_item        = (int)($ids_item[$i] ?? 0);

    if($id_solic_itens <= 0 || $id_item <= 0){
        $errors[] = "ID inválido no item (índice $i).";
        continue;
    }

    // Pega tipo e quantidade emprestada
    mysqli_stmt_bind_param($stmt_select, "i", $id_solic_itens);
    mysqli_stmt_execute($stmt_select);
    $res = mysqli_stmt_get_result($stmt_select);
    if(mysqli_num_rows($res) == 0) continue;

    $row = mysqli_fetch_assoc($res);
    $tipo = strtolower(trim($row['tipo_item']));
    $qtd_emprestada = (int)$row['quantidade'];

    //Salva observação (agora funciona para armamento e equipamento)
    $obs = trim($observacoes[$id_solic_itens] ?? '');
    if($obs !== ''){
        $sql = "UPDATE solicitacao_itens SET observacao_item = ? WHERE id_solicitacao_itens = ?";
        $s = mysqli_prepare($conexao, $sql);
        mysqli_stmt_bind_param($s, "si", $obs, $id_solic_itens);
        mysqli_stmt_execute($s);
        mysqli_stmt_close($s);
    }

    // Se for armamento -> só libera
    if(stripos($tipo, 'arm') !== false){
        mysqli_stmt_bind_param($stmt_arm, "i", $id_item);
        mysqli_stmt_execute($stmt_arm);
        continue;
    }

    // Se for equipamento
    if($tipo !== 'equipamento') continue;

    $utilizada  = (int)($qtd_utilizada[$id_solic_itens] ?? 0);
    $extraviada = (int)($qtd_extraviada[$id_solic_itens] ?? 0);
    $total_perdido = $utilizada + $extraviada;

    if($total_perdido > $qtd_emprestada){
        $errors[] = "Erro: utilizado + extraviado ($total_perdido) > emprestado ($qtd_emprestada) no item $id_solic_itens";
        continue;
    }

    //  Sempre devolve tudo dofora da quartelaria
    $sql = "UPDATE equipamentos 
            SET quantidade_disponivel_equipamento = quantidade_disponivel_equipamento - ? 
            WHERE id_equipamento = ? AND quantidade_disponivel_equipamento >= ?";
    $s = mysqli_prepare($conexao, $sql);
    mysqli_stmt_bind_param($s, "iii", $qtd_emprestada, $id_item, $qtd_emprestada);
    mysqli_stmt_execute($s);
    if(mysqli_stmt_affected_rows($s) == 0){
        $errors[] = "Falha ao devolver equipamento do campo (ID: $id_item)";
    }
    mysqli_stmt_close($s);

    //Só dá baixa no patrimônio se perdeu algo
    if($total_perdido > 0){
        $sql = "UPDATE equipamentos 
                SET quantidade_equipamento = quantidade_equipamento - ? 
                WHERE id_equipamento = ? AND quantidade_equipamento >= ?";
        $s = mysqli_prepare($conexao, $sql);
        mysqli_stmt_bind_param($s, "iii", $total_perdido, $id_item, $total_perdido);
        mysqli_stmt_execute($s);
        if(mysqli_stmt_affected_rows($s) == 0){
            $errors[] = "Falha ao dar baixa no patrimônio ($total_perdido unidades) - ID: $id_item";
        }
        mysqli_stmt_close($s);
    }
}

//Finaliza 
mysqli_stmt_close($stmt_select);
mysqli_stmt_close($stmt_arm);

if(!empty($errors)){
    mysqli_rollback($conexao);
    echo "<div class='error-box'><h3>Erros na devolução:</h3><ul>";
    foreach($errors as $e) echo "<li>$e</li>";
    echo "</ul><a href='javascript:history.back()' class='btn'>Retornar</a></div>";
}

mysqli_autocommit($conexao, true);
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
