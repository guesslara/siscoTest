// JavaScript Document 
	/* 
	 *funcionesEnsamble: contiene las validaciones y direcciona a los div correspondientes las funciones y sus variables 
	 *Autor: 
	 *Fecha:
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
		$("#"+divDestino).show().html("<p>Cargando...</p>"); 
	},
	success:function(datos){ 
		$("#cargadorGeneral").hide(); 
		$("#"+divDestino).show().html(datos);		 
	}, 
	timeout:90000000, 
	error:function() { $("#"+divDestino).show().html('<center>Error: El servidor no responde. <br>Por favor intente mas tarde. </center>'); } 
	}); 
}
function capturaL(){
	$("#resumenStatus").hide();
	$("#detalleEmpaque").show();
	$("#ventanita").hide();
	 $(document).ready(function (){
	//se define el array para el nombre de las columnas
	nombresColumnas=new Array("Lote","Fecha de Recibo","Producto","Marca","Modelo","Serie","Fecha Entrega","Guia de Entrega","Status Final","Mensaje")
	cargaInicial(10,"detalleEmpaque","controlador.php","action=datos","errores",nombresColumnas);
	inicio();
	$("#txt_0").focus();
        $("#txt_0").removeClass("datoListado");
        $("#txt_0").addClass("elementoFocus");
    });
}
function consultaL(){
	$("#detalleEmpaque").hide();
	$("#resumenStatus").show();
	$("#ventanita").hide();
	ajaxApp("resumenStatus","controlador.php","action=verFoliosResumen","POST");
}
function exportar(){
	$("#ventanita").show();
	ajaxApp("enlaventanita","controlador.php","action=exportar","POST");
}
function exportaXLS(){
	$("#ventanita").hide();
	var lotesE="";
	for(var i=0; i < document.frmlotes.lote.length; i++){
		if(document.frmlotes.lote[i].checked){
			lotesE+=document.frmlotes.lote[i].value + ",";
		}
	}
	ajaxApp("detalleEmpaque","controlador.php","action=exportarXLS&lotesEx="+lotesE,"POST");
}
function cerrarVentana(div){ 
	if(div=="resultados"){ 
		$("#"+div).hide();	 
	} 
	else{ 
		$("#resultados").hide(); 
		$("#transparenciaGeneral1").hide(); 
		$("#"+div).hide(); 
	} 
} 
function clean2(){ 
	$("#detalleEmpaque").html(""); 
} 