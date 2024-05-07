<?php
session_start();

// Simulando um processo de login
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    // Verifica o login (pode ser feito com validação em banco de dados)
    // Neste exemplo, vamos assumir que o login é válido
    $_SESSION['username'] = $username;

    header('Location: index.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../estilos/usuario.css">
</head>
<body>

<div class="login-container">
    <h2>Login</h2>
    <form action="usuario.php" method="post">
        <input type="text" name="username" placeholder="Usuário" required>
        <input type="submit" value="Login">
    </form>
</div>

</body>
</html>
