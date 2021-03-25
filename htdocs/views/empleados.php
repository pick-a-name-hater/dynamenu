<!------------------------------------------------------------------------------
PAGINA DE EMPLEADOS
------------------------------------------------------------------------------->
<!DOCTYPE html>
<html lang="es">
	<head>
		<?php include("includes/cabecera.php");?>
		<?php include("includes/cargajs.html"); ?> 		
		<?php include("../modelo/usuario.php"); ?>
		<?php include("../modelo/BBDD.php"); ?>
		<script type="text/javascript" src="./js/usuariosJQRY.js"></script>
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
                    <h1>Empleados</h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <div class="btn-group me-2">
                            <button type="button" class="btn btn-primary" onclick="window.location='AltaEmpleado.php'">Añadir empleado</button>
                        </div>
                    </div>
                </div> 
                <!--Tabla de empleados -->
				Los empleados en Rojo están dados de baja y no podrán acceder al sistema. Los empleados en verde NO HAN CAMBIADO CONTRASEÑA.
				<?php
				   $us =new usuario();
				   $us->cargaEmpleados();
				?>
				<form name ="DatosEmpleados" method="POST" class="DatosEmpleados" action="../controlador/controlador.php">
					<!--campos ocultos para el controlador -->
					<input type="text" name="USU_ID_marcado" id="USU_ID_marcado" value="-1" class="sr-only form-control">
					<input type="text" name="USU_definitivo" id="USU_definitivo" value="no" class="sr-only form-control">
					<!--campos ocultos para el controlador -->
					<input type="text" name="objeto" id="objeto" value="usuario" class="sr-only form-control">
					<input type="text" name="accion" id="accion" value="elimina" class="sr-only form-control">
					<input type="text" name="enlaceSI" id="enlaceSI" value="../views/empleados.php" class="sr-only form-control">
					<input type="text" name="enlaceNO" id="enlaceNO" value="../views/empleados.php" class="sr-only form-control">
					<!-- añado campo oculto de mensaje para recepcionar mensajes -->
					<?php echo "<input type='text' name='error' id='error' value='".$_SESSION['error']."' class='sr-only form-control'>"?>
				</form>
            </main>
        </div> <!--row-->
    </div>     
	<?php include('includes/pie.php') ?>
	<?php session_start();$_SESSION["error"]="";?>
	</body>
</html>