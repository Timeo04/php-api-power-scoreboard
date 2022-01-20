<?php
header('Content-Type: application/json; charset=utf-8');
$db = parse_url(getenv("DATABASE_URL"));
$ok = true;
if(isset($_GET['id']) and is_numeric($_GET['id']){
    $id = $_GET['id'];
}else{
  $ok = false;
  echo json_encode(["ok" => false]);
}
$pdo = new PDO("pgsql:" . sprintf(
    "host=%s;port=%s;user=%s;password=%s;dbname=%s",
    $db["host"],
    $db["port"],
    $db["user"],
    $db["pass"],
    ltrim($db["path"], "/")
));
/*
if($ok){
   $statement = $pdo->prepare("SELECT COUNT(*) FROM scoreboard WHERE userid=".$id.");");
   $statement->execute();
   $data = $statement->fetchAll(PDO::FETCH_ASSOC);
   echo json_encode($data);
}*/
echo json_encode(["ok" => true]);
