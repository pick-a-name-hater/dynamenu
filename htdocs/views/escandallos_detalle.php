<!------------------------------------------------------------------------------
PAGINA DE INCIDENCIAS
------------------------------------------------------------------------------->
<!DOCTYPE html>
<html lang="es">
	<head>
		<?php include("includes/cabecera.php");?>
		<?php include("includes/cargajs.html"); ?> 	
       <!-- <script src="js/jquery-3.5.1.js"></script>	
        <script src="Bootstrap/js/bootstrap.js"></script>
        <script src="Bootstrap/js/bootstrap.bundle.min.js"></script-->
		<?php include("../modelo/escandallo.php"); ?> 		
		<?php include("../modelo/ingrediente.php"); ?> 
		<?php include("../modelo/BBDD.php"); ?> 	
		<script src="js/escandallosJQRY.js"></script>
	</head>
	<body>
	<?php 
        session_start();
        // Si no esta logado lo envia a hacerlo
        if (!(isset($_SESSION['usuario']))){
            header('Location: login');
		}
		$_SESSION['estadoEscandallo']=$_GET['estadoEscandallo'];
		$_SESSION['idEscandallo']=$_GET['idEscandallo'];
		$esc=new escandallo();
		if (!($_SESSION['estadoEscandallo']=="alta")){
			$datosEsc=$esc->datosEscandallo($_SESSION['idEscandallo']);
			$rotulo=$esc->daNombreEscandallo($_SESSION['idEscandallo']);
			$iRaciones=$datosEsc['ESC_Raciones'];
			$iCoste=$datosEsc['ESC_PrecioCoste'];
			$iPrecio=$datosEsc['ESC_PrecioVenta'];
			if ($_SESSION['estadoEscandallo']=="detalle"){
				$deshabilito="disabled";
			}else{
				$deshabilito="";
			}
		}else{
			$rotulo="Nombre del plato";
			$iRaciones="";
			$iCoste="";
			$iPrecio="";
			$deshabilito="";
		}
	?>
	<?php include('includes/barraNavegacionNegocio.html') ?>
	<br><br>
    <div class="container-fluid">
		<div class="row">
            <?php include('includes/menu_admin.php') ?>
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 id="tituloEscandallo"><?php echo $rotulo?></h1>
                    <div class="btn-toolbar mb-4 mb-md-0">l
                        <div class="btn-group me-2">
                        <button id="btnGuardaPlato" name="btnGuardaPlato" class="btn btn-primary" type="button" href="" <?php echo $deshabilito?>>Guardar</button>
                        </div>
                        <div class="btn-group me-2">
                        <button id="btnAtras" name="btnAtras" class="btn btn-warning" type="button" href="../views/escandallos.php">Atras</button>
                        </div>
                    </div>
                </div> 
				<form name="DatosEscandallo" id="DatosEscandallo" method="POST" action="../controlador/controlador.php">
					<ul class="nav nav-tabs" id="myTab" role="tablist">
						<li class="nav-item" role="presentation">
							<a class="nav-link active" id="titulos-tab" data-toggle="tab" href="#titulos" role="tab" aria-controls="profile" aria-selected="false">
								Títulos del escandallo
							</a>
						</li>
						<li class="nav-item" role="presentation">
							<a class="nav-link" id="datosGenerales-tab" data-toggle="tab" href="#datosGenerales" role="tab" aria-controls="home" aria-selected="true">
								Datos Generales
							</a>
						</li>
						<li class="nav-item" role="presentation">
							<a class="nav-link" id="lineas-tab" data-toggle="tab" href="#lineas" role="tab" aria-controls="contact" aria-selected="false">
								Líneas del escandallo
							</a>
						</li>
					</ul>
					<div class="tab-content" id="myTabContent">
						<div class="tab-pane fade show active" id="titulos" role="tabpanel" aria-labelledby="titulos-tab">
							<?php include('includes/escandallosTitulosTab.php') ?>
						</div> 

						<div class="tab-pane fade" id="datosGenerales" role="tabpanel" aria-labelledby="datosGenerales-tab">
							<?php include('includes/escandallosDatosGeneralesTab.php') ?>
						</div>

						<div class="tab-pane fade" id="lineas" role="tabpanel" aria-labelledby="lineas-tab" style="padding: 0">
							<?php include('includes/escandallosLineasTab.php') ?>
						</div>
					</div>
					<!--campos ocultos para el controlador -->
					<input type="text" name="objeto" id="objeto" value="escandallo" class="sr-only form-control">
					<input type="text" name="accion" id="accion" value="inserta" class="sr-only form-control">
					<input type="text" name="enlaceSI" id="enlaceSI" value="../views/escandallos.php" class="sr-only form-control">
					<input type="text" name="enlaceNO" id="enlaceNO" value="../views/escandallos.php" class="sr-only form-control">
					<!--<input type="text" name="tablaTs" id="tablaTs" value="" class="sr-only form-control">
					<input type="text" name="tablaLs" id="tablaLs" value="" class="sr-only form-control">-->
					<!-- Para pasar los datos a la REQUEST y al servidor -->
					<textarea name="tablaTs" id="tablaTs" cols="80" rows="10" class="sr-only form-control"></textarea>
					<textarea name="tablaLs" id="tablaLs" cols="80" rows="10" class="sr-only form-control"></textarea>
					<!-- Para pasar los datos de estado a Javascript -->
					<input type="text" name="estadoEscandallo" id="estadoEscandallo" value="<?php echo $_SESSION['estadoEscandallo']?>" class="sr-only form-control">
					<input type="text" name="idEscandallo" id="idEscandallo" value="<?php echo $_SESSION['idEscandallo']?>" class="sr-only form-control">
				</form>
            </main>

        </div> 
    </div>     
<?php include('includes/pie.php') ?>
</body>
</html>