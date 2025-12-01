<?php

session_start();
header("Content-Type: application/json");
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    die(json_encode(["error" => "Não autorizado"]));
}

$method = $_SERVER['REQUEST_METHOD'];

//LISTAR CHAMADOS (GET)
if ($method == 'GET') {
    if ($_SESSION['perfil'] == 'admin') {
        // Admin vê tudo e o nome do solicitante
        $sql = "SELECT c.*, u.nome as solicitante FROM chamados c 
                JOIN usuarios u ON c.usuario_id = u.id 
                ORDER BY c.data_abertura DESC";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
    } else {
        // Usuário vê apenas os seus
        $sql = "SELECT * FROM chamados WHERE usuario_id = ? ORDER BY data_abertura DESC";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$_SESSION['user_id']]);
    }
    
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
}

//CRIAR NOVO CHAMADO (POST) 
if ($method == 'POST') {
    $data = json_decode(file_get_contents("php://input"));

    if(isset($data->titulo) && isset($data->categoria)) {
        $sql = "INSERT INTO chamados (usuario_id, titulo, descricao, categoria, prioridade, status) 
                VALUES (?, ?, ?, ?, ?, 'aberto')";
        
        $stmt = $pdo->prepare($sql);
        $result = $stmt->execute([
            $_SESSION['user_id'],
            $data->titulo,
            $data->descricao,
            $data->categoria,
            $data->prioridade
        ]);

        echo json_encode(["success" => $result]);
    }
}

// --- ATUALIZAR STATUS DO CHAMADO (PUT) ---
if ($method == 'PUT') {
    // Apenas admin pode fechar chamados
    if ($_SESSION['perfil'] !== 'admin') {
        die(json_encode(["success" => false, "message" => "Apenas administradores."]));
    }

    $data = json_decode(file_get_contents("php://input"));

    if(isset($data->id) && isset($data->novo_status)) {
        $sql = "UPDATE chamados SET status = ?, data_fechamento = NOW() WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        
        try {
            $stmt->execute([$data->novo_status, $data->id]);
            echo json_encode(["success" => true]);
        } catch (PDOException $e) {
            echo json_encode(["success" => false, "message" => "Erro SQL: " . $e->getMessage()]);
        }
    } else {
        echo json_encode(["success" => false, "message" => "Dados incompletos."]);
    }
}
?>