<?php
header('Content-Type: application/json; charset=utf-8');

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

if(!isset($data['userid']) or !is_numeric($data['userid'])){
  echo json_encode(["ok" => false]);
}else{
  $statement = $pdo->prepare("DELETE FROM scoreboard WHERE userid=".$data['userid'].";");
  $ok = $statement->execute();
  echo json_encode(["ok" => $ok]); 
}
