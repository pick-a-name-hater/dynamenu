<!------------------------------------------------------------------------------
PAGINA PAGINA DE INICIO DE RESTAURANTE
------------------------------------------------------------------------------->
<!DOCTYPE html>
<html lang="es">
	<head>
		<?php include("includes/cabecera.php");?>
		<?php include("includes/cargajs.html"); ?>
		<style type="text/css">
			.jumbotron {
				margin-bottom: 0px;
				background-image: url(./Assets/Images/Fondo20.jpg);
				background-position: 0% 25%;
				background-size: cover;
				background-repeat: no-repeat;
				color: white;
				text-shadow: black 0.3em 0.3em 0.3em;
			}
		</style> 		
	</head>
	<body>
	<?php
		session_start();
        // Si no esta logado lo envia a hacerlo
        if (!(isset($_SESSION['usuario']))){
            header('Location: login');
        } 
		// Obtiene el tipo de usuario
		$us=$_SESSION['usuario']['USU_ROL_ID'];
		//$us=1;
		if ($us==1){
			//administrador del sistema. enlaza a comienzo.php
			$pagina="Location: comienzo.php"; header($pagina); 
		}
	?>
	<?php include('includes/barraNavegacionNegocio.html') ?>	<br><br>
    <div class="container-fluid">
		<div class="row">
            <?php include('includes/menu_admin.php') ?>
            <main class="col-md-12 ms-sm-auto col-lg-10 px-md-4">
                <div class=" justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                   
                    <!--<div class="btn-toolbar mb-2 mb-md-0">
                    </div>-->
					<div class="jumbotron jumbotron">
					<div class="cover-container text-center">
						
						<h1 class="display-1"><br><?php echo $_SESSION['negocio']['NEG_NombreComercial']; ?></h1>
						<h1 class="display-5"><br>Bienvenido a tu restaurante</h1>
						<h1 class="display-1"><br></h1>
						<p class="lead">Utiliza las opciones del menú para acceder a las diferentes opciones de la aplicación</p>
					</div>
					</div> 
				</div> 
            </main>
        </div> <!--row-->
    </div>     
	</div>
	<?php include("includes/pie.php");?>
	</body>
</html>
