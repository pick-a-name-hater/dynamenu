<!------------------------------------------------------------------------------
PAGINA de Registro de usuarios de DYNAMENU
------------------------------------------------------------------------------->
<!DOCTYPE html>
<html lang="es">
	<head>
		<?php include("includes/cabecera.php");?>
		<?php include("includes/cargajs.html"); ?> 		
		<?php include("../modelo/usuario.php"); ?>
		<?php include("../modelo/BBDD.php"); ?>
		<script src="./js/usuariosJQRY.js"></script>
	</head>
	<body>
	<?php 
        session_start();
        // Si no esta logado lo envia a hacerlo
        if (!(isset($_SESSION['usuario']))){
            header('Location: login');
        } 
    ?>
	<?php include('includes/barraNavegacion.php') ?>
	
    <main>
	<br><br><br>
	<div class="container" style="padding-top: 100">
		<div class="row" >
            <!-- Datos de acceso-->
			<div class="col-sm-12">
                <form style="width: 100%; align: center" name ="DatosRegistro" method="POST" action="../controlador/controlador.php">
					<h3>Datos de acceso</h3>
					<div class="form-label-group">
						<label for="inputEmail">Email</label>
						<input type="email" id="inputEmail" name="inputEmail" class="form-control" placeholder="Introduzca su Email" required="required"  autofocus="autofocus" minlength='4' title='Longitud máxima: 20' maxlength='20'>
					</div>
					<div class="form-label-group">
						<label for="inputPassword">Contraseña</label>
						<input type="password" id="inputContraseña" name="inputContraseña" class="form-control"  placeholder="********" required="required" minlength='4' title='Solo permite letras con un tamaño entre 4 y 20' maxlength='20' >
					</div>
					<div class="form-label-group">
						<label for="inputConfirma">Confirma la contraseña</label>
						<input type="password" id="inputConfirma" name="inputConfirma" class="form-control" placeholder="********" required="required" minlength='4' title='Solo permite letras con un tamaño entre 4 y 20' maxlength='20'>
					</div>

					<h3>Datos del negocio</h3>
					<div class="form-label-group">
						<label for="inputRazon">Razon Social (*)</label>
						<input type="text" id="inputRazon" name="inputRazon" class="form-control" placeholder="Razon social" required="required" autofocus="autofocus" minlength="3" maxlength="40" title="Mínima longitud 3, Máxima longitud 40.">
					</div>
					<div class="form-label-group">
						<label for="inputCIF">CIF (*)</label>
						<input type="text" id="inputCIF" name="inputCIF" class="form-ycontrol" pattern="/^(\d{8})([A-Z])$/| /^[XYZ]\d{7,8}[A-Z]$/|/^([ABCDEFGHJKLMNPQRSUVW])(\d{7})([0-9A-J])$/" placeholder="Introduza CIF, NIf o tarjeta de residente." required="required minlength="9" maxlength="9" title="Introduzca CIF empresa: X99999999, NIF personal: 99999999X Tarjeta de Residencia: X9999999X">
					</div>
					<div class="form-label-group">
						<label for="inputComercial">Nombre Comercial</label>
						<input type="text" id="inputComercial" name="inputComercial" class="form-control" placeholder="Nombre comercial" >
					</div>

					<h3>Datos del administrador</h3>
					<div class="form-label-group">
						<label for="inputNombre">Nombre (*)</label>
						<input type="text" id="inputNombre" name="inputNombre" class="form-control" placeholder="Nombre" required="required" autofocus="autofocus" minlength="3" pattern="[A-Za-z ñÑáéíóúÁÉÍÓÚ]{3,40}" title="Solo permite letras con un tamaño entre 3 y 40" maxlength="40">
					</div>
					<div class="form-label-group">
						<label for="inputApellidos">Apellidos  (*)</label>
						<input type="text" id="inputApellidos" name="inputApellidos" class="form-control" placeholder="Apellidos" required="required" pattern="[A-Za-z ñÑáéíóúÁÉÍÓÚ]{3,40}" title="Solo permite letras con un tamaño entre 3 y 50" maxlength="50" >
					</div>
					<div class="form-label-group">
						<label for="inputDNI">DNI  (*)</label>
						<input type="text" id="inputDNI" name="inputDNI" class="form-control" pattern="^([0-9]{8}[A-Z])|[XYZ][0-9]{7}[A-Z]$" placeholder="00000000T" required="required" minlength="9" maxlength="9"  required="required">
					</div>
					<div class="form-label-group">
						<label for="inputTelefono">Teléfono  (*)</label>
						<input type="text" id="inputTelefono" name="inputTelefono" class="form-control" placeholder="999999999" required="required" maxlength='9' pattern='[0-9]{9}' title='Solo permite números. Debe tener una longitud de 9.'>
					</div>
					<p style ="margin-top:20"><button class="btn  btn-lg btn-block btn-primary d-flex justify-content-between align-items-right" type="submit" style="margin-top: 20" >Dar de alta Servicio con estos datos</button></p>
					<!-- tipo de usuario -->
					<input type="text" name="inputROL_ID" id="inputROL_ID" value="2" class="sr-only form-control">
					<input type="text" name="inputNEG_ID" id="inputNEG_ID" value="" class="sr-only form-control">
					<!--campos ocultos para el controlador -->
					<input type="text" name="objeto" id="objeto" value="negocio" class="sr-only form-control">
					<input type="text" name="accion" id="accion" value="registro" class="sr-only form-control">
					<input type="text" name="enlaceSI" id="enlaceSI" value="../views/registro.php" class="sr-only form-control">
					<input type="text" name="enlaceNO" id="enlaceNO" value="../views/registro.php" class="sr-only form-control">
					<!-- añado campo oculto de mensaje para recepcionar mensajes -->
					<?php echo "<input type='text' name='error' id='error' value='".$_SESSION['error']."' class='sr-only form-control'>"?>					
                </form>
			</div>
        </div>
    </div>
    </main>
	<?php include('includes/pie.php') ?>
</body>
</html>