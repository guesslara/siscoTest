// JavaScript Document 
	/* 
	 *funcionesEnsamble: contiene las validaciones y direcciona a los div correspondientes las funciones y sus variables 
	 *Autor: Rocio Manuel Aguilar 
	 *Fecha:20/Nov/2012 
	*/ 
function ajaxApp(divDestino,url,parametros,metodo){	 
	$.ajax({ 
	async:true, 
	type: metodo, 
	dataType: "html", 
	contentType: "application/x-www-form-urlencoded", 
	url:url, 
	data:parametros, 
	beforeSend:function(){ 
		$("#cargadorGeneral").show(); 
	}, 
	success:function(datos){ 
		$("#cargadorGeneral").hide(); 
		$("#"+divDestino).show().html(datos);		 
	}, 
	timeout:90000000, 
	error:function() { $("#"+divDestino).show().html('<center>Error: El servidor no responde. <br>Por favor intente mas tarde. </center>'); } 
	}); 
} 
function clean2(){ 
	$("#detalleEmpaque").html(""); 
} 
function cerrarVentana(div,trans){ 
	if(div=="resultados"){ 
		$("#"+div).hide();	 
	} 
	else{ 
		$("#resultados").hide(); 
		$("#"+trans).hide(); 
		$("#"+div).hide(); 
	} 
} 
function confirmar(){ 
	var entrar = confirm("¿Realmente quieres guardar los datos?"); 
	if ( !entrar ) exit(); 
} 
function continuar(){ 
	var entrar = confirm("¿Deseas continuar?"); 
	if ( !entrar ) exit(); 
}
function limpia(campo){
	$("#"+campo).removeAttr("value");
}
function mostrarLotes(idUsuario,idProyectoSeleccionado,opt){ 
	ajaxApp("listadoEmpaque","controladorEnsamble.php","action=mostrarLotes&opt="+opt+"&idUsuario="+idUsuario+"&idProyectoSeleccionado="+idProyectoSeleccionado,"POST"); 
} 

function quita(){

	$("#resultados").hide();
}
function coloca(){

	$("#resultados").show();
}
function verFormatos(idLote,idProyectoSeleccionado,idUsuario,numPo){
	ajaxApp("detalleEmpaque","controladorEnsamble.php","action=verFormatos&idLote="+idLote+"&idUsuario="+idUsuario+"&idProyectoSeleccionado="+idProyectoSeleccionado+"&numPo="+numPo,"POST"); 
}
function formatoPDF(noFormato,idLote,idUsuario,idProyectoSeleccionado,nombre){
	ajaxApp("detalleEmpaque","controladorEnsamble.php","action=formatoPDF&idLote="+idLote+"&idUsuario="+idUsuario+"&idProyectoSeleccionado="+idProyectoSeleccionado+"&noFormato="+noFormato+"&nombre="+nombre,"POST"); 
}