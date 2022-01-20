<html>
 <head>
  <title>Admin - Scoreboard</title>
  <link rel="stylesheet" href="stylesheets/style.css">
 </head>
 <body>
   <h1>Admin</h1>
   <h2>Scoreboard</h2>
   <a href="https://openprocessing.org/sketch/1447262">zum Game</a>
  <br>
  <p></p>
  <form method="post" id="form1"></form>
   <?php
  
    $db = parse_url(getenv("DATABASE_URL"));
    $pdo = new PDO("pgsql:" . sprintf(
        "host=%s;port=%s;user=%s;password=%s;dbname=%s",
        $db["host"],
        $db["port"],
        $db["user"],
        $db["pass"],
        ltrim($db["path"], "/")
    ));
  
  echo $_POST;
  if(isset($_POST['delete'])){
    echo $_POST['delete'];
  }
  
    echo "<p>Helloo World</p>";
  
    //showTable($pdo);
  
    //function showTable($pdo1){
     echo '<table border="1" width="800" style="margin-left:auto;margin-right:auto">';
     echo '<tr><th>ScoreID:</th><th>UserID:</th><th>Score:</th><th>Name:</th><th>Datum:</th><th>delete</th></tr>';
     $sql = "SELECT * FROM scoreboard ORDER BY score DESC";
     foreach ($pdo->query($sql) as $row) {
      //echo "
      echo "<tr>";
      echo "<td>". $row['scoreid']. "</td>";
      echo "<td>". $row['userid']. "</td>";
      echo "<td>". $row['score'] . "</td>";
      echo "<td>". $row['name'] . "</td>";
      echo "<td>". $row['date'] . "</td>";
      echo '<td><button type="submit" form="form1" name="delete" value="'.$row['scoreid']. '">Löschen</button></td>';
      //echo '<td><form method="post"><input type="submit" name="button1" class="button" value="'.$row['scoreid']. '"</td>';
      echo "</tr>";
     }
     echo "</table>";  
    //}
  
    function resetDB(){
     
     echo "<p>reseeet</p>";
    }
   ?>
 </body>
</html>
