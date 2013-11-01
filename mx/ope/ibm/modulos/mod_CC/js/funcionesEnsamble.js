
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


function abreVentana(div,accion,idParte,idProyectoSeleccionado,idUser,div2){
	
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
	if ( !salir ) exit();
}
function muestraLista(idProyectoSeleccionado,idUserCC){
	//alert(idProyectoSeleccionado);
	//exit;
	$("#contenido").html("");
	$("#contenido").hide();
	ajaxApp("listadoEmpaque","controladorEnsamble.php","action=muestraListado&idProyecto="+idProyectoSeleccionado+"&idUserCC="+idUserCC,"POST");
}
function muestraInfo(idParte,idProyectoSeleccionado,idUserCC){
	//alert(idUserCC);
	//exit;
	ajaxApp("detalleEmpaque","controladorEnsamble.php","action=muestraInfo&idParte="+idParte+"&idProyecto="+idProyectoSeleccionado+"&idUserCC="+idUserCC,"POST");
}
/*function prueba1(idParte,idProyectoSeleccionado,idUserCC,idGrupo){
	arrayLCD=['pinturaOriginal','texturaUniforme','serigrafia','rayones','partesRotas','rayadoMarcado','faltanPiezas','limpio','botonesBuenEstado','enciende','datosEtiqueta','pruebasFuncionales','empaque','datosEquipo'];
	arrayHD=['bolsaConductiva','faltanPiezas','limpio','datosEtiqueta','pruebasFuncionales','empaque','formateado'];
	arrayMB=['bolsaConductiva','faltanPiezas','limpio','componentesDañados','partesDesoldadas','soldadura','holograma','scanearEtiqueta','realizarPruebas','pruebasFuncionales','empaque','datosEquipo'];
	if(idGrupo==1){
		for(var j=0;j<arrayHD.length;j++){
			$("#"+arrayHD[j]).hide();
		}
		for(var k=0;k<arrayMB.length;k++){
			$("#"+arrayMB[k]).hide();
		}
		for(var i=0;i<arrayLCD.length;i++){
			$("#"+arrayLCD[i]).show();
		}
	}
	if(idGrupo==3){
		for(var i=0;i<arrayLCD.length;i++){
			$("#"+arrayLCD[i]).hide();
		}
		for(var k=0;k<arrayMB.length;k++){
			$("#"+arrayMB[k]).hide();
		}
		for(var j=0;j<arrayHD.length;j++){
			$("#"+arrayHD[j]).show();
		}
	}
	if(idGrupo==2){
		for(var i=0;i<arrayLCD.length;i++){
			$("#"+arrayLCD[i]).hide();
		}
		for(var j=0;j<arrayHD.length;j++){
			$("#"+arrayHD[j]).hide();
		}
		for(var k=0;k<arrayMB.length;k++){
			if(idProyectoSeleccionado!='2' && arrayMB[k]=='holograma'){
				$("#"+arrayMB[k]).hide()
			}
			else{
				$("#"+arrayMB[k]).show();
			}
		}
	}
	ajaxApp("detalleEmpaque","controladorEnsamble.php","action=prueba1&idParte="+idParte+"&idProyecto="+idProyectoSeleccionado+"&idUserCC="+idUserCC+"&idGrupo="+idGrupo,"POST");
}*/
function guardaDatosPrueba1(idParte,idProyecto,idUserCC,idGrupo){
	if(idGrupo==1){
		arrayLCD=['pinturaOriginal','texturaUniforme','serigrafia','rayones','partesRotas','rayadoMarcado','faltanPiezas','limpio','botonesBuenEstado','enciende','datosEtiqueta','pruebasFuncionales','empaque','datosEquipo'];
		arrayValida=Array();
		arrayResultado=Array();
		for(var i=0;i<arrayLCD.length;i++){
			arrayValida[i]=$("'input:radio[name='"+arrayLCD[i]+"']:checked'").val();
			//alert(arrayValida[i]);
			/*if($("#"+arrayValida[i]+"Rd").is(':checked')){*/
				arrayResultado[i]="&"+arrayLCD[i]+"="+$("'input:radio[name='"+arrayLCD[i]+"']:checked'").val();
				//alert(ArrayResultado);
			/*}
			else{
				
				alert("Faltan elementos por contestar");
				alert("este es el arrayLCD y no entro="+arrayLCD[i]);
				 //$("#pregunta"+arrayLCD[i]).css({ color: "#FFFFFF", background: "#000000" });
				//$(arrayLCD[i]).attr ('style', 'background: #F5F060');
				return;
			}*/
			
			
		}
		alert(arrayResultado);
	}
	if(idGrupo==2){
		
	}
	if(idGrupo==3){
		
	}
	
}
function guardaDatos(idParte,idProyecto,idUserCC,idLote){
	
	var cosmetica = $("input:radio[name='cosmetica']:checked").val();
	var limpieza = $("input:radio[name='limpieza']:checked").val();
	var piezasFaltantes = $("input:radio[name='piezasFaltantes']:checked").val();
	var partesSueltas = $("input:radio[name='partesSueltas']:checked").val();
	var pantallaFisica = $("input:radio[name='pantallaFisica']:checked").val();
	var enciende = $("input:radio[name='enciende']:checked").val();
	var serial = $("input:radio[name='serial']:checked").val();
	var saHDMI = $("input:radio[name='saHDMI']:checked").val();
	var saDVI = $("input:radio[name='saDVI']:checked").val();
	var bocinas = $("input:radio[name='bocinas']:checked").val();
	var pruebaFunc = $("input:radio[name='pruebaFunc']:checked").val();
	var inspID=$("#inspID").val();
	var statusCC=$("#statusCC").val();
	var date=$("#date").val();
	var hr=$("#hr").val();
	var min=$("#min").val();
	var obserCC=$("#obserCC").val();
	if(!cosmetica||!limpieza||!piezasFaltantes||!partesSueltas||!pantallaFisica||!enciende||!serial||!saHDMI||!saDVI||!bocinas||!pruebaFunc||inspID==0||statusCC==0){
		alert("Verifique que todos los campos se hayan seleccionado");
		return;
	}
	else{
		ajaxApp("detalleEmpaque","controladorEnsamble.php","action=guardaDatos&idParte="+idParte+"&idProyecto="+idProyecto+"&idUserCC="+idUserCC+"&cosmetica="+cosmetica+
		"&limpieza="+limpieza+"&piezasFaltantes="+piezasFaltantes+"&partesSueltas="+partesSueltas+"&pantallaFisica="+pantallaFisica+"&enciende="+enciende
		+"&serial="+serial+"&saHDMI="+saHDMI+"&saDVI="+saDVI+"&bocinas="+bocinas+"&pruebaFunc="+pruebaFunc+"&inspID="+inspID+"&statusCC="+statusCC+"&date="+date
		+"&hr="+hr+"&min="+min+"&idLote="+idLote+"&obserCC="+obserCC,"POST");
	}
}
function muestraReporte(idParte,idProyectoSeleccionado,idUserCC){
	ajaxApp("detalleEmpaque","controladorEnsamble.php","action=muestraReporte&idParte="+idParte+"&idProyecto="+idProyectoSeleccionado+"&idUserCC="+idUserCC,"POST");
}