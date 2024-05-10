<?php
// Conexão com o banco de dados MySQL usando PDO
    require_once 'conexao.php';

    // Recupera as credenciais do formulário de login
    $emailLogin = $_POST['emailLogin'];
    $senhaLogin = md5($_POST['senhaLogin']);

    # solicita a conexão com o banco de dados e guarda na váriavel dbh.
    $dbh = Conexao::getConexao();

    // Consulta preparada para verificar se o usuário existe no banco de dados
    $query = "SELECT * FROM caopanheiro.adotante JOIN caopanheiro.doador ON adotante.email = doador.email and adotante.senha = doador.senha WHERE adotante.email = :email and adotante.senha = :senha;";

    $stmt = $dbh->prepare($query);
    $stmt->bindParam(':email', $emailLogin);
    $stmt->bindParam(':senha', $senhaLogin);
    $result = $stmt->execute();

    // Verifica se a consulta retornou algum resultado
    if ($stmt->rowCount() > 0) {
        // Login bem sucedido
        header('location: usuario.php');
    } else {
        // Login falhou
        echo "Usuário ou senha incorretos!";
    }