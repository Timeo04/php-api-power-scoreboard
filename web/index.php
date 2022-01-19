<html>
 <head>
  <title>POWERS - Scoreboard</title>
 </head>
 <body>
   <h1>Scoreboard</h1>
   <a href="https://openprocessing.org/sketch/1447262">zum Game</a>
 <?php 
  echo '<p>Hallo Welt</p>'; 
  
  $db = parse_url(getenv("DATABASE_URL"));
  $pdo = new PDO("pgsql:" . sprintf(
      "host=%s;port=%s;user=%s;password=%s;dbname=%s",
      $db["host"],
      $db["port"],
      $db["user"],
      $db["pass"],
      ltrim($db["path"], "/")
  ));
  
  $sql = "SELECT score, name, date FROM scoreboard ORDER BY score DESC";
  foreach ($pdo->query($sql) as $row) {
   echo $row['score']." ".$row['name']." ".$row['date']."  "."<br />";
   //echo "E-Mail: ".$row['email']."<br /><br />";
  }
 ?>
 </body>
</html>
