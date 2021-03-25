<?php
/*-----------------------------------------------------------------------------
 * GESTIÓN DE ESCANDALLOS
 -----------------------------------------------------------------------------*/
class escandallo {
    //declaración de propiedades
    public $deshabilito="";
    //CONSTRUCTOR
    //-------------------------------------------------------------------------  
    function __construct(){
		if ($_SESSION['estadoEscandallo']=='detalle'){
			$this->deshabilito="disabled";
		}else{
			$this->deshabilito="";
		}
	}
	// ALTA DE  ESCANDALLO
    //-------------------------------------------------------------------------  
    public function inserta(){
		$ins="INSERT INTO `escandallos`(`ESC_ID`, `ESC_NEG_ID`, `ESC_Raciones`, `ESC_CosteRacion`, `ESC_CoeficienteMerma`, `ESC_PesoRacion`, `ESC_PrecioCoste`, `ESC_PrecioVenta`) VALUES (";
		$ins=$ins."'0','".$_SESSION['usuario']['USU_NEG_ID']."','".$_REQUEST['inputRaciones']."','".$_REQUEST['inputCoste']."','0','0','".$_REQUEST['inputCoste']."','".$_REQUEST['inputPrecio']."')";
		echo $ins;
		$con=$_SESSION['SGBD'];
		$result = mysqli_query($con,$ins);
		$filas=  mysqli_affected_rows($con);
		if ($filas>-1){
			$_SESSION['error']="Escandallo añadido";
			// codigo de escandallo.
			$id_escandallo=mysqli_insert_id($con);
			$tta=new tableTOarray();
			$titulos=$tta->convierteARRAY($_REQUEST['tablaTs']);
			$lineas=$tta->convierteARRAY($_REQUEST['tablaLs']);
			$tta->muestraARRAY($titulos);
			$tta->muestraARRAY($lineas);
			// inserta los títulos
			foreach ($titulos as $fila){
				$inst="INSERT INTO `escandallos_titulos`(`TIT_ID`, `TIT_ESC_ID`, `TIT_IDI_ID`, `TIT_Titulo`, `TIT_Descripcion`) VALUES ";
				$inst=$inst."('0','".$id_escandallo."','".$fila[2]."','".$fila[0]."','".$fila[1]."')";
				$resulttit = mysqli_query($con,$inst);
			}
			// inserta las líneas.
			foreach ($lineas as $key => $fila){
				$insl="INSERT INTO `escandallos_lineas`(`ELI_ID`, `ELI_ESC_ID`, `ELI_ING_ID`, `ELI_Cantidad`, `ELI_UDS_ID`, `ELI_CosteUd`, `ELI_CosteTotal`, `ELI_CosteRacion`, `ELI_PorcentajeMerma`, `ELI_Esencial`) VALUES ";
				$insl=$insl."('0','".$id_escandallo."','".$fila[0]."','".$fila[6]."','".$fila[4]."','".$fila[7]."','".$fila[8]."','".$fila[9]."','".$fila[10]."','".$fila[2]."')";
				$resultlin = mysqli_query($con,$insl);
			}
			$this->cargaEscandallos("si");
			$_SESSION['error']="ESCANDALLO GUARDADO.";
			return TRUE;
		}else{
			$_SESSION['error']="ERROR DESCONOCIDO EN EL ALTA DE ESCANDALLO. CONSULTE CON EL ADMINISTRADOR".$ins;
			echo $_SESSION['error'];
			return FALSE;
		}
    }  
    
