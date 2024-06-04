<?php
session_start();
header('Content-Type: text/html; charset=utf-8');

require_once 'conexao.php';

function validarEntrada($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

function validarCPF($cpf) {
    // Remove caracteres especiais
    $cpf = preg_replace('/[^0-9]/', '', $cpf);

    // Verifica se o CPF tem 11 dígitos
    if (strlen($cpf) != 11) {
        return false;
    }

    // Calcula os dígitos verificadores para verificar se o CPF é válido
    for ($t = 9; $t < 11; $t++) {
        for ($d = 0, $c = 0; $c < $t; $c++) {
            $d += $cpf[$c] * (($t + 1) - $c);
        }
        $d = ((10 * $d) % 11) % 10;
        if ($cpf[$c] != $d) {
            return false;
        }
    }

    return true;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = validarEntrada($_POST['nome']);
    $sobrenome = validarEntrada($_POST['sobrenome']);
    $datanasc = validarEntrada($_POST['dataNasc']);
    $cpf = validarEntrada($_POST['cpf']);
    $endereco = validarEntrada($_POST['endereco']);
    $cidade = validarEntrada($_POST['cidade']);
    $estado = validarEntrada($_POST['estado']);
    $complemento = validarEntrada($_POST['complemento']);
    $email = filter_var(validarEntrada($_POST['email']), FILTER_SANITIZE_EMAIL);
    $senha = password_hash(validarEntrada($_POST['senha']), PASSWORD_DEFAULT);
    $perfil = validarEntrada($_POST['perfil']);

    if (empty($nome) || empty($sobrenome) || empty($datanasc) || empty($cpf) || empty($endereco) || empty($cidade) || empty($estado) || empty($email) || empty($senha) || empty($perfil)) {
        $_SESSION['mensagem'] = 'Por favor, preencha todos os campos obrigatórios.';
        header('Location: cadastro.php');
        exit;
    }

    if (!validarCPF($cpf)) {
        $_SESSION['mensagem'] = 'CPF inválido.';
        header('Location: cadastro.php');
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['mensagem'] = 'E-mail inválido.';
        header('Location: cadastro.php');
        exit;
    }

    try {
        $dbh = Conexao::getConexao();

        $query = "INSERT INTO caopanheiro.usuario (nome, sobrenome, data_nascimento, cpf, cidade, estado, endereco, email, senha, perfil) 
                  VALUES (:nome, :sobrenome, :datanasc, :cpf, :cidade, :estado, :endereco, :email, :senha, :perfil)";

        $stmt = $dbh->prepare($query);

        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':sobrenome', $sobrenome);
        $stmt->bindParam(':datanasc', $datanasc);
        $stmt->bindParam(':cpf', $cpf);
        $stmt->bindParam(':cidade', $cidade);
        $stmt->bindParam(':estado', $estado);
        $stmt->bindParam(':endereco', $endereco);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':senha', $senha);
        $stmt->bindParam(':perfil', $perfil);

        if ($stmt->execute()) {
            $_SESSION['mensagem'] = 'Cadastrado com Sucesso!';
            header('Location: Paglogin.php');
            exit;
        } else {
            $_SESSION['mensagem'] = 'Não foi possível inserir Usuário!';
            $error = $stmt->errorInfo();
            print_r($error);
        }
    } catch (PDOException $e) {
        $_SESSION['mensagem'] = 'Erro ao conectar-se ao banco de dados: ' . $e->getMessage();
    } finally {
        $dbh = null;
    }

    header('Location: cadastro.php');
    exit;
} else {
    $_SESSION['mensagem'] = 'Método de requisição inválido.';
    header('Location: cadastro.php');
    exit;
}
?>