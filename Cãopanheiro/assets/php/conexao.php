<?php
    header('Content-Type: text/html; charset=utf-8;');
    
    class Conexao
    {
        public static function getConexao()
        {
            try {
                return new PDO("mysql:host=localhost;dbname=caopanheiro;", "root", "Root123@");
            } catch(Exception $e) {
                echo 'Erro ao conectar com o banco de dados . ' . $e->getMessage();
            }
        }
    }
