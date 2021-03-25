	<!-- BARRA DE NAVEGACIÓN DEL ADMINISTRADOR -->	
		<nav class="navbar navbar-expand-sm bg-dark navbar-dark fixed-top">
			<!-- Brand -->
			<a class="navbar-brand" href="#">DYNAMENU-A</a>

			<!-- Links -->
			<ul class="navbar-nav">
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
					Restaurantes
					</a>
					<div class="dropdown-menu">
						<a class="dropdown-item " href="#">Restaurantes</a>
						<a class="dropdown-item " href="#">Salas</a>
						<a class="dropdown-item " href="#">Mesas</a>
					</div>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="#">Cartas</a>
				</li>
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
					Cocina
					</a>
					<div class="dropdown-menu">
						<a class="dropdown-item" href="#">Pases de Cocina</a>
						<a class="dropdown-item" href="#">Escandallos</a>
						<a class="dropdown-item" href="#">Incidencias</a>
					</div>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="#">Comandero</a>
				</li>
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
					Configuración
					</a>
					<div class="dropdown-menu">
						<a class="dropdown-item" href="#">Idiomas</a>
						<a class="dropdown-item" href="#">Unidades de Medida</a>
						<a class="dropdown-item" href="#">Alérgenos</a>
					</div>
				</li>
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
					Usuarios
					</a>
					<div class="dropdown-menu">
						<a class="dropdown-item" href="#">Roles</a>
						<a class="dropdown-item" href="#">Usuarios</a>
					</div>
				</li>
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
					<span class="glyphicon glyphicon-user" aria-hidden="true"> </span><?php echo $_SESSION['usuario']['USU_Nombre']." ".$_SESSION['usuario']['USU_Apellidos'];?>
					</a>
					<div class="dropdown-menu">
						<a class="dropdown-item" href="#">Mi perfil</a>
						<a class="dropdown-item" href="desconectar.php">Desconectar</a>
					</div>
				</li>
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
					PROVISIONAL
					</a>
					<div class="dropdown-menu">
						<a class="dropdown-item" href="MODELusuarios.php">usuarios</a>
						<a class="dropdown-item" href="MODELperfil.php">Perfil</a>
						<a class="dropdown-item" href="registro.php">Registro</a>
						<a class="dropdown-item" href="MODELnegocio.php">Negocio</a>
						<a class="dropdown-item" href="MODELempleados.php">Empleados</a>
						<a class="dropdown-item" href="MODELescandallos">Escandallos</a>
						<a class="dropdown-item" href="MODELescandallos_detalle.php">Escandallos_detalle</a>
						<a class="dropdown-item" href="MODELincidencias">Incidencias</a>
					</div>
				</li>				
			</ul>
		</nav>
