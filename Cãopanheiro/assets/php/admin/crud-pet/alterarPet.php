<?php
ob_start();
session_start();

// Verifica se o usuário está autenticado
if (!isset($_SESSION['nome'])) {
    header("Location: ../../login.php");
    exit;
}

require __DIR__ . '/../../conexao.php';

$dbh = Conexao::getConexao();

$petId = isset($_GET['id']) ? intval($_GET['id']) : 0;

function validarEntrada($data) {
    return htmlspecialchars(trim($data));
}

// Obtém os dados do pet
$query = "SELECT * FROM pet WHERE petId = :petId";
$stmt = $dbh->prepare($query);
$stmt->bindParam(':petId', $petId, PDO::PARAM_INT);
$stmt->execute();
$pet = $stmt->fetch(PDO::FETCH_ASSOC);

if ($pet) {
    $nome = $pet['nome'];
    $petDataNasc = $pet['dataNascimento'];
    $petRaca = $pet['raca'];
    $petPorte = $pet['porte'];
    $petSexo = $pet['sexo'];
    $petDescricao = $pet['descricao'];
    $petStatus = $pet['status'];
}

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Área Restrita</title>
    <link rel="stylesheet" href="../../../css/dashboards.css">
    <link rel="stylesheet" href="../../../css/cadastroPet.css">
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
        <button class="nav-toggle"><span class="material-symbols-outlined">menu</span></button>
        <figure class="logo"><img src="../../../img/logo1.png" alt=""></figure>
        <div class="user-info">Bem-vindo, <?= htmlspecialchars($_SESSION['nome'], ENT_QUOTES, 'UTF-8'); ?> <span id="username"></span></div>
    </header>
    <nav>
        <ul>
            <li><a href="pets.php">Pets cadastrados</a></li>
            <li><a href="../crud-usuario/listaUsuarios.php">Usuários cadastrados</a></li>
            <li><a href="../administrador_dashboard.php">Meu Perfil</a></li>
            <li><a href="../listaAdmin.php">Administradores</a></li>
            <li><a href="#">Conversas</a></li>
            <li><a href="../../logout.php">Sair</a></li>
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
            <form action="alterarPet.php?id=<?= $petId; ?>" method="post">
                <div>
                    <label for="alterNome">Nome do Pet: </label>
                    <input type="text" name="alterNome" id="alterNome" value="<?= htmlspecialchars($nome, ENT_QUOTES, 'UTF-8'); ?>" required>
                </div>
                <div>
                    <label for="alterPetNasc">Data de nascimento: </label>
                    <input type="date" name="alterPetNasc" id="alterPetNasc" value="<?= htmlspecialchars($petDataNasc, ENT_QUOTES, 'UTF-8'); ?>" required>
                </div>
                <div class="radio">
                    <label>Porte: </label>
                    <label for="pequeno">Pequeno</label>
                    <input type="radio" name="porte" id="pequeno" value="pequeno" <?= $petPorte == 'pequeno' ? 'checked' : '' ?>>
                    <label for="medio">Médio</label>
                    <input type="radio" name="porte" id="medio" value="medio" <?= $petPorte == 'medio' ? 'checked' : '' ?>>
                    <label for="grande">Grande</label>
                    <input type="radio" name="porte" id="grande" value="grande" <?= $petPorte == 'grande' ? 'checked' : '' ?>>
                </div>
                <div class="raca">
                    <label>Raça: </label>
                    <select name="raca" id="raca">
                        <option value="<?= htmlspecialchars($petRaca, ENT_QUOTES, 'UTF-8'); ?>"><?= htmlspecialchars($petRaca, ENT_QUOTES, 'UTF-8'); ?></option>
                        <option value="null">Selecione uma opção</option>
                        <option value="labrador">Labrador</option>
                        <option value="golden retriever">Golden Retriever</option>
                        <option value="dalmata">Dálmata</option>
                        <option value="bulldog">Bulldog</option>
                        <option value="pitbull">Pitbull</option>
                        <option value="pincher">Pincher</option>
                    </select>
                </div>
                <div class="radio">
                    <label>Sexo: </label>
                    <label for="macho">Macho</label>
                    <input type="radio" name="sexo" id="macho" value="Macho" <?= $petSexo == 'Macho' ? 'checked' : '' ?>>
                    <label for="femea">Fêmea</label>
                    <input type="radio" name="sexo" id="femea" value="Fêmea" <?= $petSexo == 'Fêmea' ? 'checked' : '' ?>>
                </div>
                <label for="descricao">Descrição:</label>
                <textarea name="descricao" id="descricao" cols="30" rows="4" placeholder="Fale um pouco sobre o pet"><?= htmlspecialchars($petDescricao, ENT_QUOTES, 'UTF-8'); ?></textarea>
                <div id="submit">
                    <input type="submit" value="Salvar">
                </div>
            </form>
        </div>
    </main>
    <script src="../../../js/script.js"></script>
    <script src="../../../js/alert.js"></script>
</body>
</html>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $petNome = validarEntrada($_POST['alterNome']);
    $petNascimento = validarEntrada($_POST['alterPetNasc']);
    $petPorte = validarEntrada($_POST['porte']);
    $petRaca = validarEntrada($_POST['raca']);
    $petSexo = validarEntrada($_POST['sexo']);
    $descricao = validarEntrada($_POST['descricao']);

    $sql = "UPDATE caopanheiro.pet SET nome = :nome, dataNascimento = :dataNasc, raca = :raca, porte = :porte, sexo = :sexo, descricao = :descricao WHERE petId = :petId";
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':nome', $petNome);
    $stmt->bindParam(':dataNasc', $petNascimento);
    $stmt->bindParam(':raca', $petRaca);
    $stmt->bindParam(':porte', $petPorte);
    $stmt->bindParam(':sexo', $petSexo);
    $stmt->bindParam(':descricao', $descricao);
    $stmt->bindParam(':petId', $petId, PDO::PARAM_INT);

    if ($stmt->execute()) {
        header("Location: alterarPet.php?id=$petId&status=success");
        exit;
    } else {
        echo '<p>Não foi possível alterar as informações do pet!</p>';
        $errorInfo = $stmt->errorInfo();
        echo '<p>Erro: ' . htmlspecialchars($errorInfo[2], ENT_QUOTES, 'UTF-8') . '</p>';
    }
}

ob_end_flush();
?>
