<?php
// Inclui o arquivo de configuração do banco de dados
require_once '../../config/database.php';

// Cria uma nova instância da classe Database
$database = new Database();

// Estabelece a conexão com o banco de dados
$db = $database->getConnection();

// Verifica se o parâmetro 'id' foi passado na URL
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    // Sanitiza o ID recebido para evitar injeção de SQL
    $id = intval($_GET['id']);

    // Define a query SQL para buscar o dispositivo pelo ID informado
    $query = "SELECT * FROM dispositivos WHERE id = :id";

    // Prepara a consulta SQL
    $stmt = $db->prepare($query);

    // Associa o valor do ID ao parâmetro :id na consulta
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);

    // Executa a consulta no banco de dados
    $stmt->execute();

    // Obtém o resultado da consulta
    $dispositivo = $stmt->fetch(PDO::FETCH_ASSOC);

    // Verifica se um dispositivo foi encontrado
    if ($dispositivo) {
        // Converte o resultado para o formato JSON e exibe
        echo json_encode($dispositivo);
    } else {
        // Retorna uma mensagem de erro caso o dispositivo não seja encontrado
        echo json_encode(['error' => 'Dispositivo não encontrado.']);
    }
} else {
    // Caso o parâmetro 'id' não seja enviado, retorna os primeiros 1000 dispositivos
    $query = "SELECT * FROM dispositivos LIMIT 1000";

    // Prepara a consulta SQL
    $stmt = $db->prepare($query);

    // Executa a consulta no banco de dados
    $stmt->execute();

    // Obtém os resultados da consulta como um array associativo
    $dispositivos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Converte os resultados para o formato JSON e exibe
    echo json_encode($dispositivos);
}
?>
