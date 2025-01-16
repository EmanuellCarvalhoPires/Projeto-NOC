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
$chamado_id = $data['chamado_id'];
$comentario = $data['comentario'];

// Inserir comentário no banco de dados
$stmt = $conn->prepare("INSERT INTO comentarios (chamado_id, comentario) VALUES (?, ?)");
$stmt->bind_param("is", $chamado_id, $comentario);

if ($stmt->execute()) {
    echo json_encode(["success" => true, "message" => "Comentário adicionado com sucesso!"]);
} else {
    echo json_encode(["success" => false, "message" => "Erro ao adicionar comentário."]);
}

$stmt->close();
$conn->close();
?>
