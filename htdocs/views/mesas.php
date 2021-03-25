<!------------------------------------------------------------------------------
PAGINA DE SALAS Y MESAS
------------------------------------------------------------------------------->
<!DOCTYPE html>
<html lang="es">
	<head>
		<?php include("includes/cabecera.php");?>
		<?php include("includes/cargajs.html");?>
		<?php include("../modelo/sala.php");?>
		<?php include("../modelo/mesa.php");?>
		<?php include("../modelo/BBDD.php");?>
		<script type="text/javascript" src="./js/salaJQRY.js"></script>
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
                    <div class="col-md-4"><h2>Salas</h2></div>
                    <div class="col-md-8"><h2>Mesas</h2></div>
                </div> 
                <!--Formularios-->
                <div class="row" style="margin: 100">
                    <div class="col-md-4 width:30% ">
                        <div class="table-responsive">
                        <!--<div class="form row g-4">-->
							<form class="form-inline" style="width: 100%; align: center" name ="DatosSalas" method="POST" action="../controlador/controlador.php">
								<input type="text" width=100% class="form-control" id="inputNombreSala" name="inputNombreSala" required pattern='[A-Za-z ñÑáéíóúÁÉÍÓÚ]{3,50}' placeholder="Nombre de la Sala">
								<button type="submit" class="btn btn-primary" style="margin: 20">Añadir sala</button>
								<!-- Identificador de SALA -->
								<input type="text" name="inputSAL_ID" id="inputSAL_ID" value="2" class="sr-only form-control">
								<!--campos ocultos para el controlador -->
								<input type="text" name="objeto" id="objeto" value="sala" class="sr-only form-control">
								<input type="text" name="accion" id="accion" value="inserta" class="sr-only form-control">
								<input type="text" name="enlaceSI" id="enlaceSI" value="../views/mesas.php" class="sr-only form-control">
								<input type="text" name="enlaceNO" id="enlaceNO" value="../views/mesas.php" class="sr-only form-control">							
							</form>
                        </div>
                    </div>
					<br/><br/>
                    <div class="col-md-8">
                        <div class="table-responsive">
							<form class="form-inline" style="width: 100%; align: center" name ="DatosMesas" method="POST" action="../controlador/controlador.php">
								<input type="text" class="form-control" id="inputIdMesa"  name="inputIdMesa" required pattern="[0-9]{1,6}" placeholder="Nº de mesa">
								<input type="text" class="form-control" id="inputComensales" name="inputComensales" required pattern="[0-9]{1,6}" placeholder="Nº comensales">
								<!--SELECT PARA SELECCION DE SALA>-->
								<?php 
								     $sa=new sala(); 
									 $sa->selectSalas();
								?>
								<button type="submit" class="btn btn-primary" style="margin: 20">Añadir mesa</button>
								<!-- Identificador de MESA -->
								<input type="text" name="inputMES_ID" id="inputMES_ID" value="0" class="sr-only form-control">
								<input type="text" name="inputMES_SAL_ID" id="inputMES_SAL_ID" value="0" class="sr-only form-control">
								<!--campos ocultos para el controlador -->
								<input type="text" name="objeto" id="objetoMesa" value="mesa" class="sr-only form-control">
								<input type="text" name="accion" id="accionMesa" value="inserta" class="sr-only form-control">
								<input type="text" name="enlaceSI" id="enlaceSI" value="../views/mesas.php" class="sr-only form-control">
								<input type="text" name="enlaceNO" id="enlaceNO" value="../views/mesas.php" class="sr-only form-control">							

							</form>
                        </div>
                    </div>
                </div>
				<!--Tablas-->
                <div class="row" style="margin: 100">
                    <div class="col-md-4">
						<?php $sa=new sala(); $sa->cargaTablaSalas();?>
                    </div>
                    <div class="col-md-8">

							<?php $me=new mesa(); $me->cargaTablaMesas();?>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
<?php include('includes/pie.php') ?>
</body>
</html>