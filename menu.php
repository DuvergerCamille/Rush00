<?PHP
session_start();
include("install.php");
?>
<div class="menu">
	<ul class="ul_menu">
		<?PHP
$resultat = mysqli_query($_SESSION['mysqli'], 'SELECT famille FROM familles');
while($donnees = mysqli_fetch_assoc($resultat))
{
	?><li class="list_menu"><h2><a href="boutique.php?page=<?PHP echo $donnees['famille'];?>"><?PHP echo $donnees['famille']; ?></a></h2></li>
<?PHP
}
mysqli_free_result($resultat);
					?>
	</ul>
</div>
