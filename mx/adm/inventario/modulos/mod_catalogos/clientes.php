<?php 
	session_start();
	include("../../conf/validar_usuarios.php");
	validar_usuarios(0,1,2);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<title>Contactos del Sistema</title>



  <script src="../../js/jquery.js" type="text/javascript"></script>



  <script type="text/javascript">

	//$(document).ready(accion('listar'));

	function accion(a)

	{

	  	$("#div_contactos").hide();

		$("#contenido").show();

		  $.ajax({

		   async:true,

		   type: "POST",

		   dataType: "html",

		   contentType: "application/x-www-form-urlencoded",

		   url:"clientes2.php",

		   data:"accion="+a,

		   beforeSend:function(){ 

				$("#contenido").show().html('<center><br><img src="../../img/loading2.gif"><br>Cargando pagina, espere un momento.</center>'); 

			},

		   success:function(datos){ $("#contenido").show().html(datos); },

		   timeout:90000000,

		   error:function() { $("#contenido").show().html('<center>Error: El servidor no responde. <br>Por favor intente mas tarde. </center>'); }

		 }); 	

	}

	

	function validar_frm0()

	{

		var id_cliente=$("#id_cliente").attr("value");				

		var fecha_alta=$("#fecha_alta").attr("value");					

		var activo=$("#activo").attr("value");					

		var cve_cliente=$("#cve_cliente").attr("value");				if (validar_campo("Clave del cliente",cve_cliente)) { /*OK*/ } else { return; }				

		var r_social=$("#r_social").attr("value");						if (validar_campo("Razon Social",r_social)) { /*OK*/ } else { return; }

		var n_comercial=$("#n_comercial").attr("value");				if (validar_campo("Nombre Comercial",n_comercial)) { /*OK*/ } else { return; }

		var rfc=$("#rfc").attr("value");								if (validar_campo("RFC",rfc)) { /*OK*/ } else { return; }

		var direccion_web=$("#direccion_web").attr("value");			if (validar_campo("Direccion Web",direccion_web)) { /*OK*/ } else { return; }

		var calle_numero=$("#calle_numero").attr("value");				if (validar_campo("Calle / Numero",calle_numero)) { /*OK*/ } else { return; }			

		var colonia=$("#colonia").attr("value");						if (validar_campo("Colonia",colonia)) { /*OK*/ } else { return; }

		var del_mun=$("#del_mun").attr("value");						if (validar_campo("Del / Municipio",del_mun)) { /*OK*/ } else { return; }		

		var entidad=$("#entidad").attr("value");						if (validar_campo("Entidad",entidad)) { /*OK*/ } else { return; }

		var pais=$("#pais").attr("value");								if (validar_campo("Pais",pais)) { /*OK*/ } else { return; }

		var cp=$("#cp").attr("value");									if (validar_campo("CP",cp)) { /*OK*/ } else { return; }

		var contactos=$("#contactos").attr("value");					if (validar_campo("Contactos",contactos)) { /*OK*/ } else { return; }

		var obs=$("#obs").attr("value");									



		if (confirm("¿Desea guardar el Cliente?"))

		{

			 var d="accion=guardar_cliente&id_cliente="+id_cliente+"&fecha_alta="+fecha_alta+"&activo="+activo+"&cve_cliente="+cve_cliente+"&r_social="+r_social+"&n_comercial="+n_comercial+"&rfc="+rfc+"&direccion_web="+direccion_web+"&calle_numero="+calle_numero+"&colonia="+colonia+"&del_mun="+del_mun+"&entidad="+entidad+"&pais="+pais+"&cp="+cp+"&contactos="+contactos+"&obs="+obs;

			 //alert(d);

			  $.ajax({

			   async:true,

			   type: "POST",

			   dataType: "html",

			   contentType: "application/x-www-form-urlencoded",

			   url:"clientes2.php",

			   data:d,

			   beforeSend:function(){ 

					$("#contenido").show().html('<center><br><img src="../../img/loading2.gif"><br>Cargando pagina, espere un momento.</center>'); 

				},

			   success:function(datos){ $("#contenido").show().html(datos); },

			   timeout:90000000,

			   error:function() { $("#contenido").show().html('<center>Error: El servidor no responde. <br>Por favor intente mas tarde. </center>'); }

			 });

			 

		 }		

		

	}

	

	function validar_campo(campo,valor)

	{

		//alert("Campo: "+campo+"\nValor: "+valor);

		if (valor==""||valor=="undefined")

		{

			alert("Error: El campo "+campo+" es obligatorio, por favor capture un valor.");

			return false;

		} else {

			// ok

			return true;

		}	

	}

	

	function ver_cliente(id_cliente)

	{

	  $.ajax({

	   async:true,

	   type: "POST",

	   dataType: "html",

	   contentType: "application/x-www-form-urlencoded",

	   url:"clientes2.php",

	   data:"accion=ver_cliente&id_cliente="+id_cliente,

	   beforeSend:function(){ 

			$("#contenido").show().html('<center><br><img src="../../img/loading2.gif"><br>Cargando pagina, espere un momento.</center>'); 

		},

	   success:function(datos){ $("#contenido").show().html(datos); },

	   timeout:90000000,

	   error:function() { $("#contenido").show().html('<center>Error: El servidor no responde. <br>Por favor intente mas tarde. </center>'); }

	 });	

	}	

	

	

	

	function elegir_contacto()

	{

		$("#contenido").hide();

		  $.ajax({

		   async:true,

		   type: "POST",

		   dataType: "html",

		   contentType: "application/x-www-form-urlencoded",

		   url:"clientes2.php",

		   data:"accion=ver_contactos",

		   beforeSend:function(){ 

				$("#div_contactos").show().html('<center><br><img src="../../img/loading2.gif"><br>Cargando pagina, espere un momento.</center>'); 

			},

		   success:function(datos){ $("#div_contactos").show().html(datos); },

		   timeout:90000000,

		   error:function() { $("#div_contactos").show().html('<center>Error: El servidor no responde. <br>Por favor intente mas tarde. </center>'); }

		 });		

	}

	

	function colocar_contactos()

	{

		var claves="";

		for (var i=0;i<document.frm1.elements.length;i++)

		{

			if (document.frm1.elements[i].type=="checkbox")

			{

				if (document.frm1.elements[i].checked)

				{

					//alert("Variable claves=["+claves+"]");

					if (claves=="")

						claves=claves+document.frm1.elements[i].value;

					else

						claves=claves+","+document.frm1.elements[i].value;

				}	

			}

		}

		if (claves==""||claves=='undefined') return;

		//alert("Colocar: "+claves);

		

		$("#contenido").show();

		$("#div_contactos").hide();

		$("#contactos").attr("value",claves);		

	}

	

	

	

	

	

	

	

  </script>	

	<style type="text/css">

		body,document{ margin:0px 0px 0px 0px; font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px;}

		a:link{ text-decoration:none;}

		a:hover{ text-decoration:none; color:#FF0000;}

		a:visited{ text-decoration:none;}		

		#all { margin:0px 0px 0px 0px; }

			#titulo { text-align:center; padding:2px; font-size:16px; margin:10px 10px 10px 10px;  }

			#opciones { text-align:right; margin:1px 10px 2px 0px; }

			#contenido { text-align:left; margin:10px 10px 10px 0px; padding:10px 10px 10px 0px; }

			

		.txtoc { text-align:center; background-color:#FFFFFF; border: #CCCCCC 1px solid; height:17px;}	

		.txtoi { text-align:left; background-color:#FFFFFF; border: #CCCCCC 1px solid; height:17px;}

		.txtvi { text-align:left; background-color:#FFFFFF; border: #CCCCCC 1px dotted; height:17px;}

		

		.td1{ border-left:#efefef 1px solid; border-right:#efefef 1px solid;}

		.td1i{ border-left:#efefef 1px solid; }		

		img { width:32px; height:32px;}

		

		.cv { font-weight:bold; text-align:left; background-color:#EFEFEF; color: #666666; padding-left:5px; }		

	</style>	  

</head>



<body onload="accion('listar')">

	<? include("../menu/menu.php"); ?>

	<div id="all">

		<br />

		<div id="opciones">

			<a href="javascript:accion('listar');">Listar</a> | 

			<a href="javascript:accion('nuevo');">Nuevo Cliente </a>&nbsp;

		</div>

		<div id="contenido">

			<center>&nbsp;</center>

		</div>

		<div id="div_contactos">&nbsp;</div>

	</div>
	<?	include("../../f.php");	?>
</body>

</html>