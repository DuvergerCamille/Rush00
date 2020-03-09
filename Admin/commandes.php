<?PHP
session_start();
include("../install.php");
if (!$_SESSION['pseudo'])
	$connection = 1;
else
{
	$connection = 2;
	$resultat = mysqli_query($_SESSION['mysqli'], 'SELECT * FROM orders');
	$count = 0;
	while($donnees = mysqli_fetch_assoc($resultat))
		$count++;
	mysqli_free_result($resultat);
	$_SESSION['nb_order'] = $count;
	if (isset($_POST['delete_all']))
	{
		$res = mysqli_query($_SESSION['mysqli'], "DELETE FROM orders");
		mysqli_free_result($res);
	}
	else if (isset($_POST['delete']))
	{
		$formular = 1;
		if (isset($_POST['del_order']))
		{
			$formular = 2;
			$del = 1;
			$num = 1;
			if (!is_numeric($_POST['del_order']))
				$num = 2;
			else
			{
				$resultat = mysqli_query($_SESSION['mysqli'], 'SELECT * FROM orders');
				while($donnees = mysqli_fetch_assoc($resultat))
				{
					if ($donnees['id_order'] === $_POST['del_order'])
						$del = 2;
				}
				mysqli_free_result($resultat);
				if ($del === 2)
				{
					$resultat2 = mysqli_query($_SESSION['mysqli'], "DELETE FROM orders WHERE `orders`.`id_order` = '$_POST[del_order]'");
					mysqli_free_result($resultat2);
				}
			}
		}
	}
}
?>
<html>
	<head>
		<title>Admin</title>
		<link rel="stylesheet" href="../miniboutique.css">
	</head>
	<body>
<?PHP
if ($connection === 2)
	include("header.php");
?>
		<div class="center">
<?PHP
if ($connection === 2)
	include("menu.php");
?>
			<div class="boutique">
<?PHP
if ($connection === 2)
{
	if ($formular === 1)
		echo "<p class=\"articles error\"><strong>Il faut choisir la commande a supprimer.</strong></p>";
	if (($del === 1) && ($num === 1))
		echo "<p class=\"articles error\"><strong>Ce numero ne correspond a aucune commande.</strong></p>";
	if ($num === 2)
		echo "<p class=\"articles error\"><strong>Il faut entrer un nombre.</strong></p>";
	if ($count === 0)
	{
		echo "<br><br><br><br><br><br<br><br><br><br><br><br><br><br><br><br><br><br>";
		echo "<p class=\"articles\"><strong>Il n'y a pas de commande en cours!</strong></p>";
	}
	else
	{
		$resultat = mysqli_query($_SESSION['mysqli'], 'SELECT * FROM orders');
		echo "<table>";
		echo "<tr><th>Numéro de la commande</th><th>Pseudo du commanditaire</th><th>produit et quantité</th><th>Total commande</th></tr>";
		while($donnees = mysqli_fetch_assoc($resultat))
		{
			echo "<tr>";
			echo "<td><p style=\"text-align:center;\">".$donnees['id_order']."</p></td>";
			echo "<td><p style=\"text-align:center;\">".$donnees['pseudo']."</p></td>";
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
	if ($count > 0)
	{
		echo "<form style=\"text-align:center;\" method=\"POST\" action=\"commandes.php\">";
		echo "<p class=\"articles\">Numéro de la commande a supprimer: <input type=\"text\" name=\"del_order\" value=\"\" /> <input class=\"suscribe_input_extra\" type=\"submit\" name=\"delete\" value=\"supprimer une commande\"></p>";
		echo "<p class=\"articles\"><input class=\"suscribe_input_medium\" type=\"submit\" name=\"delete_all\" value=\"les supprimer toutes\"></p>";
		echo "</form>";
	}
}
else
{
	echo "<br><br><br><br><br><br<br><br><br><br><br><br><br><br><br><br><br><br>";
	echo "<p class=\"articles error\"><strong>Tu n'es pas connecté !</strong></p>";
}
?>
			</div>
		</div>
	</body>
</html>
