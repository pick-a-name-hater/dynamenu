<?php
/*-----------------------------------------------------------------------------
 * Esta clase permite los accesos a la Base de datos dynamenu
 * NECESITA ACTIVAR LA EXTENSION GD o GD2 de PHP.
 * Buscar GD en phpinfo(), sino en php.ini en seccion extensiones extension=gd
 * antes de incluir esta clase debe incluir
 * 
 ------------------------------------------------------------------------------*/
class qr {
    // Declaración de la propiedad
    private $filename="";
    
    // CONSTRUCTOR.
    //--------------------------------------------------------------------------
    function __construct(){
    }
    // Crea conexion al SGBD
    //--------------------------------------------------------------------------    
    public function construye($numEmpresa,$nomEmpresa) {
        //Agregamos la libreria para genera códigos QR
        include "./phpqrcode/qrlib.php";    
        //Declaramos la ruta y nombre del archivo a generar
        $filename = 'qr.png';
        //Parametros de Condiguración
        $tamaño = 10; //Tamaño de Pixel
        $level = 'L'; //Precisión Baja
        $framSize = 3; //Tamaño en blanco
        $contenido = "http://dynamenu.com/carta.php?cd=".$numEmpresa; //Texto
        //Enviamos los parametros a la Función para generar código QR 
        QRcode::png($contenido, $filename, $level, $tamaño, $framSize); 
        $this->filename=$filename;
    }
    // Libera la conexión a la BBDD.
    //--------------------------------------------------------------------------   
    public function muestra(){
        if (!($this->filename=="")){
            //Mostramos la imagen generada
            echo '<img src="'.$this->filename.'" /><hr/>';        
        }
    }

}