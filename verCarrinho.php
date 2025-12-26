<?php
session_start();
if(!isset($_SESSION['id_usuario'])){
    header("Location: login.php?status=nao_autorizado");
    exit();
}
include("conecta.php");
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Carrinho</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css?v=2">
    <style>
    @media (max-width: 768px) {
        /* Botão Voltar fica grande e bonito */
        .container > a.btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            padding: 16px;
            font-size: 1.2rem;
            margin-bottom: 20px;
            border-radius: 12px;
        }

        /* Cards do carrinho ficam mais espaçosos */
        .card {
            padding: 20px !important;
            margin-bottom: 20px;
        }

        /* Itens do carrinho ficam fáceis de ler e clicar */
        .card p {
            font-size: 1.1rem;
            padding: 12px 0;
            border-bottom: 1px solid #ddd;
        }

        .card a.btn {
            display: inline-block;
            margin-top: 8px;
            padding: 10px 16px;
            font-size: 1rem;
        }

        /* Botão Enviar Solicitação */
        .form-buttons input[type="submit"] {
            width: 100%;
            padding: 18px;
            font-size: 1.3rem;
            font-weight: 600;
        }

        h2, h3 {
            font-size: 1.4rem;
            margin: 20px 0 10px;
        }

        .alert {
            padding: 16px;
            font-size: 1.1rem;
            text-align: center;
        }
    }
    
</style>
</head>
<body>

<div class="bg-fallback"></div>

<header>
    <nav>
        <!-- seu menu exatamente igual -->
        <?php if ($_SESSION['perfil_usuario'] == 1): ?>
                <div class="logo"><a href="homeQuarteleiro.php"><img src="./img/home.png" alt="Home" style="width: 28px; vertical-align: middle-top;"><span> COMMANDER</span></a></div>

          <ul>
            <li><a href="equipamentos.php">Equipamentos / Armamentos</a></li>
            <li><a href="operacoes.php">Operações</a></li>
            <li><a href="solicitacoesQuarteleiro.php">Solicitações</a></li>
            <li><a href="solicitacoesVtr.php">Solicitações Viatura</a></li>
            <li><a href="solicitarSolicitante.php">Solicitação Direta</a></li>
            <li><a href="listarUsuarios.php">Usuários</a></li>
            <li><a href="cadastrarQuarteleiro.php">Cadastrar Quarteleiro</a></li>
            <li><a href="editarPerfil.php">Perfil</a></li>
            <li><a href="logout.php"><img src="./img/logout.png" alt="Logout" style="width: 30px; height: 30px;"></a></li>
          </ul>
        <?php else: ?>
          <div class="logo"><a href="homeSolicitante.php"><img src="./img/home.png" alt="Home" style="width: 28px; vertical-align: middle-top;"><span> COMMANDER</span></a></div>
          <ul>
            <li><a href="solicitarSolicitante.php">Solicitar Itens</a></li>
            <li><a href="checkListVtr.php">Solicitar Viatura</a></li>
            <li><a href="solicitacoesAnterioresSolicitante.php" class="ativo">Solicitações Anteriores</a></li>
            <li><a href="editarPerfil.php">Perfil</a></li>
            <li><a href="logout.php"><img src="./img/logout.png" alt="Logout" style="width: 30px; height: 30px;"></a></li>
          </ul>
        <?php endif; ?>
    </nav>
</header>

