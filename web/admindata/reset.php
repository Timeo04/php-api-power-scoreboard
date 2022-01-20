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
  <form method="post" id="form1"></form>
   <?php
    if(isset($_POST['deleteAll'])){
     resetDB();
    }else{
     echo "<h2 style=\"color: red;\">Alles löschen?</h2>";
     echo "<p>Sind Sie sicher? <br>Diese Aktion <b>kann nicht rückgängig gemacht werden</b></p>";
     echo "<button type=\"submit\" form=\"form1\" name=\"deleteAll\" value=\"true\">Zurücksetzen</button>";
     echo "<br>";
     echo "<button onclick=\"window.location.href = '../admin';\">Abbrechen</button>";
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
     echo "<p><b>zurückgesetzt!</b></p><br>";
     echo "<button onclick=\"window.location.href = '../admin';\">Zurück</button>";
    }
   ?>
  </body>
</html>
