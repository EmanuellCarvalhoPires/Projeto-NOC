<?php
header("Content-Type: application/json");

// Conexão com o banco de dados
$conn = new mysqli("localhost", "root", "", "portalNOC");
if ($conn->connect_error) {
    echo json_encode(["success" => false, "message" => "Erro na conexão com o banco de dados."]);
    exit;
}

// Obter dados do POST
$data = json_decode(file_get_contents("php://input"), true);
$titulo = $data['titulo'];
$prioridade = $data['prioridade'];
$descricao = $data['descricao'];

// Inserir chamado no banco de dados
$stmt = $conn->prepare("INSERT INTO chamados (titulo, prioridade, descricao) VALUES (?, ?, ?)");
$stmt->bind_param("sis", $titulo, $prioridade, $descricao);

if ($stmt->execute()) {
    echo json_encode(["success" => true, "message" => "Chamado adicionado com sucesso!"]);
} else {
    echo json_encode(["success" => false, "message" => "Erro ao adicionar chamado."]);
}

$stmt->close();
$conn->close();
?>
