<?php
mysqli_report(MYSQLI_REPORT_OFF);
$conexao = mysqli_connect("localhost", "root", "", "tccquartelaria");
if (!$conexao) {
    echo "Erro de conexão com o banco de dados:" . mysqli_connect_error();
    die();
}
?>
<div class="icone-lateral">
        <img src="./img/logobatalhao.png" alt="Ícone Batalhão de Choque BM">
    </div>
    <link rel="stylesheet" href="style.css">