<?php
/*-----------------------------------------------------------------------------
 * GESTIÓN DE COMANDAS
 -----------------------------------------------------------------------------*/
class comanda {
    //declaración de array de platos con incidencias.
    public $lineasComanda;    
    //CONSTRUCTOR
    //-------------------------------------------------------------------------  
    function __construct(){
	}
    //INSERTA comanda
    //-------------------------------------------------------------------------  
    public function inserta(){
        $ins="INSERT INTO `pedidos`(`PED_ID`, `PED_NEG_ID`, `PED_MES_ID`, `PED_CAMARERO_ID`, `PED_Recogida`, `PED_ADomicilio`, `PED_FechaHoraRecepcion`, `PED_FechaHoraEntrega`, `PED_FechaHoraCierre`) VALUES ";
        $ins=$ins."('0','".$_SESSION['usuario']['USU_NEG_ID']."','".$_REQUEST['inputMESA']."','".$_REQUEST['inputCamarero']."','0','0',CURRENT_TIMESTAMP,NULL,NULL)";
        echo "<br>".$ins."<br>";
        $con=$_SESSION['SGBD'];
		$result = mysqli_query($con,$ins);
		$filas=  mysqli_affected_rows($con);
        echo "filas: ".$filas."<br>";
        //$filas=0;
		if ($filas>-1){
			// codigo interno de comanda.
			$id_comanda=mysqli_insert_id($con);
            //Insertamos lineas de la comanda.
            //--------------------------------
            $numero = count($_REQUEST); // obtiene el número de parámetros.
            $tags = array_keys($_REQUEST);// obtiene los nombres de los parametros
            $valores = array_values($_REQUEST);// obtiene los valores de los parametros
            //crea las variables y les asigna el valor
            for($i=0;$i<$numero;$i++){
                $this->añadeLineasComanda($tags[$i],$valores[$i]);
            }
            //insertamos las lineas.
            foreach ($this->lineasComanda as $linea){
                $insl="INSERT INTO `pedidos_lineas`(`LIN_ID`, `LIN_PED_ID`, `LIN_Uds`, `LIN_ESC_ID`, `LIN_EST_ID`, `LIN_Observaciones`) VALUES ";
                $insl=$insl."('0','".$id_comanda."','".$linea[1]."','".$linea[0]."','1','".$linea[2]."')";
                echo "<br>".$insl."<br>";
                $result1 = mysqli_query($con,$insl);
            }
            unset($result1);
        }
        unset($result);
        $_SESSION['error']="Comanda añadida.";
        $this->cargaComandas("si");
    }
    // Añade una linea a la comanda dependiente de si recibe unidades o comentarios de la REQUEST
    //-------------------------------------------------------------------------------------------  
    function añadeLineasComanda($etiqueta,$valor){
        $inicio=substr($etiqueta,0,6);
        // SI No es una etiqueta para las lineas no hace nada
        if (!(($inicio=='Unidad') || ($inicio=='Coment'))){
            return;
        }
        // si el valor es 0  o vacio no hace nada.
        if (($valor=='0') ||($valor=='')){
            return;
        }
        // prepara si el valor es de las unidades o los comentarios
        if ($inicio=="Unidad"){
            $codigoPlato=substr($etiqueta,8);
            $ind=1;
            $unid=$valor;
            $comen="";
        }else{
            $codigoPlato=substr($etiqueta,11);
            $ind=2;
            $unid="";
            $comen=$valor;
        }
        $encontrada=FALSE;
        // Si lo encuentra actualiza el nuevo valor
        $i=0;
        foreach ($this->lineasComanda as $linea){
            if ($linea[0]==$codigoPlato){
                $this->lineasComanda[$i][$ind]=$valor;
                $encontrada=TRUE;
                break;
            }
            $i++;
        }
        // si no lo ha encontrado añade una nueva linea
        //echo "encontrada:".$encontrada." codigoPlato: ".$codigoPlato." unid: ".$unid." comen: ".$comen."<br>";
        if (!($encontrada)){
            //echo "HE AÑADIDO<br>";
            $this->lineasComanda[]=array($codigoPlato, $unid,$comen);
        }
    }

