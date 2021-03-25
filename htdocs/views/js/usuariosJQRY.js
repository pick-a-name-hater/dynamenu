/*----------------------------------------------------------------------------- 
 * JS PARA GESTIÓN DE USUARIOS.
 * La parte que está dentro de $(document).ready(function() funciona a los eventos jquery cuando el documento se ha cargado.
 * La parte externa corresponde a la responsabilidad del programador
  * -----------------------------------------------------------------------------*/

$(document).ready(function(){
	//alert("Estoy en Jquery");
	
	//mostrar();
	// Despues de confirmación
	$("#inputConfirma").on("blur", function(){
		if ($(this).val()!=$("#inputContraseña").val()){
			alert("No coinciden las contraseñas introducidas");
			//$(this).prev().focus();
			$("#inputContraseña").focus();
		}
	});
	$("#inputCIF").on("blur", function(){
		cif=$(this).val();
		if (!(isValidDNI(cif) || isValidCIF(cif))){
			alert("No es un CIF,NIF o NIE válido");
			$("#inputCIF").focus();
		}
	});
	$("#inputDNI").on("blur", function(){
		cif=$(this).val();
		if (!(isValidDNI(cif))){
			alert("No es un NIF o NIE válido");
			$("#inputDNI").focus();
		}
	});
	// claveActual ¿Podemos verificarla en el cliente?
	$("#claveActual").on("blur", function(){
		actual=$(this).val();
		alert("Verifica clave Actual");
	});	
	$("#claveNueva2").on("blur", function(){
		if ($(this).val()!=$("#claveNueva1").val()){
			alert("No coinciden las contraseñas introducidas");
			//$(this).prev().focus();
			$("#claveNueva1").focus();
		}
	});
	
});


/*----------------------------------------------------------------------------- 
 * PARTE EXTERNA A JQUERY
 * ---------------------------------------------------------------------------*/
function mostrar(){
}

/* CARGA UNA NUEVA PÁGINA A demanda
-------------------------------------------------------------------*/
function enlazar(pagina){
	location.href=pagina;
}
/* CONFIRMA BAJA DE EMPLEADO A DEMANDA
-------------------------------------------------------------------*/
function confirmaBajaUsuario(usid,usnom){
	var mensaje = "ID: "+usid+ " NOMBRE: "+usnom+". \nCONFIRME QUE DESEA DAR DE BAJA ESTE USUARIO";
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

	}
}
/* Confirme la validez del NIF o del NIE. Comprueba si es un DNI correcto (entre 5 y 8 letras seguidas de la letra que corresponda).
Acepta NIEs (Extranjeros con X, Y o Z al principio
-------------------------------------------------------------------*/
function isValidDNI(dni) {
    var numero, let, letra;
    var expresion_regular_dni = /^[XYZ]?\d{5,8}[A-Z]$/;

    dni = dni.toUpperCase();

    if(expresion_regular_dni.test(dni) === true){
        numero = dni.substr(0,dni.length-1);
        numero = numero.replace('X', 0);
        numero = numero.replace('Y', 1);
        numero = numero.replace('Z', 2);
        let = dni.substr(dni.length-1, 1);
        numero = numero % 23;
        letra = 'TRWAGMYFPDXBNJZSQVHLCKET';
        letra = letra.substring(numero, numero+1);
        if (letra != let) {
            //alert('Dni erroneo, la letra del NIF no se corresponde');
            return false;
        }else{
            //alert('Dni correcto');
            return true;
        }
    }else{
        //alert('Dni erroneo, formato no válido');
        return false;
    }
}
/* Confirme la validez del NIF o del NIE. Comprueba si es un DNI correcto (entre 5 y 8 letras seguidas de la letra que corresponda).
Acepta NIEs (Extranjeros con X, Y o Z al principio
-------------------------------------------------------------------*/
function isValidCIF(cif) {
	if (!cif || cif.length !== 9) {
		return false;
	}
	var letters = ['J', 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I'];
	var digits = cif.substr(1, cif.length - 2);
	var letter = cif.substr(0, 1);
	var control = cif.substr(cif.length - 1);
	var sum = 0;
  var i;
	var digit;
	if (!letter.match(/[A-Z]/)) {
		return false;
	}
	for (i = 0; i < digits.length; ++i) {
		digit = parseInt(digits[i]);
		if (isNaN(digit)) {
			return false;
		}
		if (i % 2 === 0) {
			digit *= 2;
			if (digit > 9) {
				digit = parseInt(digit / 10) + (digit % 10);
			}
			sum += digit;
		} else {
			sum += digit;
		}
	}
	sum %= 10;
	if (sum !== 0) {
		digit = 10 - sum;
	} else {
		digit = sum;
	}
	if (letter.match(/[ABEH]/)) {
		return String(digit) === control;
	}
	if (letter.match(/[NPQRSW]/)) {
		return letters[digit] === control;
	}
	return String(digit) === control || letters[digit] === control;
}
