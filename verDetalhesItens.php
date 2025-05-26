<?php
include("conecta.php");

$sqlArmamentos = "SELECT * FROM armamentos";
$sqlEquipamentos = "SELECT * FROM equipamentos";
$queryArmamentos = mysqli_query($conexao, $sqlArmamentos);
$queryEquipamentos = mysqli_query($conexao, $sqlEquipamentos);
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalhes Itens - Quartelaria</title>
</head>

<body>
    <a href="equipamentos.php">Voltar</a><br>
    <a href="homeQuarteleiro.php">Home</a>
    <h1>Equipamentos</h1>
    <a href="addEquipamento.php">Adicionar Equipamento</a> |
    <a href="addArmamento.php">Adicionar Armamento</a> |
    <a href="verDetalhesItens.php">Ver detalhes</a><br><br>
    <?php
    // Armamentos
    echo "<tbody> <h1> Armamentos </h1><table border='1'> 
            <tr>
                <th>Nome</th>
                <th>Tipo</th>
                <th>Calibre</th>
                <th>Código</th>
                <th>Opções</th>
                
            </tr>";
    while ($armamento = mysqli_fetch_assoc($queryArmamentos)) {
        $nome = $armamento['nome_armamento'];
        $codigo = $armamento['codigo_armamento'];
        $tipo = $armamento['tipo_armamento'];
        $calibre = $armamento['calibre_armamento'];
        echo "<tr>";
        echo "<td>$nome</td>
    <td>$codigo</td>
    <td>$tipo</td>
    <td>$calibre</td>
    <td>Editar | Excluir</td>";
        echo "</tr>";
    }echo "</table> </tbody>";

//Equipamentos


    echo "<tbody> <h1> Equipamentos </h1>";
    echo "</table>";
    echo "<table border='1'> 
            <tr>
                <th>Nome</th>
                <th>Tipo</th>
                <th>Qtd. disponível</th>
                <th>Qtd. em uso</th>
                <th>Opções</th>
                
            </tr>";
    while ($armamento = mysqli_fetch_assoc($queryEquipamentos)) {
        $nome = $armamento['nome_equipamento'];
        $tipo = $armamento['tipo_equipamento'];
        $quantidade = $armamento['quantidade_equipamento'];
        echo "<tr>";
        echo "<td>$nome</td>
    <td>$tipo</td>
    <td>$quantidade <br>(Alterar no código, por enquanto ta a total)</td>
    <td>Y(Alterar no código)</td>
    <td>Editar | Excluir</td>";
        echo "</tr>";
    }
    echo "</table> </tbody>"; ?>
</body>

</html>