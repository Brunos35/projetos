<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <!-- Adicionando a área de chat -->
<div id="chat">
    <h2>Chat</h2>
    <div id="messages">
        <!-- Mensagens serão carregadas aqui -->
    </div>
    <form id="sendMessageForm">
        <input type="hidden" name="destinatario" id="destinatario" value="ID_DO_DESTINATARIO">
        <textarea name="conteudo" id="conteudo" rows="3" required></textarea>
        <button type="submit">Enviar</button>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const destinatario = document.getElementById('destinatario').value;
        const messagesDiv = document.getElementById('messages');
        const sendMessageForm = document.getElementById('sendMessageForm');
        const conteudo = document.getElementById('conteudo');

        // Função para carregar as mensagens
        const loadMessages = async () => {
            try {
                const response = await fetch(`get_messages.php?destinatario=${destinatario}`);
                if (response.ok) {
                    messagesDiv.innerHTML = await response.text();
                }
            } catch (error) {
                console.error('Erro ao carregar mensagens:', error);
            }
        };

        // Enviar mensagem
        sendMessageForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const formData = new FormData(sendMessageForm);
            try {
                const response = await fetch('send_message.php', {
                    method: 'POST',
                    body: formData
                });
                if (response.ok) {
                    conteudo.value = '';
                    loadMessages();
                }
            } catch (error) {
                console.error('Erro ao enviar mensagem:', error);
            }
        });

        // Carregar mensagens inicialmente e a cada 5 segundos
        loadMessages();
        setInterval(loadMessages, 5000);
    });
</script>

</body>
</html>