<?php
session_start();
header('Content-Type: text/html; charset=utf-8');

require_once 'conexao.php';

# Função para validar dados de entrada
function validarEntrada($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

# Verifica se os dados foram enviados via POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    # Recebe e valida os valores enviados do formulário via método POST
    $nome = validarEntrada($_POST['nome']);
    $sobrenome = validarEntrada($_POST['sobrenome']);
    $datanasc = validarEntrada($_POST['dataNasc']);
    $cpf = validarEntrada($_POST['cpf']);
    $endereco = validarEntrada($_POST['endereco']);
    $telefone = validarEntrada($_POST['telefone']);
    $email = filter_var(validarEntrada($_POST['email']), FILTER_SANITIZE_EMAIL);
    $senha = password_hash(validarEntrada($_POST['senha']), PASSWORD_DEFAULT);
    $perfil = validarEntrada($_POST['perfil']);

    # Verifica se todos os campos obrigatórios foram preenchidos
    if (empty($nome) || empty($sobrenome) || empty($datanasc) || empty($cpf) || empty($endereco) || empty($telefone) || empty($email) || empty($senha) || empty($perfil)) {
        echo '<p>Por favor, preencha todos os campos obrigatórios.</p>';
        echo "<p><a href='index.php'>Voltar</a></p>";
        exit;
    }

    # Verifica se o e-mail é válido
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo '<p>E-mail inválido.</p>';
        echo "<p><a href='index.php'>Voltar</a></p>";
        exit;
    }

    try {
        # Solicita a conexão com o banco de dados e guarda na variável dbh.
        $dbh = Conexao::getConexao();

        # Cria uma instrução SQL para inserir dados na tabela usuarios.
        $query = "INSERT INTO caopanheiro.usuarios (Nome, Sobrenome, DataNascimento, CPF, Endereco, Telefone, Email, Senha, Perfil) 
                  VALUES (:Nome, :Sobrenome, :DataNascimento, :CPF, :Endereco, :Telefone, :Email, :Senha, :Perfil)";

        # Prepara a execução da query e retorna para uma variável chamada stmt.
        $stmt = $dbh->prepare($query);

        # Associa os parâmetros aos valores
        $stmt->bindParam(':Nome', $nome);
        $stmt->bindParam(':Sobrenome', $sobrenome);
        $stmt->bindParam(':DataNascimento', $datanasc);
        $stmt->bindParam(':CPF', $cpf);
        $stmt->bindParam(':Endereco', $endereco);
        $stmt->bindParam(':Telefone', $telefone);
        $stmt->bindParam(':Email', $email);
        $stmt->bindParam(':Senha', $senha);
        $stmt->bindParam(':Perfil', $perfil);

        # Executa a instrução contida em stmt
        if ($stmt->execute()) {
            echo "<script>alert('Cadastrado com Sucesso!')</script>";
            header('Location: Paglogin.php');
            exit;
        } else {
            echo '<p>Não foi possível inserir Usuário!</p>';
            $error = $stmt->errorInfo();
            print_r($error);
        }
    } catch (PDOException $e) {
        echo '<p>Erro ao conectar-se ao banco de dados: ' . $e->getMessage() . '</p>';
    } finally {
        # Fecha a conexão
        $dbh = null;
    }

    echo "<p><a href='index.php'>Voltar</a></p>";
} else {
    echo '<p>Método de requisição inválido.</p>';
    echo "<p><a href='index.php'>Voltar</a></p>";
}
?>
