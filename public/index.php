<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sitio Pé de Serra - Gestão de Dispositivos de Rede</title>
    <!-- Estilo personalizado -->
    <link href="/Equipamentos/assets/css/styles.css" rel="stylesheet">
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Arquivo JavaScript para interações -->
    <script src="/Equipamentos/assets/js/ajax.js" defer></script>
</head>
<body>
    <div class="container mt-4">
        <img class= "center-image" src="../img/equipamento.jpg" alt="Ativos de rede">
        <h1 class="text-center mb-4">Gestão de Ativos de Rede </h1>

        <!-- Botão para abrir o modal de adicionar dispositivo -->
        <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addModal">Adicionar Dispositivo</button>

        <div id="alertContainer"></div>
        <!-- Tabela para exibir os dispositivos -->
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
                <!-- Conteúdo carregado dinamicamente via JavaScript -->
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
                    <!-- Formulário para adicionar dispositivo -->
                    <form id="addDeviceForm">
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
                        <div class="mb-3">
                            <label for="nome" class="form-label">Nome do Dispositivo</label>
                            <input type="text" id="nome" name="nome_dispositivo" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="local" class="form-label">Local de Instalação</label>
                            <select id="local" name="local_instalacao" class="form-control" required>
                                <option value="">Selecione</option>
                                <option value="cozinha">Cozinha</option>
                                <option value="salao">Salão</option>
                                <option value="chale">Chalé</option>
                                <option value="container">Container</option>
                                <option value="garagem">Garagem</option>
                                <option value="casa caseiro">Casa caseiro</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="ip" class="form-label">Endereço IP</label>
                            <input type="text" name="ip" id="ip" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="conexao" class="form-label">Conexão à Rede</label>
                            <select id="conexao" name="conexao_rede" class="form-control" required>
                                <option value="">Selecione</option>
                                <option value="DHCP">DHCP</option>
                                <option value="IP fixo">IP Fixo</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Salvar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Scripts Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- Modal para edição de dispositivos -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="editForm" onsubmit="return editDevice(this)">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Editar Dispositivo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                    <input type="hidden" id="edit_id" name="id">
                    <div class="mb-3">
                        <label for="edit_nome" class="form-label">Nome</label>
                        <input type="text" id="edit_nome" class="form-control" name="nome_dispositivo" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_tipo" class="form-label">Tipo de Equipamento</label>
                        <select id="edit_tipo" name="tipo_equipamento" class="form-control" required>
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
                    <div class="mb-3">
                        <label for="edit_local" class="form-label">Local de Instalação</label>
                        <select id="edit_local" name="local_instalacao" class="form-control" required>
                            <option value="">Selecione</option>
                            <option value="cozinha">Cozinha</option>
                            <option value="salão">Salão</option>
                            <option value="chale">Chalé</option>
                            <option value="container">Container</option>
                            <option value="garagem">Garagem</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="edit_ip" class="form-label">IP</label>
                        <input type="text" id="edit_ip" class="form-control" name="ip" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_conexao" class="form-label">Conexão à Rede</label>
                        <select id="edit_conexao" name="conexao_rede" class="form-control" required>
                            <option value="">Selecione</option>
                            <option value="DHCP">DHCP</option>
                            <option value="IP fixo">IP Fixo</option>
                        </select>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-primary">Salvar</button>
            </div>
        </form>
        </div>
    </div>
</div>

</body>
</html>
