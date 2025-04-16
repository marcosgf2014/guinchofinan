<?php
// Script para criar a tabela 'veiculos' automaticamente no banco 'guincho'
$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'guincho';

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die('Erro na conexão: ' . $conn->connect_error);
}
$sql = "CREATE TABLE IF NOT EXISTS veiculos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    cliente_id INT NOT NULL,
    tipo_veiculo VARCHAR(50) NOT NULL,
    placa VARCHAR(12) NOT NULL,
    modelo VARCHAR(50),
    ano INT,
    cor VARCHAR(30),
    status VARCHAR(20),
    valor_servico DECIMAL(10,2),
    data_entrada DATE,
    hora_entrada TIME,
    data_saida DATE,
    hora_saida TIME,
    origem VARCHAR(100),
    destino VARCHAR(100),
    obs TEXT,
    FOREIGN KEY (cliente_id) REFERENCES clientes(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";
if ($conn->query($sql) === TRUE) {
    echo "Tabela 'veiculos' criada com sucesso!";
} else {
    echo "Erro ao criar tabela: " . $conn->error;
}
$conn->close();
