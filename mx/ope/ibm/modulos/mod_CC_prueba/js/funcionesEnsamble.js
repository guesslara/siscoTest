
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

function confirmar(){
	var entrar = confirm("¿Realmente quieres guardar los datos?");
	if ( !entrar ) exit();
}
function confirmarSalir(){
	var salir = confirm("¿Realmente quieres Salir de este apartado");
	if ( !salir )
	return;
}
function muestraLista(idProyectoSeleccionado,idUserCC){
	$("#contenido").html("");
	$("#contenido").hide();
	ajaxApp("listadoEmpaque","controladorEnsamble.php","action=muestraListado&idProyecto="+idProyectoSeleccionado+"&idUserCC="+idUserCC,"POST");
}
function muestraInfo(idItem,idProyectoSeleccionado,idUserCC){
	ajaxApp("detalleEmpaque","controladorEnsamble.php","action=muestraInfo&idItem="+idItem+"&idProyecto="+idProyectoSeleccionado+"&idUserCC="+idUserCC,"POST");
}

function guardaDatos(idItem,idUserCC,statusCC,idProyecto){
	var idsprubsi=new Array();
	var idsprubno=new Array();
	var valorescheck=new Array();
	var checkvacios=new Array();
	var pruecheck=new Array();
	var cont=1;
	for(var j=0;j<$("input:radio").length;j++){
		
		if($("input:radio")[j].checked){
			if($("input:radio")[j].value=="Si"){
				idsprubsi.push($("input:hidden[name='num_prueba']")[j].value);
			}else{
				idsprubno.push($("input:hidden[name='num_prueba']")[j].value);
			}
			cont--;
		}else{
			cont++;	
		}
		if(cont>2){
		checkvacios.push($("input:radio")[j].id);
		cont=1;
		}
	}

	if(checkvacios!=""){
		for(var z=0; z<checkvacios.length;z++){
		alert("Verifique la "+checkvacios[z]);
		return;
		}
	}else{
		
	var aseg_calidad=$("#aseguramientoCalidad").val();
	var obserCC=$("#observacionesCC").val();
	
	}
		if(confirm("¿Esta seguro que el checklist es "+statusCC+"?")){
			ajaxApp("detalleEmpaque","controladorEnsamble.php","action=guardaDatos&idItem="+idItem+"&idUserCC="+idUserCC+"&statusCC="+statusCC+"&obserCC="+obserCC+"&aseg_calidad="+aseg_calidad+"&idsprubsi="+idsprubsi+"&idsprubno="+idsprubno+"&idProyecto="+idProyecto,"POST");
		}else{
			return;
		}
}
function buscaPorParametro(evento){
	
	if(evento.which==13){
	paraBusqueda=$("#opciones").val();
		
	if(paraBusqueda=="undefined"){
		alert("Debe seleccionar una opcion para buscar");
		return 0;
	}		
	valor=document.getElementById("no_x").value;
	ajaxApp("listadoEmpaque","controladorEnsamble.php","action=busquedaxParametro&paraBusqueda="+paraBusqueda+"&valor="+valor,"POST");


	}else{
		document.getElementById("no_x").focus();
	}
		return 1;
}
function muestraReporte(idItem,idProyectoSeleccionado,idUserCC){
	ajaxApp("detalleEmpaque","controladorEnsamble.php","action=muestraReporte&idItem="+idItem+"&idProyecto="+idProyectoSeleccionado+"&idUserCC="+idUserCC,"POST");
}
 function seleccionCambia(){
	paraBusqueda=$("#opciones").val();
		
	if(paraBusqueda=="undefined"){
		alert("Debe seleccionar una opcion para buscar");
		return 0;
	}else{
		document.getElementById("no_x").focus();
	}
		return 1;
	
 }
 function cambiaColor(div){
	div.style.backgroundColor="#888888"
 }
 
 function quitaColor(div){
	div.style.backgroundColor="#ffffff"
 }
