
<html>
  <head>
    <title>m08uf3pr2 - Acc&eacute;s al servei de directori LDAP amb PHP</title>
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





  </div>
        
       
  
        <input type="submit" name="submit" value="Afegir"> <br>

       

    </form>
</div>
   
  </body>
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
        $add = ldap_add($ldapconn,$ldapdn,$info) or die ("juyut");
        
        
        
    }else {
        echo "No se pudo conectar al servidor LDAP";
    }

    }
}

}


?>