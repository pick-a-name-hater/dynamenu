<?php
/*-----------------------------------------------------------------------------
 * GESTIÓN DE USUARIOS
 -----------------------------------------------------------------------------*/
class usuario {
    //declaración de propiedades
    
    //CONSTRUCTOR
    //-------------------------------------------------------------------------  
    function __construct(){
    }
    //CONSTRUCTOR
    //-------------------------------------------------------------------------  
	public function logado(){
		$cqr=$_SESSION['SGBD'];
		//preparamos parámetros
		$email=$_REQUEST['inputEmail'];
		$email=htmlspecialchars($email,ENT_QUOTES,"UTF-8");
		$password=$_REQUEST['inputPassword'];
		$password=htmlspecialchars($password,ENT_QUOTES,"UTF-8");
		
		//---------------- VERSION TRADICIONAL ---------------------------------
		$query ="SELECT * from `usuarios` where USU_Email='$email' and USU_Contraseña='$password'";
		$result = mysqli_query($cqr,$query);
		$filas=  mysqli_num_rows($result);
		if ($filas>0){
			$row=mysqli_fetch_array($result,MYSQLI_BOTH);
			// Comprueba que no este dado de baja
			if (!($row['USU_FechaBaja'])){
				$_SESSION['miusuario']=$row['USU_ID'];
				$_SESSION['usuario']=$row;
				//carga los usuarios. siempre despues de asignar usuario de sesion.
				$this->cargaUsuarios("si");
				//cargamos los datos del restaurante
				$neg = new negocio();
				$exito=$neg->busca($row['USU_NEG_ID']);
				return TRUE;
			}else{
				$_SESSION['error']="Usuario dado de baja Temporalmente. Consulte con el administrador";	
				return FALSE;
			}
		}else{
			unset($_SESSION['usuario']);
			return FALSE;
		}
		//-----VERSION PREPARADA evitamos ataque de inyección SQL------------------------
		/*echo "ANTES PREPARE ". $email." --- ".$password;
		$query =$mysqli_prepare($cqr,"SELECT * from `usuarios` where USU_Email=? and USU_Contraseña=?;");
		mysqli_stmt_bind_param($query,"ss",$email,$password);
		mysqli_stmt_execute($query);
		echo $query."<br>";
		$result = mysqli_query($con,$query);
		$filas=  mysqli_num_rows($result);
		echo "PASADO";
		if ($filas>0){
			$row=mysqli_fetch_array($result,MYSQLI_BOTH);
			$_SESSION['usuario']=$row;
			return TRUE;
		}else{
			unset($_SESSION['usuario']);
			return FALSE;
		}*/
	}
    
    //Cambia la contraseña
    //-------------------------------------------------------------------------  
    public function cambiaContrasenia(){
		// Verifica si la contraseña actual introducidad es la correcta
		$miUsu=$this->daDatosUsuario($_REQUEST['id']);
		if ($_REQUEST['claveActual']==$miUsu['USU_Contraseña']){
			if ($_REQUEST['claveNueva1']==$_REQUEST['claveNueva2']){
				$cambia="UPDATE usuarios set USU_Contraseña='".$_REQUEST['claveNueva1']."' WHERE USU_ID=".$_REQUEST['id'];
				$_SESSION['error']=$cambia;
				$con=$_SESSION['SGBD'];
				$result = mysqli_query($con,$cambia);
				$filas=  mysqli_affected_rows($con);
				$_SESSION['error']="He cambiado la contraseña de acceso de:".$miUsu['USU_Nombre'];
				return TRUE;
			}else{
				$_SESSION['error']="La contraseña nueva no se ha repetido correctamente";
				return FALSE;
			}
		}else{
			$_SESSION['error']="No ha puesto la contraseña actual correctamente.  Cambio no permitido";
			return FALSE;
		}
		return FALSE;
    }
    
