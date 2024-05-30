<?php
session_start();
require __DIR__ . '/../conexao.php';

$dbh = Conexao::getConexao();

function sanitizeInput($data) {
    return htmlspecialchars(strip_tags($data));
}

$messages = [];
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $idChat = sanitizeInput($_GET['idChat']);

    if (!empty($idChat) && is_numeric($idChat)) {
        try {
            $stmt = $dbh->prepare("SELECT m.conteudo, m.dataEnvio, u.nome AS remetente
                                   FROM mensagem m
                                   JOIN usuario u ON m.remetente = u.idUsuario
                                   WHERE m.idChat = :idChat
                                   ORDER BY m.dataEnvio ASC");
            $stmt->bindParam(':idChat', $idChat, PDO::PARAM_INT);
            $stmt->execute();
            $messages = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    } else {
        echo "Invalid input.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Messages</title>
</head>
<body>
    <form method="get" action="">
        <label for="idChat">Chat ID:</label>
        <input type="text" id="idChat" name="idChat" required><br>
        <input type="submit" value="View Messages">
    </form>

    <?php
    if (!empty($messages)) {
        foreach ($messages as $message) {
            echo "<p><strong>" . htmlspecialchars($message['remetente']) . ":</strong> " . htmlspecialchars($message['conteudo']) . " <em>(" . htmlspecialchars($message['dataEnvio']) . ")</em></p>";
        }
    } else {
        echo "No messages found.";
    }
    ?>
</body>
</html>
