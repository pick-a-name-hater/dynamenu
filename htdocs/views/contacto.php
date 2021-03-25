<!------------------------------------------------------------------------------
PAGINA de contacto de DYNAMENU
------------------------------------------------------------------------------->
<!DOCTYPE html>
<html lang="es">
	<head>
		<?php include("includes/cabecera.php");?>
        <?php include("includes/cargajs.html"); ?> 
	</head>
<body>
    <header>
    </header>
    <main>
    <div class="container" style="padding-top: 100">
		<div class="row">
			<?php include('includes/barraNavegacion.php') ?>  
		</div>
		<div class="row"><br><br><br></div>
        <div class="row">
            <div class="col-lg-6 col-md-7 mx-auto">
                <form class="form-contact">
                    <div class="text-center mb-4">
                        <h1 class="h3 mb-3 font-weight-normal">Contacto</h1>
                    </div>
                    <div class="form-label-group">
                        <label for="inputNombre">Nombre (*)</label>
                        <input type="text" id="inputNombre" class="form-control" placeholder="Nombre" required="required" autofocus="autofocus">
                    </div>
                    <div class="form-label-group">
                        <label for="inputEmpresa">Empresa</label>
                        <input type="text" id="inputEmpresa" class="form-control" placeholder="Empresa">
                    </div>
                    <div class="form-label-group">
                        <label for="inputEmail">Email (*)</label>
                        <input type="email" id="inputEmail" class="form-control" placeholder="Email" required="required">
                    </div>
                    <div class="form-label-group">
                        <label for="inputMensaje">Mensaje (*)</label>
                        <textarea id="inputMensaje" class="form-control" placeholder="Escribe aquí tu consulta" required="required"></textarea>
                    </div>
                    <button class="btn btn-lg btn-primary btn-block" type="submit" style="margin-top: 20" >Enviar</button>
                </form>
            </div>
			<div class="col-lg-6 col-md-7 mx-auto">
				<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3038.288873932296!2d-3.682653699999999!3d40.40245089999999!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd42263d5df44893%3A0xff3aa06c8c7c1262!2sCalle+del+Comercio%2C+Madrid!5e0!3m2!1ses!2ses!4v1437901692371" width="600" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>  
			</div>
        </div>
    </div>
    </main>
	<footer>
		<?php include('includes/pie.php');?>
	</footer>
</body>
</html>
