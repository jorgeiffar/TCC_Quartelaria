<?php
include("conecta.php");
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add. Armamento - Quartelaria</title>
</head>

<body>
    <a href="equipamentos.php">Voltar</a><br>
    <a href="homeQuarteleiro.php">Home</a>
    <h1>Adicionar armamento</h1>
    <form action="inserirArmamento.php" method="post">
        Nome do Armamento: <input type="text" name="nomeArma" required><br>
        Tipo: <select name="tipoArma" required>
            <option value="">Selecione</option>
            <option value="Fuzil">Fuzil</option>
            <option value="Pistola">Pistola</option>
            <option value="Espingarda">Espingarda</option>
            <option value="Lancador">Lançador</option>
            <option value="Spark">Spark</option>
            <option value="Granada">Granada</option>
            </optgroup>
        </select><br>
        Calibre: <input type="text" name="calibreArma" required><br>
        Código do Armamento: <input type="text" name="codigoArma" required><br>
        <input type="submit" value="Adicionar Armamento">
    </form>


    <?php
    if (isset($_GET['status'])) {
        $status = $_GET['status'];
        echo "<hr>";
        if ($status == 0) {
            echo "<div id='mensagem' style=\"color: red;\"> Falha ao adicionar armamento no sistema. </div>";
        } elseif ($status == 1) {
            echo "<div id='mensagem' style=\"color: green;\"> Armamento adicionado no sistema. </div>";
        } else {
            echo "<div id='mensagem' style=\"color: orange;\"> Erro não identificado </div>";
        }
    }
    ?>
    <script>
        setTimeout(function () {
            var msg = document.getElementById('mensagem');
            if (msg) {
                msg.style.display = 'none';
            }
        }, 3000); // 3000 milissegundos = 3 segundos
    </script>
</body>

</html>