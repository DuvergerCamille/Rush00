<?PHP
session_start();
include("install.php");
$way = 1;
if (isset($_SESSION['pseudo']))
{
	$resultat = mysqli_query($_SESSION['mysqli'], 'SELECT * FROM orders');
	while($donnees = mysqli_fetch_assoc($resultat))
	{
		if ($_SESSION['pseudo'] === $donnees['pseudo'])
			$way = 2;
	}
	mysqli_free_result($resultat);
	$cmd = 1;
	if (isset($_POST['show']))
		$cmd = 2;
}
if ($way === 1)
{
	if (isset($_GET['article']))
	{
		$valid = FALSE;
		$resultat = mysqli_query($_SESSION['mysqli'], 'SELECT instrument, partoche FROM instruments');
		while($donnees = mysqli_fetch_assoc($resultat))
		{
			if (($_GET['article'] == $donnees['instrument']) || ($_GET['article'] == $donnees['partoche']))
				$valid = TRUE;
		}
		mysqli_free_result($resultat);
		if ($valid === TRUE && (!isset($_SESSION[$_GET['article']])))
			$_SESSION[$_GET['article']] = 1;
		if (isset($_POST['submit']) && isset($_POST['qnt']))
		{
			if (is_numeric($_POST['qnt']))
			{
				if ($_POST['qnt'] >= 1)
					$_SESSION[$_GET['article']] = $_POST['qnt'];
			}
		}
		if (isset($_POST['delete']))
			unset($_SESSION[$_GET['article']]);
	}
	if (isset($_POST['delete_all']))
	{
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
	}
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
$resultat = mysqli_query($_SESSION['mysqli'], 'SELECT * FROM instruments');
$count = 0;
$price = 0;
while($donnees = mysqli_fetch_assoc($resultat))
{
	if (($_SESSION[$donnees['instrument']] >= 1) || ($_SESSION[$donnees['partoche']] >= 1))
	{
		if ($_SESSION[$donnees['instrument']] >= 1)
		{
			$res = $_SESSION[$donnees['instrument']] * $donnees['prix_inst'];
			echo "<form style=\"text-align:center;\" method=\"POST\" action=\"panier.php?article=".$donnees['instrument']."\"><p class=\"articles\">".$_SESSION[$donnees['instrument']]." x ".$donnees['instrument']."<strong> Prix: </strong>".$res."$ Quantité: <input style=\"width:40px;height:40px;\" type=\"text\" name=\"qnt\" value=\"\"> <input class=\"suscribe_input\" type=\"submit\" name=\"submit\" value=\"Valider\"> <input class=\"suscribe_input\" type=\"submit\" name=\"delete\" value=\"Supprimer\"></p></form>";
			$price = $price + $res;
			$count = $count + $_SESSION[$donnees['instrument']];
		}
		if ($_SESSION[$donnees['partoche']] >= 1)
		{
			$res = $_SESSION[$donnees['partoche']] * $donnees['prix_ptn'];
			echo "<form style=\"text-align:center;\" method=\"POST\" action=\"panier.php?article=".$donnees['partoche']."\"><p class=\"articles\">".$_SESSION[$donnees['partoche']]." x ".$donnees['partoche']."<strong> Prix: </strong>".$res."$ Quantité: <input style=\"width:40px;height:40px;\" type=\"text\" name=\"qnt\" value=\"\"> <input class=\"suscribe_input\" type=\"submit\" name=\"submit\" value=\"Valider\"> <input class=\"suscribe_input\" type=\"submit\" name=\"delete\" value=\"Supprimer\"></p></form>";
			$price = $price + $res;
			$count = $count + $_SESSION[$donnees['partoche']];
		}
	}
}
mysqli_free_result($resultat);
if ($count !== 0)
{
	$_SESSION['panier'] = $price;
	echo "<p class=\"articles\">Tu as $count articles dans ton panier, d'une valeur de ".$price."$, joyeux luron ! <a href=\"result_commande.php\"><input class=\"suscribe_input\" type=\"submit\" name=\"submit\" value=\"Commande\" /></a></p>";
	echo "<form style=\"text-align:center;\" method=\"POST\" action=\"panier.php\"><p class=\"articles\"><input class=\"suscribe_input\" type=\"submit\" name=\"delete_all\" value=\"Vider\"></p></form>";
}
else
{
	if ($way === 2)
	{
		if ($cmd === 1)
		{
			echo "<br><br><br><br><br><br<br><br><br><br><br><br><br><br><br><br><br><br>";
			echo "<p class=\"articles error\"><strong>Tu as deja une commande en cours jeune luron !</strong></p>";
			echo "<form style=\"text-align:center;\" method=\"POST\" action=\"panier.php\">";
			echo "<p class=\"articles\"><input class=\"suscribe_input_extra\" type=\"submit\" name=\"show\" value=\"voir la commande\"></p>";
			echo "</form>";
		}
		else
		{
			$resultat = mysqli_query($_SESSION['mysqli'], "SELECT * FROM orders WHERE pseudo='$_SESSION[pseudo]'");
			echo "<table>";
			echo "<tr><th>Numéro de la commande</th><th>produit et quantité</th><th>Total commande</th></tr>";
			while($donnees = mysqli_fetch_assoc($resultat))
			{
				echo "<tr>";
				echo "<td><p style=\"text-align:center;\">".$donnees['id_order']."</p></td>";
				echo "<td>";
				$order = $donnees['commande'];
				$tab = explode(";",$order);
				$i = 0;
				while ($tab[$i])
				{
					echo "<p style=\"text-align:center;\">".$tab[$i]." X ".$tab[$i + 1]."</p>";
					$i = $i + 2;
				}
				echo "</td>";
				echo "<td><p style=\"text-align:center;\">".$donnees['total_panier']." $</p></td>";
				echo "</tr>";
			}
			mysqli_free_result($resultat);
			echo "</table>";
		}
	}
	else
	{
		echo "<br><br><br><br><br><br<br><br><br><br><br><br><br><br><br><br><br><br>";
		echo "<p class=\"articles\"><strong>Il n'y a rien dans ton panier pour le moment jeune luron !</strong></p>";
	}
}
?>
			</div>
		</div>
	</body>
</html>
