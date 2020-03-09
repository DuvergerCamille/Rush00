<?PHP
session_start();
include("install.php");
if (isset($_SESSION['pseudo']))
	$connect = 1;
else
	$connect = 2;
if (isset($_POST['pseudo']) && isset($_POST['pwd']) && isset($_POST['submit']))
{
	$_POST['pwd'] = hash('whirlpool', $_POST['pwd']);
	$connection = 0;
	$resultat = mysqli_query($_SESSION['mysqli'], 'SELECT * FROM users');
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
		<title>Les Clefs en Fêtes</title>
		<link rel="stylesheet" href="miniboutique.css">
	</head>
	<body>
		<?PHP include("header.php");?>
		<div class="center">
			<?PHP include("menu.php");?>
			<div class="boutique">
<?PHP
if ($connect == 2)
{
	if ($connection === 1)
	{
		echo "<br><br><br><br><br><br<br><br><br><br><br><br><br><br><br><br><br><br>";
		echo "<p class=\"articles\"><strong>Bon retour parmi nous luron ".$_SESSION['pseudo']." !</strong></p>";
		echo "<p class=\"articles\"><a href=\"boutique.php?page=instru\"><input class=\"suscribe_input\" type=\"submit\" name=\"submit\" value=\"boutique\" /></a></p>";
	}
	else if ($connection === 2)
	{
		echo "<br><br><br><br><br><br<br><br><br><br><br><br><br><br><br><br><br><br>";
		echo "<p class=\"articles error\"><strong>Le mot de passe ne correspond pas au compte... retente donc l'ami !</strong></p>";
		echo "<p class=\"articles\"><a href=\"index.php\"><input class=\"suscribe_input\" type=\"submit\" name=\"submit\" value=\"accueil\" /></a></p>";
	}
	else
	{
		echo "<br><br><br><br><br><br<br><br><br><br><br><br><br><br><br><br><br><br>";
		echo "<p class=\"articles error\"><strong>Je ne connais malheureusement aucun \"".$_POST['pseudo']."\"... inscris-toi donc l'ami !</strong></p>";
		echo "<p class=\"articles\"><a href=\"inscription.php\"><input class=\"suscribe_input\" type=\"submit\" name=\"submit\" value=\"s'incrire\" /></a></p>";
	}
}
else
{
	echo "<br><br><br><br><br><br<br><br><br><br><br><br><br><br><br><br><br><br>";
	echo "<p class=\"articles error\"><strong>Je ne peux pas connecter quelqu'un qui l'est deja !</strong></p>";
}

?>
			</div>
		</div>
	</body>
</html>
