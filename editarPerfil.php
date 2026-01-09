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
    <link rel="stylesheet" href="style.css?v=2">
</head>
<body>
    <div class="bg-fallback"></div>

   <nav>
    <?php if ($_SESSION['perfil_usuario'] == 1): ?>
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
    <?php else: ?>
       
        <div class="logo"><a href="homeSolicitante.php"><img src="./img/home.png" alt="Home" style="width: 28px; vertical-align: middle-top;"><span> COMMANDER</span></a></div>
        <ul>
            <li><a href="solicitarSolicitante.php">Solicitar Itens</a></li>
            <li><a href="checkListVtr.php">Solicitar Viatura</a></li>
            <li><a href="solicitacoesAnterioresSolicitante.php" class="ativo">Solicitações Anteriores</a></li>
            <li><a href="editarPerfil.php">Perfil</a></li>
            <li><a href="logout.php"><img src="./img/logout.png" alt="Logout" style="width: 30px; height: 30px; vertical-align: middle;"></a></li>
        </ul>

    <?php endif; ?>
</nav>

    
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

    <footer>
&copy; <?php echo date("Y"); ?> COMMANDER - Sistema de Gerenciamento de Quartelaria    </footer>
</body>
</html>
