<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Adicionar Operação Policial</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>

      <a href="operacoes.php">Voltar</a><br>
    <a href="homeQuarteleiro.php">Home</a><br>
    <h1>Adicionar Operação</h1>

    <form action="inserirOperacao.php" method="post">
      
      Nome da Operação:
      <input type="text"  name="nome" required><br>

      Tipo de Operação
      <select  name="tipo" required>
        <option value="">Selecione</option>
        <option value="Patrulhamento">Patrulhamento</option>
        <option value="Cerco">Cerco</option>
        <option value="Blitz">Blitz</option>
        <option value="Reintegração de Posse">Reintegração de Posse</option>
        <option value="Apoio a Outro Órgão">Apoio a Outro Órgão</option>
        <option value="Outros">Outros</option>
      </select><br>

     Local da Operação:
      <input type="text"  name="local" required><br>
      Data e Hora:
      <input type="datetime-local"  name="data_hora" required><br>

      Descrição Detalhada: <br>
      <textarea name="descricao" rows="6" required></textarea><br>

      Status da Operação:
      <select name="status" required>
        <option value="Planejada">Planejada</option>
        <option value="Em Andamento">Em Andamento</option>
        <option value="Concluída">Concluída</option>
        <option value="Cancelada">Cancelada</option>
      </select><br>

      <input type="submit" value="Registrar Operação">
    </form>
    
    <?php
    if (isset($_GET['status'])) {
        $status = $_GET['status'];
        echo "<hr>";
        if ($status == 0) {
            echo "<div id='mensagem' style=\"color: red;\"> Falha ao adicionar operação no sistema. </div>";
        } elseif ($status == 1) {
            echo "<div id='mensagem' style=\"color: green;\"> Operação adicionado no sistema. </div>";
        } else {
            echo "<div id='mensagem' style=\"color: orange;\"> Erro não identificado </div>";
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
