<?php
include("conecta.php"); 
session_start();


if(!isset($_SESSION['id_usuario'])){
    header("Location: login.php?status=nao_autorizado");
    exit();
}

$id_usuario = $_SESSION['id_usuario'];
$km = $_POST['km'];
$placa = strtoupper($_POST['placa']);//deixa tudo maiusculo
$datahora_br = $_POST['datahora'];
$itens_form = $_POST['itens'] ?? [];

// Converte a data/hora do formato brasileiro (d/m/Y H:i:s) para o formato do MySQL (Y-m-d H:i:s)
$data_mysql = DateTime::createFromFormat('d/m/Y H:i:s', $datahora_br)->format('Y-m-d H:i:s');

//Inserção do Checklist Principal (Tabela solicitacao_viatura)
// O campo 'observacoes_viatura' não foi preenchido no formulário, então vou deixar vazio ('')
$sql_principal = "INSERT INTO solicitacao_viatura (
    id_usuario, 
    data_solicitacao_viatura, 
    quilometragem, 
    placa_veiculo, 
    observacoes_viatura, 
    status_solicitacao_viatura
) VALUES (
    '{$id_usuario}', 
    '{$data_mysql}', 
    '{$km}', 
    '{$placa}', 
    '', 
    'Pendente' 
)"; // Assume status inicial como PENDENTE

$resultado_principal = mysqli_query($conexao, $sql_principal);

if ($resultado_principal) {
    // Obtém o ID da solicitação principal recem inserida
    $id_solicitacao = mysqli_insert_id($conexao);

    //Inserção dos Detalhes dos Itens (Tabela resultado_checklist_viatura)

    // Antes de inserir os detalhes, precisamos do id_item para cada nome_item
    foreach ($itens_form as $nome_item => $dados) {
        
        // "Limpa" os dados do item
        $qap = $dados['qap']; // '1' para OK, '0' para NÃO OK
        $obs = $dados['obs'] ?? '';
        
        //Busca o id_item na tabela itens_checklist usando o nome_item
        $sql_busca_id = "SELECT id_item FROM itens_checklist WHERE nome_item = '{$nome_item}'";
        $resultado_id = mysqli_query($conexao, $sql_busca_id);
        
        // Verifica se o item foi encontrado
        if ($resultado_id && mysqli_num_rows($resultado_id) > 0) {
            $item_data = mysqli_fetch_assoc($resultado_id);
            $id_item = $item_data['id_item'];
            
            //Insere o detalhe do item
            $sql_detalhes = "INSERT INTO resultado_checklist_viatura (
                id_solicitacao_viatura, 
                id_item, 
                qap, 
                observacao_item
            ) VALUES (
                '{$id_solicitacao}', 
                '{$id_item}', 
                '{$qap}', 
                '{$obs}'
            )";
            
            if (!mysqli_query($conexao, $sql_detalhes)) {
                
            }
        }
    }

    // Sucesso
    header("Location: homeSolicitante.php");
    exit();

}
?>