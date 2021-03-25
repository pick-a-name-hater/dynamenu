<!DOCTYPE html>
<!------------------------------------------------------------------------------
PAGINA PARA Ejecutar la conexión al SGDB mysql y a la BBDD de DYNAMENU.
------------------------------------------------------------------------------->
<html>
    <head>
        <title>Carta dinámica DYNAMENU</title>
        <meta charset="UTF-8">
    </head>
    <body>
        <?php
			session_start();
			//borra session si existe
            session_unset();
			//inicia sesion o la abre si existe
            session_start();
        ?>
        <script>
            window.location="comienzo.php";
        </script>
    </body>
</html>