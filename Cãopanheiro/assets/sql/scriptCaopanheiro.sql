-- Criar o banco de dados
CREATE DATABASE IF NOT EXISTS Caopanheiro;

-- Selecionar o banco de dados
USE Caopanheiro;

-- Tabela para armazenar informações sobre os adotantes
CREATE TABLE Adotante (
    AdotanteID INT AUTO_INCREMENT PRIMARY KEY,
    Nome VARCHAR(50),
    Sobrenome VARCHAR(50),
    DataNascimento DATE,
    CPF VARCHAR(14) UNIQUE,
    Endereco VARCHAR(100),
    Email VARCHAR(100),
    NumeroWhatsapp VARCHAR(20),
    Senha VARCHAR(100) -- A senha deve ser armazenada com segurança, preferencialmente com hash
);

-- Tabela para armazenar informações sobre os doadores
CREATE TABLE Doador (
    DoadorID INT AUTO_INCREMENT PRIMARY KEY,
    Nome VARCHAR(50),
    Sobrenome VARCHAR(50),
    DataNascimento DATE,
    CPF VARCHAR(14) UNIQUE,
    Endereco VARCHAR(100),
    Email VARCHAR(100),
    NumeroWhatsapp VARCHAR(20),
    Senha VARCHAR(100) -- A senha deve ser armazenada com segurança, preferencialmente com hash
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
    Descricao TEXT
);

-- Tabela para relacionar adotantes e pets (muitos para muitos)
CREATE TABLE Adocao (
    AdotanteID INT,
    PetID INT,
    DataAdocao DATE,
    PRIMARY KEY (AdotanteID, PetID),
    FOREIGN KEY (AdotanteID) REFERENCES Adotante(AdotanteID),
    FOREIGN KEY (PetID) REFERENCES Pet(PetID)
);

-- Tabela para relacionar doadores e pets (um para muitos)
CREATE TABLE Doacao (
    DoadorID INT,
    PetID INT,
    DataDoacao DATE,
    PRIMARY KEY (DoadorID, PetID),
    FOREIGN KEY (DoadorID) REFERENCES Doador(DoadorID),
    FOREIGN KEY (PetID) REFERENCES Pet(PetID)
);

-- Tabela para armazenar informações sobre as conversas de chat
CREATE TABLE Chat (
    ChatID INT AUTO_INCREMENT PRIMARY KEY,
    Remetente INT,
    Destinatario INT,
    Conteudo TEXT,
    DataHora TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (Remetente) REFERENCES Adotante(AdotanteID),
    FOREIGN KEY (Destinatario) REFERENCES Adotante(AdotanteID)
);
