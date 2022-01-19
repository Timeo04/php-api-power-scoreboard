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

//$pdo = new PDO('mysql:host=localhost;dbname=test', 'root', '');
$statement = $pdo->prepare("SELECT * FROM scoreboard ORDER BY score;");
$statement->execute();
$data = $statement->fetchAll(PDO::FETCH_ASSOC);
echo json_encode($data);
