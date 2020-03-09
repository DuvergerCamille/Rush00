<?PHP
session_start();
include("../install.php");
if (!isset($_SESSION['pseudo']))
	$connection = 1;
else
{
	$connection = 2;
	$formular = 1;
	if (isset($_POST['del_prod']) || isset($_POST['new_inst']) || isset($_POST['old_prod']) || isset($_POST['prod']))
	{
		$formular = 2;
		if (isset($_POST['del_prod']))
			$req = 1;
		if (isset($_POST['new_inst']))
			$req = 2;
		if (isset($_POST['old_prod']))
			$req = 3;
		if (isset($_POST['prod']))
			$req = 4;
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
			$resultat = mysqli_query($_SESSION['mysqli'], 'SELECT * FROM instruments');
			while($donnees = mysqli_fetch_assoc($resultat))
			{
				if ($donnees['instrument'] === $_POST['del_prod'])
				{
					$id_prod = $donnees['id_intru'];
					$del = 2;
				}
				if($donnees['partoche'] === $_POST['del_prod'])
				{
					$id_prod = $donnees['id_intru'];
					$del = 3;
				}
			}
			mysqli_free_result($resultat);
			if (($del === 2) || ($del === 3))
			{
				if ($del === 2)
					$resultat2 = mysqli_query($_SESSION['mysqli'], "DELETE FROM instruments WHERE `instruments`.`instrument` = '$_POST[del_prod]'");
				else if ($del === 3)
					$resultat2 = mysqli_query($_SESSION['mysqli'], "DELETE FROM instruments WHERE `instruments`.`partoche` = '$_POST[del_prod]'");
				$resultat2 = mysqli_query($_SESSION['mysqli'], "DELETE FROM link_tabs WHERE id_intru='$id_prod'");
				echo "<p class=\"articles\"><strong>Ligne d'articles supprimée !</strong></p>";
			}
			else
				echo "<p class=\"articles error\"><strong>Le nom donné n'est pas dans la base de données!</strong></p>";
		}
		else if ($req === 2)
		{
			if (isset($_POST['new_inst']) && isset($_POST['new_prix_inst']) && isset($_POST['new_ptn']) && isset($_POST['new_prix_ptn']))
			{
				if (is_numeric($_POST['new_prix_inst']) && is_numeric($_POST['new_prix_ptn']) && ($_POST['new_prix_inst'] > 0) && ($_POST['new_prix_ptn'] > 0))
				{
					$resultat = mysqli_query($_SESSION['mysqli'], 'SELECT * FROM instruments');
					while($donnees = mysqli_fetch_assoc($resultat))
					{
						if (($donnees['instrument'] === $_POST['new_inst']) || ($donnees['instrument'] === $_POST['new_ptn']) || ($donnees['partoche'] === $_POST['new_ptn']) || ($donnees['partoche'] === $_POST['new_inst']))
							$_POST['error_pseudo'] = 9;
					}
					mysqli_free_result($resultat);
					if ($_POST['error_pseudo'] !== 9)
					{
						$req_pre = mysqli_prepare($_SESSION['mysqli'], 'INSERT INTO instruments (instrument, partoche, prix_inst, prix_ptn) VALUES (?, ?, ?, ?)');
						mysqli_stmt_bind_param($req_pre, "ssii", $_POST['new_inst'], $_POST['new_ptn'], $_POST['new_prix_inst'], $_POST['new_prix_ptn']);
						mysqli_stmt_execute($req_pre);
					}
				}
				else
					echo "<br><p class=\"articles error\"><strong>Prix erronés.</strong></p>";
			}
			if ($_POST['error_pseudo'] === 9)
			{
				echo "<br><p class=\"articles error\"><strong>Pseudo existant, en changer.</strong></p>";
				echo "<br><p class=\"articles error\"><a href=\"gestion.php?page=prod\"><input class=\"suscribe_input\" type=\"submit\" name=\"submit\" value=\"Recommencer\" /></a></p>";
			}
			else
			{
				echo "<p class=\"articles\"><strong> Ligne d'articles créée.</strong></p><br><p style=\"text-align:center;font-size:20px;\"><a href=\"prod.php\"></a></p>";
			}
		}
		else if ($req === 3)
		{
			$resultat = mysqli_query($_SESSION['mysqli'], 'SELECT * FROM instruments');
			while($donnees = mysqli_fetch_assoc($resultat))
			{
				if (($donnees['instrument'] === $_POST['old_prod']) || ($donnees['partoche'] === $_POST['old_prod']))
					$del = 2;
			}
			mysqli_free_result($resultat);
			if ($del === 2)
			{
				if (isset($_POST['prod_new']) && isset($_POST['old_prod']))
				{
					$modif = TRUE;
					$resultat = mysqli_query($_SESSION['mysqli'], 'SELECT * FROM instruments');
					while($donnees = mysqli_fetch_assoc($resultat))
					{
						if (($donnees['instrument'] === $_POST['prod_new']) || ($donnees['partoche'] === $_POST['prod_new']))
							$_POST['error_pseudo'] = 9;
						if ($donnees['instrument'] === $_POST['old_prod'])
							$cur = 1;
						if ($donnees['partoche'] === $_POST['old_prod'])
							$cur = 2;
					}
					mysqli_free_result($resultat);
					if ($_POST['error_pseudo'] != 9)
					{
						if ($cur === 1)
							mysqli_query($_SESSION['mysqli'], "UPDATE instruments SET instrument='$_POST[prod_new]' WHERE instrument='$_POST[old_prod]'");
						if ($cur === 2)
							mysqli_query($_SESSION['mysqli'], "UPDATE instruments SET partoche='$_POST[prod_new]' WHERE partoche='$_POST[old_prod]'");
					}
					if ($_POST['error_pseudo'] === 9)
						echo "<br><p class=\"articles error\"><strong>Ce nom est deja utilisé.</strong></p>";
					else
						echo "<p class=\"articles\"><strong>La modification a été apportée.</strong></p>";
				}
			}
			else
				echo "<p class=\"articles error\"><strong>Le premier nom n'est pas dans la base de données!</strong></p>";
		}
		else if ($req === 4)
		{
			$resultat = mysqli_query($_SESSION['mysqli'], 'SELECT * FROM instruments');
			while($donnees = mysqli_fetch_assoc($resultat))
			{
				if (($donnees['instrument'] === $_POST['prod']) || ($donnees['partoche'] === $_POST['prod']))
					$del = 2;
			}
			mysqli_free_result($resultat);
			if ($del === 2)
			{
				if (is_numeric($_POST['new_price']) && ($_POST['new_price'] > 0))
				{
					$modif = TRUE;
					$resultat = mysqli_query($_SESSION['mysqli'], 'SELECT * FROM instruments');
					while($donnees = mysqli_fetch_assoc($resultat))
					{
						if ($donnees['instrument'] === $_POST['prod'])
							$cur = 1;
						if ($donnees['partoche'] === $_POST['prod'])
							$cur = 2;
					}
					mysqli_free_result($resultat);
					if ($cur === 1)
						mysqli_query($_SESSION['mysqli'], "UPDATE instruments SET prix_inst='$_POST[new_price]' WHERE instrument='$_POST[prod]'");
					if ($cur === 2)
						mysqli_query($_SESSION['mysqli'], "UPDATE instruments SET prix_ptn='$_POST[new_price]' WHERE partoche='$_POST[prod]'");
					echo "<p class=\"articles\"><strong>La modification a été apportée.</strong></p>";
				}
			}
			else
				echo "<p class=\"articles error\"><strong>Le premier nom n'est pas dans la base de données!</strong></p>";
		}
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
