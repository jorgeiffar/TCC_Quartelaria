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
$observacoes = $_POST['observacao'] ?? [];
$ids_solicitacao_itens = $_POST['id_solicitacao_itens'] ?? [];

if($id_solicitacao <= 0 || empty($ids_solicitacao_itens)){
    echo "Dados incompletos. Verifique id_solicitacao e itens.";
    exit();
}


// desativa autocommit
mysqli_autocommit($conexao, false);
$errors = [];

// 1) Atualizar status da solicitação (todos os itens)
$sql_status_items = "UPDATE solicitacao_itens SET status_solicitacao = 'Devolvido' WHERE id_solicitacao = $id_solicitacao";
if(!mysqli_query($conexao, $sql_status_items)){
    $errors[] = "Erro ao atualizar status dos itens: " . mysqli_error($conexao);
}

// 2) Para cada item
foreach($ids_solicitacao_itens as $index => $id_solicitacao_itens){

    $id_solicitacao_itens = (int)$id_solicitacao_itens;
    $obs_raw = $observacoes[$index] ?? '';
    $obs = mysqli_real_escape_string($conexao, $obs_raw);

    // Atualizar a observação
    $sql_obs = "UPDATE solicitacao_itens 
                SET observacao_item = '$obs' 
                WHERE id_solicitacao_itens = $id_solicitacao_itens";
    if(!mysqli_query($conexao, $sql_obs)){
        $errors[] = "Erro salvando observação (id_solicitacao_itens={$id_solicitacao_itens}): " . mysqli_error($conexao);
    }

    // Buscar dados do item
    $sql_sel = "SELECT id_item, tipo_item, quantidade 
                FROM solicitacao_itens 
                WHERE id_solicitacao_itens = $id_solicitacao_itens";
    $res_sel = mysqli_query($conexao, $sql_sel);
    if(!$res_sel || mysqli_num_rows($res_sel) == 0){
        $errors[] = "Item não encontrado na solicitacao_itens (id_solicitacao_itens={$id_solicitacao_itens}).";
        continue;
    }

    $row = mysqli_fetch_assoc($res_sel);
    $id_item = (int)$row['id_item'];
    $tipo_item = strtolower(trim($row['tipo_item'] ?? ''));
    $qtd = (int)($row['quantidade'] ?? 0);

    if(in_array($tipo_item, ['armamento','armamentos'])){
        // Atualizar status do armamento
        $sql_arm = "UPDATE armamentos SET status_armamento = 0 WHERE id_armamento = $id_item";
        if(!mysqli_query($conexao, $sql_arm)){
            $errors[] = "Erro atualizando armamento (id_armamento={$id_item}): " . mysqli_error($conexao);
        }
    } else {
        // Atualizar quantidade disponível de equipamento
        if($qtd > 0){
            $sql_eqp = "UPDATE equipamentos 
                        SET quantidade_disponivel_equipamento = quantidade_disponivel_equipamento - $qtd 
                        WHERE id_equipamento = $id_item";
            if(!mysqli_query($conexao, $sql_eqp)){
                $errors[] = "Erro atualizando equipamento (id_equipamento={$id_item}): " . mysqli_error($conexao);
            }
        }
    }
}

// Finalizar transação
if(!empty($errors)){
    mysqli_rollback($conexao);
    mysqli_autocommit($conexao, true);
    echo "<h3>Ocorreram erros — transação revertida:</h3><ul>";
    foreach($errors as $e){
        echo "<li>" . htmlspecialchars($e) . "</li>";
    }
    echo "</ul><a href='javascript:history.back()'>Voltar</a>";
    exit();
} else {
    mysqli_commit($conexao);
    mysqli_autocommit($conexao, true);
    echo "Devolução registrada com sucesso! <a href='homeQuarteleiro.php'>Voltar</a>";
    exit();
}
?>