<main class="container">
    <a class="btn secundario" href="solicitarSolicitante.php">Voltar</a>
    <div class="card">
        <?php
        if ($_SESSION['perfil_usuario'] == 1 && !empty($_SESSION['usuario_selecionado'])) {
            $usuario = (int) $_SESSION['usuario_selecionado'];
            $sql = "SELECT nome_usuario, identidade_funcional_usuario FROM usuarios WHERE id_usuario = $usuario";
            $result = mysqli_query($conexao, $sql);

            if ($result && mysqli_num_rows($result) > 0) {
                $dados = mysqli_fetch_assoc($result);
                echo "<div class='card'><strong>Solicitante Selecionado:</strong> {$dados['nome_usuario']}<br>";
                echo "<strong>Identidade Funcional:</strong> {$dados['identidade_funcional_usuario']}</div>";
            } else {
                echo "<div class='alert error'>Usuário selecionado não encontrado.</div>";
            }
        } elseif($_SESSION['perfil_usuario'] == 1 && empty($_SESSION['usuario_selecionado'])) {
            echo "<div class='alert info'>Nenhum usuário selecionado.</div>";
        }

        if (isset($_POST['operacao'])){ 
            $_SESSION['operacao'] = $_POST['operacao'];
            $sql = "SELECT nome_operacao FROM operacoes WHERE id_operacao = {$_SESSION['operacao']}";
            $queryOperacao = mysqli_query($conexao,$sql);
            $operacao = mysqli_fetch_assoc($queryOperacao);
        }
        if (isset($_POST['data_devolucao_item'])) $_SESSION['data_devolucao_item'] = $_POST['data_devolucao_item'];
        ?>

        <h2>Carrinho</h2>
        <div class="card">
        <?php
        if (empty($_SESSION['carrinho_armamentos']) && empty($_SESSION['carrinho_equipamentos'])) {
            echo "<div class='alert info'>Carrinho vazio.</div>";
        } else {
            if (!empty($_SESSION['carrinho_armamentos'])) {
                $ids = implode(',', $_SESSION['carrinho_armamentos']);
                $q = mysqli_query($conexao, "SELECT id_armamento, nome_armamento, codigo_armamento FROM armamentos WHERE id_armamento IN ($ids)");
                echo "<h3>Armamentos</h3>";
                echo "<div class='card'>";
                while ($r = mysqli_fetch_assoc($q)){
                    echo "<p>• {$r['nome_armamento']} - {$r['codigo_armamento']}<br>";
                    echo "<a class='btn' href='removerItemCarrinho.php?tipo=armamento&id_item=" . $r['id_armamento'] . "'>Remover</a></p>";
                }
                echo "</div>";
            }

            if (!empty($_SESSION['carrinho_equipamentos'])) {
                $idsArray = array_column($_SESSION['carrinho_equipamentos'], 'id');
                $ids = implode(',', $idsArray);
                $q = mysqli_query($conexao, "SELECT id_equipamento, nome_equipamento, tipo_equipamento FROM equipamentos WHERE id_equipamento IN ($ids)");
                echo "<h3>Equipamentos</h3>";
                echo "<div class='card'>";
                while ($r = mysqli_fetch_assoc($q)) {
                    $quantidade = 1;
                    foreach ($_SESSION['carrinho_equipamentos'] as $item){
                        if($item['id'] == $r['id_equipamento']){
                            $quantidade = $item['quantidade'];
                            break;
                        }
                    }
                    echo "<p>• {$r['nome_equipamento']} - {$r['tipo_equipamento']} | Quantidade: $quantidade<br>";
                    echo "<a class='btn' href='removerItemCarrinho.php?tipo=equipamento&id_item=" . $r['id_equipamento'] . "'>Remover</a></p>";
                }
                echo "</div>";
            }
        }

        echo "<hr><br><h3>Operação:</h3>" . ($operacao['nome_operacao'] ?? 'Não informada');
        echo "<h3>Devolução prevista:</h3>" . ($_SESSION['data_devolucao_item'] ?? 'Não informada');

       

        if (!empty($_SESSION['carrinho_armamentos']) || !empty($_SESSION['carrinho_equipamentos'])) {
            if (!empty($_SESSION['operacao']) && !empty($_SESSION['data_devolucao_item'])) {
                echo '<form method="post" action="processaSolicitacao.php" class="form-area">
                        <div class="form-buttons">
                            <input type="submit" value="Enviar Solicitação">
                        </div>
                      </form>';
            } else {
                echo "<div class='alert error'>⚠️ Preencha o motivo e a data de devolução antes de enviar a solicitação.</div>";
            }
        }
        ?>
        </div>
    </div>
</div>
</main>

<footer>
    &copy; <?php echo date("Y"); ?> COMMANDER - Sistema de Gerenciamento de Quartelaria
</footer>
</body>
</html>
