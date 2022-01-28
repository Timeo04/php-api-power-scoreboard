<?php
header('Content-Type: application/json; charset=utf-8');
//header('Access-Control-Allow-Origin: https://preview.openprocessing.org');
//header('Access-Control-Allow-Methods: GET');
header("Access-Control-Allow-Headers: X-Requested-With");

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
    //$statement = $pdo->prepare("SELECT * FROM scoreboard ORDER BY score;");
     $sql = "SELECT MAX(score) score, name FROM scoreboard GROUP BY userid, name ORDER BY score DESC";
    $statement = $pdo->prepare("SELECT MAX(score) score, name, userid FROM scoreboard GROUP BY userid, name ORDER BY score DESC LIMIT ".$num.";");
    //$statement = $pdo->prepare("SELECT * FROM scoreboard ORDER BY score DESC LIMIT ".$num.";");
}else{
    $statement = $pdo->prepare("SELECT MAX(score) score, name, userid FROM scoreboard GROUP BY userid, name ORDER BY score DESC;");
    //$statement = $pdo->prepare("SELECT * FROM scoreboard ORDER BY score DESC;");
}
$statement->execute();
$data = $statement->fetchAll(PDO::FETCH_ASSOC);
echo json_encode($data);
