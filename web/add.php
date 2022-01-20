<?php
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: https://preview.openprocessing.org');
header('Access-Control-Allow-Methods: POST');
header("Access-Control-Allow-Headers: X-Requested-With");
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
$datevar = $data['date'];
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
if(!isset($datevar)){
    date_default_timezone_set('Europe/Zurich');
    $datevar = date('Y-m-d H:i:s');
}

if($ok){
    if(isset($datevar)){
        $statement = $pdo->prepare("INSERT INTO scoreboard (userid,score,name,date) VALUES (".$userid.",".$score.",'".$name."','".$datevar."');");
    }else{
        //$statement = $pdo->prepare("SELECT * FROM scoreboard ORDER BY score DESC;");
        $statement = $pdo->prepare("INSERT INTO scoreboard (userid,score,name) VALUES (".$userid.",".$score.",'".$name."');");
        //$statement->execute();
        //echo json_encode(["ok" => "INSERT INTO scoreboard (userid,score,name) VALUES (".$userid.",".$score.",'".$name."');"]);
    }
    $sok = $statement->execute();
    echo json_encode(["ok" => $sok]);
    //echo json_encode(["ok" => true]);
}
