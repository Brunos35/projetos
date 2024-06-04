<?php
ob_start();
session_start();
require __DIR__ . '/../conexao.php';
$dbh = Conexao::getConexao();

// Verifica se o formulário foi submetido
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $petNome = $_POST['alterNome'];
    $petNascimento = $_POST['alterPetNasc'];
    $petPorte = $_POST['porte'];
    $petRaca = $_POST['raca'];
    $petSexo = $_POST['sexo'];
    $descricao = $_POST['descricao'];

    // Verifica se o upload da foto foi realizado com sucesso
    if (isset($_FILES['uploadFoto']) && $_FILES['uploadFoto']['error'] == UPLOAD_ERR_OK) {
        // Diretório de upload
        $uploadFilePath = __DIR__ . '/imgPets/';
        
        // Verifica e cria o diretório de upload, se necessário
        if (!is_dir($uploadFilePath)) {
            if (!mkdir($uploadFilePath, 0777, true)) {
                die('Erro ao criar o diretório de upload.');
            }
        }

        // Verifica se o diretório de upload possui permissões de escrita
        if (!is_writable($uploadFilePath)) {
            die('O diretório de upload não possui permissões de escrita.');
        }

        // Informações do arquivo enviado
        $fileTmpPath = $_FILES['uploadFoto']['tmp_name'];
        $fileName = $_FILES['uploadFoto']['name'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));
        $allowedfileExtensions = array('jpg', 'gif', 'png', 'jpeg');

        // Verifica a extensão do arquivo
        if (in_array($fileExtension, $allowedfileExtensions)) {
            // Gera um novo nome único para o arquivo
            $newFileName = time() . '.' . $fileExtension;
            $dest_path = $uploadFilePath . $newFileName;

            // Move o arquivo para o diretório de upload
            if (move_uploaded_file($fileTmpPath, $dest_path)) {
                $relativeFilePath = 'doador/imgPets/' . $newFileName;
                $query = "UPDATE caopanheiro.pets SET nome = :nome, dataNascimento = :dataNascimento, raca = :raca, porte = :porte, sexo = :sexo, descricao = :descricao, foto = :foto WHERE petId = :petId";
                $stmt = $dbh->prepare($query);
                $stmt->bindParam(':nome', $petNome);
                $stmt->bindParam(':dataNascimento', $petNascimento);
                $stmt->bindParam(':raca', $petRaca);
                $stmt->bindParam(':porte', $petPorte);
                $stmt->bindParam(':sexo', $petSexo);
                $stmt->bindParam(':descricao', $descricao);
                $stmt->bindParam(':foto', $relativeFilePath);
                $stmt->bindParam(':petId', $_SESSION['petId']);
                $result = $stmt->execute();

                // Redireciona após a operação ser concluída
                if ($result) {
                    header("Location: pets.php?status=success");
                    exit;
                } else {
                    echo '<p>Não foi possível cadastrar o pet!</p>';
                    $error = $dbh->errorInfo();
                    print_r($error);
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
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Área Restrita</title>

    <link rel="stylesheet" href="../../css/dashboards.css">
    <link rel="stylesheet" href="../../css/cadastroPet.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <style>
        h1 {
            text-align: center;
        }

        nav {
            height: 115% !important;
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
            <li><a href="doador_dashboard.php">Meu Perfil</a></li>
            <li><a href="../chat/listaChats.php">Conversas</a></li>
            <li><a href="../logout.php">Sair</a></li>
        </ul>
    </nav>

    <main>
        <div class="content" id="conteudo">

            <h1>Alterar Informações</h1>
            <?php
            if (isset($_GET['status']) && $_GET['status'] == 'success') {
                echo '<div class="alert">
                <span class="closebtn" onclick="this.parentElement.style.display = \'none\';">&times;</span>
                Dados Alterados com sucesso!
                </div>';
            }
            ?>
            <form action="alterarPet.php" method="post">
                <div>
                    <label for="alterNome">Nome do Pet: </label>
                    <input type="text" name="alterNome" id="alterNome" value="<?= $_SESSION['petNome'] ?>">
                </div>

                <div>
                    <label for="alterPetNasc">Data de nascimento: </label>
                    <input type="date" name="alterPetNasc" id="alterPetNasc" value="<?= $_SESSION['petDataNasc'] ?>">
                </div>

                <div class="radio">
                    <label>Porte: </label>
                    <label for="pequeno">Pequeno</label>
                    <input type="radio" name="porte" id="pequeno" value="pequeno" <?= $_SESSION['petPorte'] == 'pequeno' ? 'checked' : '' ?>>
                    <label for="medio">Médio</label>
                    <input type="radio" name="porte" id="medio" value="medio" <?= $_SESSION['petPorte'] == 'medio' ? 'checked' : '' ?>>
                    <label for="grande">Grande</label>
                    <input type="radio" name="porte" id="grande" value="grande" <?= $_SESSION['petPorte'] == 'grande' ? 'checked' : '' ?>>
                </div>

                <div class="raca">
                    <label>Raça: </label>
                    <select name="raca" id="raca">
                       <option value="<?= $_SESSION['petRaca'] ?>"><?= $_SESSION['petRaca'] ?></option> <option value="null">Selecione uma opção</option>                        
                        <option value="labrador">labrador</option>
                        <option value="golden retriever">golden retriever</option>
                        <option value="dalmata">dalmata</option>
                        <option value="bulldog">bulldog</option>
                        <option value="pitbull">pitbull</option>
                        <option value="pincher">pincher</option>
                    </select>
                </div>

                <div class="radio">
                    <label>Sexo: </label>
                    <label for="macho">Macho</label>
                    <input type="radio" name="sexo" id="macho" value="M" <?= $_SESSION['petSexo'] == 'M' ? 'checked' : '' ?>>
                    <label for="femea">Fêmea</label>
                    <input type="radio" name="sexo" id="femea" value="F" <?= $_SESSION['petSexo'] == 'F' ? 'checked' : '' ?>>
                </div>
                <label for="descricao">Descrição:</label>
                <textarea name="descricao" id="descricao" cols="30" rows="4" placeholder="Fale um pouco sobre o pet"><?= $_SESSION['petDescricao'] ?></textarea>

                <div class="dropzone-box" method="post">
                    <label>Adicione as fotos: </label>
                    <div class="dropzone-area">
                        <div class="uploadIcon">ICONE</div>
                        <input type="file" id="uploadFoto" name="uploadFoto" >
                        <p class="fotoInfo">Sem arquivo selecionado</p>
                    </div>
                    <div class="dropzone-actions">
                        <button type="reset">Cancelar</button>

                    </div>
                </div>
                <div id="submit">
                    <input type="submit" value="Salvar">
                </div>
            </form>

        </div>
    </main>
    <script src="../../js/script.js"></script>
    <script src="../../js/alert.js"></script>

</body>

</html>