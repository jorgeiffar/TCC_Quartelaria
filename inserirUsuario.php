<?php
include("conecta.php");

$nome = $_POST['nome'];
$idFuncional = $_POST['idFuncional'];
$email = $_POST['email'];
$senha = $_POST['senha'];
$perfil = $_POST['perfil'];
$hash = password_hash($senha, PASSWORD_DEFAULT);

$sql = "SELECT * FROM usuarios WHERE identidade_funcional_usuario = '$idFuncional'";
$query = mysqli_query($conexao, $sql);

if(mysqli_num_rows($query)>0){
    echo "Usuário já cadastrado!<br>Para realizar login <a href='login.php'> clique aqui</a>";
}else{
    $sqlInsert = "INSERT INTO usuarios (nome_usuario,identidade_funcional_usuario,email_usuario,senha_usuario,perfil_usuario) VALUES ('$nome', '$idFuncional', '$email', '$hash', '$perfil')";
    $queryInsert = mysqli_query($conexao, $sqlInsert);
    if(isset($queryInsert)){
        if(isset($_GET['status']) and $_GET['status']=='67'){
           header("Location: cadastrarQuarteleiro?status=1"); 
        }else{
        header("Location: login.php?status=1");}
}else{
    echo "Erro inesperado no cadastro de usuário.<br>
    Tente novamente mais tarde.";
}
}
?>