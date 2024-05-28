<?php
session_start();
header('Content-Type: text/html; charset=utf-8');

require_once 'conexao.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $token = $_POST['token'];
    $new_password = password_hash($_POST['new_password'], PASSWORD_DEFAULT);

    // Verifica o token
    $sql = "SELECT id FROM users WHERE reset_token = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Atualiza a senha no banco de dados
        $sql = "UPDATE users SET password = ?, reset_token = NULL WHERE reset_token = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $new_password, $token);
        $stmt->execute();

        echo "Sua senha foi atualizada com sucesso.";
    } else {
        echo "Token inválido.";
    }
}

$conn->close();
?>
