<!DOCTYPE html>
<html lang="es">
	<head>
		<?php include("includes/cabecera.php");?>
		<?php include("includes/cargajs.html"); ?> 		
	</head>
	<body>
	<?php session_start()?>
	<?php include('includes/barraNavegacionNegocio.html') ?>
	<br><br>
    <div class="container-fluid">
		<div class="row">
            <?php include('includes/menu_admin.php') ?>
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1>Comanda {IdPedido}</h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                    </div>
                </div> 
                <div><br><br><br></div>
                <div class="row">
                    <div class="col">
                        <div class="card"> <!-- style="width: 18rem; margin: 5">-->
                            <div class="card-header">
                                Mesa 3
                                <h6 class="card-subtitle mb-2 text-muted">2 pax - 14/07/2020 14:31</h6>
                            </div>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">1 salmorejo    2,50</li>
                                <li class="list-group-item">1 ensaladilla  2,50</li>
                                <li class="list-group-item">1 calamares    3,50</li>
                                <li class="list-group-item">1 calamares    3,50</li>
                                <li class="list-group-item">1 tarta queso  3,00</li>
                                <li class="list-group-item">1 hel pistacho 2,50</li>
                            </ul>
                            <div class="card-footer" style="text-align: right">
                                Total (IVA incluido): 17,50€
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <form>
                            <div class="form-label-group">
                                <label for="inputCantidad">Cantidad</label>
                                <input type="number" id="inputCantidad" name="inputCantidad" class="form-control" minlength="3" maxlength="40" required="required" title="Máxima longitud 40."autofocus="autofocus" >
                            </div>
                            <div class="form-label-group">
                                <label for="selectPlato">Plato</label>
                                <select class="form-control" id="selectPlato" name="selectPlato" required>
                                    <option disabled selected>--Selecciona el plato--</option>    
                                    <option>Calamares a la romana</option>
                                    <option>Salmorejo</option>
                                    <option>Solomillo de cerdo a la pimienta</option>
                                </select>
                            </div>
                            <div class="form-label-group">
                                <label for="inputObservaciones">Observaciones</label>
                                <input type="text" id="inputObservaciones" name="inputObservaciones" class="form-control" minlength="9" maxlength="9"  required="required">
                            </div>
                            <div><br></div>
                            <button class="btn  btn-lg btn-primary d-flex justify-content-between align-items-right" type="submit" style="margin-top: 20"  >
                                &#60; &#60; Añadir línea
                            </button>
                        </form>
                    </div>

                </div>

            </main>
        </div> <!--row-->
    </div>     
<?php include('includes/pie.php') ?>
</body>
</html>