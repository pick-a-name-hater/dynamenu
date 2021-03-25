<?php
session_start();
/*----------------------------------------------------------------------------- 
 * CONTROLADOR DE ACCESOS.
 ----------------------------------------------------------------------------*/
// includes
include("../modelo/BBDD.php");
include("../modelo/tableTOarray.php");
include("../modelo/usuario.php");
include("../modelo/negocio.php");
include("../modelo/sala.php");
include("../modelo/mesa.php");
include("../modelo/incidencia.php");
include("../modelo/escandallo.php");
include("../modelo/comanda.php");

/*include("../modelo/BBDD.php");*/

// CONTROLA PARAMETROS Y SESSION.
/*----------------------------------------------------------------------------*/

// ENLAZA CON LA BBDD si no lo había hecho antes
// Ver como hacer una conexión persistente.
/*----------------------------------------------------------------------------*/
//if (!$_SESSION['SGBD']){
	/*$conexion=mysqli_connect("localhost","root","25073001","dynamenu") or die();
	if (mysqli_connect_errno()){
		printf("Fallo la conexión: %s\n",mysqli_connect_error());
	}	
	//lo mete en la sesion para posteriores usos
	$_SESSION['SGBD']=$conexion; */
    $bbdd= new BBDD(); 
    $bbdd->conecta();
//}
/*$bd=new BBDD();
$conexion=$bd->conexion;*/

// Muestra las variables que recibe del request. Muy util depuración. Comentar al publicar
//----------------------------------------------------------------------------------------
/*$numero = count($_REQUEST); // obtiene el número de parámetros.
$tags = array_keys($_REQUEST);// obtiene los nombres de los parametros
$valores = array_values($_REQUEST);// obtiene los valores de los parametros
for($i=0;$i<$numero;$i++){
    echo " NUMERO: ".$i." ETIQUETA:".$tags[$i]." VALOR:".$valores[$i]."<br>";
}*/
// llama a controlador
//-------------------------------------------
controlador();
// Reenvia a otra página vaciando lo pendiente
//-------------------------------------------
function redirect($url) {
    ob_start();
    header('Location: '.$url);
    ob_end_clean();
    die();
}
// CONTROLADOR
//-------------------------------------------
function controlador(){
	$objeto=$_REQUEST["objeto"];
	$accion=$_REQUEST["accion"];
	// Variable comunicación de error
	//$_SESSION["error"]="<br>He entrado en controlador<br>";
	// Por defecto 
	$exito=TRUE;
    switch ($objeto) {
        case "usuario":
            $us = new usuario();
            switch ($accion){
                case "AltaEmpleado":
                    $us->AltaEmpleado();
                    break;
                case "elimina":
                    $us->borra(); 
                    break;
                case "modifica":
                    $exito=$us->modifica();                
                    break;
                case "cambiaContraseña":
                    $exito=$us->cambiaContrasenia();
					break;
                case "logado":
                    $exito=$us->logado();
					break;
				default:
					break;
            }
            break;
        case "negocio":
            $ne = new negocio();
            switch ($accion){
                case "alta":
                    $ne->inserta();
                    break;
                case "baja":
                    $ne->elimina(); 
                    break;
                case "modifica":
                    $ne->modifica();                
                    break;
				case "registro":
					$exito=$ne->inserta();					
				default:
					break;
            }
            break;
        case "sala":
            $sa = new sala();
            switch ($accion){
                case "inserta":
                    $sa->inserta();
                    break;
                case "elimina":
                    $sa->elimina(); 
                    break;
				default:
					break;
            }
            break;
        case "mesa":
            $me = new mesa();
            switch ($accion){
                case "inserta":
                    $me->inserta();
                    break;
                case "elimina":
                    $me->elimina(); 
                    break;
				default:
					break;
            }
            break;
        case "incidencia":
            $in = new incidencia();
			$_SESSION['error']="despues de crear objeto incidencia";
            switch ($accion){
                case "inserta":
                    $exito=$in->inserta();
                    break;
                case "elimina":
					$_SESSION['error']="Antes de eliminar incidencia";
                    $exito=$in->elimina(); 
                    break;
				default:
					break;
            }
            break;
        case "escandallo":
            $es = new escandallo();
            switch ($accion){
                case "inserta":
                    $exito=$es->inserta();
                    break;
                case "elimina":
                    $exito=$es->elimina(); 
                    break;
                case "modifica":
                    $exito=$es->modifica();
                    break;
                case "encarta":
                    $exito=$es->ponActivo(); 
                    break;
                default:
                    break;
            }
            break;
        case "comanda":
            $co = new comanda();
            switch ($accion){
                case "inserta":
                    $co->inserta();
                    break;
                case "elimina":
                    $co->elimina(); 
                    break;
                    case "modifica":
                    $co->modifica();
                    break;
                case "cierra":
                    $co->cierra(); 
                    break;
                case "paseCocina":
                    $co->paseCocina(); 
                    break;
                default:
                    break;
            }
            break; 
    }
	// Lleva a la página prevista
	if ($exito){
		redirect($_REQUEST['enlaceSI']);
	}else{
		redirect($_REQUEST['enlaceSI']);
	}
}
?>