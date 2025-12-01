<?php

require 'db.php';

header("Content-Type: application/json");
$data = json_decode(file_get_contents("php://input"));

if(isset($data->nome) && isset($data->email) && isset($data->senha)) {
    
    //  Verifica se o email já existe
    $check = $pdo->prepare("SELECT id FROM usuarios WHERE email = ?");
    $check->execute([$data->email]);
    
    if($check->rowCount() > 0) {
        echo json_encode(["success" => false, "message" => "Este e-mail já está cadastrado!"]);
        exit;
    }

    // 2. Insere o novo usuário (Sempre como 'user' comum por segurança)
    $sql = "INSERT INTO usuarios (nome, email, senha, perfil) VALUES (?, ?, ?, 'user')";
    $stmt = $pdo->prepare($sql);
    
    try {
        $stmt->execute([$data->nome, $data->email, $data->senha]);
        echo json_encode(["success" => true, "message" => "Conta criada com sucesso!"]);
    } catch (PDOException $e) {
        echo json_encode(["success" => false, "message" => "Erro ao cadastrar: " . $e->getMessage()]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Preencha todos os campos!"]);
}
?>