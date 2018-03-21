<?php
session_start(); 

if( isset($_POST['login']) && isset($_POST['password']))
{
	$ldaphost = "ldap://daw2m08.fjeclot.net";
	$ldaprdn  = 'cn='.trim($_POST['login']).',dc=fjeclot,dc=net';
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
			$_SESSION['password'] = trim($_POST['password']);
			$_SESSION['dn'] = $ldaprdn;
			header('Location: home.php'); 		
		} else {
			echo "Error en el mom d'usuari, unitat organitzativa o contrasenya!";
			echo $ldaprdn;
		}
	}
}

?>

<html>
	<head>
	
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

	<title>P&agrave;gina d'indentificaci&oacute;</title>
	</head>
	<body>

	<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
  <a class="navbar-brand" href="#">Navbar</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation" style="">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarColor01">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Features</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Pricing</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">About</a>
      </li>
    </ul>
    <form class="form-inline my-2 my-lg-0">
      <input class="form-control mr-sm-2" placeholder="Search" type="text">
      <button class="btn btn-secondary my-2 my-sm-0" type="submit">Search</button>
    </form>
  </div>
</nav>

<form action=login.php method=post>
	<h1>IDENTIFICACI&Oacute; DE L'USUARI DINS DEL DOMINI fjeclot.net</h1>	
	Si us plau, identificat amb el teu nom d'usuari, unitat organitzativa i contrasenya:
		<table cellspacing=3 cellpadding=3>
		   <tr>
			  <td>Nom d'usuari: </td>
			  <td><input type=text name=login size=16 maxlength=15></td>
		   </tr>
			  <td>Contrasenya: </td>
			  <td><input type=password name=password size=16 maxlength=15></td>
		   </tr>
		   <tr>
			  <td colspan=2><input type=submit value=Autenticaci&oacute;></td>
		   </tr>
		</table>
	</form>
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

	</body>

</html>
