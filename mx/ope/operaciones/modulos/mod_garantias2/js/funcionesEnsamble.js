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
	ajaxApp("detalleEmpaque","controladorEnsamble.php","action=agregaDatos","POST"); 
}
function editarRegistro(idG){
	clean2();
	ajaxApp("detalleEmpaque","controladorEnsamble.php","action=editarDatos&id="+idG,"POST");
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

function vertabla(){
        /*alert("Seleccione un commodity dentro de las opciones que le ofrece el menu para visualizar las pruebas que contiene");*/
	ajaxApp("detalleEmpaque","controladorEnsamble.php","action=vertabla","POST");
	 }
	 
function insertaRe(){
	
	var campos=new Array();
	var valores=new Array();
	var cam_obligatorios=new Array();
	var va_obligatorios=new Array();
	var sql_valores="";
	var ubicacion;  
	var caracteres = "abcdefghijklmnopqrstuvwxyzñ1234567890ü ABCDEFGHIJKLMNOPQRSTUVWXYZÑáéíóúÁÉÍÓÚÜ/-()&.:-,_@#.' '";
	var form=document.getElementById("form_x");
	
	//recorrer los input para obtener sus id y sus valores
	for(var i=0;i<form.elements.length;i++){
		if(form.elements[i].id=="lanzadorB1"||form.elements[i].id=="lanzadorB2"||form.elements[i].id=="lanzadorB3"||form.elements[i].id=="lanzadorB4"||form.elements[i].id=="dias_trans"||form.elements[i].id=="dias_ab"||form.elements[i].value=="Guardar Registro"||form.elements[i].id=="hoy"){
			
		}else{
			campos.push(form.elements[i].id);
			valores.push(form.elements[i].value);	
		}
	}
	
	
	//Aqui se insertan los campos del formulario que son obligatorios llenar al momento de guardar
	for (var x=0;x<form.elements.length;x++){
		if(form.elements[x].id=="num_reclamo"||form.elements[x].id=="info_falla"||form.elements[x].id=="producto"||form.elements[x].id=="fecha_compra"||form.elements[x].id=="fecha_asignacion"||form.elements[x].id=="status"||form.elements[x].id=="num_contrato"||form.elements[x].id=="nombre_cliente"){
			cam_obligatorios.push(form.elements[x].id);
			va_obligatorios.push(form.elements[x].value);
		}else{
			
		}
		
	}
	//alert(cam_obligatorios);
	//exit;
	//alert(valores);
	
	
	
	
	
	for (var i2=0;i2<cam_obligatorios.length;i2++){
                     if ($("#"+cam_obligatorios[i2]).attr("class")=="campo_obligatorio"&&(va_obligatorios[i2]==""||va_obligatorios[i2]=="undefined"||va_obligatorios[i2]==null)){
                     	    alert("Error: El campo ("+cam_obligatorios[i2]+") es obligatorio.");
                            return;
		     }
                     /*for (var j=0;j<valores[i2].length;j++){  // recorrido de string para buscar caracteres no validos en la cadena  
                        ubicacion = valores[i2].substring(j, j + 1)  
                        if (caracteres.indexOf(ubicacion) != -1) {  
                           if(ubicacion=="'"){
                              ubicacion=ubicacion.replace("'","''");
                              //alert(ubicacion);
                              //return;
                           }
                        }
                        else {  
                           alert("ERROR: No se acepta el caracter '" + ubicacion + "'.")  
                           return; 
                        }  
                     }*/
		     
	}
	
	
	//Se almacenan todos los datos del formulario para después insertarlos
	for(var i3=0;i3<campos.length;i3++){
                     if (sql_valores==""){
                            sql_valores=campos[i3]+"|||"+valores[i3];
			    //alert(sql_valores); exit;
		     } else {
                            sql_valores+="@@@"+campos[i3]+"|||"+valores[i3];
			      //alert(sql_valores); exit;
		     }	
	}
	
	      if (confirm("¿Desea actualiza el registro?")){
                     ajaxApp("detalleEmpaque","controladorEnsamble.php","action=insertaRe&campos_valores="+sql_valores,"POST");
	      }
	             
	}
	
	
	function numeroDias(){
		var difDias=int;
        var fechaInicio = document.getElementById("fecha_asignacion").value;
	var fechaFin = document.getElementById("fecha_compromiso").value;
  
     
         var diaInicio=fechaInicio.substring(0,2);
        var mesInicio=fechaInicio.substring(3,5);
         var anoInicio=fechaInicio.substring(6,10);
         
        var diaFin=fechaFin.substring(0,2);
         var mesFin=fechaFin.substring(3,5);
         var anoFin=fechaFin.substring(6,10);
         
         var f1 =  new Date(anoInicio,mesInicio,diaInicio);
        var f2 =  new Date(anoFin,mesFin,diaFin);
        difDias= Math.floor((f2.getTime()-f1.getTime()) / (1000 * 60 * 60 * 24))+1  
	alert(difDias); exit;
	
	}
	
	
function actualizaRe(id){
  function verifica_prod(evento){
	if(evento.which==13){
	numserie=document.getElementById("num_serie").value;
        campos=numserie;
	}
	else{
	   alert("Ingrese nuevamente el numero de serie");
	document.getElementById("num_serie").focus();
	}
  }
	var campos=new Array();
	var valores=new Array();
	var cam_obligatorios=new Array();
	var va_obligatorios=new Array();
	var sql_valores="";
	var ubicacion;  
	var caracteres = "abcdefghijklmnopqrstuvwxyzñ1234567890ü ABCDEFGHIJKLMNOPQRSTUVWXYZÑáéíóúÁÉÍÓÚÜ/-()&.:-,_";
	var form=document.getElementById("formeditar");
	//recorrer los input para obtener sus valores
	for(var i=0;i<form.elements.length;i++){
		if(form.elements[i].id=="lanzadorB1"||form.elements[i].id=="lanzadorB2"||form.elements[i].id=="lanzadorB3"||form.elements[i].id=="lanzadorB4"||form.elements[i].id=="dias_trans"||form.elements[i].id=="dias_ab"||form.elements[i].value=="Actualizar Registro"||form.elements[i].id=="hoy"){
			
		}else{
			campos.push(form.elements[i].id);
			valores.push(form.elements[i].value);	
		}
	}
	//Aqui se insertan los campos del formulario que son obligatorios llenar al momento de guardar
	for (var x=0;x<form.elements.length;x++){
		if(form.elements[x].id=="num_reclamo"||form.elements[x].id=="info_falla"||form.elements[x].id=="producto"||form.elements[x].id=="fecha_compra"||form.elements[x].id=="fecha_asignacion"||form.elements[x].id=="status"||form.elements[x].id=="num_contrato"||form.elements[x].id=="nombre_cliente"){
			cam_obligatorios.push(form.elements[x].id);
			va_obligatorios.push(form.elements[x].value);
		}else{
			
		}
		
	}
	//alert(cam_obligatorios);
	//exit;
	//alert(valores);
	
	
	//Recorre el arreglo de campos obligatorios para realizar la validación-.....
	for (var i2=0;i2<cam_obligatorios.length;i2++){
                     if ($("#"+cam_obligatorios[i2]).attr("class")=="campo_obligatorio"&&(va_obligatorios[i2]==""||va_obligatorios[i2]=="undefined"||va_obligatorios[i2]==null)){
                     	    alert("Error: El campo ("+cam_obligatorios[i2]+") es obligatorio.");
                            return;
		     }
                     /*for (var j=0;j<valores[i2].length;j++){  // recorrido de string para buscar caracteres no validos en la cadena  
                        ubicacion = valores[i2].substring(j, j + 1)  
                        if (caracteres.indexOf(ubicacion) != -1) {  
                           if(ubicacion=="'"){
                              ubicacion=ubicacion.replace("'","''");
                              //alert(ubicacion);
                              //return;
                           }
                        }
                        else {  
                           alert("ERROR: No se acepta el caracter '" + ubicacion + "'.")  
                           return; 
                        }  
                     }*/
		     
	}
	
	
	//Se almacenan todos los datos del formulario para después insertarlos
	for(var i3=0;i3<campos.length;i3++){
                     if (sql_valores==""){
                            sql_valores=campos[i3]+"|||"+valores[i3];
			    //alert(sql_valores); exit;
		     } else {
                            sql_valores+="@@@"+campos[i3]+"|||"+valores[i3];
			      //alert(sql_valores); exit;
		     }	
	}
	      
              if (confirm("¿Desea modificar el registro?")){
                     ajaxApp("detalleEmpaque","controladorEnsamble.php","action=actRe&campos_valores="+sql_valores+"&idd="+id,"POST");
	      }
	             
	}	 
	 
function getDias(){
	
	
	fechahoy= new Date();
	fechasinfor=Date.parse(fechahoy);
	fechaAsig=document.getElementById("fecha_asignacion").value.split("-");
	temp2=new Date(fechaAsig[0],fechaAsig[1]-1,fechaAsig[2])
	fechamil=Date.parse(temp2);
	un_dia=1000*60*60*24;
	resta=fechasinfor-fechamil;
	
	diferencia=Math.floor(resta/un_dia);
	
	$("#dias_trans").attr("value",diferencia);
	
}
 






