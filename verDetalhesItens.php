<?php
include("conecta.php");
session_start();
if (!isset($_SESSION['id_usuario']) || $_SESSION['perfil_usuario'] != 1) {
    header("Location: login.php?status=nao_autorizado");
    exit();
}

$sqlArmamentos = "SELECT * FROM armamentos ORDER BY nome_armamento DESC";
$sqlEquipamentos = "SELECT * FROM equipamentos";
$queryArmamentos = mysqli_query($conexao, $sqlArmamentos);
$queryEquipamentos = mysqli_query($conexao, $sqlEquipamentos);
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalhes dos Itens - Quartelaria</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
<header>
  <nav>
    <div class="logo" ><a href="homeQuarteleiro.php">Commander</a></div>
    <ul>
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
    <h1>Detalhes dos Itens</h1>

    <div class="card">
      <h2>Equipamentos</h2>
      <div class="tabela-responsiva">
        <table>
          <thead>
            <tr>
              <th>Nome</th>
              <th>Tipo</th>
              <th>Qtd. Disponível</th>
              <th>Qtd. Total</th>
              <th>Última Atualização</th>
              <th>Status</th>
              <th>Opções</th>
            </tr>
          </thead>
          <tbody>
            <?php
            while ($dadosEquip = mysqli_fetch_array($queryEquipamentos)) {
                $nome = $dadosEquip['nome_equipamento'];
                $tipo = $dadosEquip['tipo_equipamento'];
                $quantTotal = $dadosEquip['quantidade_equipamento'];
                $quantDisp = $quantTotal - $dadosEquip['quantidade_disponivel_equipamento'];
                $data = $dadosEquip['ultima_atualizacao_equipamento'];
                $status = $dadosEquip['status_equipamento'];
                $id = $dadosEquip['id_equipamento'];

                echo "<tr>
                        <td>$nome</td>
                        <td>$tipo</td>
                        <td>$quantDisp</td>
                        <td>$quantTotal</td>
                        <td>$data</td>
                        <td>$status</td>
                        <td>
                            <a href='editarEquipamento.php?id=$id' class='link-editar'>Editar</a> |
                            <a href='excluirEquipamento.php?id=$id' class='link-excluir'>Excluir</a>
                        </td>
                      </tr>";
            }
            ?>
          </tbody>
        </table>
      </div>
    </div>

    <div class="card">
      <h2>Armamentos</h2>
      <div class="tabela-responsiva">
        <table>
          <thead>
            <tr>
              <th>Nome</th>
              <th>Tipo</th>
              <th>Calibre</th>
              <th>Código</th>
              <th>Status</th>
              <th>Opções</th>
            </tr>
          </thead>
          <tbody>
            <?php
            while ($dadosArma = mysqli_fetch_array($queryArmamentos)) {
                $nome = $dadosArma['nome_armamento'];
                $tipo = $dadosArma['tipo_armamento'];
                $calibre = $dadosArma['calibre_armamento'];
                $codigo = $dadosArma['codigo_armamento'];
                $status = $dadosArma['status_armamento'];
                $id = $dadosArma['id_armamento'];

                echo "<tr>
                        <td>$nome</td>
                        <td>$tipo</td>
                        <td>$calibre</td>
                        <td>$codigo</td>
                        <td>$status</td>
                        <td>
                            <a href='editarArmamento.php?id=$id' class='link-editar'>Editar</a> |
                            <a href='excluirArmamento.php?id=$id' class='link-excluir'>Excluir</a>
                        </td>
                      </tr>";
            }
            ?>
          </tbody>
        </table>
      </div>
    </div>

    <div class="voltar">
      <a href="equipamentos.php" class="btn secundario">← Voltar</a>
    </div>

  </section>
</main>

<footer>
  &copy; 2025 COMMANDER - Sistema de Gerenciamento de Quartelaria
</footer>

</body>
</html>
