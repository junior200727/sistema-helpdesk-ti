<?php


//BLOCO DE DEPURAÇÃO (MOSTRA ERROS) 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Inicia sessão e define cabeçalho
session_start();
header("Content-Type: application/json");

// Tenta incluir a conexão
try {
    require 'db.php';
} catch (Exception $e) {
    die(json_encode(["success" => false, "message" => "Erro ao carregar db.php: " . $e->getMessage()]));
}

// Recebe os dados
$input = file_get_contents("php://input");
$data = json_decode($input);

// Verifica se o JSON veio vazio
if (!$data) {
    echo json_encode(["success" => false, "message" => "Nenhum dado recebido. JSON Inválido."]);
    exit;
}

if(isset($data->email) && isset($data->senha)) {
    try {
        $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email = ?");
        $stmt->execute([$data->email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && $data->senha == $user['senha']) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['perfil'] = $user['perfil'];
            $_SESSION['nome'] = $user['nome'];

            echo json_encode([
                "success" => true, 
                "perfil" => $user['perfil'], 
                "nome" => $user['nome']
            ]);
        } else {
            echo json_encode(["success" => false, "message" => "Email ou senha incorretos!"]);
        }
    } catch (PDOException $e) {
        echo json_encode(["success" => false, "message" => "Erro SQL: " . $e->getMessage()]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Preencha email e senha."]);
}
?>