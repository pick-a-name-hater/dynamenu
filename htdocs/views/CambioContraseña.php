<!------------------------------------------------------------------------------
PAGINA DE Cambio de contraseña
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
	<!-- parametro nulo si perfil propio. 2 para ver perfil de un empleado. 3 para modificar el de un empleado.-->
	<?php  $miusuario=$_GET["miusuario"]; $us=new usuario();$miUsu=$us->daDatosUsuario($miusuario);?>
    <div class="container-fluid">
		<div class="row">
            <?php include('includes/menu_admin.php') ?>
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
				<div class='col-md-12'>
					<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
						<h1>Cambio de contraseña</h1>
						<h4><?php echo $miusuario." ".$miUsu['USU_Nombre']?></h4>
					</div> 
					<!--Formulario de cambio de contraseña -->
					<div class="col-md-12 d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
						<form name='CambioContraseña' method='post' action='../controlador/controlador.php'>
							<input name='id' type='hidden' value='<?php echo $miusuario?>'>
							<label>Introduce tu Contraseña actual<br>
							    <!--  MEDTER EN LOS CAMPOS PATRON PARA CONTRASEÑAS FUERTES DESPUES DE PRUEBAS : pattern='^(?=\w*\d)(?=\w*[A-Z])(?=\w*[a-z])\S{4,20}$' -->
								<input name='claveActual' id='claveActual' type='password' class='form-control'  minlength='4' title='Solo permite letras con un tamaño entre 4 y 20' maxlength='20' required>
							</label>
							<br><br>
							<label>Introduce tu nueva Contraseña<br>
								<input name='claveNueva1' id='claveNueva1' type='password' class='form-control'  minlength='4' title='Solo permite letras con un tamaño entre 4 y 20' maxlength='20' required>
							</label>
							<br><br>
							<label>Confirmar tu nueva Contraseña<br>
								<input name='claveNueva2' id='claveNueva2' type='password' class='form-control'  minlength='4' title='Solo permite letras con un tamaño entre 4 y 20' maxlength='20' required>
							</label>
							<br>
							<br>     
							<button type='submit' value='Actualizar' class='btn  btn-lg btn-primary d-flex justify-content-between align-items-right' style='margin-top: 20'>Actualizar contraseña</button> <br />
							<!--campos ocultos para el controlador -->
							<input type='text' name='objeto' id='objeto' value='usuario' class='sr-only form-control'>
							<input type='text' name='accion' id='accion' value='cambiaContraseña' class='sr-only form-control'>
							<input type='text' name='enlaceSI' id='enlaceSI' value='../views/empleados.php' class='sr-only form-control'>
							<input type='text' name='enlaceNO' id='enlaceNO' value='../views/CambioContraseña.php?miusuario=<?php echo $miusuario?>' class='sr-only form-control'>
						</form> 
					</div> 
				</div>
            </main>
        </div><!-- row --> 
    </div> 
	<?php include('includes/pie.php') ?>
	<?php session_start();$_SESSION["error"]="";?>
</body>
</html>