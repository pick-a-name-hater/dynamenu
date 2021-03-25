<?php
/*-----------------------------------------------------------------------------
 * GESTIÓN DE SALAS
 -----------------------------------------------------------------------------*/
class sala {
    //declaración de propiedades
    
    //CONSTRUCTOR
    //-------------------------------------------------------------------------  
    function __construct(){
    }
	// ALTA DE  sala
    //-------------------------------------------------------------------------  
    public function inserta(){
		$ins="INSERT INTO `salas`(`SAL_ID`, `SAL_NEG_ID`, `SAL_Nombre`, `SAL_CoordX`, `SAL_CoordY`, `SAL_Ancho`, `SAL_Altura`) VALUES (";
		$ins=$ins."'0','".$_SESSION['usuario']['USU_NEG_ID']."','".$_REQUEST['inputNombreSala']."','0','0','0','0')";
		$con=$_SESSION['SGBD'];
		$result = mysqli_query($con,$ins);
		$filas=  mysqli_affected_rows($con);
		if ($filas>0){
			$_SESSION['error']="Sala añadida";
			$this->cargaSalas("si");
			return TRUE;
		}else{
			$_SESSION['error']="ERROR DESCONOCIDO EN EL ALTA DE SALA. CONSULTE CON EL ADMINISTRADOR".$ins;
			return FALSE;
		}
    }  
    
    //BORRA Sala
    //-------------------------------------------------------------------------  
    public function elimina(){
		$con=$_SESSION['SGBD'];
		$ejecuta="DELETE FROM salas WHERE SAL_ID=".$_REQUEST["inputSAL_ID"].";";
        mysqli_query($con,$ejecuta) or die("No he podido dar de BAJA la SALA<br>MySQL dice: ".mysql_error());
		$filas=  mysqli_affected_rows($con);
		if ($filas>0){
			$_SESSION['error']="He dado de baja la Sala:".$_REQUEST["inputSAL_ID"];
			$this->cargaSalas("si");
			return TRUE;
		}else{
			$_SESSION['error']="Error desconocido. NO SE HA DADO DE BAJA la SALA:".$ejecutaa;
			return FALSE;
		}
    } 
	//Carga en un array de session las salas del negocio
	//-------------------------------------------------------------------------------
	public function cargaSalas($fuerza){
		// Fuerza=true obliga a cargar
		if (!($fuerza=="si")){
			//echo "verifico si esta cargada...";
			// si no forzamos y Si estan cargados los usuarios no carga.
			if ((isset($_SESSION['MisSalas']))){
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
			$busca="Select * from salas where SAL_NEG_ID=".$_SESSION['usuario']['USU_NEG_ID'];
		}
		$result = mysqli_query($con,$busca);
		$filas = mysqli_num_rows($result);
		while($row = mysqli_fetch_array($result)) {
			// añade elemento al array
			$misSalas[]=$row;
		}
		// Asigna el array a la sesion
		$_SESSION['MisSalas']=$misSalas;
		mysqli_free_result($result);
	}
	
	//Carga en tabla las salas del negocio
	//--------------------------------------------------------------------------
	public function cargaTablaSalas(){
		$this->cargaSalas("no");
		// Cabecera de tabla.
		echo "<div class='table-responsive'>";
		echo "<table class='table table-striped table-sm table-bordered table-hover'>";
		echo '<thead class="thead-dark">';
			echo '<th>ID</th>';
			echo '<th>Nombre</th>';
			echo '<th>Eliminar</th>';
		echo '</thead>';		
        echo '<tbody>';
		if (isset($_SESSION['MisSalas'])){
			$misSalas=$_SESSION['MisSalas'];
			$numSalas=count($misSalas);
		}else{
			$numSalas=0;
		}
		for($i=0;$i<$numSalas;++$i){
			$row=$misSalas[$i];
			echo "<tr>";
			echo "<td>".$row['SAL_ID']."</td>";
			echo "<td>".$row['SAL_Nombre']."</td>";
			echo "<td>";
			echo "<button style ='border:0' onclick=\"confirmaBajaSala('".$row['SAL_ID']."','".$row['SAL_Nombre']."');\"><img src='./Assets/Icons/eliminar.svg' alt='Eliminar' ></img></button>";
			echo "</td>";
			echo "</tr>";
		} 
		echo '</tbody>';
		echo '</table>'; 
		if ($numSalas==0){echo "No TIENE SALAS. INTRODUZCALAS AQUI MISMO";}
		echo '</div>';
	}
	//Ofrece select para seleccion de SALAS
	//--------------------------------------------------------------------------
	public function selectSalas(){
		$this->cargaSalas("no");
		if (isset($_SESSION['MisSalas'])){
			$misSalas=$_SESSION['MisSalas'];
			$numSalas=count($misSalas);
		}else{
			$numSalas=0;
		}
		//echo "<select class=´'form-select' aria-label='Seleccion de Salas del restaurante' id='selectSalas' name='selectSalas' required placeholder='Sala'>";
		echo "<select class='form-control' name='selectSalas' id='selectSalas' required placeholder='Selecciona la Sala del restaurante'>";
		for($i=0;$i<$numSalas;++$i){
			$row=$misSalas[$i];
			echo "<option value='".$row['SAL_ID']."'>".$row['SAL_Nombre']."</option>";
		}
		echo "</select>";
	}
	//Da el nombre de una sala dada su id
	//--------------------------------------------------------------------------
	public function daNombreSala($idSala){
		$this->cargaSalas("no");
		foreach ($_SESSION['MisSalas'] as $sala){
			if ($idSala==$sala['SAL_ID']){
				return $sala['SAL_Nombre'];
			}
		}
	}
	
	
}
