<?php
	session_start();
	// Obtiene el tipo de usuario
	$us=$_SESSION['usuario']['USU_ROL_ID'];
	switch ($us){
		case 2:
			//Gerente
			include "menu_gerente.php";
			break;
		case 3:
			//Camarero
			include "menu_camarero.php";
			break;
		case 4:
			//Cocinero
			include "menu_cocinero.php";
			break;
	}
	//Si hay algún mensaje pendiente lo muestra y lo vacía.
	echo "<script>bootbox.alert('".$_SESSION['error']."')</script>";$_SESSION['error']=""; 
	$_SESSION["error"]="";
?>

