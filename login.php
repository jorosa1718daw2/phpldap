<?php
session_start(); 

if( isset($_POST['login']) && isset($_POST['password']) && isset($_POST['ou']))
{
	$ldaphost = "ldap://daw2m08.fjeclot.net";
	$ldaprdn  = 'uid='.trim($_POST['login']).',ou='.trim($_POST['ou']).',dc=fjeclot,dc=net';
	$ldappass = trim($_POST['password']);  
	 
	
	// Connectant-se al servidor openLDAP
	$ldapconn = ldap_connect($ldaphost) or die("No s'ha pogut establir una connexió amb el servidor openLDAP.");

    ldap_set_option($ldapconn, LDAP_OPT_PROTOCOL_VERSION, 3);

	if ($ldapconn) {
		// Autenticant-se en el servidor openLDAP
		$ldapbind = ldap_bind($ldapconn, $ldaprdn, $ldappass);

		// Accedint a home.php
		if ($ldapbind) {
			$_SESSION['username'] = trim($_POST['login']);
			header('Location: home.php'); 		
		} else {
			echo "Error en el mom d'usuari, unitat organitzativa o contrasenya!";
			echo $ldaprdn;
		}
	}
}

?>

<html>
	<title>P&agrave;gina d'indentificaci&oacute;</title>
	<form action=login.php method=post>
	<h1>IDENTIFICACI&Oacute; DE L'USUARI DINS DEL DOMINI fjeclot.net</h1>	
	Si us plau, identificat amb el teu nom d'usuari, unitat organitzativa i contrasenya:
		<table cellspacing=3 cellpadding=3>
		   <tr>
			  <td>Nom d'usuari: </td>
			  <td><input type=text name=login size=16 maxlength=15></td>
		   </tr>
		   <tr>
			  <td>Unitat organitzativa: </td>
			  <td><input type=text name=ou size=16 maxlength=15></td>
		   </tr>
		   <tr>
			  <td>Contrasenya: </td>
			  <td><input type=password name=password size=16 maxlength=15></td>
		   </tr>
		   <tr>
			  <td colspan=2><input type=submit value=Autenticaci&oacute;></td>
		   </tr>
		</table>
	</form>
</html>
