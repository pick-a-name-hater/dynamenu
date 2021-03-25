<!------------------------------------------------------------------------------
PAGINA DE DATOS DEL NEGOCIO
------------------------------------------------------------------------------->
<!DOCTYPE html>
<html lang="es">
	<head>
		<?php include("includes/cabecera.php");?>
		<?php include("includes/cargajs.html"); ?> 		
		<?php include("../modelo/usuario.php"); ?>		
        <?php include("../modelo/qr.php"); ?> 
        <?php include("../modelo/BBDD.php"); ?> 
		<script type="text/javascript" src="./js/usuariosJQRY.js"></script>
	</head>
	<body>
	<?php 
        session_start();
        // Si no esta logado lo envia a hacerlo
        if (!(isset($_SESSION['usuario']))){
            header('Location: login');
        } 
    ?>
	<?php include('includes/barraNavegacionNegocio.html') ?>	<br><br>
    <div class="container-fluid">
		<div class="row">
            <?php include('includes/menu_admin.php') ?>
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1>Perfil del Restaurante</h1>
                    <!--<div class="btn-toolbar mb-2 mb-md-0">
                    </div>-->
                </div> 
                <div class="row">
                    <div class="col">
                        <!--Formulario de perfil -->
                        <form name="DatosNegocio" method="POST" action="../controlador/controlador.php">
                            <div class="col-md-9">
                                <div class="form-label-group">
                                    <label for="inputRazon">Razón social (*)</label>
                                    <input type="text" id="inputRazon" name="inputRazon" class="form-control" minlength="3" maxlength="40" required="required" title="Mínima longitud 3, Máxima longitud 40." autofocus="autofocus" value=<?php $v=$_SESSION['negocio']['NEG_RazonSocial'];echo "\"".$v."\""?>>
                                </div>
                                <div class="form-label-group">
                                    <label for="inputCIF">CIF (*)</label>
                                    <input type="text" id="inputCIF" name="inputCIF" class="form-control" minlength="9" maxlength="9"  required="required" value=<?php $v=$_SESSION['negocio']['NEG_CIF'];echo "\"".$v."\""?>>
                                </div>
                                <div class="form-label-group">
                                    <label for="inputComercial">Nombre comercial </label>
                                    <input type="text" id="inputComercial" name="inputComercial" class="form-control" value=<?php $v=$_SESSION['negocio']['NEG_NombreComercial'];echo "\"".$v."\""?> >
                                </div>
                                <div>
                                <button class="btn  btn-lg btn-primary d-flex justify-content-between align-items-right" type="submit" style="margin-top: 20"  >
                                    Guardar cambios
                                </button>
                                </div>
                            </div>
                            <!--campos ocultos para el controlador -->
                            <input type="text" name="objeto" id="objeto" value="negocio" class="sr-only form-control">
                            <input type="text" name="accion" id="accion" value="modifica" class="sr-only form-control">
                            <input type="text" name="enlaceSI" id="enlaceSI" value="../views/inicial.php" class="sr-only form-control">
                            <input type="text" name="enlaceNO" id="enlaceNO" value="../views/negocio.php" class="sr-only form-control">
                        </form>
                    </div>
                    <div class="col">
                        <?php
                            $qr=new qr();
                            $qr->construye($_SESSION['negocio']['NEG_ID'],$_SESSION['negocio']['NEG_NombreComercial']);
                            $qr->muestra();
                        ?>
                    </div>
                </div>
            </main>
        </div> <!--row-->
    </div>     
	<?php include('includes/pie.php') ?>
	<?php session_start();$_SESSION["error"]="";?>
</body>
</html>