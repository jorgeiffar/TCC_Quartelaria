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
    <link rel="stylesheet" href="style.css?v=2">
</head>

<body>
    <nav>
              <div class="logo"><a href="homeQuarteleiro.php"><img src="./img/home.png" alt="Home" style="width: 28px; vertical-align: middle-top;"><span> COMMANDER</span></a></div>

      <ul>
        <li><a href="equipamentos.php" class="ativo">Equipamentos / Armamentos</a></li>
        <li><a href="operacoes.php">Operações</a></li>
        <li><a href="solicitacoesQuarteleiro.php">Solicitações</a></li>
        <li><a href="solicitacoesVtr.php">Solicitações Viatura</a></li>
        <li><a href="solicitarSolicitante.php">Solicitação Direta</a></li>
        <li><a href="listarUsuarios.php">Usuários</a></li>
        <li><a href="cadastrarQuarteleiro.php">Cadastrar Quarteleiro</a></li>
        <li><a href="editarPerfil.php">Perfil</a></li>
        <li><a href="logout.php"><img src="./img/logout.png" alt="Logout" style="width: 30px; height: 30px; vertical-align: middle;"></a></li>
      </ul>
    </nav>
    <div class="container">
    

        <div class="titulo-principal">
            <h1>Histórico de Checklists de Viatura</h1>
            <hr>
            <h2>Checklists Anteriores</h2>
        </div>

        <div class="conteudo-tabela">
            <?php
            if (mysqli_num_rows($resultado_vtr) <= 0) {
                echo "<p class='aviso-vazio'>Nenhum Histórico de Checklists de Viatura encontrado (Negado, Concluído, etc.).</p>";
            } else {
                echo "<table border='1' class='tabela-historico'>
                        <thead>
                            <tr>
                                <th>Usuário</th>
                                <th>Placa / KM</th>
                                <th>Data/Hora Solicitação</th>
                                <th>Status</th>
                                <th>Opções</th>
                            </tr>
                        </thead>
                        <tbody>";

                while ($dados_vtr = mysqli_fetch_assoc($resultado_vtr)) {

                    $id_vtr = $dados_vtr['id_solicitacao_viatura'];
                    $nome_vtr = $dados_vtr['nome_usuario'];
                    $placa_km = $dados_vtr['placa_veiculo'] . " / " . $dados_vtr['quilometragem'] . " km";
                    $data_solicitacao_vtr = date("d/m/Y H:i", strtotime($dados_vtr['data_solicitacao_viatura']));
                    $status_vtr = $dados_vtr['status_solicitacao_viatura'];

                    echo "<tr class='linha-status " . strtolower($status_vtr) . "'>
                            <td>$nome_vtr</td>
                            <td>$placa_km</td>
                            <td>$data_solicitacao_vtr</td>
                            <td>$status_vtr</td>
                            <td>
                                <a href='detalhesVtr.php?id=$id_vtr&status=7' class='btn-detalhes'>Ver detalhes</a>
                            </td>
                          </tr>";
                }

                echo "  </tbody>
                      </table>";
            }
            ?>
        </div>
    </div>
</body>
</html>
