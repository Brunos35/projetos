<?php
session_start();
header('Content-Type: text/html; charset=utf-8');

require_once 'conexao.php';
require __DIR__ . '/../../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

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

                // Configurar PHPMailer
                $mail = new PHPMailer(true);

                try {
                    // Configurações do servidor
                    $mail->isSMTP();
                    $mail->Host = 'smtp.gmail.com';
                    $mail->SMTPAuth = true;
                    $mail->Username = 'brunos02santos@gmail.com';
                    $mail->Password = '3379';
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                    $mail->Port = 587;

                    // Configurações do e-mail
                    $mail->setFrom('no-reply@Cãopanheiro.com', 'Cãopanheiro');
                    $mail->addAddress($email);
                    $mail->isHTML(true);
                    $mail->Subject = 'Redefinição de Senha';
                    $mail->Body = "Clique no link para redefinir sua senha: <a href='http://localhost/bruno/C%C3%A3opanheiro/assets/php/reset_password.php?token=$token'>Redefinir Senha</a>";

                    // Envia o e-mail
                    $mail->send();
                    echo "Um e-mail de redefinição de senha foi enviado para " . htmlspecialchars($email);
                } catch (Exception $e) {
                    echo "Erro ao enviar e-mail: {$mail->ErrorInfo}";
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
