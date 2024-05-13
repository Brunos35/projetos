<?php
    header('Content-Type: text/html; charset=utf-8;');
    ini_set("include_path" ,"\C:\Users\bruno\OneDrive\Documentos\EstudoProgramação\projetos\Cãopanheiro\assets\php");
    
    class Conexao
    {
        public static function getConexao()
        {
            try {
                return new PDO("mysql:host=localhost;dbname=caopanheiro;", "root", "");
                
            } catch(Exception $e) {
                echo 'Erro ao conectar com o banco de dados . ' . $e->getMessage();
            }
        }
    }