    // INSERTA USUARIO.
    //-------------------------------------------------------------------------  
    public function AltaEmpleado(){
		if (!($this->existeEmail($_REQUEST['inputEmail'],0))){
			// no existe el email indicado
			$con=$_SESSION['SGBD'];
			$hoy= date("Y-m-d");
			$ins="INSERT INTO `usuarios`(`USU_ID`, `USU_Email`, `USU_Contraseña`, `USU_NEG_ID`, `USU_ROL_ID`, `USU_Nombre`, `USU_Apellidos`, `USU_DNI`, `USU_NumeroSS`, `USU_CuentaBancaria`, `USU_Direccion`, `USU_Telefono1`, `USU_Telefono2`, `USU_FechaAlta`, `USU_FechaBaja`, `USU_Activo`) VALUES ";
			$ins=$ins."('0','";
			$ins=$ins.$_REQUEST['inputEmail']."','".$_REQUEST['inputContraseña']."','";
			if (isset($_REQUEST['inputNEG_ID'])){
				// Viene del registro 
				$ins=$ins.$_REQUEST['inputNEG_ID']."','";
			}else{
				// viene de la gestión de usuarios.
				$ins=$ins.$_SESSION['usuario']['USU_NEG_ID']."','";
			}
			$ins=$ins.$_REQUEST['inputROL_ID']."','".$_REQUEST['inputNombre']."','";
			$ins=$ins.$_REQUEST['inputApellidos']."','".$_REQUEST['inputDNI']."','','','','".$_REQUEST['inputTelefono']."','','".$hoy."',null,'1')";
			$result = mysqli_query($con,$ins);
			$filas=  mysqli_affected_rows($con);
			if ($filas>0){
				if (isset($_REQUEST['inputNEG_ID'])){
					// Viene de registro
					$_SESSION['error']="He registrado correctamente Restaurante y Gerente";
					//$_SESSION['error']="Filas: ".$filas." -- ".$ins;
					return TRUE;
				}else{				
					//añade a la tabla de usuarios sin recargar todos los usuarios
					$misUsuarios=$_SESSION['MisUsuarios'];
					$numUsuarios=count($misUsuarios);
					// añado la ultima fila
					$misUsuarios[]=$misUsuarios[$numUsuarios-1];
					//le doy los valores actuales.
					$misUsuarios[$numUsuarios]['USU_ID']=mysqli_insert_id($con);
					$misUsuarios[$numUsuarios]['USU_Email']=$_REQUEST['inputEmail'];
					$misUsuarios[$numUsuarios]['USU_Contraseña']=$_REQUEST['inputContraseña'];
					$misUsuarios[$numUsuarios]['USU_USU_NEG_ID']=$_SESSION['usuario']['USU_NEG_ID'];
					$misUsuarios[$numUsuarios]['USU_USU_ROL_ID']=$_REQUEST['inputROL_ID'];
					$misUsuarios[$numUsuarios]['USU_Nombre']=$_REQUEST['inputNombre'];
					$misUsuarios[$numUsuarios]['USU_Apellidos']=$_REQUEST['inputApellidos'];
					$misUsuarios[$numUsuarios]['USU_DNI']="";
					$misUsuarios[$numUsuarios]['USU_NumeroSS']="";
					$misUsuarios[$numUsuarios]['USU_CuentaBancaria']="";
					$misUsuarios[$numUsuarios]['USU_Direccion']="";
					$misUsuarios[$numUsuarios]['USU_Telefono1']="";
					$misUsuarios[$numUsuarios]['USU_Telefono2']="";
					$misUsuarios[$numUsuarios]['USU_FechaAlta']=$hoy;
					$misUsuarios[$numUsuarios]['USU_FechaBaja']="";
					$misUsuarios[$numUsuarios]['USU_Activo']="1";
					//modifica la variable de sesion
					$_SESSION['MisUsuarios']=$misUsuarios;
					// recarga la tabla de usuarios
					//$this->cargaUsuarios("si");
					$_SESSION['error']="He dado de alta el empleado. No olvide comunicarle su contraseña e indicarle que entre en su perfil para cambiarla y completar su perfil";
					return TRUE;
				}
			}else{
				$_SESSION['error']="ERROR DESCONOCIDO EN EL ALTA. CONSULTE CON EL ADMINISTRADOR".$ins;
				return FALSE;
			}
		}else{
			$_SESSION['error']="Existe otro usuario con el EMAIL INDICADO. No puedo dar de alta este usuario. Si esta es su dirección de correo comuníquelo al administrador.";
			return FALSE;
		} 
    }  

	
    // MODIFICA USUARIO
    //-------------------------------------------------------------------------  
    public function modifica(){
		$con=$_SESSION['SGBD'];
		//---------- sistema TRADICIONAL -----------------------------
		if (!($this->existeEmail($_REQUEST['inputEmail'],$_SESSION['miusuario']))){
			$modi="UPDATE usuarios SET USU_Email='".$_REQUEST['inputEmail']."',";
			$modi=$modi."USU_Nombre= '".$_REQUEST['inputNombre']."',";
			$modi=$modi."USU_Apellidos= '".$_REQUEST['inputApellidos']."',";
			$modi=$modi."USU_DNI= '".$_REQUEST['inputDNI']."',";
			$modi=$modi."USU_NumeroSS= '".$_REQUEST['inputNumeroSS']."',";
			$modi=$modi."USU_CuentaBancaria= '".$_REQUEST['inputCuentaBancaria']."',";
			$modi=$modi."USU_Direccion= '".$_REQUEST['inputDireccion']."',";
			$modi=$modi."USU_Telefono1= '".$_REQUEST['inputTelefono1']."',";
			$modi=$modi."USU_Telefono2= '".$_REQUEST['inputTelefono2']."'";
			$modi=$modi." where USU_ID=".$_SESSION['miusuario'];
			$result = mysqli_query($con,$modi);
			$filas=  mysqli_affected_rows($con);
			//Actualiza session.
			if ($_SESSION['usuario']['USU_ID']==$_SESSION['miusuario']){
				//modifico el usuario logado.
				$_SESSION['usuario']['USU_Email']=$_REQUEST['inputEmail'];
				$_SESSION['usuario']['USU_Nombre']=$_REQUEST['inputNombre'];
				$_SESSION['usuario']['USU_Apellidos']=$_REQUEST['inputApellidos'];
				$_SESSION['usuario']['USU_DNI']=$_REQUEST['inputDNI'];
				$_SESSION['usuario']['USU_NumeroSS']=$_REQUEST['inputNumeroSS'];
				$_SESSION['usuario']['USU_CuentaBancaria']=$_REQUEST['inputCuentaBancaria'];
				$_SESSION['usuario']['USU_Direccion']=$_REQUEST['inputDireccion'];
				$_SESSION['usuario']['USU_Telefono1']=$_REQUEST['inputTelefono1'];
				$_SESSION['usuario']['USU_Telefono2']=$_REQUEST['inputTelefono2'];
				$_SESSION['error']="Tus datos se han guardado";
			}
			//Actualiza Tabla de usuarios en memoria.
			$misUsuarios=$_SESSION['MisUsuarios'];
			$numUsuarios=count($misUsuarios);
			for($i=0;$i<$numUsuarios;++$i){
				if ($misUsuarios[$i]['USU_ID']==$_SESSION['miusuario']){
					$misUsuarios[$i]['USU_Email']=$_REQUEST['inputEmail'];
					$misUsuarios[$i]['USU_Nombre']=$_REQUEST['inputNombre'];
					$misUsuarios[$i]['USU_Apellidos']=$_REQUEST['inputApellidos'];
					$misUsuarios[$i]['USU_DNI']=$_REQUEST['inputDNI'];
					$misUsuarios[$i]['USU_NumeroSS']=$_REQUEST['inputNumeroSS'];
					$misUsuarios[$i]['USU_CuentaBancaria']=$_REQUEST['inputCuentaBancaria'];
					$misUsuarios[$i]['USU_Direccion']=$_REQUEST['inputDireccion'];
					$misUsuarios[$i]['USU_Telefono1']=$_REQUEST['inputTelefono1'];
					$misUsuarios[$i]['USU_Telefono2']=$_REQUEST['inputTelefono2'];				
					break;
				}
			}
			$_SESSION['MisUsuarios']=$misUsuarios;
			$_SESSION['error']="He modificado el usuario indicado.";
			return TRUE;
		}else{
			$_SESSION['error']="Existe otro usuario con el EMAIL INDICADO. No puedo dar Modificar este usuario. Confirme el email. Si es el email correcto comuníquelo al administrador.";			
			return FALSE;
		}
		
		//---------- prepara la sentencia para evitar inyeccion SQL NON FUNCIONA EN EL PREPARE---------------------
		/*$modi="UPDATE `usuarios` SET `USU_Apellidos`= ? WHERE `USU_ID`= ?";
		$modi="UPDATE usuarios SET USU_Email= ? ,USU_Nombre= ? ,USU_Apellidos= ?,USU_DNI= ? ,USU_NumeroSS= ? ,USU_CuentaBancaria= ? ,USU_Direccion= ? ,USU_Telefono1= ? ,USU_Telefono2= ? WHERE USU_ID= ?";
		$modi="UPDATE `usuarios` SET `USU_Email`= ? ,`USU_Nombre`= ? ,`USU_Apellidos`= ?,`USU_DNI`= ? ,`USU_NumeroSS`= ? ,`USU_CuentaBancaria`= ? ,`USU_Direccion`= ? ,`USU_Telefono1`= ? ,`USU_Telefono2`= ? WHERE `USU_ID`= ?";
		echo "<br>antes de prepare<br>".$_REQUEST['inputApellidos']. " --- ". $_SESSION['usuario']['USU_ID'];
		$qrypreparada =$mysqli_prepare($con,$modi);
		if($qrypreparada){
			echo "<br>antes de param<br>";
			//mysqli_stmt_bind_param($qrypreparada,"sssssssssi",$_REQUEST['inputEmail'],$_REQUEST['inputNombre'],$_REQUEST['inputApellidos'],$_REQUEST['inputDNI'],$_REQUEST['inputNumeroSS'],$_REQUEST['inputCuentaBancaria'],$_REQUEST['inputDireccion'],$_REQUEST['inputTelefono1'],$_REQUEST['inputTelefono2'], $_SESSION['usuario']['USU_ID']);
			mysqli_stmt_bind_param($qrypreparada,"si",$_REQUEST['inputApellidos'], $_SESSION['usuario']['USU_ID']);
			echo "<br>antes de execute<br>";
			mysqli_stmt_execute($qrypreparada);
			//Actualiza session.
			$_SESSION["error"]="cambios". $_REQUEST['inputApellidos'];
			//$_SESSION['usuario']['USU_Email']=$_REQUEST['inputEmail'];
			//$_SESSION['usuario']['USU_Nombre']=$_REQUEST['inputNombre'];
			$_SESSION['usuario']['USU_Apellidos']=$_REQUEST['inputApellidos'];
			/*$_SESSION['usuario']['USU_DNI']=$_REQUEST['inputDNI'];
			$_SESSION['usuario']['USU_NumeroSS']=$_REQUEST['inputNumeroSS'];
			$_SESSION['usuario']['USU_CuentaBancaria']=$_REQUEST['inputCuentaBancaria'];
			$_SESSION['usuario']['USU_Direccion']=$_REQUEST['inputDireccion'];
			$_SESSION['usuario']['USU_Telefono1']=$_REQUEST['inputTelefono1'];
			$_SESSION['usuario']['USU_Telefono2']=$_REQUEST['inputTelefono2'];
		}else{
			echo "<br>SQL Error: " . mysqli_stmt_error($qrypreparada)."<br>";
		   echo "<br>NO HA PREPARADO<br>";
		};*/
    }  
    
