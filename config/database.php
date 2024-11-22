<?php
// Define a classe Database para gerenciar a conexão ao banco de dados
class Database {
    // Configurações do banco de dados
    private $host = "127.0.0.1"; // Endereço do servidor do banco
    private $db_name = "sitio_pds"; // Nome do banco de dados
    private $username = "epaminondas"; // Nome de usuário para conexão
    private $password = "Ep@m1n0nd@s"; // Senha para conexão
    public $conn; // Variável que armazenará a conexão ativa

    /**
     * Método para obter a conexão com o banco de dados.
     * 
     * @return PDO|null Retorna a conexão ativa ou null em caso de erro.
     */
    public function getConnection() {
        $this->conn = null; // Inicializa a variável de conexão como null

        try {
            // Cria uma nova conexão PDO
            $this->conn = new PDO(
                "mysql:host=" . $this->host . ";dbname=" . $this->db_name,
                $this->username,
                $this->password
            );

            // Configura o PDO para exibir erros de exceção
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $exception) {
            // Exibe uma mensagem de erro caso a conexão falhe
            echo "Erro de conexão: " . $exception->getMessage();
        }

        // Retorna a conexão ativa (ou null em caso de erro)
        return $this->conn;
    }
}
?>