    //BORRA ESCANDALLO
    //-------------------------------------------------------------------------  
    public function elimina(){
		$con=$_SESSION['SGBD'];
		//borro lineas.
		$ejecuta="DELETE FROM escandallos_lineas WHERE ELI_ESC_ID=".$_REQUEST["idEscandallo"].";";
        mysqli_query($con,$ejecuta) or die("No he podido dar de BAJA las lineas del ESCANDALLO <br>MySQL dice: ".mysql_error());
		//borro titulos.
		$ejecuta="DELETE FROM escandallos_titulos WHERE TIT_ESC_ID=".$_REQUEST["idEscandallo"].";";
        mysqli_query($con,$ejecuta) or die("No he podido dar de BAJA los titulos del ESCANDALLO <br>MySQL dice: ".mysql_error());
		//borra cabecera de escandallo
		$ejecuta="DELETE FROM escandallos WHERE ESC_ID=".$_REQUEST["idEscandallo"].";";
        mysqli_query($con,$ejecuta) or die("No he podido dar de BAJA el ESCANDALLO <br>MySQL dice: ".mysql_error());
		$filas=  mysqli_affected_rows($con);
		if ($filas>-1){
			$_SESSION['error']="He dado de baja el ESCANDALLO:".$_REQUEST["idEscandallo"];
			$this->cargaEscandallos("si");
			$_SESSION['error']="ESCANDALLO ELIMINADO.";
			return TRUE;
		}else{
			$_SESSION['error']="Error desconocido. NO SE HA DADO DE BAJA el ESCANDALLO:".$ejecuta;
			return FALSE;
		}
    } 
    //Modifica ESCANDALLO.
    //-------------------------------------------------------------------------  
    public function modifica(){
		$ins="UPDATE `escandallos` SET `ESC_Raciones`='".$_REQUEST['inputRaciones']."',";
		$ins=$ins."`ESC_CosteRacion`='". $_REQUEST['inputCoste']."',";
		$ins=$ins."`ESC_CoeficienteMerma`='0',";
		$ins=$ins."`ESC_PesoRacion`='0',";
		$ins=$ins."`ESC_PrecioCoste`='".$_REQUEST['inputCoste']."',";
		$ins=$ins."`ESC_PrecioVenta`='".$_REQUEST['inputPrecio']."'";
		$ins=$ins." where ESC_ID=".$_REQUEST["idEscandallo"];
		//echo $ins;
		$con=$_SESSION['SGBD'];
		$result = mysqli_query($con,$ins);
		$filas=  mysqli_affected_rows($con);
		if ($filas>-1){
			$_SESSION['error']="Escandallo Modificado";
			// codigo de escandallo.
			$id_escandallo=$_REQUEST["idEscandallo"];
			$tta=new tableTOarray();
			$titulos=$tta->convierteARRAY($_REQUEST['tablaTs']);
			$lineas=$tta->convierteARRAY($_REQUEST['tablaLs']);
			//borro titulos anteriores.
			$ejecuta="DELETE FROM escandallos_titulos WHERE TIT_ESC_ID=".$_REQUEST["idEscandallo"].";";
			//echo $ejecuta;
			mysqli_query($con,$ejecuta) or die("No he podido dar de BAJA los titulos del ESCANDALLO <br>MySQL dice: ".mysql_error());
			// inserta los títulos
			foreach ($titulos as $fila){
				$inst="INSERT INTO `escandallos_titulos`(`TIT_ID`, `TIT_ESC_ID`, `TIT_IDI_ID`, `TIT_Titulo`, `TIT_Descripcion`) VALUES ";
				$inst=$inst."('0','".$id_escandallo."','".$fila[2]."','".$fila[0]."','".$fila[1]."')";
				$resulttit = mysqli_query($con,$inst);
			}
			//-----------------------------
			//Borra las lineas anteriores.
			$ejecuta="DELETE FROM escandallos_lineas WHERE ELI_ESC_ID=".$_REQUEST["idEscandallo"].";";
			//echo $ejecuta;
			mysqli_query($con,$ejecuta) or die("No he podido dar de BAJA las lineas del ESCANDALLO <br>MySQL dice: ".mysql_error());
			// inserta las líneas.
			foreach ($lineas as $fila){
				$insl="INSERT INTO `escandallos_lineas`(`ELI_ID`, `ELI_ESC_ID`, `ELI_ING_ID`, `ELI_Cantidad`, `ELI_UDS_ID`, `ELI_CosteUd`, `ELI_CosteTotal`, `ELI_CosteRacion`, `ELI_PorcentajeMerma`, `ELI_Esencial`) VALUES ";
				$insl=$insl."('0','".$id_escandallo."','".$fila[0]."','".$fila[6]."','".$fila[4]."','".$fila[7]."','".$fila[8]."','".$fila[9]."','".$fila[10]."','".$fila[2]."')";
				//echo $insl;
				$resultlin = mysqli_query($con,$insl);
			}
			//-----------------------------
			//Cargo los escandallos
			$this->cargaEscandallos("si");
			$_SESSION['error']="ESCANDALLO MODIFICADO.";
			return TRUE;
		}else{
			$_SESSION['error']="ERROR DESCONOCIDO EN EL MODIFICACIÓN DE ESCANDALLO. CONSULTE CON EL ADMINISTRADOR".$ins;
			echo $_SESSION['error'];
			return FALSE;
		}
    } 
	//Pone activo un escandallo para que pueda formar parte de las cartas
	//-------------------------------------------------------------------------------
	public function ponactivo(){
		//$act="update `escandallos` set `activo`= 1 where ESC_ID=".$_REQUEST['idEscandallo'];
	}


