<?php
require __DIR__ . '/../conexao.php';

function sanitizeInput($data) {
    return htmlspecialchars(strip_tags($data));
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $doadorId = sanitizeInput($_POST['usuario1']);
    $usuId = sanitizeInput($_POST['usuario2']);

    if (!empty($doadorId) && !empty($usuId) && is_numeric($doadorId) && is_numeric($usuId)) {
        try {
            $dbh = Conexao::getConexao();
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stmt = $dbh->prepare("INSERT INTO chats (doador, adotante) VALUES (:doador, :adotante)");
            $stmt->bindParam(':doador', $doadorId, PDO::PARAM_INT);
            $stmt->bindParam(':adotante', $usuId, PDO::PARAM_INT);

            $stmt->execute();

            echo "Chat created successfully";
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
    <title>Create Chat</title>
</head>
<body>
    <form method="post" action="">
        <label for="usuario1">Usuario 1 ID:</label>
        <input type="text" id="usuario1" name="usuario1"><br>
        <label for="usuario2">Usuario 2 ID:</label>
        <input type="text" id="usuario2" name="usuario2"><br>
        <input type="submit" value="Create Chat">
    </form>
</body>
</html>
