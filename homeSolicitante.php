<?php
include("conecta.php");
session_start();
if(!isset($_SESSION['id_usuario'])){
    header("Location: login.php?status=nao_autorizado");
    exit();
}
$query = "SELECT solicitacao_itens.*, 
COALESCE(armamentos.nome_armamento, equipamentos.nome_equipamento) AS nome_item, armamentos.codigo_armamento
FROM solicitacao_itens
LEFT JOIN armamentos ON solicitacao_itens.id_item = armamentos.id_armamento AND solicitacao_itens.tipo_item = 'armamento'
LEFT JOIN equipamentos ON solicitacao_itens.id_item = equipamentos.id_equipamento AND solicitacao_itens.tipo_item = 'equipamento'
WHERE solicitacao_itens.id_usuario = {$_SESSION['id_usuario']} AND solicitacao_itens.status_solicitacao != 'Negado' AND solicitacao_itens.status_solicitacao != 'Devolvido'
ORDER BY solicitacao_itens.data_solicitacao ASC";
$result = mysqli_query($conexao,$query);

$solicitacoes =[];

while($dados = mysqli_fetch_assoc($result)){
    $idSolicitacao = $dados['id_solicitacao'];
    if(!isset($solicitacoes[$idSolicitacao])){
        $solicitacoes[$idSolicitacao] = [
            'data_solicitacao' => $dados['data_solicitacao'],
            'data_devolucao' => $dados['data_devolucao_item'],
            'status_solicitacao' => $dados['status_solicitacao'],
            'itens' => []
        ];
    }
    $solicitacoes[$idSolicitacao]['itens'][] = [
        'nome' => $dados['nome_item'],
        'tipo' => $dados['tipo_item'],
        'codigo' => $dados['codigo_armamento'],
        'quantidade' => $dados['quantidade']
    ];
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - Quartelaria</title>
</head>
<body>
    <a href="solicitarSolicitante.php">Realizar solicitação de itens</a> |
<a href="checkListVtr.php">Realizar solicitação da viatura</a> |
<a href="solicitacoesAnterioresSolicitante.php">Solicitações anteriores</a> |
<a href="logout.php">Logout ->|</a>
    <h1> Solicitações atuais: </h1>


<?php
foreach($solicitacoes as $idSolicitacao => $solicitacao){
    echo "<h3> Solicitacao #$idSolicitacao </h3>
    Data de solicitação: {$solicitacao['data_solicitacao']}<br>
    Data prevista de devolução: {$solicitacao['data_devolucao']}<br>
    Status: {$solicitacao['status_solicitacao']}
    ";

    echo "<table border ='1'>
    <tr>
    <th>Item</th>
    <th>Código</th>
    <th>Tipo</th>
    <th>Quantidade</th>
    </tr>
    ";
foreach($solicitacao['itens'] as $item){
    echo "
    <tr>
    <td>{$item['nome']}</td>
    <td>";
    if($item['tipo'] == 'armamento'){
        echo "{$item['codigo']}";
    } elseif($item['tipo'] == 'equipamento'){
        echo "X";
    }
    echo "</td>
    <td>{$item['tipo']}</td>
    <td>{$item['quantidade']}</td>
    </tr>
    ";
}
echo "</table><hr>";
}
?>

</body>
</html>
