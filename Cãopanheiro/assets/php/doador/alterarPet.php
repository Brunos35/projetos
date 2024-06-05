<?php
ob_start();
session_start();
require __DIR__ . '/../conexao.php';

$dbh = Conexao::getConexao();

if (isset($_GET['Id'])) {
    $petId = intval($_GET['Id']);
} elseif (isset($_POST['petId'])) {
    $petId = intval($_POST['petId']);
} else {
    die('ID do pet não fornecido.');
}

$query = "SELECT * FROM caopanheiro.pets WHERE petId = :id";
$stmt = $dbh->prepare($query);
$stmt->bindValue(':id', $petId, PDO::PARAM_INT);
$stmt->execute();

$pet = $stmt->fetch(PDO::FETCH_ASSOC);

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
            <li><a href="chatsDoador.php">Conversas</a></li>
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
            <form action="alterarPet.php?Id=<?= $petId ?>" method="post">
                <input type="hidden" name="Id" value="<?= $petId ?>">
                <div>
                    <label for="alterNome">Nome do Pet: </label>
                    <input type="text" name="alterNome" id="alterNome" value="<?= $pet['nome'] ?>">
                </div>

                <div>
                    <label for="alterPetNasc">Data de nascimento: </label>
                    <input type="date" name="alterPetNasc" id="alterPetNasc" value="<?= $pet['dataNascimento'] ?>">
                </div>

                <div class="radio">
                    <label>Porte: </label>
                    <label for="pequeno">Pequeno</label>
                    <input type="radio" name="porte" id="pequeno" value="pequeno" <?= $pet['porte'] == 'pequeno' ? 'checked' : '' ?>>
                    <label for="medio">Médio</label>
                    <input type="radio" name="porte" id="medio" value="medio" <?= $pet['porte'] == 'medio' ? 'checked' : '' ?>>
                    <label for="grande">Grande</label>
                    <input type="radio" name="porte" id="grande" value="grande" <?= $pet['porte'] == 'grande' ? 'checked' : '' ?>>
                </div>

                <div class="radio">
                    <label>Espécie: </label>
                    <label for="cachorro">Cachorro</label>
                    <input type="radio" name="especie" id="cachorro" value="cachorro" required>
                    <label for="gato">Gato</label>
                    <input type="radio" name="especie" id="gato" value="gato" required>
                </div>

                <div class="raca">
                    <label>Raça: </label>
                    <select name="raca" id="raca">
                        <option value="<?= $pet['raca'] ?>"><?= $pet['raca'] ?></option>
                        <option value="null">Selecione uma opção</option>
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
                    <input type="radio" name="sexo" id="macho" value="M" <?= $pet['sexo'] == 'M' ? 'checked' : '' ?>>
                    <label for="femea">Fêmea</label>
                    <input type="radio" name="sexo" id="femea" value="F" <?= $pet['sexo'] == 'F' ? 'checked' : '' ?>>
                </div>
                <label for="descricao">Descrição:</label>
                <textarea name="descricao" id="descricao" cols="30" rows="4" placeholder="Fale um pouco sobre o pet"><?= $pet['descricao'] ?></textarea>

                <div class="dropzone-box" method="post">
                    <label>Adicione as fotos: </label>
                    <div class="dropzone-area">
                        <div class="uploadIcon">ICONE</div>
                        <input type="file" id="uploadFoto" name="uploadFoto">
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
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const especieRadios = document.querySelectorAll('input[name="especie"]');
            const racaContainer = document.getElementById('raca-container');
            const racaSelect = document.getElementById('raca');

            const racas = {
                cachorro: ['labrador', 'golden retriever', 'dalmata', 'bulldog', 'pitbull', 'pincher'],
                gato: ['persa', 'siamês', 'maine coon', 'bengal', 'sphynx']
            };

            especieRadios.forEach(radio => {
                radio.addEventListener('change', (event) => {
                    const especie = event.target.value;
                    racaSelect.innerHTML = '<option value="null">Selecione uma opção</option>';
                    if (racas[especie]) {
                        racas[especie].forEach(raca => {
                            const option = document.createElement('option');
                            option.value = raca;
                            option.textContent = raca;
                            racaSelect.appendChild(option);
                        });
                        racaContainer.style.display = 'block';
                    } else {
                        racaContainer.style.display = 'none';
                    }
                });
            });
        });
    </script>


