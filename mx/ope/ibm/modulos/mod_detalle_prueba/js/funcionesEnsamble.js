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



function nuevaPrueba() {
	/*alert("El o los Commodities que se encuentran en el menu de seleccion no contienen pruebas");
	alert("A continuacion Seleccione un Commodity dentro del menu para agregar pruebas al mismo");*/
	ajaxApp("detalleEmpaque","controladorEnsamble.php","action=edittest","POST"); 
	}
	
function recuperaCC(){
	var selectt=$("#idCommodity").val();
	var cont="";
	var contText="";
	var selection=document.getElementById("formcommod");
	for(j=0;j<selection.elements.length;j++){
		if(selection.elements[j].type =="checkbox"){
		    if(selection.elements[j].checked){
		       if(cont==""){
			 cont=cont+selection.elements[j].value;
		       }	
		       else{
		        cont=cont+","+selection.elements[j].value;		
			} 
		     }	
		}
	}
        if(cont==""){
		alert("No se ha seleccionado ningun parametro de pruebas");
	}
	
	else{
	if (selectt=="") {
		alert("No se ha seleccionado ningun commodity");
		return;
		}
		conta=cont;
		
		var parameters="action=insertar&comm="+selectt+"&conta="+conta;
		ajaxApp("detalleEmpaque","controladorEnsamble.php", parameters,"POST");	
	}
}

function vercommodity(){
        /*alert("Seleccione un commodity dentro de las opciones que le ofrece el menu para visualizar las pruebas que contiene");*/
	ajaxApp("detalleEmpaque","controladorEnsamble.php","action=vercommodity","POST");
	 }
	 
function verpruebas(sel){
        /*alert("Da click en el botón OK para limpiar la pantalla");*/
	var valSelec = sel.options[sel.selectedIndex].value;
	var parameters="action=verpruebas&idcomm="+valSelec;
	ajaxApp("pruebas","controladorEnsamble.php",parameters,"POST");
	 }

function commoditypruebas(){
	/*alert("Seleccione un Commodity dentro del menu de seleccion para mostrar las pruebas que contiene");*/
	ajaxApp("detalleEmpaque","controladorEnsamble.php","action=commoditypruebas","POST");
	 }
	 
function mostrarpruebas(sel){
	/*alert("Seleccione las pruebas que desee eliminar y de click en el boton BORRAR");*/
//alert(sel);
	var valSelec = sel.options[sel.selectedIndex].value;
	var parameters="action=mostrarpruebas&idcomost="+valSelec;
	ajaxApp("pruebas","controladorEnsamble.php",parameters,"POST");
	 }
	 
function eliminar(){
	//$("#detalleEmpaque").html("");
	var selectid=$("#idCommo").val();
	/*alert(selectprueba);*/
	var cont="";
	var contText="";
	var selection=document.getElementById("formdelet");
	for(j=0;j<selection.elements.length;j++){
		if(selection.elements[j].type =="checkbox"){
		    if(selection.elements[j].checked){
		       if(cont==""){
			 cont=cont+selection.elements[j].value;
		       }	
		       else{
		        cont=cont+","+selection.elements[j].value;		
			} 
		     }	
		}
	}
        if(cont==""){
		alert("No se ha seleccionado ninguna prueba(s)");
	}
	
	else{
	if (selectid=="") {
		alert("No se ha seleccionado ningun commodity");
		return;
		}
	conta=cont;
	/*alert(conta);
	exit;*/
	var parameters="action=eliminar&sell="+selectid+"&conta="+conta;
	//alert(parameters);	
	ajaxApp("pruebas","controladorEnsamble.php",parameters,"POST");
	 
	}
}

function commodityfull() {
	/*alert("Seleccione un Commodity dentro del menu de seleccion para agregar pruebas");*/
	ajaxApp("detalleEmpaque","controladorEnsamble.php","action=commodityfull","POST"); 
	}

function verpruebas2(sel){
	/*alert("Se mostraran a continuacion las pruebas que no contenga el Commodity seleccionado y que desee agregar");
	alert("Seleccione las pruebas que desee agregar y de click en el botón GUARDAR");*/
	$("#pruebas").html("");
	var valSelec = sel.options[sel.selectedIndex].value;
	var parameters="action=verpruebas2&idcommx="+valSelec;
	ajaxApp("pruebas","controladorEnsamble.php",parameters,"POST");
	//alert(parameters);
	 }
	 
function recuper(){
	//$("#detalleEmpaque").html("");
	var selectid=$("#modifikr").val();
	/*alert(selectprueba);*/
	var cont="";
	var contText="";
	var selection=document.getElementById("savethm");
	for(j=0;j<selection.elements.length;j++){
		if(selection.elements[j].type =="checkbox"){
		    if(selection.elements[j].checked){
		       if(cont==""){
			 cont=cont+selection.elements[j].value;
		       }	
		       else{
		        cont=cont+","+selection.elements[j].value;		
			} 
		     }	
		}
	}
        if(cont==""){
		alert("No se ha seleccionado ninguna prueba(s)");
	}
	
	else{
	if (selectid=="") {
		alert("No se ha seleccionado ningun commodity");
		return;
		}
	conta=cont;
	/*alert(conta);
	exit;*/
	var parameters="action=insertar2&sell="+selectid+"&conta="+conta;
	//alert(parameters);	
	ajaxApp("pruebas","controladorEnsamble.php",parameters,"POST");	
	}
}

function ActivarDivborrar(){
        var contenedor = document.getElementById("borrar");
        contenedor.style.display = "block";
        return true;
    }
    
function ActivarDivmodify(){
        var contenedor = document.getElementById("modify");
        contenedor.style.display = "block";
        return true;
    }
    
function ActivarDivadd(){
        var contenedor = document.getElementById("add");
        contenedor.style.display = "block";
        return true;
    }



function listaMov(idUsuario,idProyectoSeleccionado){/*Funcion que agrega nuevos lotes*/ 
	
	ajaxApp("listadoEmpaqueValidacion","controladorEnsamble.php","action=listaMov&idUsuario="+idUsuario+"&idProyectoSeleccionado="+idProyectoSeleccionado,"POST"); 
}