    //ELIMINA comanda
    //-------------------------------------------------------------------------  
    public function elimina(){
		$con=$_SESSION['SGBD'];
		$ejecuta="DELETE FROM pedidos WHERE PED_ID=".$_REQUEST["inputPED_ID"].";";
		echo $ejecuta;
        mysqli_query($con,$ejecuta) or die("No he podido dar de BAJA LA COMANDA <br>MySQL dice: ".mysql_error());
		$filas=  mysqli_affected_rows($con);
		if ($filas>-1){
			$_SESSION['error']="He dado de baja La comanda:".$_REQUEST["inputPED_ID"];
			$this->cargaComandas("si");
			return TRUE;
		}else{
			$_SESSION['error']="Error desconocido. NO SE HA DADO DE BAJA la COMANDA:".$ejecutaa;
			return FALSE;
        }
        $_SESSION['error']="Comanda eliminada :".$_REQUEST["inputPED_ID"];
    }
    //MODIFICA comanda
    //-------------------------------------------------------------------------  
    public function modifica(){
        $con=$_SESSION['SGBD'];
        // Modifica cabecera de comanda
        $upd="UPDATE `pedidos` SET `PED_MES_ID`='".$_REQUEST['inputMESA']."',`PED_Camarero_ID`='".$_REQUEST['inputCamarero']."' WHERE PED_ID=".$_REQUEST['idComanda'];
        $result=mysqli_query($con,$upd) or die("No he podido dar de MODIFICAR LA COMANDA <br>MySQL dice: ".mysql_error());
		$filas=  mysqli_affected_rows($con);
		if ($filas>-1){
            // Borra lineas de comanda
            $borrar="delete from `pedidos_lineas` where `LIN_PED_ID`=".$_REQUEST['idComanda'];
            mysqli_query($con,$borrar);
            // inserta nuevas lineas de comanda.
            $numero = count($_REQUEST); // obtiene el número de parámetros.
            $tags = array_keys($_REQUEST);// obtiene los nombres de los parametros
            $valores = array_values($_REQUEST);// obtiene los valores de los parametros
            //crea las variables y les asigna el valor
            for($i=0;$i<$numero;$i++){
                $this->añadeLineasComanda($tags[$i],$valores[$i]);
            }
            var_dump($this->lineasComanda);
            //insertamos las lineas.
            foreach ($this->lineasComanda as $linea){
                $insl="INSERT INTO `pedidos_lineas`(`LIN_ID`, `LIN_PED_ID`, `LIN_Uds`, `LIN_ESC_ID`, `LIN_EST_ID`, `LIN_Observaciones`) VALUES ";
                $insl=$insl."('0','".$_REQUEST['idComanda']."','".$linea[1]."','".$linea[0]."','1','".$linea[2]."')";
                $result1 = mysqli_query($con,$insl);
            }
            unset($result1);
        }
        unset($result);
        $this->recuperaComanda($_REQUEST['idComanda']);
        $_SESSION['error']="Comanda modificada :".$_REQUEST['idComanda'];
        $this->cargaComandas("si");
    }
    //CIERRA la comanda. asociado al cobro de la misma.
    //-------------------------------------------------------------------------  
    public function cierra(){
        $cierra="UPDATE `pedidos` SET `PED_FechaHoraCierre`=CURRENT_TIMESTAMP WHERE PED_ID=".$_REQUEST['inputPED_ID'];
        $_SESSION['error']="Comanda cerrada :".$_REQUEST['inputPED_ID'];
        $result=mysqli_query($con,$cierra) or die("No he podido CERRAR LA COMANDA <br>MySQL dice: ".mysql_error());
    }
    //PASE DE COCINA
    //-------------------------------------------------------------------------  
    public function paseCocina(){
        $numero = count($_REQUEST); // obtiene el número de parámetros de $_REQUEST
        $tags = array_keys($_REQUEST);// obtiene los nombres de los parametros
        $valores = array_values($_REQUEST);// obtiene los valores de los parametros
        $incLineas="";
        for($i=0;$i<$numero;$i++){
            $eslinea=substr($tags[$i],0,3);
            if ($eslinea=="LIN"){
                $incLineas=$incLineas.$valores[$i].",";
            }
        }
        $incLineas = " in (".substr($incLineas, 0, -1).")";
        echo "<br>".$incLineas."<br>";
        //Mira cambio en función de la accion a realizar
        switch ($_REQUEST['inputAccionPlatos']) {
            case 1:
                $aEstado=2;
                break;
            case 2:
                $aEstado=3;
                break;
            case 3:
                $aEstado=4;
                break;
        }        
        //insertamos las lineas.
        $modlineas="update pedidos_lineas set `LIN_EST_ID`=".$aEstado." where `LIN_ID` ".$incLineas; 
        echo "<br>".$modlineas."<br>";
    	$con=$_SESSION['SGBD'];
        $result1 = mysqli_query($con,$modlineas); 
        $filas=  mysqli_affected_rows($con);
        echo "filas: ".$filas;      
        unset($result1);
    }


