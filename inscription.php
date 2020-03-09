<?PHP
session_start();
include("install.php");
?>
<html>
	<head>
		<title>Les Clefs en Fêtes</title>
		<link rel="stylesheet" href="miniboutique.css">
	</head>
	<body>
		<?PHP include("header.php");?>
		<div class="center">
		<?PHP include("menu.php")?>
			<form action="result_inscription.php" method="POST" class="suscribe">
				Identifiant: <input type="text" name="new_pseudo" value="" />
				<br />
				Mot de passe: <input type="password" name="new_pwd" value="" />
				<br />
				Email: <input type="text" name="new_email" value="" />
				<br />
				<input class="suscribe_input" type="submit" name="submit" value="s'inscrire" />
			</form>
		</div>
	</body>
</html>
