
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

<div class="mx-auto" style="width: 300px;">
<form class="px-4 py-3" action="home.php" method="post">
	<div class="form-check">
		<input class="form-check-input" type="radio" name="cercaUsuari" value=""/>
		<label class="form-check-label" for="exampleRadios1">
		Cerca Usuari
		</label>
	</div>
	<div class="form-check">
		<input class="form-check-input" type="radio" name="afegirUsuari" value=""/>
		<label class="form-check-label" for="exampleRadios2">
		AfegirUsuari
		</label> 
	</div>
	<br>
	<input class="btn btn-primary" type=submit value="Anar a la opció escollida"/>
</form>

</div>






</body>
	
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

	
</html>
