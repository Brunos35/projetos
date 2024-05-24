<?php
session_start();

require __DIR__ . '/../conexao.php';

try {
    $dbh = Conexao::getConexao();

    $query = "SELECT * FROM caopanheiro.usuarios";
    $stmt = $dbh->prepare($query);
    $stmt->execute();

    $quantidadeRegistros = $stmt->rowCount();
} catch (PDOException $e) {
    echo "Erro na conexão: " . $e->getMessage();
    die();
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Área Restrita</title>
    <link rel="stylesheet" href="../../css/dashboards.css">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
</head>

<body>
    <header>
        <button class="nav-toggle"><span class="material-symbols-outlined">menu</span></button>
        <figure class="logo"><img src="../../img/logo1.png" alt=""></figure>
        <div class="user-info">Bem-vindo,
            <?= htmlspecialchars($_SESSION['nome'], ENT_QUOTES, 'UTF-8'); ?> <span id="username"></span>
        </div>
    </header>
    <nav>
    <ul>
      <li><a href="../crud-pet/pets.php">Pets cadastrados</a></li>
      <li><a href="listaUsuarios.php">Usuários cadastrados</a></li>
      <li><a href="../administrador_dashboard.php">Meu Perfil</a></li>
      <li><a href="../listaAdmin.php">Administradores</a></li>
      <li><a href="#">Conversas</a></li>
      <li><a href="../../logout.php">Sair</a></li>
    </ul>
  </nav>
    <main>
        <div class="content" id="conteudo">
            <h1>Usuários cadastrados</h1>
            <hr>
            <section>
                <table id="pet">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th id="nome">Nome</th>
                            <th id="raca">Sobrenome</th>
                            <th>Data de Nascimento</th>
                            <th>Endereço</th>
                            <th>Email</th>
                            <th>Perfil</th>
                            <th>Status</th>
                            <th colspan="2" class="acoes">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($quantidadeRegistros == 0): ?>
                            <tr>
                                <td colspan="9">Não existem usuários cadastrados.</td>
                            </tr>
                        <?php else: ?>
                            <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
                                <tr>
                                    <td>
                                        <?= $usuId = intval($row['UsuarioID']); ?>
                                    </td>
                                    <td>
                                        <?= htmlspecialchars($row['Nome'], ENT_QUOTES, 'UTF-8'); ?>
                                    </td>
                                    <td>
                                        <?= htmlspecialchars($row['Sobrenome'], ENT_QUOTES, 'UTF-8'); ?>
                                    </td>
                                    <td>
                                        <?= htmlspecialchars($row['DataNascimento'], ENT_QUOTES, 'UTF-8'); ?>
                                    </td>
                                    <td>
                                        <?= htmlspecialchars($row['Endereco'], ENT_QUOTES, 'UTF-8'); ?>
                                    </td>
                                    <td>
                                        <?= htmlspecialchars($row['Email'], ENT_QUOTES, 'UTF-8'); ?>
                                    </td>
                                    <td>
                                        <?= htmlspecialchars($row['Perfil'], ENT_QUOTES, 'UTF-8'); ?>
                                    </td>
                                    <td>
                                        <?= ($row['status'] == 'ativo') ? 'ATIVO' : 'INATIVO'; ?>
                                    </td>
                                    <td class="acoes">
                                        <button class="acoes"><a class="btnalterar"
                                                href="alterarUsuarios.php?Id=<?= $usuId; ?>">Alterar</a></button>
                                        <?php
                                        if ($row['status'] == 'ativo') {
                                            echo "<button class='acoes'><a class='btnexcluir' href='excluirUsuarios.php?Id=$usuId' onclick='return confirm(\"Deseja confirmar a operação?\");'>Excluir</a></button>";
                                        } else {
                                            echo "<button class='acoes'><a class='btnexcluir' href='reativarUsuarios.php?Id=$usuId' onclick='return confirm(\"Deseja confirmar a operação?\");'>Reativar</a></button>";
                                        }
                                        ?>


                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php endif; ?>
                        <?php $dbh = null; ?>
                    </tbody>
                </table>
            </section>

        </div>
    </main>
    <script src="../../js/script.js"></script>
</body>

</html>