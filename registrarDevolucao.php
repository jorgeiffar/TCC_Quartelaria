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
$ids_item = $_POST['id_item'] ?? []; // IDs reais dos equipamentos/armamentos

if($id_solicitacao <= 0 || empty($ids_solicitacao_itens) || empty($ids_item)){
    echo "Dados incompletos. Verifique id_solicitacao, itens e ids dos equipamentos.";
    exit();
}

// garantir arrays paralelos (usa o menor comprimento)
$len = min(count($ids_solicitacao_itens), count($ids_item), count($observacoes));
if($len === 0){
    echo "Nenhum item válido enviado.";
    exit();
}

// desativa autocommit
mysqli_autocommit($conexao, false);
$errors = [];

// 1) Atualizar status de todos os itens da solicitação (prepared)
$sql_status_items = "UPDATE solicitacao_itens SET status_solicitacao = 'Devolvido' WHERE id_solicitacao = ?";
$stmt_status = mysqli_prepare($conexao, $sql_status_items);
if(!$stmt_status){
    echo "Erro ao preparar atualização de status: " . mysqli_error($conexao);
    exit();
}
mysqli_stmt_bind_param($stmt_status, "i", $id_solicitacao);
if(!mysqli_stmt_execute($stmt_status)){
    $errors[] = "Erro ao atualizar status dos itens: " . mysqli_stmt_error($stmt_status);
}
mysqli_stmt_close($stmt_status);

// Prepared statements reaproveitáveis
$stmt_select_item = mysqli_prepare($conexao, "SELECT tipo_item, quantidade FROM solicitacao_itens WHERE id_solicitacao_itens = ?");
$stmt_update_arm = mysqli_prepare($conexao, "UPDATE armamentos SET status_armamento = 0 WHERE id_armamento = ?");
$stmt_check_arm = mysqli_prepare($conexao, "SELECT 1 FROM armamentos WHERE id_armamento = ?");
$stmt_check_eqp = mysqli_prepare($conexao, "SELECT quantidade_disponivel_equipamento FROM equipamentos WHERE id_equipamento = ?");
$stmt_update_eqp = mysqli_prepare($conexao, "UPDATE equipamentos SET quantidade_disponivel_equipamento = quantidade_disponivel_equipamento - ? WHERE id_equipamento = ? AND quantidade_disponivel_equipamento >= ?");

if(!$stmt_select_item || !$stmt_update_arm || !$stmt_check_arm || !$stmt_check_eqp || !$stmt_update_eqp){
    $errors[] = "Erro ao preparar statements: " . mysqli_error($conexao);
}

