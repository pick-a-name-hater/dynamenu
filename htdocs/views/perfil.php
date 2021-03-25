<!------------------------------------------------------------------------------
PAGINA DE DATOS DEL usuario
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
	<?php $parametro = $_GET ["parametro"]; $miusuario=$_GET["miusuario"];?>
    <div class="container-fluid">
		<div class="row">
            <?php include('includes/menu_admin.php') ?>
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
					<?php
					switch ($parametro){
						case 2:
							// visualizacion desde empleados
							$_SESSION['miusuario']=$miusuario;
							echo "<h1>Perfil de:".$miusuario."</h1>";
							break;
						case 3:
							// edicion desde empleados
							$_SESSION['miusuario']=$miusuario;
							echo "<h1>Perfil de:".$miusuario."</h1>";
							break;
						default:
							// Mi perfil.
							$_SESSION['miusuario']=$_SESSION['usuario']['USU_ID'];
							$parametro=1;
							$miusuario=$_SESSION['usuario']['USU_ID'];
							echo "<h1>Mi perfil</h1>";
					}
					?>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <div class="btn-group me-2">
							<?php
							$pag="type='button' class='btn btn-primary' style='margin:5' onclick=\"location.href='CambioContraseña.php?miusuario=".$miusuario."'\";";
                            echo "<button ".$pag.">Cambiar contraseña</button>";
							?>
                        </div>
                    </div>
                </div> 
                <!--Formulario de perfil -->
				<?php
					$us=new usuario();
					$us->cargaDatosPerfil($miusuario,$parametro);
				?>
            </main>
        </div> <!--row-->
    </div>     
	<?php include('includes/pie.php') ?>
	<?php session_start();$_SESSION["error"]="";?>
</body>
</html>