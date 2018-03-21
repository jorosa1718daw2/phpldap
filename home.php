
<?php
session_start(); 

if (isset($_SESSION['username']))
{
	// Connexió amb el servidor openLDAP
	$ldaphost = "ldap://daw2m08.fjeclot.net";
	$ldapconn = ldap_connect($ldaphost) or die("Could not connect to LDAP server.");
	ldap_set_option($ldapconn, LDAP_OPT_PROTOCOL_VERSION, 3);
	if ($ldapconn) {
		// Autenticació anònima al servidor openLDAP
		$ldapbind = ldap_bind($ldapconn);
		// Accedint a les dades
		if ($ldapbind) {
			$search = ldap_search($ldapconn, "dc=fjeclot,dc=net", "uid=".$_SESSION['username']);
			$info = ldap_get_entries($ldapconn, $search);
			//Ara, visualitzarem algunes de les dades de l'usuari:
			for ($i=0; $i<$info["count"]; $i++)
			{
				echo "Nom: ".$info[$i]["cn"][0]. "<br />";
				echo "Títol: ".$info[$i]["title"][0]. "<br />";
				echo "Telèfon fixe: ".$info[$i]["telephonenumber"][0]. "<br />";
				echo "Adreça postal: ".$info[$i]["postaladdress"][0]. "<br />";
				echo "Telèfon mòbil: ".$info[$i]["mobile"][0]. "<br />";
				echo "Descripció: ".$info[$i]["description"][0]. "<br />";
			} 
		} 
		else {
			echo "Error d'autenticació!";
		}
	}
}
else{
	echo "Hola";
	header('Location: login.php'); 	
}



// Log OUT
if(isset($_GET['logout']))	{
	session_destroy();
	header('Location: login.php');
}

if(isset($_POST['cercaUsuari'])){
	header('Location: cercaUsuari.php'); 
}
if(isset($_POST['afegirUsuari'])){
	header('Location: addUser.php'); 
}
?>
<html>
<title> Dades de l'usuari</title>
	<a href="home.php?logout">Logout</a> <br> <br>

	<form action="home.php" method="post">
		<input type="radio" name="cercaUsuari" value=""/>Cerca Usuari <br>
		<input type="radio" name="afegirUsuari" value=""/>AfegirUsuari <br>
		<input type="submit" value="Anar a la opció escollida"/>
	</form>
	
</html>
