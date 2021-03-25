<!------------------------------------------------------------------------------
PAGINA DE COMANDERO
------------------------------------------------------------------------------->
<!DOCTYPE html>
<html lang="es">
	<head>
		<?php include("includes/cabecera.php");?>
		<?php include("includes/cargajs.html"); ?> 		
	</head>
	<body>
	<?php session_start()?>
	<br><br>
	<?php include('includes/barraNavegacionNegocio.html') ?>
    <div class="container-fluid">
		<div class="row">
            <?php include('includes/menu_admin.php') ?>
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1>Comandero</h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <div class="btn-group me-2">
                            <a href="comanda" class="btn btn-primary">Añadir comanda</a>
                        </div>
                    </div>
                </div> 
                <!--Comandas -->
                <div class="row">
                    <div class="card" style="width: 18rem; margin: 5">
                        <div class="card-header">
                            <button  style="border:0"><img src=".\Assets\Icons\editar.svg" alt="editar"></img></button>
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
                    <div class="card" style="width: 18rem;margin: 5">
                        <div class="card-header">
                            <button  style="border:0"><img src=".\Assets\Icons\editar.svg" alt="editar"></img></button>
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
                    <div class="card" style="width: 18rem;margin: 5">
                        <div class="card-header">
                            <button  style="border:0"><img src=".\Assets\Icons\editar.svg" alt="editar"></img></button>
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
                    <div class="card" style="width: 18rem;margin: 5">
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
                    <div class="card" style="width: 18rem;margin: 5">
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
                    <div class="card" style="width: 18rem;margin: 5">
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
            </main>
        </div> <!--row-->
        <?php include('includes/pie.php') ?>
    </div>     
</body>
</html>