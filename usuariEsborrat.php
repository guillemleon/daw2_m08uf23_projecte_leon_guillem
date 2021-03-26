<?php

session_start();
echo "<p>Usuari ".$_SESSION["usuariEsborrat"].", esborrat!</p>
<a href='http://zend-gulefo.fjeclot.net/m08uf23/Opcions.php'> Tornar al menú</a>";

?>