<?php
session_start();
// Conexão com o banco de dados MySQL usando PDO
    require_once 'conexao.php';

    // Recupera as credenciais do formulário de login
    $emailLogin = $_POST['emailLogin'];
    $senhaLogin = md5($_POST['senhaLogin']);


    # solicita a conexão com o banco de dados e guarda na váriavel dbh.
    $dbh = Conexao::getConexao();

    // Consulta preparada para verificar se o usuário existe no banco de dados
    $query = "SELECT * FROM usuarios WHERE email = :email and senha = :senha";

    
    $stmt = $dbh->prepare($query);
    $stmt->bindParam(':email', $emailLogin);
    $stmt->bindParam(':senha', $senhaLogin);
    $stmt->execute();

    // Verifica se a consulta retornou algum resultado
    if ($stmt->rowCount() > 0) {
        // Login bem sucedido
        // Recupera as informações do usuário
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        $_SESSION['perfil'] = $user['Perfil'];
        $_SESSION['nome']= $user['Nome'];
        $_SESSION['sobrenome']= $user['Sobrenome'];
        $_SESSION['data']= date('Y-m-d', strtotime($user['DataNascimento']));
        $_SESSION['email']= $user['Email'];
        $_SESSION['cpf'] = $user['CPF'];
        $_SESSION['endereco'] = $user['Endereco'];
        $_SESSION['Senha'] = $user['Senha'];
        $_SESSION['usuId'] = $user['UsuarioID'];
        $_SESSION['status'] = $user['status'];
        // Redireciona para a página correspondente ao perfil do usuário
        switch ($_SESSION['perfil']) {
            case 'adotante':
                header("Location: adotante/adotante_dashboard.php");
                break;
            case 'doador':
                header("Location: doador/doador_dashboard.php");
                break;
            case 'administrador':
                header("Location: admin/administrador_dashboard.php");
                break;
            default:
                echo "Perfil inválido!";
                break;
            }
        } else{
        // Login falhou
        echo "<script>window.alert('Usuário ou senha incorretos!')</script>";
        
    }