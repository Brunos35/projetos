<?php
session_start();
require __DIR__ . '/../conexao.php';

// Verifica se o usuário está autenticado
if (!isset($_SESSION['UsuarioID'])) {
    header("Location: login.php"); // Redireciona para a página de login se não estiver autenticado
    exit();
}

$dbh = Conexao::getConexao();

$UsuarioID = $_SESSION['UsuarioID'];

// Consulta para obter os chats associados ao usuário
$stmt = $dbh->prepare("SELECT c.ChatID, 
                              CASE WHEN c.Doador = :UsuarioID THEN (SELECT Nome FROM Usuarios WHERE UsuarioID = c.Adotante)
                                   ELSE (SELECT Nome FROM Usuarios WHERE UsuarioID = c.Doador)
                              END AS nomeDestinatario
                      FROM Chats c
                      WHERE (c.Doador = :UsuarioID OR c.Adotante = :UsuarioID)
                      GROUP BY c.ChatID
                      ORDER BY MAX(c.ChatID) DESC");
$stmt->bindParam(':UsuarioID', $UsuarioID);
$stmt->execute();

$chats = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meus Chats</title>
    <!-- Adicione seu CSS personalizado aqui -->
    <style>
    body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f5f5f5;
}

.container {
    max-width: 800px;
    margin: 20px auto;
    padding: 20px;
    background-color: #fff;
    border-radius: 5px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

h1 {
    font-size: 24px;
    margin-bottom: 20px;
    color: #333;
}

ul {
    list-style-type: none;
    padding: 0;
    margin: 0;
}

li {
    border-bottom: 1px solid #ddd;
    padding: 10px 0;
}

a {
    text-decoration: none;
    color: #007bff;
}

a:hover {
    text-decoration: underline;
    color: #0056b3;
}
</style>
</head>
<body>
    <h1>Meus Chats</h1>
    <ul>
        <?php foreach ($chats as $chat): ?>
            <li>
                <a href="chat.php?id=<?php echo $chat['ChatID']; ?>">
                    <?php echo $chat['nomeDestinatario']; ?> <!-- Nome do destinatário -->
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
</body>
</html>
