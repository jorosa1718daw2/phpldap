
<html>
  <head>
    <meta http-equiv="content-type" content="text/html;
      charset=windows-1252">
    <title>m08uf3pr2 - Acc&eacute;s al servei de directori LDAP amb PHP</title>
  </head>
  <body style="text-align: center">
    <h1>Cerca Usuari</h1>

    <form action="cercaUsuari.php" method="post">
        <label for="">UID</label><br>
        <input type="text" name="username"/> <br> <br>
  
        <input type="submit" value="Buscar"> <br>

        <a href="home.php">Volver</a>

    </form>
   
  </body>
</html>
<?php
session_start(); 

if (isset($_POST['username']))
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
			$search = ldap_search($ldapconn, "dc=fjeclot,dc=net", "uid=".$_POST['username']);
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
                echo "Identificador de l' usuari: ".$info[$i]["uid"][0]. "<br />";
                echo "Numero Identificador de l' usuari: ".$info[$i]["uidnumber"][0]. "<br />";
                echo "Grup de l' usuari per defecte: ".$info[$i]["gidnumber"][0]. "<br />";
                echo "Directory Personal: ".$info[$i]["homedirectory"][0]. "<br />";
                echo "Shell de l' usuari: ".$info[$i]["loginshell"][0]. "<br />";
			} 
		} 
		else {
			echo "Error d'autenticació!";
		}
	}
}
?>







