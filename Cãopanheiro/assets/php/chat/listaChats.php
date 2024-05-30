<?php
session_start();
require __DIR__ . '/../conexao.php';

// Verifica se o usuário está autenticado
if (!isset($_SESSION['usuId'])) {
    header("Location: ../login.php"); // Redireciona para a página de login se não estiver autenticado
    exit();
}

$dbh = Conexao::getConexao();


// Consulta para obter os chats associados ao usuário
$stmt = $dbh->prepare("SELECT c.ChatID, 
                              CASE WHEN c.Doador = :UsuarioID THEN (SELECT Nome FROM Usuarios WHERE UsuarioID = c.Adotante)
                                   ELSE (SELECT Nome FROM Usuarios WHERE UsuarioID = c.Doador)
                              END AS nomeDestinatario
                      FROM Chats c
                      WHERE (c.Doador = :UsuarioID OR c.Adotante = :UsuarioID)
                      GROUP BY c.ChatID
                      ORDER BY MAX(c.ChatID) DESC");
$stmt->bindParam(':UsuarioID', $_SESSION['usuId']);
$stmt->execute();

$chats = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Área Restrita</title>
    <link rel="stylesheet" href="../../css/dashboards.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
</head>

<body>
    <header>
        <button class="nav-toggle"><span class="material-symbols-outlined">
                menu
            </span></button>
        <figure class="logo"><img src="../../img/logo1.png" alt=""></figure>
        <div class="user-info">Bem-vindo, <?= $_SESSION['nome']; ?> <span id="username"></span></div>
    </header>
    <nav>
        <ul>
            <li><a href="adotante_dashboard.php">Meu Perfil</a></li>
            <li><a href="../catalogo.php">Pets disponíveis</a></li>
            <li><a href="../chat/listaChats.php">Conversas</a></li>
            <li><a href="../logout.php">Sair</a></li>
        </ul>
    </nav>
    <main>
        <div class="content" id="conteudo">
            <h1>Meus Chats</h1>
            <ul>
                <?php foreach ($chats as $chat) : ?>
                    <li>
                        <a href="chat.php?id=<?php echo $chat['ChatID']; ?>">
                            <?php echo $chat['nomeDestinatario']; ?> <!-- Nome do destinatário -->
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>

        </div>
    </main>
    <script src="../../js/script.js">

    </script>
</body>

</html>