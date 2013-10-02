// JavaScript Document
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
function verificaTeclaImeiEmpaque(evento){
	if(evento.which==13){		
		//se valida la longitud de la cadena capturada
		var imei=document.getElementById("txtImeiEmpaque").value;
		if(imei.length < 15){
			$("#erroresCaptura").html("");
			$("#erroresCaptura").append("Error: verifique que haya introducido en el Imei la informacion correcta.");
			
		}else{
			document.getElementById("txtSimEmpaque").focus();
		}
		
	}
}
function cerrarVentana(div){
	$("#"+div).hide();
}
function mostrarFormulario(){
	ajaxApp("detalleEmpaque","controladorEnsamble.php","action=mostrarFormularioBusqueda","POST");
}
function buscarProductoProd(evento){
	//if(evento.which==13){	
		var parametro=$("#txtBusquedaProd").val();
		if(parametro=="" || parametro==null){
			alert("Error: Introduzca un parametro de Busqueda");
		}else{
			ajaxApp("divBusqueda","controladorEnsamble.php","action=busquedaProd&parametro="+parametro,"POST");
		}
	//}
}
function capturarExistencias(id){
	ajaxApp("gridBusqueda","controladorEnsamble.php","action=mostrarFormularioCaptura&id="+id,"POST");
}
var valores =  "";
function siguienteCaja(caja,indiceSig,evento){
	if(evento.which==13){
		caja=$("#"+caja).val();
		if(valores==""){
			valores=caja;
		}else{
			valores=valores+","+caja;
		}				
		if(indiceSig==13){//se manda el enlace a la siguiente caja
			$("#btnActualizarExist").focus();
			$("#btnActualizarExist").select();
			valores.legth=0;
		}else{
			$("#exist_"+indiceSig).focus();
			$("#exist_"+indiceSig).select();	
		}		
	}
}
function guardarActualizacion(){
	idProducto=$("#hdnIdProducto").val();	
	alert("Valores "+": "+valores);
	//se mandan los valores para actualizarlos en la base de datos
	ajaxApp("gridBusqueda","controladorEnsamble.php","action=guardarExistencia&valores="+valores+"&idProducto="+idProducto,"POST");
}
