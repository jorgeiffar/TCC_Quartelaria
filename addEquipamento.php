<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add. Equipamento - Quartelaria</title>
</head>

<body>
    <a href="equipamentos.php">Voltar</a><br>
    <a href="homeQuarteleiro.php">Home</a>
    <h1>Adicionar Equipamento</h1>
    <form action="inserirEquipamento.php" method="post">
        Nome do Equipamento: <input type="text" name="nomeEquip"><br>
        Tipo: <select name="tipoEquip"><br>
            <option value="">Selecione</option>
            <optgroup label="Munições">
                <option value="7,62x51mm">7,62x51mm</option>
                <option value="5,56x45mm">5,56 x 45mm</option>
                <option value="9mm">9mm</option>
                <option value="12GA">12GA</option>
                <option value="Spark">Spark</option>
            </optgroup>
            <hr>
            <optgroup label="Operação de Controle de Distúrbios">
                <option value="Escudo">Escudo</option>
                <option value="Capacete">Capacete</option>
                <option value="Bastao">Bastão</option>
            </optgroup>
            <hr>
            <optgroup label="Outros">
                <option value="Carregador">Carregador</option>
                <option value="Bandoleira">Bandoleira</option>
            </optgroup>
        </select><br>
        Quantidade: <input type="number" name="quantidadeEquip"><br>
        <input type="submit" value="Adicionar Equipamento">
    </form>
    <?php
    if (isset($_GET['status'])) {
        $status = $_GET['status'];
        echo "<hr>";
        if ($status == 0) {
            echo "<div id='mensagem' style=\"color: red;\"> Falha ao adicionar equipamento no sistema. </div>";
        } elseif ($status == 1) {
            echo "<div id='mensagem' style=\"color: green;\"> Equipamento adicionado no sistema. </div>";
        } else {
            echo "<div id='mensagem' style=\"color: orange;\"> Erro não identificado. </div>";
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