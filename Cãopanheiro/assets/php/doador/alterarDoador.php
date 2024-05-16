<?php
session_start();
require __DIR__ . '/../conexao.php';
$dbh = Conexao::getConexao();
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Área Restrita</title>

    <link rel="stylesheet" href="../../css/dashboards.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <style>
        input,
        label {
            height: 25px !important;
            margin: 5px 0px 5px 2px;
        }

        input {
            width: 200px !important;
            height: 25px !important;
            margin-right: 10px;
            border: 1px dashed var(--color3);
            border-radius: 10px;
        }

        input#alterEndereco {
            width: 480px !important;
        }

        input#alterDataNasc {
            width: 105px !important;
        }

        input#alterCpf {
            width: 210px !important;
        }

        input#alterSenha {
            width: 161px !important;
        }
    </style>
</head>

<body>
    <header>
        <button class="nav-toggle"><span class="material-symbols-outlined">
                menu
            </span></button>
        <figure class="logo"><img src="../../img/logo1.png" alt=""></figure>
        <div class="user-info">Bem-vindo, <?= $_SESSION['nome']; ?> <span id="username"></span></div>
    </header>
    <nav>
        <ul>
            <li><a href="pets.php">Meus Pet</a></li>
            <li><a href="alterarDoador.php">Meu Perfil</a></li>
            <li><a href="#">Conversas</a></li>
            <li><a href="../../index.html">Página Inicial</a></li>
            <li><a href="">Sair</a></li>
        </ul>
    </nav>

    <main>
        <div class="content" id="conteudo">

            <h1>Alterar Informações</h1>

            <form action="alterarDoador.php" method="post">

                <label for="alterNome">Nome: </label>
                <input type="text" name="alterNome" id="alterNome" required value=" <?= $_SESSION['nome'] ?>">

                <label for="alterSobrenome">Sobrenome: </label>
                <input type="text" name="alterSobrenome" required value=" <?= $_SESSION['sobrenome'] ?>">
                <br>
                <label for="dataNasc">Data de Nascimento: </label>
                <input type="date" name="alterDataNasc" id="alterDataNasc" value=" <?= $_SESSION['data'] ?>">
                <br>
                <label for="cpf">CPF: </label>
                <input type="number" name="alterCpf" id="alterCpf" value="<?= $_SESSION['cpf'] ?>">
                <br>
                <label for="alterEndereco">Endereço: </label>
                <input type="text" name="alterEndereco" id="alterEndereco" value=" <?= $_SESSION['endereco'] ?>">
                <br>
                <label for="alterEmail">E-mail</label>
                <input type="email" name="alterEmail" id="alterEmail" required autofocus value="<?= $_SESSION['email'] ?>"><br>
                
                <label for="alterSenha">Nova senha: </label>
                <input type="password" name="alterSenha" id="alterSenha">
                <br>
                <button class="salvar" type="submit">Salvar</button>
            </form>

        </div>
    </main>
    <script src="../../js/script.js">

    </script>
</body>

</html>
<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $nome = $_POST['alterNome'];
    $sobrenome = $_POST['alterSobrenome'];
    $dataNasc = $_POST['alterDataNasc'];
    $cpf = $_POST['alterCpf'];
    $endereco = $_POST['alterEndereco'];
    $email = $_POST['alterEmail'];
    $senha = $_POST['alterSenha'];

    $dbh = Conexao::getConexao();

    // Verifica se uma imagem foi enviada
    if (isset($_FILES['uploadFoto']) && $_FILES['uploadFoto']['error'] == UPLOAD_ERR_OK) {
        // Obtém informações da imagem
        $fileTmpPath = $_FILES['uploadFoto']['tmp_name'];
        $fileName = $_FILES['uploadFoto']['name'];
        $fileSize = $_FILES['uploadFoto']['size'];
        $fileType = $_FILES['uploadFoto']['type'];
        //obtém a extensão da imagem
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));
         // Define os tipos de arquivos permitidos
         $allowedfileExtensions = array('jpg', 'gif', 'png', 'jpeg');

         if (in_array($fileExtension, $allowedfileExtensions)) {
            // Cria um novo nome para a imagem
            $newFileName = time() . $fileName . '.' . $fileExtension;
            // Define o caminho onde a imagem será armazenada
            $uploadFileDir = __DIR__ . 'imagemPets/';
            $dest_path = $uploadFileDir . $newFileName;

              // Move o arquivo para o diretório de upload
              if(move_uploaded_file($dest_path)) {
                // Prepara a instrução SQL para inserir os dados no banco de dados
               
                $sql = "UPDATE caopanheiro.usuarios SET Nome = :nome, Sobrenome = :sobrenome, DataNascimento = :dataNasc, CPF = :cpf, Endereco = :endereco, Email = :email, foto_caminho = :fotoCaminho WHERE UsuarioID = :id";
                    if(!empty($senha))
                    $sql = "UPDATE caopanheiro.usuarios SET Nome = :nome, Sobrenome = :sobrenome, DataNascimento = :dataNasc, CPF = :cpf, Endereco = :endereco, Email = :email, Senha = :senha WHERE UsuarioID = :id";


                $stmt = $dbh->prepare($sql);
                $stmt->bindParam(':id', $_SESSION['usuId']);
                $stmt->bindParam(':nome', $nome);
                $stmt->bindParam(':sobrenome', $sobrenome);
                $stmt->bindParam(':dataNasc', $dataNasc);
                $stmt->bindParam(':cpf', $cpf);
                $stmt->bindParam(':endereco', $endereco);
                $stmt->bindParam(':email', $email);
                $stmt->bindParam(':fotoCaminho', $dest_path);

                    if(!empty($senha))
                        $stmt->bindParam(':senha', md5($senha));
                    $result = $stmt->execute();

                    if ($result) {
                        echo 'Alterado com sucesso';
                        $_SESSION['nome'] = $nome;
                        $_SESSION['sobrenome'] = $sobrenome;
                        $_SESSION['data'] = $dataNasc;
                        $_SESSION['cpf'] = $cpf;
                        $_SESSION['endereco'] = $endereco;
                        $_SESSION['email'] = $email;
                        header("Location: doador_dashboard.php");
                        exit();
                    } else {
                        echo "Erro ao cadastrar o pet.";
                    }
                } else {
                    echo "Erro ao mover o arquivo para o diretório de upload.";
                }
            } else {
                echo "Tipo de arquivo não permitido.";
            }
        } else {
            echo "Nenhuma imagem enviada ou houve um erro no upload.";
        }
}
?>