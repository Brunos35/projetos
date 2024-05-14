<?php 
session_start();
require __DIR__ . '/../conexao.php';
?>
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
            <div class="user-info">Bem-vindo, <?= $_SESSION['nome'];?> <span id="username"></span></div>
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
            <h1>Cadastrar pets</h1>
            <form action="cadastrarPets.php" method="post">

            <label for="petNome">Nome do Pet: </label>
            <input type="text" name="petNome" id="petNome">
            <label for="petNasc">Data de nascimento: </label>
            <input type="date" name="petNasc" id="petNasc">

            <div id="radio">
                <p>Porte:</p>
                <label for="pequeno">Pequeno</label>
                <input type="radio" name="porte" id="pequeno" value="pequeno">
                <label for="medio">Medio</label>
                <input type="radio" name="porte" id="medio" value="medio">
                <label for="grande">Grande</label>
                <input type="radio" name="porte" id="grande" value="grande">
                </form>
            </div>

            <div id="raca">
                <select name="raca" id="raca">
                    <option value="labrador">labrador</option>
                    <option value="golden retriever">golden retriever</option>
                    <option value="dalmata">dalmata</option>
                    <option value="bulldog">bulldog</option>
                    <option value="pitbull">pitbull</option>
                    <option value="pincher">pincher</option>
                </select>
            </div>
            <p>Sexo: </p>
            <label for="macho">Macho</label>
            <input type="radio" name="sexo" id="macho">
            <label for="femea">Fêmea</label>
            <input type="radio" name="sexo" id="femea">
            <label for="descricao">Descrição:</label>
            <textarea name="descricao" id="descricao" cols="30" rows="10" placeholder="Fale um pouco sobre o pet"></textarea>

            Fotos:
        </div>

    <script src="../../js/script.js">
        
    </script>
</body>
</html>
