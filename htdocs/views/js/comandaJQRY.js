/*----------------------------------------------------------------------------- 
 * JS PARA COMANDAS - PEDIDOS
 * La parte que está dentro de $(document).ready(function() funciona a los eventos jquery cuando el documento se ha cargado.
 * La parte externa corresponde a la responsabilidad del programador
  * -----------------------------------------------------------------------------*/
$(document).ready(function(){
	//alert("estoy en JQUERY2");
	// Control de accciones
	$('#btnInserta').click(function() {
		var mensaje = "Va a DAR DE ALTA esta comanda.\n\n DESEA CONTINUAR?";
		if (confirm(mensaje)){
			document.getElementById("accion").value="inserta";
			// envia formulario
			$("#FormDatosComanda").submit();
		}
	});
	$('#btnModifica').click(function() {
		var mensaje = "Va a GUARDAR LOS CAMBIOS de esta comanda.\n\n DESEA CONTINUAR?";
		if (confirm(mensaje)){
			$("#accion").val("modifica");
			$("#FormDatosComanda").submit();
		}
	});
	$('#btnVuelve').click(function() {
		if (confirm("Va a abandonar este pedido.\nSi ha hecho cambios SE PERDERAN.\n DESEA CONTINUAR?")){
			location.href='comandas.php';
		}
	});

	// Control de botones.
	switch ($("#estadoComanda").val()) {
		case "detalle":
			$('#btnInserta').hide();$('#btnVuelve').show();$('#btnModifica').hide();
			break;
		case "alta": 
			$('#btnInserta').show();$('#btnVuelve').hide();$('#btnModifica').hide();
			break;
		case "modifica": 
			$('#btnInserta').hide();$('#btnVuelve').hide();$('#btnModifica').show();
			break;
		default:
			$('#btnInserta').hide();$('#btnVuelve').show();$('#btnModifica').hide();
			break;
	}
	$('#btnResume').click(function() {
		$("#btnResume").hide();
		$("#btnExpande").show();
		$("#tablaComanda tbody tr").each(function() {
			var cantidad = $(this).find('input[type="number"]').val();
            if (cantidad.length == 0) {
                $(this).hide();
            }
        });
	});

	$('#btnExpande').click(function() {
		$("#btnResume").show();
		$("#btnExpande").hide();
        $("#tablaComanda tr").each(function() {
            $(this).show();
        });

	});

	// Hace resume automatico si el estado es detalle.
	if ($('#btnVuelve').is(":visible")){
		$('#btnResume').click();
	}
	// Pase de cocina. Detecta cambios en seleccion
	$("#inputAccionPlatos").change(function() {
		accion=$("#inputAccionPlatos").val();
		location.href='cocina.php?inputAccionPlatos='+accion;
	});
});

/*----------------------------------------------------------------------------- 
 FUNCIONES EXTERNAS A JQUERY
* -----------------------------------------------------------------------------*/
// Elimina comanda Seleccionada
//------------------------------------------------------------------------------
function eliminaComanda(idcomanda,fechahora,ubicacion,camarero){
	//alert("Estoy en confirmar la baja de la COMANDA");
	var mensaje = "Va a eliminar la comanda \nID: "+idcomanda+ "\nTomada a las: "+fechahora+"\nUbicación: "+ubicacion+"\nCamarero:"+camarero+"\nTenga en cuenta que eliminara todos los elementos de la misma.\nCONFIRME QUE DESEA DAR DE BAJA ESTA COMANDA";
	if (confirm(mensaje)){
		document.getElementById("inputPED_ID").value=idcomanda;
		document.getElementById("accion").value="elimina";
		// envia formulario
		document.SelComandas.submit();
	}
}
// hace invisible filas con unidades vacias
//------------------------------------------------------------------------------
function resumeComanda(){
	$("table tr td .unidades").each(function() {
		var celda = $.trim($(this).text());
		if (celda.length == 0) {
			$(this).parent().hide();
		}
	});
}
/* -----------------------------------------------------------------------------*/
// Elimina comanda Seleccionada
//------------------------------------------------------------------------------
function cierraComanda(idcomanda,fechahora,ubicacion,camarero){
	//alert("Estoy en confirmar CIERRE de la COMANDA");
	var mensaje = "Va a CERRAR la comanda \nID: "+idcomanda+ "\nTomada a las: "+fechahora+"\nUbicación: "+ubicacion+"\nCamarero:"+camarero+"\nSi cierra esta comanda ya no podrá modificarla y desaparecerá de los pases de sala y cocina.\nCONFIRME QUE DESEA CERRAR ESTA COMANDA";
	if (confirm(mensaje)){
		document.getElementById("inputPED_ID").value=idcomanda;
		document.getElementById("accion").value="cierra";
		// envia formulario
		document.SelComandas.submit();
	}
}