    //BORRA USUARIO
    //-------------------------------------------------------------------------  
    public function borra(){
		$con=$_SESSION['SGBD'];
		if ($_REQUEST["USU_definitivo"]=="si"){
			$ejecuta="DELETE FROM usuarios WHERE USU_ID=".$_REQUEST["USU_ID_marcado"].";";
		}else{
			$hoy=date("Y-m-d");
			$ejecuta="UPDATE usuarios set USU_FechaBaja= '".$hoy."' WHERE USU_ID=".$_REQUEST["USU_ID_marcado"].";";
		}
		echo $ejecuta;
        mysqli_query($con,$ejecuta) or die("No se ha podido dar de BAJA el USUARIO<br>MySQL dice: ".mysql_error());
		$filas=  mysqli_affected_rows($con);
		if ($filas>0){
			$_SESSION['error']="He dado de baja el Usuario:".$_REQUEST["USU_ID_marcado"];
		}else{
			$_SESSION['error']="Error desconocido. NO SE HA DADO DE BAJA EL USUARIO:".$_REQUEST["USU_ID_marcado"];
			return FALSE;
		}
		// modifica la tabla de usuarios
		$misUsuarios=$_SESSION['MisUsuarios'];
		$numUsuarios=count($misUsuarios);
		// Actualiza matriz de session
		for($i=0;$i<$numUsuarios;++$i){
			if ($misUsuarios[$i]['USU_ID']==$_REQUEST["USU_ID_marcado"]){break;}
		}
		$_SESSION['error']=$_SESSION['error']." - ".$i;
		if ($_REQUEST["USU_definitivo"]=="si"){
			unset($misUsuarios[$i]); // unset deja el espacio vacio pero no elimina la posicion
			$misUsuarios = array_values($misUsuarios);//quito el espacio que ha quedado despues de eliminarse
		}else{
			$misUsuarios[$i]['USU_FechaBaja']=$hoy;
		}
		$_SESSION['MisUsuarios']=$misUsuarios;
		$_SESSION['error']="USUARIO ELIMINADO.".$_REQUEST["USU_ID_marcado"];
		return TRUE;
    } 
	//CARGA USUARIOS. Se carga una matriz con los usuarios para manejo de los mismos.
	//-------------------------------------------------------------------------------
	public function cargaUsuarios($fuerza){
		// Fuerza=true obliga a cargar
		if (!($fuerza=="si")){
			//echo "verifico si esta cargada...";
			// si no forzamos y Si estan cargados los usuarios no carga.
			if ((isset($_SESSION['MisUsuarios']))){
				return;
			}
		}
		// Si tenemos  la conexión abierta no la hacemos
		if ((isset($_SESSION['SGDB']))){
			$con=$_SESSION['SGBD'];
		}else{
			$bbdd=new BBDD();
			$bbdd->conecta();
			$con=$bbdd->conexion;
		}
		if ($_SESSION['usuario']['USUS_ROL_ID']==1){
			// usuario Administrador. Todos los usuarios
			$busca="Select * from usuarios where 1";
		}else{
			// usuario gerente
			$sel=" and USU_ROL_ID IN (2,3,4) ";
			$busca="Select * from usuarios where USU_NEG_ID=".$_SESSION['usuario']['USU_NEG_ID']. $sel;
		}
		$result = mysqli_query($con,$busca);
		$filas = mysqli_num_rows($result);
		while($row = mysqli_fetch_array($result)) {
			// añade elemento al array
			$misUsuarios[]=$row;
		}
		// Asigna el array a la sesion
		$_SESSION['MisUsuarios']=$misUsuarios;
		mysqli_free_result($result);
	}
	
