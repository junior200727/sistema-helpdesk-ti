<?php
// Força o PHP a mostrar todos os erros na tela
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

echo "<h3>Diagnóstico de Conexão</h3>";

$host = 'localhost';
$dbname = 'helpdesk_ti';
$username = 'root'; 
$password = ''; // <--- A suspeita está aqui

try {
    echo "Tentando conectar ao banco <b>$dbname</b>...<br>";
    
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "<h2 style='color:green'>SUCESSO! Conexão funcionou.</h2>";
    echo "O problema não é o banco de dados. Verifique se o arquivo login.php tem algum erro de digitação.";
    
} catch (PDOException $e) {
    echo "<h2 style='color:red'>ERRO DE CONEXÃO:</h2>";
    echo "<b>Mensagem do erro:</b> " . $e->getMessage() . "<br><br>";
    
    if(strpos($e->getMessage(), 'Access denied') !== false) {
        echo "FAIL: A senha do usuário 'root' está errada.<br>";
        echo "Tente alterar no arquivo <b>api/db.php</b> a senha para <b>'lampp'</b> ou a senha que você criou na instalação.";
    }
    
    if(strpos($e->getMessage(), 'Unknown database') !== false) {
        echo "FAIL: O banco de dados 'helpdesk_ti' não existe.<br>";
        echo "Vá no http://localhost/phpmyadmin e crie o banco.";
    }
}
?>