<?php
    header('Content-Type: text/html; charset=utf-8;');
    
    require_once 'conexao.php';

    # recebe os valores enviados do formulário via método post.
    $nome = $_POST['nome'];
    $sobrenome = $_POST['sobrenome'];
    $datanasc = $_POST['dataNasc'];
    $cpf = $_POST['cpf'];
    $endereco = $_POST['endereco'];
    $telefone = $_POST['telefone'];
    $email = $_POST['email'];
    $senha = md5($_POST['senha']);

    # solicita a conexão com o banco de dados e guarda na váriavel dbh.
    $dbh = Conexao::getConexao();

    # cria uma instrução SQL para inserir dados na tabela usuarios.
    $query = "INSERT INTO caopanheiro.adotante (Nome, Sobrenome, CPF,Endereco ,NumeroWhatsapp ,Email, Senha) 
                VALUES (:Nome, :Sobrenome, :CPF, :Endereco, :NumeroWhatsapp, :Email, :Senha);"; 
    
    # prepara a execução da query e retorna para uma variável chamada stmt.
    $stmt = $dbh->prepare($query);

    # com a variável stmt, usada bindParam para associar a cada um dos parâmetro
    # e seu tipo (opcional).
    $stmt->bindParam(':Nome', $nome);
    $stmt->bindParam(':Sobrenome', $sobrenome);
    $stmt->bindParam(':CPF', $cpf);
    $stmt->bindParam(':Endereco', $endereco);
    $stmt->bindParam(':NumeroWhatsapp', $telefone);
    $stmt->bindParam(':Email', $email);
    $stmt->bindParam(':Senha', $senha);    
    
    # executa a instrução contida em stmt e se tudo der certo retorna uma valor maior que zero.
    $result= $stmt->execute();
    if ($result)
    {
        echo "<script>window.alert('Cadastrado com Sucesso!')</script>";
        header('location: usuario.php');
        exit;
    } else {
        echo '<p>Não foi fossível inserir Usuário!</p>';
        # método da classe conexao que informa o error ocorrido na execução da query.
        $error = $dbh->errorInfo();
        print_r($error);
    }
    $dbh = null;
    echo "<p><a href='index.php'>Voltar</a></p>";