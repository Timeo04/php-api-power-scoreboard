<html>
 <head>
  <title>Admin - Scoreboard</title>
  <link rel="stylesheet" href="../stylesheets/style.css">
 </head>
 <body>
  <p></p>
   <h1>Admin</h1>
   <h2>Scoreboard</h2>
   <a href="https://openprocessing.org/sketch/1447262">zum Game</a>
  <br>
  <p></p>
   <?php
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
    $name = $_POST['name'];
    $score = $_POST['score'];
    $userid = $_POST['userid'];
    $datevar = $_POST['date'];
    //echo "<p>".$name."</p><br>";
    //echo "<p>".$score."</p><br>";
    //echo "<p>".$userid."</p><br>";
    //echo "<p>".$datevar."</p><br>";
    if(strlen($name)<1){
     $ok = false;
    }elseif(!is_numeric($score)){
     $ok = false;
    }elseif(!is_numeric($userid)){
     $ok = false;
    }
    if(!isset($datevar) or $datevar==''){
      date_default_timezone_set('Europe/Zurich');
      $datevar = date('Y-m-d H:i:s');
    }
    if($ok){
     $statement = $pdo->prepare("INSERT INTO scoreboard (userid,score,name,date) VALUES (".$userid.",".$score.",'".$name."','".$datevar."');");
     $statement->execute();
     echo "<p>gespeichert!</p><br>";
    }else{
     echo "<p>Fehler!</p><br>";
    }
   ?>
  <br>
  <button class="modify" onclick="window.location.href = '../admin';">Zurück</button>
  <!--<input type="button" value="Zurück" onClick="javascript:history.back()">-->
 </body>
</html>
