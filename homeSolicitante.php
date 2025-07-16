<?php
include("conecta.php");
$query = "SELECT * FROM solicitacao_itens where id_usuario = 1 AND status_solicitacao != 'Negado' GROUP BY id_solicitacao ORDER BY data_solicitacao ASC";
$result = mysqli_query($conexao,$query);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - Quartelaria</title>
</head>
<body>
    <h1> Solicitações atuais: </h1>


<?php
while($dados = mysqli_fetch_assoc($result)){
    $idItem = $dados['id_item'];
    $tipoItem = $dados['tipo_item'];
    if($tipoItem == 'armamento'){
        $queryItem = "SELECT nome_armamento FROM armamentos WHERE id_armamento = $idItem";
         $resultItem = mysqli_query($conexao,$queryItem);
        $dadosItem = mysqli_fetch_assoc($resultItem);
        $nomeItem = $dadosItem['nome_armamento'];
    }elseif($tipoItem == 'equipamento'){
        $queryItem = "SELECT nome_equipamento FROM equipamentos WHERE id_equipamento = $idItem";
         $resultItem = mysqli_query($conexao,$queryItem);
        $dadosItem = mysqli_fetch_assoc($resultItem);
        $nomeItem = $dadosItem['nome_equipamento'];
    }
   
    echo "Datas:
    Data de solicitação: {$dados['data_solicitacao']} <br>
    Data prevista de devolucao: {$dados['data_devolucao_item']}";
    echo "<table border='1'>
    <tr>
    <th>Item</th>
    <th>Tipo</th>
    <th>Quantidade</th>
    <th>Status</th>
    </tr>
    <tr>
    <td>$nomeItem</td>
    <td>{$dados['tipo_item']}</td>
    <td>{$dados['quantidade']}</td>
    <td>{$dados['status_solicitacao']}</td>
    </tr>
    </table>
    <br><hr>
    ";
    
}
?>


<strong>//Tabela//</strong><br>
itens | status<br>
a,b,c | Autorizado<br><br>
<a href="solicitarSolicitante.php">Realizar solicitação de itens</a><br>
<a href="checkListVtr.php">Realizar solicitação da viatura</a><br>
<a href="solicitacoesAnterioresSolicitante.php">Solicitações anteriores</a><br>

</body>
</html>
