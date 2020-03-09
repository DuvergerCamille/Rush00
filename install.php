<?PHP
$_SESSION['mysqli'] = mysqli_connect("127.0.0.1", "root", "Tikwi22", "miniboutique");
if ($_SESSION['mysqli'] === FALSE)
{
	echo "ERREUR : Nous n'avons pas pu joindre la base de données";
	exit ;
}
?>
