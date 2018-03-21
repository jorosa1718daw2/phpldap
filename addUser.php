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
<html>
  <head>
    <title>m08uf3pr2 - Acc&eacute;s al servei de directori LDAP amb PHP</title>
  </head>
  <body>
    <h1>Afegir Usuari</h1>

    <form action="addUser.php" method="post">
        
        <label for="">uid:</label><br>
        <input type="text" name="uid"/> <br> <br>
        <label for="">OU:</label><br>
        <input type="text" name="ou"/> <br> <br>
        <label for="">givenName:</label><br>
        <input type="text" name="givenname"/> <br> <br>
        <label for="">surname:</label><br>
        <input type="text" name="surname"/> <br> <br>
        <label for="">title:</label><br>
        <input type="text" name="title"/> <br> <br>
         <label for="">telephone:</label><br>
        <input type="text" name="telephone"/> <br> <br>
        <label for="">mobile:</label><br>
        <input type="text" name="mobile"/> <br> <br>
        <label for="">postalAddress:</label><br>
        <input type="text" name="postaladdress"/> <br> <br>
        <label for="">shell:</label><br>
        <input type="text" name="shell"/> <br> <br>
        <label for="">gidnumber:</label><br>
        <input type="text" name="gidnumber"/> <br> <br>
        <label for="">uidnumer:</label><br>
        <input type="text" name="uidnumber"/> <br> <br>
        <label for="">homedirectory:</label><br>
        <input type="text" name="homedirectory"/> <br> <br>
        <label for="">description:</label><br>
        <input type="text" name="description"/> <br> <br>
        <label for="">Password:</label><br>
        <input type="text" name="password"/> <br> <br>
  
        <input type="submit" name="submit" value="Afegir"> <br>

        <a href="home.php">Volver</a>

    </form>
   
  </body>
</html>
