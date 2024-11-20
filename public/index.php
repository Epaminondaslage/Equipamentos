<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD - Dispositivos</title>

    <!-- CSS personalizado -->
    <link href="../assets/css/styles.css" rel="stylesheet">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Script para funcionalidades AJAX -->
    <script src="../assets/js/ajax.js" defer></script>
</head>
<body>
    <div class="container mt-4">
        <h1 class="text-center mb-4">Gestão de Dispositivos</h1>

        <!-- Botão para abrir o modal de adicionar dispositivo -->
        <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addModal">Adicionar Dispositivo</button>

        <!-- Tabela para exibir dispositivos -->
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tipo</th>
                    <th>Nome</th>
                    <th>Local</th>
                    <th>IP</th>
                    <th>Conexão</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody id="deviceTable">
                <!-- Conteúdo da tabela será preenchido via AJAX -->
            </tbody>
        </table>
    </div>

    <!-- Modal para adicionar dispositivo -->
    <div class="modal fade" id="addModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Adicionar Dispositivo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addDeviceForm">
                        <!-- Campo Tipo de Equipamento -->
                        <div class="mb-3">
                            <label for="tipo" class="form-label">Tipo de Equipamento</label>
                            <select id="tipo" name="tipo_equipamento" class="form-control" required>
                                <option value="">Selecione</option>
                                <option value="camera">Câmera</option>
                                <option value="roteador">Roteador</option>
                                <option value="access point">Access Point</option>
                                <option value="rele ip">Relé IP</option>
                                <option value="interruptor ip">Interruptor IP</option>
                                <option value="tomada ip">Tomada IP</option>
                                <option value="camera IP">Câmera IP</option>
                                <option value="DVR">DVR</option>
                                <option value="NVR">NVR</option>
                                <option value="computador">Computador</option>
                                <option value="inversor de frequencia">Inversor de Frequência</option>
                            </select>
                        </div>
                        <!-- Campo Nome do Dispositivo -->
                        <div class="mb-3">
                            <label for="nome" class="form-label">Nome do Dispositivo</label>
                            <input type="text" id="nome" name="nome_dispositivo" class="form-control" required>
                        </div>
                        <!-- Campo Local de Instalação -->
                        <div class="mb-3">
                            <label for="local" class="form-label">Local de Instalação</label>
                            <select id="local" name="local_instalacao" class="form-control" required>
                                <option value="">Selecione</option>
                                <option value="cozinha">Cozinha</option>
                                <option value="salão">Salão</option>
                                <option value="chale">Chalé</option>
                                <option value="container">Container</option>
                                <option value="garagem">Garagem</option>
                            </select>
                        </div>
                        <!-- Campo Observação -->
                        <div class="mb-3">
                            <label for="observacao" class="form-label">Observação</label>
                            <textarea id="observacao" name="observacao" class="form-control"></textarea>
                        </div>
                        <!-- Campo IP -->
                        <div class="mb-3">
                            <label for="ip" class="form-label">IP</label>
                            <input type="text" id="ip" name="ip" class="form-control" required
                                pattern="^((25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)(\.|$)){4}$"
                                title="Digite um IP válido (ex: 192.168.0.1)">
                        </div>
                        <!-- Campo Conexão à Rede -->
                        <div class="mb-3">
                            <label for="conexao" class="form-label">Conexão à Rede</label>
                            <select id="conexao" name="conexao_rede" class="form-control" required>
                                <option value="">Selecione</option>
                                <option value="DHCP">DHCP</option>
                                <option value="IP fixo">IP Fixo</option>
                            </select>
                        </div>
                        <!-- Botão para salvar -->
                        <button type="submit" class="btn btn-primary">Salvar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
