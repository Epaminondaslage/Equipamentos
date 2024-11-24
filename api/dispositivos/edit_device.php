<?php
require_once '/Equipamentos/config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $database = new Database();
    $db = $database->getConnection();

    $id = $_POST['id'] ?? null;
    $tipo = $_POST['tipo_equipamento'] ?? null;
    $nome = $_POST['nome_dispositivo'] ?? null;
    $local = $_POST['local_instalacao'] ?? null;
    $ip = $_POST['ip'] ?? null;
    $conexao = $_POST['conexao_rede'] ?? null;


    $query = "UPDATE dispositivos 
              SET tipo_equipamento = :tipo, nome_dispositivo = :nome, local_instalacao = :local,
                   ip = :ip, conexao_rede = :conexao
              WHERE id = :id";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':tipo', $tipo);
    $stmt->bindParam(':nome', $nome);
    $stmt->bindParam(':local', $local);
    $stmt->bindParam(':ip', $ip);
    $stmt->bindParam(':conexao', $conexao);
    $stmt->bindParam(':id', $id);

    if ($stmt->execute()) {
        echo "Dispositivo atualizado com sucesso!";
    } else {
        echo "Erro ao atualizar o dispositivo.";
    }
}
?>
