<?php
header("Content-Type: application/json");

// Conexão com o banco de dados
$conn = new mysqli("localhost", "root", "", "portalNOC");
if ($conn->connect_error) {
    echo json_encode(["success" => false, "message" => "Erro na conexão com o banco de dados."]);
    exit;
}

// Consultar chamados
$sql = "SELECT id, titulo, prioridade, descricao FROM chamados ORDER BY data_criacao DESC";
$result = $conn->query($sql);

$chamados = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $chamados[] = $row;
    }
}

// Retornar resultados
echo json_encode($chamados);
$conn->close();
?>
