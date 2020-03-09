<?PHP
session_start();
include("install.php");
if (!isset($_SESSION['pseudo']))
	$error = 1;
else
{
	$way = 1;
	$error = 2;
	$resultat = mysqli_query($_SESSION['mysqli'], 'SELECT * FROM orders');
	while($donnees = mysqli_fetch_assoc($resultat))
	{
		if ($_SESSION['pseudo'] === $donnees['pseudo'])
			$way = 2;
	}
	mysqli_free_result($resultat);
}
?>
<html>
	<head>
		<title>Les Clefs en Fête</title>
		<link rel="stylesheet" href="miniboutique.css">
	</head>
	<body>
		<?PHP include("header.php");?>
		<div class="center">
			<?PHP include("menu.php");?>
			<div class="boutique">
<?PHP
if ($error === 2)
{
	$resultat = mysqli_query($_SESSION['mysqli'], "SELECT * FROM `users` WHERE `pseudo` = '$_SESSION[pseudo]' ");
	while($donnees = mysqli_fetch_assoc($resultat))
	{
		echo "<form style=\"text-align:center;\" method=\"POST\" action=\"modif_compte.php\"><p class=\"articles\"><strong>Pseudo:</strong> ".$donnees['pseudo']." <strong>Modifier:</strong> <input style=\"width:100px;height:40px;\" type=\"text\" name=\"pseudo_new\" value=\"\"> <input class=\"suscribe_input\" type=\"submit\" name=\"submit\" value=\"Modifier\"></p></form>";
		echo "<form style=\"text-align:center;\" method=\"POST\" action=\"modif_compte.php\"><p class=\"articles\"><strong>Ancien mot de passe:</strong> <input style=\"width:100px;height:40px;\" type=\"password\" name=\"old_pwd\" value=\"\"><strong> Modifier:</strong> <input style=\"width:100px;height:40px;\" type=\"password\" name=\"pwd_new\" value=\"\"> <input class=\"suscribe_input\" type=\"submit\" name=\"submit\" value=\"Modifier\"></p></form>";
		echo "<form style=\"text-align:center;\" method=\"POST\" action=\"modif_compte.php\"><p class=\"articles\"><strong>Email:</strong> ".$donnees['email']." <strong>Modifier:</strong> <input style=\"width:100px;height:40px;\" type=\"text\" name=\"email_new\" value=\"\"> <input class=\"suscribe_input\" type=\"submit\" name=\"submit\" value=\"Modifier\"></p></form>";
	}
	mysqli_free_result($resultat);
	echo "<form style=\"text-align:center;\" method=\"POST\" action=\"modif_compte.php\"><input class=\"large\" type=\"submit\" name=\"delete\" value=\"Supprimer compte\"></form>";
	if ($way === 2)
	{
		echo "<p class=\"articles\"><strong>Tu as une commande en attente !</strong></p>";
		echo "<form style=\"text-align:center;\" method=\"POST\" action=\"modif_compte.php\"><input class=\"large\" type=\"submit\" name=\"delete_order\" value=\"Annuler commande\"></form>";
	}
}
else
	echo "<p class=\"articles error\"><strong>Tu n'es pas connecté !</strong></p>";
?>
			</div>
		</div>
	</body>
</html>
