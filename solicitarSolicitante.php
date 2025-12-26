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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solicitação</title>
    <link rel="stylesheet" href="style.css">
    <style>
      /* ====== SEUS ESTILOS ORIGINAIS – NADA ALTERADO ====== */
      h1, h2, h3 { margin-bottom: 15px; }

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

      .item-card:hover { transform: scale(1.01); }

      .item-card h4 { margin-bottom: 8px; color: var(--cor-texto); }

      .item-card form { margin-top: 10px; }

      .item-card input[type="submit"] { width: 100%; }

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

      /* RESPONSIVIDADE EXTRA NO CELULAR (opcional – deixa os cards maiores) */
      @media (max-width: 768px) {
        .itens-grid { grid-template-columns: 1fr; gap: 18px; }
        .item-card { padding: 22px; }
        .item-card h4 { font-size: 1.3rem; }
        .item-card input[type="submit"],
        .item-card input[type="number"] { padding: 14px; font-size: 1.1rem; }
      }
    </style>
</head>
<body>
<div class="bg-fallback"></div>

<!-- HEADER ADICIONADO (essencial pro style.css funcionar) -->
<header>
    <nav>
        <?php if ($_SESSION['perfil_usuario'] == 1): ?>
                <div class="logo"><a href="homeQuarteleiro.php"><img src="./img/home.png" alt="Home" style="width: 28px; vertical-align: middle-top;"><span> COMMANDER</span></a></div>

          <ul>
            <li><a href="equipamentos.php" class="ativo">Equipamentos / Armamentos</a></li>
            <li><a href="operacoes.php">Operações</a></li>
            <li><a href="solicitacoesQuarteleiro.php">Solicitações</a></li>
            <li><a href="solicitacoesVtr.php">Solicitações Viatura</a></li>
            <li><a href="solicitarSolicitante.php">Solicitação Direta</a></li>
            <li><a href="listarUsuarios.php">Usuários</a></li>
            <li><a href="cadastrarQuarteleiro.php">Cadastrar Quarteleiro</a></li>
            <li><a href="editarPerfil.php">Perfil</a></li>
            <li><a href="logout.php"><img src="./img/logout.png" alt="Logout" style="width: 30px; height: 30px; vertical-align: middle;"></a></li>
          </ul>
        <?php else: ?>
          <div class="logo"><a href="homeSolicitante.php"><img src="./img/home.png" alt="Home" style="width: 28px; vertical-align: middle-top;"><span> COMMANDER</span></a></div>
          <ul>
            <li><a href="solicitarSolicitante.php">Solicitar Itens</a></li>
            <li><a href="checkListVtr.php">Solicitar Viatura</a></li>
            <li><a href="solicitacoesAnterioresSolicitante.php" class="ativo">Solicitações Anteriores</a></li>
            <li><a href="editarPerfil.php">Perfil</a></li>
            <li><a href="logout.php"><img src="./img/logout.png" alt="Logout" style="width: 30px; height: 30px; vertical-align: middle;"></a></li>
          </ul>
        <?php endif; ?>
    </nav>
</header>

<!-- MAIN + CONTAINER (trocado de <div class="container"> para <main class="container">) -->
<main class="container">
<a href="verCarrinho.php" class="btn secundario"><img src="./img/carrinho.png" alt="Carrinho de Compras" style="width: 30px; height: 30px; vertical-align: middle;"> | Ver Carrinho </a><br>

<?php
// === NOTIFICAÇÃO ===
if (isset($_GET['status']) && $_GET['status'] === 'qtdincompativel') {
    echo "<div id='notificacao-topo' style='position:fixed;top:90px;left:50%;transform:translateX(-50%);background:#e74c3c;color:white;padding:14px 28px;border-radius:12px;box-shadow:0 10px 30px rgba(0,0,0,0.25);z-index:9999;font-weight:600;text-align:center;animation:slideDown .5s ease'>
            Quantidade incompatível com o estoque!
            <button onclick='this.parentElement.remove()' style='background:none;border:none;color:white;font-size:1.8rem;cursor:pointer;margin-left:10px;'>×</button>
          </div>
          <style>@keyframes slideDown{from{opacity:0;transform:translateX(-50%) translateY(-20px)}to{opacity:1;transform:translateX(-50%)}}</style>";
}
?>

