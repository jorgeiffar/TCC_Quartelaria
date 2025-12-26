<?php
include("conecta.php");
$query = "SELECT * FROM usuarios";
$resultado = mysqli_query($conexao, $query);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Lista de Usuários - Quartelaria</title>
    <link rel="stylesheet" href="style.css">
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
        <h1>Lista de Usuários</h1>

        <div class="card">
            <table class="tabela">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Identidade Funcional</th>
                        <th>Email</th>
                        <th>Cargo</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($usuario = mysqli_fetch_assoc($resultado)) { ?>
                        <tr>
                            <td><?php echo $usuario['nome_usuario']; ?></td>
                            <td><?php echo $usuario['identidade_funcional_usuario']; ?></td>
                            <td><?php echo $usuario['email_usuario']; ?></td>
                            <td>
                                <?php 
                                    if($usuario['perfil_usuario'] == 1){
                                        echo "Quarteleiro";
                                    } else {
                                        echo "Solicitante"; 
                                    }
                                ?>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- FOOTER -->
    <footer>
&copy; <?php echo date("Y"); ?> COMMANDER - Sistema de Gerenciamento de Quartelaria    </footer>
</body>
</html>
