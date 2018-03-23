
<html>
  <head>
    <title>m08uf3pr2 - Acc&eacute;s al servei de directori LDAP amb PHP</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    
  </head>
  <body>

  <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
  <a class="navbar-brand" href="home.php">PHPLDAP-ADMIN</a>
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
    <h1>Afegir Usuari</h1>

    <form action="addUser.php" method="post">
    <div class="form-row">
        <div class="form-group col-md-6">
            <label >givenname</label>
        <input type="text" class="form-control" name="givenname" placeholder="givenname">
        </div>
        
    <div class="form-group col-md-6">
      <label >Last Name</label>
      <input type="text" class="form-control" name="surname" placeholder="surname">
    </div>

    <div class="form-group">
        <label >Title</label>
        <input type="text" class="form-control" name="title" placeholder="title">
    </div>

     <div class="form-group col-md-6">
      <label >telephone number </label>
      <input type="text" class="form-control" name="telephone" placeholder="telephone">
    </div>

     <div class="form-group">
        <label >Mobile Phone</label>
        <input type="text" class="form-control" name="mobile" placeholder="mobile">
    </div>

     <div class="form-group col-md-6">
      <label >Postal Address </label>
      <input type="text" class="form-control" name="postaladdress" placeholder="postaladdress">
    </div>

    <div class="form-group col-md-6">
      <label >Description</label>
      <input type="text" class="form-control" name="description" placeholder="description">
    </div>
    <div class="form-group">
        <label >UID</label>
        <input type="text" class="form-control" name="uid" placeholder="uid">
    </div>
    <div class="form-group col-md-6">
        <label >Organizational Unit</label>
        <input type="text" class="form-control" name="ou" placeholder="ou">
    </div>
    <div class="form-group">
        <label >GUID</label>
        <input type="text" class="form-control" name="gidnumber" placeholder="gidnumber">
    </div>
    <div class="form-group">
        <label >UID Number</label>
        <input type="text" class="form-control" name="uidnumber" placeholder="uidnumber">
    </div>

    <div class="form-group col-md-6">
        <label >Home Directory</label>
        <input type="text" class="form-control" name="homedirectory" placeholder="homedirectory">
    </div>
    <div class="form-group col-md-6">
        <label >Shell</label>
        <input type="text" class="form-control" name="shell" placeholder="shell">
    </div>
    <div class="form-group">
        <label >Password</label>
        <input type="password" class="form-control" name="password" placeholder="password">
    </div>





  </div>
        
       
  
        <input class="btn btn-success" type="submit" name="submit" value="Afegir"> <br>

       

    </form>
</div>
   
  </body>
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

	
</html>

<?php
session_start();
if (isset($_SESSION['username']))
{
echo $_SESSION['dn'];
if (isset($_POST['submit'])){


    $ldaphost = "ldap://daw2m08.fjeclot.net";
    $ldapconn = ldap_connect($ldaphost) or die("Could not connect to LDAP server.");
    ldap_set_option($ldapconn, LDAP_OPT_PROTOCOL_VERSION, 3);

if($ldapconn)
{
    $ldapbind = ldap_bind($ldapconn,$_SESSION['dn'],$_SESSION['password']);

    if($ldapbind){

        $info["objectclass"][0] = "top";
        $info["objectclass"][1] = "person";
        $info["objectclass"][2] = "organizationalperson";
        $info["objectclass"][3] = "inetorgperson";
        $info["objectclass"][4] = "posixaccount";
        $info["objectclass"][5] = "shadowaccount";
        $info["givenname"] = trim($_POST['givenname']);
        $info["cn"] = trim($_POST['givenname'])." ".trim($_POST['surname']);
        $info["sn"] = trim($_POST['surname']);
        $info["title"] = trim($_POST['title']);
        $info["telephonenumber"] = trim($_POST['telephone']);
        $info["mobile"] = trim($_POST['mobile']);
        $info["postaladdress"] = trim($_POST['postaladdress']);
        $info["description"] = trim($_POST['description']);
        $info["uid"] = trim($_POST['uid']);
        $info["ou"] = trim($_POST['ou']);
        $info["gidnumber"] = trim($_POST['gidnumber']);
        $info["uidnumber"] = trim($_POST['uidnumber']);
        $info["homedirectory"] = trim($_POST['homedirectory']);
        $info["loginshell"] = trim($_POST['shell']);
        $info["userpassword"] = trim($_POST['password']);


        $ldapdn  = 'uid='.trim($_POST['uid']).',ou='.trim($_POST['ou']).',dc=fjeclot,dc=net';
        $add = ldap_add($ldapconn,$ldapdn,$info);
        if($add) {
            echo '<div class="container alert alert-succes" style="text-align: center;">';
            echo "Usuari afegit";
            echo '</div>';
        }else{
            echo '<div class="container alert alert-danger" style="text-align: center;">';
            echo "Usuari no afegit";
            echo '</div>';
        }
        
        
        
    }else {
        echo "No se pudo conectar al servidor LDAP";
        header('Location: login.php');
    }

    }
}

}


?>