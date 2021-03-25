<!------------------------------------------------------------------------------
PAGINA DE INCIDENCIAS
------------------------------------------------------------------------------->
<!DOCTYPE html>
<html lang="es">
	<head>

		<?php include("includes/cabecera.php");?>
		<?php include("includes/cargajs.html");?>
		<?php include("../modelo/incidencia.php");?>
		<?php include("../modelo/BBDD.php");?>
		<script type="text/javascript" src="./js/incidencias.js"></script>
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
                    <h1>Incidencias</h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <div class="btn-group me-2">
                            <button type="button" class="btn btn-primary" onclick="location.href='altaIncidencia.php'">Crear incidencia</button>
                        </div>
                    </div>
                </div> 
				<?php $in=new incidencia(); $in->cargaTablaIncidencias();?> 
				<form class="form-inline" style="width: 100%; align: center" name ="SelIncidencias" method="POST" action="../controlador/controlador.php">								<!-- Identificador de MESA -->
					<input type="text" name="inputINC_ID" id="inputINC_ID" value="0" class="sr-only form-control">
					<!--campos ocultos para el controlador -->
					<input type="text" name="objeto" id="objeto" value="incidencia" class="sr-only form-control">
					<input type="text" name="accion" id="accion" value="elimina" class="sr-only form-control">
					<input type="text" name="enlaceSI" id="enlaceSI" value="../views/incidencias.php" class="sr-only form-control">
					<input type="text" name="enlaceNO" id="enlaceNO" value="../views/incidencias.php" class="sr-only form-control">							
				</form>
            </main>
        </div> <!--row-->
    </div>  
	<?php echo $_SESSION['error'];?>	
	<?php include('includes/pie.php') ?>
	</body>
</html>