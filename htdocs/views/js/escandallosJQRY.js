// Globales
var filaTitulo;
var filaLinea;
var mensaje="DEBE CORREGIR/COMPLETAR ALGUNOS CAMPOS:\n--------------------------------------------------------\n\n";

/*----------------------------------------------------------------------------- 
 * JS PARA GESTIÓN DE ESCANDALLOS
 * La parte que está dentro de $(document).ready(function() funciona CUANDO LA PAGINA SE HA CARGADO
 * La parte externa corresponde a la responsabilidad del programador
 * -----------------------------------------------------------------------------*/
$(document).ready(function(){
	//alert("Estoy en Jquery22");
	// Si es el estado es detalle pone a readonly todos los controles de form
	if ($("#estadoEscandallo").val()=="detalle"){
		detalleReadonly();
	}
	
	// Cambios en datos generales activan boton verificar
	//-----------------------------------------------------------------------------
	$(".escGeneral").on('change', function(){
		$("#verifica").removeAttr('disabled');
	});
	// Cambios en ciertos campos hacen que se vacien inputCosteTotal y inputCosteRacion
	//-----------------------------------------------------------------------------
	$("#inputRaciones").on('change', function(){
		$("#inputCosteTotal").val('');
		$("#inputCosteRacion").val('');
	});
	$("#inputCantidad").on('change', function(){
		$("#inputCosteTotal").val('');
		$("#inputCosteRacion").val('');
	});
	$("#inputCosteUd").on('change', function(){
		$("#inputCosteTotal").val('');
		$("#inputCosteRacion").val('');
	});

	
	// Guarda el plato en la BBDD
	//-----------------------------------------------------------------------------
	$("#btnGuardaPlato").click(function(){
		//titulosVerificados=VerificaCamposDeTitulo(true);
		generalesVerificados=VerificaCamposGenerales(true);
		//lineasVerificadas=VerificaCamposDeLineas(true);
		globalVerificado=VerificaGlobal();
		if (globalVerificado && generalesVerificados){
			if (confirm("Desea Guardar este escandallo?")){
				var txtTitulos="<table>"+$('#tablaTitulos').html()+"</table>";
				var txtLineas="<table>"+$('#tablaLineas').html()+"</table>";
				$('#tablaTs').html(txtTitulos);
				$('#tablaLs').html(txtLineas);
				if ($("#estadoEscandallo").val()=="modifica"){
					$("#accion").val("modifica");
				}
				$('#DatosEscandallo').submit();
			}
		}else{
			alert(mensaje);
			mensaje="DEBE CORREGIR/COMPLETAR ALGUNOS CAMPOS:\n--------------------------------------------------------\n\n";
		}
	});
	// Pulsa el boton atras en el detalle de escandallos
	//-----------------------------------------------------------------------------
	$("#btnAtras").click(function(){
		if (confirm("Desea salir del escandallo?")){
			location.href="escandallos.php";
		}
	});

	
	// Calcula el coste Total de unidades incluidas en un plato.
	//-----------------------------------------------------------------------------
	$("#inputCosteTotal").focus(function(){
		//alert("inputCosteTotal");
		cant=parseFloat($("#inputCantidad").val());
		costeud=parseFloat($("#inputCosteUd").val());
		costeTot=cant*costeud;
		//alert(costeTot);
		var res=Number.parseFloat(costeTot).toFixed(2);
		//alert(res);
		$(this).val(res);
	});

	// Calcula el coste por RACION de plato servido
	//-----------------------------------------------------------------------------
	$("#inputCosteRacion").focus(function(){
		//alert("inputCosteRacion");
		costeTot=parseFloat($("#inputCosteTotal").val());
		//alert(costeTot);
		nraciones =$("#inputRaciones").val();
		//alert("nraciones:"+nraciones.length);
		if ((isNaN(nraciones)) || (nraciones.length == 0) || (costeTot.length == 0) ||(isNaN(costeTot))){
			//alert("Introduzca correctamente el NUMERO DE RACIONES del escandallo");
			$("#inputRaciones").focus();
		}else{
			raciones=parseFloat($("#inputRaciones").val());
			costeRac=costeTot/raciones;
			//alert(costeRac);
			var res=Number.parseFloat(costeRac).toFixed(2);
			//alert(res);
			$(this).val(res);
		}
	});
	
	// Añade una fila al array de titulos.
	//-----------------------------------------------------------------------------
	$("#añadeTitulo").click(function(){
		// si los campos no se han introducido correctamente aborta la inserción
		if (!(VerificaCamposDeTitulo(false))){
			alert(mensaje);
			mensaje="DEBE CORREGIR/COMPLETAR ALGUNOS CAMPOS:\n--------------------------------------------------------\n\n";
			return;
		}
		var tabla = document.getElementById("tablaTitulos");
		var nfilas=$("#tablaTitulos tr").length;
		// Oculta mensaje sin líneas
		$("#mensajeTitulos").hide();
		// introduce linea en el array
		var fila = tabla.insertRow(-1); //ultima fila
		miid="filaT"+nfilas;
		//fila.setAttribute("id",miid);
		fila.id=miid;
		var cell1 = fila.insertCell(0);
		var cell2 = fila.insertCell(1);
		var cell3 = fila.insertCell(2);
		var cell4 = fila.insertCell(3);
		var cell5 = fila.insertCell(4);
		var cell6 = fila.insertCell(5);
		cell1.innerHTML = $('#inputTitulo').val();
		cell2.innerHTML = $('#inputDescripcion').val();
		cell3.innerHTML = $('#selectIdioma option:selected').val();
		cell4.innerHTML = $('#selectIdioma option:selected').text();
		//modifica="modificaFilaDeTabla('tablaTitulos','"+nfilas+"\');";
		cell5.innerHTML = "<button style ='border:0' class='modificaLinea' onclick='modificaFilaDeTitulos("+fila.id+")'><img src='./Assets/Icons/editar.svg' alt='Modificar' ></img></button>";
		cell6.innerHTML = "<button style ='border:0' class='eliminaTitulo' onclick='eliminaFilaDeTabla("+fila.id+")'><img src='./Assets/Icons/eliminar.svg' alt='Eliminar' ></img></button>";
		// oculto celda de la columna 3 (id idioma)
		cell3.style.display="none";
		//Si el idioma es español cambia el titulo superior del escandallo.
		if ($('#selectIdioma').val()==1){
			$("#tituloEscandallo").text($('#inputTitulo').val());
		}
		// Vacia los campos de entrada.
		VaciaCamposTitulos();
		// Pone el foco en el titulo.
		$("#inputTitulo").focus();
	});

	// si le damos al boton modificar en TITULOS
	//-----------------------------------------------------------------------------
	$("#modificaTitulo").click(function(){
		//alert("Entro en Modifica");
		var x=filaTitulo.cells;
		x[0].innerHTML = $('#inputTitulo').val(); 
		x[1].innerHTML = $('#inputDescripcion').val();
		x[2].innerHTML = $('#selectIdioma option:selected').val();
		x[3].innerHTML = $('#selectIdioma option:selected').text();
		//sustituyeel botón añadir por el boton modifica o confirma
		$("#añadeTitulo").show();
		$("#modificaTitulo").hide();
		// Vacia los campos de entrada.
		VaciaCamposTitulos();		
		//Pone el foco en el primer campo.
		$("#inputTitulo").focus();	
	});
	// si le damos al boton modificar en LINEAS
	//-----------------------------------------------------------------------------
	$("#modificaLinea").click(function(){
		var x=filaLinea.cells;
		x[0].innerHTML = $('#inputidAfectado option:selected').val();
		x[1].innerHTML = $('#inputidAfectado option:selected').text();
		x[2].innerHTML = $('#selectEsencial option:selected').val();
		x[3].innerHTML = $('#selectEsencial option:selected').text();
		x[4].innerHTML = $('#selectUds option:selected').val();
		x[5].innerHTML = $('#selectUds option:selected').text();
		x[6].innerHTML = $('#inputCantidad').val(); 
		x[7].innerHTML = $('#inputCosteUd').val(); 
		x[8].innerHTML = $('#inputCosteTotal').val(); 
		x[9].innerHTML = $('#inputCosteRacion').val(); 
		x[10].innerHTML = $('#inputMerma').val(); 
		//sustituye el botón añadir por el boton modifica o confirma
		$("#añadeLinea").show();
		$("#modificaLinea").hide();
		// Vacia los campos de entrada.
		VaciaCamposLineas();		
		//Pone el foco en el primer campo.
		$("#inputCantidad").focus();
	});
	// Añade una fila al array de lineas de escandallo.
	//-----------------------------------------------------------------------------
	$("#añadeLinea").click(function(){
		// si los campos no se han introducido correctamente aborta la inserción
		if (!(VerificaCamposDeLineas(false))){
			alert(mensaje);
			"DEBE CORREGIR/COMPLETAR ALGUNOS CAMPOS:\n--------------------------------------------------------\n\n";
			return;
		}		
		// Oculta mensaje sin líneas
		$("#mensajeLineas").hide();
		// Asigna tabla y obtiene longitud
		var tabla = document.getElementById("tablaLineas");
		var nfilas=$("#tablaLineas tr").length;
		miid="filaL"+nfilas;
		// introduce linea en el array
		var fila = tabla.insertRow(-1); //ultima fila
		fila.id=miid;
		var cell1 = fila.insertCell(0);
		var cell2 = fila.insertCell(1);
		var cell3 = fila.insertCell(2);
		var cell4 = fila.insertCell(3);
		var cell5 = fila.insertCell(4);
		var cell6 = fila.insertCell(5);
		var cell7 = fila.insertCell(6);
		var cell8 = fila.insertCell(7);
		var cell9 = fila.insertCell(8);
		var cell10 = fila.insertCell(9);
		var cell11 = fila.insertCell(10);
		var cell12 = fila.insertCell(11);
		var cell13 = fila.insertCell(12);
		cell1.innerHTML = $('#inputidAfectado option:selected').val();
		cell2.innerHTML = $('#inputidAfectado option:selected').text();
		cell3.innerHTML = $('#selectEsencial option:selected').val();
		cell4.innerHTML = $('#selectEsencial option:selected').text();
		cell5.innerHTML = $('#selectUds option:selected').val();
		cell6.innerHTML = $('#selectUds option:selected').text();
		cell7.innerHTML = $('#inputCantidad').val();
		cell8.innerHTML = $('#inputCosteUd').val();
		cell9.innerHTML = $('#inputCosteTotal').val();
		cell10.innerHTML = $('#inputCosteRacion').val();
		cell11.innerHTML = $('#inputMerma').val();
		cell12.innerHTML = "<button style ='border:0' class='modificaLinea' onclick='modificaFilaDeLineas("+fila.id+")'><img src='./Assets/Icons/editar.svg' alt='Modificar' ></img></button>";
		cell13.innerHTML = "<button style ='border:0' class='eliminaFila' onclick='eliminaFilaDeTabla("+fila.id+")'><img src='./Assets/Icons/eliminar.svg' alt='Eliminar' ></img></button>";
		// Oculta las columnas id
		cell1.style.display="none";
		cell3.style.display="none";
		cell5.style.display="none";
		//vacia los campos.
		VaciaCamposLineas();
		// pone el foco en la cantidad
		$("#inputCantidad").focus();
	});
});


