/*----------------------------------------------------------------------------- 
 * JS PARA INCIDENCIAS
 * La parte que está dentro de $(document).ready(function() funciona a los eventos jquery cuando el documento se ha cargado.
 * La parte externa corresponde a la responsabilidad del programador
 * -----------------------------------------------------------------------------*/
$(document).ready(function(){
	//alert("estoy en JQUERY");
  	$("#inputTIPO").change(function(){
		//alert("Cambio"+$("#inputTIPO").val());
    	if($("#inputTIPO").val()=="1-Falta ingrediente"){
			$("#divIdAfectado").show();
			$("#divPlatoAfectado").hide();
		}else{
			$("#divIdAfectado").hide();
			$("#divPlatoAfectado").show();
		}
  	});
});
/*----------------------------------------------------------------------------- 
 FUNCIONES EXTERNAS A JQUERY
* -----------------------------------------------------------------------------*/
function confirmaBajaIncidencia(idincidencia,idTipo,nomAfectado){
	var mensaje = "Va a eliminar la incidencia:\nID: "+idincidencia+"\nTipo:"+idTipo+"\nProducto afectado: "+nomAfectado+"\nTenga en cuenta que PONDRÁ EN LA CARTA los platos afectados por la incidencia.\nCONFIRME QUE DESEA DAR DE BAJA ESTA INCIDENCIA";
	if (confirm(mensaje)){
		document.getElementById("inputINC_ID").value=idincidencia;
		document.getElementById("accion").value="elimina";
		// envia formulario
		document.SelIncidencias.submit();
	}
}