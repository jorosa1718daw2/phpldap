


<html>
<head>
<title> Dades de l'usuari</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
  <a class="navbar-brand" href="#">PHPLDAP-ADMIN</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation" style="">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarColor01">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="home.php">Home <span class="sr-only">(current)</span></a>
      </li>
	  <li class="nav-item active">
        
      </li>
    </ul>
   <form class="form-inline my-2 my-lg-0">
   <a type="button" class="btn btn-danger" class="btn btn-secondary my-2 my-sm-0"  href="home.php?logout">Logout</a>
      
    </form>
  </div>
</nav>


<div class="container" style="margin-top: 5%">
  <div class="row">
    <div class="col-sm">
		<h1>Cerca Usuari</h1>

<form action="cercaUsuari.php" method="post">
		<label for="">UID</label><br>
		<input type="text" name="username"/> <br> <br>

		<input type="submit" value="Buscar"> <br>
    </div>



</form>



</body>
	
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

	
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
			if ($_POST['username']){
			for ($i=0; $i<$info["count"]; $i++)
			{
				echo '<div class="col-sm">';
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
					echo '</div>';
			} 
		}else {
			echo '<div class="alert alert-danger" style="text-align: center;">';
			echo "No s'ha trobat res";
			echo '</div>';
		}
	
	
		} 
		else {
			echo "Error d'autenticació!";
		}
	}
}
?>