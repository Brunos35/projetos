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
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        #chat {
            width: 90%;
            max-width: 600px;
            background-color: #ffffff;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            height: 80vh;
        }

        #chat h2 {
            background-color: #4a76a8;
            color: #ffffff;
            padding: 10px;
            text-align: center;
            margin: 0;
            font-size: 1.2em;
        }

        #messages {
            flex: 1;
            padding: 20px;
            overflow-y: auto;
            background-color: #f9f9f9;
        }

        .message {
            margin-bottom: 15px;
            display: flex;
            flex-direction: column;
        }

        .message.sent {
            align-items: flex-end;
        }

        .message.received {
            align-items: flex-start;
        }

        .message .text {
            padding: 10px 15px;
            border-radius: 20px;
            max-width: 70%;
            line-height: 1.5;
            word-wrap: break-word;
        }

        .message.sent .text {
            background-color: #dcf8c6;
            color: #333333;
        }

        .message.received .text {
            background-color: #ffffff;
            color: #333333;
            border: 1px solid #e1e1e1;
        }

        #sendMessageForm {
            display: flex;
            border-top: 1px solid #e1e1e1;
            background-color: #ffffff;
        }

        #sendMessageForm textarea {
            flex: 1;
            padding: 15px;
            border: none;
            border-radius: 0;
            outline: none;
            resize: none;
            font-family: inherit;
        }

        #sendMessageForm button {
            padding: 15px;
            background-color: #4a76a8;
            color: #ffffff;
            border: none;
            cursor: pointer;
        }

        #sendMessageForm button:hover {
            background-color: #3b5f8a;
        }
    </style>
</head>

<body>
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
