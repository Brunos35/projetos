<?php
session_start();
header('Content-Type: text/html; charset=utf-8;');

require __DIR__ . '/../conexao.php';

$petNome = $_POST['petNome'];
$petNasc = $_POST['petNasc'];
$petPorte = $_POST['porte'];
$petRaca = $_POST['raca'];
$petSexo = $_POST['sexo'];
$descricao = $_POST['descricao'];

# solicita a conexão com o banco de dados e guarda na váriavel dbh.
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
        $uploadFileDir = __DIR__ . '/imgPets/';
        $dest_path = $uploadFileDir . $newFileName;

        // Move o arquivo para o diretório de upload
        if (move_uploaded_file($fileTmpPath,$dest_path)) {

            # cria uma instrução SQL para inserir dados na tabela usuarios.
            $query = "INSERT INTO caopanheiro.pet (nome, dataNascimento, raca, porte, sexo, descricao, doador, foto) 
                VALUES (:nome, :dataNascimento, :raca, :porte, :sexo, :descricao, :doador, :foto);";

            # prepara a execução da query e retorna para uma variável chamada stmt.
            $stmt = $dbh->prepare($query);

            # com a variável stmt, usada bindParam para associar a cada um dos parâmetro
            # e seu tipo (opcional).
            $stmt->bindParam(':nome', $petNome);
            $stmt->bindParam(':dataNascimento', $petNasc);
            $stmt->bindParam(':raca', $petRaca);
            $stmt->bindParam(':porte', $petPorte);
            $stmt->bindParam(':sexo', $petSexo);
            $stmt->bindParam(':descricao', $descricao);
            $stmt->bindParam(':doador', $_SESSION['usuId']);
            $stmt->bindParam(':foto', $dest_path);
            var_dump($_SESSION['usuId']);
            $result = $stmt->execute();

            if ($result) {
                echo "<script>window.alert('Cadastrado com Sucesso!')</script>";
                header("Location: pets.php");
                exit;
            } else {
                echo '<p>Não foi fossível inserir Usuário!</p>';
                # método da classe conexao que informa o error ocorrido na execução da query.
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
