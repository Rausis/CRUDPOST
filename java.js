// Adicionar uma nova mensagem
document.getElementById('messageForm').addEventListener('submit', (e) => {
    e.preventDefault();
    fetch('back.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ message: document.getElementById('messageInput').value })
    })
    .then(res => res.json())
    .then(() => loadMessages());
});

// Carregar todas as mensagens
function loadMessages() {
    fetch('back.php?action=getMessages')
        .then(res => res.json())
        .then(data => {
            const messagesContainer = document.getElementById('messagesContainer');
            messagesContainer.innerHTML = ''; // Limpar mensagens anteriores

            data.messages.forEach(msg => {
                const postDiv = document.createElement('div');
                postDiv.classList.add('post');

                const messageContent = document.createElement('p');
                messageContent.textContent = msg.message;

                const editInput = document.createElement('input');
                editInput.value = msg.message;

                const saveButton = document.createElement('button');
                saveButton.textContent = 'Salvar';
                saveButton.addEventListener('click', () => {
                    editMessage(msg.id, editInput.value); // Editar mensagem ao clicar
                });

                const delButton = document.createElement('button');
                delButton.textContent = 'Excluir';
                delButton.addEventListener('click', () => {
                    deleteMessage(msg.id); // Excluir mensagem ao clicar
                });

                postDiv.appendChild(messageContent);
                postDiv.appendChild(editInput);
                postDiv.appendChild(saveButton);
                postDiv.appendChild(delButton);
                messagesContainer.appendChild(postDiv);
            });
        });
}

// Excluir mensagem específica
function deleteMessage(id) {
    fetch(`back.php?action=delete&id=${id}`, { method: 'DELETE' })
        .then(loadMessages); // Recarregar mensagens após exclusão
}

// Editar mensagem específica
function editMessage(id, newContent) {
    fetch('back.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ action: 'edit', id: id, message: newContent })
    })
    .then(res => res.json())
    .then(loadMessages); // Recarregar mensagens após edição
}

// Carregar mensagens quando a página carregar
document.addEventListener('DOMContentLoaded', loadMessages);