	//Carga en un array de session ESCANDALLOS del negocio
	//-------------------------------------------------------------------------------
	public function cargaEscandallos($fuerza){
		// Fuerza=true obliga a cargar
		if (!($fuerza=="si")){
			//echo "verifico si esta cargada...";
			// si no forzamos y Si estan cargados los usuarios no carga.
			if ((isset($_SESSION['MisEscandallos']))){
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
		// CARGA CABECERAS ESCANDALLO
		if ($_SESSION['usuario']['USU_ROL_ID']=='1'){
			// usuario Administrador. 
			$buscaE="Select * from escandallos where 1 order by ESC_ID";
			$buscaT="Select * from escandallos_titulos where 1 order by ESC_ID";
			$buscaL="Select * from escandallos_lineas where 1 order by ESC_ID";
		}else{
			// usuario gerente
			$buscaE="Select * from escandallos where ESC_NEG_ID=".$_SESSION['usuario']['USU_NEG_ID']." order by ESC_ID";
		}
		// ids de esta empresa
		$escIds="";
		$result = mysqli_query($con,$buscaE);
		$filas = mysqli_num_rows($result);
		if ($filas>0){
			while($row = mysqli_fetch_array($result)) {
				// añade elemento al array
				$misEscandallos[]=$row;
				$escIds=$escIds.$row['ESC_ID'].",";
			}
			$escIds = " in (".substr($escIds, 0, -1).")";
			$buscaT="Select * from escandallos_titulos where TIT_ESC_ID ".$escIds." order by TIT_ID";
			$buscaL="Select * from escandallos_lineas where ELI_ESC_ID ".$escIds." order by ELI_ID";
			//CARGA TITULOS DE ESCANDALLO
			$result1 = mysqli_query($con,$buscaT);
			//$filas = mysqli_num_rows($result1);
			while($row = mysqli_fetch_array($result1)) {
				// añade elemento al array
				$misEscandallosTitulos[]=$row;
			}
			//CARGA LINEAS DE ESCANDALLOS.
			$result2 = mysqli_query($con,$buscaL);
			//$filas = mysqli_num_rows($result2);
			while($row = mysqli_fetch_array($result2)) {
				// añade elemento al array
				$misEscandallosLineas[]=$row;
			}
			$_SESSION['MisEscandallos']=$misEscandallos;
			$_SESSION['MisEscandallosTitulos']=$misEscandallosTitulos;
			$_SESSION['MisEscandallosLineas']=$misEscandallosLineas;
			mysqli_free_result($result);
			mysqli_free_result($result1);
			mysqli_free_result($result2);
		}
		//CARGA IDIOMAS.
		if ((isset($_SESSION['MisIdiomas']))){
		}else{
			$result3 = mysqli_query($con,"select * from idiomas");
			$filas = mysqli_num_rows($result3);
			if ($filas>0){
				while($row = mysqli_fetch_array($result3)) {
					// añade elemento al array
					$misIdiomas[]=$row;
				}		
				// Asigna los array a la sesion
				$_SESSION['MisIdiomas']=$misIdiomas;
				//mysqli_free_result($result3);
			}
		}	
		//CARGA UNIDADES DE MEDIDA
		if ((isset($_SESSION['MisUnidades']))){
		}else{		
			$result4 = mysqli_query($con,"select * from udsmedida");
			$filas = mysqli_num_rows($result4);
			if ($filas>0){
				while($row = mysqli_fetch_array($result4)) {
					// añade elemento al array
					$misUnidades[]=$row;
				}		
				// Asigna los array a la sesion
				$_SESSION['MisUnidades']=$misUnidades;
				//mysqli_free_result($result4);
			}
		}
	}

	//Da la linea de datos generales de un escandallo
	//--------------------------------------------------------------------------
	public function datosEscandallo($idEscandallo){
		if (!(isset($_SESSION['MisEscandallos']))){
			// No están cargados o no hay escandallos.
			$this->cargaEscandallos("no");
		}
		foreach ($_SESSION['MisEscandallos'] as $escDatos){
			if ($escDatos['ESC_ID']==$idEscandallo){
				return $escDatos;
			}
		}
	}
	// Da nombre del escandallo
	//--------------------------------------------------------------------------
	public function daNombreEscandallo($idEscandallo){
		if (!(isset($_SESSION['MisEscandallosTitulos']))){
			// No están cargados o no hay escandallos.
			$this->cargaEscandallos("no");
		}
		$nombre="";
		foreach ($_SESSION['MisEscandallosTitulos'] as $lineTitulo){
			if ($lineTitulo['TIT_ESC_ID']==$idEscandallo){
				if ($lineTitulo['TIT_IDI_ID']=='1'){
					//Español
					$nombre=$lineTitulo['TIT_Titulo'];
					break;
				}
			}
		}
		return $nombre;
	}
	// Da Descripción del escandallo
	//--------------------------------------------------------------------------
	public function daDescripcionEscandallo($idEscandallo){
		if (!(isset($_SESSION['MisEscandallosTitulos']))){
			// No están cargados o no hay escandallos.
			$this->cargaEscandallos("no");
		}
		$nombre="";
		foreach ($_SESSION['MisEscandallosTitulos'] as $lineTitulo){
			if ($lineTitulo['TIT_ESC_ID']==$idEscandallo){
				if ($lineTitulo['TIT_IDI_ID']=='1'){
					//Español
					$nombre=$lineTitulo['TIT_Descripcion'];
					break;
				}
			}
		}
		return $nombre;
	}
	// Da el precio de una escandallo
	//--------------------------------------------------------------------------
	public function daPrecioEscandallo($idEscandallo){
		if (!(isset($_SESSION['MisEscandallos']))){
			// No están cargados o no hay escandallos.
			$this->cargaEscandallos("no");
		}
		$precio="";
		foreach ($_SESSION['MisEscandallos'] as $escandallo){
			if ($escandallo['ESC_ID']==$idEscandallo){
				$precio=$escandallo['ESC_PrecioVenta'];
			}
		}
		return $precio;
	}
	//Da el nombre de un escandallo, si lo hay., en español
	//--------------------------------------------------------------------------
	public function daNombreIdioma($idIdioma){
		if (!(isset($_SESSION['MisIdiomas']))){
			// No están cargados o no hay escandallos.
			$this->cargaEscandallos("no");
		}
		$nom="";
		foreach ($_SESSION['MisIdiomas'] as $id){
			if ($id['IDI_ID']==$idIdioma){
				$nom=$id['IDI_Descripcion'];
			}
		}
		return $nom;
	}
	//Da el nombre de Unidad
	//--------------------------------------------------------------------------
	public function daNombreUnidad($idUnidad){
		if (!(isset($_SESSION['MisUnidades']))){
			// No están cargados o no hay escandallos.
			$this->cargaEscandallos("no");
		}
		$nom="";
		foreach ($_SESSION['MisUnidades'] as $id){
			if ($id['UDS_ID']==$idUnidad){
				$nom=$id['UDS_Nombre'];
			}
		}
		return $nom;
	}
	//Da el texto de esencial. esencial=0 ==> NO ESENCIAL, esencial=1 ==> ESENCIAL
	//--------------------------------------------------------------------------
	public function daTextoEsencial($idEsencial){
		if ($idEsencial==0){
			return "NO ESENCIAL para el plato.";
		}else{
			return "ESENCIAL para el plato.";
		}
	}
	//Da el texto de esencial. esencial=0 ==> NO ESENCIAL, esencial=1 ==> ESENCIAL
	//--------------------------------------------------------------------------
	public function daNombreIngrediente($idIngrediente){
		if (!(isset($_SESSION['MisIngredientes']))){
			// No están cargados o no hay escandallos.
			$this->cargaEscandallos("no");
		}
		$nom="";
		foreach ($_SESSION['MisIngredientes'] as $id){
			if ($id['ING_ID']==$idIngrediente){
				$nom=$id['ING_Nombre'];
			}
		}
		return $nom;
	}	
	//Carga en tabla los ESCANDALLOS del negocio
	//--------------------------------------------------------------------------
	public function cargaTablaEscandallos(){
		$this->cargaEscandallos("no");
		// Cabecera de tabla.
		echo "<div class='table-responsive'>";
		echo "<table class='table table-striped table-sm table-bordered table-hover'>";
		echo '<thead class="thead-dark">';
			echo '<th>Nombre del plato</th>';
			echo '<th align="right">Raciones</th>';
			echo '<th align="right">Coste/ración</th>';
			echo '<th align="right">P.Venta/ración</th>';
			echo '<th>Activo</th>';
			echo '<th>Detalle</th>';
			echo '<th>Modificar</th>';
			echo '<th>Eliminar</th>';
		echo '</thead>';		
        echo '<tbody>';
		if (isset($_SESSION['MisEscandallos'])){
			$misEscandallos=$_SESSION['MisEscandallos'];
			$numEscandallos=count($misEscandallos);
		}else{
			$numEscandallos=0;
		}
		//$minombre=daNombreEscandallo($row['ESC_ID']);
		//echo "Nombre escandallo:"
		for($i=0;$i<$numEscandallos;++$i){
			$row=$misEscandallos[$i];
			// identifica fila con ESCXXX
			echo "<tr id='ESC".$row['ESC_ID']."'>";
			$nombreEscandallo=$this->daNombreEscandallo($row['ESC_ID']);
			echo "<td>".$nombreEscandallo."</td>";
			//echo "<td>".""."</td>";
			echo "<td align='right'>".$row['ESC_Raciones']."</td>";
			echo "<td align='right'>".$row['ESC_CosteRacion']."</td>";
			echo "<td align='right'>".$row['ESC_PrecioVenta']."</td>";
			$accionVisible="\"enCartaEscandallo('".$row['ESC_ID']."','".$nombreEscandallo."');\"";
			echo "<td><button style ='border:0' onclick=".$accionVisible."><img src='./Assets/Icons/hacer_visible.svg' alt='Ver detalle'></img></button></td>";
			$accionDetalle="\"location.href='escandallos_detalle.php?estadoEscandallo=detalle&idEscandallo=".$row['ESC_ID']."'\"";
			echo "<td><button style ='border:0' onclick=".$accionDetalle."><img src='./Assets/Icons/ver_detalle.svg' alt='Ver detalle'></img></button></td>";
			$accionModifica="\"location.href='escandallos_detalle.php?estadoEscandallo=modifica&idEscandallo=".$row['ESC_ID']."'\"";
			echo "<td><button style ='border:0' onclick=".$accionModifica."><img src='./Assets/Icons/editar.svg' alt='Editar'></img></button></td>";
			echo "<td>";
			//$accionBaja="\"\"";
			$accionBaja="\"eliminaEscandallo('".$row['ESC_ID']."','".$nombreEscandallo."');\"";
			echo "<button style ='border:0' onclick=$accionBaja><img src='./Assets/Icons/eliminar.svg' alt='Eliminar' ></img></button>";
			echo "</td>";
			echo "</tr>";
		} 
		echo '</tbody>';
		echo '</table>'; 
		if ($numEscandallos==0){echo "No TIENE ESCANDALLOS. INTRODUZCALOS AQUI MISMO";}
		echo '</div>';
	}
	//Ofrece select para seleccion Unidades de medida
	//--------------------------------------------------------------------------
	public function selectUnidades(){
		$this->cargaEscandallos("no");
		if (isset($_SESSION['MisUnidades'])){
			$misUnidades=$_SESSION['MisUnidades'];
			$numUnidades=count($misUnidades);
		}else{
			$numUnidades=0;
		}
		echo "<select class='form-control' id='selectUds' name='selectUds' required placeholder='Unidad que utilizaremos'".$this->deshabilito.">";
		for($i=0;$i<$numUnidades;++$i){
			$row=$misUnidades[$i];
			echo "<option value='".$row['UDS_ID']."'>".$row['UDS_Nombre']."</option>";
		}
		echo "</select>";
	}
	//Ofrece select para seleccion de ESCANDALLOS
	//--------------------------------------------------------------------------
	public function selectIdiomas(){
		$this->cargaEscandallos("no");
		if (isset($_SESSION['MisIdiomas'])){
			$misIdiomas=$_SESSION['MisIdiomas'];
			$numIdiomas=count($misIdiomas);
		}else{
			$numIdiomas=0;
		}
		echo "<select class='form-control' required id='selectIdioma' name='selectIdioma' placeholder='Idiomas de la carta'".$this->deshabilito.">";
		for($i=0;$i<$numIdiomas;++$i){
			$row=$misIdiomas[$i];
			echo "<option value='".$row['IDI_ID']."'>".$row['IDI_Descripcion']."</option>";
		}
		echo "</select>";
	}
	//Carga los titulos del escandallo especificado		
	//--------------------------------------------------------------------------
	public function cargaTablaTitulos($idEscandallo){
		$this->cargaEscandallos("no");
		// Cabecera de tabla.
		echo "<div class=' col-md-12 table-responsive'>";
		echo "<table class='table table-striped table-sm table-bordered table-hover' id='tablaTitulos' name='tablaTitulos' >";
		echo '<thead class="thead-dark">';
			echo '<th class="">Titulo</th>';
			echo '<th class="">Descripción</th>';
			echo "<th style='display:none;' class=''>Id</th>";
			echo '<th class="">Idioma</th>';
			echo '<th class="">Modifica</th>';
			echo '<th class="">Elimina</th>';
			echo '</thead>';		
        echo '<tbody>';
		if (isset($_SESSION['MisEscandallosTitulos'])){
			// selecciona los titulos de este escandallo
			if (!($_SESSION['estadoEscandallo']=='alta')){
				$alguno=0;
				foreach ($_SESSION['MisEscandallosTitulos'] as $row){
					if ($row['TIT_ESC_ID']==$_SESSION['idEscandallo']){
						$alguno++;
						$misTitulos[]=$row;
					}
				}
				if ($alguno>0){$numTitulos=count($misTitulos);}else{$numtitulos=0;}
			}else{
				$numTitulos=0;	
			}
		}else{
			$numTitulos=0;
		}
		//$numtitulos=0;
		for($i=0;$i<$numTitulos;++$i){
			$row=$misTitulos[$i];
			//identifica fila para borrados y modificaciones
			$miid="filaT".$i;
			echo "<tr id='".$miid."'>";
			echo "<td>".$row['TIT_Titulo']."</td>";
			echo "<td>".$row['TIT_Descripcion']."</td>";
			echo "<td  style='display:none;'>".$row['TIT_IDI_ID']."</td>";
			echo "<td>".$this->daNombreIdioma($row['TIT_IDI_ID'])."</td>";
			echo "<td><button ".$this->deshabilito." style ='border:0' class='modificaLinea' onclick='modificaFilaDeTitulos(".$miid.")'><img src='./Assets/Icons/editar.svg' alt='Modificar' ></img></button></td>";
			echo "<td><button ".$this->deshabilito." style ='border:0' class='eliminaTitulo' onclick='eliminaFilaDeTabla(".$miid.")'><img src='./Assets/Icons/eliminar.svg' alt='Eliminar' ></img></button></td>";
			echo "</tr>";
		}
		echo '</tbody>';
		echo '</table>';
		if ($numTitulos==0){
			echo "<div id='mensajeTitulos'>No TIENE DESCRIPCIONES DEL PLATO. INTRODUZCALAS AQUI MISMO</div>";
		}else{
			
		}
		echo '</div>';
	}
	//Carga las lineas del ESCANDALLOS seleccionado
	//--------------------------------------------------------------------------
	public function cargaTablaLineas($idEscandallo){
		$this->cargaEscandallos("no");
		// Cabecera de tabla.
		echo "<div class='table-responsive'>";
		echo "<table class='table table-striped table-sm table-bordered table-hover' id='tablaLineas' name='tablaLineas'>";
		echo '<thead class="thead-dark">';
			echo "<th style='display:none;'>IdI</th>";
			echo '<th>Ingrediente</th>';
			echo "<th style='display:none;'>IdE</th>";
			echo '<th>Esencial'.$idEscandallo.'</th>';
			echo "<th style='display:none;'>IdU</th>";
			echo '<th>Uds</th>';
			echo '<th>Cantidad</th>';
			echo '<th>Coste/ud</th>';
			echo '<th>CosteTotal</th>';
			echo '<th>Coste ración</th>';
			echo '<th>%Merma</th>';
			echo '<th>Modificar</th>';
			echo '<th>Eliminar</th>';
		echo '</thead>';		
        echo '<tbody>';
		if (isset($_SESSION['MisEscandallosLineas'])){
			// selecciona las líneas de este escandallo
			$alguno=0;
			foreach ($_SESSION['MisEscandallosLineas'] as $row){
				if ($row['ELI_ESC_ID']==$_SESSION['idEscandallo']){
					$misLineas[]=$row;
					$alguno++;
				}
			}
			if ($alguno>0){$numLineas=count($misLineas);}else{$numlineas=0;}
		}else{
			$numLineas=0;
		}

		for($i=0;$i<$numLineas;++$i){
			$row=$misLineas[$i];
			$miid="filaL".$i;
			echo "<tr id='".$miid."'>";
			//echo "<tr>";
			echo "<td style='display:none;'>".$row['ELI_ING_ID']."</td>";
			echo "<td>".$this->daNombreIngrediente($row['ELI_ING_ID'])."</td>"; //da nombre a ingrediente
			echo "<td style='display:none;'>".$row['ELI_Esencial']."</td>";
			echo "<td>".$this->daTextoEsencial($row['ELI_Esencial'])."</td>"; //da mnombre a esencial
			echo "<td style='display:none;'>".$row['ELI_UDS_ID']."</td>";
			echo "<td>".$this->daNombreUnidad($row['ELI_UDS_ID'])."</td>"; //da nombre unidad.
			echo "<td>".$row['ELI_Cantidad']."</td>";
			echo "<td>".$row['ELI_CosteUd']."</td>";
			echo "<td>".$row['ELI_CosteTotal']."</td>";
			echo "<td>".$row['ELI_CosteRacion']."</td>";
			echo "<td>".$row['ELI_PorcentajeMerma']."</td>";
			echo "<td><button ".$this->deshabilito." style ='border:0' class='modificaLinea' onclick='modificaFilaDeLineas(".$miid.")'><img src='./Assets/Icons/editar.svg' alt='Modificar' ></img></button></td>";
			echo "<td><button ".$this->deshabilito." style ='border:0' class='eliminaLinea' onclick='eliminaFilaDeTabla(".$miid.")'><img src='./Assets/Icons/eliminar.svg' alt='Eliminar' ></img></button></td>";
			echo "</tr>";
		} 
		echo '</tbody>';
		echo '</table>'; 
		if ($numLineas==0){echo "<div id='mensajeLineas'>No TIENE LINEAS DEL PLATO. INTRODUZCALAS AQUI MISMO</div>";}
		echo '</div>';
	}
	//Obtiene una select con todos los platos
	//-----------------------------------------------------------------------------------------------
	function selectPlatos(){
		$this->cargaEscandallos("no");
		if (isset($_SESSION['MisEscandallos'])){
			$misEscandallos=$_SESSION['MisEscandallos'];
			$numEscandallos=count($misEscandallos);
		}else{
			$numEscandallos=0;
		}
		echo "<select name='inputPlatoAfectado' id='inputPlatoAfectado' class='form-control' required placeholder='Seleccione Plato' >";
		for($i=0;$i<$numEscandallos;++$i){
			$row=$misEscandallos[$i];
			echo "<option value='".$row['ESC_ID']."'>".$this->daNombreEscandallo($row['ESC_ID'])."</option>";
		}
		echo "</select>";
	}

}
?>