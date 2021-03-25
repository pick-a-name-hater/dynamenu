<!------------------------------------------------------------------------------
PAGINA PAGINA DE INICIO DE DYNAMENU
------------------------------------------------------------------------------->
<!DOCTYPE html>
<html lang="es">
	<head>
		<?php include("includes/cabecera.php");?>
		<?php include("includes/cargajs.html"); ?> 
	</head>
	<body>
		<?php include("includes/barraNavegacion.php"); ?>
		<!-- Carrusel de imagenes --------------------------------->
		<div id="demo" class="carousel slide" data-ride="carousel">
		  <ul class="carousel-indicators">
			<li data-target="#demo" data-slide-to="0"></li>
			<li data-target="#demo" data-slide-to="1"></li>
			<li data-target="#demo" data-slide-to="2"></li>
			<li data-target="#demo" data-slide-to="3"></li>
			<li data-target="#demo" data-slide-to="4"></li>
			<li data-target="#demo" data-slide-to="5"></li>
		  </ul>
		  <div class="carousel-inner">
			<div class="carousel-item">
			  <img src="Assets/Images/Hosteleria1.jpg" width=100% height="400">
			  <div class="carousel-caption align: left" >
				<h3>Facil de crear y usar</h3>
				<p>Tu mismo podrás hacerlo siguiendo los pasos que te indicamos!!</p>
			  </div>   
			</div>
			<div class="carousel-item active">
			  <img src="Assets/Images/Hosteleria3.jpg" width=100% height="400">
			  <div class="carousel-caption">
				<h3>Económico</h3>
				<p>Por unos céntimos al día podrás cambiar la gestión de tu restaurante totalmente!</p>
			  </div>   
			</div>
			<div class="carousel-item">
			  <img src="Assets/Images/Hosteleria5.jpg" width=100% height="400">
			  <div class="carousel-caption">
				<h3>Profesional</h3>
				<p>Una mejor gestión de tu restaurante!</p>
			  </div>   
			</div>
			<div class="carousel-item">
			  <img src="Assets/Images/Hosteleria4.jpg" width=100% height="400">
			  <div class="carousel-caption">
				<h3>Digital</h3>
				<p>Todos los datos en la nube y seguros!</p>
			  </div>   
			</div>
			<div class="carousel-item">
			  <img src="Assets/Images/Hosteleria6.jpg" width=100% height="400">
			  <div class="carousel-caption">
				<h3>Adaptativo</h3>
				<p>Podrás gestionar tu restaurante desde el ordenador, el teléfono y la tablet!</p>
			  </div>   
			</div>
			<div class="carousel-item">
			  <img src="Assets/Images/Hosteleria8.jpg" width=100% height="400">
			  <div class="carousel-caption">
				<h3>Menores costes</h3>
				<p>Disminuye los errores y desplazamientos de tus camareros y cocineros!</p>
			  </div>   
			</div>
		  </div>
		  <a class="carousel-control-prev" href="#demo" data-slide="prev">
			<span class="carousel-control-prev-icon"></span>
		  </a>
		  <a class="carousel-control-next" href="#demo" data-slide="next">
			<span class="carousel-control-next-icon"></span>
		  </a>
		</div>
		
		<main>
            <!-- Contenido de la página -->
            <div class="container" bg-dark>
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            <center>La Carta dinámica para hosteleria</center>
                        </h1>
                    </div>
                    <div class="col-md-4">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4><i class="fa fa-fw fa-check"></i>Aspecto profesional</h4>
                            </div>
                            <div class="panel-body">
                                <p>La carta dinámica que puedes construir tu mismo a trav&eacute;s de este portal tiene todas las caracter&iacute;sticas necesarias para que puedas prestar el servicio r&aacute;pidamente.  Tu carta tendr&aacute; un aspecto profesional que podr&aacute;s personalizar.  Tambi&eacute;n prodr&aacute;s llevar la gesti&oacute;n de tu restuarante sin depender de nadie y realizarla en el momento que quieras</p>
                                <a href="caracteristicas.php" class="btn btn-primary">M&aacute;s....</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4><i class="fa fa-fw fa-gift"></i>Es econ&oacute;mica</h4>
                            </div>
                            <div class="panel-body">
                                <p>Puedes elegir el plan que mejor se adapte a tu negocio.  Tambi&eacute;n puedes elegir pagar solo por el uso.  En esta modalidad se cobrar&aacute; a m&eacute;s vencido por las visualizaciones de tu carta y los servicios que se hayan realizado en tu portal.  En esta modalidad pagar&aacute;s por los comandas, clientes, visitantes que ha tenido tu portal.</p>
                                <a href="caracteristicas.php" class="btn btn-primary">M&aacute;s....</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4><i class="fa fa-fw fa-compass"></i>F&aacute;cil de crear y usar</h4>
                            </div>
                            <div class="panel-body">
                                <p>Podr&aacute;s ver que lo f&aacute;cil que es crear tu propia carta diámica.  Nuestro portal te guiar&aacute; para que puedas realizar r&aacute;pidamente tu carta dinámica.  A trav&eacute;s de los tutoriales podr&aacute;s observar como realizar las tareas m&aacute;s comunes.  Tambi&eacute;n puedes usar nuestra ayuda en l&iacute;nea para aquellas dudas que no puedas resolver solo.</p>
                                <a href="caracteristicas.php" class="btn btn-primary">M&aacute;s....</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
		</main>
		<?php include("includes/pie.php"); ?>
	</body>
</html>
