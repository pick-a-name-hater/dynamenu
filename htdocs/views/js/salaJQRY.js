/*----------------------------------------------------------------------------- 
 * JS PARA SALAS
 * La parte que está dentro de $(document).ready(function() funciona a los eventos jquery cuando el documento se ha cargado.
 * La parte externa corresponde a la responsabilidad del programador
  * -----------------------------------------------------------------------------*/

$(document).ready(function(){
	//alert("estoy en JQUERY");
  	$("button").click(function(){
    	$("p").hide();
  	});
});


/*----------------------------------------------------------------------------- 
 FUNCIONES EXTERNAS A JQUERY
* -----------------------------------------------------------------------------*/

function confirmaBajaSala(idsala,nomsala){
	//alert("Estoy en confirmar la baja de la sala");
	var mensaje = "Va a eliminar la sala ID: "+idsala+ " NOMBRE: "+nomsala+"\nTenga en cuenta que eliminara también las mesas de la misma.\nCONFIRME QUE DESEA DAR DE BAJA ESTA SALA";
	if (confirm(mensaje)){
		document.getElementById("inputSAL_ID").value=idsala;
		document.getElementById("accion").value="elimina";
		// envia formulario
		document.DatosSalas.submit();
	}
}

function confirmaBajaMesa(idsala,nomsala,idmesa,NpersonasMesa){
	//alert("Estoy en confirmar la baja de la Mesa");
	var mensaje = "Va a eliminar la siguiente Mesa:\nIDentificativo Mesa: "+idmesa+ "\nNumero de personas: "+NpersonasMesa+"\nIdentificativo de Sala: "+idsala+"\nNombre de Sala: "+nomsala+"º\n\nAsegúrese de no tener servicios activos en la misma.\nCONFIRME QUE DESEA DAR DE BAJA ESTA MESA";
	if (confirm(mensaje)){
		document.getElementById("inputMES_ID").value=idmesa;
		document.getElementById("inputMES_SAL_ID").value=idsala;
		document.getElementById("accionMesa").value="elimina";
		// envia formulario
		document.DatosMesas.submit();
	}
}