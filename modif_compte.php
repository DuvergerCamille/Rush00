<?PHP
session_start();
include("install.php");
if (isset($_SESSION['pseudo']))
{
	$deleted = 2;
	$del_ord = 2;
	$connected = TRUE;
	if (isset($_POST['pseudo_new']) && isset($_POST['submit']))
	{
		$modif = TRUE;
		(preg_match('/^([a-zA-Z0-9]{2,25})$/', trim($_POST['pseudo_new'])) === 1) ? $_POST['error_pseudo'] = 0: $_POST['error_pseudo'] = 1;
		if ($_POST['error_pseudo'] == 0)
		{
			$resultat = mysqli_query($_SESSION['mysqli'], 'SELECT pseudo FROM users');
			while($donnees = mysqli_fetch_assoc($resultat))
			{
				if ($donnees['pseudo'] === $_POST['new_pseudo'])
					$_POST['error_pseudo'] = 9;
			}
			mysqli_free_result($resultat);
			if ($_POST['error_pseudo'] != 9)
				mysqli_query($_SESSION['mysqli'], "UPDATE users SET pseudo='$_POST[pseudo_new]' WHERE pseudo='$_SESSION[pseudo]'");
		}
	}
	else if (isset($_POST['pwd_new']) && isset($_POST['old_pwd']) && isset($_POST['submit']))
	{
		$modif = TRUE;
		$error = 1;
		(preg_match('/^([a-zA-Z0-9]{2,25})$/', trim($_POST['pwd_new'])) === 1) ? $_POST['error_pwd'] = 0: $_POST['error_pwd'] = 3;
		if ($_POST['error_pwd'] == 0)
		{
			$_POST['pwd_new'] = hash('whirlpool', $_POST['pwd_new']);
			$_POST['old_pwd'] = hash('whirlpool', $_POST['old_pwd']);
			$resultat = mysqli_query($_SESSION['mysqli'], "SELECT pwd FROM users WHERE `pseudo` = '$_SESSION[pseudo]'");
			while($donnees = mysqli_fetch_assoc($resultat))
			{
				if ($_POST['old_pwd'] === $donnees['pwd'])
					$error = 2;
			}
			mysqli_free_result($resultat);
			if ($error === 2)
			{
				$resultat = mysqli_query($_SESSION['mysqli'], "UPDATE `users` SET `pwd` = '$_POST[pwd_new]' WHERE `users`.`pseudo` = '$_SESSION[pseudo]'");
				mysqli_free_result($resultat);
			}
		}
	}
	else if (isset($_POST['email_new']) && isset($_POST['submit']))
	{
		$modif = TRUE;
		(preg_match('/^([\w\.-]+)@([\w\.-]+)(\.[a-z]{2,4})$/',trim($_POST['email_new'])) === 1)? $_POST['error_email'] = 0: $_POST['error_email'] = 7;
		if ($_POST['error_email'] == 0)
		{
			$resultat = mysqli_query($_SESSION['mysqli'], "UPDATE `users` SET `email` = '$_POST[email_new]' WHERE `users`.`pseudo` = '$_SESSION[pseudo]'");
			mysqli_free_result($resultat);
		}
	}
	else if (isset($_POST['delete']))
	{
		$modif = TRUE;
		$deleted = 1;
		$resultat = mysqli_query($_SESSION['mysqli'], 'SELECT * FROM orders');
		while($donnees = mysqli_fetch_assoc($resultat))
		{
			if ($_SESSION['pseudo'] === $donnees['pseudo'])
			{
				$res = mysqli_query($_SESSION['mysqli'], "DELETE FROM orders WHERE `orders`.`pseudo` = '$_SESSION[pseudo]'");
				mysqli_free_result($res);
			}
		}
		mysqli_free_result($resultat);
		$resultat = mysqli_query($_SESSION['mysqli'], "DELETE FROM users WHERE `users`.`pseudo` = '$_SESSION[pseudo]'");
		mysqli_free_result($resultat);
		$_SESSION['pseudo'] = NULL;
	}
	else if (isset($_POST['delete_order']))
	{
		$modif = TRUE;
		$del_ord = 1;
		$resultat = mysqli_query($_SESSION['mysqli'], "DELETE FROM orders WHERE `orders`.`pseudo` = '$_SESSION[pseudo]'");
		mysqli_free_result($resultat);
	}
	else
		$modif = FALSE;
}
else
	$connected = FALSE;
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
if ($connected === TRUE)
{
	if ($modif === TRUE)
	{
		if (($_POST['error_pseudo'] == 1) || ($_POST['error_pwd'] == 3) || ($_POST['error_email'] == 7) || ($_POST['error_pseudo'] == 9) || ($error === 1))
		{
			if ($_POST['error_pseudo'] === 1)
				echo "<br><p class=\"articles error\"><strong>Joyeux luron, ton identifiant ne doit contenir qu'entre 2 et 25 caractères, des lettres (MAJUSCULES ou minuscule) et/ou des chiffres.</strong></p>";
			if ($_POST['error_pwd'] === 3)
				echo "<br><p class=\"articles error\"><strong>Joyeux luron, ton mot de passe ne doit contenir qu'entre 2 et 25 caractères, des lettres (MAJUSCULES ou minuscule) et/ou des chiffres.</strong></p>";
			if ($error === 1)
				echo "<br><p class=\"articles error\"><strong>Joyeux luron, ton mot de passe ne semble pas correspondre.</strong></p>";
			if ($_POST['error_email'] === 7)
				echo "<br><p class=\"articles error\"><strong>Joyeux luron, ton email ne semble pas respecter les normes, viendrais-tu d'un autre monde ?</strong></p>";
			if ($_POST['error_pseudo'] === 9)
				echo "<br><p class=\"articles error\"><strong>Ami luron, un autre joyeux luron semble déjå avoir utilisé cet identifiant, fais preuve d'imagination !</strong></p>";
			echo "<br><p class=\"articles error\"><a href=\"inscription.php\"><input class=\"suscribe_input\" type=\"submit\" name=\"submit\" value=\"inscription\" /></a></p>";
		}
		else if ($deleted === 1)
			echo "<p class=\"articles\"><strong>Luron, ton compte a bien été supprimé !</strong></p><br><p style=\"text-align:center;font-size:20px;\"><a href=\"inscription.php\"><input class=\"suscribe_input\" type=\"submit\" name=\"submit\" value=\"Inscription\" /></a></p>";
		else if ($del_ord === 1)
			echo "<p class=\"articles\"><strong>Luron, ta commande a bien été supprimée !</strong></p><br><p style=\"text-align:center;font-size:20px;\"><a href=\"boutique.php?page=sheet\"><input class=\"suscribe_input\" type=\"submit\" name=\"submit\" value=\"Boutique\" /></a></p>";
		else
		{
			if (isset($_POST['pseudo']))
				$_SESSION['pseudo'] = $_POST['pseudo'];
			echo "<p class=\"articles\"><strong>Luron ".$_SESSION['pseudo'].", ta modification a été apportée !</strong></p><br><p style=\"text-align:center;font-size:20px;\"><a href=\"index.php\"><input class=\"suscribe_input\" type=\"submit\" name=\"submit\" value=\"Retour accueil\" /></a></p>";
		}
	}
	else
		echo "<p class=\"articles\"><strong>Luron ".$_SESSION['pseudo'].", tu n'as fait aucune modification !</strong></p><br><p style=\"text-align:center;font-size:20px;\"><a href=\"compte.php\"><input class=\"suscribe_input\" type=\"submit\" name=\"submit\" value=\"Retour compte\" /></a></p>";
}
else
	echo "<p class=\"articles\"><strong>Luron, tu dois te connecter pour modifier tes informations !</strong></p><br><p style=\"text-align:center;font-size:20px;\"><a href=\"index.php\"><input class=\"suscribe_input\" type=\"submit\" name=\"submit\" value=\"Retour accueil\" /></a></p>";
?>
			</div>
		</div>
	</body>
</html>
