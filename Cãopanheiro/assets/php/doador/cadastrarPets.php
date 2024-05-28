<?php
session_start();
header('Content-Type: text/html; charset=utf-8');

require __DIR__ . '/../conexao.php';

$petNome = $_POST['petNome'];
$petNasc = $_POST['petNasc'];
$petPorte = $_POST['porte'];
$petRaca = $_POST['raca'];
$petSexo = $_POST['sexo'];
$descricao = $_POST['descricao'];

$dbh = Conexao::getConexao();

$uploadFilePath = __DIR__ . '/imgPets/';

if (!is_dir($uploadFilePath)) {
    if (!mkdir($uploadFilePath, 0777, true)) {
        die('Erro ao criar o diretório de upload.');
    }
}

if (!is_writable($uploadFilePath)) {
    die('O diretório de upload não possui permissões de escrita.');
}

if (isset($_FILES['uploadFoto']) && $_FILES['uploadFoto']['error'] == UPLOAD_ERR_OK) {
    $fileTmpPath = $_FILES['uploadFoto']['tmp_name'];
    $fileName = $_FILES['uploadFoto']['name'];
    $fileSize = $_FILES['uploadFoto']['size'];
    $fileType = $_FILES['uploadFoto']['type'];
    $fileNameCmps = explode(".", $fileName);
    $fileExtension = strtolower(end($fileNameCmps));
    $allowedfileExtensions = array('jpg', 'gif', 'png', 'jpeg');

    if (in_array($fileExtension, $allowedfileExtensions)) {
        $newFileName = time() . '.' . $fileExtension;
        $dest_path = $uploadFilePath . $newFileName;

        if (move_uploaded_file($fileTmpPath, $dest_path)) {
            $relativeFilePath = 'doador/imgPets/' . $newFileName;
            $query = "INSERT INTO caopanheiro.pet (nome, dataNascimento, raca, porte, sexo, descricao, doador, foto) 
                      VALUES (:nome, :dataNascimento, :raca, :porte, :sexo, :descricao, :doador, :foto)";
            $stmt = $dbh->prepare($query);
            $stmt->bindParam(':nome', $petNome);
            $stmt->bindParam(':dataNascimento', $petNasc);
            $stmt->bindParam(':raca', $petRaca);
            $stmt->bindParam(':porte', $petPorte);
            $stmt->bindParam(':sexo', $petSexo);
            $stmt->bindParam(':descricao', $descricao);
            $stmt->bindParam(':doador', $_SESSION['usuId']);
            $stmt->bindParam(':foto', $relativeFilePath);
            $result = $stmt->execute();

            if ($result) {
                echo "<script>alert('Cadastrado com Sucesso!');</script>";
                header("Location: pets.php");
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
?>