/*----------------------------------------------------------------------------- 
 * PARTE EXTERNA AL ARRANQUE POSTERIOR DE JAVASCRIPT
 * ---------------------------------------------------------------------------*/

/* Elimina una fila de la la tabla html que introduzcamos.
-----------------------------------------------------------------*/
function eliminaFilaDeTabla(miIdFila){
	var mensaje = `Desea eliminar El elemento señalado?${miIdFila.id}`;
	if (confirm(mensaje)){
		miIdFila.remove();
		//$('#'+miIdFila).remove();
	}
}
/* Modifica un título de un escandallo
-----------------------------------------------------------------*/
function modificaFilaDeTitulos(mifila){
	var mensaje = "Desea MODIFICAR los datos del título de este Escandallo?";
	if (confirm(mensaje)){
		var x=mifila.cells;
		tit=x[0].innerHTML; 
		des=mifila.cells[1].innerHTML;
		idi=mifila.cells[2].innerHTML;
		$("#inputTitulo").val(tit);
		$("#inputDescripcion").val(des);
		$('#selectIdioma').val(idi);
		// no debemos modificar el idioma
		$('#selectIdioma').prop('disabled',true);
		//sustituye el botón añadir por el boton modifica o confirma
		$("#añadeTitulo").hide();
		$("#modificaTitulo").show();
		// Cambia el color de los inputs.
		//variable de memoria global javascript
		filaTitulo=mifila;
		//Pone el foco en el primer campo.
		$("#inputTitulo").focus();
		//Vacia campos de líneas.
		//VaciaCamposTitulos();
	}
} 
/* Modifica una línea de un escandallo
-----------------------------------------------------------------*/
function modificaFilaDeLineas(mifila){
	var mensaje = "Desea MODIFICAR los datos de la línea de este Escandallo?";
	if (confirm(mensaje)){
		var x=mifila.cells;
		//alert("Lo que esta en la linea: \n"+x[0].innerHTML);
		 $('#inputidAfectado option:selected').val(x[0].innerHTML);
		 $('#inputidAfectado option:selected').text(x[1].innerHTML);
		 //$('#selectEsencial option:selected').val(x[2].innerHTML);
		 $('#selectEsencial option:selected').text(x[3].innerHTML);
		 $('#selectUds option:selected').val(x[4].innerHTML);
		 $('#selectUds option:selected').text(x[5].innerHTML);
		 $('#inputCantidad').val(x[6].innerHTML); 
		 $('#inputCosteUd').val(x[7].innerHTML); 
		 $('#inputCosteTotal').val(x[8].innerHTML); 
		 $('#inputCosteRacion').val(x[9].innerHTML); 
		 $('#inputMerma').val(x[10].innerHTML); 
		//sustituye el botón añadir por el boton modifica o confirma
		$("#añadeLinea").hide();
		$("#modificaLinea").show();
		// Cambia el color de los inputs.
		//variable de memoria global javascript
		filaLinea=mifila;
		//Vacia campos de Lineas.
		//VaciaCamposLineas();
		//Pone el foco en el primer campo.
		$("#inputCantidad").focus();
	}
} 
/* Vacia los campos de entrada de titulos
-----------------------------------------------------------------*/
function VaciaCamposTitulos(){
	$("#inputTitulo").val("");
	$("#inputDescripcion").val("");
	//$('#selectIdioma').val('')
	$('#selectIdioma').prop('SelectedIndex',0);
	$("#inputTitulo").focus();
}
/* Vacia los campos de entrada de LINEAS
-----------------------------------------------------------------*/
function VaciaCamposLineas(){
	$('#inputidAfectado').prop("SelectedIndex",0);
	$('#selectEsencial').prop("SelectedIndex",0);
	$('#selectUds').prop("SelectedIndex",0);
	$('#inputCantidad').val(""); 
	$('#inputCosteUd').val(""); 
	$('#inputCosteTotal').val(""); 
	$('#inputCosteRacion').val(""); 
	$('#inputMerma').val(""); 
}
/* Verifica los campos de Titulos
-----------------------------------------------------------------*/
function VerificaCamposDeTitulo(global){
	verificado=true;
	men="";
	//alert("inicial:"+mensaje);
	// Verificar que el nombre tenga contenido
	if ($("#inputTitulo").val().length<5){
		men=men+"Debe introducir el NOMBRE DEL PLATO con una longitud mínima de 5 caracteres\n";
		verificado=false;
	}
	// Verificar que la descripcion tenga contenido
	if ($("#inputDescripcion").val().length<5){
		men=men+"Debe introducir LA DESCRIPCIÓN DEL PLATO con una longitud mínima de 5 caracteres\n";
		verificado=false;
	}
	// Verificar que se ha seleccionado un idioma
	if ($("#selectIdioma").val().length<1){
		men=men+"Debe introducir El IDIOMA del plato\n";
		verificado=false;
	}
	// Asigna tabla y obtiene longitud
	var tabla = document.getElementById("tablaTitulos");
	var nfilas=$("#tablaTitulos tr").length;
	// verificar que el idioma no se haya introducido
	for (var i=0, row;row = tabla.rows[i]; i++){
		//alert();
		if (tabla.rows[i].cells[2].innerHTML==$('#selectIdioma').val()){
			men=men+"Ya existe una descripción en este IDIOMA\n";
			verificado=false;
		}
	}
	if ((!(verificado)) && (global)){
		mensaje=mensaje+"PESTAÑA TÍTULOS DE ESCANDALLO\n----------------------------------------\n"+men;
	}else{
		mensaje=mensaje+men;
	}
	//alert("Final:"+mensaje);
	return verificado;
}
/* Verifica los campos de Líneas de escandallos
-----------------------------------------------------------------*/
function VerificaCamposDeLineas(global){
	verificado=true;
	men="";
	expRegDec = /[0-9]{1,3}\.[0-9]{2}/;
	// Verificar que el nombre tenga contenido
	if ((expRegDec.test($("#inputCantidad").val())) === false){
		men=men+"Debe introducir LA CANTIDAD DE PRODUCTO en formato 999.99\n";
		verificado=false;
	}
	if ((expRegDec.test($("#inputCosteUd").val())) === false){
		men=men+"Debe introducir EL COSTE POR UNIDAD en formato 999.99\n";
		verificado=false;
	}
	if ((expRegDec.test($("#inputCosteTotal").val())) === false){
		men=men+"Debe introducir EL COSTE TOTAL en formato 999.99\n";
		verificado=false;
	}
	if ((expRegDec.test($("#inputCosteRacion").val())) === false){
		men=men+"Debe introducir EL COSTE POR RACION en formato 999.99\n";
		verificado=false;
	}
	if ((expRegDec.test($("#inputMerma").val())) === false){
		men=men+"Debe introducir EL PORCENTAJE DE MERMA en formato 999.99\n";
		verificado=false;
	}
	if ((!(verificado)) && (global)){
		mensaje=mensaje+"PESTAÑA LINEAS DE ESCANDALLO\n--------------------------------------\n"+men;
	}else{
		mensaje=mensaje+men;
	}
	return verificado;
}

