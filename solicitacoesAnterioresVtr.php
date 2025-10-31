<?php
include("conecta.php");
session_start();

if (!isset($_SESSION['id_usuario']) || $_SESSION['perfil_usuario'] != 1) {
    header("Location: login.php?status=nao_autorizado");
    exit();
}


$query_vtr = "SELECT 
 solicitacao_viatura.id_solicitacao_viatura, 
 solicitacao_viatura.data_solicitacao_viatura, 
 solicitacao_viatura.quilometragem, 
 solicitacao_viatura.placa_veiculo,
 solicitacao_viatura.status_solicitacao_viatura,
usuarios.nome_usuario
 FROM solicitacao_viatura
 JOIN usuarios ON solicitacao_viatura.id_usuario = usuarios.id_usuario
 WHERE solicitacao_viatura.status_solicitacao_viatura != 'Pendente' 
  AND solicitacao_viatura.status_solicitacao_viatura != 'Aceito'
  AND solicitacao_viatura.status_solicitacao_viatura != 'Ativo'
 ORDER BY solicitacao_viatura.data_solicitacao_viatura DESC";

$resultado_vtr = mysqli_query($conexao, $query_vtr);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Histórico de Checklists de Viatura</title>
</head>

<body>
    <a href="homeQuarteleiro.php">Voltar - Home</a>

    <h1>Histórico de Checklists de Viatura</h1>
    <hr> <h2>Checklists Anteriores</h2>
    <?php
    if (mysqli_num_rows($resultado_vtr) <= 0) {
        echo "Nenhum Histórico de Checklists de Viatura encontrado (Negado, Concluído, etc.).";
    } else {
        echo "<table border='1'>
 <tr>
 <th>Usuário</th>
 <th>Placa / KM</th>
 <th>Data/Hora Solicitação</th>
 <th>Status</th>
 <th>Opções</th>
 </tr>";

        while ($dados_vtr = mysqli_fetch_assoc($resultado_vtr)) {

            $id_vtr = $dados_vtr['id_solicitacao_viatura'];
            $nome_vtr = $dados_vtr['nome_usuario'];
            $placa_km = $dados_vtr['placa_veiculo'] . " / " . $dados_vtr['quilometragem'] . " km";
            $data_solicitacao_vtr = date("d/m/Y H:i", strtotime($dados_vtr['data_solicitacao_viatura']));
            $status_vtr = $dados_vtr['status_solicitacao_viatura'];

            echo "<tr>
 <td>$nome_vtr</td>
 <td>$placa_km</td>
 <td>$data_solicitacao_vtr</td>
 <td>$status_vtr</td>
 <td>
  <a href='detalhesVtr.php?id=$id_vtr&status=7'>Ver detalhes</a>
 </td>
</tr>";
        }

        echo "</table>";
    }
    ?>

</body>

</html>