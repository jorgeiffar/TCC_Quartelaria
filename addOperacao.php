<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Adicionar Operação Policial</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="container">
      <a href="operacoes.php">Voltar</a><br>
    <a href="homeQuarteleiro.php">Home</a><br>
    <h1>Adicionar Operação</h1>

    <form action="inserir_operacao.php" method="POST">
      
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

      <!--Data e Horário:
      <input type="datetime-local"  name="data_hora" required><br>-->

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

  </div>
</body>
</html>
