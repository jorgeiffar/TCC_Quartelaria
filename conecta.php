<?php
mysqli_report(MYSQLI_REPORT_OFF);
$conexao = mysqli_connect("localhost", "root", "", "tccquartelaria");
if (!$conexao) {
    echo "Erro de conexão com o banco de dados:" . mysqli_connect_error();
    die();
}
?>
<link rel="icon" type="image/png" href="img/icons8-soldier-man-64.png">
  <div class="bg-fallback"></div>
  