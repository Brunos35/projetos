<?php
session_start();

require __DIR__ . '/../../conexao.php';
# solicita a conexão com o banco de dados e guarda na váriavel dbh.
$dbh = Conexao::getConexao();

# cria uma instrução SQL para selecionar todos os dados na tabela pet.
$query = "SELECT * FROM caopanheiro.pet";

# prepara a execução da query e retorna para uma variável chamada stmt.
$stmt = $dbh->prepare($query);
$stmt->execute();

# devolve a quantidade de linhas retornada pela consulta a tabela.
$quantidadeRegistros = $stmt->rowCount();

# Cria um array para armazenar os IDs dos pets.
$petIds = [];
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Área Restrita</title>
    <link rel="stylesheet" href="../../../css/dashboards.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <style>

    </style>
</head>

<body>
    <header>
        <button class="nav-toggle"><span class="material-symbols-outlined">menu</span></button>
        <figure class="logo"><img src="../../../img/logo1.png" alt=""></figure>
        <div class="user-info">Bem-vindo,
            <?= htmlspecialchars($_SESSION['nome'], ENT_QUOTES, 'UTF-8'); ?> <span id="username"></span>
        </div>
    </header>
    <nav>
        <ul>
            <li><a href="pets.php">Pets cadastrados</a></li>
            <li><a href="../crud-usuario/listaUsuarios.php">Usuários cadastrados</a></li>
            <li><a href="../administrador_dashboard.php">Meu Perfil</a></li>
            <li><a href="../listaAdmin.php">Administradores</a></li>
            <li><a href="../chat/listaChats.php">Conversas</a></li>
            <li><a href="../../logout.php">Sair</a></li>
        </ul>
    </nav>
    <div class="content" id="conteudo">
        <h1>Pets cadastrados</h1>
        </section>

        <hr>

        <section>
            <table id="pet">
                <thead>
                    <tr>
                        <th>Doador</th>
                        <th id="nome">Nome</th>
                        <th id="raca">Raça</th>
                        <th>Sexo</th>
                        <th>Status</th>
                        <th colspan="2" class="acoes">Ações</th>
                    </tr>
                </thead>

                <tbody>
                    <?php if ($quantidadeRegistros == 0): ?>
                        <tr>
                            <td colspan="6">Não existem pets cadastrados.</td>
                        </tr>
                    <?php else: ?>
                        <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
                            <?php
                            $status = $row['status'] == "adotado" ? "ADOTADO" : "DISPONÍVEL";
                            $petId = intval($row['petId']);
                            # Armazena o ID no array, se ainda não estiver presente
                            if (!in_array($petId, $petIds)) {
                                $petIds[] = $petId;
                            }
                            ?>
                            <tr>
                                <td><?= htmlspecialchars($row['doador'], ENT_QUOTES, 'UTF-8'); ?></td>
                                <td><?= htmlspecialchars($row['nome'], ENT_QUOTES, 'UTF-8'); ?></td>
                                <td><?= htmlspecialchars($row['raca'], ENT_QUOTES, 'UTF-8'); ?></td>
                                <td><?= htmlspecialchars($row['sexo'], ENT_QUOTES, 'UTF-8'); ?></td>
                                <td><?= $status; ?></td>
                                <td class="acoes">
                                    <button class="acoes">
                                        <a class="btnalterar" href="alterarPet.php?id=<?= $petId; ?>">Alterar</a>
                                    </button>
                                    <button class="acoes">
                                        <a class="btnexcluir" href="excluirPet.php?id=<?= $petId; ?>" onclick="return confirm('Deseja confirmar a operação?');">Excluir</a>
                                    </button>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php endif; ?>
                    <?php $dbh = null; ?>
                </tbody>
            </table>
        </section>
    </div>

    <script src="../../../js/script.js"></script>
</body>

</html>
