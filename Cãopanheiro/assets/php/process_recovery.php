<?php
session_start();
header('Content-Type: text/html; charset=utf-8');

require_once 'conexao.php';

$dbh = Conexao::getConexao();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);

    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        try {
            // Verifica se o e-mail existe no banco de dados
            $sql = "SELECT UsuarioID FROM usuarios WHERE email = :email";
            $stmt = $dbh->prepare($sql);
            $stmt->bindParam(':email', $email);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                // Gera um token único
                $token = bin2hex(random_bytes(50));

                // Armazena o token no banco de dados
                $sql = "UPDATE usuarios SET reset_token = :token WHERE email = :email";
                $stmt = $dbh->prepare($sql);
                $stmt->bindParam(':token', $token);
                $stmt->bindParam(':email', $email);
                $stmt->execute();

                // Envia o e-mail com o link de redefinição de senha
                $reset_link = "http://localhost/bruno/C%C3%A3opanheiro/assets/php/reset_password.php?token=" . $token;
                $subject = "Redefinição de Senha";
                $message = "Clique no link para redefinir sua senha: " . $reset_link;
                $headers = "From: no-reply@seu_dominio.com\r\n";
                $headers .= "Reply-To: no-reply@seu_dominio.com\r\n";
                $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

                if (mail($email, $subject, $message, $headers)) {
                    echo "Um e-mail de redefinição de senha foi enviado para " . htmlspecialchars($email);
                } else {
                    echo "Falha ao enviar o e-mail.";
                }
            } else {
                echo "E-mail não encontrado.";
            }
        } catch (Exception $e) {
            echo "Erro ao processar o pedido: " . $e->getMessage();
        }
    } else {
        echo "E-mail inválido.";
    }
} else {
    echo "Método de requisição inválido.";
}
?>