/* Verifica los campos de Líneas de escandallos
-----------------------------------------------------------------*/
function VerificaCamposGenerales(global){
	verificado=true;
	men="";
	expRegDec = /[0-9]{1,3}\.[0-9]{2}/;
	// Verificar que el nombre tenga contenido
	raciones=$("#inputRaciones").val();
	var rac=Number.parseInt(raciones);
	if ((raciones=='') || (raciones== null)|| (rac<1) || (rac>999)){
		men=men+"Debe introducir LAS RACIONES FINALES DEL ESCANDALLO entre 1 y 999\n";
		verificado=false;
	}
	if ((expRegDec.test($("#inputCoste").val())) === false){
		men=men+"Debe introducir EL COSTE POR RACION en formato 999.99\n";
		verificado=false;
	}
	if ((expRegDec.test($("#inputPrecio").val())) === false){
		men=men+"Debe introducir EL PRECIO DE VENTA DE LA RACIÓN en formato 999.99\n";
		verificado=false;
	}
	if ((!(verificado)) && (global)){
		mensaje=mensaje+"PESTAÑA DATOS GENERALES\n--------------------------------\n"+men;
	}else{
		mensaje=mensaje+men;
	}
	return verificado;
}
/* Verificaciones globales del plato
-----------------------------------------------------------------*/
function VerificaGlobal(){
	verificado=true;
	men="";
	// Verificar que tenga al menos 1 titulo.
	var nTitulos=$("#tablaTitulos tr").length;
	//alert("nTitulos:"+nTitulos);
	if (nTitulos<2){
		// cuenta como tr el encabezado
		men=men+"Debe incluir al menos 1 título en el escandallo\n";
		verificado=false;
	}
	// Verifica que tenga al menos 1 linea.
	var nLineas=$("#tablaLineas tr").length;
	//alert("nLineas:"+nLineas);
	if (nLineas<2){
		// cuenta como tr el encabezado
		men=men+"Debe incluir al menos 1 Linea en el escandallo\n";
		verificado=false;
	}

	// añade mensaje
	if (!(verificado)){
		mensaje=mensaje+"ERRORES GENERALES DEL ESCANDALLO\n----------------------------------------\n"+men;
	}
	return verificado;
}
/* Elimina Escandallo
-----------------------------------------------------------------*/
function eliminaEscandallo(idescandallo,nombreescandallo){
	var mensaje = "Va a eliminar el Escandallo:\n\nID: "+idescandallo+"\nNombre:"+nombreescandallo+"\n\nTenga en cuenta que ELIMINARÁ TOTALMENTE ESTE PLATO .\nCONFIRME QUE DESEA DAR DE BAJA ESTE ESCANDALLO";
	if (confirm(mensaje)){
		document.getElementById("idEscandallo").value=idescandallo;
		document.getElementById("accion").value="elimina";
		// envia formulario
		document.DatosEscandallo.submit();
	}

}
/* Pone en carta escandallo
-----------------------------------------------------------------*/
function enCartaEscandallo(idescandallo,nombreescandallo){
	var mensaje = "Va a Poner ACTIVO este Escandallo:\n\nID: "+idescandallo+"\nNombre:"+nombreescandallo+"\n\nEsto le permite que pueda ser incluido en una o varias cartas.\n\nCONFIRME QUE DESEA HACER ESTO";
	if (confirm(mensaje)){
		document.getElementById("idEscandallo").value=idescandallo;
		document.getElementById("accion").value="ponActivo";
		// envia formulario
		document.DatosEscandallo.submit();
	}
	
}

/* Si solo consultamos detalle pone en readonly todo el formulario de detalle
-----------------------------------------------------------------*/
function detalleReadonly(){
}