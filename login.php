<?php
include("conecta.php");

$status = $_GET['status'] ?? null;

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Quartelaria</title>
</head>
<body>
<?php
if($status == 1){
     echo "<div id='mensagem' style=\"color: green;\"> Usuário cadastrado! </div>";
}
?>    

<form action="login.php" method="post">
Identidade Funcional: <input type="number" name="idFuncional" required><br>
Senha: <input type="password" name="senha" required><br>
<input type="submit" value="Entrar"><br>
Ainda não é cadastrado? <a href="cadastrar.php">Cadastre-se!</a>
</form>
</body>
<script>
        setTimeout(function () {
            var msg = document.getElementById('mensagem');
            if (msg) {
                msg.style.display = 'none';
            }
        const url = new URL(window.location);
        url.searchParams.delete('status');
        window.history.replaceState({}, document.title, url);
        }, 3000); // 3000 milissegundos = 3 segundos
    </script>
</html>
<?php
if($_SERVER['REQUEST_METHOD'] === 'POST'){
$idFuncional = $_POST['idFuncional'];
$senha = $_POST['senha'];
$sqlSelect = "SELECT * FROM usuarios WHERE identidade_funcional_usuario = '$idFuncional'";


$sqlCadastrado = "SELECT * FROM usuarios WHERE identidade_funcional_usuario = '$idFuncional'";
$queryCadastrado = mysqli_query($conexao, $sqlCadastrado);

if(mysqli_num_rows($queryCadastrado) == 0){
    echo "<hr>Usuário ainda <strong>não</strong> cadastrado!<hr>";
}else{


$querySelect = mysqli_query($conexao,$sqlSelect);
$dadosUser = mysqli_fetch_assoc($querySelect);
$senhaCript = $dadosUser['senha_usuario'];
if(mysqli_num_rows($querySelect) > 0){
$verify = password_verify($senha, $senhaCript);
if($verify){
    if($dadosUser['perfil_usuario'] == 1){
        header("Location: homeQuarteleiro.php");
        exit;
    }elseif($dadosUser['perfil_usuario'] == 2){
        header("Location: homeSolicitante.php");
        exit;
    }
}
}}}
?>