# Equipamentos
crud equipamentos
```
projeto-crud/
├── api/
│   ├── dispositivos/
│   │   ├── get.php          # Endpoint para listar dispositivos (GET)
│   │   ├── post.php         # Endpoint para adicionar dispositivo (POST)
│   │   ├── put.php          # Endpoint para editar dispositivo (PUT)
│   │   ├── delete.php       # Endpoint para excluir dispositivo (DELETE)
├── assets/
│   ├── css/
│   │   └── styles.css       # Estilos CSS externos (responsivo e moderno)
│   ├── js/
│       ├── ajax.js          # JavaScript para AJAX e interatividade
│       └── script.js        # (Opcional) Scripts auxiliares, se necessário
├── backup/
│   └── backup_data.php      # Gera backup dos dados em formato CSV
├── config/
│   └── database.php         # Configuração da conexão ao banco de dados
├── public/
│   ├── index.php            # Página principal com lista e interações
│   ├── add_device.php       # (Opcional) Página de adição, se não for via modal
│   ├── edit_device.php      # (Opcional) Página de edição, se não for via modal
│   └── delete_device.php    # (Opcional) Página de exclusão, se não for via modal
├── sql/
│   └── create_table.sql     # Script SQL para criação do banco de dados e tabelas
├── .gitignore               # Arquivo para ignorar configurações e logs
├── README.md                # Documentação do projeto
```