</body>

</html>
<?php
// Função para validar e sanitizar entradas
function sanitizeInput($data)
{
    return htmlspecialchars(strip_tags(trim($data)));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuarioId = $_SESSION['usuId'];
    $petId = isset($_POST['petId']) ? intval($_POST['petId']) : null;
    $petNome = sanitizeInput($_POST['alterNome']);
    $petNasc = sanitizeInput($_POST['alterPetNasc']);
    $especie = sanitizeInput($_POST['especie']);
    $porte = sanitizeInput($_POST['porte']);
    $raca = sanitizeInput($_POST['raca']);
    $sexo = sanitizeInput($_POST['sexo']);
    $descricao = sanitizeInput($_POST['descricao']);

    if (isset($_FILES['uploadFoto']) && $_FILES['uploadFoto']['error'] === UPLOAD_ERR_OK) {
        $fotoTmpPath = $_FILES['uploadFoto']['tmp_name'];
        $fotoName = basename($_FILES['uploadFoto']['name']);
        $fotoSize = $_FILES['uploadFoto']['size'];
        $fotoType = $_FILES['uploadFoto']['type'];

        $uploadDir = '../../uploads/';
        $destPath = $uploadDir . $fotoName;

        $fotoTmpPath = $_FILES['uploadFoto']['tmp_name'];
        $fotoName = basename($_FILES['uploadFoto']['name']);
        $fotoSize = $_FILES['uploadFoto']['size'];
        $fotoType = $_FILES['uploadFoto']['type'];

        $uploadDir = '../../uploads/';
        $destPath = $uploadDir . $fotoName;

        // Mensagem de depuração para verificar o caminho temporário da foto
        echo "Caminho temporário da foto: " . $fotoTmpPath . "<br>";

        // Mensagem de depuração para verificar o nome da foto
        echo "Nome da foto: " . $fotoName . "<br>";

        // Mensagem de depuração para verificar o tamanho da foto
        echo "Tamanho da foto: " . $fotoSize . " bytes<br>";

        // Mensagem de depuração para verificar o tipo da foto
        echo "Tipo da foto: " . $fotoType . "<br>";

        if (move_uploaded_file($fotoTmpPath, $destPath)) {
            try {
                $dbh = Conexao::getConexao();
                $stmt = $dbh->prepare("UPDATE pets SET nome = ?, dataNascimento = ?, especie = ?, porte = ?, raca = ?, sexo = ?, descricao = ?, foto = ? WHERE petId = ?");
                $stmt->execute([$petNome, $petNasc, $especie, $porte, $raca, $sexo, $descricao, $fotoName, $petId]);
                echo "Informações do pet atualizadas com sucesso!";
            } catch (PDOException $e) {
                echo "Erro ao atualizar informações do pet: " . $e->getMessage();
            }
        } else {
            echo "Erro ao fazer upload da foto.";
        }
    } else {
        try {
            $dbh = Conexao::getConexao();
            $stmt = $dbh->prepare("UPDATE pets SET nome = ?, dataNascimento = ?, especie = ?, porte = ?, raca = ?, sexo = ?, descricao = ? WHERE petId = ?");
            $stmt->execute([$petNome, $petNasc, $especie, $porte, $raca, $sexo, $descricao, $petId]);
            echo "Informações do pet atualizadas!";
        } catch (PDOException $e) {
            echo "Erro ao atualizar informações do pet: " . $e->getMessage();
        }
    }
}
?>