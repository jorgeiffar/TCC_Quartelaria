<?php
session_start();
if(!isset($_SESSION['id_usuario'])){
    header("Location: login.php?status=nao_autorizado");
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solicitações Anteriores - Quartelaria</title>
</head>
<body>
        <a href="homeSolicitante.php">Voltar</a><br>
    <a href="homeSolicitante.php">Home</a><br>
    <h1>Solicitações Anteriores</h1>
    <table border ='1'>
        <tr><th>Solicitante</th>
        <th>Id. funcional</th>
        <th>equipamento</th>
        <th>código</th>
        <th>Data retirada</th>
        <th>Data devolução</th>
        <th>status</th>
        <th>opções</th></tr>
        <tr>
            <td>Eduardo</td>
            <td>12345</td>
            <td>FAL</td>
            <td>31542</td>
            <td>22/04/2001</td>
            <td>24/04/2002</td>
            <td>Devolvido</td>
            <td>Editar | Excluir</td>
    </tr>
</table>
</body>
</html>