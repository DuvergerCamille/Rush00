<?PHP
session_start();
include("../install.php");
if (!$_SESSION['pseudo'])
	$connection = 1;
else
{
	$connection = 2;
	$modif = 1;
	if (isset($_POST['prod']) && isset($_POST['catego']) && isset($_POST['submit']))
	{
		$modif = 2;
		$del = 1;
		$del2 = 1;
		$resultat = mysqli_query($_SESSION['mysqli'], 'SELECT * FROM familles');
		while($donnees = mysqli_fetch_assoc($resultat))
		{
			if ($donnees['famille'] === $_POST['catego'])
			{
				$id_cat = $donnees['id_famille'];
				$del = 2;
			}
		}
		mysqli_free_result($resultat);
		$resultat = mysqli_query($_SESSION['mysqli'], 'SELECT * FROM instruments');
		while($donnees = mysqli_fetch_assoc($resultat))
		{
			if ($donnees['instrument'] === $_POST['prod'])
			{
				$id_prod = $donnees['id_instru'];
				$del2 = 2;
			}
			if ($donnees['partoche'] === $_POST['prod'])
			{
				$id_prod = $donnees['id_instru'];
				$del = 2;
			}
		}
		mysqli_free_result($resultat);
		if (($del === 2) && ($del2 === 2))
		{
			$req_pre = mysqli_prepare($_SESSION['mysqli'], 'INSERT INTO link_tabs (id_famille, id_instru) VALUES (?, ?)');
			mysqli_stmt_bind_param($req_pre, "ii", $id_cat, $id_prod);
			mysqli_stmt_execute($req_pre);
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
	if (($modif === 2) && ($del === 2) && ($del2 === 2))
		echo "<br><p class=\"articles\">L'assignation a été faite.</p>";
	else
		echo "<br><p class=\"articles error\"><strong>Toutes les données ne correspondaient ou pas a la base de données ou bien étaient inexistantes.</strong></p>";
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
