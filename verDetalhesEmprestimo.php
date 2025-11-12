<?php
session_start();
if(!isset($_SESSION['id_usuario'])){
    header("Location: login.php?status=nao_autorizado");
    exit();
}

include("conecta.php");

$id_solicitacao = $_GET['id'] ?? null;

if(!$id_solicitacao){
    echo "Empréstimo não especificado!";
    exit();
}

$sql_itens = "SELECT * FROM solicitacao_itens WHERE id_solicitacao = $id_solicitacao";
$result_itens = mysqli_query($conexao, $sql_itens);

if(mysqli_num_rows($result_itens) == 0){
    echo "Nenhum empréstimo encontrado!";
    exit();
}

// 1° item p descobrir o id_usuario da solicitação
$item_exemplo = mysqli_fetch_assoc($result_itens);
$id_usuario_solicitante = $item_exemplo['id_usuario'];

$sql_usuario = "SELECT nome_usuario FROM usuarios WHERE id_usuario = $id_usuario_solicitante";
$result_usuario = mysqli_query($conexao, $sql_usuario);
$usuario = mysqli_fetch_assoc($result_usuario);

$result_itens = mysqli_query($conexao, $sql_itens);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalhes Empréstimo - Quartelaria</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header class="topo">
        <nav class="navbar">
             <div class="logo" ><a href="homeQuarteleiro.php">Commander</a></div>
    <ul>
      <li><a href="equipamentos.php" class="ativo">Equipamentos / Armamentos</a></li>
      <li><a href="operacoes.php">Operações</a></li>
      <li><a href="solicitacoesQuarteleiro.php">Solicitações</a></li>
      <li><a href="solicitacoesVtr.php">Solicitações Viatura</a></li>
      <li><a href="solicitarSolicitante.php">Solicitação Direta</a></li>
      <li><a href="listarUsuarios.php">Usuários</a></li>
      <li><a href="cadastrarQuarteleiro.php">Cadastrar Quarteleiro</a></li>
      <li><a href="editarPerfil.php">Perfil</a></li>
      <li><a href="logout.php">Logout</a></li>
    </ul>
        </nav>
    </header>

    <main class="container">
        <section class="conteudo">
            <h1>Detalhes do Empréstimo</h1>
            <h2>Solicitante: <i><?= $usuario['nome_usuario'] ?></i></h2>

            <div class="tabela-container">
                <h3>Itens</h3>
                <table class="tabela">
                    <thead>
                        <tr>
                            <th>Nome do Item</th>
                            <th>Código</th>
                            <th>Quantidade</th>
                            <th>Tipo</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($item = mysqli_fetch_assoc($result_itens)){
                            if($item['tipo_item'] == 'armamento'){
                                $sqlQtd = "SELECT quantidade FROM solicitacao_itens WHERE id_item = ".$item['id_item'];
                                $resultQtd = mysqli_query($conexao, $sqlQtd);
                                $detalheQtd = mysqli_fetch_assoc($resultQtd);

                                $sql_det = "SELECT nome_armamento, codigo_armamento FROM armamentos WHERE id_armamento = ".$item['id_item'];
                                $result_det = mysqli_query($conexao, $sql_det);
                                $detalhe = mysqli_fetch_assoc($result_det);
                            
                                echo "<tr>
                                    <td> {$detalhe['nome_armamento']} </td>
                                    <td> {$detalhe['codigo_armamento']} </td>
                                    <td> {$detalheQtd['quantidade']} </td>
                                    <td> {$item['tipo_item']}</td>
                                </tr>"; 
                            
                            } else {
                                $sqlQtd = "SELECT quantidade FROM solicitacao_itens WHERE id_item = ".$item['id_item'];
                                $resultQtd = mysqli_query($conexao, $sqlQtd);
                                $detalheQtd = mysqli_fetch_assoc($resultQtd);

                                $sql_det = "SELECT nome_equipamento FROM equipamentos WHERE id_equipamento = ".$item['id_item'];
                                $result_det = mysqli_query($conexao, $sql_det);
                                $detalhe = mysqli_fetch_assoc($result_det);

                                echo "<tr>
                                    <td> {$detalhe['nome_equipamento']} </td>
                                    <td> X </td>
                                    <td> {$detalheQtd['quantidade']} </td>
                                    <td> {$item['tipo_item']}</td>
                                </tr>"; 
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>

            <form action="" method="get" class="form-acao">
                <input type="hidden" name="observacao" value="1">
                <input type="hidden" name="id" value="<?= $id_solicitacao ?>">
                <button type="submit" class="btn">Marcar como devolvido</button>
            </form>

            <?php
            if(isset($_GET['observacao'])){
                $result_itens = mysqli_query($conexao, $sql_itens);
                ?>
                <div class="form-devolucao">
                    <hr>
                    <form action="registrarDevolucao.php" method="post">
                        <table class="tabela">
                            <thead>
                                <tr>
                                    <th>Nome do Item</th>
                                    <th>Código</th>
                                    <th>Observação</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while($item = mysqli_fetch_assoc($result_itens))
                                   if($item['tipo_item'] == 'armamento'){
                                $sqlQtd = "SELECT quantidade FROM solicitacao_itens WHERE id_item = ".$item['id_item'];
                                $resultQtd = mysqli_query($conexao, $sqlQtd);
                                $detalheQtd = mysqli_fetch_assoc($resultQtd);
                                
                                $sql_det = "SELECT nome_armamento, codigo_armamento FROM armamentos WHERE id_armamento = ".$item['id_item'];
                                $result_det = mysqli_query($conexao, $sql_det);
                                $detalhe = mysqli_fetch_assoc($result_det);

                                echo "<tr>
                                        <td> {$detalhe['nome_armamento']} </td>
                                        <td> {$detalhe['codigo_armamento']}</td>
                                        <td><input type=\"text\" name=\"observacao[]\" class=\"input-observacao\"></td>
                                    </tr>
                                    <input type=\"hidden\" name=\"id_item[]\" value=\"{$item['id_item']}\">
                                    <input type=\"hidden\" name=\"id_solicitacao_itens[]\" value=\"{$item['id_solicitacao_itens']}\">
                                    <input type=\"hidden\" name=\"id_solicitacao\" value=\"$id_solicitacao\">";
                                   }elseif($item['tipo_item'] == 'equipamento'){
                                $sqlQtd = "SELECT quantidade FROM solicitacao_itens WHERE id_item = ".$item['id_item'];
                                $resultQtd = mysqli_query($conexao, $sqlQtd);
                                $detalheQtd = mysqli_fetch_assoc($resultQtd);
                                
                                $sql_det = "SELECT nome_equipamento FROM equipamentos WHERE id_equipamento = ".$item['id_item'];
                                $result_det = mysqli_query($conexao, $sql_det);
                                $detalhe = mysqli_fetch_assoc($result_det);

                                echo "<tr>
                                        <td> {$detalhe['nome_equipamento']} </td>
                                        <td> X </td>
                                        <td> X </td>
                                    </tr>
                                    <input type=\"hidden\" name=\"id_item[]\" value=\"{$item['id_item']}\">
                                    <input type=\"hidden\" name=\"id_solicitacao_itens[]\" value=\"{$item['id_solicitacao_itens']}\">
                                    <input type=\"hidden\" name=\"observacao[]\" value=''>
                                    <input type=\"hidden\" name=\"id_solicitacao\" value=\"$id_solicitacao\">";
                                }
                              echo "  </tbody></table>
                              <button class='btn'>Registrar</button>
                            </form>
                        </div>";
                    }
            ?>
            <div class="voltar">
      <a href="homeQuarteleiro.php" class="btn secundario">← Voltar</a>
    </div>
        </section>
    </main>

    <footer>
        &copy; <?php echo date("Y"); ?> COMMANDER - Sistema de Gerenciamento de Quartelaria
    </footer>
</body>
</html>
