<?php
session_start();
require __DIR__ . '/../conexao.php';

$dbh = Conexao::getConexao();

$remetente = $_SESSION['usuId'];
$destinatario = $_POST['destinatario'];
$conteudo = htmlspecialchars($_POST['conteudo'], ENT_QUOTES, 'UTF-8');

try {
    $stmt = $dbh->prepare("INSERT INTO Chat (Remetente, Destinatario, Conteudo) VALUES (:remetente, :destinatario, :conteudo)");
    $stmt->bindParam(':remetente', $remetente);
    $stmt->bindParam(':destinatario', $destinatario);
    $stmt->bindParam(':conteudo', $conteudo);

    if ($stmt->execute()) {
        echo "Mensagem enviada com sucesso!";
    } else {
        echo "Erro ao enviar mensagem.";
    }
} catch (PDOException $e) {
    echo "Erro ao enviar mensagem: " . $e->getMessage();
}

$dbh = null;
?>
