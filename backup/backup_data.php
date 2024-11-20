<?php
// Inclui o arquivo de configuração do banco de dados
// Este arquivo contém a classe Database para conexão ao banco
require_once '../config/database.php';

// Cria uma instância da classe Database
$database = new Database();

// Estabelece a conexão com o banco de dados
$db = $database->getConnection();

// Define os cabeçalhos para download do arquivo CSV
header('Content-Type: text/csv');
header('Content-Disposition: attachment;filename=backup_dispositivos.csv');

// Abre um fluxo de saída para escrever o arquivo CSV
$output = fopen("php://output", "w");

// Escreve a linha de cabeçalho no arquivo CSV
fputcsv($output, ["ID", "Tipo de Equipamento", "Nome", "Local de Instalação", "Observação", "IP", "Conexão"]);

// Prepara a query SQL para buscar todos os dispositivos
$query = "SELECT * FROM dispositivos";
$stmt = $db->prepare($query);

// Executa a consulta no banco
$stmt->execute();

// Escreve cada linha de resultado no arquivo CSV
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    fputcsv($output, $row);
}

// Fecha o fluxo de saída
fclose($output);

// Finaliza o script
exit;
?>
