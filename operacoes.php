<?php
include("conecta.php");
session_start();
if(!isset($_SESSION['id_usuario'])){
    header("Location: login.php?status=nao_autorizado");
    exit();
}
$sqlOperacao = "SELECT * FROM operacoes";
$queryOperacao = mysqli_query($conexao, $sqlOperacao);
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Operações - Quartelaria</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    
    <header>
        <nav>
            <div class="logo" ><a href="homeQuarteleiro.php">Commander</a></div>
            <ul>
                <li><a href="equipamentos.php">Equipamentos / Armamentos</a></li>
                <li><a href="operacoes.php">Operações</a></li>
                <li><a href="solicitacoesQuarteleiro.php">Solicitações</a></li>
                <li><a href="solicitacoesVtr.php">Solicitações Viatura</a></li>
                <li><a href="solicitarSolicitante.php">Solicitação Direta</a></li>
                <li><a href="listarUsuarios.php">Visualizar Usuários</a></li>
                <li><a href="cadastrarQuarteleiro.php">Cadastrar Quarteleiro</a></li>
                <li><a href="editarPerfil.php">Editar Perfil</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>

    <main class="container">
        <section class="conteudo">
            <h1>Operações</h1>
            <hr>
            <div class="card">
                <div class="links-topo">
                    <a href="addOperacao.php" class="btn secundario">+ Adicionar operação</a><br><br>
                </div>

                <div class="tabela-container">
                    <table class="tabela">
                        <thead>
                            <tr>
                                <th>Nome</th>
                                <th>Local</th>
                                <th>Descrição</th>
                                <th>Tipo</th>
                                <th>Data de início</th>
                                <th>Status</th>
                                <th>Opções</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            while ($operacao = mysqli_fetch_assoc($queryOperacao)) {
                                $id = $operacao['id_operacao'];
                                $nome = $operacao['nome_operacao'];
                                $local = $operacao['local_operacao'];
                                $tipo = $operacao['tipo_operacao'];
                                $descricao = $operacao['descricao_operacao'];
                                $data = $operacao['data_inicio_operacao'];
                                $status = $operacao['status_operacao'];
                                echo "
                                <tr>
                                    <td>$nome</td>
                                    <td>$local</td>
                                    <td>$descricao</td>
                                    <td>$tipo</td>
                                    <td>$data</td>
                                    <td>$status</td>
                                    <td>
                                        <a href='editarOperacao.php?id=$id' class='link-editar'>Editar</a> | 
                                        <a href='#' class='link-excluir'>Excluir</a>
                                    </td>
                                </tr>
                                ";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </main>

    <footer>
        &copy; 2025 COMMANDER - Sistema de Gerenciamento de Quartelaria
    </footer>
</body>
</html>
