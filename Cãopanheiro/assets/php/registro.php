<?php
    header('Content-Type: text/html; charset=utf-8;');
    
    require_once '../src/conexao.php';

    # recebe os valores enviados do formulário via método post.
    $nome = $_POST['nome'];
    $sobrenome = $_POST['sobrenome'];
    $datanasc = $_POST['dataNasc'];
    $cpf = $_POST['cpf'];
    $endereco = $_POST['endereco'];
    $telefone = $_POST['telefone'];
    $email = $_POST['email'];
    $senha = md5($_POST['senha']);
    $perfil = $_POST['perfil'];

    # solicita a conexão com o banco de dados e guarda na váriavel dbh.
    $dbh = Conexao::getConexao();

    # cria uma instrução SQL para inserir dados na tabela usuarios.
    $query = "INSERT INTO caopanheiro.adotante (nome, sobrenome, datanasc, cpf,endereco ,telefone ,email, senha, perfil) 
                VALUES (:nome, :sobrenome, :datanasc, :cpf, :endereco, :telefone,:email, :senha, :perfil);"; 
    
    # prepara a execução da query e retorna para uma variável chamada stmt.
    $stmt = $dbh->prepare($query);

    # com a variável stmt, usada bindParam para associar a cada um dos parâmetro
    # e seu tipo (opcional).
    $stmt->bindParam(':nome', $nome);
    $stmt->bindParam(':sobrenome', $sobrenome);
    $stmt->bindParam(':datanasc', $datanasc);
    $stmt->bindParam(':cpf', $cpf);
    $stmt->bindParam(':endereco', $endereco);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':senha', $senha);    
    $stmt->bindParam(':perfil', $perfil);
    
    # executa a instrução contida em stmt e se tudo der certo retorna uma valor maior que zero.
    $result= $stmt->execute();
    if ($result)
    {
        header('location: index.php');
        exit;
    } else {
        echo '<p>Não foi fossível inserir Usuário!</p>';
        # método da classe conexao que informa o error ocorrido na execução da query.
        $error = $dbh->errorInfo();
        print_r($error);
    }
    $dbh = null;
    echo "<p><a href='index.php'>Voltar</a></p>";