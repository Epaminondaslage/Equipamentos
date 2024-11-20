CREATE DATABASE IF NOT EXISTS equipamentos_db;
USE equipamentos_db;

CREATE TABLE dispositivos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    tipo_equipamento ENUM('camera', 'roteador', 'access point', 'rele ip', 'interruptor ip', 'tomada ip', 'camera IP', 'DVR', 'NVR', 'computador', 'inversor de frequencia') NOT NULL,
    nome_dispositivo VARCHAR(255) NOT NULL,
    local_instalacao ENUM('cozinha', 'salão', 'chale', 'container', 'garagem') NOT NULL,
    observacao TEXT,
    ip VARCHAR(15) UNIQUE NOT NULL,
    conexao_rede ENUM('DHCP', 'IP fixo') NOT NULL
);
