<?php
/*-----------------------------------------------------------------------------
 * GESTIÓN DE MESAS
 -----------------------------------------------------------------------------*/
class mesa {
    //declaración de propiedades
    
    //CONSTRUCTOR
    //-------------------------------------------------------------------------  
    function __construct(){
    }
	// ALTA DE  mesa
    //-------------------------------------------------------------------------  
    public function inserta(){
		// OJO selectsalas obtener valor;
		$ins="INSERT INTO `mesas`(`MES_ID`, `MES_SAL_ID`, `MES_CoordX`, `MES_CoordY`, `MES_NPersonas`) VALUES (";
		$ins=$ins."'".$_REQUEST['inputIdMesa']."','".$_REQUEST['selectSalas']."','0','0','".$_REQUEST['inputComensales']."')";
		echo $ins;
		$con=$_SESSION['SGBD'];
		$result = mysqli_query($con,$ins);
		$filas=  mysqli_affected_rows($con);
		echo "Filas: ".$filas;
		if ($filas>0){
			$_SESSION['error']="Mesa añadida";
			$this->cargaMesas("si");
			$_SESSION['error']=$ins;
			return TRUE;
		}else{
			$_SESSION['error']="ERROR DESCONOCIDO EN EL ALTA DE MESA. CONSULTE CON EL ADMINISTRADOR".$ins;
			return FALSE;
		}
    }  
    
    //BORRA Mesa
    //-------------------------------------------------------------------------  
    public function elimina(){
		$con=$_SESSION['SGBD'];
		$ejecuta="DELETE FROM mesas WHERE MES_ID = '".$_REQUEST['inputMES_ID']."' and MES_SAL_ID='".$_REQUEST["inputMES_SAL_ID"]."';";
		$_SESSION['error']=$ejecuta;
        mysqli_query($con,$ejecuta) or die("No he podido dar de BAJA la MESA<br>MySQL dice: ".mysql_error());
		$filas=  mysqli_affected_rows($con);
		if ($filas>0){
			$_SESSION['error']="He dado de baja la Mesa:".$_REQUEST["inputMES_ID"];
			$this->cargaMesas("si");
			$_SESSION['error']="MESA ELIMINADA.";
			return TRUE;
		}else{
			$_SESSION['error']="Error desconocido. NO SE HA DADO DE BAJA la MESA:".$ejecuta;
			return FALSE;
		}
    } 
	//Carga Mesas
	//-------------------------------------------------------------------------------
	public function cargaMesas($fuerza){
		// Fuerza=true obliga a cargar
		if (!($fuerza=="si")){
			//echo "verifico si esta cargada...";
			// si no forzamos y Si estan cargados los usuarios no carga.
			if ((isset($_SESSION['MisMesas']))){
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
			$busca="Select * from salas where 1";
		}else{
			// usuario gerente
			$busca="SELECT SAL_ID,SAL_Nombre,MES_ID,MES_NPersonas FROM salas,mesas WHERE MES_SAL_ID=SAL_ID and SAL_NEG_ID='".$_SESSION['usuario']['USU_NEG_ID']."' Order by 2,3";
		}
		$result = mysqli_query($con,$busca);
		$filas = mysqli_num_rows($result);
		while($row = mysqli_fetch_array($result)) {
			// añade elemento al array
			$misMesas[]=$row;
		}
		// Asigna el array a la sesion
		$_SESSION['MisMesas']=$misMesas;
		mysqli_free_result($result);
	}
	
	//CARGA Tabla de mesas
	//--------------------------------------------------------------------------
	public function cargaTablaMesas(){
		$this->cargaMesas("no");
		// Cabecera de tabla.
		echo "<div class='table-responsive'>";
		echo "<table class='table table-striped table-sm table-bordered table-hover'>";
		echo '<thead class="thead-dark">';
			echo '<th>SALA</th>';
			echo '<th>Mesa</th>';
			echo '<th>Nº Comensales</th>';
			echo '<th>Eliminar</th>';
		echo '</thead>';		
        echo '<tbody>';
		if (isset($_SESSION['MisMesas'])){
			$misMesas=$_SESSION['MisMesas'];
			$numMesas=count($misMesas);
		}else{
			$numMesas=0;
		}
		for($i=0;$i<$numMesas;++$i){
			$row=$misMesas[$i];
			echo "<tr>";
			echo "<td>".$row['SAL_Nombre']."</td>";
			echo "<td>".$row['MES_ID']."</td>";
			echo "<td>".$row['MES_NPersonas']."</td>";
			echo "<td>";
			echo "<button style ='border:0' onclick=\"confirmaBajaMesa('".$row['SAL_ID']."','".$row['SAL_Nombre']."','".$row['MES_ID']."','".$row['MES_NPersonas']."');\"><img src='./Assets/Icons/eliminar.svg' alt='Eliminar' ></img></button>";
			echo "</td>";
			echo "</tr>";
		} 
		echo '</tbody>';
		echo '</table>';
		if ($numMesas==0){echo "No TIENE MESAS. INTRODUZCALAS AQUI MISMO";}		
		echo '</div>';
	}
	
	//SELECCIONA mesas desde comandas. Si enviamos miMesa es para que la seleccione por defecto. Y miesto=detalle le indica que deshabilita el control.
	//------------------------------------------------------------------------------------------------------------------------------------------------
	public function seleccionaMesas($mimesa,$miestado){
		$this->cargaMesas("no");
		if($miestado=="detalle"){$dis="disabled";}else{$dis="";}
		echo "<select class='form-control form-control-sm text-primary' ".$dis." id='inputMESA' name='inputMESA' required placeholder='Mesa de Sala en la que se situa la comanda'>";
		foreach ($_SESSION['MisMesas'] as $mesa){
			$ubica=$mesa['MES_ID'].'-'.$mesa['SAL_ID'];
			if ($ubica==$mimesa){$sel="selected";}else{$sel="";}
			echo "<option value='".$mesa['MES_ID'].'-'.$mesa['SAL_ID']."' ".$sel." ".$dis.">"."Mesa: ".$mesa['MES_ID']." de ".$mesa['SAL_Nombre']." (".$mesa['MES_NPersonas']." personas)</option>";
		}
		echo "</select>";
	}
	// Ofrece un nombre coloquial de una mesa basada en el formato MM-SS que se graba
	//------------------------------------------------------------------------------------------------------------------------------------------------
	public function daNombreMesa($mimesa){
		$this->cargaMesas("no");
		$nomMesa="";
		foreach ($_SESSION['MisMesas'] as $mesa){
			$ubica=$mesa['MES_ID'].'-'.$mesa['SAL_ID'];
			if ($ubica==$mimesa){
				$nomMesa="Mesa: ".$mesa['MES_ID']." de ".$mesa['SAL_Nombre']." (".$mesa['MES_NPersonas']." personas)";
				break;
			}
		}
		return $nomMesa;
	}

}
