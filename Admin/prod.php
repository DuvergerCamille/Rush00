<?PHP
session_start();
include("../install.php");
if (!$_SESSION['pseudo'])
	$connection = 1;
else
{
	$connection = 2;
	$formular = 1;
	if (isset($_POST['show']) || isset($_POST['delete']) || isset($_POST['delete_all']) || isset($_POST['add']) || isset($_POST['edit']) || isset($_POST['join']))
	{
		$formular = 2;
		if (isset($_POST['show']))
			$req = 1;
		if (isset($_POST['delete']))
			$req = 2;
		if (isset($_POST['delete_all']))
			$req = 3;
		if (isset($_POST['add']))
			$req = 4;
		if (isset($_POST['edit']))
			$req = 5;
		if (isset($_POST['join']))
			$req = 6;
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
	if ($formular === 2)
	{
		if ($req === 1)
		{
			$resultat = mysqli_query($_SESSION['mysqli'], 'SELECT * FROM instruments');
			echo "<table>";
			echo "<tr><th>Instrument</th><th>prix instrument</th><th>Partition</th><th>prix partition</th></tr>";
			while($donnees = mysqli_fetch_assoc($resultat))
			{
				echo "<tr>";
				echo "<td><p style=\"text-align:center;\">".$donnees['instrument']."</p></td>";
				echo "<td><p style=\"text-align:center;\">".$donnees['prix_inst']." $</p></td>";
				echo "<td><p style=\"text-align:center;\">".$donnees['partoche']."</p></td>";
				echo "<td><p style=\"text-align:center;\">".$donnees['prix_ptn']." $</p></td>";
				echo "</tr>";
			}
			mysqli_free_result($resultat);
			echo "</table>";
		}
		else if ($req === 2)
			echo "<form action=\"result_prod.php\" method=\"POST\" class=\"suscribe\">Nom de la ligne d'articles a supprimer: <input type=\"text\" name=\"del_prod\" value=\"\" /><br /><input class=\"suscribe_input\" type=\"submit\" name=\"delete\" value=\"supprimer\" /></form>";
		else if ($req === 3)
		{
			$res = mysqli_query($_SESSION['mysqli'], "DELETE FROM instruments");
			mysqli_free_result($res);
			$res = mysqli_query($_SESSION['mysqli'], "DELETE FROM link_tabs");
			mysqli_free_result($res);
			echo "<p class=\"articles\"><strong>Tous les articles ont bien été supprimés !</strong></p>";
		}
		else if ($req === 4)
			echo "<form action=\"result_prod.php\" method=\"POST\" class=\"suscribe\">Nom instrument: <input type=\"text\" name=\"new_inst\" value=\"\" /><br />Prix instrument: <input type=\"text\" name=\"new_prix_inst\" value=\"\" /><br />Nom partition: <input type=\"text\" name=\"new_ptn\" value=\"\" /><br />Prix partition: <input type=\"text\" name=\"new_prix_ptn\" value=\"\" /><br /><input class=\"suscribe_input\" type=\"submit\" name=\"submit\" value=\"créer\" /></form>";
		else if ($req === 5)
		{
			echo "<form style=\"text-align:center;\" method=\"POST\" action=\"result_prod.php\"><p class=\"articles\"><strong>Nom actuel du produit:</strong> <input style=\"width:100px;height:40px;\" type=\"text\" name=\"old_prod\" value=\"\"><strong> Nouveau:</strong> <input style=\"width:100px;height:40px;\" type=\"text\" name=\"prod_new\" value=\"\"> <input class=\"suscribe_input\" type=\"submit\" name=\"submit\" value=\"Modifier\"></p></form>";
			echo "<form style=\"text-align:center;\" method=\"POST\" action=\"result_prod.php\"><p class=\"articles\"><strong>Nom du produit:</strong> <input style=\"width:100px;height:40px;\" type=\"text\" name=\"prod\" value=\"\"><strong> Nouveau prix:</strong> <input style=\"width:100px;height:40px;\" type=\"text\" name=\"new_price\" value=\"\"> <input class=\"suscribe_input\" type=\"submit\" name=\"submit\" value=\"Modifier\"></p></form>";
		}
		else if ($req === 6)
		{
			echo "<form style=\"text-align:center;\" method=\"POST\" action=\"assigner.php\"><p class=\"articles\"><strong>Nom du produit:</strong> <input style=\"width:100px;height:40px;\" type=\"text\" name=\"prod\" value=\"\"><strong> Nom de la catégorie:</strong> <input style=\"width:100px;height:40px;\" type=\"text\" name=\"catego\" value=\"\"> <input class=\"suscribe_input\" type=\"submit\" name=\"submit\" value=\"Assigner\"></p></form>";
		}
	}
	else
	{
		echo "<br><br><br><br><br><br<br><br><br><br><br><br><br><br><br><br><br><br>";
		echo "<p class=\"articles error\"><strong>Formulaire non rempli</strong></p>";
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
