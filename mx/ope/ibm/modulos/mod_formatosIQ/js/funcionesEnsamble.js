
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
	ajaxApp("cuerpo","Cuerpos/"+noform+".php","pagAct="+(pagAct-1)+"&intervalo="+(nvolimite)+"&totalpag="+paginasT+"&idLote="+idLote,"POST");
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

function insertform(){
	
	var idlote=document.getElementById("lote").value;
	var fecha=document.getElementById("fecha").value;
	var iframe = document.getElementById("reloj");
	var input= iframe.contentWindow.document.getElementById("reloj2").value;
	var nombr=document.getElementById("nombre").value;
        var intro=document.getElementById("intro").value;
	var numparte=document.getElementById("numpart").value;
	var pic=document.getElementById("uploadedfile");
	var inputt= pic.contentWindow.document.getElementById("nbre").value;
	var comentarios=document.getElementById("coment").value;
	var firma=document.getElementById("firma").value;
	var parametros="action=insertardatos&loteid="+idlote+"&fecha="+fecha+"&timer="+input+"&name="+nombr+"&introd="+intro+"&nuparte="+numparte+"&fott="+inputt+"&comenta="+comentarios+"&firma="+firma;
//alert(parametros);

	ajaxApp("uno","controladorEnsamble.php",parametros,"POST");
}

function insertformdos(){
	
	var idlote=document.getElementById("lote").value;
	var fecha=document.getElementById("fecha").value;
	var iframe = document.getElementById("reloj");
	var input= iframe.contentWindow.document.getElementById("reloj2").value;
	var nombr=document.getElementById("nombre").value;
        var intro=document.getElementById("intro").value;
	var numparte=document.getElementById("numpart").value;
	var picture=document.getElementById("uploadedfile");
	var inputt= picture.contentWindow.document.getElementById("nobre").value;
	var comentarios=document.getElementById("coment").value;
	var firma=document.getElementById("firma").value;
	var parametros="action=insertardatosdos&loteid="+idlote+"&fecha="+fecha+"&timer="+input+"&name="+nombr+"&introd="+intro+"&nuparte="+numparte+"&fott="+inputt+"&comenta="+comentarios+"&firma="+firma;
//alert(parametros);
	ajaxApp("uno","controladorEnsamble.php",parametros,"POST");
}

function valida(){
        
        var nombr=document.getElementById("nombre").value;
        var intro=document.getElementById("intro").value;
        var numparte=document.getElementById("numpart").value;
	var comentar=document.getElementById("coment").value;
	var fir=document.getElementById("firma").value;
        var validando=true;
        msj="";       
        
	
	if (fir==""){
            msj="Firma o nombre de quien elabora";
        }   
        if (comentar==""){
            msj="Escribir comentarios en el espacio correspondiente";
        }
	if (numparte==""){
            msj="Ingresa el numero de parte en el espacio correspondiente";
        }
	 if (intro==""){
	      msj="Ingresa la introducción en el campo correspondiente";
        }
	if (nombr==""){
            msj="Ingresa nombre del destinatario";
        }

	if(nombr==""||intro==""||numparte==""||comentar==""||fir=="") {
	  alert(msj);
	  return;
	}else{
	       insertform();
	   }
}
 

	




	







    