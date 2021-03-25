<?php
	session_start();
	// Obtiene el tipo de usuario
	if (!(isset($_SESSION['usuario']))){
		$us=0;
	}else{
		$us=$_SESSION['usuario']['USU_ROL_ID'];
	}
	//echo "Usuario: ".$us;
	//$us=1;
	switch ($us){
		case 0:
			//no logado
			include "barraNavegacionLibre.php";
			break;
		case 1:
			//Administrador
			include "barraNavegacionAdministrador.php";
			break;
		case 2:
			//Gerente
			include "barraNavegacionGerente.php";
			break;
		case 3:
			//Camarero
			include "barraNavegacionCamarero.php";
			break;
		case 4:
			//Cocinero
			include "barraNavegacionCocinero.php";
			break;
		default:
			//no logado
			include "barraNavegacionLibre.php";
			break;
	}
?>

