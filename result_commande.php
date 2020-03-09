<?PHP
session_start();
include("install.php");
//debut de remplissage de donnees dans orders
$resultat = mysqli_query($_SESSION['mysqli'], 'SELECT * FROM instruments');
while($donnees = mysqli_fetch_assoc($resultat))
{
	if (($_SESSION[$donnees['instrument']] >= 1) || ($_SESSION[$donnees['partoche']] >= 1))
	{
		if ($_SESSION[$donnees['instrument']] >= 1)
			$run = $run.$_SESSION[$donnees['instrument']].";".$donnees['instrument'].";";
		if ($_SESSION[$donnees['partoche']] >= 1)
			$run = $run.$_SESSION[$donnees['partoche']].";".$donnees['partoche'].";";
	}
}
mysqli_free_result($resultat);
$req_pre = mysqli_prepare($_SESSION['mysqli'], 'INSERT INTO orders (pseudo, commande, total_panier) VALUES (?, ?, ?)');
mysqli_stmt_bind_param($req_pre, "ssi", $_SESSION['pseudo'], $run, $_SESSION['panier']);
mysqli_stmt_execute($req_pre);
$resultat = mysqli_query($_SESSION['mysqli'], 'SELECT * FROM instruments');
while($donnees = mysqli_fetch_assoc($resultat))
{
	if (($_SESSION[$donnees['instrument']] >= 1) || ($_SESSION[$donnees['partoche']] >= 1))
	{
		if ($_SESSION[$donnees['instrument']] >= 1)
			unset($_SESSION[$donnees['instrument']]);
		if ($_SESSION[$donnees['partoche']] >= 1)
			unset($_SESSION[$donnees['partoche']]);
	}
}
mysqli_free_result($resultat);
$_SESSION['panier'] = 0;
//fin de remplissage de donnees dans orders
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
if (isset($_SESSION['pseudo']))
{
	echo "<br><br><br><br><br><br<br><br><br><br><br><br><br><br><br><br><br><br>";
	echo "<p class=\"articles\"><strong>Commande passée !</strong></p>";
}
else
{
	echo "<br><br><br><br><br><br<br><br><br><br><br><br><br><br><br><br><br><br>";
	echo "<br><p class=\"articles error\"><strong>Il faut d'abord te connecter pour passer commande !</strong></p>";
}
?>
			</div>
		</div>
	</body>
</html>