	//CARGA EMPLEADOS. Lo utiliza el gerente para su negocio y que sean de tipo 
	//--------------------------------------------------------------------------
	public function cargaEmpleados(){
		$this->cargaUsuarios("no");
		// Cabecera de tabla.
		echo "<!--Tabla de empleados -->";
		echo "<div class='table-responsive'>";
		echo "<table class='table table-striped table-sm table-bordered table-hover'>";
		echo '<thead class="thead-dark">';
			echo '<th>Categoría</th>';
			echo '<th>Nombre</th>';
			echo '<th>Apellidos</th>';
			echo '<th>Email</th>';
			echo '<th>DNI</th>';
			echo '<th>Teléfono1</th>';
			echo '<th>Teléfono2</th>';
			echo '<th>Detalle</th>';
			echo '<th>Modificar</th>';
			echo '<th>Eliminar</th';
		echo '</thead>';		
        echo '<tbody>';
		$misUsuarios=$_SESSION['MisUsuarios'];
		$numUsuarios=count($misUsuarios);
		for($i=0;$i<$numUsuarios;++$i){
			$row=$misUsuarios[$i];
			echo "<tr>";
			switch ($row['USU_ROL_ID']) {
				case 1:
					$tipo="Administrador";
					break;
				case 2:
					$tipo="Gerente";
					break;
				case 3:
					$tipo="Camarero";
					break;
				case 4:
					$tipo="Cocinero";
					break;
			}
			if((substr($row['USU_Contraseña'],0,4))=="1234"){
				$color="<td class='text-success'>";
			}else{
				$color="<td>";
			}
			if(!$row['USU_FechaBaja']==null){
				$color="<td class='text-danger'>";
			}
			echo $color.$tipo."</td>";
			echo $color.$row['USU_Nombre']."</td>";
			echo $color.$row['USU_Apellidos']."</td>";
			echo $color.$row['USU_Email']."</td>";
			echo $color.$row['USU_DNI']."</td>";
			echo $color.$row['USU_Telefono1']."</td>";
			echo $color.$row['USU_Telefono2']."</td>";
			echo "<td>";
			echo "<button style ='border:0' onclick=\"enlazar('perfil.php?parametro=2&miusuario=".$row['USU_ID']."');\"><img src='./Assets/Icons/ver_detalle.svg' alt='Ver detalle'></img></button>";
			echo "</td>";
			echo "<td>";
			echo "<button style ='border:0' onclick=\"enlazar('perfil.php?parametro=3&miusuario=".$row['USU_ID']."');\"><img src='./Assets/Icons/editar.svg' alt='Editar'></img></button>";
			echo "</td>";
			echo "<td>";
			echo "<button style ='border:0' onclick=\"confirmaBajaUsuario('".$row['USU_ID']."','".$row['USU_Nombre']."');\"><img src='./Assets/Icons/eliminar.svg' alt='Eliminar' ></img></button>";
			echo "</td>";
			echo "</tr>";
		} 
		echo '</tbody>';
		echo '</table>'; 
	}
	// devuelve datos del usuario
	//--------------------------------------------------------------------------------------------------
	public function daDatosUsuario($miusuario){
		$misUsuarios=$_SESSION['MisUsuarios'];
		$numUsuarios=count($misUsuarios);
		for($i=0;$i<$numUsuarios;++$i){
			if ($misUsuarios[$i]['USU_ID']==$miusuario){break;}
		}
		return $misUsuarios[$i];
	}
	
