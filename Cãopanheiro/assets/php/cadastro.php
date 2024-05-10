<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro Cãopanheiro</title>
    <link rel="stylesheet" href="../css/login.css">
    <style>

        body{
            background:var(--color1);
        }

        div.cadastro{
        width: 100%;
        height:100%;
        display: flex;
        justify-content: center;
        align-items: center;
        }

        form{
            width:50%;
            background-color:var(--color2);
            padding-bottom:10px;
            border-radius:10px;
        }

        .inputbox{
            width:95%;
            margin: 0px 0px 30px 20px;
        }

        .inputbox input{
            height: 5vh;
        }

        div.radio{
            margin:0 0 20px 20px;
            color:var(--color1);
            font-size: 1em;
            
        }

        input#env{
            width: 95%;
            margin: 5px 0px 15px 20px;
            height: 5vh;
            border-radius: 40px;
            background-color: var(--color1);
            border: none;
            outline: none;
            cursor: pointer;
            font-size: 1em;
            font-weight: 600;
        }

        input#env:hover{
            background: transparent;
            color: var(--color3);
            border: 2px solid var(--color1);
            transition: all .5s;
        }

        button#back{
            color:var(--color3);
            text-decoration: underline;
            background: none;
            box-shadow: none;
            border: none;
            font-size: 1em;
            margin-left: 20px;
        }
        button#back > a:visited{
            color:var(--color1);
            text-decoration: underline;
        }
    </style>
</head>
<?php 
 $nome = $_POST['nome'];
 $email = $_POST['email'];
 $senha = $_POST['senha'];
?>
<body>
    <div class="cadastro" id="cadastro">
        <form action="registro.php" autocomplete="on" method="POST">
            <h2>Registrar</h2>
            <div class="inputbox">
                <input type="text" name="nome" id="nome" required value="<?=$nome?>">
                <label for="nome">Nome:</label>
            </div>
            <div class="inputbox">
                <input type="text" name="sobrenome" id="sobrenome" required>
                <label for="nome">Sobrenome:</label>
            </div>

            <div class="inputbox">
                <input type="date" name="dataNasc" id="dataNasc">
                <label for="dataNasc">Data de Nascimento:</label>
            </div>

            <div class="inputbox">
                <input type="number" name="cpf" id="cpf">
                <label for="cpf">CPF:</label>
            </div>
        
            <div class="inputbox">
                <input type="text" name="endereco" id="endereco">
                <label for="endereco">Endereço:</label>
            </div>
            <div class="inputbox">
                <input type="tel" name="telefone" id="telefone">
                <label for="telefone">Número de telefone:</label>
            </div>
            <div class="inputbox">
                <input type="email" name="email" id="email" required value="<?=$email?>">
                <label for="email">E-mail:</label>
            </div>
            <div class="inputbox">
                <input type="password" name="senha" id="senha" required value="<?=$senha?>">
                <label for="senha">Senha:</label>
            </div>
            <div class="radio">
                <p>Qual seu objetivo? </p>
                <input type="radio" name="perfil" id="adotante" value="adotante">
                <label for="perfil">Adotar</label>
                <input type="radio" name="perfil" id="doador" value="doador">
                <label for="perfil">Doar</label>
            </div>

            <input type="submit" value="Cadastrar" id="env">

            <button id="back"><a href="Paglogin.php">Sou cadastrado</a></button>
        </form>    
    </div>
</body>
</html>

