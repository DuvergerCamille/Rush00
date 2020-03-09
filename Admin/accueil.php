<?PHP
session_start();
include("../install.php");
if (isset($_POST['pseudo']) && isset($_POST['pwd']))
{
	$_POST['pwd'] = hash('whirlpool', $_POST['pwd']);
	$connection = 0;
	$resultat = mysqli_query($_SESSION['mysqli'], 'SELECT * FROM admin');
	while($donnees = mysqli_fetch_assoc($resultat))
	{
		if ($donnees['pseudo'] === $_POST['pseudo'])
		{
			if ($donnees['pwd'] === $_POST['pwd'])
			{
				$connection = 1;
				$_SESSION['pseudo'] = $_POST['pseudo'];
			}
			else
				$connection = 2;
		}
	}
	mysqli_free_result($resultat);
}
?>
<html>
	<head>
		<title>Admin</title>
		<link rel="stylesheet" href="../miniboutique.css">
	</head>
	<body>
<?PHP
if ($connection === 1)
	include("header.php");
?>
		<div class="center">
<?PHP
if ($connection === 1)
	include("menu.php");
?>
			<div class="boutique">
<?PHP
if ($connection === 1)
{
	echo "<br><br><br><br><br><br<br><br><br><br><br><br><br><br><br><br><br><br>";
	echo "<p class=\"articles\"><strong>Bon retour parmi nous admin ".$_SESSION['pseudo']." !</strong></p>";
	echo "<p class=\"articles\"><strong>Si tu veux retourner sur la facade client, clique sur le nom de la boutique.</strong></p>";
}
else if ($connection === 2)
{
	echo "<br><br><br><br><br><br<br><br><br><br><br><br><br><br><br><br><br><br>";
	echo "<p class=\"articles error\"><strong>Le mot de passe ne correspond pas au compte... retente donc l'ami !</strong></p>";
	echo "<p class=\"articles\"><a href=\"index.php\"><input class=\"suscribe_input\" type=\"submit\" name=\"submit\" value=\"connection\" /></a></p>";
}
else
{
	echo "<br><br><br><br><br><br<br><br><br><br><br><br><br><br><br><br><br><br>";
	echo "<p class=\"articles error\"><strong>\"".$_POST['pseudo']."\", tu n'as pas les droits d'admin</strong></p>";
	echo "<p class=\"articles\"><a href=\"../index.php\"><input class=\"suscribe_input\" type=\"submit\" name=\"submit\" value=\"Boutique\" /></a></p>";
}
?>
			</div>
		</div>
	</body>
</html>