	//CARGA DATOS de PERFIL. En función de si es propio, una vista de empleado o una edicion de empleado
	//--------------------------------------------------------------------------------------------------
	public function cargaDatosPerfil($miusuario,$parametro){
		$miUsu=$this->daDatosUsuario($miusuario);
		if ($parametro=='2'){
			$mas=" readonly ";
		}else{
			$mas=" ";
		}
	   echo "<form name ='DatosPerfil' method='POST' action='../controlador/controlador.php'>";
			echo "<div class='col-md-8'>";
				echo "<div class='form-label-group'>";
					echo "<label for='inputNombre'>Nombre (*)</label>";
					echo "<input type='text' id='inputNombre' name='inputNombre' class='form-control'  minlength='3' pattern='[A-Za-z ñÑáéíóúÁÉÍÓÚ]{3,40}' title='Solo permite letras con un tamaño entre 3 y 40' maxlength='50' required='required' autofocus='autofocus'".$mas." value='".$miUsu['USU_Nombre']."'>";
				echo "</div>";
				echo "<div class='form-label-group'>";
					echo "<label for='inputApellidos'>Apellidos (*)</label>";
					echo "<input type='text' id='inputApellidos' name='inputApellidos' class='form-control' pattern='[A-Za-z ñÑáéíóúÁÉÍÓÚ]{3,40}' title='Solo permite letras con un tamaño entre 3 y 50' maxlength='50' required='required' ".$mas."value='".$miUsu['USU_Apellidos']."'>";
				echo "</div>";
				echo "<div class='form-label-group'>";
					echo "<label for='inputEmail'>Email (*)</label>";
					echo "<input type='email' id='inputEmail' name='inputEmail' class='form-control'  maxlength='40' required='required' ".$mas."value='".$miUsu['USU_Email']."'>";
				echo "</div>";
				echo "<div class='form-label-group'>";
					echo "<label for='inputDireccion'>Dirección</label>";
					echo "<input type='text' id='inputDireccion' name='inputDireccion' maxlength='100' class='form-control' ".$mas." value='".$miUsu['USU_Direccion']."'>";
				echo "</div>";
				echo "<div class='form-label-group'>";
					echo "<label for='inputDNI'>DNI</label>";
					echo "<input type='text' id='inputDNI' name='inputDNI' class='form-control' maxlength='9' title='DNI: 99999999X  NIE: X9999999X'".$mas."value='".$miUsu['USU_DNI']."'>";
				echo "</div>";
			echo "</div>";
			echo "<div class=col-md-8></div>";
			echo "<div class='col-md-8'>";
				echo "<div class='form-label-group'>";
					echo "<label for='inputTelefono1'>Teléfono Primario</label>";
					echo "<input type='text' id='inputTelefono1' name='inputTelefono1' class='form-control' maxlength='9' pattern='[0-9]{9}' title='Solo permite números. Debe tener una longitud de 9.'".$mas."value='".$miUsu['USU_Telefono1']."'>";
				echo "</div>";
				echo "<div class='form-label-group'>";
					echo "<label for='inputTelefono2'>Teléfono Secundario</label>";
					echo "<input type='text' id='inputTelefono2' name='inputTelefono2' class='form-control' maxlength='9' pattern='[0-9]{9}' title='Solo permite números. Debe tener una longitud de 9.' ".$mas."value='".$miUsu['USU_Telefono2']."'>";
				echo "</div>";
				echo "<div class='form-label-group'>";
					echo "<label for='inputNumeroSS'>Nº de la Seguridad Social</label>";
					echo "<input type='text' id='inputNumeroSS' name='inputNumeroSS' class='form-control' maxlength='11' title='Máximo de 11 dígitos.'".$mas."value='".$miUsu['USU_NumeroSS']."'>";
				echo "</div>";
				echo "<div class='form-label-group'>";
					echo "<label for='inputCuentaBancaria'>Cuenta Bancaria</label>";
					echo "<input type='text' id='inputCuentaBancaria' name='inputCuentaBancaria' class='form-control' maxlength='24' title='Introduzca IBAN sin espaciones' ".$mas."value='".$miUsu['USU_CuentaBancaria']."'>";
				echo "</div>";
				
				if (!($parametro=='2')){
					echo "<button class='btn  btn-lg btn-primary d-flex justify-content-between align-items-right' type='submit' style='margin-top: 20' >Guardar cambios</button>";
				}else{
					echo "<button class='btn  btn-lg btn-primary d-flex justify-content-between align-items-right' type='button' onclick=\"location.href='empleados';\" style='margin-top: 20' >VOLVER A EMPLEADOS</button>";
				};
			echo "</div>";
			echo "<!--campos ocultos para el controlador -->";
			echo "<input type='text' name='objeto' id='objeto' value='usuario' class='sr-only form-control'>";
			echo "<input type='text' name='accion' id='accion' value='modifica' class='sr-only form-control'>";
			echo "<input type='text' name='enlaceSI' id='enlaceSI' value='../views/inicial.php' class='sr-only form-control'>";
			echo "<input type='text' name='enlaceNO' id='enlaceNO' value='../views/perfil.php' class='sr-only form-control'>";
		echo "</form>";
	}
	// EXISTE CORREO ELECTRONICO EN LA BBDD?
    //-------------------------------------------------------------------------  
    public function existeEmail($email,$miusuario){
		echo "He entrado en comprobacion email";
        if(!empty($email)) {
			echo "NO ES VACIO";
            //normaliza los caracteres especiales.
            $email=htmlspecialchars($email,ENT_QUOTES,"UTF-8");
            if ($miusuario==0){
				// alguien se está intentanto registrar o dar de alta un empleado. el email NO debe estar en la BBDD
                $query ="SELECT * from usuarios where USU_Email='$email'";
            }else{
				// alguien está modificando datos de su perfil o de otro usuario si tiene privilegios para ello. El email si existe debe ser del propio usuario.
                $query ="SELECT * from usuarios where USU_Email='$email' and USU_ID!='$miusuario'";
            }
			echo $query;
            $result = mysqli_query($_SESSION['SGBD'],$query);
            $filas=  mysqli_num_rows($result);
            if ($filas>0){
				return true;
            }else{	
				return false;
			}
        }else{
			return false;
		}
    }
	// Selecciona usuario de un tipo
	//--------------------------------------------------------------------------------------------------
	public function seleccionaUsuarios($tipUsuario,$usseleccionado, $miestado){
		if($miestado=="detalle"){$dis="disabled";}else{$dis="";}
		echo "<select class='form-control form-control-sm text-primary' ".$dis." id='inputCamarero' name='inputCamarero' required placeholder='Camarero que toma la comanda.'>";
		if ($tipUsuario>2){
			// camarero, cocinero.  Solo tienen acceso a su usuario.
			echo "<option value='".$_SESSION['usuario']['USU_ID']."' selected>".$_SESSION['usuario']['USU_Nombre']." ".$_SESSION['usuario']['USU_Apellidos']."</option>";
		}else{
			foreach ($_SESSION['MisUsuarios'] as $usuario){
				if ($tipUsuario==$usuario['USU_ROL_ID']){
					if ($usuario['USU_ID']==$usseleccionado){$sel="selected";}else{$sel="";}
					echo "<option value='".$usuario['USU_ID']."' ".$sel.">".$usuario['USU_Nombre']." ".$usuario['USU_Apellidos']."</option>";
				}
			}
		}
		echo "</select>";

	}	
	// Da el nombre de un usuario dado su codigo
	//--------------------------------------------------------------------------------------------------
	public function daNombreUsuario($idUsuario){
		foreach ($_SESSION['MisUsuarios'] as $usuario){
			if ($idUsuario==$usuario['USU_ID']){
				return $usuario['USU_Nombre']." ".$usuario['USU_Apellidos'];
			}
		}
	}

}
