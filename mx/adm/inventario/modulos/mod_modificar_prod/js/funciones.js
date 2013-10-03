function ajaxApp(divDestino,url,parametros,metodo){
	var buscador="detalleUsuarios";
	$.ajax({
	async:true,
	type: metodo,
	dataType: "html",
	contentType: "application/x-www-form-urlencoded",
	url:url,
	data:parametros,
	beforeSend:function(){ 
		if(divDestino != "detalleUsuarios1"){
			$("#cargando").show();		
		}
	},
	success:function(datos){
		$("#cargando").hide();
		if(divDestino == "detalleUsuarios1"){
			$("#"+buscador).show().html(datos);
		}else{
			$("#"+divDestino).show().html(datos);
		}
	},
	timeout:90000000,
	error:function() { $("#"+divDestino).show().html('<center>Error: El servidor no responde. <br>Por favor intente mas tarde. </center>'); }
	});
}
function nuevoUsuario(){
	div="detalleUsuarios";
	url="controladorUsuarios.php";
	parametros="action=nuevoUsuarioForm";
	metodo="GET";
	ajaxApp(div,url,parametros,metodo);	
}

function Buscador(){
	var txtBuscar=document.getElementById("txtBuscar").value;

	parametros="action=consulta&txtBusca="+txtBuscar;
	ajaxApp("detalleUsuarios1","controladorUsuarios.php",parametros,"POST");
	
}
