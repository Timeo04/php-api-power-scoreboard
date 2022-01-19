<html>
 <head>
  <title>POWERS - Scoreboard</title>
  <link rel="stylesheet" href="stylesheets/style.css">
 </head>
 <body>
   <h1>Scoreboard</h1>
   <a href="https://openprocessing.org/sketch/1447262">zum Game</a>
  <br>
 <?php 
  //echo '<p>Hallo Welt</p>'; 
  
  $db = parse_url(getenv("DATABASE_URL"));
  $pdo = new PDO("pgsql:" . sprintf(
      "host=%s;port=%s;user=%s;password=%s;dbname=%s",
      $db["host"],
      $db["port"],
      $db["user"],
      $db["pass"],
      ltrim($db["path"], "/")
  ));
  
  
  echo '<table border="1" width="200" style="margin-left:auto;margin-right:auto">';
  echo '<tr><th>Score:</th><th>Name:</th><th>Datum:</th></tr>';
  $sql = "SELECT score, name, date FROM scoreboard ORDER BY score DESC";
  foreach ($pdo->query($sql) as $row) {
   echo "<tr>";
   echo "<td>". $row['score'] . "</td>";
   echo "<td>". $row['name'] . "</td>";
   echo "<td>". $row['date'] . "</td>";
   echo "</tr>";
   //echo $row['score']." ".$row['name']." ".$row['date']."  "."<br />";
   //echo "E-Mail: ".$row['email']."<br /><br />";
  }
  echo "</table>";
 ?>
 </body>
</html>
