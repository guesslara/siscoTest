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
function formatoPDF(noFormato,idLote,idUsuario,idProyectoSeleccionado,nombre,datoE){
	//alert(idLote+"\n"+datoE);
	if((noFormato=="IQF0750317" && datoE==0) || (noFormato=="IQF0750321" && datoE==0)){
		$("#transparenciaGeneral1").show();
		$("#divMensajeCaptura").show();
		ajaxApp("listadoEmpaqueValidacion","controladorEnsamble.php","action=muestraTec&idLote="+idLote+"&idUsuario="+idUsuario+"&idProyectoSeleccionado="+idProyectoSeleccionado+"&noFormato="+noFormato+"&nombre="+nombre+"&datoE="+datoE,"POST"); 
	
	}else{
		ajaxApp("detalleEmpaque","controladorEnsamble.php","action=formatoPDF&idLote="+idLote+"&idUsuario="+idUsuario+"&idProyectoSeleccionado="+idProyectoSeleccionado+"&noFormato="+noFormato+"&nombre="+nombre+"&datoE="+datoE,"POST"); 
	}
}
function add(noform){
	$("#ant").show();
	var pagAct=parseInt($("#pagAct").val());
	var idLote=$("#idLote").val();
	var limite=$("#limite").val();
	var paginasT=$("#tp").val();
	ajaxApp("cuerpo","Cuerpos/"+noform+".php","pagAct="+(pagAct+1)+"&intervalo="+limite+"&totalpag="+paginasT+"&idLote="+idLote,"POST");
}
function att(noform){
	$("#sig").show();
	var pagAct=parseInt($("#pagAct").val());
	var limite=$("#limite").val();
	var idLote=$("#idLote").val();
	var paginasT=$("#tp").val();
	var limreg=$("#limreg").val();
	nvolimite=limite-(limreg*2);
	parametros="pagAct="+(pagAct-1)+"&intervalo="+(nvolimite)+"&totalpag="+paginasT+"&idLote="+idLote;
	ajaxApp("cuerpo","Cuerpos/"+noform+".php",parametros,"POST");
}
function muestraTiempo(noFormato){
	var pagAct=parseInt($("#pagAct").val());
	var limite=$("#limite").val();
	var idLote=$("#idLote").val();
	var paginasT=$("#tp").val();
	var limreg=$("#limreg").val();
	nvolimite=limite;
	var parametros="pagAct="+pagAct+"&intervalo="+(nvolimite)+"&totalpag="+paginasT+"&idLote="+idLote;
	ajaxApp("cuerpo","Cuerpos/"+noFormato+"-1.php",parametros,"POST");
}

function insertform306(){
	var fecha=document.getElementById("fecha").value;
	var numparte=document.getElementById("numpart").value;
	var picture=document.getElementById("uploadedfile").value;
	var comentarios=document.getElementById("coment").value;
	var firma=document.getElementById("firma").value;
	var parametros="action=insertar&fecha"+fecha+"&nuparte"+numparte+"&pic"+picture+"&coment"+comentarios+"&firma"+firma;
	ajaxApp("detalleEmpaque","controladorEnsamble.php", parametros,"POST");
}