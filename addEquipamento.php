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
        Equipamento: <select name="equipamento"><br>
            <option value="">Selecione</option>
            <optgroup label="Operação de Controle de Distúrbios">
                <option value="Disturbios|Escudo">Escudo</option>
                <option value="Disturbios|Capacete">Capacete</option>
                <option value="Disturbios|Bastao">Bastão</option>
            </optgroup>
            <hr>
            <optgroup label="Outros">
                <option value="Outros|Carregador">Carregador</option>
                <option value="Outros|Bandoleira">Bandoleira</option>
            </optgroup>
        </select><br>
        Quantidade: <input type="number" name="quantidadeEquip"><br>
        Quantidade mínima:<input type="number" name="quantidadeMin"><br>
        <input type="submit" value="Adicionar Equipamento">
    </form>
<hr>
    <h1>Adicionar Munições</h1>
     <form action="inserirEquipamento.php" method="post">
        Calibre: <select name="equipamento">
            <option value="">Selecione</option>
                <option value="Municao|7,62x51mm">7,62x51mm</option>
                <option value="Municao|5,56x45mm">5,56x45mm</option>
                <option value="Municao|9mm">9mm</option>
                <option value="Municao|12GA">12GA</option>
                <option value="Municao|Spark">Spark</option>
        </select><br>
        Quantidade: <input type="number" name="quantidadeEquip"><br>
        Quantidade mínima:<input type="number" name="quantidadeMin"><br>
        <input type="submit" value="Adicionar Munições">
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
        const url = new URL(window.location);
        url.searchParams.delete('status');
        window.history.replaceState({}, document.title, url);
        }, 3000); // 3000 milissegundos = 3 segundos
    </script>
</body>

</html>