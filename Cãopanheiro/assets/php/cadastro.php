<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro Cãopanheiro</title>
    <link rel="stylesheet" href="../css/login.css">
</head>
<?php 
 $nome = $_POST['nome'];
 $email = $_POST['email'];
 $senha = $_POST['senha'];
?>
<body>
    <div class="registro" id="registro">
        <form action="registro.php" autocomplete="on">
            <h2>Registrar</h2>
            <div class="inputbox">
                <input type="text" name="nome" id="nome" required value="<?=$nome?>">
                <label for="nome">Nome</label>
            </div>
            <div class="inputbox">
                <input type="text" name="sobrenome" id="sobrenome" required">
                <label for="nome">Sobrenome</label>
            </div>

            <div class="inputbox">
                <input type="date" name="dataNasc" id="dataNasc">
                <label for="dataNasc">Data de Nascimento: </label>
            </div>

            <div class="inputbox">
                <input type="number" name="cpf" id="cpf">
                <label for="cpf">CPF: </label>
            </div>
        
            <div class="inputbox">
                <input type="text" name="endereco" id="endereco">
                <label for="endereco">Endereço</label>
            </div>
            <div class="inputbox">
                <input type="tel" name="telefone" id="telefone">
                <label for="telefone">Número de telefone: </label>
            </div>
            <div class="inputbox">
                <input type="email" name="email" id="email" required value="<?=$email?>">
                <label for="email">E-mail</label>
            </div>
            <div class="inputbox">
                <input type="password" name="senha" id="senha" required value="<?=$senha?>">
                <label for="senha">Senha</label>
            </div>
            <div class="input">
                <p>Qual seu objetivo? </p>
                <input type="radio" name="perfil" id="adotante">
                <label for="perfil">Adotar</label>
                <input type="radio" name="perfil" id="doador">
                <label for="perfil">Doar</label>
            </div>

            <input type="submit" value="Cadastrar">

            <button class="env">Registrar</button>
        </form>
    <button class="regs"><a href="Paglogin.php">Sou cadastrado</a></button>
    </div>
</body>
</html>

