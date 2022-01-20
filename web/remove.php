<?php
header('Content-Type: application/json; charset=utf-8');
//header('Access-Control-Allow-Origin: https://preview.openprocessing.org');
//header('Access-Control-Allow-Methods: POST');
//header("Access-Control-Allow-Headers: X-Requested-With");
header("Access-Control-Allow-Headers: X-PINGOTHER, Content-Type");

$db = parse_url(getenv("DATABASE_URL"));
$pdo = new PDO("pgsql:" . sprintf(
    "host=%s;port=%s;user=%s;password=%s;dbname=%s",
    $db["host"],
    $db["port"],
    $db["user"],
    $db["pass"],
    ltrim($db["path"], "/")
));

$data = json_decode(file_get_contents('php://input'), true);

if(!isset($data['scoreid']) or !is_numeric($data['scoreid'])){
  echo json_encode(["ok" => false]);
}else{
  $statement = $pdo->prepare("DELETE FROM scoreboard WHERE scoreid=".$data['scoreid'].";");
  $ok = $statement->execute();
  echo json_encode(["ok" => $ok]); 
}
