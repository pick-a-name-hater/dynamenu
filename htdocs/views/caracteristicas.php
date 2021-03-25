<!------------------------------------------------------------------------------
PAGINA de Características de la aplicación
------------------------------------------------------------------------------->
<!DOCTYPE html>
<html lang="es">
	<head>
		<?php include("includes/cabecera.php");?>
        <?php include("includes/cargajs.html"); ?> 
	</head>
 <body>
	<div class=container>
	<header>
		<?php include('includes/barraNavegacion.php');?> 
	</header>
	<main>
        <div class="container" >
			<div class="row"><br><br><br></div>
			<div class="row">
                <!-- App web disponible desde cualquier dispositivo-->
                <div class="col-lg-4">
                    <!--<svg class="bd-placeholder-img rounded-circle" width="140" height="140" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: 140x140" preserveAspectRatio="xMidYMid slice" focusable="false"><title>Placeholder</title><rect width="100%" height="100%" fill="#777"/><text x="50%" y="50%" fill="#777" dy=".3em">140x140</text></svg>-->
					<div class="rounded-circle" width=140 height=140>
						<center><img src="Assets/Images/responsive.jpg" class="rounded-circle" width=140 height=140"></center>
					</div>

                    <h3><center>Disponible desde cualquier dispositivo</center></h3>
                    <ul>
                        <li>Aplicación web responsive</li>
                        <li>Gestión de empleados </li>
                        <li>Accesos controlados en función del cargo de los mismos</li>
                    </ul>
                </div>
                <!-- Carta digital-->
                <div class="col-lg-4">
                    <!--<svg class="bd-placeholder-img rounded-circle" width="140" height="140" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: 140x140" preserveAspectRatio="xMidYMid slice" focusable="false"><title>Placeholder</title><rect width="100%" height="100%" fill="#777"/><text x="50%" y="50%" fill="#777" dy=".3em">140x140</text></svg>-->
					<div class="rounded-circle" width=140 height=140>
						<center><img src="Assets/Images/CartaDigital.jpg" class="rounded-circle" width=140 height=140></center>
					</div>
                    <h3><center>Carta digital</center></h3>
                    <ul>
                        <li>Gestión de incidencias durante servicio</li>
                        <li>Generación y gestión de escandallos</li>
                        <li>Creación automática de la carta </li>
                        <li>Carta dinámica adaptable a las incidencias </li>
                    </ul>
                </div>
                <!--Control de incidencias-->
                <div class="col-lg-4">
                    <!--<svg class="bd-placeholder-img rounded-circle" width="140" height="140" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: 140x140" preserveAspectRatio="xMidYMid slice" focusable="false"><title>Placeholder</title><rect width="100%" height="100%" fill="#777"/><text x="50%" y="50%" fill="#777" dy=".3em">140x140</text></svg>-->
					<div class="rounded-circle" width=140 height=140>
						<center><img src="Assets/Images/SeguimientoPedidos.jpg" class="rounded-circle" width=140 height=140></center>
					</div>
                    <h3><center>Seguimiento de comandas</center></h3>
                    <ul>
                        <li>Comandero digital </li>
                        <li>Simulador de pase en cocina </li>
                        <li>Seguimiento de cada pedido en cada etapa hasta el cierre </li>
                    </ul>
                </div>
            </div>

            <hr class="featurette-divider">
            <div class="row featurette">
                <div class="col-md-7">
                    <h2 class="featurette-heading">Ventajas</h2>
                    <p class="lead">
                        Dynamenu está dirigido a ayudar a mejorar la calidad del servicio a negocios de restauración.</br>
                        Podrás tener acceso al control de tu negocio y de los pedidos a tiempo real y desde cualquier dispositivo, sin necesidad de estar allí presencialmente.
                        Las comandas se realizarán de forma más ágil, sin necesidad de trasladar al personal de sala, y se reducirán los fallos de comunicación. </br>
                        También se podrán personalizar los pedidos para  ofrecer una experiencia más completa al consumidor. </br>
                        Podrás gestionar que se ve en la carta en todo momento y se tendrán en cuenta automñaticamente las incidencias que puedan surgir durante el servicio, mejorando así la impresión de los clientes.
                    </p>
                </div>
                <div class="col-md-5">
					<img src="Assets/Images/Hosteleria10.jpg" width=100% height=100%>
                </div>
            </div>

            <hr class="featurette-divider">
            <div class="row featurette">
                <div class="col-md-7 order-md-2">
                    <h2 class="featurette-heading">Tarifas</h2>
                    <p class="lead">
                        Con DynaMenu podrás realizar un demo gratuita de un mes, sin compromiso alguno.</br>
                        <a id="btnRegistro" class="btn btn-lg btn-primary btn-block" href="registro" style="margin-top:20; margin-bottom:20">Pruebalo aquí</a>
                        El precio incluye soporte 24/7 y no tiene permanencia, se paga mensualmente, aunque si lo prefieres puedes obtener una oferta anual pagando 10 meses por un servicio de 12.
                        <h2 style="text-align: center"> 20€/mes por hosting del negocio</h2>
                        <h2 style="text-align: center">7€/mes por usuario</h2>
                    </p>
                </div>
                <div class="col-md-5 order-md-1">
					<img src="Assets/Images/Hosteleria7.jpg" width=100% height=100%>
                </div>
            </div>
            <hr class="featurette-divider">
        </div>
    </main>
	<footer>
        <?php include('includes/pie.php');?>
	</footer>
</body>
</html>