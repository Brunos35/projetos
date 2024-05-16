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

    <form action="alterarDoador.php" method="post">
        <input type="hidden" name="id" value="<?=$_SESSION['usuId']?>">
        
        <label for="alterNome">Nome: </label>
        <input type="text" name="alterNome" id="alterNome" required value="<?=$_SESSION['nome']?>"><br>

        <label for="alterSobrenome">Sobrenome: </label>
        <input type="text" name="alterSobrenome" required value="<?=$_SESSION['sobrenome']?>">
        
        <label for="dataNasc">Data de Nascimento: </label>
        <input type="date" name="alterDataNasc" id="alterDataNasc" value="<?=$_SESSION['data']?>">

        <label for="cpf">CPF: </label>
        <input type="number" name="alterCpf" id="alterCpf" value="<?=$_SESSION['cpf']?>">
        
        <label for="alterEndereco">Endereço: </label>
        <input type="text" name="alterEndereco" id="alterEndereco" value="<?=$_SESSION['endereco']?>">

        <label for="alterEmail">E-mail</label>
        <input type="email" name="alterEmail" id="alterEmail"required autofocus value="<?=$_SESSION['email']?>"><br>

        <label for="alterSenha">Nova senha: </label>
        <input type="password" name="alterSenha" id="alterSenha">

        <button class="salvar" type="submit">Salvar</button>
    </form>

        </div>
</main>
    <script src="../../js/script.js">
        
    </script>
</body>
</html>
<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $nome = $_POST['alterNome'];
    $sobrenome = $_POST['alterSobrenome'];
    $dataNasc = $_POST['alterDataNasc'];
    $cpf = $_POST['alterCpf'];
    $endereco = $_POST['alterEndereco'];
    $email = $_POST['alterEmail'];
    $senha = md5($_POST['alterSenha']);

    $dbh = Conexao::getConexao();

    $sql = "UPDATE caopanheiro.usuarios SET Nome = :nome, Sobrenome = :sobrenome, DataNascimento = :dataNasc, CPF = :cpf, Endereco = :endereco, Email = :email, Senha = :senha WHERE id = :id";

    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':nome', $nome);
    $stmt->bindParam(':sobrenome', $sobrenome);
    $stmt->bindParam(':dataNasc', $dataNasc);
    $stmt->bindParam(':cpf', $cpf);
    $stmt->bindParam(':endereco', $endereco);
    $stmt->bindParam(':email', $email);
    if (!empty($senha)) {
        $stmt->bindParam(':senha', $senhaHash);
    }

    if ($stmt->execute()) {
        $_SESSION['nome'] = $nome;
        $_SESSION['sobrenome'] = $sobrenome;
        $_SESSION['data'] = $dataNasc;
        $_SESSION['cpf'] = $cpf;
        $_SESSION['endereco'] = $endereco;
        $_SESSION['email'] = $email;
        header("Location: .php");
        exit();
    } else {
        echo "Erro ao atualizar informações.";
    }
}
?>
