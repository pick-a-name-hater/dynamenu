<?php
/*-----------------------------------------------------------------------------
 * GESTIÓN DE INCIDENCIAS
 -----------------------------------------------------------------------------*/
class incidencia {
    //declaración de propiedades
    
    //CONSTRUCTOR
    //-------------------------------------------------------------------------  
    function __construct(){
    }
	// ALTA DE INCIDENCIA
    //-------------------------------------------------------------------------  
    public function inserta(){
		$hoy=date('Y-m-d h:i:s');
		echo $hoy;
		if ($_REQUEST['inputTIPO']=="1"){
			// falta un ingrediente
			$valor=$_REQUEST['inputidAfectado'];
		}else{
			// falta un plato
			$valor=$_REQUEST['inputPlatoAfectado'];
		}
		$ins="INSERT INTO `incidencias`(`INC_ID`, `INC_NEG_ID`, `INC_FechaAlta`, `INC_Tipo`, `INC_idAfectado`, `INC_USU_ID`) VALUES (";
		$ins=$ins."'0','".$_SESSION['usuario']['USU_NEG_ID']."','".$hoy."','".$_REQUEST['inputTIPO']."','".$valor."','".$_SESSION['usuario']['USU_ID']."')";
		echo $ins;
		$con=$_SESSION['SGBD'];
		$result = mysqli_query($con,$ins);
		$filas=  mysqli_affected_rows($con);
		if ($filas>0){
			$_SESSION['error']="Incidencia añadida";
			$this->cargaIncidencias("si");
			return TRUE;
		}else{
			$_SESSION['error']="ERROR DESCONOCIDO EN EL ALTA DE INCIDENCIA. CONSULTE CON EL ADMINISTRADOR".$ins;
			return FALSE;
		}
    }  
    
    //BORRA INCIDENCIA
    //-------------------------------------------------------------------------  
    public function elimina(){
		$con=$_SESSION['SGBD'];
		$ejecuta="DELETE FROM incidencias WHERE INC_ID=".$_REQUEST["inputINC_ID"].";";
		echo $ejecuta;
        mysqli_query($con,$ejecuta) or die("No he podido dar de BAJA la INCIDENCIA <br>MySQL dice: ".mysql_error());
		$filas=  mysqli_affected_rows($con);
		if ($filas>0){
			$_SESSION['error']="He dado de baja la Incidencia:".$_REQUEST["inputINC_ID"];
			$this->cargaIncidencias("si");
			return TRUE;
		}else{
			$_SESSION['error']="Error desconocido. NO SE HA DADO DE BAJA la INCIDENCIA:".$ejecutaa;
			return FALSE;
		}
    } 
	//Carga en un array de session las INCIDENCIAS del negocio
	//-------------------------------------------------------------------------------
	public function cargaIncidencias($fuerza){
		// Fuerza=true obliga a cargar
		if (!($fuerza=="si")){
			//echo "verifico si esta cargada...";
			// si no forzamos y Si estan cargados los usuarios no carga.
			if ((isset($_SESSION['MisIncidencias']))){
				return;
			}
		}
		// Si tenemos  la conexión abierta no la hacemos
		if ((isset($_SESSION['SGDB']))){
			$con=$_SESSION['SGBD'];
		}else{
			$bbdd=new BBDD();
			$bbdd->conecta();
			$con=$bbdd->conexion;
		}
		if ($_SESSION['usuario']['USU_ROL_ID']==1){
			// usuario Administrador. Todos los usuarios
			$busca="Select * from incidencias where 1";
		}else{
			// usuario gerente
			//$busca1="select INC_ID,INC_FechaAlta,INC_Tipo,ING_Nombre,USU_Nombre FROM `incidencias`, `usuarios`, `ingredientes` WHERE INC_Tipo=1 and INC_idAfectado=ING_ID and INC_USU_ID=USU_ID and INC_NEG_ID=".$_SESSION['usuario']['USU_NEG_ID'];
			$busca="select INC_ID,INC_FechaAlta,INC_Tipo,ING_Nombre,USU_Nombre FROM `incidencias`, `usuarios`, `ingredientes` WHERE INC_Tipo=1 and INC_idAfectado=ING_ID and INC_USU_ID=USU_ID and INC_NEG_ID=".$_SESSION['usuario']['USU_NEG_ID']." UNION select INC_ID,INC_FechaAlta,INC_Tipo,TIT_Titulo,USU_Nombre FROM `incidencias`, `usuarios`, `escandallos_titulos` WHERE INC_Tipo=2 and INC_idAfectado=TIT_ESC_ID and TIT_IDI_ID=1 and INC_USU_ID=USU_ID and INC_NEG_ID=".$_SESSION['usuario']['USU_NEG_ID'];

		}
		$result = mysqli_query($con,$busca);
		$filas = mysqli_num_rows($result);
		while($row = mysqli_fetch_array($result)) {
			// añade elemento al array
			$misIncidencias[]=$row;
		}
		// Asigna el array a la sesion
		$_SESSION['MisIncidencias']=$misIncidencias;
		mysqli_free_result($result);
	}
	
	//Carga en tabla las INCIDENCIAS del negocio
	//--------------------------------------------------------------------------
	public function cargaTablaIncidencias(){
		$this->cargaIncidencias("no");
		// Cabecera de tabla.
		echo "<div class='table-responsive'>";
		echo "<table class='table table-striped table-sm table-bordered table-hover'>";
		echo '<thead class="thead-dark">';
			echo '<th>Fecha</th>';
			echo '<th>Tipo</th>';
			echo '<th>Afectado</th>';
			echo '<th>Usuario</th>';
			echo '<th>Eliminar</th>';
		echo '</thead>';		
        echo '<tbody>';
		if (isset($_SESSION['MisIncidencias'])){
			$misIncidencias=$_SESSION['MisIncidencias'];
			$numIncidencias=count($misIncidencias);
		}else{
			$numIncidencias=0;
		}
		for($i=0;$i<$numIncidencias;++$i){
			$row=$misIncidencias[$i];
			if ($row['INC_Tipo']=="1"){
				$tipo="1-Falta ingrediente";
			}else{
				$tipo="2-Falta plato";
			}
			echo "<tr>";
			echo "<td>".$row['INC_FechaAlta']."</td>";
			echo "<td>".$tipo."</td>";
			echo "<td>".$row['ING_Nombre']."</td>";
			echo "<td>".$row['USU_Nombre']."</td>";
			echo "<td>";
			echo "<button style ='border:0' onclick=\"confirmaBajaIncidencia('".$row['INC_ID']."','".$row['INC_Tipo']."','".$row['ING_Nombre']."');\"><img src='./Assets/Icons/eliminar.svg' alt='Eliminar' ></img></button>";
			echo "</td>";
			echo "</tr>";
		} 
		echo '</tbody>';
		echo '</table>'; 
		if ($numIncidencias==0){echo "No TIENE INCIDENCIAS. Si lo precisa, INTRODUZCALAS AQUI MISMO";}
		echo '</div>';
	}
}