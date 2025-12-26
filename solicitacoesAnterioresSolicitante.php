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
WHERE solicitacao_itens.id_usuario = {$_SESSION['id_usuario']} 
AND (solicitacao_itens.status_solicitacao = 'Negado' OR solicitacao_itens.status_solicitacao = 'Devolvido')
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
    <title>Solicitações Anteriores - Quartelaria</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header>
    <nav>
        <div class="logo"><a href="homeSolicitante.php"><img src="./img/home.png" alt="Home" style="width: 28px; vertical-align: middle-top;"><span> COMMANDER</span></a></div>
        <ul>
            <li><a href="solicitarSolicitante.php">Solicitar Itens</a></li>
            <li><a href="checkListVtr.php">Solicitar Viatura</a></li>
            <li><a href="solicitacoesAnterioresSolicitante.php" class="ativo">Solicitações Anteriores</a></li>
            <li><a href="editarPerfil.php">Perfil</a></li>
            <li><a href="logout.php"><img src="./img/logout.png" alt="Logout" style="width: 30px; height: 30px; vertical-align: middle;"></a></li>
        </ul>
    </nav>
</header>

<main class="container">

    <section>
        <h1>Solicitações Anteriores</h1>
        <hr>

        <div class="card">
            <?php if(empty($solicitacoes)): ?>
                <p>Nenhuma solicitação anterior encontrada.</p>
            <?php else: ?>
                <?php foreach($solicitacoes as $idSolicitacao => $solicitacao): ?>
                    <h3>Solicitação #<?php echo $idSolicitacao; ?></h3>
                    Data de solicitação: <?php echo $solicitacao['data_solicitacao']; ?><br>
                    Data prevista de devolução: <?php echo $solicitacao['data_devolucao']; ?><br>
                    Status: <?php echo $solicitacao['status_solicitacao']; ?>

                    <table border='1'>
                        <tr>
                            <th>Item</th>
                            <th>Código</th>
                            <th>Tipo</th>
                            <th>Quantidade</th>
                        </tr>
                        <?php foreach($solicitacao['itens'] as $item): ?>
                        <tr>
                            <td><?php echo $item['nome']; ?></td>
                            <td>
                                <?php 
                                if($item['tipo'] == 'armamento'){
                                    echo $item['codigo'];
                                } elseif($item['tipo'] == 'equipamento'){
                                    echo "X";
                                }
                                ?>
                            </td>
                            <td><?php echo $item['tipo']; ?></td>
                            <td><?php echo $item['quantidade']; ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                    <hr>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </section>

</main>

<footer>
    &copy; <?php echo date("Y"); ?> COMMANDER - Sistema de Gerenciamento de Quartelaria
</footer>

</body>
</html>