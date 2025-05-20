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
    <form action="" method="post">
        Nome do Armamento: <input type="text" name="nomeArma"><br>
        Tipo: <select name="tipoArma">
            <option value="">Selecione</option>
        </select><br>
        Calibre: <input type="text" name="calibreArma"><br>
        Código do Armamento: <input type="text" name="codigoArma"><br>
        <input type="submit" value="Adicionar Armamento">
    </form>
</body>
</html>