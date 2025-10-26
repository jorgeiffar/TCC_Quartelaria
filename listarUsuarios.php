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
</head>
<body> <a href="homeQuarteleiro.php">Voltar - Home</a><br>
    <h1>Lista de Usuários</h1>
 
    <table border="1">
        <tr>
            <th>Nome</th>
            <th>Identidade Funcional</th>
            <th>Email</th>
            <th>Cargo</th>
        </tr>

        <?php while ($usuario = mysqli_fetch_assoc($resultado)) { ?>
            <tr>
                <td><?php echo $usuario['nome_usuario']; ?></td>
                <td><?php echo $usuario['identidade_funcional_usuario']; ?></td>
                <td><?php echo $usuario['email_usuario']; ?></td>
                <td><?php if($usuario['perfil_usuario'] == 1){
                    echo "Quarteleiro";
                }else{
                echo "Solicitante"; }?></td>
            </tr>
        <?php } ?>
    </table>
</body>
</html>
