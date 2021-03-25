<!------------------------------------------------------------------------------
PAGINA de Logado de usuarios de DYNAMENU
------------------------------------------------------------------------------->
<!DOCTYPE html>
<html lang="es">
	<head>
		<?php include("includes/cabecera.php");?>
		<?php include("includes/cargajs.html");?>
	</head>
<body>
    <header>
        <?php include('includes/barraNavegacion.php') ?>  
    </header>
    <main>
	<div><br><br></div>
    <div class="container" style="padding-top: 100">
        <div class="row">
            <div class="col-lg-6 col-md-7 mx-auto">
				<!-- 
				formulario para logado de usuarios. Enlaza con el controlador mediante POST y pasa parámetros y
				el control mediante los valores de control objeto y accion
				-----------------------------------------------------------------------------------------------
				-->
				<br><br>
                <form class="form-signin" name ="datoslogado" method="POST" action="../controlador/controlador.php">
                    <div class="text-center mb-4">
                        <h1 class="h3 mb-3 font-weight-normal">Acceso Área de clientes</h1>
                    </div>
                    <div class="form-label-group">
                        <label for="inputEmail">Email</label>
                        <input name="inputEmail" type="email" id="inputEmail" class="form-control" placeholder="Email" required autofocus="">
                    </div>
                    <div class="form-label-group">
                        <label for="inputPassword">Contraseña</label>
                        <input name="inputPassword" type="password" id="inputPassword" class="form-control" placeholder="Password" required>
                    </div>
					<div><br><br></div>
                    <button class="btn btn-lg btn-primary btn-block" type="submit" style="margin-top:20">Acceso</button>
                    <p>¿Todavía no tienes cuenta? Solicitala a través de este <a href="registro">enlace</a>.</p>
					<!--campos ocultos para el controlador -->
					<input type="text" name="objeto" id="objeto" value="usuario" class="sr-only form-control">
					<input type="text" name="accion" id="accion" value="logado" class="sr-only form-control">
					<input type="text" name="enlaceSI" id="enlaceSI" value="../views/inicial.php" class="sr-only form-control">
					<input type="text" name="enlaceNO" id="enlaceNO" value="../views/login.php" class="sr-only form-control">
                </form>
            </div>
        </div>
    </div>
    </main>
	<?php include('includes/pie.php');?>
</body>
</html>