<?PHP
session_start();
include("install.php");
if (!isset($_SESSION['panier']))
	$_SESSION['panier'] = 0;
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
				<h1><p style="text-align:center;">Salut a toi Luron !</p></h1>
				<h2><p style="text-align:center;">et bienvenu sur LE site de vente et manufacture d'instruments de ton serviteur</p></h2>
				<h2><p style="text-align:center;">j'ai nommé Joseph Molenhauer, (moi-même)</p></h2>
				<p style="text-align:center;font-size:20px;">Durant ton séjour sur mon site, merci de te présenté a moi en te connectant</p>
				<p style="text-align:center;font-size:20px;"> (tu ne pourras finaliser tes commandes qu'après t'être connecté) </p>
				<p style="text-align:center;font-size:20px;">tu trouveras a ta gauche les familles d'instruments disponibles</p>
				<p style="text-align:center;font-size:20px;">en haut a gauche tous les instruments et toutes les partitions</p>
				<p style="text-align:center;font-size:20px;"> et tu pourras revenir a cette page en cliquant sur le nom du magasin</p>
				<p style="text-align:center;font-size:20px;">Bon séjour aux "Clefs en fête" !</p>
				<p style="text-align:center;font-size:20px;"> (ps : voici une petite liste de ce que je propose) </p>
<?PHP
$resultat = mysqli_query($_SESSION['mysqli'], "SELECT id_instru FROM `link_tabs` WHERE `id_famille` = '3' ");
$i = 0;
while($donnees = mysqli_fetch_assoc($resultat))
{
	$tab[$i] = $donnees['id_instru'];
	$i++;
}
mysqli_free_result($resultat);
$j = 0;
while ($j < $i)
{
	$fram = $tab[$j];
	$resultat = mysqli_query($_SESSION['mysqli'], "SELECT * FROM `instruments` WHERE `id_instru` = '$fram' ");
	while($donnees = mysqli_fetch_assoc($resultat))
	{
		echo "<br><p class=\"articles\"><strong>Instrument: </strong><a class=\"black\" href=\"panier.php?article=".$donnees['instrument']."\">".$donnees['instrument']."</a><strong> Prix: </strong>".$donnees['prix_inst']."$</p>";
		echo "<br><p class=\"articles\"><strong>Partition: </strong><a class=\"black\" href=\"panier.php?article=".$donnees['partoche']."\">".$donnees['partoche']."</a><strong> Prix: </strong>".$donnees['prix_ptn']."$</p>";
	}
	mysqli_free_result($resultat);
	$j++;
}
?>
			</div>
		</div>
	</body>
</html>
