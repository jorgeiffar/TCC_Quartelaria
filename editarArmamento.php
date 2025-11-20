<?php
include("conecta.php");
session_start();

// Verifica permissão
if(!isset($_SESSION['id_usuario']) || $_SESSION['perfil_usuario'] != 1){
    header("Location: login.php?status=nao_autorizado");
    exit();
}

// Inicializa variáveis
$sucesso_geral = $sucesso_serial = $erro_serial = null;
$show_serie_box = false;

// Pega id via GET
if(isset($_GET['id'])){
    $id = intval($_GET['id']);
    $query = "SELECT * FROM armamentos WHERE id_armamento = '$id'";
    $result = mysqli_query($conexao, $query);
    $dados = mysqli_fetch_assoc($result);
    if(!$dados){
        echo "Armamento não encontrado.";
        exit();
    }
} else {
    echo "ID não informado.";
    exit();
}

// Se o formulário foi enviado (atualização geral e possivelmente alteração do código)
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    // limpar entradas (mantém valor antigo se campo não vier)
    $nome = mysqli_real_escape_string($conexao, $_POST['nome_armamento'] ?? $dados['nome_armamento']);
    $tipo = mysqli_real_escape_string($conexao, $_POST['tipo_armamento'] ?? $dados['tipo_armamento']);
    $calibre = mysqli_real_escape_string($conexao, $_POST['calibre_armamento'] ?? $dados['calibre_armamento']);

    // Atualiza campos gerais (sempre)
    $query = "UPDATE armamentos 
              SET nome_armamento = '$nome',
                  tipo_armamento = '$tipo',
                  calibre_armamento = '$calibre'
              WHERE id_armamento = $id";
    mysqli_query($conexao, $query);

    // Se o usuário habilitou a edição do nº de série
    if(isset($_POST['allow_serial_edit']) && $_POST['allow_serial_edit'] == '1'){
        $show_serie_box = true; // mantém a área visível após submit caso precise corrigir
        $codigo_antigo = mysqli_real_escape_string($conexao, $_POST['codigo_antigo'] ?? '');
        $novo_codigo = mysqli_real_escape_string($conexao, $_POST['novo_codigo'] ?? '');

        // Recarrega o valor atual do BD (garantia de comparação)
        $q2 = "SELECT codigo_armamento FROM armamentos WHERE id_armamento = $id";
        $r2 = mysqli_query($conexao, $q2);
        $row = mysqli_fetch_assoc($r2);
        $codigo_atual_bd = $row['codigo_armamento'] ?? '';

        if($codigo_antigo === $codigo_atual_bd){
            $q_up = "UPDATE armamentos SET codigo_armamento = '$novo_codigo' WHERE id_armamento = $id";
            $r_up = mysqli_query($conexao, $q_up);
            if(!$r_up){
                $erro_serial = "Erro ao atualizar nº de série: " . mysqli_error($conexao);
            } else {
                $sucesso_serial = "Nº de série atualizado com sucesso.";
                $show_serie_box = false; // se deu certo, pode ocultar
            }
        } else {
            $erro_serial = "Código atual informado não confere com o registro. Edição cancelada.";
        }
    }

    // Recarrega dados (para mostrar valores atualizados)
    $q3 = "SELECT * FROM armamentos WHERE id_armamento = '$id'";
    $r3 = mysqli_query($conexao, $q3);
    $dados = mysqli_fetch_assoc($r3);

    if(!isset($erro_serial) && !isset($sucesso_serial)){
        $sucesso_geral = "Dados atualizados com sucesso.";
    } elseif(!isset($erro_serial) && isset($sucesso_serial)){
        // mostra apenas sucesso do serial (já tratado)
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Armamento - Quartelaria</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* Garante que a área do número de série só apareça após confirmação */
        .serie-box {
            display: none; /* padrão: escondido */
            margin-top: 12px;
            padding: 12px;
            border: 1px solid #ccc;
            background: #f8f8f8;
            border-radius: 6px;
        }
        .serie-box.show { display: block; }
        .msg-ok { color: #007a00; font-weight: 600; }
        .msg-erro { color: #b00020; font-weight: 600; }
        label { display:block; margin-top:8px; font-weight:500; }
        input[type="text"], select { width:100%; max-width:420px; padding:8px; margin-top:4px; box-sizing:border-box; }
        input[type="submit"], button { padding:8px 12px; margin-top:10px; cursor:pointer; }
        .links-topo { margin-bottom:10px; }
        .card { padding:16px; border-radius:8px; background:#fff; box-shadow:0 1px 3px rgba(0,0,0,0.06); max-width:900px; }
    </style>
</head>
<body>
    <header>
        <nav>
            <div class="logo" ><a href="homeQuarteleiro.php">Commander</a></div>
            <ul>
                <li><a href="equipamentos.php">Equipamentos / Armamentos</a></li>
                <li><a href="operacoes.php">Operações</a></li>
                <li><a href="solicitacoesQuarteleiro.php">Solicitações</a></li>
                <li><a href="solicitacoesVtr.php">Solicitações Viatura</a></li>
                <li><a href="solicitarSolicitante.php">Solicitação Direta</a></li>
                <li><a href="listarUsuarios.php">Usuários</a></li>
                <li><a href="cadastrarQuarteleiro.php">Cadastrar Quarteleiro</a></li>
                <li><a href="editarPerfil.php">Editar Perfil</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>

    <main class="container">
        <section>
            <h1>Editar Armamento</h1>
            <hr>

            <div class="card">
                <div class="links-topo">
                    <a href="verDetalhesItens.php">Voltar</a> |
                    <a href="homeQuarteleiro.php">Home</a>
                </div>

                <?php if(!empty($sucesso_geral)) echo "<p class='msg-ok'>".htmlspecialchars($sucesso_geral)."</p>"; ?>
                <?php if(!empty($sucesso_serial)) echo "<p class='msg-ok'>".htmlspecialchars($sucesso_serial)."</p>"; ?>
                <?php if(!empty($erro_serial)) echo "<p class='msg-erro'>".htmlspecialchars($erro_serial)."</p>"; ?>

                <form action="" method="post" id="formEdicao" autocomplete="off">
                    <label for="nome_armamento">Nome do Armamento:</label>
                    <input id="nome_armamento" type="text" name="nome_armamento" value="<?=htmlspecialchars($dados['nome_armamento'] ?? '')?>" required>

                    <label for="tipo_armamento">Tipo de Armamento:</label>
                    <select id="tipo_armamento" name="tipo_armamento" required>
                        <option value="">Selecione</option>
                        <option value="Fuzil" <?= (isset($dados['tipo_armamento']) && $dados['tipo_armamento'] == 'Fuzil') ? 'selected' : '' ?>>Fuzil</option>
                        <option value="Pistola" <?= (isset($dados['tipo_armamento']) && $dados['tipo_armamento'] == 'Pistola') ? 'selected' : '' ?>>Pistola</option>
                        <option value="Carabina" <?= (isset($dados['tipo_armamento']) && $dados['tipo_armamento'] == 'Carabina') ? 'selected' : '' ?>>Carabina</option>
                        <option value="Espingarda" <?= (isset($dados['tipo_armamento']) && $dados['tipo_armamento'] == 'Espingarda') ? 'selected' : '' ?>>Espingarda</option>
                        <option value="Submetralhadora" <?= (isset($dados['tipo_armamento']) && $dados['tipo_armamento'] == 'Submetralhadora') ? 'selected' : '' ?>>Submetralhadora</option>
                    </select>

                    <label for="calibre_armamento">Calibre:</label>
                    <select id="calibre_armamento" name="calibre_armamento" required>
                        <option value="">Selecione</option>
                        <option value="5,56" <?= (isset($dados['calibre_armamento']) && $dados['calibre_armamento'] == '5,56x45mm') ? 'selected' : '' ?>>5,56x45mm</option>
                        <option value="7,62" <?= (isset($dados['calibre_armamento']) && $dados['calibre_armamento'] == '7,62x51mm') ? 'selected' : '' ?>>7,62x51mm</option>
                        <option value="9mm" <?= (isset($dados['calibre_armamento']) && $dados['calibre_armamento'] == '9mm') ? 'selected' : '' ?>>9mm</option>
                        <option value="12GA" <?= (isset($dados['calibre_armamento']) && $dados['calibre_armamento'] == '12GA') ? 'selected' : '' ?>>12GA</option>
                    </select>

                    <label>Número de Série:</label>
                    <input type="text" id="codigoMostrado" value="<?=htmlspecialchars($dados['codigo_armamento'] ?? '')?>" disabled style="max-width:300px; display:inline-block;">
                    <button type="button" id="btnEditarSerie">Editar Nº de Série</button>

                    <!-- Área do serial: exibida somente após confirmação do confirm() ou se o POST veio com allow_serial_edit=1 -->
                    <div class="serie-box <?= $show_serie_box ? 'show' : '' ?>" id="serieBox" aria-hidden="<?= $show_serie_box ? 'false' : 'true' ?>">
                        <hr>
                        <p><strong>Confirme o código atual e insira o novo número de série:</strong></p>

                        <label for="codigo_antigo">Código atual (confirmação):</label>
                        <input id="codigo_antigo" type="text" name="codigo_antigo" placeholder="Digite o código atual" value="">

                        <label for="novo_codigo">Novo número de série:</label>
                        <input id="novo_codigo" type="text" name="novo_codigo" placeholder="Digite o novo código" value="">

                        <!-- flag para o servidor saber que deve tentar editar o serial -->
                        <input type="hidden" name="allow_serial_edit" id="allow_serial_edit" value="<?= ($show_serie_box ? '1' : '0') ?>">
                    </div>

                     <input type="submit" value="Salvar Alterações" class="btn primario">
                    <a href="verDetalhesItens.php" class="btn secundario">Cancelar</a>
                </form>
            </div>
        </section>
    </main>

    <footer>
       &copy; <?php echo date("Y"); ?> COMMANDER - Sistema de Gerenciamento de Quartelaria
    </footer>

    <script>
        (function(){
            const btn = document.getElementById('btnEditarSerie');
            const box = document.getElementById('serieBox');
            const flag = document.getElementById('allow_serial_edit');

            btn.addEventListener('click', function(){
                // Confirmação no cliente — a verificação real do serial é feita no servidor
                const confirmar = confirm("Você quer habilitar a edição do Nº de Série? Esta ação requer que você confirme o código atual.");
                if(confirmar){
                    box.classList.add('show');
                    box.setAttribute('aria-hidden','false');
                    flag.value = '1';
                    const campoConfirm = box.querySelector('input[name=\"codigo_antigo\"]');
                    if(campoConfirm) campoConfirm.focus();
                } else {
                    // garante que continue escondido e flag fica 0
                    box.classList.remove('show');
                    box.setAttribute('aria-hidden','true');
                    flag.value = '0';
                }
            });

            // Segurança UX: se o usuário pressionar Enter dentro dos campos do serial,
            // o formulário será submetido normalmente (com allow_serial_edit = 1 quando visível).
            // Não precisamos de código extra aqui.
        })();
    </script>
</body>
</html>
