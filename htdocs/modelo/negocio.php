<?php
/*-----------------------------------------------------------------------------
 * GESTIÓN DE RESTAURANTES
 -----------------------------------------------------------------------------*/
class negocio {
    //declaración de propiedades
    
    //CONSTRUCTOR
    //-------------------------------------------------------------------------  
    function __construct(){
		//echo "He creado negocio";
    }
    //ALTA de restaurantes
    //-------------------------------------------------------------------------  
	function inserta(){
		$_SESSION['error']="He entrado en insercion de restaurantes.";
		if (!($this->existeNIF($_REQUEST['inputCIF'],0))){
			$_SESSION['error']=$_SESSION['error']." NO EXISTE CIF -";
			// no existe el CIF indicado
			$con=$_SESSION['SGBD'];
			$hoy= date("Y-m-d");
			$ins="INSERT INTO `negocios`(`NEG_ID`, `NEG_CIF`, `NEG_RazonSocial`, `NEG_NombreComercial`) VALUES ('0',\"".$_REQUEST['inputCIF']."\",\"".$_REQUEST['inputRazon']."\",\"".$_REQUEST['inputComercial']."\" )";
			$_SESSION['error']=$ins;
			$result = mysqli_query($con,$ins);
			$filas=  mysqli_affected_rows($con);
			if ($filas>0){
				$miMensaje="He dado de alta El Restaurante con los datos facilitados. No olvide acceder al sistema con sus datos y completar los datos de su empresa y su perfil";
				$_SESSION['error']=$ins." - ".$miMensaje;
				$us= new usuario();
				// Estampo empresa para alta de gerente.
				//$_REQUEST[inputNEG_ID]=mysqli_insert_id($con);
				$_REQUEST['inputNEG_ID']=mysql_insert_id($con);
				$us->AltaEmpleado();
				$_SESSION['error']="Restaurante dado de alta.";
				return TRUE;
			}else{
				$_SESSION['error']=$ins." - ERROR DESCONOCIDO EN EL ALTA. CONSULTE CON EL ADMINISTRADOR";
				return FALSE;
			}
		}else{
			$_SESSION['error']=$ins."Existe otra empresa con el CIF INDICADO. No puedo dar de alta esta empresa. Si este es su CIF comuníquelo al administrador.";
			return FALSE;
		} 
	}
	// EXISTE CIF EN LA BBDD?
    //-------------------------------------------------------------------------  
    public function existeNIF($NIF,$miempresa){
		echo "He entrado en comprobacion de existencia de CIF";
        if(!empty($NIF)) {
			// no es vacio
            //normaliza los caracteres especiales.
            $NIF=htmlspecialchars($NIF,ENT_QUOTES,"UTF-8");
            if ($miempresa==0){
				// alguien se está intentanto registrar registrar una empresa. el NIF NO debe estar en la BBDD
                $query ="SELECT * from negocios where NEG_CIF='$NIF'";
            }else{
				// alguien está modificando datos de su empresa (gerente o Administrador). El CIF si existe debe ser del propio usuario.
                $query ="SELECT * from negocios where NEG_CIF='$NIF' and NEG_ID!='$miempresa'";
            }
			echo $query;
            $result = mysqli_query($_SESSION['SGBD'],$query);
            $filas=  mysqli_num_rows($result);
            if ($filas>0){
				return true;
            }else{	
				return false;
			}
        }else{
			return false;
		}
    }
	
    //BAJA de restaurantes
    //-------------------------------------------------------------------------  
	function elimina(){
	}
    //MODIFICACION de restaurantes
    //-------------------------------------------------------------------------  
	function modifica(){
		$con=$_SESSION['SGBD'];
		/*---------- sistema TRADICIONAL -----------------------------*/
		$modi="UPDATE negocios SET NEG_CIF='".$_REQUEST['inputCIF']."',";
		$modi=$modi."NEG_RazonSocial= '".$_REQUEST['inputRazon']."',";
		$modi=$modi."NEG_NombreComercial= '".$_REQUEST['inputComercial']."'";
		$modi=$modi." where NEG_ID=".$_SESSION['negocio']['NEG_ID'];
		$result = mysqli_query($con,$modi);
		$filas=  mysqli_affected_rows($con);
		//Actualiza session.
		$_SESSION['negocio']['NEG_CIF']=$_REQUEST['inputCIF'];
		$_SESSION['negocio']['NEG_RazonSocial']=$_REQUEST['inputRazon'];
		$_SESSION['negocio']['NEG_NombreComercial']=$_REQUEST['inputComercial'];
		$_SESSION['error']="Se han guardado los datos de tu Restaurante";
		return TRUE;
	}
    //DATOS de restaurantes
    //-------------------------------------------------------------------------  
	function busca($nempresa){
		$cqr=$_SESSION['SGBD'];
		$query ="SELECT * from `negocios` where NEG_ID=".$nempresa;
		$result = mysqli_query($cqr,$query);
		$filas=  mysqli_num_rows($result);
		if ($filas>0){
			$row=mysqli_fetch_array($result,MYSQLI_BOTH);
			$_SESSION['negocio']=$row;
			return TRUE;
		}else{
			unset($_SESSION['negocio']);
			$_SESSION['error']="No he localizado el restaurante:".$nempresa." ".$query;
			return FALSE;
		}
	}
}
?>