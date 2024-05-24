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
            <li><a href="pets.php">Pets cadastrados</a></li>
            <li><a href="administrador_dashboard.php">Meu Perfil</a></li>
            <li><a href="#">Conversas</a></li>
            <li><a href="config.php">Configurações</a></li>            
            <li><a href="../logout.php">Sair</a></li>
        </ul>
    </nav>
    <main>
        <div class="content" id="conteudo">
           <button><a href="listaUsuarios.php">Usuários cadastrados</a></button>
           <button><a href="listaPets.php">Pets cadastrados</a></button>

        </div>
    </main>
    <script src="../../js/script.js">

    </script>
</body>

</html>