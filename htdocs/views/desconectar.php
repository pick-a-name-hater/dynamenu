<!------------------------------------------------------------------------------
DESCONECTA UN USUARIO LOGADO.
------------------------------------------------------------------------------->
<?php 
//quita la sesion
include("../modelo/BBDD.php");
session_start();
// Si no esta logado lo envia a hacerlo
if (!(isset($_SESSION['usuario']))){
    header('Location: login');
} 
// desconecta de la BBDD
//$bbdd=new BBDD();
//$bbdd->desconecta();
// libera la sesion.
session_unset();
// Enlaza página inicio pública
header("location:comienzo.php")
?>
