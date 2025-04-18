CREATE DATABASE IF NOT EXISTS guincho;
USE guincho;

CREATE TABLE IF NOT EXISTS checklist (
    id INT AUTO_INCREMENT PRIMARY KEY,
    cliente VARCHAR(100) NOT NULL,
    origem VARCHAR(100),
    destino VARCHAR(100),
    veiculo VARCHAR(100) NOT NULL,
    data_entrada DATETIME NOT NULL,
    quilometragem INT,
    nivel_combustivel VARCHAR(10),
    danos_externos BOOLEAN,
    pertences TEXT,
    observacoes TEXT,

    pneus_dianteiros VARCHAR(20),
    pneus_traseiros VARCHAR(20),
    rodas_dianteiras VARCHAR(20),
    rodas_traseiras VARCHAR(20),

    calotas BOOLEAN,
    retrovisores BOOLEAN,
    palhetas BOOLEAN,
    triangulo BOOLEAN,
    macaco_chave BOOLEAN,
    estepe BOOLEAN,

    bancos BOOLEAN,
    painel BOOLEAN,
    consoles BOOLEAN,
    forracao BOOLEAN,
    tapetes BOOLEAN,

    bateria BOOLEAN,
    chaves BOOLEAN,
    documentos BOOLEAN,
    som BOOLEAN,
    caixa_selada BOOLEAN,

    fotos TEXT,
    assinatura_cliente VARCHAR(255),
    assinatura_responsavel VARCHAR(255)
);
