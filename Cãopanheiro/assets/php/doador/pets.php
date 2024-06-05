<?php
session_start();
require __DIR__ . '/../conexao.php';

# solicita a conexão com o banco de dados e guarda na variável dbh.
$dbh = Conexao::getConexao();

# Definindo variáveis para filtragem e paginação
$filtroStatus = isset($_GET['status']) ? $_GET['status'] : ''; // Status do pet
$filtroRaca = isset($_GET['raca']) ? $_GET['raca'] : ''; // Status do pet
$filtroPesquisa = isset($_GET['pesquisa']) ? $_GET['pesquisa'] : ''; // Status do pet
$paginaAtual = isset($_GET['pagina']) ? $_GET['pagina'] : 1; // Página atual
$porPagina = 5; // Número de registros por página

# Cria uma instrução SQL base para selecionar os dados na tabela pets onde o doador é o usuário logado.
$query = "SELECT * FROM caopanheiro.pets WHERE doador = :doador";

# Adiciona filtro de status se fornecido
if (!empty($filtroStatus)) {
    $query .= " AND status = :status";
}

# Adiciona filtro de raça se fornecido
if (!empty($filtroRaca)) {
    $query .= " AND raca LIKE :raca";
}

# Adiciona filtro de pesquisa se fornecido
if (!empty($filtroPesquisa)) {
    $query .= " AND (nome LIKE :pesquisa OR raca LIKE :pesquisa)";
}

# Prepara e executa a query novamente para obter os resultados paginados
$stmt = $dbh->prepare($query);
$stmt->bindValue(':doador', $_SESSION['usuId'], PDO::PARAM_INT);
if (!empty($filtroStatus)) {
    $stmt->bindValue(':status', $filtroStatus, PDO::PARAM_STR);
}
if (!empty($filtroRaca)) {
    $stmt->bindValue(':raca', '%' . $filtroRaca . '%', PDO::PARAM_STR);
}
if (!empty($filtroPesquisa)) {
    $stmt->bindValue(':pesquisa', '%' . $filtroPesquisa . '%', PDO::PARAM_STR);
}
$stmt->execute();

# Recupera a quantidade total de registros (sem limitação de paginação)
$quantidadeRegistros = $stmt->rowCount();

# Calcula o número total de páginas
$totalPaginas = ceil($quantidadeRegistros / $porPagina);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Área Restrita</title>
    <link rel="stylesheet" href="../../css/dashboards.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <style>
        form {
            margin-bottom: 20px;
            height: 40px;
        }

        label {margin-right: 10px;}

        select,
        input[type="text"] {
            padding: 5px;
            border: 1px solid #ccc;
            border-radius: 3px;
            margin-right: 10px;
        }

        button[type="submit"] {
            padding: 5px 10px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }

        button[type="submit"]:hover {background-color: #0056b3;}

        input[type="text"] {width: 200px;}
    </style>
</head>

<body>
    <header>
        <button class="nav-toggle"><span class="material-symbols-outlined">menu</span></button>
        <figure class="logo"><img src="../../img/logo1.png" alt=""></figure>
        <div class="user-info">Bem-vindo, <?= htmlspecialchars($_SESSION['nome'], ENT_QUOTES, 'UTF-8'); ?> <span id="username"></span></div>
    </header>
    <nav>
        <ul>
            <li><a href="pets.php">Meus Pet</a></li>
            <li><a href="doador_dashboard.php">Meu Perfil</a></li>
            <li><a href="chatsDoador.php">Conversas</a></li>
            <li><a href="../logout.php">Sair</a></li>
        </ul>
    </nav>
    <div class="content" id="conteudo">
        <h1>Meus Pets</h1>

        <hr>
        <!--formulário de filtro-->
        <form action="" method="GET">
            <label for="status">Filtrar por status:</label>
            <select name="status" id="status">
                <option value="">Todos</option>
                <option value="adotado">Adotado</option>
                <option value="disponivel">Disponível</option>
            </select>
            <label for="raca">Filtrar por raça:</label>
            <input type="text" name="raca" id="raca" placeholder="Raça">
            <label for="pesquisa">Pesquisar:</label>
            <input type="text" name="pesquisa" id="pesquisa" placeholder="Digite aqui...">
            <button type="submit">Filtrar</button>
        </form>

        <section>
            <table id="pet">
                <thead>
                    <tr>
                        <th id="nome">Nome</th>
                        <th id="raca">Raça</th>
                        <th>Sexo</th>
                        <th>Status</th>
                        <th colspan="2" class="acoes">Ações</th>
                    </tr>
                </thead>

                <tbody>
                    <?php if ($quantidadeRegistros == 0) : ?>
                        <tr>
                            <td colspan="5">Não existem pets cadastrados.</td>
                        </tr>
                    <?php else : ?>
                        <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) : ?>
                            <tr>
                                <?php $status = $row['status'] == "adotado" ? "ADOTADO" : "DISPONÍVEL"; ?>
                                <td><?= htmlspecialchars($row['nome'], ENT_QUOTES, 'UTF-8'); ?></td>
                                <td><?= htmlspecialchars($row['raca'], ENT_QUOTES, 'UTF-8'); ?></td>
                                <td><?= htmlspecialchars($row['sexo'], ENT_QUOTES, 'UTF-8'); ?></td>
                                <td><?= htmlspecialchars($status, ENT_QUOTES, 'UTF-8'); ?></td>
                                <td class="acoes">
                                    <button class="acoes"><a class="btnalterar" href="alterarPet.php?Id=<?= intval($row['petId']); ?>">Alterar</a></button>
                                    <button class="acoes"><a class="btnexcluir" href="excluirPet.php?Id=<?= intval($row['petId']); ?>" onclick="return confirm('Deseja confirmar a operação?');">Excluir</a></button>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php endif; ?>
                    <?php $dbh = null; ?>
                </tbody>
            </table>
        </section>

        <div class="pagination">
            <?php for ($i = 1; $i <= $totalPaginas; $i++) : ?>
                <a href="?pagina=<?= $i ?><?= !empty($filtroStatus) ? '&status=' . $filtroStatus : '' ?>"><?= $i ?></a>
            <?php endfor; ?>
        </div>

        <button id="pet"><a href="formCadastroPet.php" id="pet">Novo Pet</a></button>
    </div>

    <script src="../../js/script.js"></script>
</body>

</html>