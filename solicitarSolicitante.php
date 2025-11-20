<?php
session_start();
if(!isset($_SESSION['id_usuario'])){
    header("Location: login.php?status=nao_autorizado");
    exit();
}
include("conecta.php");

// armamentos
$sqlArmamentos = "SELECT * FROM armamentos where status_armamento != 1";
$resultadoArmamentos = mysqli_query($conexao, $sqlArmamentos);
$armamentos_por_tipo = [];
while ($row = mysqli_fetch_assoc($resultadoArmamentos)) {
    $tipo = $row['tipo_armamento'];
    $armamentos_por_tipo[$tipo][] = $row;
}

// equipamentos
$sqlEquipamentos = "SELECT * FROM equipamentos";
$resultadoEquipamentos = mysqli_query($conexao, $sqlEquipamentos);
$equipamentos_por_tipo = [];
while ($row = mysqli_fetch_assoc($resultadoEquipamentos)) {
    $tipo = $row['tipo_equipamento'];
    $equipamentos_por_tipo[$tipo][] = $row;
}

// operacoes
$sqlOperacoes = "SELECT id_operacao, nome_operacao FROM operacoes ORDER BY nome_operacao ASC";
$resultadoOperacoes = mysqli_query($conexao, $sqlOperacoes);

$id_solicitacao = mysqli_insert_id($conexao);
$sql = "SELECT identidade_funcional_usuario, nome_usuario FROM usuarios";
$result = mysqli_query($conexao,$sql);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Solicitação</title>
    <link rel="stylesheet" href="style.css">
    <style>
      /* ====== AJUSTES ESPECÍFICOS PARA ESTA PÁGINA ====== */
      h1, h2, h3 {
        margin-bottom: 15px;
      }

      .section-title {
        font-size: 1.6rem;
        font-weight: 600;
        border-left: 6px solid var(--cor-principal);
        padding-left: 12px;
        margin: 40px 0 20px;
        color: var(--cor-principal);
      }

      .itens-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
        gap: 20px;
      }

      .item-card {
        background: var(--cor-card);
        border: 1px solid var(--cor-borda);
        border-radius: var(--radius);
        box-shadow: var(--sombra);
        padding: 20px;
        transition: transform 0.2s ease;
      }

      .item-card:hover {
        transform: scale(1.01);
      }

      .item-card h4 {
        margin-bottom: 8px;
        color: var(--cor-texto);
      }

      .item-card form {
        margin-top: 10px;
      }

      .item-card input[type="submit"] {
        width: 100%;
      }

      .section-divider {
        margin: 60px 0 30px;
        border: none;
        height: 2px;
        background: var(--cor-borda);
      }

      .final-form {
        background: var(--cor-card);
        border: 1px solid var(--cor-borda);
        border-radius: var(--radius);
        box-shadow: var(--sombra);
        padding: 30px;
        margin-top: 50px;
      }

      @media (max-width: 700px) {
        .item-card {
          padding: 15px;
        }
      }
    </style>
</head>
<body>
<div class="bg-fallback"></div>

<!-- ===== NAVBAR ===== -->
<nav>
    <?php if ($_SESSION['perfil_usuario'] == 1): ?>
      <div class="logo"><a href="homeQuarteleiro.php">Commander</a></div>
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
    <?php else: ?>
      <li><a href="homeSolicitante.php">Voltar - Home</a></li>
    <?php endif; ?>
</nav>
    


<!-- ===== CONTEÚDO PRINCIPAL ===== -->
<div class="container">
<a href="verCarrinho.php" class="btn secundario"><img src="./img/carrinho.png" alt="Carrinho de Compras" style="width: 30px; height: 30px; vertical-align: middle;"> | Ver Carrinho </a><br>
<?php
if (isset($_GET['status'])) {
    $status = $_GET['status'];
    $mensagem = '';
    $cor = '';

    if ($status === 'qtdincompativel') {
        $mensagem = 'Falha ao adicionar no Carrinho, Quantidade Incompatível';
        $cor = '#e74c3c'; // vermelho
    }
    // Você pode adicionar mais status aqui no futuro:
    // elseif ($status === 'adicionado') {
    //     $mensagem = 'Item adicionado com sucesso!';
    //     $cor = '#27ae60';
    // }

    if ($mensagem !== '') {
       $alturaNavbar = 80; // ← mude aqui se sua navbar tiver outra altura (ex: 70px, 90px, etc)

        echo "
        <div id='notificacao-topo' style='
            position: fixed;
            top: {$alturaNavbar}px; /* ← aparece logo abaixo da navbar */
            left: 50%;
            transform: translateX(-50%);
            background: $cor;
            color: white;
            padding: 14px 28px;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.25);
            z-index: 9998; /* menor que a navbar? não tem problema, está abaixo */
            font-weight: 600;
            font-size: 1rem;
            min-width: 320px;
            max-width: 90%;
            text-align: center;
            opacity: 0;
            transform: translateX(-50%) translateY(-20px);
            transition: all 0.5s ease;
            pointer-events: none;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        '>
            " . htmlspecialchars($mensagem) . "
            <button onclick='this.parentElement.remove()' style='
                background: none;
                border: none;
                color: white;
                font-size: 1.6rem;
                cursor: pointer;
                margin-left: 15px;
                padding: 0;
                line-height: 1;
                pointer-events: all;
            '>×</button>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const notif = document.getElementById('notificacao-topo');
                if (notif) {
                    // Animação de entrada
                    setTimeout(() => {
                        notif.style.opacity = '1';
                        notif.style.transform = 'translateX(-50%) translateY(0)';
                        notif.style.pointerEvents = 'all';
                    }, 100);

                    // Remove automaticamente após 6 segundos
                    setTimeout(() => {
                        notif.style.opacity = '0';
                        notif.style.transform = 'translateX(-50%) translateY(-30px)';
                        setTimeout(() => notif.remove(), 600);
                    }, 6000);
                }
            });
        </script>
        ";
    }
}
?>

