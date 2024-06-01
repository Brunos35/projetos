<?php
session_start();
require_once __DIR__ . '/../conexao.php';

$dbh = Conexao::getConexao();

$remetente = $_SESSION['usuId'];
$destinatario = $_POST['destinatario'];
$conteudo = htmlspecialchars($_POST['conteudo'], ENT_QUOTES, 'UTF-8');

try {
    // Adicionando DataEnvio para registrar o tempo de envio da mensagem
    $query = "INSERT INTO mensagens (Remetente, Destinatario, Conteudo, DataEnvio) VALUES (:remetente, :destinatario, :conteudo, NOW())";
    
    $stmt = $dbh->prepare($query);
    $stmt->bindParam(':remetente', $remetente, PDO::PARAM_INT);
    $stmt->bindParam(':destinatario', $destinatario, PDO::PARAM_INT);
    $stmt->bindParam(':conteudo', $conteudo, PDO::PARAM_STR);

    // Depuração: Exibir a consulta preparada
    echo "Consulta preparada: $query";

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
