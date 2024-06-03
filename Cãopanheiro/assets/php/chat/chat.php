<?php
session_start();
require __DIR__ . '/../conexao.php';

// Verifica se o usuário está autenticado
if (!isset($_SESSION['usuId'])) {
    header("Location: ../login.php"); // Redireciona para a página de login se não estiver autenticado
    exit();
}

$dbh = Conexao::getConexao();

if (!$dbh) {
    die("Erro ao conectar ao banco de dados.");
}

$chatId = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
$destinatario = htmlspecialchars($_GET['destinatario'], ENT_QUOTES, 'UTF-8');
$usuarioId = $_SESSION['usuId'];

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/chat.css">
    <title>Chat</title>

</head>

<body>
    <button id="volta"><a href="listaChats.php">Voltar</a></button>
    <!-- Adicionando a área de chat -->
    <div id="chat">
        <h2>Chat</h2>
        <div id="messages">
            <!-- Mensagens serão carregadas aqui -->
        </div>
        <form id="sendMessageForm">
            <input type="hidden" name="destinatario" id="destinatario" value="<?= htmlspecialchars($destinatario, ENT_QUOTES, 'UTF-8') ?>">
            <input type="hidden" name="chatId" id="chatId" value="<?= htmlspecialchars($chatId, ENT_QUOTES, 'UTF-8') ?>"> <!-- Campo oculto para chatId -->
            <input type="hidden" name="usuarioId" id="usuarioId" value="<?= htmlspecialchars($usuarioId, ENT_QUOTES, 'UTF-8') ?>"> <!-- Campo oculto para usuarioId -->
            <textarea name="conteudo" id="conteudo" rows="3" required></textarea>
            <button type="submit">Enviar</button>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const destinatario = document.getElementById('destinatario').value;
            const usuarioId = document.getElementById('usuarioId').value;
            const messagesDiv = document.getElementById('messages');
            const sendMessageForm = document.getElementById('sendMessageForm');
            const conteudo = document.getElementById('conteudo');

            // Função para carregar as mensagens
            const loadMessages = async () => {
                try {
                    const response = await fetch(`receberMensagens.php?destinatario=${encodeURIComponent(destinatario)}`);
                    const data = await response.json();
                    if (!Array.isArray(data)) {
                        console.error('Resposta inválida:', data);
                        return;
                    }
                    messagesDiv.innerHTML = '';
                    data.forEach(message => {
                        const messageDiv = document.createElement('div');
                        messageDiv.classList.add('message');
                        messageDiv.classList.add(message.Remetente == usuarioId ? 'sent' : 'received');
                        messageDiv.innerHTML = `<strong>${message.RemetenteNome}:</strong> <div class="text">${message.Conteudo}</div>`;
                        messagesDiv.appendChild(messageDiv);
                    });
                    messagesDiv.scrollTop = messagesDiv.scrollHeight; // Rolagem automática para o fim
                } catch (error) {
                    console.error('Erro ao carregar mensagens:', error);
                }
            };

            // Enviar mensagem
            sendMessageForm.addEventListener('submit', async (e) => {
                e.preventDefault();
                const formData = new FormData(sendMessageForm);
                try {
                    const response = await fetch('enviarMensagem.php', {
                        method: 'POST',
                        body: formData
                    });
                    if (response.ok) {
                        conteudo.value = '';
                        loadMessages();
                    } else {
                        console.error('Erro ao enviar mensagem.');
                    }
                } catch (error) {
                    console.error('Erro ao enviar mensagem:', error);
                }
            });

            // Carregar mensagens inicialmente e a cada 10 segundos
            loadMessages();
            setInterval(loadMessages, 10000);
        });
    </script>

</body>

</html>