<?php if ($_SESSION['perfil_usuario'] == 1): ?>

<div class="card">
    <h2 class="section-title">Solicitante</h2>

    <?php if (!empty($_SESSION['usuario_selecionado'])): ?>
        <?php
        $idUsuario = $_SESSION['usuario_selecionado'];
        $sql = "SELECT nome_usuario, identidade_funcional_usuario 
                FROM usuarios 
                WHERE id_usuario = $idUsuario";
        $res = mysqli_query($conexao, $sql);
        $dados = mysqli_fetch_assoc($res);
        ?>

        <p><strong>Nome:</strong> <?= $dados['nome_usuario'] ?></p>
        <p><strong>Identidade Funcional:</strong> <?= $dados['identidade_funcional_usuario'] ?></p>

        <hr>
<br>
        <form method="post" action="addAoCarrinho.php">
            <label>Alterar solicitante:</label>
            <select name="usuario">
                <option value="">— manter atual —</option>
                <?php
                $sqldireta = "SELECT * FROM usuarios";
                $resultado = mysqli_query($conexao, $sqldireta);
                while ($row = mysqli_fetch_assoc($resultado)) {
                    echo "<option value='{$row['id_usuario']}'>
                            {$row['nome_usuario']} | {$row['identidade_funcional_usuario']}
                          </option>";
                }
                ?>
            </select>

            <div class="form-buttons">
                <button type="submit">Alterar</button>
            </div>
        </form>

    <?php else: ?>

        <form method="post" action="addAoCarrinho.php">
            <label for="usuario">Selecionar solicitante:</label>
            <select name="usuario" id="usuario" required>
                <option value="">==== Selecione ====</option>
                <?php
                $sqldireta = "SELECT * FROM usuarios";
                $resultado = mysqli_query($conexao, $sqldireta);
                while ($row = mysqli_fetch_assoc($resultado)) {
                    echo "<option value='{$row['id_usuario']}'>
                            {$row['nome_usuario']} | {$row['identidade_funcional_usuario']}
                          </option>";
                }
                ?>
            </select>

            <div class="form-buttons">
                <button type="submit">Confirmar</button>
            </div>
        </form>

    <?php endif; ?>
</div>

<?php endif; ?>


<?php if ($_SESSION['perfil_usuario'] == 1 && !empty($_SESSION['usuario_selecionado']) || $_SESSION['perfil_usuario'] != 1): ?>

<br><br>
  <div class="card" style="margin-bottom: 30px;">
    <label for="busca-material"><strong>Pesquisar material</strong></label>
    <input
        type="text"
        id="busca-material"
        placeholder="Digite nome, código ou tipo..."
        style="width:100%; padding:12px; font-size:1rem;"
    >
</div>

<h2 class="section-title">Armamentos</h2>
<div class="itens-grid">
  <?php foreach ($armamentos_por_tipo as $tipo => $armamentos): ?>
    <?php foreach ($armamentos as $arma): ?>
      <div class="item-card material-card"
     data-nome="<?= strtolower($arma['nome_armamento']) ?>"
     data-codigo="<?= strtolower($arma['codigo_armamento']) ?>"
     data-tipo="<?= strtolower($tipo) ?>">

        <h4><?= htmlspecialchars($arma['nome_armamento']) ?></h4>
        <p><strong>Código:</strong> <?= $arma['codigo_armamento'] ?></p>
        <p><strong>Tipo:</strong> <?= htmlspecialchars($tipo) ?></p>
        <form method="post" action="addAoCarrinho.php">
          <input type="hidden" name="tipo" value="armamento">
          <input type="hidden" name="id_item" value="<?= $arma['id_armamento'] ?>">
          <input type="submit" class="btn" value="Adicionar ao Carrinho">
        </form>
      </div>
    <?php endforeach; ?>
  <?php endforeach; ?>
</div>

<hr class="section-divider">

