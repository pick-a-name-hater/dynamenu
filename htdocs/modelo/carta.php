<?php
/*-----------------------------------------------------------------------------
 * GESTIÓN DE CARTAS
 -----------------------------------------------------------------------------*/
class carta {
    //declaración de array de platos con incidencias.
    public $platosIncidencia = array();
    //CONSTRUCTOR
    //-------------------------------------------------------------------------  
    function __construct(){
	}
    //Obtiene la primera carta de un negocio.
    //-------------------------------------------------------------------------  
    public function primeraCarta($idCarta){
		// Si tenemos  la conexión abierta no la hacemos
		if ((isset($_SESSION['SGDB']))){
			$con=$_SESSION['SGBD'];
		}else{
			$bbdd=new BBDD();
			$bbdd->conecta();
			$con=$bbdd->conexion;
		}
        unset($_SESSION['carta']);
        // Si IdCarta es 0 se llama desde menús de administración y se obtiene la primera carta del negocio
        if ($idCarta==0){
            //obtengo las cartas del negocio
            $ejecuta="select * FROM cartas WHERE CAR_NEG_ID=".$_SESSION['usuario']['USU_NEG_ID']." and CAR_Activa='1' order by CAR_ID";
            $result = mysqli_query($con,$ejecuta) or die("mal<br>: ".mysql_error());
            $filas = mysqli_num_rows($result);
            if ($filas>0){
                while($row = mysqli_fetch_array($result)) {
                    $_SESSION['carta']=$row;
                    $idCarta=$_SESSION['carta']['CAR_ID'];
                    break;
                }
            }
        }else{
            $ejecuta="select * FROM cartas WHERE CAR_ID=".$idCarta." and CAR_Activa='1' order by CAR_ID";
            $result = mysqli_query($con,$ejecuta) or die("mal<br>: ".mysql_error());
            $filas = mysqli_num_rows($result);
            if ($filas>0){
                while($row = mysqli_fetch_array($result)) {
                    $_SESSION['carta']=$row;
                    break;
                }
            }
    
        }
        unset($result);
        unset($filas);
        unset($row);
        if (isset($_SESSION['carta'])){
            $this->datosCarta($idCarta);
        }
    }
    //Obtiene las secciones de la carta seleccionada
    //-------------------------------------------------------------------------  
    public function datosCarta($idCarta){
		$con=$_SESSION['SGBD'];
        $secIds="";
        // Carga las secciones de la carta seleccionada
		//$ejecuta="select * FROM cartas_secciones WHERE SEC_CAR_ID=".$_SESSION['carta']['CAR_ID']." order by SEC_ID";
		$ejecuta="select * FROM cartas_secciones WHERE SEC_CAR_ID=".$idCarta." order by SEC_ID";
		$result = mysqli_query($con,$ejecuta);
		$filas = mysqli_num_rows($result);
		if ($filas>0){
            while($row = mysqli_fetch_array($result)) {
                $misSecciones[]=$row;
                $secIds=$secIds.$row['SEC_ID'].",";
			}
        }
        $secIds = " in (".substr($secIds, 0, -1).")";
        $_SESSION['secciones']=$misSecciones;
        unset($result);
        unset($filas);
        unset($row);
        unset($misSecciones);
        // Cargo platos de las secciones
		$ejecuta="select * FROM secciones_lineas WHERE LIN_visible=1 and LIN_SEC_ID ".$secIds." order by LIN_SEC_ID,LIN_ID";
		$result = mysqli_query($con,$ejecuta);
		$filas = mysqli_num_rows($result);
		if ($filas>0){
            while($row = mysqli_fetch_array($result)) {
                $misPlatos[]=$row;
			}
        }
        $_SESSION['Platos']=$misPlatos;
        unset($result);
        unset($filas);
        unset($row);
        unset($misPlatos);
    }
    // Ofrece la carta visualmente
    //-------------------------------------------------------------------------  
    public function sacaCartaLogado(){
        if (!(isset($_SESSION['carta']))){
            return;
        }
        $esc=new escandallo();
        $this->obtienePlatosIncidencia();
        foreach ($_SESSION['secciones'] as $seccion){
            echo "<div class='container'>";
            $sec=TRUE;
            foreach ($_SESSION['Platos'] as $plato){
                if ($plato['LIN_SEC_ID']==$seccion['SEC_ID']){
                    // mira si tiene algun ingrediente con indicencia. Lo saca a carta si no lo tiene.
                    if($this->noTieneIncidencia($plato['LIN_ESC_ID'])){
                        if ($sec){
                            echo "<h4 class='seccion'>".$seccion['SEC_Descripcion']."</h4>";
                            $sec=FALSE;
                        }
                        echo "<div class='row'>";
                        echo "<div class='col-9'><p class='plato'>".$esc->daNombreEscandallo($plato['LIN_ESC_ID'])."</p></div>";
                        echo "</div>";
                        echo "<div class='row'>";
                        echo "<div class='col-9'><p class='descripcion'>".$esc->daDescripcionEscandallo($plato['LIN_ESC_ID'])."</p></div>";
                        echo "<div class='col-1'>".$esc->daPrecioEscandallo($plato['LIN_ESC_ID'])."€</div>";
                        echo "</div>";
                    }
                }
            }
            echo "</div>";
        }
    }
    // Ofrece la carta visualmente CUANDO NO ESTAMOS LOGADOS
    //-------------------------------------------------------------------------  
    public function sacaCarta(){
        if (!(isset($_SESSION['carta']))){
            return;
        }
        $esc=new escandallo();
        $this->obtienePlatosIncidencia();
        foreach ($_SESSION['secciones'] as $seccion){
            echo "<div class='container'>";
            $sec=TRUE;
            foreach ($_SESSION['Platos'] as $plato){
                if ($plato['LIN_SEC_ID']==$seccion['SEC_ID']){
                    // mira si tiene algun ingrediente con indicencia. Lo saca a carta si no lo tiene.
                    if($this->noTieneIncidencia($plato['LIN_ESC_ID'])){
                        if ($sec){
                            echo "<h4 class='seccion'>".$seccion['SEC_Descripcion']."</h4>";
                            $sec=FALSE;
                        }
                        // para sacar carta de fuera debemos ver una forma de no cargar los escandallos que dependen de el usuario
                        // de session que, desde fuera, no existe.
                        $sqldat="SELECT ESC_PrecioVenta, TIT_Titulo, TIT_Descripcion FROM `escandallos`, `escandallos_titulos` WHERE TIT_IDI_ID=1 and ESC_ID=TIT_ESC_ID and ESC_ID=".$plato['LIN_ESC_ID'];
                        //echo $sqldat;
                        $result = mysqli_query($_SESSION['SGBD'],$sqldat);
                        $filas = mysqli_num_rows($result);
                        if ($filas>0){
                            while($row = mysqli_fetch_array($result)) {
                                break;
                            }
                        }
                        echo "<div class='row'>";
                        echo "<div class='col-9'><p class='plato'>".$row['TIT_Titulo']."</p></div>";
                        echo "</div>";
                        echo "<div class='row'>";
                        echo "<div class='col-9'><p class='descripcion'>".$row['TIT_Descripcion']."</p></div>";
                        echo "<div class='col-1'>".$row['ESC_PrecioVenta']."€</div>";
                        echo "</div>";
                    }
                }
            }
            echo "</div>";
        }
    }
    // Carga platos con incidencia
    //-------------------------------------------------------------------------  
    public function obtienePlatosIncidencia(){
        //carga productos incidencias
		$con=$_SESSION['SGBD'];
        // incidencias de tipo 1 que falta ingrediente.
		$ejecuta="select ELI_ESC_ID from escandallos_lineas WHERE ELI_ING_ID in (select INC_IdAfectado from incidencias where INC_TIPO=1)";
		$result = mysqli_query($con,$ejecuta);
        while($row = mysqli_fetch_array($result)) {
            $this->platosIncidencia[]=$row['ELI_ESC_ID'];
        }
        // incidencias de tipo 2 que falta el plato directamente
		$ejecuta="select INC_IdAfectado from incidencias where INC_TIPO=2";
		$result1 = mysqli_query($con,$ejecuta);
        while($row1 = mysqli_fetch_array($result1)) {
            $this->platosIncidencia[]=$row1['INC_IdAfectado'];
        }
    }
    // Devuelve TRUE si el plato no tiene incidencia
    //-------------------------------------------------------------------------  
    public function noTieneIncidencia($idPlato){
        $noEncontrado=TRUE;
        foreach ($this->platosIncidencia as $valor){
            if ($valor==$idPlato){
                $noEncontrado=FALSE;
                break;
            }
        }
        return $noEncontrado;
        return TRUE;
    }
    // Da el nombre comercial del negocio de una carta
    //-------------------------------------------------------------------------  
    public function daNombreComercio($idCarta){
        $con=$_SESSION['SGBD'];
        $ejecuta="select NEG_NombreComercial FROM negocios, cartas where CAR_NEG_ID=NEG_ID and CAR_ID=".$idCarta;
        $result = mysqli_query($con,$ejecuta) or die("mal<br>: ".mysql_error());
        $nomc="";
        $filas = mysqli_num_rows($result);
        if ($filas>0){
            while($row = mysqli_fetch_array($result)) {
                $nomc=$row['NEG_NombreComercial'];
                break;
            }
        }
        return $nomc;
    }

