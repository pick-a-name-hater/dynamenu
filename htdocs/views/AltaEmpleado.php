<!------------------------------------------------------------------------------
PAGINA PARA DAR DE ALTA EMPLEADOS
------------------------------------------------------------------------------->
<!DOCTYPE html>
<html lang="es">
	<head>
		<?php include("includes/cabecera.php");?>
		<?php include("includes/cargajs.html"); ?> 		
		<script type="text/javascript" src="./js/us		
		<?php include("includes/BBDD.html"); ?> uariosJQRY.js"></script>
	</head>
	<body>
	<?php 
		session_start();
		// No permite acceso si no estamos logados
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
                    <h1>Alta empleado</h1>
					<br>
                </div> 
                <!--Formulario de perfil -->
                <form name ="DatosPerfil" method="POST" action="../controlador/controlador.php">
					<div class="col-md-8">
                        <div class="form-label-group">
                            <label for="inputTipoEmpleado">Tipo de empleado(*)</label>
							<select class="form-control" name="inputROL_ID" id="inputROL_ID" required autofocus="">
								<option value="3">Camarero</option>
								<option value="4">Cocinero</option>
								<option value="2">Gerente</option>
							</select>
						</div>
                        <div class="form-label-group">
                            <label for="inputNombre">Nombre (*)</label>
							<input type="text" id="inputNombre" name="inputNombre" class="form-control"  minlength="3" pattern="[A-Za-z ñÑáéíóúÁÉÍÓÚ]{3,40}" title="Solo permite letras con un tamaño entre 3 y 40" maxlength="50" required="required" autofocus="autofocus" >
                        </div>
                        <div class="form-label-group">
                            <label for="inputApellidos">Apellidos (*)</label>
                            <input type="text" id="inputApellidos" name="inputApellidos" class="form-control" pattern="[A-Za-z ñÑáéíóúÁÉÍÓÚ]{3,40}" title="Solo permite letras con un tamaño entre 3 y 50" maxlength="50" required="required" >
                        </div>
                        <div class="form-label-group">
                            <label for="inputEmail">Email (*)</label>
                            <input type="email" id="inputEmail" name="inputEmail" class="form-control"  maxlength="40" required="required" >
                        </div>
                        <div class="form-label-group">
                            <label for="inputContraseña">Contraseña (*)</label>
                            <input type="text" id="inputContraseña" name="inputContraseña" maxlength="100" class="form-control" value="1234" required>
                        </div>
						<div>
						<br><br>
						<button class="btn  btn-lg btn-block btn-primary d-flex justify-content-between align-items-right" type="submit" style="margin-top: 20" >Dar de alta con estos datos</button>
						</di>
					</div>
					<!--campos ocultos para el controlador -->
					<input type="text" name="objeto" id="objeto" value="usuario" class="sr-only form-control">
					<input type="text" name="accion" id="accion" value="AltaEmpleado" class="sr-only form-control">
					<input type="text" name="enlaceSI" id="enlaceSI" value="../views/empleados.php" class="sr-only form-control">
					<input type="text" name="enlaceNO" id="enlaceNO" value="../views/AltaEmpleado.php" class="sr-only form-control">
                </form>
            </main>
        </div> <!--row-->
    </div>     
	<?php session_start();$_SESSION["error"]="";?>
	<?php include('includes/pie.php') ?>
</body>
</html>