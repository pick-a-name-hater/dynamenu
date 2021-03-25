<!------------------------------------------------------------------------------
PAGINA DE DATOS DEL NEGOCIO
------------------------------------------------------------------------------->
<!DOCTYPE html>
<html lang="es">
	<head>
		<?php include("includes/cabecera.php");?>
		<?php include("includes/cargajs.html"); ?>
        <?php include("../modelo/escandallo.php"); ?> 
        <?php include("../modelo/usuario.php"); ?> 
        <?php include("../modelo/mesa.php"); ?> 
        <?php include("../modelo/sala.php"); ?> 
		<?php include("../modelo/carta.php"); ?> 
        <?php include("../modelo/comanda.php");?>
		<?php include("../modelo/ingrediente.php"); ?>		
        <?php include("../modelo/BBDD.php"); ?>
        <script type="text/javascript" src="./js/comandaJQRY.js"></script>
	</head>
	<body>
	<?php 
		session_start();
        // No permite acceso si no estamos logados
        if (!(isset($_SESSION['usuario']))){
            header('Location: login');
        } 
		$_SESSION['estadoComanda']=$_GET['estadoComanda'];
		$_SESSION['idComanda']=$_GET['idComanda'];
		$com=new comanda();
        echo "Estado: ".$_SESSION['estadoComanda'];
		if (!($_SESSION['estadoComanda']=="alta")){
			$datosCom=$com->datosComanda($_SESSION['idComanda']);
			$rotulo=$com->daNombreComanda($_SESSION['idComanda']);
			if ($_SESSION['estadoComanda']=="detalle"){
				$deshabilito="disabled";
			}else{
				$deshabilito="";
			}
            $mesa=$datosCom['PED_MES_ID'];
            $camarero=$datosCom['PED_CAMARERO_ID'];
		}else{
			$rotulo="Nueva Comanda";
			$deshabilito="";
            $mesa="";
            $camarero="";
        }

    ?>
	<?php include('includes/barraNavegacionNegocio.html') ?>
	<br><br>
    <div class="container-fluid">
		<div class="row justify-content-center">
            <?php include('includes/menu_admin.php') ?>
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1><?php echo $rotulo ?></h1>
                </div> 
                <form id="FormDatosComanda" name="DatosComanda" method="POST" action="../controlador/controlador.php">
                    <div class="row justify-content-center">
                        <div class="col">
                            <?php $mes=new mesa(); $mes->seleccionaMesas($mesa,$_SESSION['estadoComanda']);?>
                        </div>
                        <div class="col">
                            <?php $usu=new usuario(); $usu->seleccionaUsuarios('3',$camarero,$_SESSION['estadoComanda']);?>
                        </div>
                        <button class="btn  btn-sm btn-dark " id="btnResume" type="button" >&nbspRESUME&nbsp</button>
                        <button style="display:none" class="btn  btn-sm btn-warning" id="btnExpande" type="button" >EXPANDE</button>
                    </div>
                    <div class="row">
                        <!--<div class="col-md-9">-->
                        <div class="col-sm">
                            <div class="table-responsive">
                                <?php $car=new carta();$car->primeraCarta(0);$car->cargaComanda($_SESSION['estadoComanda'],$_SESSION['idComanda']);?>
                            </div>
                        </div>
                        <!--<div class="col-md-3">-->
                        <button class="btn  btn-sm btn-primary " id="btnInserta" name="btnInserta" type="button" >&nbspINSERTA&nbsp</button>   
                        <button style="display:none" class="btn  btn-sm btn-success " id="btnVuelve" name="btnVuelve" type="button" >&nbspVUELVE&nbsp</button>   
                        <button style="display:none" class="btn  btn-sm btn-danger " id="btnModifica" name="btnModifica" type="button" >GUARDA&nbsp</button>   
                        <!--</div>-->
                    </div>
                    <!--campos ocultos para el controlador -->
                    <input type="text" name="objeto" id="objeto" value="comanda" class="sr-only form-control">
                    <input type="text" name="accion" id="accion" value="inserta" class="sr-only form-control">
                    <input type="text" name="enlaceSI" id="enlaceSI" value="../views/comandas.php" class="sr-only form-control">
                    <input type="text" name="enlaceNO" id="enlaceNO" value="../views/comandas.php" class="sr-only form-control">
                    <input type="text" name="estadoComanda" id="estadoComanda" value="<?php echo $_GET['estadoComanda']; ?>" class="sr-only form-control">
                    <input type="text" name="idComanda" id="idComanda" value="<?php echo $_GET['idComanda']; ?>" class="sr-only form-control">
                </form>
            </main>
        </div> <!--row-->
    </div>     
	<?php include('includes/pie.php') ?>
</body>
</html>