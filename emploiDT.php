<?php
require_once('connect.php');
session_start();


$dsn="mysql:dbname=".BASE.";host=".SERVER;
try{
$connexion=new PDO($dsn,USER,PASSWD);
}
catch(PDOException $e){
printf("Echec de la connexion : %s \n", $e->getMessage());
exit();
}
$id=0;
$errorMessage='';
echo $_SESSION['NomUtil']."<br/>";

$sql2="SELECT * FROM Utilisateur where NomUtil=:NomUtil";
$stat=$connexion->prepare($sql2);
$stat->bindParam(':NomUtil',$_SESSION['NomUtil']);
$stat->execute();

if($stat->rowCount()==0)
     echo "Inconnu! <br>";

foreach ($stat as $row1)
{
$id=$row1['NomUtil'];
}

//activité faites par le login

$sql="SELECT * FROM Faire where NomUtil=:id";
$statement=$connexion->prepare($sql);
$statement->bindParam(':id',$id);
$statement->execute();

?>

<!doctype html>
<head>
<meta charset="utf-8">
<title>Emploi du temps</title>
</head>
<body>
<p>Emploi du temps : (Cliquer sur OK pour continuer)</p>
<?php
if(!$statement)
     echo "Problème d'accès a la BD";
    else
    {
     if($statement->rowCount()==0)
     echo "Sans activité. <br>";
else
{
foreach ($statement as $row)
{
$sql3="SELECT NomAct FROM Activite where NomAct=:idA";
$stmt=$connexion->prepare($sql3);
$stmt->bindParam(':idA',$row['NomAct']);
$stmt->execute();
foreach ($stmt as $row3)
{	
echo $row3['NomAct']." ".$row['DateAct']." ".$row['HeureAct']."<br> ";
}
}
}
}
    ?>
<form action="menu.php" method="GET">
<input type="submit" value="ok">
</form>
</body>
</html>
