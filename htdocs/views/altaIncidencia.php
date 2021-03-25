<!------------------------------------------------------------------------------
PAGINA DE DATOS DEL NEGOCIO
------------------------------------------------------------------------------->
<!DOCTYPE html>
<html lang="es">
	<head>
		<?php include("includes/cabecera.php");?>
		<?php include("includes/cargajs.html"); ?>
		<?php include("../modelo/ingrediente.php"); ?>
		<?php include("../modelo/escandallo.php"); ?>		
        <?php include("../modelo/BBDD.php"); ?>
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
		<div class="row justify-content-center">
            <?php include('includes/menu_admin.php') ?>
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1>Alta Incidencia</h1>
                </div> 
                <div class="row justify-content-center">
                    <div class="col-md-9">
                    <form name="DatosIncidencia" method="POST" action="../controlador/controlador.php">
                        <!--<div class="col-md-9">-->
                            <div class="form-label-group">
                                <label for="inputTIPO">Tipo de incidencia:</label>
                                <select class="form-control" id="inputTIPO" name="inputTIPO" required placeholder="Tipo de incidencia">
                                    <option value="1">1-Falta ingrediente</option>
                                    <option value="2">2-Falta plato</option>
                                </select>
                            </div>
                            <div class="form-label-group" id="divIdAfectado" >
								<label for='inputidAfectado'>INGREDIENTE que nos falta:</label>
								<?php $ing=new ingrediente(); echo "<br/>"; $ing->selectIngredientes(); ?>
                            </div>
                            <div class="form-label-group" style="display: none" id="divPlatoAfectado" >
								<label for='inputPlatoAfectado'>PLATO que nos falta:</label>
								<?php $esc=new escandallo(); echo "<br/>"; $esc->selectPlatos(); ?>
                            </div>
                            <div><br></div>
                            <button class="btn  btn-lg btn-primary d-flex justify-content-between align-items-right" type="submit" style="margin: 200"  >
                                Dar de alta
                            </button>
                        <!--</div>-->
                        <!--campos ocultos para el controlador -->
                        <input type="text" name="objeto" id="objeto" value="incidencia" class="sr-only form-control">
                        <input type="text" name="accion" id="accion" value="inserta" class="sr-only form-control">
                        <input type="text" name="enlaceSI" id="enlaceSI" value="../views/incidencias.php" class="sr-only form-control">
                        <input type="text" name="enlaceNO" id="enlaceNO" value="../views/incidencias.php" class="sr-only form-control">
                        
                    </form>
                    </div>
                </div>
            </main>
        </div> <!--row-->
    </div>     
	<?php include('includes/pie.php') ?>
</body>
</html>