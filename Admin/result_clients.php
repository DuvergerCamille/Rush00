<?PHP
session_start();
include("../install.php");
if (!isset($_SESSION['pseudo']))
	$connection = 1;
else
{
	$connection = 2;
	$formular = 1;
	if (isset($_POST['del_pseudo']) || isset($_POST['new_pseudo']) || isset($_POST['old_pseudo']) || isset($_POST['old_email']) || isset($_POST['pseudo']) || isset($_POST['pseudo_admin']))
	{
		$formular = 2;
		if (isset($_POST['del_pseudo']))
			$req = 1;
		if (isset($_POST['new_pseudo']))
			$req = 2;
		if (isset($_POST['old_pseudo']))
			$req = 3;
		if (isset($_POST['old_email']))
			$req = 4;
		if (isset($_POST['pseudo']))
			$req = 5;
		if (isset($_POST['pseudo_admin']))
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
		$modif = FALSE;
		$del = 1;
		if ($req === 1)
		{
			$resultat = mysqli_query($_SESSION['mysqli'], 'SELECT * FROM users');
			while($donnees = mysqli_fetch_assoc($resultat))
			{
				if ($donnees['pseudo'] === $_POST['del_pseudo'])
					$del = 2;
			}
			mysqli_free_result($resultat);
			if ($del === 2)
			{
				$resultat2 = mysqli_query($_SESSION['mysqli'], "DELETE FROM users WHERE `users`.`pseudo` = '$_POST[del_pseudo]'");
				mysqli_free_result($resultat2);
				echo "<p class=\"articles\"><strong>Client supprimé !</strong></p>";
			}
			else
				echo "<p class=\"articles error\"><strong>Le pseudo donné ne fait pas parti des clients!</strong></p>";
		}
		else if ($req === 2)
		{
			if (isset($_POST['new_pseudo']) && isset($_POST['new_pwd']) && isset($_POST['new_email']) && isset($_POST['submit']))
			{
				(preg_match('/^([a-zA-Z0-9]{2,25})$/', trim($_POST['new_pseudo'])) === 1) ? $_POST['error_pseudo'] = 0: $_POST['error_pseudo'] = 1;
				(preg_match('/^([a-zA-Z0-9]{2,25})$/', trim($_POST['new_pwd'])) === 1) ? $_POST['error_pwd'] = 0: $_POST['error_pwd'] = 3;
				(preg_match('/^([\w\.-]+)@([\w\.-]+)(\.[a-z]{2,4})$/',trim($_POST['new_email'])) === 1)? $_POST['error_email'] = 0: $_POST['error_email'] = 7;
				if (($_POST['error_pseudo'] == 0) && ($_POST['error_pwd'] == 0) && ($_POST['error_email'] == 0))
				{
					$resultat = mysqli_query($_SESSION['mysqli'], 'SELECT pseudo FROM users');
					while($donnees = mysqli_fetch_assoc($resultat))
					{
						if ($donnees['pseudo'] === $_POST['new_pseudo'])
							$_POST['error_pseudo'] = 9;
					}
					mysqli_free_result($resultat);
					if ($_POST['error_pseudo'] !== 9)
					{
						$_POST['new_pwd'] = hash('whirlpool', $_POST['new_pwd']);
						$req_pre = mysqli_prepare($_SESSION['mysqli'], 'INSERT INTO users (pseudo, pwd, email) VALUES (?, ?, ?)');
						mysqli_stmt_bind_param($req_pre, "sss", $_POST['new_pseudo'], $_POST['new_pwd'], $_POST['new_email']);
						mysqli_stmt_execute($req_pre);
					}
				}
			}
			if (($_POST['error_pseudo'] == 1) || ($_POST['error_pwd'] == 3) || ($_POST['error_email'] == 7) || ($_POST['error_pseudo'] == 9))
			{
				if ($_POST['error_pseudo'] === 1)
					echo "<br><p class=\"articles error\"><strong>L'identifiant ne doit contenir qu'entre 2 et 25 caractères, des lettres (MAJUSCULES ou minuscule) et/ou des chiffres.</strong></p>";
				if ($_POST['error_pwd'] === 3)
					echo "<br><p class=\"articles error\"><strong>Le mot de passe ne doit contenir qu'entre 2 et 25 caractères, des lettres (MAJUSCULES ou minuscule) et/ou des chiffres.</strong></p>";
				if ($_POST['error_email'] === 7)
					echo "<br><p class=\"articles error\"><strong>L'adresse email ne semble pas respecter les normes.</strong></p>";
				if ($_POST['error_pseudo'] === 9)
					echo "<br><p class=\"articles error\"><strong>Pseudo existant, en changer.</strong></p>";
				echo "<br><p class=\"articles error\"><a href=\"clients.php\"><input class=\"suscribe_input\" type=\"submit\" name=\"submit\" value=\"Recommencer\" /></a></p>";
			}
			else
			{
				echo "<p class=\"articles\"><strong> Compte client ".$_POST['new_pseudo']." créé.</strong></p><br><p style=\"text-align:center;font-size:20px;\"><a href=\"clients.php\"></a></p>";
			}
		}
		else if ($req === 3)
		{
			$resultat = mysqli_query($_SESSION['mysqli'], 'SELECT * FROM users');
			while($donnees = mysqli_fetch_assoc($resultat))
			{
				if ($donnees['pseudo'] === $_POST['old_pseudo'])
					$del = 2;
			}
			mysqli_free_result($resultat);
			if ($del === 2)
			{
				if (isset($_POST['pseudo_new']) && isset($_POST['old_pseudo']))
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
							mysqli_query($_SESSION['mysqli'], "UPDATE users SET pseudo='$_POST[pseudo_new]' WHERE pseudo='$_POST[old_pseudo]'");
					}
					if ($_POST['error_pseudo'] === 1)
						echo "<br><p class=\"articles error\"><strong>L'identifiant ne doit contenir qu'entre 2 et 25 caractères, des lettres (MAJUSCULES ou minuscule) et/ou des chiffres.</strong></p>";
					if ($_POST['error_pseudo'] === 9)
						echo "<br><p class=\"articles error\"><strong>Cet identifiant est deja utilisé.</strong></p>";
					else if($_POST['error_pseudo'] != 1 && $_POST['error_pseudo'] != 9)
						echo "<p class=\"articles\"><strong>La modification a été apportée.</strong></p>";
				}
			}
			else
				echo "<p class=\"articles error\"><strong>Le premier pseudo n'est pas dans la base de données!</strong></p>";
		}
		else if ($req === 4)
		{
			$resultat = mysqli_query($_SESSION['mysqli'], 'SELECT * FROM users');
			while($donnees = mysqli_fetch_assoc($resultat))
			{
				if ($donnees['email'] === $_POST['old_email'])
					$del = 2;
			}
			mysqli_free_result($resultat);
			if ($del === 2)
			{
				if (isset($_POST['email_new']) && isset($_POST['old_email']))
				{
					$modif = TRUE;
					(preg_match('/^([\w\.-]+)@([\w\.-]+)(\.[a-z]{2,4})$/',trim($_POST['email_new'])) === 1)? $_POST['error_email'] = 0: $_POST['error_email'] = 7;
					if ($_POST['error_email'] == 0)
					{
						$resultat = mysqli_query($_SESSION['mysqli'], "UPDATE `users` SET `email` = '$_POST[email_new]' WHERE `users`.`email` = '$_POST[old_email]'");
						mysqli_free_result($resultat);
					}
				}
				if ($_POST['error_email'] === 7)
					echo "<br><p class=\"articles error\"><strong>Joyeux luron, ton email ne semble pas respecter les normes, viendrais-tu d'un autre monde ?</strong></p>";
				else
					echo "<p class=\"articles\"><strong>La modification a été apportée.</strong></p>";
			}
			else
				echo "<p class=\"articles error\"><strong>Le premier email n'est pas dans la base de données!</strong></p>";
		}
		else if ($req === 5)
		{
			if (isset($_POST['pwd_new']))
			{
				(preg_match('/^([a-zA-Z0-9]{2,25})$/', trim($_POST['new_pwd'])) === 1) ? $_POST['error_pwd'] = 0: $_POST['error_pwd'] = 3;
				$resultat = mysqli_query($_SESSION['mysqli'], 'SELECT * FROM users');
				while($donnees = mysqli_fetch_assoc($resultat))
				{
					if ($donnees['pseudo'] === $_POST['pseudo'])
						$del = 2;
				}
				mysqli_free_result($resultat);
				if ($del === 2)
				{
					$resultat = mysqli_query($_SESSION['mysqli'], 'SELECT * FROM users');
					while($donnees = mysqli_fetch_assoc($resultat))
					{
						$_POST['pwd_new'] = hash('whirlpool', $_POST['pwd_new']);
						if (($donnees['pseudo'] === $_POST['pseudo']) && ($_POST['error_pwd'] === 0))
							$donnees['pwd'] = $_POST['pwd_new'];
					}
					mysqli_free_result($resultat);
					if ($_POST['error_pwd'] === 3)
						echo "<br><p class=\"articles error\"><strong>Le mot de passe ne doit contenir qu'entre 2 et 25 caractères, des lettres (MAJUSCULES ou minuscule) et/ou des chiffres.</strong></p>";
					else
						echo "<p class=\"articles\"><strong>La modification a été apportée.</strong></p>";
				}
				else
					echo "<p class=\"articles error\"><strong>Le pseudo n'est pas dans la base de données!</strong></p>";
			}
			else
				echo "<p class=\"articles error\"><strong>Le mot de passe n'a pas été rentré!</strong></p>";
		}
		else if ($req === 6)
		{
			$resultat = mysqli_query($_SESSION['mysqli'], 'SELECT * FROM users');
			while($donnees = mysqli_fetch_assoc($resultat))
			{
				if ($donnees['pseudo'] === $_POST['pseudo_admin'])
				{
					$del = 2;
					$pseudo = $donnees['pseudo'];
					$pwd = $donnees['pwd'];
				}
			}
			mysqli_free_result($resultat);
			if ($del === 2)
			{
				$req_pre = mysqli_prepare($_SESSION['mysqli'], 'INSERT INTO admin (pseudo, pwd) VALUES (?, ?)');
				mysqli_stmt_bind_param($req_pre, "ss", $pseudo, $pwd);
				mysqli_stmt_execute($req_pre);
				echo "<p class=\"articles\"><strong> Le compte client ".$_POST['pseudo']." a les droits d'admin.</strong></p><br><p style=\"text-align:center;font-size:20px;\"><a href=\"clients.php\"></a></p>";
			}
			else
				echo "<p class=\"articles error\"><strong>Le pseudo n'est pas dans la base de données!</strong></p>";
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
}
?>
			</div>
		</div>
	</body>
</html>