	//Da la linea de datos generales de una comanda
	//--------------------------------------------------------------------------
	public function datosComanda($idComanda){
		if (!(isset($_SESSION['MisComandas']))){
			// No están cargadas o no hay comandas.
			$this->cargaComandas("no");
		}
		foreach ($_SESSION['MisComandas'] as $comDatos){
			if ($comDatos['PED_ID']==$idComanda){
				return $comDatos;
			}
		}
	}
	// Da nombre de la comanda
	//--------------------------------------------------------------------------
	public function daNombreComanda($idComanda){
        $comDatos=$this->datosComanda($idComanda);
        $nombre="Comanda: ".$comDatos['PED_ID']." <small>".$comDatos['PED_FechaHoraRecepcion']." Ubicacion: ".$comDatos['PED_MES_ID']."</small>";
		return $nombre;
	}    
	//Carga en un array de session las INCIDENCIAS del negocio
	//-------------------------------------------------------------------------------
	public function cargaComandas($fuerza){
		// Fuerza=true obliga a cargar
		if (!($fuerza=="si")){
			//echo "verifico si esta cargada...";
			// si no forzamos y Si estan cargados los usuarios no carga.
			if ((isset($_SESSION['MisComandas']))){
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
        switch ($_SESSION['usuario']['USU_ROL_ID']) {
            case 1:
                // usuario ADMINISTRADOR. Todos los usuarios
                $busca="Select * from pedidos where 1";
                break;
            case 2:
                // usuario GERENTE.  Ve todos los pedidos de su empresa.
                $busca="select * from pedidos where PED_NEG_ID=".$_SESSION['usuario']['USU_NEG_ID']." and PED_FechaHoraCierre is null";
                break;
            case 3:
                // usuario CAMARERO. Ve solo sus pedidos.
                $busca="select * from pedidos where PED_NEG_ID=".$_SESSION['usuario']['USU_NEG_ID']." and PED_CAMARERO_ID='".$SESSION['usuario'].['USU_ID']."' "." and PED_FechaHoraCierre is null";
                break;
            case 4:
                // usuario COCINERO.  Ve todos los pedidos de su empresa. Pero no tiene todos los permisos como el GERENTE
                $busca="select * from pedidos where PED_NEG_ID=".$_SESSION['usuario']['USU_NEG_ID']." and PED_FechaHoraCierre is null";
                break;
        }        
		$result = mysqli_query($con,$busca);
		$filas = mysqli_num_rows($result);
		while($row = mysqli_fetch_array($result)) {
			// añade elemento al array
			$misComandas[]=$row;
		}
		// Asigna el array a la sesion
		$_SESSION['MisComandas']=$misComandas;
		mysqli_free_result($result);
	}

	//Carga en tabla las COMANDAS ACTIVAS DEl negocio
	//--------------------------------------------------------------------------
	public function cargaTablaComandas(){
		$this->cargaComandas("no");
  		// Cabecera de tabla.
		echo "<div class='table-responsive'>";
		echo "<table class='table table-striped table-sm table-bordered table-hover'>";
		echo '<thead class="thead-dark">';
			echo '<th>Mesa</th>';
            echo '<th>Id</th>';
            echo '<th>Nombre Camarero</th>';
			echo '<th>Hora Alta</th>';
			//echo '<th>Comentarios</th>';
			echo '<th>Acciones</th>';
            echo '<th>Ver</th>';
			echo '<th>Modificar</th>';
			echo '<th>Eliminar</th>';
		echo '</thead>';		
        echo '<tbody>';
		if (isset($_SESSION['MisComandas'])){
			$misComandas=$_SESSION['MisComandas'];
			$numComandas=count($misComandas);
		}else{
			$numComandas=0;
		}
        //$sa=new sala();
        $me=new mesa();
		for($i=0;$i<$numComandas;++$i){
			$row=$misComandas[$i];
            $nomMesaCompleto=$me->daNombreMesa($row['PED_MES_ID']);
			echo "<tr>";
			echo "<td>".$nomMesaCompleto."</td>";

			echo "<td>".$row['PED_CAMARERO_ID']."</td>";
            $us=new usuario();
            $nomCamarero=$us->daNombreUsuario($row['PED_CAMARERO_ID']);
			echo "<td>".$nomCamarero."</td>";
			echo "<td>".$row['PED_FechaHoraRecepcion']."</td>";
			//echo "<td>".$row['']."</td>";
			$accionVisible="\"cierraComanda('".$row['PED_ID']."','".$row['PED_FechaHoraRecepcion']."','".$nomMesaCompleto."','".$nomCamarero."');\"";
            echo "<td><button style ='border:0' onclick=".$accionVisible."><img src='./Assets/Icons/hacer_visible.svg' alt='Ver detalle'></img></button></td>";
			$accionDetalle="\"location.href='altaComanda.php?estadoComanda=detalle&idComanda=".$row['PED_ID']."'\"";
			echo "<td><button style ='border:0' onclick=".$accionDetalle."><img src='./Assets/Icons/ver_detalle.svg' alt='Ver detalle'></img></button></td>";
			$accionModifica="\"location.href='altaComanda.php?estadoComanda=modifica&idComanda=".$row['PED_ID']."'\"";
			echo "<td><button style ='border:0' onclick=".$accionModifica."><img src='./Assets/Icons/editar.svg' alt='Editar'></img></button></td>";
			$accionBaja="\"eliminaComanda('".$row['PED_ID']."','".$row['PED_FechaHoraRecepcion']."','".$nomMesaCompleto."','".$nomCamarero."');\"";
			echo "<td><button style ='border:0' onclick=$accionBaja><img src='./Assets/Icons/eliminar.svg' alt='Eliminar' ></img></button></td>";
			echo "</tr>";
		} 
		echo '</tbody>';
		echo '</table>'; 
		if ($numComandas==0){echo "No TIENE COMANDAS. Si lo precisa, INTRODUZCALAS AQUI MISMO";}
		echo '</div>';
	}
  	//Recupera lineas de un pedido-comanda Para dar datos de la lineas
	//--------------------------------------------------------------------------
	public function recuperaComanda($idPedido){
		// Si tenemos  la conexión abierta no la hacemos
		if ((isset($_SESSION['SGDB']))){
			$con=$_SESSION['SGBD'];
		}else{
			$bbdd=new BBDD();
			$bbdd->conecta();
			$con=$bbdd->conexion;
		}        
        //$busca="select * from pedidos_lineas where LIN_PED_ID=".$idpedido;
        $busca="SELECT `LIN_ID`, `LIN_PED_ID`, `LIN_Uds`, `LIN_ESC_ID`, `LIN_EST_ID`, `LIN_Observaciones` FROM `pedidos_lineas` WHERE `LIN_PED_ID`='".$idPedido."'";
        //echo "ANTES:";
        $result9 = mysqli_query($con,$busca);
        //echo "despues..";
		$filas=  mysqli_num_rows($result9);
        //echo "filas: ".$filas;
		while($row = mysqli_fetch_array($result9)) {
  			$misLineasPedido[]=$row;
		}
        //echo "paso...";
        //session_start();
        $_SESSION['pedidoCargado']=$idPedido;
        $_SESSION['pedidoCargadoLineas']=$misLineasPedido;
    }
    // Da el contenido de un dato de las lineas
    //------------------------------------------------------------------------------------  
    // $miestado: alta,modifica,detalle
    // $tipdato: unidades,comentario
    // $idPedido: 
    // $idPlato.
    function daDatoLineaComanda($miestado,$tipDato,$idPedido,$idPlato){
        if ($miestado=="alta"){
            // no hay dato en la BBDD, en pantalla aparece vacio.
            return "";
        }
        // miro si tengo cargado el pedido en la session 
        $cargado="no";
        if(!(isset($_SESSION['pedidoCargado']))){
            $cargado="no";
        }else{
            if ($_SESSION['pedidoCargado']==$idPedido){
                $cargado="si";
            }else{
                $cargado="no";
            }
        }
        //echo "Estado:".$miestado." tipDato: ".$tipDato." idPedido: ".$idPedido." idPlato: ".$idPlato. "Cargado: ".$cargado;
        // si no lo tengo cargado lo cargo
        if ($cargado=="no"){
            //echo "a recuperar....";
            $this->recuperaComanda($idPedido);
            //echo "pasado.";
        }
        // ahora miro el dato solicitado.
        $dev="";
        foreach ($_SESSION['pedidoCargadoLineas'] as $linea){
            if($linea['LIN_ESC_ID']==$idPlato){
                switch ($tipDato) {
                    case "unidades":
                        $dev=$linea['LIN_Uds'];
                        break;
                    case "observaciones":
                        $dev=$linea['LIN_Observaciones'];
                        break;
                    case "estado":
                        $dev=$linea['LIN_EST_ID'];
                        break;
                    default:
                        $dev="";
                        break;
                }
                break; // del foreach;
            }
        }
        //echo "DEV: ".$dev;
        return $dev;
    }
	//Carga en tabla los platos de COMANDAS ACTIVAS que estan en estado: pedidos o preparandose
	//-----------------------------------------------------------------------------------------
	public function cargaPaseCocina($accion){
        switch ($accion) {
            case 1:
                $estadoLineas="(1,2)";
                break;
            case 2:
                $estadoLineas="(2)";
                break;
            case 3:
                $estadoLineas="(3)";
                break;
        } 
  		// Cabecera de tabla.
        $mesa=new mesa();
		echo "<div class='table-responsive'>";
		echo "<table class='table table-striped table-sm table-bordered table-hover'>";
		echo '<thead class="thead-dark">';
			echo '<th>Mesa</th>';
			echo '<th>Hora Alta</th>';
            echo '<th>SEL</th>';
            echo '<th>UDS</th>';
            echo '<th>Plato</th>';
			echo '<th>Comentarios</th>';
		echo '</thead>';		
        echo '<tbody>';
        $paseCo="SELECT `LIN_ID`, `LIN_PED_ID`, `LIN_Uds`, `LIN_ESC_ID`, `LIN_EST_ID`, `LIN_Observaciones`, ";
        $paseCo=$paseCo."`PED_MES_ID`, `PED_FechaHoraRecepcion`, ";
        $paseCo=$paseCo."`TIT_TITULO` ";
        $paseCo=$paseCo."FROM `pedidos_lineas` , `pedidos`, `escandallos_titulos` ";
        $paseCo=$paseCo."WHERE ";
        $paseCo=$paseCo."`LIN_EST_ID` in ".$estadoLineas." AND ";
        $paseCo=$paseCo."`PED_FechaHoraCierre` is null AND "; 
        $paseCo=$paseCo."`LIN_PED_ID` = `PED_ID` AND ";
        $paseCo=$paseCo."`TIT_ESC_ID` = `LIN_ESC_ID` AND `TIT_IDI_ID`='1' ";
        $paseCo=$paseCo."order by  `PED_FechaHoraRecepcion` ";
		// Si tenemos  la conexión abierta no la hacemos
		if ((isset($_SESSION['SGDB']))){
			$con=$_SESSION['SGBD'];
		}else{
			$bbdd=new BBDD();
			$bbdd->conecta();
			$con=$bbdd->conexion;
		}
 		$result = mysqli_query($con,$paseCo);
        $numPlatos=  mysqli_affected_rows($con);
        while($row = mysqli_fetch_array($result)) {
            $miMesa=$mesa->daNombreMesa($row['PED_MES_ID']);
            $deshabilita="";
            switch ($row['LIN_EST_ID']) {
                case 1:
                    $color="";
                    break;
                case 2:
                    if ($accion==1){
                        // Se muestran los ya marcados para tener imagen mental de la mesa
                        $color="class='text-danger'";
                        $deshabilita="disabled";
                    }else{
                        $color="";
                        $deshabilita="";
                    }
                    break;
                case 3:
                    $color="class='text-success'";
                    break;
                case 4:
                    $color="class='text-primary'";
                    break;
                default:
                    $color="";
                    break;
                        
            }             
			echo "<tr ".$color.">";
            echo "<td>".$miMesa."</td>";
            echo "<td>".$row['PED_FechaHoraRecepcion']."</td>";
            echo "<td><center><input class='form-check-input' type='checkbox' ",$deshabilita." name='LIN".$row['LIN_ID']."' value='".$row['LIN_ID']."' id='LIN".$row['LIN_ID']."'></center></td>";
            echo "<td>".$row['LIN_Uds']."</td>";
            echo "<td>".$row['TIT_TITULO']."</td>";
            echo "<td>".$row['LIN_Observaciones']."</td>";
			echo "</tr>";
		} 
		echo '</tbody>';
		echo '</table>'; 
		if ($numPlatos==0){echo "No TIENE PLATOS PARA SELECCIONAR";}
		echo '</div>';
	}
  

} //clase
?>