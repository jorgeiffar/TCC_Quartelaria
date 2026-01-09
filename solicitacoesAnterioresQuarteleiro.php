<?php
include("conecta.php");

session_start();
if(!isset($_SESSION['id_usuario']) || $_SESSION['perfil_usuario'] != 1){
    header("Location: login.php?status=nao_autorizado");
    exit();
}

// Busca solicitações finalizadas/devolvidas com observação
$query = "SELECT si.id_solicitacao, si.data_solicitacao, si.data_devolucao_item, si.data_devolucao_real_item, 
                 si.status_solicitacao, si.observacao_item,
                 u.nome_usuario, si.tipo_item, si.id_item,
                 e.nome_equipamento, e.tipo_equipamento,
                 a.nome_armamento, a.tipo_armamento
          FROM solicitacao_itens si
          JOIN usuarios u ON si.id_usuario = u.id_usuario
          LEFT JOIN equipamentos e ON si.id_item = e.id_equipamento AND si.tipo_item = 'equipamento'
          LEFT JOIN armamentos a ON si.id_item = a.id_armamento AND si.tipo_item = 'armamento'
          WHERE si.status_solicitacao IN ('Devolvido', 'Finalizado')
          ORDER BY si.id_solicitacao DESC";

$resultado = mysqli_query($conexao, $query);

$id_atual = 0;
$equipamentos = "";
$armamentos = "";
$observacoes = "";  // Acumula observações de armamentos
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Solicitações Anteriores - Quartelaria</title>
    <link rel="stylesheet" href="style.css?v=2">
</head>
<body>

<div class="bg-fallback"></div>

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
    <h1>Solicitações Anteriores</h1>


    <table class="tabela">
        <tr>
            <th>Usuário</th>
            <th>Equipamentos</th>
            <th>Armamentos</th>
            <th>Data Solicitação</th>
            <th>Data Prevista</th>
            <th>Data Devolução Real</th>
            <th>Observações</th>
            <th>Status</th>
        </tr>

    <?php
    while ($dados = mysqli_fetch_assoc($resultado)) {
        $id = $dados['id_solicitacao'];

        // Quando muda de solicitação, imprime a anterior
        if ($id != $id_atual && $id_atual != 0) {
            echo "<tr>
                    <td>$nome</td>
                    <td>$equipamentos</td>
                    <td>$armamentos</td>
                    <td>$data_solicitacao</td>
                    <td>$data_prevista</td>
                    <td>$data_real</td>
                    <td>$observacoes</td>
                    <td>$status</td>
                  </tr>";

            // Limpa acumuladores
            $equipamentos = "";
            $armamentos = "";
            $observacoes = "";
        }

        // Atualiza dados principais da solicitação
        if ($id != $id_atual) {
            $id_atual = $id;
            $nome = $dados['nome_usuario'];
            $data_solicitacao = date("d/m/Y", strtotime($dados['data_solicitacao']));
            $data_prevista = $dados['data_devolucao_item'] ? date("d/m/Y", strtotime($dados['data_devolucao_item'])) : "-";
            $data_real = $dados['data_devolucao_real_item'] ? date("d/m/Y", strtotime($dados['data_devolucao_real_item'])) : "-";
            $status = $dados['status_solicitacao'];
        }

        // Acumula itens
        if ($dados['tipo_item'] == 'equipamento') {
            $equipamentos .= $dados['tipo_equipamento'] . " - " . $dados['nome_equipamento'] . "<br>";
        } 
        elseif ($dados['tipo_item'] == 'armamento') {
            $nome_arm = $dados['nome_armamento'];
            $tipo_arm = $dados['tipo_armamento'];
            $obs = trim($dados['observacao_item']);

            $armamentos .= $tipo_arm . " - " . $nome_arm . "<br>";

            if (!empty($obs)) {
                $obs_segura = htmlspecialchars($obs, ENT_QUOTES, 'UTF-8');
                $observacoes .= "$tipo_arm - $nome_arm: $obs_segura<br>";
            }
        }
    }

    if ($id_atual != 0) {
        echo "<tr>
                <td>$nome</td>
                <td>$equipamentos</td>
                <td>$armamentos</td>
                <td>$data_solicitacao</td>
                <td>$data_prevista</td>
                <td>$data_real</td>
                <td>$observacoes</td>
                <td>$status</td>
              </tr>";
    }
    ?>
    </table>
</div>

<footer>
    &copy; <?php echo date("Y"); ?> COMMANDER - Todos os direitos reservados.
</footer>

</body>
</html>
