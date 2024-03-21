<?php
// Função para carregar mensagens do arquivo de texto
function loadMessages() {
    $messages = file_get_contents('messages.txt');
    return json_decode($messages, true);
}

// Função para salvar mensagens no arquivo de texto
function saveMessage($sender, $message) {
    $messages = loadMessages();
    $messages[] = array('sender' => $sender, 'message' => $message);
    file_put_contents('messages.txt', json_encode($messages));
}

// Verifica se a requisição é um POST e se contém uma mensagem
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['message'])) {
    $sender = isset($_POST['sender']) ? $_POST['sender'] : 'Usuário';
    $message = $_POST['message'];
    saveMessage($sender, $message);
    exit; // Termina a execução do script após salvar a mensagem
}

// Verifica se a requisição é um GET para carregar mensagens
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    header('Content-Type: application/json');
    $messages = loadMessages();
    echo json_encode($messages);
    exit; // Termina a execução do script após enviar as mensagens
}
?>