<style>
    @keyframes slideDown {
        from { 
            transform: translateY(-30px); 
            opacity: 0; 
        }
        to { 
            transform: translateY(0); 
            opacity: 1; 
        }
    }
</style>
<?php
if ($_SESSION['perfil_usuario'] == 1) {
    echo '<div class="card">';
    echo '<h2 class="section-title">Selecionar Solicitante</h2>';
    echo '<form method="post" action="addAoCarrinho.php">';
    echo '<label for="usuario">Solicitante:</label>';
    echo '<select name="usuario" id="usuario" required>';
    echo "<option value=''>====Selecione====</option>";

    $sqldireta = "SELECT * FROM usuarios";
    $resultado = mysqli_query($conexao, $sqldireta);
    while ($row = mysqli_fetch_assoc($resultado)) {
        echo "<option value='{$row['id_usuario']}'>{$row['nome_usuario']} | {$row['identidade_funcional_usuario']}</option>";
    }

    echo '</select>';
    echo '<div class="form-buttons"><button type="submit">Confirmar Solicitante</button></div>';
    echo '</form>';
    echo '</div>';
}
?>

<?php
if ($_SESSION['perfil_usuario'] == 1 and !empty($_SESSION['usuario_selecionado']) or $_SESSION['perfil_usuario'] != 1) {
?>
<!-- ===== ARMAMENTOS ===== -->
<h2 class="section-title">Armamentos</h2>
<div class="itens-grid">
  <?php foreach ($armamentos_por_tipo as $tipo => $armamentos): ?>
    <?php foreach ($armamentos as $arma): ?>
      <div class="item-card">
        <h4><?= htmlspecialchars($arma['nome_armamento']) ?></h4>
        <p><strong>Código:</strong> <?= $arma['codigo_armamento'] ?></p>
        <p><strong>Tipo:</strong> <?= htmlspecialchars($tipo) ?></p>
        <form method="post" action="addAoCarrinho.php">
          <input type="hidden" name="tipo" value="armamento">
          <input type="hidden" name="id_item" value="<?= $arma['id_armamento'] ?>">
          <input type="submit" class="btn"value="Adicionar ao Carrinho">
        </form>
      </div>
    <?php endforeach; ?>
  <?php endforeach; ?>
</div>

<hr class="section-divider">

<!-- ===== EQUIPAMENTOS ===== -->
<h2 class="section-title">Equipamentos</h2>
<div class="itens-grid">
  <?php foreach ($equipamentos_por_tipo as $tipo => $equipamentos): ?>
    <?php foreach ($equipamentos as $equipa): ?>
      <div class="item-card">
        <h4><?= htmlspecialchars($equipa['nome_equipamento']) ?></h4>
        <p><strong>Tipo:</strong> <?= htmlspecialchars($tipo) ?></p>
        <form method="post" action="addAoCarrinho.php">
          <input type="hidden" name="tipo" value="equipamento">
          <input type="hidden" name="id_item" value="<?= $equipa['id_equipamento'] ?>">
          <label>Quantidade:</label>
          <input type="number" name="quantidade_municao" required>
          <input type="submit" class="btn" value="Adicionar ao Carrinho">
        </form>
      </div>
    <?php endforeach; ?>
  <?php endforeach; ?>
</div>

<hr class="section-divider">

<!-- ===== OPERAÇÃO / MOTIVO ===== -->
<div class="final-form">
  <form method="post" action="verCarrinho.php">
    <input type="hidden" name="id_solicitacao_itens" value="<?= $id_solicitacao ?>">

    <h2 class="section-title">Operação / Motivo</h2>
    <label for="operacao">Operação:</label>
    <select name="operacao" id="operacao" required>
      <option value="">====Selecione====</option>
      <?php
      if (mysqli_num_rows($resultadoOperacoes) > 0) {
          while ($op = mysqli_fetch_assoc($resultadoOperacoes)) {
              echo "<option value='{$op['id_operacao']}'>{$op['nome_operacao']}</option>";
          }
      } else {
          echo "<option value=''>Nenhuma operação cadastrada</option>";
      }
      ?>
    </select>

    <label for="data_devolucao_item">Data de devolução prevista:</label>
    <input type="date" name="data_devolucao_item" id="data_devolucao_item" required>

    <div class="form-buttons">
      <input type="submit" value="Salvar e Ver Carrinho">
    </div>
  </form>
</div>
<?php } ?>

</div> <!-- Fim container -->

<footer>
  &copy; <?= date('Y') ?> Sistema de Solicitação
</footer>
<script>
document.addEventListener("DOMContentLoaded", function() {
  // Se há uma posição salva, rola até ela
  const scrollPos = sessionStorage.getItem("scrollPos");
  if (scrollPos) {
    window.scrollTo(0, parseInt(scrollPos));
    sessionStorage.removeItem("scrollPos"); // limpa depois
  }

  // Antes de enviar qualquer formulário, salva a posição atual
  document.querySelectorAll("form").forEach(form => {
    form.addEventListener("submit", () => {
      sessionStorage.setItem("scrollPos", window.scrollY);
    });
  });
});
</script>

</body>
</html>
