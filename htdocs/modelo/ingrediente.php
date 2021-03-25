<?php
/*-----------------------------------------------------------------------------
 * GESTIÓN DE INGREDIENTE
 -----------------------------------------------------------------------------*/
class ingrediente {
    //declaración de propiedades
    
    //CONSTRUCTOR
    //-------------------------------------------------------------------------  
    function __construct(){
    }
	// ALTA DE INGREDIENTE
    //-------------------------------------------------------------------------  
    public function inserta(){
		/*$hoy=date('d-m-Y h-i-s');
		$ins="INSERT INTO `ingredientes`(`ING_ID`, `ING_NEG_ID`, `ING_TIPO`, `ING_Nombre`, `ING_ALE_ID`) VALUES (";
		$ins=$ins."'0','".$_SESSION['usuario']['USU_NEG_ID']."','".$_REQUEST['input	ING_Tipo']."','".$_REQUEST['inputING_Nombre']."','".$_REQUEST['inputING_ALE_ID']."')";
		echo $ins;
		$con=$_SESSION['SGBD'];
		$result = mysqli_query($con,$ins);
		$filas=  mysqli_affected_rows($con);
		if ($filas>0){
			$_SESSION['error']="Ingrediente añadido";
			$this->cargaIngredientes("si");
			return TRUE;
		}else{
			$_SESSION['error']="ERROR DESCONOCIDO EN EL ALTA DE Ingrediente. CONSULTE CON EL ADMINISTRADOR".$ins;
			return FALSE;
		}*/
    }  
    
    //BORRA INGREDIENTE
    //-------------------------------------------------------------------------  
    public function elimina(){
		/*$con=$_SESSION['SGBD'];
		$ejecuta="DELETE FROM ingredientes WHERE ING_ID=".$_REQUEST["inputING_ID"].";";
		echo $ejecuta;
        mysqli_query($con,$ejecuta) or die("No he podido dar de BAJA el Ingrediente <br>MySQL dice: ".mysql_error());
		$filas=  mysqli_affected_rows($con);
		if ($filas>0){
			$_SESSION['error']="He dado de baja el Ingrediente:".$_REQUEST["inputING_ID"];
			$this->cargaIngredientes("si");
			return TRUE;
		}else{
			$_SESSION['error']="Error desconocido. NO SE HA DADO DE BAJA el Ingrediente:".$ejecutaa;
			return FALSE;
		}*/
    } 
	//Carga en un array de session las INGREDIENTES del negocio
	//-------------------------------------------------------------------------------
	public function cargaIngredientes($fuerza){
		// Fuerza=true obliga a cargar
		if (!($fuerza=="si")){
			//echo "verifico si esta cargada...";
			// si no forzamos y Si estan cargados los ingredientes no carga.
			if ((isset($_SESSION['MisIngredientes']))){
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
			$busca="Select * from ingredientes where 1 order by ING_Nombre";
		}else{
			// usuario gerente
			$busca="select ING_ID,ING_NEG_ID,ING_TIPO,ING_Nombre,ING_ALE_ID FROM `ingredientes` WHERE (ING_NEG_ID is null OR ING_NEG_ID='".$_SESSION['usuario']['USU_NEG_ID']."') order by ING_Nombre";
		}
		$result = mysqli_query($con,$busca);
		$filas = mysqli_num_rows($result);
		while($row = mysqli_fetch_array($result)) {
			// añade elemento al array
			$misIngredientes[]=$row;
		}
		// Asigna el array a la sesion
		$_SESSION['MisIngredientes']=$misIngredientes;
		mysqli_free_result($result);
	}
	
	//Carga en tabla las INGREDIENTES del negocio
	//--------------------------------------------------------------------------
	public function cargaTablaIngredientes(){
		/*$this->cargaIngredientes("no");
		// Cabecera de tabla.
		echo "<div class='table-responsive'>";
		echo "<table class='table table-striped table-sm table-bordered table-hover'>";
		echo '<thead class="thead-dark">';
			echo '<th>Id</th>';
			echo '<th>Tipo</th>';
			echo '<th>Nombre</th>';
			echo '<th>Alergeno</th>';
			echo '<th>Eliminar</th>';
		echo '</thead>';		
        echo '<tbody>';
		if (isset($_SESSION['MisIngredientes'])){
			$misIngrediente=$_SESSION['MisIngredientes'];
			$numIngredientes=count($misIngredientes);
		}else{
			$numIngredientes=0;
		}
		for($i=0;$i<$numIngredientes;++$i){
			$row=$misIngredientes[$i];
			echo "<tr>";
			echo "<td>".$row['ING_ID']."</td>";
			echo "<td>".$row['ING_Tipo']."</td>";
			echo "<td>".$row['ING_Nombre']."</td>";
			echo "<td>".$row['ING_ALE_ID']."</td>";
			echo "<td>";
			echo "<button style ='border:0' onclick=\"confirmaBajaIngrediente('".$row['ING_ID']."','".$row['ING_Tipo']."','".$row['ING_Nombre']."');\"><img src='./Assets/Icons/eliminar.svg' alt='Eliminar' ></img></button>";
			echo "</td>";
			echo "</tr>";
		} 
		echo '</tbody>';
		echo '</table>'; 
		if ($numIncidencias==0){echo "No TIENE INGREDIENTES. Si lo precisa, INTRODUZCALOS AQUI MISMO";}
		echo '</div>';*/
	}
	//Ofrece select y carga de productos para su seleccion en INGREDIENTES
	//--------------------------------------------------------------------------
	public function selectIngredientes(){
		$this->cargaIngredientes("no");
		// Si tenemos  la conexión abierta no la hacemos

		if ((isset($_SESSION['SGDB']))){
			$con=$_SESSION['SGBD'];
		}else{
			$bbdd=new BBDD();
			$bbdd->conecta();
			$con=$bbdd->conexion;
		}
		// ver si estamos en muestra detalle para deshabilitar seleccion
		if ($_SESSION['estadoEscandallo']=="detalle"){
			$deshabilito="disabled";
		}else{
			$deshabilito="";
		}
		// Carga tipos de productos
		if (isset($_SESSION['MisIngredientes'])){
			$misIngredientes=$_SESSION['MisIngredientes'];
			$numIngredientes=count($misIngredientes);
		}else{
			$numIngredientes=0;
		}
		echo "<select name='inputidAfectado' id='inputidAfectado' class='form-control' required placeholder='Seleccione Ingrediente' ".$deshabilito.">";
		for($i=0;$i<$numIngredientes;++$i){
			$row=$misIngredientes[$i];
			echo "<option value='".$row['ING_ID']."'>".$row['ING_Nombre']."</option>";
		}
		echo "</select>";
	}
	
}
