<?php
/*-----------------------------------------------------------------------------
 * Clase que convierte un table html a un array php.
 * Permite el paso de tables a través de campos ocultos que se reciben en la
 * REQUEST y se pueden tratar desde PHP.
 * USO:
 * $tta=new tableTOarray();
 * $miarray=$tta->convierteARRAY($stringConTable); 
 * $tta->muestraARRAY($miarray);
 -----------------------------------------------------------------------------*/
class tableTOarray {
    //declaración de propiedades
    
    //CONSTRUCTOR
    //-------------------------------------------------------------------------  
    function __construct(){
    }
    //Convierte un table pasado en un string a un array devuelto por la funcion
    //--------------------------------------------------------------------------
    function convierteARRAY($str){ 
        // Limpio campos ocultos.
        $str=str_replace(' style="display: none;"',"",$str);
        $str=str_replace('style="display:none;">',"",$str);
        $str=str_replace('style="display:none;"',"",$str);
        //quito los button
        $ini=strpos($str,"<button");
        $fin=strpos($str,"</button>");
        while ($ini){
            $str=substr($str,0,$ini-1).substr($str,$fin+8);
            $ini=strpos($str,"<button");
            $fin=strpos($str,"</button>");
        }
        // inicia búsqueda de campos.
        $ini=strpos($str,"<tr");
        $fin=strpos($str,"</tr>");
        while ($ini){
            $fila=substr($str,$ini+4,$fin-$ini);
            //echo "ini: ". $ini. "fin: ". $fin."--". $fila."<br><br>";
            // Busca columnas
            $inif=strpos($fila,"<td");
            $finf=strpos($fila,"</td>");
            $cont=0;
            while ($inif){
                $cont++;
                //mientras encuentre un td añade al array mifila
                $valor=substr($fila,$inif+4,$finf-$inif-4);
                $mifila[]=$valor;
                //echo "inif: ". $inif. "finf: ". $finf."--". $valor."<br><br>";
                $fila=substr($fila,$finf+4);
                $inif=strpos($fila,"<td");
                $finf=strpos($fila,"</td>");
            }
            // si no ha encontrado un td no añade ninguna fila
            if ($cont>0){
                //si en la fila ha encontrado algun td
                $contenidos[]=$mifila;
            }
            unset($mifila);
            $str=substr($str,$fin+4);
            $ini=strpos($str,"<tr");
            $fin=strpos($str,"</tr>");
        }
        //print_r($contenidos);
        return $contenidos;
    }
    //Muestra un array pasado como parametro en formato TABLE HTML para visualización
    //--------------------------------------------------------------------------
    function muestraARRAY($miarr){
        $filas=count($miarr);
        echo "<table border='1'>";
        foreach ($miarr as $fila){
            echo "<tr>";
            foreach ($fila as $valor){
                echo "<td>".$valor."</td>";
            }
            echo "</tr>";
        }
        echo "</table>";
    }
}
    
?>