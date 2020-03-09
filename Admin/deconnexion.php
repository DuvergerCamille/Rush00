<?PHP
session_start();
include("../install.php");
session_unset();
?>
<html>
	<head>
		<title>Admin</title>
		<link rel="stylesheet" href="../miniboutique.css">
	</head>
	<body>
		<div class="center">
			<div class="boutique">
<?PHP
echo "<br><br><br><br><br><br<br><br><br><br><br><br><br><br><br><br><br><br>";
echo "<p class=\"articles\"><strong>Te voila deconnecter ! A la prochaine jeune luron !</strong></p>";
echo "<p class=\"articles\"><a href=\"index.php\"><input class=\"suscribe_input\" type=\"submit\" name=\"submit\" value=\"Connection\" /></a></p>";
?>
			</div>
		</div>
	</body>
</html>
