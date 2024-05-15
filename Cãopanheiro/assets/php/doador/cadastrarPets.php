<?php
    session_start();
    header('Content-Type: text/html; charset=utf-8;');
    
    require __DIR__ . '/../conexao.php';

    $petNome = $_POST['petNome'];
    $petNasc = $_POST['petNasc'];
    $petPorte = $_POST['porte'];
    $petRaca = $_POST['raca'];
    $petSexo = $_POST['sexo'];
    $descricao = $_POST['descricao'];
    //$Fotos

    
    # solicita a conexão com o banco de dados e guarda na váriavel dbh.
    $dbh = Conexao::getConexao();

    # cria uma instrução SQL para inserir dados na tabela usuarios.
    $query = "INSERT INTO caopanheiro.pet (nome, dataNascimento, raca, porte, sexo, descricao, doador) 
                VALUES (:nome, :dataNascimento, :raca, :porte, :sexo, :descricao, :doador);"; 
    
    # prepara a execução da query e retorna para uma variável chamada stmt.
    $stmt = $dbh->prepare($query);

    # com a variável stmt, usada bindParam para associar a cada um dos parâmetro
    # e seu tipo (opcional).
    $stmt->bindParam(':nome', $petNome);
    $stmt->bindParam(':dataNascimento', $petNasc);
    $stmt->bindParam(':raca', $petRaca);
    $stmt->bindParam(':porte', $petPorte);
    $stmt->bindParam(':sexo', $petSexo);
    $stmt->bindParam(':descricao', $descricao);
    $stmt->bindParam(':doador', $_SESSION['usuId']);
    var_dump($_SESSION['usuId']);
    $result= $stmt->execute();

    if ($result){
        echo "<script>window.alert('Cadastrado com Sucesso!')</script>";
        header("Location: pets.php");
        exit;
    } else {
        echo '<p>Não foi fossível inserir Usuário!</p>';
        # método da classe conexao que informa o error ocorrido na execução da query.
        $error = $dbh->errorInfo();
        print_r($error);
    }