<?php
include("conecta.php");
session_start();

if(!isset($_SESSION['id_usuario'])){
    header("Location: login.php?status=nao_autorizado");
    exit();
}


$sql = "SELECT id_item, nome_item, descricao_item FROM itens_checklist ORDER BY id_item";
$itens = mysqli_query($conexao, $sql);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Checklist da Viatura</title>
</head>
<body>
    <h2>Checklist de Viatura</h2>
    <form action="visualizar_chkvtr.php" method="post">

        Quilometragem: 
        <input type="number" name="km" required><br><br>

        Placa do veículo: 
        <input type="text" name="placa" required><br><br>

        <table border="1" cellpadding="5">
            <thead>
                <tr>
                    <th>Item</th>
                    <th>QAP</th>
                    <th>Observações</th>
                </tr>
            </thead>
            <tbody>
                <?php while($item = mysqli_fetch_assoc($itens)): ?>
                    <tr>
                        <td><?= $item['nome_item'] ?></td>
                        <td>
                            <input type="checkbox" name="itens[<?= $item['nome_item'] ?>][qap]" value="1">
                        </td>
                        <td>
                            <input type="text" name="itens[<?= $item['nome_item'] ?>][obs]">
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <br>
        <input type="submit" value="Verificar Solicitação">
    </form>
</body>
</html>
