<?php 
   
// Verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Conexão com o banco de dados (substitua os valores conforme sua configuração)
    $servername = "localhost";
    $username = "root";
    $password = "Root123@";
    $dbname = "caopanheiro";

    $conn = new mysqli($servername, $username, $password, $dbname);

    // Verifica a conexão
    if ($conn->connect_error) {
        die("Erro na conexão com o banco de dados: " . $conn->connect_error);
    }

    // Prepara os dados recebidos do formulário
    $nome = $_POST['nome'];
    $sobrenome = $_POST['sobrenome'];
    $dataNascimento = $_POST['dataNasc'];
    $cpf = $_POST['cpf'];
    $endereco = $_POST['endereco'];
    $email = $_POST['email'];
    $numeroWhatsapp = $_POST['telefone'];
    $senha = $_POST['senha'];

    // Insere os dados na tabela de adotantes
    $sql = "INSERT INTO adotante (Nome, Sobrenome, DataNascimento, CPF, Endereco, Email, NumeroWhatsapp, Senha)
    VALUES ('$nome', '$sobrenome', '$dataNascimento', '$cpf', '$endereco', '$email', '$numeroWhatsapp', '$senha')";

    if ($conn->query($sql) === TRUE) {
        echo "Cadastro de adotante realizado com sucesso!";
    } else {
        echo "Erro ao cadastrar adotante: " . $conn->error;
    }

    // Fecha a conexão com o banco de dados
    $conn->close();
}

?>