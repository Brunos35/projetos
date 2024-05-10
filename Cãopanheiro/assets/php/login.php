<?php
// Conexão com o banco de dados MySQL usando PDO
    require_once 'conexao.php';

    // Recupera as credenciais do formulário de login
    $emailLogin = $_POST['email'];
    $senhaLogin = $_POST['senhaLogin'];

    // Consulta preparada para verificar se o usuário existe no banco de dados
    $stmt = $conn->prepare("SELECT * FROM caopanheiro.adotante, caopanheiro.doador, caopanheiro.admin WHERE email=:email AND senha=:senha");
    $stmt->bindParam(':email', $emailLogin);
    $stmt->bindParam(':senha', $senhaLogin);
    $stmt->execute();

    // Verifica se a consulta retornou algum resultado
    if ($stmt->rowCount() > 0) {
        // Login bem sucedido
        echo "Login bem sucedido!";
    } else {
        // Login falhou
        echo "Usuário ou senha incorretos!";
    }

$conn = null;
?>
