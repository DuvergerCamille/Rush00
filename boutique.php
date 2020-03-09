<?PHP
session_start();
include("install.php");
if (!$_GET['page'])
	$_GET['page'] = 42;
else
{
	if ($_GET['page'] == "sheet")
		$req = 1;
	else if ($_GET['page'] == "instru")
		$req = 2;
	else
		$req = 3;
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
if ($_GET['page'] === 42)
{
	echo "<br><br><br><br><br><br<br><br><br><br><br><br><br><br><br><br><br><br>";
	echo "<strong><p class=\"articles error\">Tu as touché a mon URL fripon de luron ! Rechante-le et je te donnerai les informations que tu cherches !</p></strong>";
}
else
{
	$count = 0;
	if ($req === 1)
	{
		$resultat = mysqli_query($_SESSION['mysqli'], 'SELECT partoche, prix_ptn FROM instruments');
		while($donnees = mysqli_fetch_assoc($resultat))
		{
			echo "<br><form style=\"text-align:center;\" method=\"POST\" action=\"panier.php?article=".$donnees['partoche']."\"><p class=\"articles\"><strong>Partition: </strong><a class=\"black\" href=\"panier.php?article=".$donnees['partoche']."\">".$donnees['partoche']."</a><strong> Prix: </strong>".$donnees['prix_ptn']."$ Quantité: <input style=\"width:40px;height:40px;\" type=\"text\" name=\"qnt\" value=\"\"> <input class=\"suscribe_input\" type=\"submit\" name=\"submit\" value=\"Valider\"></p></form>";
			$count++;
		}
		mysqli_free_result($resultat);
		if ($count === 0)
			echo "<br><p class=\"articles error\"><strong>Il n'y a pas de produits ici.</strong></p>";
	}
	else if ($req === 2)
	{
		$resultat = mysqli_query($_SESSION['mysqli'], 'SELECT instrument, prix_inst FROM instruments');
		while($donnees = mysqli_fetch_assoc($resultat))
		{
			echo "<br><form style=\"text-align:center;\" method=\"POST\" action=\"panier.php?article=".$donnees['instrument']."\"><p class=\"articles\"><strong>Instrument: </strong><a class=\"black\" href=\"panier.php?article=".$donnees['instrument']."\">".$donnees['instrument']."</a><strong> Prix: </strong>".$donnees['prix_inst']."$ Quantité: <input style=\"width:40px;height:40px;\" type=\"text\" name=\"qnt\" value=\"\"> <input class=\"suscribe_input\" type=\"submit\" name=\"submit\" value=\"Valider\"></p></form>";
			$count++;
		}
		mysqli_free_result($resultat);
		if ($count === 0)
			echo "<br><p class=\"articles error\"><strong>Il n'y a pas de produits ici.</strong></p>";
	}
	else if ($req === 3)
	{
		$valid = FALSE;
		$resultat = mysqli_query($_SESSION['mysqli'], 'SELECT famille FROM familles');
		while($donnees = mysqli_fetch_assoc($resultat))
		{
			if ($_GET['page'] == $donnees['famille'])
				$valid = TRUE;
		}
		mysqli_free_result($resultat);
		if ($valid === TRUE)
		{
			$resultat = mysqli_query($_SESSION['mysqli'], "SELECT * FROM `familles` WHERE `famille` = '$_GET[page]'");
			while($donnees = mysqli_fetch_assoc($resultat))
				$fram = $donnees['id_famille'];
			mysqli_free_result($resultat);
			$resultat = mysqli_query($_SESSION['mysqli'], "SELECT id_instru FROM `link_tabs` WHERE `id_famille` = '$fram' ");
			$i = 0;
			while($donnees = mysqli_fetch_assoc($resultat))
			{
				$tab[$i] = $donnees['id_instru'];
				$i++;
			}
			mysqli_free_result($resultat);
			$j = 0;
			while ($j < $i)
			{
				$fram = $tab[$j];
				$resultat = mysqli_query($_SESSION['mysqli'], "SELECT * FROM `instruments` WHERE `id_instru` = '$fram' ");
				while($donnees = mysqli_fetch_assoc($resultat))
				{
					echo "<br><form style=\"text-align:center;\" method=\"POST\" action=\"panier.php?article=".$donnees['instrument']."\"><p class=\"articles\"><strong>Instrument: </strong><a class=\"black\" href=\"panier.php?article=".$donnees['instrument']."\">".$donnees['instrument']."</a><strong> Prix: </strong>".$donnees['prix_inst']."$ Quantité: <input style=\"width:40px;height:40px;\" type=\"text\" name=\"qnt\" value=\"\"> <input class=\"suscribe_input\" type=\"submit\" name=\"submit\" value=\"Valider\"></p></form>";
					echo "<br><form style=\"text-align:center;\" method=\"POST\" action=\"panier.php?article=".$donnees['partoche']."\"><p class=\"articles\"><strong>Partition: </strong><a class=\"black\" href=\"panier.php?article=".$donnees['partoche']."\">".$donnees['partoche']."</a><strong> Prix: </strong>".$donnees['prix_ptn']."$ Quantité: <input style=\"width:40px;height:40px;\" type=\"text\" name=\"qnt\" value=\"\"> <input class=\"suscribe_input\" type=\"submit\" name=\"submit\" value=\"Valider\"></p></form>";
					$count++;
				}
				mysqli_free_result($resultat);
				$j++;
			}
			if ($count === 0)
				echo "<br><p class=\"articles error\"><strong>Il n'y a pas de produits ici.</strong></p>";
		}
		else
		{
			echo "<br><br><br><br><br><br<br><br><br><br><br><br><br><br><br><br><br><br>";
			echo "<strong><p class=\"articles error\">Tu as touché a mon URL fripon de luron ! Rechante-le et je te donnerai les informations que tu cherches !</p></strong>";
		}
	}
}
?>
			</div>
		</div>
	</body>
</html>
