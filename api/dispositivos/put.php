<?php
// Inclui o arquivo de configuração do banco de dados
// Este arquivo contém a classe Database responsável pela conexão ao banco
require_once '../../config/database.php';

// Cria uma nova instância da classe Database
$database = new Database();

// Estabelece a conexão com o banco de dados
$db = $database->getConnection();

// Recebe os dados enviados pelo cliente (frontend ou API)
// O conteúdo é capturado no formato JSON e convertido em um objeto PHP
$data = json_decode(file_get_contents("php://input"));

// Função para validar o endereço IP
function isValidIP($ip) {
    return filter_var($ip, FILTER_VALIDATE_IP) !== false;
}

// Verifica se o IP fornecido é válido
if (!isValidIP($data->ip)) {
    // Retorna uma mensagem de erro no formato JSON se o IP for inválido
    echo json_encode(["success" => false, "message" => "IP inválido!"]);
    exit;
}

// Prepara a query SQL para atualizar o dispositivo na tabela
$query = "UPDATE dispositivos 
          SET tipo_equipamento = :tipo_equipamento, 
              nome_dispositivo = :nome_dispositivo,
              local_instalacao = :local_instalacao,
              observacao = :observacao,
              ip = :ip,
              conexao_rede = :conexao_rede
          WHERE id = :id";

// Prepara a consulta SQL no banco
$stmt = $db->prepare($query);

// Associa os valores recebidos aos parâmetros da query, prevenindo SQL Injection
$stmt->bindParam(":id", $data->id, PDO::PARAM_INT);
$stmt->bindParam(":tipo_equipamento", $data->tipo_equipamento);
$stmt->bindParam(":nome_dispositivo", $data->nome_dispositivo);
$stmt->bindParam(":local_instalacao", $data->local_instalacao);
$stmt->bindParam(":observacao", $data->observacao);
$stmt->bindParam(":ip", $data->ip);
$stmt->bindParam(":conexao_rede", $data->conexao_rede);

// Executa a query e verifica se a atualização foi bem-sucedida
if ($stmt->execute()) {
    // Retorna uma mensagem de sucesso no formato JSON
    echo json_encode(["success" => true, "message" => "Dispositivo atualizado com sucesso!"]);
} else {
    // Retorna uma mensagem de erro no formato JSON
    echo json_encode(["success" => false, "message" => "Erro ao atualizar dispositivo."]);
}
?>
