<?php
header("Content-Type: application/json");

// Conexão com o banco de dados
$conn = new mysqli("localhost", "root", "", "portalNOC");
if ($conn->connect_error) {
    echo json_encode(["success" => false, "message" => "Erro na conexão com o banco de dados."]);
    exit;
}

// Obter o ID do chamado
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Consultar informações do chamado
$sqlChamado = "SELECT id, titulo, descricao FROM chamados WHERE id = ?";
$stmtChamado = $conn->prepare($sqlChamado);
$stmtChamado->bind_param("i", $id);
$stmtChamado->execute();
$resultChamado = $stmtChamado->get_result();
$chamado = $resultChamado->fetch_assoc();

if (!$chamado) {
    echo json_encode(["success" => false, "message" => "Chamado não encontrado."]);
    exit;
}

// Consultar comentários do chamado
$sqlComentarios = "SELECT comentario FROM comentarios WHERE chamado_id = ?";
$stmtComentarios = $conn->prepare($sqlComentarios);
$stmtComentarios->bind_param("i", $id);
$stmtComentarios->execute();
$resultComentarios = $stmtComentarios->get_result();

$comentarios = [];
while ($row = $resultComentarios->fetch_assoc()) {
    $comentarios[] = $row;
}

// Combinar dados e retornar JSON
$chamado['comentarios'] = $comentarios;
echo json_encode($chamado);

$stmtChamado->close();
$stmtComentarios->close();
$conn->close();
?>
