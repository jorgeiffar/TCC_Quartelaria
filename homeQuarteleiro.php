<?php
include("conecta.php");

session_start();
if(!isset($_SESSION['id_usuario']) || $_SESSION['perfil_usuario'] !=1){
    header("Location: login.php?status=nao_autorizado");
    exit();
}

$query = "SELECT si.id_solicitacao, si.data_solicitacao, si.data_devolucao_item, si.status_solicitacao,
                 u.nome_usuario, si.tipo_item, si.id_item,
                 e.nome_equipamento, e.tipo_equipamento,
                 a.nome_armamento, a.tipo_armamento
          FROM solicitacao_itens si
          JOIN usuarios u ON si.id_usuario = u.id_usuario
          LEFT JOIN equipamentos e ON si.id_item = e.id_equipamento AND si.tipo_item = 'equipamento'
          LEFT JOIN armamentos a ON si.id_item = a.id_armamento AND si.tipo_item = 'armamento'
          WHERE si.status_solicitacao = 'Aceito'
          ORDER BY si.id_solicitacao";

$resultado = mysqli_query($conexao, $query);

$id_atual = 0;
$equipamentos = "";
$armamentos = "";
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Empréstimos</title>
</head>
<body>
<a href="equipamentos.php">Equipamentos - Armamentos</a> |
<a href="operacoes.php">Operações</a> |
<a href="solicitacoesQuarteleiro.php">Solicitações</a> |
<a href="solicitacoesVtr.php">Solicitações Viatura</a> |
<a href="solicitarSolicitante.php">Solicitação Direta</a> |
<a href="listarUsuarios.php">Visualizar Usuários</a> |
<a href="cadastrarQuarteleiro.php">Cadastrar Novo Quarteleiro</a> |==========|
<a href="editarPerfil.php">Editar Perfil</a> |
<a href="logout.php">Logout ->|</a>

<h1>Empréstimos</h1>
<hr>
<?php
if(mysqli_num_rows($resultado)<=0){
    echo "Nenhum Empréstimo Ativo";
}else{
echo "<table border='1'>
        <tr>
            <th>Usuário</th>
            <th>Equipamentos</th>
            <th>Armamentos</th>
            <th>Datas</th>
            <th>Status</th>
            <th>Opções</th>
        </tr>";

while ($dados = mysqli_fetch_assoc($resultado)) {
    $id = $dados['id_solicitacao'];

    // quando mudar de solicitação, imprime a anterior
    if ($id != $id_atual && $id_atual != 0) {
        echo "<tr>
                <td>$nome</td>
                <td>$equipamentos</td>
                <td>$armamentos</td>
                <td>$data_solicitacao - $data_devolucao</td>
                <td>$status</td>
                <td><a href='verDetalhesEmprestimo.php?id=$id_atual'>Ver detalhes</a></td>
              </tr>";

        // Limpa os acumuladores
        $equipamentos = "";
        $armamentos = "";
    }

    // Atualiza os dados principais da solicitação
    if ($id != $id_atual) {
        $id_atual = $id;
        $nome = $dados['nome_usuario'];
        $data_solicitacao = date("d/m/Y", strtotime($dados['data_solicitacao']));
        $data_devolucao = date("d/m/Y", strtotime($dados['data_devolucao_item']));
        $status = $dados['status_solicitacao'];
    }

    // Acumula os itens
    if ($dados['tipo_item'] == 'equipamento') {
        $equipamentos .= $dados['tipo_equipamento'] . " - " . $dados['nome_equipamento'] . "<br>";
    } elseif ($dados['tipo_item'] == 'armamento') {
        $armamentos .= $dados['tipo_armamento'] . " - " . $dados['nome_armamento'] . "<br>";
    }
}

// Imprime o último grupo
if ($id_atual != 0) {
    echo "<tr>
            <td>$nome</td>
            <td>$equipamentos</td>
            <td>$armamentos</td>
            <td>$data_solicitacao - $data_devolucao</td>
            <td>$status</td>
            <td><a href='verDetalhesEmprestimo.php?id=$id_atual'>Ver detalhes</a></td>
          </tr>";
}

echo "</table>";
}
?>
