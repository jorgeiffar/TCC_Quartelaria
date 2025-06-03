<?php
include("conecta.php");

$id_usuario = "Definir conexao(criarlogin)"; 
$id_equipamento = $_POST['id_equipamento'];
$id_armamento = $_POST['id_armamento'];
$motivo = $_POST['motivo_solicitacao'];
$data_solicitacao = date('Y-m-d H:i:s');
$data_devolucao =$_POST['data_devolucao_item'];
$status = 'Pendente';


$sql = "
    INSERT INTO solicitacao_itens (
        id_usuario,
        id_equipamento,
        id_armamento,
        motivo_solicitacao,
        data_solicitacao,
        data_devolucao_item,
        status_solicitacao
    ) VALUES (
        $id_usuario,
        $id_equipamento,
        $id_armamento,
        '$motivo',
        '$data_solicitacao',
        '$data_devolucao',
        '$status'
    )
";

if (mysqli_query($conexao, $sql)) {
    echo "Solicitação enviada com sucesso!";
} else {
    echo "Erro ao solicitar: " . mysqli_error($conexao);
}

?>
