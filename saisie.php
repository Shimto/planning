<?php
  require_once('connect.php');
  session_start();
  $dsn="mysql:dbname=".BASE.";host=".SERVER;
  try{
    $connexion=new PDO($dsn,USER,PASSWD);
  }
  catch(PDOException $e) {
    printf("Echec de la connexion : %s \n", $e->getMessage());
    exit();
  }
  $errorMessage='';
	if(!empty($_POST)) {
    if(!empty($_POST['DateAct']) && !empty($_POST['HeureAct'])) {
    $sql2="SELECT * FROM Utilisateur where NomUtil=:NomUtil";
    $stat=$connexion->prepare($sql2);
    $stat->bindParam(':NomUtil',$_SESSION['NomUtil']);
    $stat->execute();  
    if($stat->rowCount()==0)
      echo "Inconnu. <br>";  
    foreach ($stat as $row1) {
     $id=$row1['NomUtil'];
    }   
    $sql1="SELECT NomAct FROM Activité WHERE NomAct=:choixAct";
    $stmt=$connexion->prepare($sql1);
    $stmt->bindParam(':choixAct',$_POST['choixAct']);
    $stmt->execute();
    if($stmt->rowCount()==0)
      echo "Erreur : L'activité que vous avez saisi est inconnue. <br>";   
    foreach ($stmt as $row) {
     $idAct=$row['NomAct'];
    }
    $sql="INSERT INTO `Bporte`.`Faire` (`NomUtil`, `NomAct`, `DateAct`, `HeureAct`) VALUES(:NomUtil,:NomAct,:DateAct,:HeureAct)";    
    $statement=$connexion->prepare($sql);
    $statement->bindParam(':NomUtil',$id);
    $statement->bindParam(':NomAct',$idAct);
    $statement->bindParam(':DateAct',$_POST['DateAct']);
    $statement->bindParam(':HeureAct',$_POST['HeureAct']);
    $statement->execute();
   }
 }
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Activité ajoutée</title>
</head>
<p>Activité ajoutée (cliquer sur OK pour continuer)</p>
<form action="menu.php" method="GET">
<input type="submit" value="ok">
</form>
<body>
</body>
</html>