// Loop pelos itens (usando indices para manter paralelo com id_item e observacao)
for($i = 0; $i < $len; $i++){
    $id_solicitacao_item = (int)$ids_solicitacao_itens[$i];
    $id_item = (int)$ids_item[$i];
    $obs_raw = $observacoes[$i] ?? '';
    $obs = trim($obs_raw);

    if($id_item <= 0 || $id_solicitacao_item <= 0){
        $errors[] = "IDs inválidos no índice {$i}.";
        continue;
    }

    // Atualizar observação (se houver)
    if($obs !== ''){
        $sql_obs = "UPDATE solicitacao_itens SET observacao_item = ? WHERE id_solicitacao_itens = ?";
        $sobs = mysqli_prepare($conexao, $sql_obs);
        if($sobs){
            mysqli_stmt_bind_param($sobs, "si", $obs, $id_solicitacao_item);
            mysqli_stmt_execute($sobs);
            if(mysqli_stmt_errno($sobs)){
                $errors[] = "Erro salvando observação (item={$id_solicitacao_item}): " . mysqli_stmt_error($sobs);
            }
            mysqli_stmt_close($sobs);
        } else {
            $errors[] = "Erro ao preparar update de observação: " . mysqli_error($conexao);
        }
    }

    // Buscar tipo_item e quantidade para decidir ação
    mysqli_stmt_bind_param($stmt_select_item, "i", $id_solicitacao_item);
    mysqli_stmt_execute($stmt_select_item);
    $res_item = mysqli_stmt_get_result($stmt_select_item);
    if(!$res_item || mysqli_num_rows($res_item) === 0){
        $errors[] = "Não foi possível recuperar tipo/quantidade para id_solicitacao_itens={$id_solicitacao_item}.";
        continue;
    }
    $row = mysqli_fetch_assoc($res_item);
    $tipo_item = strtolower(trim($row['tipo_item'] ?? ''));
    $qtd = (int)($row['quantidade'] ?? 0);

    // Decisão tolerante: tenta na tabela preferida pelo tipo, mas faz fallback
    $tried_arm = false;
    $tried_eqp = false;

    // função auxiliar para checar e atualizar armamento
    $do_armamento = function($conexao, $id_item, &$errors) use ($stmt_check_arm, $stmt_update_arm, &$tried_arm) {
        $tried_arm = true;
        mysqli_stmt_bind_param($stmt_check_arm, "i", $id_item);
        mysqli_stmt_execute($stmt_check_arm);
        $reschk = mysqli_stmt_get_result($stmt_check_arm);
        $exists = ($reschk && mysqli_num_rows($reschk) > 0);
        if($exists){
            mysqli_stmt_bind_param($stmt_update_arm, "i", $id_item);
            mysqli_stmt_execute($stmt_update_arm);
            if(mysqli_stmt_affected_rows($stmt_update_arm) === 0){
                $errors[] = "Armamento não atualizado (id={$id_item}).";
            }
            return true;
        }
        return false;
    };

    // função auxiliar para checar e atualizar equipamento (subtrai "fora")
    $do_equipamento = function($conexao, $id_item, $qtd, &$errors) use ($stmt_check_eqp, $stmt_update_eqp, &$tried_eqp) {
        $tried_eqp = true;
        mysqli_stmt_bind_param($stmt_check_eqp, "i", $id_item);
        mysqli_stmt_execute($stmt_check_eqp);
        $reschk = mysqli_stmt_get_result($stmt_check_eqp);
        $rowq = $reschk ? mysqli_fetch_assoc($reschk) : null;
        if($rowq){
            $cur = (int)$rowq['quantidade_disponivel_equipamento'];
            if($qtd <= 0){
                // nada a fazer
                return true;
            }
            // evita underflow: só subtrai se cur >= qtd
            if($cur >= $qtd){
                mysqli_stmt_bind_param($stmt_update_eqp, "iii", $qtd, $id_item, $qtd);
                mysqli_stmt_execute($stmt_update_eqp);
                if(mysqli_stmt_affected_rows($stmt_update_eqp) === 0){
                    $errors[] = "Falha ao subtrair equipamento (id={$id_item}).";
                }
                return true;
            } else {
                $errors[] = "Quantidade insuficiente no equipamento (id={$id_item}). Atual: {$cur}, tentativa de devolver: {$qtd}.";
                return false;
            }
        }
        return false;
    };

    // preferência por tipo declarado, mas com fallback
    if(stripos($tipo_item, 'arm') !== false){
        // tenta armamento primeiro
        $ok = $do_armamento($conexao, $id_item, $errors);
        if(!$ok){
            // fallback para equipamento
            $ok2 = $do_equipamento($conexao, $id_item, $qtd, $errors);
            if(!$ok2){
                $errors[] = "Item id={$id_item} não encontrado como armamento nem equipamento (preferência: armamento).";
            }
        }
    }
    elseif(stripos($tipo_item, 'equip') !== false || stripos($tipo_item, 'mun') !== false || $tipo_item === 'equipamento'){
        // tenta equipamento primeiro
        $ok = $do_equipamento($conexao, $id_item, $qtd, $errors);
        if(!$ok){
            // fallback para armamento
            $ok2 = $do_armamento($conexao, $id_item, $errors);
            if(!$ok2){
                $errors[] = "Item id={$id_item} não encontrado como equipamento nem armamento (preferência: equipamento).";
            }
        }
    } else {
        // tipo indefinido: tenta armamento então equipamento
        $ok = $do_armamento($conexao, $id_item, $errors);
        if(!$ok){
            $ok2 = $do_equipamento($conexao, $id_item, $qtd, $errors);
            if(!$ok2){
                $errors[] = "Item id={$id_item} não encontrado em nenhuma tabela (tipo desconhecido: '{$tipo_item}').";
            }
        }
    }
}

// fechar statements
if($stmt_select_item) mysqli_stmt_close($stmt_select_item);
if($stmt_update_arm) mysqli_stmt_close($stmt_update_arm);
if($stmt_check_arm) mysqli_stmt_close($stmt_check_arm);
if($stmt_check_eqp) mysqli_stmt_close($stmt_check_eqp);
if($stmt_update_eqp) mysqli_stmt_close($stmt_update_eqp);

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
