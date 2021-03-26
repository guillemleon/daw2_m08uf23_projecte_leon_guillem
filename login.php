<?php
if(isset($_SESSION['username'])) {
    session_destroy();
}
/* funció per poder treballar amb sessions. Ha d'estar present en tots els arxius php */
session_start(); 

/* Importem l'arxiu amb les variables de configuració */
require_once("dbconfig.php");

/**Login */
if( isset($_POST['login']) && isset($_POST['password']))
{
	/* En cas que no sigui usuari admin, mostrem pàgina d'error */
	if(strcmp($_POST['login'], "admin")){
		header('Location: Error.php');
	}

	else{
		$ldaprdn  = 'uid='.trim($_POST['login']).',ou='.trim($_POST['ou']).',dc=fjeclot,dc=net';
	$ldappass = trim($_POST['password']); 
	$ldapadmin= "cn=admin,dc=fjeclot,dc=net";  

	// Connectant-se al servidor openLDAP
	$ldapconn = ldap_connect($ldaphost) or die("No s'ha pogut establir una connexió amb el servidor openLDAP.");

    ldap_set_option($ldapconn, LDAP_OPT_PROTOCOL_VERSION, 3);

	/**Si hem aconseguit un identificador */
	if ($ldapconn) {
		// Autenticant-se en el servidor openLDAP
		$ldapbind = ldap_bind($ldapconn, $ldapadmin, $ldappass);

		// Accedint a home.php
		if ($ldapbind) {
			$_SESSION['username'] = trim($_POST['login']);
			ldap_close($ds);
			header('Location: Opcions.php'); 		
		} else {
			echo "Error en el mom d'usuari, unitat organitzativa o contrasenya!";
			echo $ldapconn;
		}
	}
	}
	
	
}



?>

<html>
	<head>
	<title>Login</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	</head>

	<body>
	<form action=login.php method=post>
	<h1>Identificat amb l'usuari administrador LDAP
		<table cellspacing=3 cellpadding=3>
		   <tr>
			  <td><span class="input-group-text">Nom d'usuari: </span></td>
			  <td><input class="form-control"  type=text name=login size=16 maxlength=15></td>
		   </tr>

		
		 
		   <tr>
			  <td><span class="input-group-text"> Contrasenya de l'administrador LDAP: </span></td>
			  <td><input class="form-control" type=password name=password size=16 maxlength=15></td>
		   </tr>
		   <tr>
			  <td colspan=2><input class="btn btn-success" type=submit value="Entra"></td>
		   </tr>
		</table>
		</form>
</body>

		

	
</html>
