<!------------------------------------------------------------------------------
PAGINA DE PASES DE COCINA
------------------------------------------------------------------------------->
<!DOCTYPE html>
<html lang="es">
	<head>
		<?php include("includes/cabecera.php");?>
		<?php include("includes/cargajs.html"); ?> 	
		<?php include("../modelo/comanda.php"); ?> 	        	
		<?php include("../modelo/mesa.php"); ?> 
        <?php include("../modelo/BBDD.php"); ?> 
        <script type="text/javascript" src="./js/comandaJQRY.js"></script>	        	
	</head>
	<body>
	<?php 
        session_start();
        // Si no esta logado lo envia a hacerlo
        if (!(isset($_SESSION['usuario']))){
            header('Location: login');
        } 
        $opc[]="ORDENA PREPARACIÓN -> Muestra platos PEDIDOS que pasan a EN PREPARACIÓN";
        $opc[]="ENVIO A SALA -> Muestra platos EN PREPARACIÓN que pasan a PREPARADOS";
        $opc[]="ENVIO A MESA -> Muestra platos PREPARADOS que pasan a SERVIDOS";
        $numOpc=count($opc);
        if (!(isset($_GET['inputAccionPlatos']))){
            $miAccion="1";
        }else{
            $miAccion=$_GET['inputAccionPlatos'];
        }
        switch ($miAccion) {
            case 1:
                $rot="Platos&nbspa&nbsppreparar&nbsp&nbsp";
                $sel[]="selected";$sel[]="";$sel[]="";
                $bot="A&nbspPreparación";
                break;
            case 2:
                $rot="Platos&nbspa&nbspTerminar&nbsp&nbsp";
                $sel[]="";$sel[]="selected";$sel[]="";
                $bot="A&nbspSala";
                break;
            case 3:
                $rot="Platos&nbspa&nbspServir&nbsp&nbsp";
                $sel[]="";$sel[]="";$sel[]="selected";
                $bot="A&nbspMesa";
                break;
        }  
        switch ($_SESSION['usuario']['USU_ROL_ID']) {
            case 1:
                $retornoSI="../views/cocina.php?inputAccionPlatos=1";
                $retornoNO="../views/cocina.php?inputAccionPlatos=1";
                break;
            case 2:
                $retornoSI="../views/cocina.php?inputAccionPlatos=1";
                $retornoNO="../views/cocina.php?inputAccionPlatos=1";
                break;
            case 3:
                $retornoSI="../views/cocina.php?inputAccionPlatos=3";
                $retornoNO="../views/cocina.php?inputAccionPlatos=3";
                break;
            case 3:
                $retornoSI="../views/cocina.php?inputAccionPlatos=1";
                $retornoNO="../views/cocina.php?inputAccionPlatos=1";
                break;
            }  

    ?>
	<br><br>
	<?php include('includes/barraNavegacionNegocio.html') ?>
    <div class="container-fluid">
		<div class="row">
            <?php include('includes/menu_admin.php') ?>
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <form id="paseDeCocina" name="paseDeCocina" method="POST" class="paseDeCocina" action="../controlador/controlador.php">  
                    <div class="d-flex flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                            <h1><?php echo $rot ?></h1>
                            <select class="form-control" name="inputAccionPlatos" id="inputAccionPlatos" required autofocus="" >
                                <?php
                                for ($i=0;$i<$numOpc;$i++){
                                    // camarero no tiene la opcion 1 
                                    if (($_SESSION['usuario']['USU_ROL_ID']=='3') &&($i==0)){continue;}
                                    // camarero no tiene la opcion 2 
                                    if (($_SESSION['usuario']['USU_ROL_ID']=='3') &&($i==1)){continue;}
                                    // cocinero se salta la opcion numero 3.
                                    if (($_SESSION['usuario']['USU_ROL_ID']=='4') &&($i==2)){continue;}
                                    //echo "<option ".$sel[$i]." value='".$i+1."'>".$opc[$i]."</option>";
                                    echo "<option ".$sel[$i]." value='".$i+1;
                                    echo "'>".$opc[$i]."</option>";
                                }
                                ?>
                            </select>
                            &nbsp&nbsp&nbsp
                            <div class="btn-toolbar mb-2 mb-md-0">
                                <div class="btn-group me-2">
                                    <button class="btn btn-primary d-flex justify-content-between align-items-right" type="submit" style="margin: 200"  ><?php echo $bot ?></button>
                                </div>
                            </div>
                    </div>
                    <!--Platos a cocina -->
                    <?php $com=new comanda(); $com->cargaPaseCocina($miAccion);?>
					<!--campos ocultos para el controlador -->
					<input type="text" name="objeto" id="objeto" value="comanda" class="sr-only form-control">
					<input type="text" name="accion" id="accion" value="paseCocina" class="sr-only form-control">
					<input type="text" name="enlaceSI" id="enlaceSI" value='<?php echo $retornoSI; ?>' class="sr-only form-control">
					<input type="text" name="enlaceNO" id="enlaceNO" value='<?php echo $retornoNO; ?>' class="sr-only form-control">	                    
                </form>
            </main>
        </div> <!--row-->
       
    </div>
	<?php include('includes/pie.php') ?>    
</body>
</html>