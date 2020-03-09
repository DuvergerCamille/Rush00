<?PHP
session_start();
include("../install.php");
$count = 0;
$resultat = mysqli_query($_SESSION['mysqli'], 'SELECT * FROM orders');
while($donnees = mysqli_fetch_assoc($resultat))
	$count++;
mysqli_free_result($resultat);
$_SESSION['nb_order'] = $count;
?>
<header>
	<div class="header_left">
		<div class="header_center_left">
		<h2><p class="articles"><a href="commandes.php"><?PHP
if ($_SESSION['nb_order'] > 0)
	echo "Commande(s) ".$_SESSION['nb_order']." en cours";
else
	echo "Commande";
?></a></p></h2>
		</div>
		<div class="header_center">
			<h2><p class="articles"><a href="http://localhost:8080/Rush00/index.php">Les Clefs en Fête</a></p></h2>
		</div>
	</div>
	<div class="header_right">
			<h2><p class="articles"><a href="deconnexion.php">Déconnexion</a></p></h2>
	</div>
</header>
