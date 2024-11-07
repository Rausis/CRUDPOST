<?php
// Estabelecer a conexão
$conn = conectar();

// Receber os dados do POST
$dado1 = isset($_POST['dado1']) ? $_POST['dado1'] : ''; // DADO 1
$dado2 = isset($_POST['dado2']) ? $_POST['dado2'] : ''; // DADO 2

// Executar a inserção
$insert_sql = "INSERT INTO NOME_TABELA (COLUNA_1, COLUNA_2) VALUES ('$dado1', '$dado2')"; // INSERÇÃO DE DADOS
$conn->query($insert_sql); // Executa o INSERT

// Executar a consulta de seleção
$select_sql = "SELECT * FROM NOME_TABELA"; // SELEÇÃO DE TODOS OS DADOS DA TABELA
$result = $conn->query($select_sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "ID: " . $row["id"] . " - Dado1: " . $row["COLUNA_1"] . "<br>"; // EXIBIÇÃO DOS RESULTADOS
    }
} else {
    echo "Nenhum resultado encontrado.";
}

// Alterando Valores
$valor_novo = "NOVO_VALOR"; // NOVO VALOR PARA A ATUALIZAÇÃO
$condicao = "CONDICAO_VALOR"; // CONDIÇÃO PARA SELECIONAR A LINHA A SER ALTERADA
$alter_sql = "UPDATE NOME_TABELA SET COLUNA_1 = '$valor_novo' WHERE CONDICAO_COLUNA = '$condicao'"; // ATUALIZAÇÃO DE VALOR

if ($conn->query($alter_sql) === TRUE) {
    echo "Update"; // MENSAGEM DE SUCESSO NA ATUALIZAÇÃO
} else {
    echo "ERROR"; // MENSAGEM DE ERRO NA ATUALIZAÇÃO
}

// Removendo Valores 
$remove_sql = "DELETE FROM NOME_TABELA WHERE CONDICAO_COLUNA = '$dado1'"; // DELEÇÃO DE VALOR COM BASE NA CONDIÇÃO
if ($conn->query($remove_sql) === TRUE) {
    echo "Deletado"; // MENSAGEM DE SUCESSO NA DELEÇÃO
} else {
    echo "ERRO"; // MENSAGEM DE ERRO NA DELEÇÃO
}
?>