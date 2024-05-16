-- Criar o banco de dados
CREATE DATABASE IF NOT EXISTS Caopanheiro;

-- Selecionar o banco de dados
USE Caopanheiro;

-- Tabela para armazenar informações sobre os adotantes
CREATE table usuarios(
    UsuarioID INT AUTO_INCREMENT PRIMARY KEY,
    Nome VARCHAR(50),
    Sobrenome VARCHAR(50),
    DataNascimento DATE,
    CPF VARCHAR(14) UNIQUE,
    Endereco VARCHAR(100),
    Email VARCHAR(100),
    Telefone VARCHAR(20),
    Senha VARCHAR(100), -- A senha é armazenado em md5
    Perfil enum('adotante','doador','administrador'),
    status enum('ativo','inativo')
);

-- Tabela para armazenar informações sobre os pets
CREATE TABLE Pet (
    PetID INT AUTO_INCREMENT PRIMARY KEY,
    Nome VARCHAR(50),
    DataNascimento DATE,
    Foto VARCHAR(255), -- Caminho para a foto do pet
    Raca VARCHAR(50),
    Porte ENUM('Pequeno', 'Médio', 'Grande'),
    Sexo ENUM('Macho', 'Fêmea'),
    Descricao TEXT,
    status enum('disponivel','adotado'),
);

-- Tabela para relacionar adotantes e pets (muitos para muitos)
CREATE TABLE Adocao (
    UsuarioID INT,
    PetID INT,
    DataAdocao DATE,
    PRIMARY KEY (UsuarioID, PetID),
    FOREIGN KEY (UsuarioID) REFERENCES Usuarios(UsuarioID),
    FOREIGN KEY (PetID) REFERENCES Pet(PetID)
);

-- Tabela para armazenar informações sobre as conversas de chat
CREATE TABLE Chat (
    ChatID INT AUTO_INCREMENT PRIMARY KEY,
    Remetente INT,
    Destinatario INT,
    Conteudo TEXT,
    DataHora TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (Remetente) REFERENCES Usuarios(UsuarioID)
);


