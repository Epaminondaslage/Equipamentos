// Aguarda o carregamento completo do DOM antes de executar qualquer interação
document.addEventListener("DOMContentLoaded", function () {
    // Carrega os dispositivos ao abrir a página
    loadDevices();
});

// função para editar registro inicio popo

 /**
 * Popula um elemento <select> com opções e seleciona o valor atual.
 * @param {string} selectId - O ID do elemento <select>.
 * @param {Array} options - Lista de opções disponíveis.
 * @param {string} selectedValue - O valor atualmente selecionado.
 */
function populateSelect(selectId, options, selectedValue) {
    const select = document.getElementById(selectId);
    select.innerHTML = ""; // Limpa as opções atuais
    options.forEach(option => {
        const opt = document.createElement("option");
        opt.value = option;
        opt.textContent = option.charAt(0).toUpperCase() + option.slice(1);
        if (option === selectedValue) {
            opt.selected = true;
        }
        select.appendChild(opt);
    });
}

function getSelectOptions(selectId) {
    // Seleciona o elemento <select> pelo ID
    const selectElement = document.getElementById(selectId);

    // Mapeia as opções para um array com os valores e filtra os vazios
    const options = Array.from(selectElement.options)
        .map(option => option.value) // Obtém os valores
        .filter(value => value.trim() !== ''); // Remove valores vazios

    return options;
}

// Exemplo de uso

/**
 * Abre o modal de edição e preenche os campos com os dados do dispositivo.
 * @param {number} id - O ID do dispositivo a ser editado.
 */
function openEditModal(id) {
    fetch(`/Equipamentos/api/dispositivos/get.php?id=${id}`)
        .then(response => {
            if (!response.ok) {
                throw new Error(`Erro na requisição: ${response.statusText}`);
            }
            return response.json();
        })
        .then(data => {
            // Preencher campos básicos
            document.getElementById("edit_id").value = data.id || "";
            document.getElementById("edit_nome").value = data.nome_dispositivo || "";
            document.getElementById("edit_ip").value = data.ip || "";

            // Preencher os selects com valores ENUM e selecionar o valor atual
            populateSelect("edit_tipo", getSelectOptions('tipo'), data.tipo_equipamento);
            populateSelect("edit_local", getSelectOptions('local'), data.local_instalacao);
            populateSelect("edit_conexao", getSelectOptions('conexao'), data.conexao_rede);

            const editModal = new bootstrap.Modal(document.getElementById('editModal'));
            editModal.show();
        })
        .catch(error => {
            console.error("Erro ao carregar os dados para edição:", error);
            alert("Erro ao carregar os dados para edição.");
        });
}

    
    // fim popo



    // Adicionar Dispositivo

    const addDeviceForm = document.getElementById("addDeviceForm");
    addDeviceForm.addEventListener("submit", function (e) {
        e.preventDefault(); // Previne o recarregamento da página ao enviar o formulário

        // Validação dos campos do formulário
        const tipo = document.getElementById("tipo").value.trim();
        const nome = document.getElementById("nome").value.trim();
        const local = document.getElementById("local").value.trim();
        const ip = document.getElementById("ip").value.trim();
        const conexao = document.getElementById("conexao").value.trim();

        if (!tipo || !nome || !local || !ip || !conexao) {
            alert("Por favor, preencha todos os campos obrigatórios!");
            return; // Impede o envio se houver campos vazios
        }

        const formData = new FormData(this);

        const formObject = Object.fromEntries(formData.entries());


        // Envia os dados para o backend (add_device.php)
        fetch("/Equipamentos/api/dispositivos/post.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json", // Define o tipo de conteúdo como JSON
            },
            body: JSON.stringify(formObject), // Serializa o objeto em JSON
        })
            .then((response) => response.text())
            .then((message) => {
                showAlert(message, "success"); // Exibe mensagem de sucesso
                loadDevices(); // Recarrega a lista de dispositivos
                const addModal = bootstrap.Modal.getInstance(document.getElementById("addModal"));
                addModal.hide(); // Fecha o modal de adição
            })
            .catch(() => {
                showAlert("Erro ao adicionar dispositivo.", "danger"); // Exibe mensagem de erro
            });
    });

    // Editar Dispositivo
    function editDevice(form){
        console.log('editing');
        event.preventDefault();
        const formData = new FormData(form);
        console.log("form data", formData);

        const formObject = Object.fromEntries(formData.entries());

        // Envia os dados para o backend (edit_device.php)
        fetch("/Equipamentos/api/dispositivos/put.php", {
            method: "PUT",
            headers: {
                "Content-Type": "application/json", // Define o tipo de conteúdo como JSON
            },
            body: JSON.stringify(formObject), // Serializa o objeto em JSON
        })
            .then((response) => response.text())
            .then((message) => {
                showAlert(message, "success"); // Exibe mensagem de sucesso
                loadDevices(); // Recarrega a lista de dispositivos
                const editModal = bootstrap.Modal.getInstance(document.getElementById("editModal"));
                editModal.hide(); // Fecha o modal de edição
            })
            .catch(() => {
                showAlert("Erro ao editar dispositivo.", "danger"); // Exibe mensagem de erro
            });
        return false;
    };

// Carrega os dispositivos do backend e exibe na tabela
function loadDevices() {
    fetch("/Equipamentos/api/dispositivos/get.php")
        .then((response) => response.json())
        .then((devices) => {
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
                        <button class="btn btn-warning btn-sm" onclick="openEditModal(${device.id})">Editar</button>
                        <button class="btn btn-danger btn-sm" onclick="deleteDevice(${device.id})">Excluir</button>
                    </td>
                </tr>`
                )
                .join("");
        })
        .catch(() => {
            showAlert("Erro ao carregar dispositivos.", "danger");
        });
}

// Excluir dispositivo
function deleteDevice(id) {
    if (confirm("Tem certeza que deseja excluir este dispositivo?")) {
        fetch(`/Equipamentos/api/dispositivos/delete.php?id=${id}`)
            .then((response) => response.text())
            .then((message) => {
                showAlert(message, "success");
                loadDevices(); // Recarrega a lista de dispositivos
            })
            .catch(() => {
                showAlert("Erro ao excluir dispositivo.", "danger");
            });
    }
}

// Exibir mensagens de alerta dinâmicas
function showAlert(message, type) {
    const alertBox = document.createElement("div");
    alertBox.className = `alert alert-${type} alert-dismissible fade show`;
    alertBox.role = "alert";
    alertBox.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    `;
    const alertContainer = document.getElementById('alertContainer');
    alertContainer.appendChild(alertBox);
    setTimeout(() => alertBox.remove(), 5000); // Remove o alerta após 5 segundos
}
