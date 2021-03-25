/*----------------------------------------------------------------------------- 
 * JS PARA GESTIÓN DE USUARIOS.
 * -----------------------------------------------------------------------------*/

/*-------------------------------------------------------
* Cuando termina de cargar la página fuera de eventos.
 --------------------------------------------------------*/

/*-------------------------------------------------------------------
 * CARGA UNA NUEVA PÁGINA.
 -------------------------------------------------------------------*/
function enlazar(pagina){
	location.href=pagina;
}
/*-------------------------------------------------------------------
 + CONFIRMA BAJA DE EMPLEADO.
 -------------------------------------------------------------------*/
function confirmaBajaUsuario(usid,usnom){
	/*var mensaje = "ID: "+usid+ " NOMBRE: "+usnom+". \nCONFIRME QUE DESEA DAR DE BAJA ESTE USUARIO";
	if (confirm(mensaje)){
		var men2="ID: "+usid+ " NOMBRE: "+usnom+ "¿DESEA UNA BAJA TEMPORAL? Pulse CANCEL  si es una BAJA DEFINITIVA.";
		if (confirm(men2)){
				// baja temporal
				//Cambia datos de control del formulario
				$("#USU_ID_marcado").val=usid;
				document.getElementById("USU_ID_marcado").value=usid;
				// envia formulario
				document.DatosEmpleados.submit();
		}else{
				// baja definitiva
				//Cambia datos de control del formulario
				document.getElementById("USU_ID_marcado").value=usid;
				document.getElementById("USU_definitivo").value="si";
				// envia formulario
				document.DatosEmpleados.submit();
				//$(".DatosEmpleados").submit();
		}

	}*/
	bootbox.prompt({
    title: "Confirma la BAJA ID: "+usid+ " NOMBRE: "+usnom,
    value: ['1', '3'],
    inputType: 'checkbox',
    inputOptions: [{
        text: 'NO deseo dar de baja Este USUARIO',
        value: '1',
    },
    {
        text: 'BAJA TEMPORAL. No podra logarse',
        value: '2',
    },
    {
        text: 'BAJA DEFINITIVA. Se eliminará totalmente',
        value: '3',
    }],
    callback: function (result) {
        switch ($result){
			case 2:
				//Cambia datos de control del formulario
				$("#USU_ID_marcado").val=usid;
				document.getElementById("USU_ID_marcado").value=usid;
				// envia formulario
				document.DatosEmpleados.submit();
			case 3:
				//Cambia datos de control del formulario
				document.getElementById("USU_ID_marcado").value=usid;
				document.getElementById("USU_definitivo").value="si";
				// envia formulario
				document.DatosEmpleados.submit();
		}
    }
});
}
