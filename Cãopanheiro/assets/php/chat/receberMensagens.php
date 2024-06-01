<?php
session_start();
require_once __DIR__ . '/../conexao.php';

$dbh = Conexao::getConexao();

$remetente = $_SESSION['usuId'];
$destinatario = $_GET['destinatario'];

$query = "SELECT * FROM mensagens WHERE (Remetente = :remetente AND Destinatario = :destinatario) OR (Remetente = :destinatario AND Destinatario = :remetente) ORDER BY DataEnvio ASC";

$stmt = $dbh->prepare($query);
$stmt->bindParam(':remetente', $remetente, PDO::PARAM_INT);
$stmt->bindParam(':destinatario', $destinatario, PDO::PARAM_INT);

// Depuração: Exibir a consulta preparada
echo "Consulta preparada: $query";

$stmt->execute();

$messages = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Depuração: Exibir as mensagens recuperadas
echo "Mensagens recuperadas: ";
print_r($messages);

echo json_encode($messages);

$dbh = null;
?>
