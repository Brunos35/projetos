<?php 
session_start();
require __DIR__ . '/../conexao.php';?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Área Restrita</title>
    <link rel="stylesheet" href="../../css/usuario.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
</head>
<body>
        <header>
            <button class="nav-toggle"><span class="material-symbols-outlined">
                menu
                </span></button>
            <figure class="logo"><img src="../../img/logo1.png" alt=""></figure>
            <div class="user-info">Bem-vindo, <?=$_SESSION['nome'];?> <span id="username"></span></div>
        </header>
        <nav>
            <ul>
                <li><a href="pets.php">Meus Pet</a></li>
                <li><a href="alterarDoador.php">Meu Perfil</a></li>
                <li><a href="#">Conversas</a></li>
                <li><a href="../../index.html">Página Inicial</a></li>
            </ul>
        </nav>
        <div class="content" id="conteudo">
            <h1>Olá usuario</h1>
        </div>

    <script src="../../js/script.js">
        
    </script>
</body>
</html>
