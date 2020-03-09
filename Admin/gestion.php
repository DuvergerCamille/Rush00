<?PHP
session_start();
include("../install.php");
if (!$_SESSION['pseudo'])
	$connection = 1;
else
{
	$connection = 2;
	if (!$_GET['page'])
		$_GET['page'] = 42;
	else
	{
		if ($_GET['page'] === "clients")
			$req = 1;
		else if ($_GET['page'] === "catego")
			$req = 2;
		else if ($_GET['page'] === "prod")
			$req = 3;
		else
			$_GET['page'] = 42;
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
	if ($_GET['page'] === 42)
	{
		echo "<br><br><br><br><br><br<br><br><br><br><br><br><br><br><br><br><br><br>";
		echo "<strong><p class=\"articles error\">Tu as touché a l'URL je ne peux pas te donner les informations que tu cherches !</p></strong>";
	}
	else
	{
		if ($req === 1)
		{
			echo "<form style=\"text-align:center;\" method=\"POST\" action=\"clients.php\">";
			echo "<p class=\"articles\"><input class=\"suscribe_input\" type=\"submit\" name=\"show\" value=\"liste clients\"></p>";
			echo "<p class=\"articles\"><input class=\"suscribe_input_medium\" type=\"submit\" name=\"delete\" value=\"supprimer un client\"></p>";
			echo "<p class=\"articles\"><input class=\"suscribe_input_medium\" type=\"submit\" name=\"delete_all\" value=\"supprimer les clients\"></p>";
			echo "<p class=\"articles\"><input class=\"suscribe_input_long\" type=\"submit\" name=\"add\" value=\"ajouter un client\"></p>";
			echo "<p class=\"articles\"><input class=\"suscribe_input_long\" type=\"submit\" name=\"edit\" value=\"modifier un client\"></p>";
			echo "<p class=\"articles\"><input class=\"suscribe_input_extra\" type=\"submit\" name=\"admin\" value=\"donner les droits d'admin\"></p>";
			echo "</form>";
		}
		else if ($req === 2)
		{
			echo "<form style=\"text-align:center;\" method=\"POST\" action=\"catego.php\">";
			echo "<p class=\"articles\"><input class=\"suscribe_input_medium\" type=\"submit\" name=\"show\" value=\"liste catégories\"></p>";
			echo "<p class=\"articles\"><input class=\"suscribe_input_medium\" type=\"submit\" name=\"delete\" value=\"en supprimer une\"></p>";
			echo "<p class=\"articles\"><input class=\"suscribe_input_medium\" type=\"submit\" name=\"delete_all\" value=\"les supprimer toutes\"></p>";
			echo "<p class=\"articles\"><input class=\"suscribe_input_long\" type=\"submit\" name=\"add\" value=\"en ajouter une\"></p>";
			echo "<p class=\"articles\"><input class=\"suscribe_input_long\" type=\"submit\" name=\"edit\" value=\"en modifier une\"></p>";
			echo "<p class=\"articles\"><input class=\"suscribe_input_long\" type=\"submit\" name=\"join\" value=\"assigner\"></p>";
			echo "</form>";
		}
		else if ($req === 3)
		{
			echo "<form style=\"text-align:center;\" method=\"POST\" action=\"prod.php\">";
			echo "<p class=\"articles\"><input class=\"suscribe_input\" type=\"submit\" name=\"show\" value=\"liste produits\"></p>";
			echo "<p class=\"articles\"><input class=\"suscribe_input_medium\" type=\"submit\" name=\"delete\" value=\"en supprimer un\"></p>";
			echo "<p class=\"articles\"><input class=\"suscribe_input_medium\" type=\"submit\" name=\"delete_all\" value=\"les supprimer tous\"></p>";
			echo "<p class=\"articles\"><input class=\"suscribe_input_long\" type=\"submit\" name=\"add\" value=\"en ajouter un\"></p>";
			echo "<p class=\"articles\"><input class=\"suscribe_input_long\" type=\"submit\" name=\"edit\" value=\"en modifier un\"></p>";
			echo "<p class=\"articles\"><input class=\"suscribe_input_long\" type=\"submit\" name=\"join\" value=\"assigner\"></p>";
			echo "</form>";
		}
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
