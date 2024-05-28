<?php
session_start();
require_once 'conexao.php';

$dbh = Conexao::getConexao();
$query = "SELECT * FROM caopanheiro.pet";
$stmt = $dbh->prepare($query);
$stmt->execute();
$pets = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pets</title>
    <link rel="stylesheet" href="../css/catalogo.css">
</head>
<body>
    <header>
        <h1>Pets Cadastrados</h1>
    </header>

    <?php
    if (isset($_GET['status']) && $_GET['status'] == 'erro') {
        echo "<script>alert('É preciso estar logado para acessar o chat');</script>";
        echo "<script>window.location.href='catalogo.php';</script>";
    }
    ?>

    <div class="container">
        <?php foreach ($pets as $pet) : ?>
            <div class="pet-card">
                <img src="<?= htmlspecialchars($pet['foto'], ENT_QUOTES, 'UTF-8'); ?>" alt="Foto do Pet">
                <div class="pet-info">
                    <h2><?= htmlspecialchars($pet['nome'], ENT_QUOTES, 'UTF-8'); ?></h2>
                    <p><strong>Raça:</strong> <?= htmlspecialchars($pet['raca'], ENT_QUOTES, 'UTF-8'); ?></p>
                    <p><strong>Sexo:</strong> <?= htmlspecialchars($pet['sexo'], ENT_QUOTES, 'UTF-8'); ?></p>
                    <p><strong>Status:</strong> <?= htmlspecialchars($pet['status'] == 'adotado' ? 'Adotado' : 'Disponível', ENT_QUOTES, 'UTF-8'); ?></p>
                    <p><strong>Doador:</strong> <?= htmlspecialchars($pet['doador'], ENT_QUOTES, 'UTF-8'); ?></p>
                    <p><strong>Descrição:</strong> <?= htmlspecialchars($pet['descricao'], ENT_QUOTES, 'UTF-8'); ?></p>
                    <?php
                    $chatPageUrl = isset($_SESSION['usuId']) ? ($pet['doador'] == $_SESSION['usuId'] ? 'chat_doador.php' : "chat.php?petId=" . htmlspecialchars($pet['id'], ENT_QUOTES, 'UTF-8')) : "catalogo.php?status=erro";
                    ?>
                    <a href="<?= $chatPageUrl ?>" class="btn-chat">Chat</a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</body>
</html>
