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
function oculta(div){
	$("#"+div).hide();
}
function ver(div){
	$("#"+div).show();
}
/********************************************Lote*******************************************************/ 
function mostrarLotes(idUsuario,idProyectoSeleccionado,opt){ 
	ajaxApp("listadoEmpaque","controladorEnsamble.php","action=mostrarLotes&opt="+opt+"&idUsuario="+idUsuario+"&idProyectoSeleccionado="+idProyectoSeleccionado,"POST"); 
} 
function formLotes(idUsuario,idProyectoSeleccionado){/*Funcion que agrega nuevos lotes*/ 
	$("#transparenciaGeneral1").show(); 
	$("#divMensajeCaptura").show(); 
	id_mov=$("input[name='movimientos']:checked").val(); 	
	ajaxApp("listadoEmpaqueValidacion","controladorEnsamble.php","action=formLotes&idUsuario="+idUsuario+"&idProyectoSeleccionado="+idProyectoSeleccionado+"&idMov="+id_mov,"POST"); 
} 
function agregarLotes(){/*Funcion que guarda los nuevos lotes*/ 
	$("#transparenciaGeneral1").hide(); 
	$("#divMensajeCaptura").hide(); 
	var noPO=$("#noPO").val();
	var fechaPO=$("#fechaPO").val();
	var noItem=$("#noItem").val(); 
	var diasTAT=$("#diasTAT").val(); 
	var observaciones=$("#observaciones").val(); 
	var idUsuario=document.getElementById("idUsuario").value; 
	var id_proyecto=document.getElementById("id_proyecto").value; 
	var idMov=document.getElementById("idMov").value;
	if(noPO==""||noItem==""||fechaPO==""){ 
		alert("Verifique que los campos no se encuentren vacios"); 
		return; 
	} 
	else{ 
		ajaxApp("detalleEmpaque","controladorEnsamble.php","action=addLote&noPO="+noPO+"&fechaPO="+fechaPO+"&noItem="+noItem+"&diasTAT="+diasTAT+"&observaciones="+observaciones+"&idUsuario="+idUsuario+"&id_proyecto="+id_proyecto+"&idMov="+idMov,"POST"); 
	} 
} 
function formModificaLote(idLote,idProyectoSeleccionado,id_usuario){/*Funcion que muestra formulario para la modificacion del lote*/ 
	$("#transparenciaGeneral1").show(); 
	$("#divMensajeCaptura").show(); 
	ajaxApp("listadoEmpaqueValidacion","controladorEnsamble.php","action=formModificaLote&idProyectoSeleccionado="+idProyectoSeleccionado+"&idLote="+idLote+"&id_usuario="+id_usuario,"POST"); 
} 
function modificaLote(idLote,idProyectoSeleccionado,id_usuario){/*Funcion que guarda las modificaciones de los lotes*/ 
	$("#transparenciaGeneral1").hide(); 
	$("#divMensajeCaptura").hide(); 
	var noPO=$("#nuPo").val();
	var fechaPo=$("#fechaPo").val();
	var noItem=$("#noItem").val(); 
	var fechaReg=$("#fechaReg").val(); 
	var horaReg=$("#horaReg").val(); 
	var diasTAT=$("#diasTAT").val(); 
	var observaciones=$("#observaciones").val(); 
	if(noPO==""||noItem==""||fechaReg==""||fechaPo==""){ 
		alert("Verifique que los campos no se encuentren vacios"); 
		return; 
	} 
	else{ 
		ajaxApp("detalleEmpaque","controladorEnsamble.php","action=modificaLote&noItem="+noItem+"&noPO="+noPO+"&fechaPo="+fechaPo+"&fechaReg="+fechaReg+"&horaReg="+horaReg+"&diasTAT="+diasTAT+"&observaciones="+observaciones+"&idLote="+idLote+"&idProyectoSeleccionado="+idProyectoSeleccionado+"&id_usuario="+id_usuario,"POST"); 
	} 
} 
function eliminaLote(idLote,idProyectoSeleccionado,id_usuario){
	ajaxApp("listadoEmpaqueValidacion","controladorEnsamble.php","action=eliminaLote&id_usuario="+id_usuario+"&idProyectoSeleccionado="+idProyectoSeleccionado+"&idLote="+idLote,"POST"); 	
}
/********************************************Detalle Lote*******************************************************/ 
/*Funciones para la busqueda de noParte para el SENC*/ 
function buskSEC(evento){ 
	var num=document.getElementById("noParte").value; 
	var pos2=$("#noParte").offset();
	var parametros="action=FindSEC&likeNoParte="+num;
	var enter;
	var mleft2=(pos2.left)+1; 
	var mtop2=(pos2.top)+23;
	var keyCode = ('which' in evento) ? evento.which : evento.keyCode;
	if(keyCode==13){
		enter="si";
		ajaxApp("msgresultados","controladorEnsamble.php",parametros+"&enter="+enter,"POST"); 
	}
	$("#resultados").attr("style","position: absolute;z-index: 25;width:300px;height:155px;left:0%;top:0%;font-size:10px;margin-left:"+mleft2+"px;margin-top:"+mtop2+"px;padding:10px;border:1px solid black;background-color:#FFFFFF;"); 
	if(num!="" && keyCode !=13){
		if(keyCode==27){
			cerrarVentana("resultados");
		}
		$("#resultados").fadeIn("9000"); 
		enter="no";
		ajaxApp("msgresultados","controladorEnsamble.php",parametros+"&enter="+enter,"POST"); 
	}	
} 
function inserta(id_SENC,SECN,NoParte){ 
	$("#id_SEC").attr("value",id_SENC); 
	$("#noParte").attr("value",NoParte); 
	$("#noSEC").attr("value",SECN);
	$("#modelo").focus();
} 
/*Fin de funciones para la busqueda de noParte para obtener SENC*/ 
function consultaDetalleLote(idLote,idProyectoSeleccionado,item,opt,idUsuario){/*Funcion que muestra los ITems que pertenecen al lote*/
	$("#tituloDetalle").css("background","#ff0000");
	ajaxApp("detalleEmpaque","controladorEnsamble.php","action=consultaDetalleLote&idLote="+idLote+"&idProyectoSeleccionado="+idProyectoSeleccionado+"&item="+item+"&opt="+opt+"&idUsuario="+idUsuario,"POST"); 
} 
function formAgrega(idLote,idProyectoSeleccionado,Noitem,idUsuario){/*Funcion que muestra el formulario para agregar ITEMS*/ 
	$("#transparenciaGeneral1").show(); 
	$("#divMensajeCaptura").show(); 
	$("#listadoEmpaqueValidacion").html("");
	ajaxApp("listadoEmpaqueValidacion","controladorEnsamble.php","action=formAgrega&idLote="+idLote+"&idProyectoSeleccionado="+idProyectoSeleccionado+"&noItem="+Noitem+"&idUsuario="+idUsuario,"POST"); 
} 
function agregar(idLote,idProyectoSeleccionado,item,idUsuario){ 
	var modelo=$("#modelo").val(); 
	var idTipoComodity=$("#tipoComodity").val(); 
	if(idProyectoSeleccionado==2){ 
	var codeType=$("#codeType").val(); 
	var flowTag=$("#flowTag").val(); 
	}else{ 
		var codeType="N/A"; 
		var flowTag="N/A"; 
	} 
	var numSerie=$("#numSerie").val(); 
	var obs=$("#obs").val(); 
	var idSENC=document.getElementById("id_SEC").value; 
	if(idSENC==""||numSerie==""||codeType==""||flowTag==""||idTipoComodity==""){//||modelo=="" 
		alert("Verifique que los campos no se encuentren vacios"); 
		return; 
	} 
	 else{ 
			$("#transparenciaGeneral1").hide(); 
			$("#divMensajeCaptura").hide(); 
			ajaxApp("detalleEmpaque","controladorEnsamble.php","action=addDetalleLote&modelo="+modelo+"&codeType="+codeType+"&flowTag="+flowTag+"&numSerie="+numSerie+"&desc="+obs+"&idLote="+idLote+"&idProyectoSeleccionado="+idProyectoSeleccionado+"&item="+item+"&idSENC="+idSENC+"&idTipoComodity="+idTipoComodity+"&idUsuario="+idUsuario,"POST"); 
	 } 
} 
function formModifica(idLote,idProyectoSeleccionado,idItem,idUsuario){ 
	//alert(idItem);	
	$("#transparenciaGeneral1").show(); 
	$("#divMensajeCaptura").show(); 
	$("#listadoEmpaqueValidacion").html("");
	ajaxApp("listadoEmpaqueValidacion","controladorEnsamble.php","action=formModifica&idLote="+idLote+"&idProyectoSeleccionado="+idProyectoSeleccionado+"&idItem="+idItem+"&idUsuario="+idUsuario,"POST"); 
} 
function modifica(idLote,idProyectoSeleccionado,idItem,idUsuario){ 
	var modelo=$("#modelo").val();
	var idSENC=document.getElementById("id_SEC").value; 
	var codeType=$("#codeType").val(); 
	var flowTag=$("#flowTag").val(); 
	var idTipoComodity=$("#idTipoComodity").val(); 
	var numSerie=$("#numSerie").val(); 
	var fechReg=$("#date").val(); 
	var horaReg=$("#hour").val(); 
	var desc=$("#desc").val(); 
	 if(idSENC==""||numSerie==""||codeType==""||flowTag==""||idTipoComodity==""){ 
		alert("Verifique que los campos no se encuentren vacios"); 
		return; 
	 } 
	 else{ 
	$("#transparenciaGeneral1").hide(); 
	$("#divMensajeCaptura").hide();
	ajaxApp("detalleEmpaque","controladorEnsamble.php","action=modifica&modelo="+modelo+"&codeType="+codeType+"&flowTag="+flowTag+"&numSerie="+numSerie+"&fechReg="+fechReg+"&horaReg="+horaReg+"&desc="+desc+"&idLote="+idLote+"&idProyectoSeleccionado="+idProyectoSeleccionado+"&idItem="+idItem+"&idTipoComodity="+idTipoComodity+"&idUsuario="+idUsuario+"&idSENC="+idSENC,"POST"); 
	} 	 
}
function quita(){

	$("#resultados").hide();
}
function coloca(){

	$("#resultados").show();
}
function Exportar(idLote,idProyectoSeleccionado,item,idUsuario,idMov){

	ajaxApp("detalleEmpaque","controladorEnsamble.php","action=exportar&idLote="+idLote+"&idProyectoSeleccionado="+idProyectoSeleccionado+"&item="+item+"&idUsuario="+idUsuario+"&idMov="+idMov,"POST"); 	
}
function formSENC(noParte){
	ajaxApp("formaAgrega","controladorEnsamble.php","action=formSENC&noParte="+noParte,"POST");
	$("SENC").focus();
}
function guardaSENC(){

//	alert("aqui esta");
	var noParte=$("#nPar").val();
	var SENC=$("#NSENC").val();
	var plataF=$("#plataF").val();
	var desSEN=$("#descSe").val();
	var procSe=$("#procSe").val();
	if(noParte==""){
		alert("Por Favor ingresa un número de parte");
		return;
	}
	ajaxApp("formaAgrega","controladorEnsamble.php","action=guardaSENC&noParte="+noParte+"&SENC="+SENC+"&plataF="+plataF+"&desSEN="+desSEN+"&procSe="+procSe,"POST");
}
function listaMov(idUsuario,idProyectoSeleccionado){/*Funcion que agrega nuevos lotes*/ 
	$("#transparenciaGeneral1").show(); 
	$("#divMensajeCaptura").show(); 
	ajaxApp("listadoEmpaqueValidacion","controladorEnsamble.php","action=listaMov&idUsuario="+idUsuario+"&idProyectoSeleccionado="+idProyectoSeleccionado,"POST"); 
}
function DetallesExtra(idItem){
	divMuestr="msgDetalles"+idItem;
	ajaxApp(divMuestr,"controladorEnsamble.php","action=muestraDetalles&idItem="+idItem,"POST"); 
}