<h2 class="section-title">Equipamentos</h2>
<div class="itens-grid">
  <?php foreach ($equipamentos_por_tipo as $tipo => $equipamentos): ?>
    <?php foreach ($equipamentos as $equipa): ?>
      <div class="item-card material-card"
     data-nome="<?= strtolower($equipa['nome_equipamento']) ?>"
     data-tipo="<?= strtolower($tipo) ?>">
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
<?php endif; ?>
<!-- BOTÃO FIXO PARA IR AO FINAL DA PÁGINA -->
<button id="btn-ir-final" title="Finalizar Solicitação">
    Finalizar Solicitação
</button>


<style>
    #btn-ir-final {
        position: fixed;
        bottom: 25px;
        right: 25px;
        background: var(--cor-principal, #006633);
        color: white;
        border: none;
        border-radius: 50px;
        padding: 14px 20px;
        font-size: 1rem;
        font-weight: 600;
        box-shadow: 0 6px 20px rgba(0,0,0,0.3);
        cursor: pointer;
        z-index: 1000;
        display: flex;
        align-items: center;
        gap: 10px;
        transition: all 0.3s ease;
    }

    #btn-ir-final:hover {
        background: #004d26;
        transform: translateY(-3px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.4);
    }

    #btn-ir-final::after {
        font-size: 1.4rem;
    }

    /* Esconde no desktop se quiser (opcional) */
    @media (min-width: 992px) {
        #btn-ir-final {
            bottom: 30px;
            right: 30px;
            padding: 16px 24px;
            font-size: 1.1rem;
        }
    }

    /* Esconde quando já está no final (opcional – muito útil) */
    
</style>

<script>
const btn = document.getElementById('btn-ir-final');

window.addEventListener('scroll', function () {
    const footer = document.querySelector('footer');
    if (!btn || !footer) return;

    const footerRect = footer.getBoundingClientRect();
    const windowHeight = window.innerHeight;

    const chegouNoFinal = footerRect.top <= windowHeight;

    if (chegouNoFinal) {
        // sobe o botão pra não ficar atrás do footer
        btn.style.bottom = (windowHeight - footerRect.top + 20) + 'px';

        // muda texto e seta
        btn.innerHTML = 'Voltar ao topo <span style="font-size:1.4rem;">↑</span>';
        btn.onclick = () => window.scrollTo({ top: 0, behavior: 'smooth' });

    } else {
        // posição normal
        btn.style.bottom = '25px';

        // texto original
        btn.innerHTML = 'Finalizar Solicitação <span style="font-size:1.4rem;">↓</span>';
        btn.onclick = () => window.scrollTo({ top: document.body.scrollHeight, behavior: 'smooth' });
    }
});
</script>

</main>


<footer>
&copy; <?php echo date("Y"); ?> COMMANDER - Sistema de Gerenciamento de Quartelaria
</footer>

<script>
document.addEventListener("DOMContentLoaded", function() {
  const scrollPos = sessionStorage.getItem("scrollPos");
  if (scrollPos) {
    window.scrollTo(0, parseInt(scrollPos));
    sessionStorage.removeItem("scrollPos");
  }
  document.querySelectorAll("form").forEach(form => {
    form.addEventListener("submit", () => {
      sessionStorage.setItem("scrollPos", window.scrollY);
    });
  });
});
</script>
<!-- separei os scripts em blocos pra ficar mais de boa de localizar -->
<script>
function normalizarTexto(texto) {
    return texto
        .toLowerCase()
        .normalize("NFD")
        .replace(/[\u0300-\u036f]/g, "");
}

document.addEventListener("DOMContentLoaded", function () {
    const campoBusca = document.getElementById("busca-material");
    if (!campoBusca) return;

    campoBusca.addEventListener("input", function () {
        const termo = normalizarTexto(this.value);
        const cards = document.querySelectorAll(".material-card");

        cards.forEach(card => {
            const nome = normalizarTexto(card.dataset.nome || "");
            const codigo = normalizarTexto(card.dataset.codigo || "");
            const tipo = normalizarTexto(card.dataset.tipo || "");

            const corresponde =
                nome.includes(termo) ||
                codigo.includes(termo) ||
                tipo.includes(termo);

            card.style.display = corresponde ? "block" : "none";
        });
    });
});
</script>

</body>
</html>