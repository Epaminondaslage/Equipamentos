// Aguarda o carregamento completo do DOM para garantir que todos os elementos estejam disponíveis
document.addEventListener("DOMContentLoaded", function () {
    // Carrega os dispositivos quando a página é aberta
    loadDevices();

    // Adiciona um evento ao formulário de adicionar dispositivo
    const addDeviceForm = document.getElementById("addDeviceForm");
    addDeviceForm.addEventListener("submit", function (e) {
        e.preventDefault(); // Previne o comportamento padrão de recarregar a página

        // Obtém os dados do formulário e os converte para JSON
        const formData = new FormData(addDeviceForm);
        const data = Object.fromEntries(formData);

        // Envia uma requisição POST para adicionar o dispositivo
        fetch("../api/dispositivos/post.php", {
            method: "POST",
            body: JSON.stringify(data),
            headers: {
                "Content-Type": "application/json",
            },
        })
            .then((response) => response.json()) // Converte a resposta para JSON
            .then((result) => {
                // Exibe um alerta com a mensagem de sucesso ou erro
                showAlert(result.message, result.success ? "success" : "danger");

                if (result.success) {
                    loadDevices(); // Atualiza a lista de dispositivos
                    document.querySelector("#addModal .btn-close").click(); // Fecha o modal
                }
            })
            .catch(() => {
                // Exibe um alerta caso ocorra um erro
                showAlert("Erro ao adicionar dispositivo.", "danger");
            });
    });
});

// Função para carregar dispositivos
function loadDevices() {
    // Faz uma requisição GET para buscar a lista de dispositivos
    fetch("../api/dispositivos/get.php")
        .then((response) => response.json()) // Converte a resposta para JSON
        .then((devices) => {
            // Atualiza a tabela com os dispositivos retornados
            const deviceTable = document.getElementById("deviceTable");
            deviceTable.innerHTML = devices
                .map(
                    (device) => `
                <tr>
                    <td>${device.id}</td>
                    <td>${device.tipo_equipamento}</td>
                    <td>${device.nome_dispositivo}</td>
                    <td>${device.local_instalacao}</td>
                    <td>${device.ip}</td>
                    <td>${device.conexao_rede}</td>
                    <td>
                        <button class="btn btn-sm btn-warning" onclick="editDevice(${device.id})">Editar</button>
                        <button class="btn btn-sm btn-danger" onclick="deleteDevice(${device.id})">Excluir</button>
                    </td>
                </tr>
            `
                )
                .join("");
        })
        .catch(() => {
            // Exibe um alerta caso ocorra um erro ao carregar os dispositivos
            showAlert("Erro ao carregar dispositivos.", "danger");
        });
}

// Função para excluir um dispositivo
function deleteDevice(id) {
    if (confirm("Tem certeza que deseja excluir este dispositivo?")) {
        // Faz uma requisição DELETE para excluir o dispositivo
        fetch(`../api/dispositivos/delete.php?id=${id}`, {
            method: "DELETE",
        })
            .then((response) => response.json()) // Converte a resposta para JSON
            .then((result) => {
                // Exibe um alerta com a mensagem de sucesso ou erro
                showAlert(result.message, result.success ? "success" : "danger");

                if (result.success) {
                    loadDevices(); // Atualiza a lista de dispositivos
                }
            })
            .catch(() => {
                // Exibe um alerta caso ocorra um erro
                showAlert("Erro ao excluir dispositivo.", "danger");
            });
    }
}

// Função para exibir alertas
function showAlert(message, type) {
    // Cria um elemento de alerta dinâmico
    const alertBox = document.createElement("div");
    alertBox.className = `alert alert-${type} alert-dismissible fade show`;
    alertBox.role = "alert";
    alertBox.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    `;
    document.body.appendChild(alertBox); // Adiciona o alerta ao corpo da página

    // Remove automaticamente o alerta após 5 segundos
    setTimeout(() => {
        alertBox.remove();
    }, 5000);
}

// Função para editar um dispositivo (pode ser expandida futuramente)
function editDevice(id) {
    showAlert("Função de edição ainda não implementada.", "info");
}
