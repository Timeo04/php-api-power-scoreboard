<?php
header('Content-Type: application/json; charset=utf-8');
header("Access-Control-Allow-Headers: X-Requested-With");

global $pdo, $id;

$db = parse_url(getenv("DATABASE_URL"));
$pdo = new PDO("pgsql:" . sprintf(
    "host=%s;port=%s;user=%s;password=%s;dbname=%s",
    $db["host"],
    $db["port"],
    $db["user"],
    $db["pass"],
    ltrim($db["path"], "/")
));

$id = random_int(100000,999999);
check($id);

function check($idToCheck){
  $statement = $pdo->prepare("SELECT COUNT(*) FROM scoreboard WHERE userid=".$idToCheck.";");
  $statement->execute();
  $data = $statement->fetchAll(PDO::FETCH_ASSOC);
  if($data[0]['count']==0){
    echo json_encode(["id" => $idToCheck]);
  }else{
    $id = random_int(100000,999999);
    check($id);
    //echo json_encode(["ok" => false]);
  }
}
