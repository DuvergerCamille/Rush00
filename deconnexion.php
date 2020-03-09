<?PHP
session_start();
include("install.php");
if (isset($_SESSION['pseudo']))
	$connection = 1;
else
	$connection = 2;
session_unset();
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
if ($connection === 1)
{
	echo "<br><br><br><br><br><br<br><br><br><br><br><br><br><br><br><br><br><br>";
	echo "<p class=\"articles\"><strong>Te voila deconnecter ! A la prochaine jeune luron !</strong></p>";
}
else
{
	echo "<br><br><br><br><br><br<br><br><br><br><br><br><br><br><br><br><br><br>";
	echo "<p class=\"articles error\"><strong>Je ne peux pas déconnecter quelqu'un qui n'est pas connecté !</strong></p>";
}
?>
			</div>
		</div>
	</body>
</html>
