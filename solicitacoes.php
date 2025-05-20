<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solicitações - Quartelaria</title>
</head>

<body>
    <a href="homeQuarteleiro.php">Voltar</a><br>
    <a href="homeQuarteleiro.php">Home</a><br>
    <strong><a href="solicitacoesAnteriores.php">Solicitações Anteriores</a></strong>
    <h1>Solicitações</h1>
    <h2>Solicitante: <i>Sd. Fábio</i></h2>
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
            <th>Tipo</th>
        </tr>
        <tr>
            <td>FAL</td>
            <td><select name="codEquip" required>
                    <option value="">Selecione</option>
                    <option value="31542">31542</option>
                </select></td>
            <td>Fuzil</td>
        </tr>
    </table>
<button>Negar</button> | <button>Autorizar</button>
</body>

</html>