<!DOCTYPE html>
<html lang="es">
	<head>
    <?php include("includes/cabecera.php");?>
		<?php include("includes/cargajs.html"); ?> 		
		<?php include("../modelo/escandallo.php"); ?> 
		<?php include("../modelo/carta.php"); ?> 
        <?php include("../modelo/BBDD.php"); ?> 
        <link rel="stylesheet" href = "./Assets/css/carta.css">	
		<script src="js/cartaJQRY.js"></script>
	</head>
<body>
    <?php 
        session_start();
        if (!(isset($_GET['idc']))){
            // no viene definido el parametro
            session_unset();
            header('Location: comienzo');
        }
        $idCarta=$_GET['idc'];
        $car=new carta();
        $car->primeraCarta($idCarta);
    ?>
    <?php 
        // obtengo nombre de comercio tanto si estoy logado como si no
        if (!(isset($_SESSION['usuario']))){
            $nomc=$car->daNombreComercio($idCarta);
        }else{
            $nomc=$_SESSION['negocio']['NEG_NombreComercial'];
        }
    ?>        
    <h1 class="negocio"><br><br><br><br><?php echo $nomc;?></h1>
        <h2 class="carta">
            <p class="carta">
            <img src="./Assets/Icons/asterisk.svg"></img>
            <img src="./Assets/Icons/asterisk.svg"></img>
            <img src="./Assets/Icons/asterisk.svg"></img>
            <img src="./Assets/Icons/asterisk.svg"></img>
            <img src="./Assets/Icons/asterisk.svg"></img>
            Carta
            <img src="./Assets/Icons/asterisk.svg"></img>
            <img src="./Assets/Icons/asterisk.svg"></img>
            <img src="./Assets/Icons/asterisk.svg"></img>
            <img src="./Assets/Icons/asterisk.svg"></img>
            <img src="./Assets/Icons/asterisk.svg"></img>
            </p>
        </h2>
    </head>
    <div class="container-fluid">
    <div class="row">
        <div id="margen-izda" class="col-sm-3"></div>
        <div class="col-sm-">
            <?php 
                if (!(isset($_SESSION['usuario']))){
                    $car->sacaCarta(); 
                }else{
                    $car->sacaCartaLogado();
                } 
            ?>    
        </div>
    </div>
    </div>
	<?php include('includes/pie.php') ?>  
</body>
</html>