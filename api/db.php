<?php
$host = 'localhost';
$dbname = 'helpdesk_ti';
$username = 'root';
$password = ''; 

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    
    die(json_encode(["success" => false, "message" => "Erro DB: " . $e->getMessage()]));
}
?>