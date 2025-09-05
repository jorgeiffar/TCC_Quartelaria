<?php
include("conecta.php");
session_start();
if(!isset($_SESSION['id_usuario'])){
    header("Location: login.php?status=nao_autorizado");
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solicitação Viatura - Quartelaria</title>
</head>
<body>
    <a href="homeSolicitante.php">Voltar - Home</a>
    <form action="visualizar_chkvtr.php" method="post">
    Data e Hora da inspeção:<input type="date" name="data"><input type="time" name="horarioInsepcao">//transformar em timestamp<br>
    Quilometragem da inspeção: <input type="number" name="kmInspecao"><br>
    Placa do veículo: <input type="text" name="pVeiculo"><br>
    <table border="1" cellpadding="5">
      <thead>
        <tr>
          <th>Item</th>
          <th>QAP</th>
          <th>Alteração</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>Pneus</td>
          <td><input type="checkbox" name="item[]" value="pneus"></td>
          <td><input type="text" name="pneustxt" value=""></td>
        </tr>
        <tr>
          <td>Pneu Reserva</td>
          <td><input type="checkbox" name="item[]" value="pneuReserva"></td>
          <td><input type="text" name="pneuReservatxt" value=""></td>
        </tr>
        <tr>
          <td>Faróis</td>
          <td><input type="checkbox" name="item[]" value="farois"></td>
          <td><input type="text" name="faroistxt" value=""></td>
        </tr>
        <tr>
          <td>Sinaleiras</td>
          <td><input type="checkbox" name="item[]" value="sinaleiras"></td>
          <td><input type="text" name="sinaleirastxt" value=""></td>
        </tr>
        <tr>
          <td>Sistema de pisca (esq., dir., alerta)</td>
          <td><input type="checkbox" name="item[]" value="piscas"></td>
          <td><input type="text" name="piscastxt" value=""></td>
        </tr>
        <tr>
          <td>Luz de freios</td>
          <td><input type="checkbox" name="item[]" value="luzFreio"></td>
          <td><input type="text" name="luzFreiotxt" value=""></td>
        </tr>
        <tr>
          <td>Luz de ré</td>
          <td><input type="checkbox" name="item[]" value="luzRe"></td>
          <td><input type="text" name="luzRetxt" value=""></td>
        </tr>
        <tr>
          <td>Lataria</td>
          <td><input type="checkbox" name="item[]" value="lataria"></td>
          <td><input type="text" name="latariatxt" value=""></td>
        </tr>
        <tr>
          <td>Freios</td>
          <td><input type="checkbox" name="item[]" value="freios"></td>
          <td><input type="text" name="freiostxt" value=""></td>
        </tr>
        <tr>
          <td>Freio de estacionamento</td>
          <td><input type="checkbox" name="item[]" value="freioEstacionar"></td>
          <td><input type="text" name="freioEstacionartxt" value=""></td>
        </tr>
        <tr>
          <td>Estofamento</td>
          <td><input type="checkbox" name="item[]" value="estofamento"></td>
          <td><input type="text" name="estofamentotxt" value=""></td>
        </tr>
        <tr>
          <td>Nível do radiador</td>
          <td><input type="checkbox" name="item[]" value="nivelRadiador"></td>
          <td><input type="text" name="nivelRadiadortxt" value=""></td>
        </tr>
        <tr>
          <td>Nível do óleo</td>
          <td><input type="checkbox" name="item[]" value="nivelOleo"></td>
          <td><input type="text" name="nivelOleotxt" value=""></td>
        </tr>
        <tr>
          <td>Retrovisores</td>
          <td><input type="checkbox" name="item[]" value="retrovisores"></td>
          <td><input type="text" name="retrovisorestxt" value=""></td>
        </tr>
        <tr>
          <td>Extintor</td>
          <td><input type="checkbox" name="item[]" value="extintor"></td>
          <td><input type="text" name="extintortxt" value=""></td>
        </tr>
        <tr>
          <td>Sistema de comunicação</td>
          <td><input type="checkbox" name="item[]" value="sistemaComunicacao"></td>
          <td><input type="text" name="sistemaComunicacaotxt" value=""></td>
        </tr>
        <tr>
          <td>Sirene e giro flash</td>
          <td><input type="checkbox" name="item[]" value="sireneGiroflash"></td>
          <td><input type="text" name="sireneGiroflashtxt" value=""></td>
        </tr>
        <tr>
          <td>Lavagem</td>
          <td><input type="checkbox" name="item[]" value="lavagem"></td>
          <td><input type="text" name="lavagemtxt" value=""></td>
        </tr>
        <tr>
          <td>Tapetes</td>
          <td><input type="checkbox" name="item[]" value="tapetes"></td>
          <td><input type="text" name="tapetestxt" value=""></td>
        </tr>
        <tr>
          <td>Macaco</td>
          <td><input type="checkbox" name="item[]" value="macaco"></td>
          <td><input type="text" name="macacotxt" value=""></td>
        </tr>
        <tr>
          <td>Triângulo</td>
          <td><input type="checkbox" name="item[]" value="triangulo"></td>
          <td><input type="text" name="triangulotxt" value=""></td>
        </tr>
        <tr>
          <td>Chave de roda</td>
          <td><input type="checkbox" name="item[]" value="chaveRoda"></td>
          <td><input type="text" name="chaveRodatxt" value=""></td>
        </tr>
        <tr>
          <td>Limpador de para-brisas</td>
          <td><input type="checkbox" name="item[]" value="limpadorParabrisa"></td>
          <td><input type="text" name="limpadorParabrisatxt" value=""></td>
        </tr>
      </tbody>
    </table>
    <input type="submit" value="Solicitar">
  </form>
</body>

</html>
</body>
</html>