<?php
session_start();
require __DIR__ . '/../conexao.php';

$dbh = Conexao::getConexao();

$remetente = $_SESSION['usuId'];
$destinatario = $_GET['destinatario'];

$stmt = $dbh->prepare("SELECT * FROM Chat WHERE (Remetente = :remetente AND Destinatario = :destinatario) OR (Remetente = :destinatario AND Destinatario = :remetente) ORDER BY DataHora ASC");
$stmt->bindParam(':remetente', $remetente);
$stmt->bindParam(':destinatario', $destinatario);
$stmt->execute();

$messages = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($messages as $message) {
    $sender = $message['Remetente'] == $remetente ? 'Você' : 'Outro';
    $formattedContent = htmlspecialchars($message['Conteudo']);
    $formattedDate = htmlspecialchars($message['DataHora']);
    echo "<div><strong>{$sender}:</strong> {$formattedContent} <em>({$formattedDate})</em></div>";
}

$dbh = null;
?>
