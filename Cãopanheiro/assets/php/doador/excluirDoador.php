<?php
    session_start();
    require __DIR__ . '/../conexao.php';
    $dbh = Conexao::getConexao();

    # cria o comando DELETE filtrado pelo campo id
    $query = "DELETE FROM usuarios WHERE UsuarioID = :id;";

    $stmt = $dbh->prepare($query);
    $stmt->bindParam(':id', $_SESSION['usuID']);
    $stmt->execute();

    if ($stmt->rowCount() == 1)
    {
        header('location: ../../index.html');
        exit;
    } else {
        echo "<script>window.('Não existe usuário cadastrado')</script>";
        echo "<script>window.location.href=doador_dashboard.php</script>";
    }
    $dbh = null;
    session_destroy();