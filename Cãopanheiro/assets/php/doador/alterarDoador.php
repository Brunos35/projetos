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
            <div class="user-info">Bem-vindo, <?= $_SESSION['nome'];?> <span id="username"></span></div>
        </header>
        <nav>
            <ul>
                <li><a href="pets.php">Meus Pet</a></li>
                <li><a href="alterarDoador.php">Meu Perfil</a></li>
                <li><a href="#">Conversas</a></li>
                <li><a href="../../index.html">Página Inicial</a></li>
                <li><a href="">Sair</a></li>
            </ul>
        </nav>

        <main>
        <div class="content" id="conteudo">
        

<h1>Alterar Informações</h1>

    <form action="usuarioupdate.php" method="post">
        
        <input type="hidden" name="id" value="<?=$_SESSION['usuId']?>">
        
        <label>Nome</label><br>
        <input type="text" name="nome" placeholder="Informe seu nome." size="80" required value="<?=$_SESSION['nome']?>"><br>

        <label>Sobrenome</label><br>
        <input type="text" name="Sobrenome" placeholder="Informe seu nome." size="80" required value="<?=$_SESSION['Sobrenome']?>"><br>
        <label>E-mail</label><br>
        <input type="email" name="email"   required autofocus value="<?=$_SESSION['email']?>"><br>

        

        <button class="salvar" type="submit">Salvar</button>
    </form>

        </div>
</main>
    <script src="../../js/script.js">
        
    </script>
</body>
</html>
