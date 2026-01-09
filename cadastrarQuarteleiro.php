<?php
include("conecta.php");
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Quarteleiro - Quartelaria</title>
    <link rel="stylesheet" href="style.css?v=2">
    <script>
        function validarSenha() {
            const senha = document.getElementById("senha").value;
            const confirmar = document.getElementById("confirmar_senha").value;

            if (senha !== confirmar) {
                alert("As senhas não coincidem!");
                return false;
            }
            return true;
        }
    </script>
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

    <!-- CONTEÚDO -->
    <div class="container">
        <h1>Cadastrar Quarteleiro</h1>

        <?php
        if (isset($_GET['status']) && $_GET['status'] == 1) {
            echo '<div class="alert success">Quarteleiro cadastrado com sucesso!</div>';
        }
        ?>

        <div class="card">
            <form action="inserirUsuario.php" method="post" onsubmit="return validarSenha()" class="form-area">
                <div class="form-grid">
                    <div>
                        <label for="nome">Nome:</label>
                        <input type="text" name="nome" id="nome" required>
                    </div>
                    <div>
                        <label for="idFuncional">Identidade Funcional:</label>
                        <input type="number" name="idFuncional" id="idFuncional" required>
                    </div>
                    <div>
                        <label for="email">E-mail institucional:</label>
                        <input type="email" name="email" id="email" required>
                    </div>
                    <div>
                        <label for="senha">Senha:</label>
                        <input type="password" name="senha" id="senha" required>
                    </div>
                    <div>
                        <label for="confirmar_senha">Confirmar senha:</label>
                        <input type="password" name="confSenha" id="confirmar_senha" required>
                    </div>
                </div>
                <input type="hidden" name="perfil" value="1">
                <div class="form-buttons">
                    <input type="submit" value="Cadastrar">
                </div>
            </form>
        </div>
    </div>

    <footer>
&copy; <?php echo date("Y"); ?> COMMANDER - Sistema de Gerenciamento de Quartelaria    </footer>
</body>
</html>
