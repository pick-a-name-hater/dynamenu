/*-------------------------------------------------------------------
 * FUNCIONES JAVASCRIPT COMUNES.
 * Las funciones javascript básicas están en este fichero.
 -------------------------------------------------------------------*/

/*-------------------------------------------------------------------
 * CARGA UNA NUEVA PÁGINA.
 -------------------------------------------------------------------*/
function enlazar(pagina){
    location.href=pagina;
}
/*-------------------------------------------------------------------
 * Visualiza el codigo qr de la página en la que está.  
 * DEBE EXISTIR UN DIV con id="qr" en la misma.
 * El código QR lo hace con unas dimensiones de 150x150 px.
 -------------------------------------------------------------------*/ 
function verqr(){
    var dir=window.document.URL;
    document.getElementById('qr').innerHTML='<center><img src="https://chart.googleapis.com/chart?chs=150x150&cht=qr&chl='+dir+'" width="250" height="250"></center>';
}