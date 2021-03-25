<!------------------------------------------------------------------------------
PAGINA DE ESCANDALLOS
------------------------------------------------------------------------------->
<!DOCTYPE html>
<html lang="es">
	<head>
		<?php include("includes/cabecera.php");?>
		<?php include("includes/cargajs.html"); ?> 		
		<?php include("../modelo/ingrediente.php"); ?> 	
		<?php include("../modelo/escandallo.php"); ?> 
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
    ?>
	<?php include('includes/barraNavegacionNegocio.html') ?>
	<br><br>
    <div class="container-fluid">
		<div class="row">
            <?php include('includes/menu_admin.php') ?>
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1>Escandallos</h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <div class="btn-group me-2">
                            <button type="button" class="btn btn-primary" onclick="location.href='escandallos_detalle.php?estadoEscandallo=alta&idEscandallo=0'">Añadir escandallo</button>
                        </div>
                    </div>
                </div> 
				<?php $es=new escandallo(); $es->cargaTablaEscandallos();?>
            </main>
        </div>
		<div class="row">
            <form name="DatosEscandallo" id="DatosEscandallo" method="POST" action="../controlador/controlador.php">
                <!--campos ocultos para el controlador -->
                <input type="text" name="idEscandallo" id="idEscandallo" value="" class="sr-only form-control">
                <input type="text" name="objeto" id="objeto" value="escandallo" class="sr-only form-control">
                <input type="text" name="accion" id="accion" value="elimina" class="sr-only form-control">
                <input type="text" name="enlaceSI" id="enlaceSI" value="../views/escandallos.php" class="sr-only form-control">
                <input type="text" name="enlaceNO" id="enlaceNO" value="../views/escandallos.php" class="sr-only form-control">
            </form>
        </div>
    </div>  
    <?php include('includes/pie.php') ?>	
</body>
</html>