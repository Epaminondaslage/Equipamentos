<?php
// Inclui o arquivo de configuração do banco de dados
// Este arquivo contém a classe Database responsável pela conexão ao banco
require_once '../../config/database.php';

// Cria uma nova instância da classe Database
$database = new Database();

// Estabelece a conexão com o banco de dados
$db = $database->getConnection();

// Obtém o ID do dispositivo enviado como parâmetro na URL
// Por exemplo: delete.php?id=1
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Verifica se o ID é válido
if ($id <= 0) {
    // Retorna uma mensagem de erro no formato JSON se o ID for inválido
    echo json_encode(["success" => false, "message" => "ID inválido ou não fornecido."]);
    exit;
}

// Prepara a query SQL para excluir o dispositivo com base no ID
$query = "DELETE FROM dispositivos WHERE id = :id";

// Prepara a consulta SQL no banco
$stmt = $db->prepare($query);

// Associa o valor do ID ao parâmetro da query, prevenindo SQL Injection
$stmt->bindParam(":id", $id, PDO::PARAM_INT);

// Executa a query e verifica se a exclusão foi bem-sucedida
if ($stmt->execute()) {
    // Verifica se alguma linha foi afetada (ou seja, se o ID existia)
    if ($stmt->rowCount() > 0) {
        // Retorna uma mensagem de sucesso no formato JSON
        echo json_encode(["success" => true, "message" => "Dispositivo excluído com sucesso!"]);
    } else {
        // Retorna uma mensagem de erro se o ID não foi encontrado
        echo json_encode(["success" => false, "message" => "Dispositivo não encontrado."]);
    }
} else {
    // Retorna uma mensagem de erro se a exclusão falhar
    echo json_encode(["success" => false, "message" => "Erro ao excluir dispositivo."]);
}
?>
