<!------------------------------------------------------------------------------
PAGINA DE INCIDENCIAS
------------------------------------------------------------------------------->
<!DOCTYPE html>
<html lang="es">
	<head>

		<?php include("includes/cabecera.php");?>
		<?php include("includes/cargajs.html");?>
		<?php include("../modelo/incidencia.php");?>
		<script type="text/javascript" src="./js/incidencias.js"></script>
	</head>
	<body>
	<?php session_start()?>
	<?php include('includes/barraNavegacionNegocio.html') ?>
	<br><br>
    <!--<div class="container-fluid">
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
            </main>
        </div> 
    </div>-->     
	<?php include('includes/pie.php') ?>
	</body>
</html>