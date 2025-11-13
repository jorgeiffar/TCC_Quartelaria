<?php
session_start();
include("conecta.php");

if (!isset($_SESSION['id_usuario'])) {
    header("Location: login.php?erro=nao_autorizado");
    exit();
}

$id = $_SESSION['id_usuario'];
$query = "SELECT * FROM usuarios WHERE id_usuario = $id";
$resultado = mysqli_query($conexao, $query);
$usuario = mysqli_fetch_assoc($resultado);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Perfil - Quartelaria</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="bg-fallback"></div>

   <nav>
    <?php if ($_SESSION['perfil_usuario'] == 1): ?>
      <div class="logo"><a href="homeQuarteleiro.php">Commander</a></div>
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
    <?php else: ?>
      <li><a href="homeSolicitante.php">Voltar - Home</a></li>
    <?php endif; ?>
</nav>

    <!-- CONTEÚDO -->
    <div class="container">
        <h1>Editar Perfil</h1>

        <div class="card">
            <form action="registrarEdicaoPerfil.php" method="post" class="form-area">
                <div class="form-grid">
                    <div>
                        <label for="nome">Nome:</label>
                        <input type="text" name="nome" id="nome" value="<?php echo $usuario['nome_usuario']; ?>" required>
                    </div>
                    <div>
                        <label for="idFuncional">Identidade Funcional:</label>
                        <input type="number" name="idFuncional" id="idFuncional" value="<?php echo $usuario['identidade_funcional_usuario']; ?>" required>
                    </div>
                    <div>
                        <label for="email">E-mail:</label>
                        <input type="email" name="email" id="email" value="<?php echo $usuario['email_usuario']; ?>" required>
                    </div>
                </div>
                <div class="form-buttons">
                    <input type="submit" value="Salvar alterações">
                </div>
            </form>
        </div>
    </div>

    <!-- FOOTER -->
    <footer>
        &copy; <?php echo date('Y'); ?> Quartelaria. Todos os direitos reservados.
    </footer>
</body>
</html>
