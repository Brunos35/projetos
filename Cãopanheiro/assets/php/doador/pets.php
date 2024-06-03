<?php
session_start();

require __DIR__ . '/../conexao.php';

# solicita a conexão com o banco de dados e guarda na váriavel dbh.
$dbh = Conexao::getConexao();

# cria uma instrução SQL para selecionar todos os dados na tabela usuarios.
$query = "SELECT * FROM caopanheiro.pet where doador = :doador";

# prepara a execução da query e retorna para uma variável chamada stmt.
$stmt = $dbh->prepare($query);
$stmt->bindValue(':doador', $_SESSION['usuId'], PDO::PARAM_INT);
$stmt->execute();

# devolve a quantidade de linhas retornada pela consulta a tabela.
$quantidadeRegistros = $stmt->rowCount();
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
        
    </style>
</head>

<body>
    <header>
        <button class="nav-toggle"><span class="material-symbols-outlined">
                menu
            </span></button>
        <figure class="logo"><img src="../../img/logo1.png" alt=""></figure>
        <div class="user-info">Bem-vindo, <?= $_SESSION['nome']; ?> <span id="username"></span></div>
    </header>
    <nav>
        <ul>
            <li><a href="pets.php">Meus Pet</a></li>
            <li><a href="doador_dashboard.php">Meu Perfil</a></li>
            <li><a href="../chat/listaChats.php">Conversas</a></li>
            <li><a href="../logout.php">Sair</a></li>
        </ul>
    </nav>
    <div class="content" id="conteudo">
        <h1>Meus Pets</h1>
        </section>

        <hr>

        <section>
            <table id="pet">
                <thead>
                    <tr>
                        <th id="nome">Nome</th>
                        <th id="raca">Raca</th>
                        <th>Sexo</th>
                        <th>Status</th>
                        <th colspan="2" class="acoes">Ações</th>
                    </tr>
                </thead>

                <tbody>
                    <?php if ($quantidadeRegistros == "0") : ?>
                        <tr>
                            <td colspan="3">Não existem usuários cadastrados.</td>
                        </tr>
                    <?php else : ?>
                        <?php while ($row = $stmt->fetch(PDO::FETCH_BOTH)) : ?>
                            <tr>
                                <?php $status = $row['status'] == "adotado" ? "ADOTADO" : "DISPONÍVEL"; ?>
                                <?php $_SESSION['petId'] = intval($row['petId']); ?>
                                <td><?= $row['nome']; ?></td>
                                <td><?= $row['raca']; ?></td>
                                <td><?= $row['sexo']; ?></td>
                                <td><?= $status; ?></td>
                                <td class="acoes">
                                    <button class="acoes"><a class="btnalterar" href="alterarPet.php">Alterar</a></button>
                                    <button class="acoes"><a class="btnexcluir" href="excluirPet.php" onclick="return confirm('Deseja confirmar a operação?');">Excluir</a></button>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php endif;
                    $dbh = null; ?>
                </tbody>
            </table>
        </section>
        <button id="pet"><a href="formCadastroPet.php" id="pet">Novo Pet</a></button>
    </div>

    <script src="../../js/script.js">

    </script>
</body>

</html>
