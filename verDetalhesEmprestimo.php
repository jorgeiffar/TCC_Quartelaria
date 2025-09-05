<?php
session_start();
if(!isset($_SESSION['id_usuario']) || $_SESSION['perfil_usuario'] != 1){
    header("Location: login.php?status=nao_autorizado");
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalhes Empréstimos - Quartelaria</title>
</head>

<body>
    <a href="homeQuarteleiro.php">Voltar</a><br>
    <a href="homeQuarteleiro.php">Home</a>
    <h1> Detalhes </h1>
    <h2>Solicitante: <i>Sd. Eduardo</i></h2>
    <p> Datas: <br>
        Saída: 22/04/1998<br>
        Devolução prevista: 25/04/1999</p>
    <strong>
        Itens:
    </strong><br>
    <table border='1'>
        <tr>
            <th>Nome do Item</th>
            <th>Código</th>
        </tr>
        <tr>
            <td>FAL</td>
            <td>31542</td>
        </tr>
    </table>
    <form action="" method="get">
        <input type="hidden" name='observacao' value='1'>
        <input type="submit" value='Marcar como devolvido'>
    </form>
    <?php
    if (isset($_GET['observacao'])) {
        echo "<br><hr><br>
        <table border='1'>
        <tr>
            <th>Nome do Item</th>
            <th>Código</th>
            <th>Observação</th>
        </tr>
        <tr>
            <td>FAL</td>
            <td>31542</td>
            <td><input type='text' name='observacao[]'></td>
        </tr>
    </table>";
echo "<button>Registrar</button>";
    }
    ?>
</body>

</html>