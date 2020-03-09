<?PHP
session_start();
include("../install.php");
if (!$_SESSION['pseudo'])
	$connection = 1;
else
{
	$connection = 2;
	$formular = 1;
	if (isset($_POST['show']) || isset($_POST['delete']) || isset($_POST['delete_all']) || isset($_POST['add']) || isset($_POST['edit']) || isset($_POST['admin']))
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
		if (isset($_POST['admin']))
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
			$resultat = mysqli_query($_SESSION['mysqli'], 'SELECT * FROM users');
			echo "<table>";
			echo "<tr><th>Pseudo</th><th>Email</th></tr>";
			while($donnees = mysqli_fetch_assoc($resultat))
			{
				echo "<tr>";
				echo "<td><p style=\"text-align:center;\">".$donnees['pseudo']."</p></td>";
				echo "<td><p style=\"text-align:center;\">".$donnees['email']."</p></td>";
				echo "</tr>";
			}
			mysqli_free_result($resultat);
			echo "</table>";
		}
		else if ($req === 2)
			echo "<form action=\"result_clients.php\" method=\"POST\" class=\"suscribe\">Identifiant du client a supprimer: <input type=\"text\" name=\"del_pseudo\" value=\"\" /><br /><input class=\"suscribe_input\" type=\"submit\" name=\"delete\" value=\"supprimer\" /></form>";
		else if ($req === 3)
		{
			$res = mysqli_query($_SESSION['mysqli'], "DELETE FROM orders");
			mysqli_free_result($res);
			$resultat = mysqli_query($_SESSION['mysqli'], "DELETE FROM users");
			mysqli_free_result($resultat);
			echo "<p class=\"articles\"><strong>Tous les comptes clients et leurs commandes associées ont bien été supprimés !</strong></p>";
		}
		else if ($req === 4)
			echo "<form action=\"result_clients.php\" method=\"POST\" class=\"suscribe\">Identifiant: <input type=\"text\" name=\"new_pseudo\" value=\"\" /><br />Mot de passe: <input type=\"password\" name=\"new_pwd\" value=\"\" /><br />Email: <input type=\"text\" name=\"new_email\" value=\"\" /><br /><input class=\"suscribe_input\" type=\"submit\" name=\"submit\" value=\"inscrire\" /></form>";
		else if ($req === 5)
		{
			echo "<form style=\"text-align:center;\" method=\"POST\" action=\"result_clients.php\"><p class=\"articles\"><strong>Pseudo actuel:</strong> <input style=\"width:100px;height:40px;\" type=\"text\" name=\"old_pseudo\" value=\"\"><strong> Nouveau:</strong> <input style=\"width:100px;height:40px;\" type=\"text\" name=\"pseudo_new\" value=\"\"> <input class=\"suscribe_input\" type=\"submit\" name=\"submit\" value=\"Modifier\"></p></form>";
			echo "<form style=\"text-align:center;\" method=\"POST\" action=\"result_clients.php\"><p class=\"articles\"><strong>email actuel:</strong> <input style=\"width:100px;height:40px;\" type=\"text\" name=\"old_email\" value=\"\"><strong> Nouveau:</strong> <input style=\"width:100px;height:40px;\" type=\"text\" name=\"email_new\" value=\"\"> <input class=\"suscribe_input\" type=\"submit\" name=\"submit\" value=\"Modifier\"></p></form>";
			echo "<form style=\"text-align:center;\" method=\"POST\" action=\"result_clients.php\"><p class=\"articles\"><strong> Pseudo:</strong> <input style=\"width:100px;height:40px;\" type=\"text\" name=\"pseudo\" value=\"\"><strong> Nouveau mot de passe:</strong> <input style=\"width:100px;height:40px;\" type=\"password\" name=\"pwd_new\" value=\"\"> <input class=\"suscribe_input\" type=\"submit\" name=\"submit\" value=\"Modifier\"></p></form>";
		}
		else if ($req === 6)
			echo "<form style=\"text-align:center;\" method=\"POST\" action=\"result_clients.php\"><p class=\"articles\"><strong>Pseudo:</strong> <input style=\"width:100px;height:40px;\" type=\"text\" name=\"pseudo_admin\" value=\"\"> <input class=\"suscribe_input\" type=\"submit\" name=\"submit\" value=\"Admin\"></p></form>";
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
