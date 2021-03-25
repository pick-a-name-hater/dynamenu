<?php
/*-----------------------------------------------------------------------------
 * Esta clase permite los accesos a la Base de datos dynamenu
 ------------------------------------------------------------------------------*/
class BBDD {
    // Declaración de la propiedad
    private $MySQL_host = "localhost";
    private $MySQL_database = "dynamenu";
    private $MySQL_user = "root";
    private $MySQL_password = "25073001";
    public $conexion=FALSE;
    private $bdseleccionada=TRUE;
    
    // CONSTRUCTOR.
    //--------------------------------------------------------------------------
    function __construct(){
    }
    // Crea conexion al SGBD
    //--------------------------------------------------------------------------    
    public function conecta() {
		$con=mysqli_connect($this->MySQL_host, $this->MySQL_user, $this->MySQL_password, $this->MySQL_database);
        $this->conexion=$con;
		if (!$this->conexion){
            $_SESSION['error']="Falló la conexión MySQL";
			echo "Falló la conexión MySQL<br>";
			echo "ERROR: " . mysqli_connect_errno() . "<br>";
			echo "MENSAJE: " . mysqli_connect_error() . "<br>";
			exit;			
		}else{
			//echo "Conexión correcta con MySQL<br>";
        }
		// asigna a variable de session
        session_start();
		$_SESSION['SGBD']=$this->conexion; 
    }
    // Libera la conexión a la BBDD.
    //--------------------------------------------------------------------------   
    public function desconecta(){
        if (isset($_SESSION['SGBD'])){
            echo "desconectando BBDD......<br>";
            mysqli_close($_SESSION['SGBD']);
            echo "Base de datos desconectada.<br>";
        }
    }

}