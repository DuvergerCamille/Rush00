<?PHP
session_start();
include("../install.php");
if (!isset($_SESSION['pseudo']))
	$connection = 1;
else
{
	$connection = 2;
	$formular = 1;
	if (isset($_POST['del_cate']) || isset($_POST['new_catego']) || isset($_POST['old_name']))
	{
		$formular = 2;
		if (isset($_POST['del_cate']))
			$req = 1;
		if (isset($_POST['new_catego']))
			$req = 2;
		if (isset($_POST['old_name']))
			$req = 3;
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
		$modif = FALSE;
		$del = 1;
		if ($req === 1)
		{
			$resultat = mysqli_query($_SESSION['mysqli'], 'SELECT * FROM familles');
			while($donnees = mysqli_fetch_assoc($resultat))
			{
				if ($donnees['famille'] === $_POST['del_cate'])
				{
					$id_cat = $donnees['id_famille'];
					$del = 2;
				}
			}
			mysqli_free_result($resultat);
			if ($del === 2)
			{
				$resultat2 = mysqli_query($_SESSION['mysqli'], "DELETE FROM familles WHERE `familles`.`famille` = '$_POST[del_cate]'");
				mysqli_free_result($resultat2);
				$resultat2 = mysqli_query($_SESSION['mysqli'], "DELETE FROM link_tabs WHERE id_famille= '$id_cat'");
				mysqli_free_result($resultat2);
				echo "<p class=\"articles\"><strong>Catégorie supprimée !</strong></p>";
			}
			else
				echo "<p class=\"articles error\"><strong>Le nom donné n'est pas dans la base de données!</strong></p>";
		}
		else if ($req === 2)
		{
			if (isset($_POST['new_catego']))
			{
				$resultat = mysqli_query($_SESSION['mysqli'], 'SELECT * FROM familles');
				while($donnees = mysqli_fetch_assoc($resultat))
				{
					if ($donnees['famille'] === $_POST['new_catego'])
						$_POST['error_pseudo'] = 9;
				}
				mysqli_free_result($resultat);
				if ($_POST['error_pseudo'] !== 9)
				{
					$req_pre = mysqli_prepare($_SESSION['mysqli'], 'INSERT INTO familles (famille) VALUES (?)');
					mysqli_stmt_bind_param($req_pre, "s", $_POST['new_catego']);
					mysqli_stmt_execute($req_pre);
				}
			}
		}
		if ($_POST['error_pseudo'] == 9)
		{
			if ($_POST['error_pseudo'] === 9)
				echo "<br><p class=\"articles error\"><strong>Catégorie existante, en changer.</strong></p>";
			echo "<br><p class=\"articles error\"><a href=\"gestion.php\"><input class=\"suscribe_input\" type=\"submit\" name=\"submit\" value=\"Recommencer\" /></a></p>";
		}
		else
		{
			echo "<p class=\"articles\"><strong> Catégorie ".$_POST['new_catego']." créé.</strong></p><br><p style=\"text-align:center;font-size:20px;\"><a href=\"catego.php\"></a></p>";
		}
	}
	else if ($req === 3)
	{
		$resultat = mysqli_query($_SESSION['mysqli'], 'SELECT * FROM familles');
		while($donnees = mysqli_fetch_assoc($resultat))
		{
			if ($donnees['famille'] === $_POST['old_name'])
				$del = 2;
		}
		mysqli_free_result($resultat);
		if ($del === 2)
		{
			if (isset($_POST['name_new']) && isset($_POST['old_name']))
			{
				$modif = TRUE;
				$resultat = mysqli_query($_SESSION['mysqli'], 'SELECT * FROM familles');
				while($donnees = mysqli_fetch_assoc($resultat))
				{
					if ($donnees['famille'] === $_POST['new_name'])
						$_POST['error_pseudo'] = 9;
				}
				mysqli_free_result($resultat);
				if ($_POST['error_pseudo'] != 9)
					mysqli_query($_SESSION['mysqli'], "UPDATE familles SET famille='$_POST[name_new]' WHERE famille='$_POST[old_name]'");
				if ($_POST['error_pseudo'] === 9)
					echo "<br><p class=\"articles error\"><strong>Cette catégorie est deja utilisée.</strong></p>";
				else
					echo "<p class=\"articles\"><strong>La modification a été apportée.</strong></p>";
			}
		}
		else
			echo "<p class=\"articles error\"><strong>Le premier nom n'est pas dans la base de données!</strong></p>";
	}
	else
	{
		echo "<br><br><br><br><br><br<br><br><br><br><br><br><br><br><br><br><br><br>";
		echo "<p class=\"articles error\"><strong>Formulaire non rempli correctement</strong></p>";
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
