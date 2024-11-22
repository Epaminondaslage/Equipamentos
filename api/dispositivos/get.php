<?php
// Inclui o arquivo de configuração do banco de dados
// Este arquivo contém a classe Database responsável por conectar ao banco
require_once '../../config/database.php';

// Cria uma nova instância da classe Database
$database = new Database();

// Estabelece a conexão com o banco de dados
$db = $database->getConnection();

// Define a query SQL para buscar os dispositivos
// Usamos LIMIT 10 para limitar os resultados a 10 registros por página (paginação pode ser implementada)
$query = "SELECT * FROM dispositivos LIMIT 1000";

// Prepara a consulta SQL
$stmt = $db->prepare($query);

// Executa a consulta no banco de dados
$stmt->execute();

// Obtém os resultados da consulta como um array associativo
$dispositivos = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Converte os resultados para o formato JSON e exibe
// Isso permite que o frontend (via AJAX, por exemplo) consuma os dados facilmente
echo json_encode($dispositivos);

?>
