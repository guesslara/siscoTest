// JavaScript Document
	/*
	 *funcionEnsamble: contiene las funciones de javascript del modulo
	 *Autor: Rocio Manuel Aguilar
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

function clean2(op){
	if(op=="listadoEmpaque"){
		$("#listadoEmpaque").html("");
	}else{
		$("#detalleEmpaque").html("");
	}
}


function abreVentana(div,accion,idItem,idProyectoSeleccionado,idUser,div2){
	
	if(div=="ventanaDialogo1"){	
		$("#ventanaDialogo1").show();
		if(div2=="barraBotonesVentanaDialogo"){
			$("#barraBotonesVentanaDialogo").show();
		}
	}else{
		div="detalleEmpaque";
	}
}


function buscaPorParametro(evento,idProyecto,idUsuario){
	
	if(evento.which==13){
		
            seleccion=$("#opciones").val();
		//alert(paraBusqueda);
		
	if(seleccion=="undefined"){
		alert("Debe seleccionar una opcion para buscar");
		return 0;
	}		
            serieOParte=document.getElementById("dato").value;
	//alert(valor);
	//exit;
            ajaxApp("detalleEmpaque","controladorEnsamble.php","action=busquedaxParametro&seleccion="+seleccion+"&serieOParte="+serieOParte,"POST");


	}else{
		document.getElementById("dato").focus();
	}
		return 1;
}

 function seleccionCambia(){
	//alert("Si llega aqui");
	//exit();
		seleccion=$("#opciones").val();
		//alert(paraBusqueda);
		
	if(seleccion=="undefined"){
		alert("Debe seleccionar una opcion para buscar");
		return 0;
	}else{
		document.getElementById("dato").focus();
	}
		return 1;
	
 }
 
 function detalles_dyr(idItem){
	
	
	$("#muestraMas"+idItem).show();
	
	ajaxApp("contDYR"+idItem,"controladorEnsamble.php","action=detallesdyr&iditem="+idItem,"POST");
 }
 function detalles_cc(idItem){
	//alert(idItem);
	$("#muestraOtro"+idItem).show();
	ajaxApp("contCC"+idItem,"controladorEnsamble.php","action=detallesCC&idItem="+idItem,"POST");
	
 }

function cerrar(div){
	$("#"+div).hide();
}


