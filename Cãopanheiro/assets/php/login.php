<?php
session_start();
// Conexão com o banco de dados MySQL usando PDO
require_once 'conexao.php';

// Verifica se os campos foram enviados
if (isset($_POST['emailLogin']) && isset($_POST['senhaLogin'])) {
    $emailLogin = filter_var($_POST['emailLogin'], FILTER_SANITIZE_EMAIL);
    $senhaLogin = $_POST['senhaLogin'];  // Senha em texto plano

    // Solicita a conexão com o banco de dados e guarda na variável dbh.
    $dbh = Conexao::getConexao();

    // Verifica se a conexão foi estabelecida
    if ($dbh) {
        // Consulta preparada para verificar se o usuário existe no banco de dados
        $query = "
        SELECT 
    u.UsuarioID, u.Nome, u.Sobrenome, u.DataNascimento, u.CPF, u.Endereco, u.Email, u.Telefone, u.Senha, u.Perfil, u.status 
FROM 
    usuarios u
WHERE 
    u.Email = :email
UNION
SELECT 
    a.adminId AS UsuarioID, a.nome AS Nome, a.sobrenome AS Sobrenome, NULL AS DataNascimento, NULL AS CPF, NULL AS Endereco, a.email AS Email, NULL AS Telefone, a.senha AS Senha, a.perfil AS Perfil, a.status 
FROM 
    administrador a
WHERE 
    a.email = :email
";

        $stmt = $dbh->prepare($query);
        $stmt->bindParam(':email', $emailLogin);
        $stmt->execute();

        // Verifica se a consulta retornou algum resultado
        if ($stmt->rowCount() > 0) {
            // Recupera as informações do usuário
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            // Verifica se o campo Senha está presente e não é nulo
            if (isset($user['Senha']) && !is_null($user['Senha'])) {
                // Verifica se a senha fornecida corresponde ao hash armazenado
                if (password_verify($senhaLogin, $user['Senha'])) {
                    $isAdmin = isset($user['Perfil']) && $user['Perfil'] === 'administrador';

                    $_SESSION['perfil'] = $isAdmin ? 'administrador' : (isset($user['Perfil']) ? $user['Perfil'] : 'adotante');
                    $_SESSION['nome'] = $user['Nome'];
                    $_SESSION['sobrenome'] = $user['Sobrenome'];
                    $_SESSION['data'] = date('Y-m-d', strtotime($user['DataNascimento']));
                    $_SESSION['email'] = $user['Email'];
                    $_SESSION['cpf'] = $user['CPF'];
                    $_SESSION['endereco'] = $user['Endereco'];
                    $_SESSION['usuId'] = $user['UsuarioID'];                   
                    $_SESSION['status'] = isset($user['status']) ? $user['status'] : 'ativo';
                    
                    // Redireciona para a página correspondente ao perfil do usuário
                    switch ($_SESSION['perfil']) {
                        case 'adotante':
                            header("Location: adotante/adotante_dashboard.php");
                            exit();
                        case 'doador':                          
                            header("Location: doador/doador_dashboard.php");
                            exit();
                        case 'administrador':                           
                            header("Location: admin/administrador_dashboard.php");
                            exit();
                        default:
                            echo "Perfil inválido!";
                            exit();
                    }
                } else {
                    // Senha incorreta
                    echo "<script>window.alert('Usuário ou senha incorretos!')</script>";
                    echo "<script>window.location.href = 'Paglogin.php'</script>";
                    exit();
                }
            } else {
                // Senha não encontrada no resultado da consulta
                echo "<script>window.alert('Erro no sistema: senha não encontrada.')</script>";
                # echo "<script>window.location.href = 'Paglogin.php'</script>";
                exit();
            }
        } else {
            // E-mail não encontrado
            echo "<script>window.alert('Usuário ou senha incorretos!')</script>";
            # echo "<script>window.location.href = 'Paglogin.php'</script>";
            exit();
        }
    } else {
        // Falha na conexão com o banco de dados
        echo "<script>window.alert('Erro ao conectar-se ao banco de dados!')</script>";
        # echo "<script>window.location.href = 'Paglogin.php'</script>";
        exit();
    }
} else {
    // Campos de login não foram enviados
    echo "<script>window.alert('Por favor, preencha os campos de login!')</script>";
    echo "<script>window.location.href = 'Paglogin.php'</script>";
    exit();
}
