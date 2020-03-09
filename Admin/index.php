<?PHP
session_start();
include("../install.php");
unset($_SESSION['panier']);
unset($_SESSION['pseudo']);
?>
<html>
	<head>
		<title>Les Clefs en Fêtes</title>
		<link rel="stylesheet" href="../miniboutique.css">
	</head>
	<body>
		<div class="center">
			<form action="accueil.php" method="POST" class="suscribe">
				Identifiant: <input type="text" name="pseudo" value="" />
				<br />
				Mot de passe: <input type="password" name="pwd" value="" />
				<br />
				<input class="suscribe_input" type="submit" name="submit" value="connection" />
			</form>
		</div>
	</body>
</html>
