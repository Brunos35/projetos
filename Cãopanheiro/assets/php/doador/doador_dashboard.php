<?php
session_start();
require __DIR__ . '/../conexao.php';

$dbh = Conexao::getConexao();

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Área Restrita</title>
    <link rel="stylesheet" href="../../css/usuario.css">
    <link rel="stylesheet" href="../../css/dashboards.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
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
            <li><a href="#">Conversas</a></li>
            <li><a href="../../index.html">Página Inicial</a></li>
            <li><a href="">Sair</a></li>
        </ul>
    </nav>
    <main>
        <div class="content" id="conteudo">
            <h1>Minhas Informações</h1>

            <h2>Nome: </h2>
            <p><?= $_SESSION['nome']; ?></p>
            <h2>Sobrenome: </h2>
            <p><?= $_SESSION['sobrenome']; ?></p>
            <br>
            <h2>Data de Nascimento: </h2>
            <p><?= $_SESSION['data']; ?></p>
            <br>
            <h2>CPF: </h2>
            <p><?= $_SESSION['cpf']; ?></p>
            <br>
            <h2>Endereço: </h2>
            <p><?= $_SESSION['endereco']; ?></p>
            <br>
            <h2>E-mail: </h2>
            <p><?= $_SESSION['email']; ?></p>
            <br>
            <h2>Senha: </h2>
            <p><?= $_SESSION['Senha']; ?></p>
            <br>
            <h2>Tipo de Perfil: </h2>
            <p><?= $_SESSION['perfil']; ?></p><br>
            <a class="btnalterar" href="update.php?id=<?= $row['id']; ?>">Alterar</a>
            <a class="btnexcluir" href="delete.php?id=<?= $row['id']; ?>" onclick="return confirm('Deseja confirmar a operação?');">Excluir</a>

            <?php $dbh = null; ?>
            </section>
        </div>
    </main>
    <script src="../../js/script.js">

    </script>
</body>

</html>