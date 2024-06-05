<?php
$nome = isset($_POST['nome']) ? $_POST['nome'] : '';
$email = isset($_POST['email']) ? $_POST['email'] : '';
$senha = isset($_POST['senha']) ? $_POST['senha'] : '';
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#cpf').mask('000.000.000-00');
            $('#cep').mask('00000-000');

            // Função para preencher os campos automaticamente ao inserir o CEP
            $('#cep').on('blur', function() {
                var cep = $(this).val().replace(/\D/g, '');
                if (cep) {
                    var url = 'https://viacep.com.br/ws/' + cep + '/json/';
                    $.getJSON(url, function(data) {
                        if (!("erro" in data)) {
                            $('#cidade').val(data.localidade);
                            $('#estado').val(data.uf);
                            $('#endereco').val(data.logradouro);
                            $('#complemento').val(data.complemento);
                        } else {
                            alert('CEP não encontrado');
                        }
                    });
                }
            });

            $('form').on('submit', function(e) {
                let cpf = $('#cpf').val();
                let cpfPattern = /^\d{3}\.\d{3}\.\d{3}-\d{2}$/;
                if (!cpfPattern.test(cpf)) {
                    alert('CPF inválido!');
                    e.preventDefault();
                }
            });
        });
    </script>
    <link rel="stylesheet" href="../css/login.css">
    <link rel="stylesheet" href="../css/cadastro.css">
</head>

<body>
    <div class="cadastro" id="cadastro">
        <form action="registro.php" autocomplete="on" method="POST">
            <h2>Cadastro</h2>
            <div class="inputbox">
                <input type="text" name="nome" id="nome" required value="<?=$nome?>">
                <label for="nome">Nome:</label>
            </div>
            <div class="inputbox">
                <input type="text" name="sobrenome" id="sobrenome" required>
                <label for="sobrenome">Sobrenome:</label>
            </div>
            <div class="inputbox">
                <input type="date" name="dataNasc" id="dataNasc" required>
                <label for="dataNasc">Data de Nascimento:</label>
            </div>
            <div class="inputbox">
                <input type="text" name="cpf" id="cpf" required>
                <label for="cpf">CPF:</label>
            </div>

            <div class="inputbox">
                <input type="text" name="cep" id="cep" required>
                <label for="cep">CEP:</label>
            </div>

            <div class="inputbox">
                <input type="text" name="cidade" id="cidade" required>
                <label for="cidade">Cidade:</label>
            </div>
            <div class="inputbox">
                <input type="text" name="estado" id="estado" required>
                <label for="estado">Estado:</label>
            </div>
            <div class="inputbox">
                <input type="text" name="endereco" id="endereco" required>
                <label for="endereco">Endereço:</label>
            </div>
            <div class="inputbox">
                <input type="text" name="complemento" id="complemento">
                <label for="complemento">Complemento:</label>
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
                <input type="radio" name="perfil" id="adotante" value="adotante" required>
                <label for="perfil">Adotar</label>
                <input type="radio" name="perfil" id="doador" value="doador" required>
                <label for="perfil">Doar</label>
            </div>
            <input type="submit" value="Cadastrar" id="env">
            <button id="back"><a href="Paglogin.php">Sou cadastrado</a></button>
        </form>    
    </div>
</body>

</html>
