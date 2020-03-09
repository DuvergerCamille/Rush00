<?PHP
session_start();
include("install.php");
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
if (($_POST['error_pseudo'] == 1) || ($_POST['error_pwd'] == 3) || ($_POST['error_email'] == 7) || ($_POST['error_pseudo'] == 9))
{
	if ($_POST['error_pseudo'] === 1)
		echo "<br><p class=\"articles error\"><strong>Joyeux luron, ton identifiant ne doit contenir qu'entre 2 et 25 caractères, des lettres (MAJUSCULES ou minuscule) et/ou des chiffres.</strong></p>";
	if ($_POST['error_pwd'] === 3)
		echo "<br><p class=\"articles error\"><strong>Joyeux luron, ton mot de passe ne doit contenir qu'entre 2 et 25 caractères, des lettres (MAJUSCULES ou minuscule) et/ou des chiffres.</strong></p>";
	if ($_POST['error_email'] === 7)
		echo "<br><p class=\"articles error\"><strong>Joyeux luron, ton email ne semble pas respecter les normes, viendrais-tu d'un autre monde ?</strong></p>";
	if ($_POST['error_pseudo'] === 9)
		echo "<br><p class=\"articles error\"><strong>Ami luron, un autre joyeux luron semble déjå avoir utilisé cet identifiant, fais preuve d'imagination !</strong></p>";
echo "<br><p class=\"articles error\"><a href=\"inscription.php\"><input class=\"suscribe_input\" type=\"submit\" name=\"submit\" value=\"inscription\" /></a></p>";
}
else
{
	echo "<p class=\"articles\"><strong>Luron ".$_POST['new_pseudo'].", bienvenu.e parmi nous !</strong></p><br><p style=\"text-align:center;font-size:20px;\"><a href=\"index.php\"><input class=\"suscribe_input\" type=\"submit\" name=\"submit\" value=\"Retour accueil\" /></a></p>";
}
?>
			</div>
		</div>
	</body>
</html>
