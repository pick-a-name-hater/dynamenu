<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php
    echo "<h1>qr</h1>";
	//Incluimos la libreria
 	include('qrlib.php');

 	$content = 'https://blog.adrianmartinezosorio.com/';
 	$aleatoriname = uniqid();
echo "pasado";
	//Imagen directamente en la pantalla del navegador, png stream
	QRcode::png($content);
echo "no";
 	//Exporta un qr a la ruta indcada
	QRcode::png($content, 'qrs/'.$aleatoriname.'.png');
echo "si";
 	//Exporta en un tamaño en pixeles determinado, multiplicando por 33.
	QRcode::png($content, 'qrs/'.$aleatoriname.'.png', QR_ECLEVEL_L, 1); //33x33px
	QRcode::png($content, 'qrs/'.$aleatoriname.'.png', QR_ECLEVEL_L, 2); //66x66px
	QRcode::png($content, 'qrs/'.$aleatoriname.'.png', QR_ECLEVEL_L, 3); //99x99px
	QRcode::png($content, 'qrs/'.$aleatoriname.'.png', QR_ECLEVEL_L, 4); //132x132px
	QRcode::png($content, 'qrs/'.$aleatoriname.'.png', QR_ECLEVEL_L, 10); //330x330px

?>    
</body>
</html>
