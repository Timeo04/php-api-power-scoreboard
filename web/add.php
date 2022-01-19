<?php
//header('Content-Type: application/json; charset=utf-8');
$db = parse_url(getenv("DATABASE_URL"));

$pdo = new PDO("pgsql:" . sprintf(
    "host=%s;port=%s;user=%s;password=%s;dbname=%s",
    $db["host"],
    $db["port"],
    $db["user"],
    $db["pass"],
    ltrim($db["path"], "/")
));

// Bekomme den JSON Body der Anfrage
$data = json_decode(file_get_contents('php://input'), true);
 
// Extrahiere den Text
$text = trim($data['text'] ?? '');

echo $data;
echo ' - ';
echo $text;
echo ' - ';
echo $data['score'];
echo ' - ';
echo $data['date'];
