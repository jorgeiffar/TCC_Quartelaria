<?php
include("conecta.php");
session_start();

// Verifica permissão
if(!isset($_SESSION['id_usuario']) || $_SESSION['perfil_usuario'] != 1){
    header("Location: login.php?status=nao_autorizado");
    exit();
}

// Pega id via GET
if(isset($_GET['id'])){
    $id = intval($_GET['id']);
    $query = "SELECT * FROM armamentos WHERE id_armamento = '$id'";
    $result = mysqli_query($conexao, $query);
    $dados = mysqli_fetch_assoc($result);
} else {
    echo "ID não informado.";
    exit();
}

// Se o formulário foi enviado (atualização geral e possivelmente alteração do código)
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    // limpar entradas
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

    // Se o usuário habilitou a edição do nº de série, valide e atualize
    if(isset($_POST['allow_serial_edit']) && $_POST['allow_serial_edit'] == '1'){
        $codigo_antigo = mysqli_real_escape_string($conexao, $_POST['codigo_antigo'] ?? '');
        $novo_codigo = mysqli_real_escape_string($conexao, $_POST['novo_codigo'] ?? '');

        // Recarrega o valor atual do BD para garantir comparação segura
        $q2 = "SELECT codigo_armamento FROM armamentos WHERE id_armamento = $id";
        $r2 = mysqli_query($conexao, $q2);
        $row = mysqli_fetch_assoc($r2);
        $codigo_atual_bd = $row['codigo_armamento'];

        if($codigo_antigo === $codigo_atual_bd){
            // Atualiza apenas se bateu com o código atual do BD
            $q_up = "UPDATE armamentos SET codigo_armamento = '$novo_codigo' WHERE id_armamento = $id";
            $r_up = mysqli_query($conexao, $q_up);
            if(!$r_up){
                $erro_serial = "Erro ao atualizar nº de série: " . mysqli_error($conexao);
            } else {
                $sucesso_serial = "Nº de série atualizado com sucesso.";
            }
        } else {
            $erro_serial = "Código atual informado não confere com o registro. Edição cancelada.";
        }
    }

    // Depois de atualizar, recarrega os dados para mostrar no formulário
    $q3 = "SELECT * FROM armamentos WHERE id_armamento = '$id'";
    $r3 = mysqli_query($conexao, $q3);
    $dados = mysqli_fetch_assoc($r3);

    // mensagem opcional de sucesso geral (não redireciono automaticamente para você ver a confirmação)
    if(!isset($erro_serial)){
        $sucesso_geral = "Dados atualizados com sucesso.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Armamento - Quartelaria</title>
    <style>
        .serie-box { display: none; margin-top: 8px; padding:8px; border:1px solid #ccc; background:#fafafa; }
        .msg-erro { color: #b00020; }
        .msg-ok { color: #006600; }
    </style>
</head>
<body>
    <a href="verDetalhesItens.php">Voltar</a><br>
    <a href="homeQuarteleiro.php">Home</a>

    <h1>Editar Armamento</h1>

    <?php if(isset($sucesso_geral)) echo "<p class='msg-ok'>{$sucesso_geral}</p>"; ?>
    <?php if(isset($sucesso_serial)) echo "<p class='msg-ok'>{$sucesso_serial}</p>"; ?>
    <?php if(isset($erro_serial)) echo "<p class='msg-erro'>{$erro_serial}</p>"; ?>

    <form action="" method="post" id="formEdicao">
        Nome do Armamento:
        <input type="text" name="nome_armamento" value="<?=htmlspecialchars($dados['nome_armamento'])?>" required><br>

        Tipo de Armamento:
        <select name="tipo_armamento" required>
            <option value="">Selecione</option>
            <option value="Fuzil" <?= ($dados['tipo_armamento'] == 'Fuzil') ? 'selected' : '' ?>>Fuzil</option>
            <option value="Pistola" <?= ($dados['tipo_armamento'] == 'Pistola') ? 'selected' : '' ?>>Pistola</option>
            <option value="Carabina" <?= ($dados['tipo_armamento'] == 'Carabina') ? 'selected' : '' ?>>Carabina</option>
            <option value="Espingarda" <?= ($dados['tipo_armamento'] == 'Espingarda') ? 'selected' : '' ?>>Espingarda</option>
            <option value="Submetralhadora" <?= ($dados['tipo_armamento'] == 'Submetralhadora') ? 'selected' : '' ?>>Submetralhadora</option>
        </select>
        <br>
        Calibre:
        <select name="calibre_armamento" required>
            <option value="">Selecione</option>
            <option value="5,56" <?= ($dados['calibre_armamento'] == '5,56') ? 'selected' : '' ?>>5,56</option>
            <option value="7,62" <?= ($dados['calibre_armamento'] == '7,62') ? 'selected' : '' ?>>7,62</option>
            <option value="9mm" <?= ($dados['calibre_armamento'] == '9mm') ? 'selected' : '' ?>>9mm</option>
            <option value="12GA" <?= ($dados['calibre_armamento'] == '12GA') ? 'selected' : '' ?>>12GA</option>
        </select>
        <br>

        <!-- Exibe o código atual, mas desabilitado -->
        Número de Série:
        <input type="text" id="codigoMostrado" value="<?=htmlspecialchars($dados['codigo_armamento'])?>" disabled>
        <button type="button" id="btnEditarSerie">Editar Nº de Série</button>
        <br>

        <!-- Bloco que só aparece quando o usuário clicar em "Editar Nº de Série" -->
        <div class="serie-box" id="serieBox">
            <p>Para evitar erros, confirme o código atual e insira o novo código.</p>
            Código atual (confirmação):<br>
            <input type="text" name="codigo_antigo" placeholder="Digite o código atual"><br><br>

            Novo código:<br>
            <input type="text" name="novo_codigo" placeholder="Digite o novo código"><br><br>

            <!-- flag para o servidor saber que deve tentar editar o serial -->
            <input type="hidden" name="allow_serial_edit" id="allow_serial_edit" value="0">
        </div>

        <br>
        <input type="submit" value="Salvar Alterações">
    </form>

    <script>
        const btn = document.getElementById('btnEditarSerie');
        const box = document.getElementById('serieBox');
        const flag = document.getElementById('allow_serial_edit');

        btn.addEventListener('click', function(){
            // Pergunta de confirmação simples no cliente (notificacao do navegador). A verificação real é feita no servidor.
            const confirmar = confirm("Você quer habilitar a edição do Nº de Série? Esta ação requer que você digite o código atual para confirmar.");
            if(confirmar){
                box.style.display = 'block';
                flag.value = '1'; // habilita edição na submissão
                // mover o foco para o campo de confirmação
                box.querySelector('input[name="codigo_antigo"]').focus();
            }
        });
    </script>
</body>
</html>
