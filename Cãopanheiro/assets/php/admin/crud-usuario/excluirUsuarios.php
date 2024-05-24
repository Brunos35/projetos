<?php
session_start();
require __DIR__ . '/../conexao.php';
$dbh = Conexao::getConexao();

if (isset($_GET['Id'])) {
  $usuId = intval($_GET['Id']);

  # cria o comando DELETE filtrado pelo campo id
  $query = "UPDATE caopanheiro.usuarios SET status = 'inativo' where UsuarioId = :id";

  $stmt = $dbh->prepare($query);
  $stmt->bindParam(':id', $usuId);
  $result = $stmt->execute();

  if ($result) {
    echo "<script>window.alert('Usuario Inativado com sucesso')</script>";
    exit();
  } else {
    echo "<script>window.alert('Erro ao Inativar usuário')</script>";
  }

} else {
  // Se o ID do usuário não estiver presente na query string, redirecionar para uma página de erro ou tomar outra ação adequada
  echo "ID do usuário não fornecido!";
  exit();
}
$dbh = null;
