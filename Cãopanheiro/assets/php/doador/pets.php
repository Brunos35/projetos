<?php 
session_start();

require_once "../conexao.php";


# solicita a conexão com o banco de dados e guarda na váriavel dbh.
$dbh = Conexao::getConexao();

# cria uma instrução SQL para selecionar todos os dados na tabela usuarios.
$query = "SELECT * FROM caopanheiro.pet where doador = :doador"; 

# prepara a execução da query e retorna para uma variável chamada stmt.
$stmt = $dbh->query($query);
$stmt->bindParam(':doador', $_SESSION['usuId']);
$result= $stmt->execute();
var_dump($result);

# devolve a quantidade de linhas retornada pela consulta a tabela.
$quantidadeRegistros = $stmt->rowCount();

# busca todos os dados da tabela usuário.
// $usuarios = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Área Restrita</title>
    <link rel="stylesheet" href="../../css/usuario.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
</head>
<body>
        <header>
            <button class="nav-toggle"><span class="material-symbols-outlined">
                menu
                </span></button>
            <figure class="logo"><img src="../../img/logo1.png" alt=""></figure>
            <div class="user-info">Bem-vindo, <?= $_SESSION['nome'];?> <span id="username"></span></div>
        </header>
        <nav>
            <ul>
                <li><a href="pets.php">Meus Pet</a></li>
                <li><a href="alterarDoador.php">Meu Perfil</a></li>
                <li><a href="#">Conversas</a></li>
                <li><a href="../../index.html">Página Inicial</a></li>
            </ul>
        </nav>
        <div class="content" id="conteudo">
            <h1>Meus Pets</h1>
            <section class="section__btn">
            <a class="btn" href="new.php">Novo</a>
        </section>

        <hr>

        <section>
            <table >
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nome</th>
                        <th>E-mail</th>
                        <th>Status</th>
                        <th>Ação</th>
                    </tr>
                </thead>

                <tbody>
                    <?php if ($quantidadeRegistros == "0"): ?>
                        <tr>
                            <td colspan="4">Não existem usuários cadastrados.</td>
                        </tr>
                    <?php else: ?>
                        <?php while($row = $stmt->fetch(PDO::FETCH_BOTH)): ?>
                        <tr>
                            <?php $status =  $row['status'] =="1"? "ATIVO" : "INATIVO"; ?>
                            <td><?php echo $row['UsuarioID'];?></td>
                            <td><?= $row['Nome'];?></td>
                            <td><?= $row['Email'];?></td>
                            <td><?= $status;?></td>
                            <td class="td__operacao">
                                <a class="btnalterar" href="alterarDoador.php?id=<?=$row['id'];?>">Alterar</a>
                                <a class="btnexcluir" href="excluirDoador.php?id=<?=$row['id'];?>" onclick="return confirm('Deseja confirmar a operação?');">Excluir</a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    <?php endif; $dbh = null; ?>
                </tbody>
            </table>
        </section>
            <a href="cadastrarPets.php">Novo Pet</a>
        </div>

    <script src="../../js/script.js">
        
    </script>
</body>
</html>
