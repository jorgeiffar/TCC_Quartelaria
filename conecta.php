<?php
mysqli_report(MYSQLI_REPORT_OFF);
$conexao = mysqli_connect("localhost", "root", "", "tccquartelaria");
if (!$conexao) {
    echo "Erro de conexão com o banco de dados:" . mysqli_connect_error();
    die();
}
?>