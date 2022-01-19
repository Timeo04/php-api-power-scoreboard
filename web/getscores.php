<?php
header('Content-Type: application/json; charset=utf-8');
if(isset($_GET['num'])){
    $num = (int)$_GET['num'];
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

//$pdo = new PDO('mysql:host=localhost;dbname=test', 'root', '');
if(isset($num) and is_numeric($num)  and $num > 0){
    $statement = $pdo->prepare("SELECT * FROM scoreboard ORDER BY score;");
    //$statement = $pdo->prepare("SELECT TOP $num * FROM scoreboard ORDER BY score;");
}else{
    $statement = $pdo->prepare("SELECT * FROM scoreboard ORDER BY score;");
}
$statement->execute();
$data = $statement->fetchAll(PDO::FETCH_ASSOC);
echo json_encode($data);
