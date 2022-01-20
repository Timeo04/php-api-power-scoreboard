<?php
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: https://preview.openprocessing.org');
header('Access-Control-Allow-Methods: GET');
header("Access-Control-Allow-Headers: X-Requested-With");

$ok = true;
if(isset($_GET['id']) and is_numeric($_GET['id'])){
    $id = $_GET['id'];
    //echo json_encode(["ok" => $id]);
}else{
  $ok = false;
  echo json_encode(["ok" => false]);
}
   
$db = parse_url(getenv("DATABASE_URL"));
$pdo = new PDO("pgsql:" . sprintf(
    "host=%s;port=%s;user=%s;password=%s;dbname=%s",
    $db["host"],
    $db["port"],
    $db["user"],
    $db["pass"],
    ltrim($db["path"], "/")
));

if($ok){
   $statement = $pdo->prepare("SELECT COUNT(*) FROM scoreboard WHERE userid=".$id.";");
   $statement->execute();
   $data = $statement->fetchAll(PDO::FETCH_ASSOC);
    if($data[0]['count']==0){
        echo json_encode(["ok" => true]);
    }else{
        echo json_encode(["ok" => false]);
    }
}