    // Ofrece la tabla de elementos de la carta accesible para introducir datos de comanda
    //------------------------------------------------------------------------------------  
    public function cargaComanda($miEstado,$idPedido){
        $this->obtienePlatosIncidencia();
        if($miEstado=="detalle"){$dis="disabled";}else{$dis="";}
        $esc=new escandallo();
        $com=new comanda();
        echo "<table id='tablaComanda' class='table table-sm table-striped'>";
		echo '<thead class="thead-dark">';
			echo '<th>Precio</th>';
			echo '<th>Plato</th>';
			echo '<th>Unidades</th>';
			echo '<th>Observaciones</th>';
		echo '</thead>';		
        echo "<tbody>";
        foreach ($_SESSION['secciones'] as $seccion){
            foreach ($_SESSION['Platos'] as $plato){
                if ($plato['LIN_SEC_ID']==$seccion['SEC_ID']){
                    // mira si tiene algun ingrediente con incidencia. Lo saca a carta si no lo tiene.
                    if($this->noTieneIncidencia($plato['LIN_ESC_ID'])){
                        $nomUnidades="Unidades".$plato['LIN_ESC_ID'];
                        $nomComentarios="Comentarios".$plato['LIN_ESC_ID'];
                        echo "<tr>";
                            echo "<td class='' align='right'>".$esc->daPrecioEscandallo($plato['LIN_ESC_ID'])."</td>";
                            echo "<td class=''>".$esc->daNombreEscandallo($plato['LIN_ESC_ID'])."</td>";
                            echo "<td class='unidades'>";
                                $uds=$com->daDatoLineaComanda($miEstado,"unidades",$idPedido,$plato['LIN_ESC_ID']);
                                //echo "Unidades: ".$uds. "Estado: ".$miEstado." Pedido: ".$idPedido." ".$plato['LIN_ESC_ID']."<br>";
                                echo "<input type='number' class='form-control form-control-sm uds' min='0' max='100' ".$dis." placeholder='' name='".$nomUnidades."' id='".$nomUnidades."' value='".$uds."'>";
                            echo "</td>";
                            echo "<td class='observaciones'>";
                                $comentario=$com->daDatoLineaComanda($miEstado,"observaciones",$idPedido,$plato['LIN_ESC_ID']);
                                //echo "Comentario: ".$comentario."<br>";
                                echo "<input type='input' class='form-control form-control-sm ' ".$dis." placeholder='' name='".$nomComentarios."' id='".$nomComentarios."' value='".$comentario."'>";
                                echo "</td>";
                        echo "</tr>";
                    }
                }
            }
        }
        echo "</tbody>";
        echo "</table>";
    }

}//clase
?>
