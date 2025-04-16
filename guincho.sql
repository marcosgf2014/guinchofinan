-- Banco de dados para Gerenciador Financeiro de Guincho
CREATE DATABASE IF NOT EXISTS guincho;
USE guincho;

-- Tabela de clientes
CREATE TABLE IF NOT EXISTS clientes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    cpf_cnpj VARCHAR(25),
    telefone VARCHAR(30),
    email VARCHAR(100),
    endereco VARCHAR(200)
);

-- Tabela de veículos
CREATE TABLE IF NOT EXISTS veiculos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    cliente_id INT NOT NULL,
    placa VARCHAR(20) NOT NULL,
    modelo VARCHAR(50),
    cor VARCHAR(30),
    FOREIGN KEY (cliente_id) REFERENCES clientes(id) ON DELETE CASCADE
);

-- Tabela de lançamentos financeiros
CREATE TABLE IF NOT EXISTS financeiro (
    id INT AUTO_INCREMENT PRIMARY KEY,
    cliente_id INT,
    veiculo_id INT,
    data DATE NOT NULL,
    valor DECIMAL(10,2) NOT NULL,
    descricao VARCHAR(255),
    tipo ENUM('entrada','saida') NOT NULL,
    FOREIGN KEY (cliente_id) REFERENCES clientes(id) ON DELETE SET NULL,
    FOREIGN KEY (veiculo_id) REFERENCES veiculos(id) ON DELETE SET NULL
);
