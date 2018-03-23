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

<h1 style="text-align: center">Eliminar Usuari</h1> 

<div class="container" style="margin-top: 5%">
  <div class="row">
		
 <form action="deleteUser.php" method="post">
        <label for="">Nom de l'usuari que vols eliminar</label><br>
        <input type="text" name="uid"/> <br> <br>
		<label for="">Unitat Organitzativa</label><br>
        <input type="text" name="ou"/> <br> <br>
        <input class="btn btn-danger" type="submit" name="submit" value="Esborrar"> <br>
    </div>
    </div>

</form>



</body>
	
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

</html>
<?php
session_start();
if (isset($_SESSION['username'])){
	
	if (isset($_POST['submit'])){
		$ldaphost = "ldap://daw2m08.fjeclot.net";
		
		$ldapconn = ldap_connect($ldaphost) or die("Could not connect to LDAP server.");

		ldap_set_option($ldapconn,LDAP_OPT_PROTOCOL_VERSION,3);
		if($ldapconn){
			
			$ldapbind = ldap_bind($ldapconn,$_SESSION['dn'],$_SESSION['password']);

			if ($ldapbind){
                $uid= $_POST['uid'];
                $ou= $_POST['ou'];
				$dn = "uid=$uid,ou=$ou,dc=fjeclot,dc=net";
	
                $delete = ldap_delete($ldapconn,$dn);
                
				if ($delete){
                    echo '<div class="container alert alert-succes" style="text-align: center;">';
                    echo "Usuari elminat";
                    echo '</div>';
				} else {
                    echo '<div class="container alert alert-danger" >';
                    echo "Usuari No elminat";
                    echo '</div>';
				}
			} else {
				echo "Error d'autenticacio";
				header('Location: login.php');
			}
		}
	}
} else {
	echo "No ets un usuari valid";
	header('Location: login.php');
}
?>






