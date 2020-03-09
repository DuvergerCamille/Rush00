<?PHP
session_start();
include("install.php");
?>
<header>
	<div class="header_left">
		<div class="header_center_left">
		<h2><p class="header margin_top_bis"><a class="margin_all" href="panier.php"><?PHP
if (isset($_SESSION['panier']))
	echo "Mon panier ".$_SESSION['panier']."$";
else
	echo "Mon panier 0$";
?></a>
			<a class="margin_all" href="boutique.php?page=instru">Les instruments</a>
			<a class="margin_all" href="boutique.php?page=sheet">Les partitions</a>
			<a class="margin_all" href="compte.php">Mon compte</a>
			<a class="margin_all" href="deconnexion.php">Déconnexion</a></p></h2>
		</div>
		<div class="header_center">
			<a href="index.php"><h1><p class="header margin_top">Les Clefs en Fête</p></h1></a>
			<h3><p class="header margin_top">Facteur et (re)vendeur d'instruments en ligne</p></h3>
		</div>
	</div>
	<div class="header_right">
		<form action="connection.php" method="POST">
			<h2><p class="header margin_top">Connecte toi ami luron !</p></h2>
			<a href="inscription.php"><h5><p class="header margin_top">(Ou rejoins nous joyeux luron !)</p></h5></a>
			<p class="header margin_top">Identifiant: <input type="text" name="pseudo" value="" />
			Mot de passe: <input type="password" name="pwd" value="" />
			<input type="submit" name="submit" value="Connecter" /></p>
		</form>
	</div>
</header>
