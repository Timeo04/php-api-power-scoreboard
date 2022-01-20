<html>
 <head>
  <title>Admin - Scoreboard</title>
  <link rel="stylesheet" href="stylesheets/style.css">
 </head>
 <body>
  <p></p>
   <h1>Admin</h1>
   <h2>Scoreboard</h2>
   <a href="https://openprocessing.org/sketch/1447262">zum Game</a>
  <br>
  <p></p>
  <form method="post" id="form1"></form>
   <?php
  
    if(isset($_POST['delete'])){
     deleteColumn($_POST['delete']);
     //echo $_POST['delete'];
    }
  
    if(isset($_POST['deleteAll'])){
     resetDB();
    }
  
    if(isset($_POST['submitSave'])){
     storeScore();
     //echo "<p>Saave</p>";
    }
  
    showTable();
  
    echo '<br><p></p>';
    echo '<h2 style="color: red;">Alles Löschen</h2>';
    echo '<button type="submit" form="form1" name="deleteAll" value="true">Zurücksetzen</button>';
  
    function showTable(){
     $db = parse_url(getenv("DATABASE_URL"));
     $pdo = new PDO("pgsql:" . sprintf(
        "host=%s;port=%s;user=%s;password=%s;dbname=%s",
        $db["host"],
        $db["port"],
        $db["user"],
        $db["pass"],
        ltrim($db["path"], "/")
     ));
     
     echo '<table border="1" width="800" style="margin-left:auto;margin-right:auto">';
     echo '<tr><th>ScoreID:</th><th>UserID:</th><th>Score:</th><th>Name:</th><th>Datum:</th><th>delete</th></tr>';
     $sql = "SELECT * FROM scoreboard ORDER BY scoreid DESC";
     foreach ($pdo->query($sql) as $row) {
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
    }
  
    function showModifyTable(){
     echo "<p>Hello World</p>";
    }
  
    function deleteColumn($id){
     $db = parse_url(getenv("DATABASE_URL"));
     $pdo = new PDO("pgsql:" . sprintf( 
      "host=%s;port=%s;user=%s;password=%s;dbname=%s",
      $db["host"],
      $db["port"],
      $db["user"],
      $db["pass"],
      ltrim($db["path"], "/")
     ));
     $statement = $pdo->prepare("DELETE FROM scoreboard WHERE scoreid=".$id.";");
     $statement->execute();
    }
  
    function resetDB(){
     $db = parse_url(getenv("DATABASE_URL"));
     $pdo = new PDO("pgsql:" . sprintf( 
      "host=%s;port=%s;user=%s;password=%s;dbname=%s",
      $db["host"],
      $db["port"],
      $db["user"],
      $db["pass"],
      ltrim($db["path"], "/")
     ));
     $statement = $pdo->prepare("DELETE FROM scoreboard;");
     $statement->execute();     
     echo "<p>zurückgesetzt!</p>";
    }
  
    function storeScore(){
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
     if(strlen($name)<1){
      $ok = false;
     }elseif(!is_numeric($score)){
      $ok = false;
     }elseif(!is_numeric($userid)){
      $ok = false;
     }
     if(!isset($datevar)){
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
    }
  
   ?>
  <h2>Score eintragen</h2>
  <br>
  <form action="/admindata/add.php" method="post" id="form2">
   <label for="userid">User ID (required):</label><br>
   <input type="number" id="userid" name="userid" min="0" value="9999" required><br>
   <label for="score">Score (required):</label><br>
   <input type="number" id="score" name="score" min="0" value="0" required><br>
   <label for="name">Name (required):</label><br>
   <input type="text" id="name" name="name" value="" required><br>
   <label for="date">Date:</label><br>
   <input type="text" id="date" name="date" value=""><br>
   <input type="submit" name="submitSave" value="speichern">
   <input type="reset">
  </form>
 </body>
</html>
