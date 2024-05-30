-- Criar o banco de dados
CREATE DATABASE IF NOT EXISTS Caopanheiro;

-- Selecionar o banco de dados
USE Caopanheiro;

-- Tabela para armazenar informações sobre os adotantes
CREATE TABLE IF NOT EXISTS Usuarios (
    UsuarioID INT AUTO_INCREMENT PRIMARY KEY,
    Nome VARCHAR(50),
    Sobrenome VARCHAR(50),
    DataNascimento DATE,
    CPF VARCHAR(14) UNIQUE,
    Endereco VARCHAR(100),
    Email VARCHAR(100),
    Telefone VARCHAR(20),
    Senha VARCHAR(200), -- A senha é armazenada em bcrypt
    perfil ENUM('adotante', 'doador', 'administrador'),
    status ENUM('ativo', 'inativo')
);

-- Tabela para armazenar informações sobre os pets
CREATE TABLE IF NOT EXISTS pets (
    petID INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(50),
    dataNascimento DATE,
    foto VARCHAR(255), -- Caminho para a foto do pet
    raca VARCHAR(50),
    porte ENUM('Pequeno', 'Médio', 'Grande'),
    sexo ENUM('Macho', 'Fêmea'),
    descricao TEXT,
    status ENUM('disponivel', 'adotado')
);

-- Tabela para relacionar adotantes e pets (muitos para muitos)
CREATE TABLE IF NOT EXISTS Adocoes (
    UsuarioID INT,
    petID INT,
    dataAdocao DATE,
    PRIMARY KEY (UsuarioID, petID),
    FOREIGN KEY (UsuarioID) REFERENCES Usuarios(UsuarioID),
    FOREIGN KEY (petID) REFERENCES pets(petID)
);

-- Tabela para armazenar informações sobre as conversas de chat
CREATE TABLE IF NOT EXISTS Chats (
    ChatID INT NOT NULL AUTO_INCREMENT,
    Doador INT NOT NULL,
    Adotante INT NOT NULL,
    PRIMARY KEY (ChatID),
    INDEX (Doador),
    INDEX (Adotante),
    FOREIGN KEY (Doador) REFERENCES Usuarios(UsuarioID)
        ON DELETE NO ACTION ON UPDATE NO ACTION,
    FOREIGN KEY (Adotante) REFERENCES Usuarios(UsuarioID)
        ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE = InnoDB;

-- Tabela para armazenar mensagens
CREATE TABLE IF NOT EXISTS Mensagens (
    MensagemID INT NOT NULL AUTO_INCREMENT,
    ChatID INT NOT NULL,
    Remetente INT NOT NULL,
    Conteudo VARCHAR(255) NOT NULL,
    DataEnvio DATETIME NOT NULL,
    PRIMARY KEY (MensagemID),
    INDEX (ChatID),
    INDEX (Remetente),
    FOREIGN KEY (ChatID) REFERENCES Chats(ChatID)
        ON DELETE NO ACTION ON UPDATE NO ACTION,
    FOREIGN KEY (Remetente) REFERENCES Usuarios(UsuarioID)
        ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE = InnoDB;

-- Tabela para armazenar informações sobre os administradores
CREATE TABLE IF NOT EXISTS Administradores (
    AdminID INT AUTO_INCREMENT PRIMARY KEY,
    Nome VARCHAR(50),
    Sobrenome VARCHAR(50),
    Email VARCHAR(100),
    Senha VARCHAR(200), -- A senha é armazenada em bcrypt
    Perfil ENUM('adotante', 'doador', 'administrador'),
    Status ENUM('ativo', 'inativo')
);
