<?php
// Inclui o arquivo de configuração do banco de dados
// Este arquivo contém a classe Database responsável pela conexão ao banco
ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);
error_reporting(-1);



require_once '../../config/database.php';

// Cria uma nova instância da classe Database
$database = new Database();

// Estabelece a conexão com o banco de dados
$db = $database->getConnection();

// Recebe os dados enviados pelo cliente (frontend ou API)
// O conteúdo é capturado no formato JSON e convertido em um objeto PHP
$data = json_decode(file_get_contents("php://input"));

// Prepara a query SQL para inserir um novo dispositivo na tabela
$query = "INSERT INTO dispositivos (tipo_equipamento, nome_dispositivo, local_instalacao, ip, conexao_rede)
          VALUES (:tipo_equipamento, :nome_dispositivo, :local_instalacao, :ip, :conexao_rede)";

// Prepara a consulta SQL no banco
$stmt = $db->prepare($query);

// Associa os valores recebidos aos parâmetros da query, prevenindo SQL Injection
$stmt->bindParam(":tipo_equipamento", $data->tipo_equipamento);
$stmt->bindParam(":nome_dispositivo", $data->nome_dispositivo);
$stmt->bindParam(":local_instalacao", $data->local_instalacao);
$stmt->bindParam(":ip", $data->ip);
$stmt->bindParam(":conexao_rede", $data->conexao_rede);

// Executa a query e verifica se a inserção foi bem-sucedida
if ($stmt->execute()) {
    // Retorna uma mensagem de sucesso no formato JSON
    echo json_encode(["success" => true, "message" => "Dispositivo adicionado com sucesso!"]);
} else {
    // Retorna uma mensagem de erro no formato JSON
    echo json_encode(["success" => false, "message" => "Erro ao adicionar dispositivo."]);
}
?>
