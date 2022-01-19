<?php
//header('Content-Type: application/json; charset=utf-8');
$db = parse_url(getenv("DATABASE_URL"));
$ok = true;

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
//$text = trim($data['text'] ?? '');

$name = $data['name'];
$score = $data['score'];
$userid = $data['userid'];
$date = $data['date'];
if(strlen($name)<1){
    echo json_encode(["ok" => false]);
    $ok = false;
}elseif(!is_numeric($score)){
    echo json_encode(["ok" => false]);
    $ok = false;
}elseif(!is_numeric($userid)){
   echo json_encode(["ok" => false]);
    $ok = false;
}

if($ok){
    echo json_encode(["ok" => true]);
}
