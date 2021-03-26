<?php
session_start();
require_once("dbconfig.php");

/**Delete */
if( isset($_POST['delete']))
{

// Connectant-se al servidor openLDAP
$ldapconn = ldap_connect($ldaphost) or die("No s'ha pogut establir una connexió amb el servidor openLDAP.");

ldap_set_option($ldapconn, LDAP_OPT_PROTOCOL_VERSION, 3);

/**Si hem aconseguit un identificador */
if ($ldapconn) {
// Autenticant-se en el servidor openLDAP
$ldapadmin= "cn=admin,dc=fjeclot,dc=net";
$ldapbind = ldap_bind($ldapconn, $ldapadmin, "fjeclot");


$res = ldap_delete($ldapconn, "cn=".$_POST["delete"].",ou=usuaris, dc=fjeclot, dc=net");

if($res == true){
    $_SESSION["usuariEsborrat"] = $_POST["delete"];
    header('Location: usuariEsborrat.php'); 
}

else{
    
    $_SESSION["usuariEsborrar"] = $_POST["delete"];
    header('Location: ErrorEsborrant.php'); 
}


ldap_close($ldapconn);
}



}

?>
<html>
<head>

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

</head>


<body>

<h2>ESBORRAR USUARI</h2>

		<!-- Esborrar -->
	<form action=esborrar.php method=post>	

		<table>
		<tr>
			  <td><span class="input-group-text">Nom d'usuari: </span></td>
			  <td><input class="form-control" type=text name=delete size=16 maxlength=15></td>
		   </tr>
		   <tr>
			  <td colspan=2><input class="btn btn-primary" type=submit value="Esborrar"></td>
		   </tr>
	</table>
    </form>

	<br>

<a href='http://zend-gulefo.fjeclot.net/m08uf23/Opcions.php'>Tornar al menú</a>

	</body>

	</html>