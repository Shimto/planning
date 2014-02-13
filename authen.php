<?php
require_once('connect.php');

$dsn="mysql:dbname=".BASE.";host=".SERVER;
try{
$connexion=new PDO($dsn,USER,PASSWD);
}
catch(PDOException $e){
printf("Echec de la connexion : %s \n", $e->getMessage());
exit();
}

$errorMessage='';

//test de l'envoi du formulaire
if(!empty($_POST))
{	
//les identifiants sont transmis.
if(!empty($_POST['NomUtil']) && !empty($_POST['password']))
{
$sql="SELECT * FROM Utilisateur where NomUtil=:NomUtil and password=:passwd";

$statement=$connexion->prepare($sql);
$statement->bindParam(':NomUtil',$_POST['NomUtil']);
$statement->bindParam(':passwd',$_POST['password']);
$statement->execute();
if($statement->rowCount()!=1){
$errorMessage='Erreur dans vos identifiants';
}
else
{
session_start();
$_SESSION['NomUtil']=$_POST['NomUtil'];
header('location: menu.php');
}
}
else
{
$errorMessage='Veuillez inscrire vos identifiants';
}
}
?>

<!doctype html>
<head>
<meta charset="utf-8">
<title>Formulaire d\'authentification </title>
</head>
<body>
<form action=
"<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
<fieldset>
<legend>Identifiez-vous</legend>
<?php
// Rencontre-t-on une erreur ?
if(!empty($message))
echo '<p>', htmlspecialchars($message) ,'</p>';
?>
<p>
<label for="NomUtil">Login :</label>
<input type="text" name="NomUtil" id="NomUtil" value="" />
</p>
<p>
<label for="password">Password :</label>
<input type="password" name="password" id="password" value="" />
<br/>
<input type="submit" name="submit" value="valider"/>
</p>
</fieldset>
</form>
</body>
</html>
