<?php
// Conectar ao banco de dados
$conn = new mysqli('localhost', 'root', '', 'simpleApp');

// Verificar erros de conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Obter os dados JSON enviados via POST
$dados = json_decode(file_get_contents("php://input"), true);
$action = $dados['action'] ?? '';

// Adicionar nova mensagem
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $action !== 'edit') {
    $mensagem = $dados['message'] ?? '';

    if ($mensagem) {
        $conn->query("INSERT INTO messages (message) VALUES ('$mensagem')");
        echo json_encode(['success' => true]);
    }
    exit;
}

// Editar mensagem
if ($action === 'edit' && isset($dados['id']) && isset($dados['message'])) {
    $id = $dados['id'];
    $newMessage = $dados['message'];

    if ($newMessage) {
        $conn->query("UPDATE messages SET message = '$newMessage' WHERE id = $id");
        echo json_encode(['success' => true]);
    }
    exit;
}

// Obter todas as mensagens
if (isset($_GET['action']) && $_GET['action'] === 'getMessages') {
    $resultado = $conn->query("SELECT id, message FROM messages ORDER BY id DESC");
    $mensagens = [];
    
    while ($linha = $resultado->fetch_assoc()) {
        $mensagens[] = $linha;
    }
    
    echo json_encode(['messages' => $mensagens]);
    exit;
}

// Deletar mensagem específica
if (isset($_GET['action']) && $_GET['action'] === 'delete') {
    $id = $_GET['id'];
    $conn->query("DELETE FROM messages WHERE id = $id");
    echo json_encode(['success' => true]);
    exit;
}
// Fechar a conexão com o banco de dados
$conn->close();
?>
