<?php
include ("conecta.php");
session_start();
if(!isset($_SESSION['id_usuario'])){
    header("Location: login.php?status=nao_autorizado");
    exit();
}

$queryEquip = "SELECT * FROM equipamentos GROUP BY nome_equipamento ORDER BY tipo_equipamento";
$queryArma = "SELECT * FROM armamentos GROUP BY nome_armamento";
$resultEquip = mysqli_query($conexao, $queryEquip);
$resultArma = mysqli_query($conexao, $queryArma);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Equipamentos e Armamentos - Quartelaria</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header>
  <nav>
    <div class="logo">Commander</div>
    <ul>
      <li><a href="homeQuarteleiro.php">Home</a></li>
      <li><a href="equipamentos.php" class="ativo">Equipamentos / Armamentos</a></li>
      <li><a href="operacoes.php">Operações</a></li>
      <li><a href="solicitacoesQuarteleiro.php">Solicitações</a></li>
      <li><a href="solicitacoesVtr.php">Solicitações Viatura</a></li>
      <li><a href="solicitarSolicitante.php">Solicitação Direta</a></li>
      <li><a href="listarUsuarios.php">Usuários</a></li>
      <li><a href="cadastrarQuarteleiro.php">Cadastrar Quarteleiro</a></li>
      <li><a href="editarPerfil.php">Perfil</a></li>
      <li><a href="logout.php">Logout</a></li>
    </ul>
  </nav>
</header>

<main class="container">
  <section>
    <h1>Equipamentos</h1>
    <div class="acoes-topo">
      <a href="addEquipamento.php" class="btn">+ Adicionar Equipamento/Munição</a>
      <a href="addArmamento.php" class="btn">+ Adicionar Armamento</a>
      <a href="verDetalhesItens.php" class="btn secundario">Ver Detalhes</a>
    </div>
    <hr>

    <div class="card">
      <table>
        <thead>
          <tr>
            <th>Nome</th>
            <th>Tipo</th>
            <th>Quantidade Disponível</th>
          </tr>
        </thead>
        <tbody>
        <?php
        while ($dadosEquip = mysqli_fetch_array($resultEquip)) {
            $nome = $dadosEquip['nome_equipamento'];
            $tipo = $dadosEquip['tipo_equipamento'];
            $quantidadeTotal = $dadosEquip['quantidade_equipamento'];
            $quantidadeDisponivel = $quantidadeTotal - $dadosEquip['quantidade_disponivel_equipamento'];
            echo "<tr>
                    <td>$nome</td>
                    <td>$tipo</td>
                    <td>$quantidadeDisponivel</td>
                  </tr>";
        }
        ?>
        </tbody>
      </table>
    </div>
  </section>

  <section>
    <h2>Armamentos</h2>
    <hr>
    <div class="card">
      <table>
        <thead>
          <tr>
            <th>Nome</th>
            <th>Tipo</th>
            <th>Quantidade Disponível</th>
          </tr>
        </thead>
        <tbody>
        <?php
        while ($dadosArma = mysqli_fetch_array($resultArma)) {
            $nome = $dadosArma['nome_armamento'];
            $tipo = $dadosArma['tipo_armamento'];
            $quantidadeDisponivel = "(definir código)";
            echo "<tr>
                    <td>$nome</td>
                    <td>$tipo</td>
                    <td>$quantidadeDisponivel</td>
                  </tr>";
        }
        ?>
        </tbody>
      </table>
    </div>
  </section>
</main>

<footer>
  &copy; 2025 COMMANDER - Sistema de Gerenciamento de Quartelaria
</footer>

</body>
</html>
