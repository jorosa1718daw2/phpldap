

<html>
	<head>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<link rel="stylesheet" href="styles.css" >

	<title>P&agrave;gina d'indentificaci&oacute;</title>
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
        <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
      </li>
    </ul>
   <!-- <form class="form-inline my-2 my-lg-0">
      <button class="btn btn-secondary my-2 my-sm-0" type="submit">Search</button>
    </form>-->
  </div>
</nav>

<div class="mx-auto" style="width: 300px;">

<form class="px-4 py-3" action=login.php method=post>
	<div class="form-group">
		<label>Nom d'usuari:</label>
				<input class="form-control" placeholder="Enter Login" type=text name=login size=16 maxlength=15>
	</div>
	<div class="form-group">	
			<label>Contrasenya: </label>
				<input class="form-control" type=password name=password size=16 maxlength=15>
	</div>
		<input class="btn btn-primary" type=submit value=Autenticaci&oacute;>
	</form>

	</div>
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

	</body>

</html>
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
			echo '<div class="alert alert-danger" style="text-align: center;">';
			echo "Error en el nom d'usuari o contrasenya!";
			echo '</div>';
			/**echo $ldaprdn;*/
		}
	}
}

?>