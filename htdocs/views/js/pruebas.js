/*----------------------------------------------------------------------------- 
 * JS PARA PRUEBAS DE JS
 * La parte que está dentro de $(document).ready(function() funciona a los eventos jquery cuando el documento se ha cargado.
 * La parte externa corresponde a la responsabilidad del programador
  * -----------------------------------------------------------------------------*/

$(document).ready(function(){
	alert("estoy en JQUERY");
   	$("#nombrecompleto").keydown(function(){
   		$("#txt").text("Tecla pulsada");
	}); 
	$("#nombrecompleto").keyup(function(){
   		$("#txt").text("Tecla soltada");
	}); 	
	$("#Envia").click(function(){
		$valor=$('#nombrecompleto').val();
		alert($('#nombrecompleto').val());
		$('#txt').val($('#txt').val()+$("#nombrecompleto").val()+"\n");
		//$("#txt").val($("#nombrecompleto").val());
		//$("#nombrecompleto").hide();
	});
});