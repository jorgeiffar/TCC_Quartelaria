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
$query_vtr = "SELECT id_solicitacao_viatura, data_solicitacao_viatura, quilometragem, placa_veiculo, status_solicitacao_viatura 
              FROM solicitacao_viatura
              WHERE id_usuario = {$_SESSION['id_usuario']} 
              AND status_solicitacao_viatura != 'Negado' 
              AND status_solicitacao_viatura != 'Devolvido'
              ORDER BY data_solicitacao_viatura DESC";

$result_vtr = mysqli_query($conexao, $query_vtr);

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
<a href="solicitacoesAnterioresSolicitante.php">Solicitações anteriores</a> |==========|
<a href="editarPerfil.php">Editar Perfil</a> |
<a href="logout.php">Logout ->|</a>
    <h1> Solicitações atuais: </h1>


<?php
if(mysqli_num_rows($result) <= 0){
    echo "Nenhuma solicitação ativa no momento";
}else{
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
}}
?>
<hr>
<h2>Checklists de Viatura Ativos</h2>
<?php
if($result_vtr === false || mysqli_num_rows($result_vtr) === 0){
    echo "Nenhum checklist de viatura ativo no momento.";
} else {
    // Início da Tabela
    echo "<table border='1'>
          <thead>
              <tr>
                  <th>ID Solicitação</th>
                  <th>Placa da Viatura</th>
                  <th>Quilometragem</th>
                  <th>Data/Hora Solicitação</th>
                  <th>Status</th>
              </tr>
          </thead>
          <tbody>";
          
    // Loop principal: usa fetch_assoc para buscar uma linha por vez
    while($vtr = mysqli_fetch_assoc($result_vtr)){
        
        // Formata data e hora para exibição
        $data_hora = date('d/m/Y H:i', strtotime($vtr['data_solicitacao_viatura']));
        
        echo "<tr>
                <td>{$vtr['id_solicitacao_viatura']}</td>
                <td>{$vtr['placa_veiculo']}</td>
                <td>{$vtr['quilometragem']} km</td>
                <td>{$data_hora}</td>
                <td><strong>{$vtr['status_solicitacao_viatura']}</strong></td>
              </tr>";
    }
    
    echo "</tbody>
          </table>
          <hr>";
}?>
</body>
</html>
