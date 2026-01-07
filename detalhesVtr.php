<?php
include("conecta.php");
session_start();

// Verificação de Acesso
if (!isset($_SESSION['id_usuario']) || $_SESSION['perfil_usuario'] != 1) {
    header("Location: login.php?status=nao_autorizado");
    exit();
}

// Coleta e Validação do ID da Solicitação
if (!isset($_GET['id'])) {
    header("Location: homeQuarteleiro.php?erro=id_invalido");
    exit();
}

$id_solicitacao = $_GET['id'];

// Consulta Principal (Dados da Solicitação e do Solicitante)
$query_principal = "SELECT 
    solicitacao_viatura.*, 
    usuarios.nome_usuario
FROM solicitacao_viatura
JOIN usuarios ON solicitacao_viatura.id_usuario = usuarios.id_usuario
WHERE solicitacao_viatura.id_solicitacao_viatura = '{$id_solicitacao}' 
LIMIT 1";

$resultado_principal = mysqli_query($conexao, $query_principal);

if (mysqli_num_rows($resultado_principal) == 0) {
    header("Location: homeQuarteleiro.php?erro=solicitacao_nao_encontrada");
    exit();
}

$solicitacao = mysqli_fetch_assoc($resultado_principal);

// Consulta dos Detalhes (Itens do Checklist)
$query_detalhes = "SELECT 
    resultado_checklist_viatura.qap, 
    resultado_checklist_viatura.observacao_item, 
    itens_checklist.nome_item, 
    itens_checklist.descricao_item
FROM resultado_checklist_viatura
JOIN itens_checklist ON resultado_checklist_viatura.id_item = itens_checklist.id_item
WHERE resultado_checklist_viatura.id_solicitacao_viatura = '{$id_solicitacao}'
ORDER BY itens_checklist.nome_item ASC";

$resultado_detalhes = mysqli_query($conexao, $query_detalhes);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Detalhes Checklist #<?= $id_solicitacao ?></title>
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
            <h1>Detalhes do Checklist de Viatura #<?= $id_solicitacao ?></h1>
            <hr>
        </div>

        <div class="secao solicitacao-info">
            <h2>Informações da Solicitação</h2>
            <p><strong>Solicitante:</strong> <?= $solicitacao['nome_usuario'] ?></p>
            <p><strong>Data/Hora da Solicitação:</strong> <?= date('d/m/Y H:i:s', strtotime($solicitacao['data_solicitacao_viatura'])) ?></p>
            <p><strong>Status Atual:</strong> <strong><?= $solicitacao['status_solicitacao_viatura'] ?></strong></p>
            <hr>
        </div>

        <div class="secao viatura-info">
            <h2>Dados da Viatura</h2>
            <p><strong>Placa do Veículo:</strong> <strong><?= $solicitacao['placa_veiculo'] ?></strong></p>
            <p><strong>Quilometragem:</strong> <?= $solicitacao['quilometragem'] ?> km</p>
            <p><strong>Observações Gerais:</strong> <?= empty($solicitacao['observacoes_viatura']) ? 'N/A' : $solicitacao['observacoes_viatura'] ?></p>
            <hr>
        </div>

        <div class="secao checklist-itens">
            <h2>Itens Verificados no Checklist</h2>
            <table border="1" class="tabela-checklist">
                <thead>
                    <tr>
                        <th>Item</th>
                        <th>Descrição</th>
                        <th>QAP (OK)</th>
                        <th>Observação do Solicitante</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($resultado_detalhes && mysqli_num_rows($resultado_detalhes) > 0): ?>
                        <?php while($item = mysqli_fetch_assoc($resultado_detalhes)): ?>
                            <tr class="<?= $item['qap'] == 0 ? 'item-problema' : 'item-ok' ?>">
                                <td><?= $item['nome_item'] ?></td>
                                <td><?= empty($item['descricao_item']) ? 'N/A' : $item['descricao_item'] ?></td>
                                <td><?= $item['qap'] == 1 ? 'Sim' : 'Não' ?></td>
                                <td><?= empty($item['observacao_item']) ? 'N/A' : $item['observacao_item'] ?></td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4">Nenhum item de checklist encontrado.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

    </div>
</body>
</html>
