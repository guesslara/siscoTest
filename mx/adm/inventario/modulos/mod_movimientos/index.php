<?php 	
	session_start();
	include("../../conf/validar_usuarios.php");
	validar_usuarios(0,1,2);
	include ("../../conf/conectarbase.php");	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Movimientos</title>
  <script language="javascript" src="../../js/jquery.js"></script>
  <link rel="stylesheet" type="text/css" media="all" href="../../js/Calendario/calendar-green.css" title="win2k-cold-1" /> 
  <script type="text/javascript" src="../../js/Calendario/calendar.js"></script>
  <script type="text/javascript" src="../../js/Calendario/calendar-es.js"></script>
  <script type="text/javascript" src="../../js/Calendario/calendar-setup.js"></script>  

<script language="javascript">
	function seleccionar(a)
	{
		$.ajax({
		async:true,
		type: "POST",
		dataType: "html",
		contentType: "application/x-www-form-urlencoded",
		url:"movimientos.php",
		data:"accion="+a,
		beforeSend:function(){ 
			$("#opciones").show().html('<center><br><img src="../img/loading2.gif"><br>Procesando informacion, espere un momento.</center>'); 
		},
		success:function(datos){ $("#opciones").show().html(datos); },
		timeout:90000000,
		error:function() { $("#opciones").show().html('<center>Error: El servidor no responde. <br>Por favor intente mas tarde. </center>'); }
		});		
	}

	function cerrar(d)
	{
		$("#"+d).hide();
		$("#all").css("background-image","");
		$("#datos2").show();
	}
	function cerrar2(d)
	{
		$("#"+d).hide();
		$("#all").css("background-image","");
		$("#div_items_movs1").show();
	}			
	
	function muestra_opciones()
	{
		$("#datos2").hide('');
		$("#opciones2").show('');
	}

	function coloca_tipo(i,a,c,t)
	{
		$("#txt_tipo_mov1").attr("value",i);
		$("#hdn_asociado1").attr("value",a);
		$("#hdn_concepto1").attr("value",c);
		$("#hdn_tipo1").attr("value",t);
		cerrar('opciones2');
		$("#datos2").show();
		$("#tit_mov7").html("&nbsp;&nbsp;&nbsp;&nbsp;Movimiento de "+c);
		if (i==1)
		{
			$("#lbl_oc0").show();
			$("#txt_oc0").show();
		} else {
			$("#lbl_oc0").hide();
			$("#txt_oc0").hide();		
		}
	}
	
	function coloca_almacen1(i,a)
	{
		$("#txt_idalmacen1").attr("value",i);
		$("#hdn_almacen1").attr("value",a);
		cerrar('almacenes1');
		$("#datos2").show();
	}
	
	function ver_asociado()
	{
		var asociadoX=$("#hdn_asociado1").attr("value");
		var conceptoX=$("#hdn_concepto1").attr("value");
		$.ajax({
		async:true,
		type: "POST",
		dataType: "html",
		contentType: "application/x-www-form-urlencoded",
		url:"movimientos.php",
		data:"accion=ver_asociados&a="+asociadoX+"&conceptoX="+conceptoX,
		beforeSend:function(){ 
			$("#datos2").hide();
			$("#div_asociado").show().html('<center><br><img src="../img/loading2.gif"><br>Procesando informacion, espere un momento.</center>'); 
		},
		success:function(datos){ $("#div_asociado").show().html(datos); },
		timeout:90000000,
		error:function() { $("#div_asociado").show().html('<center>Error: El servidor no responde. <br>Por favor intente mas tarde. </center>'); }
		});		

	}
	
	function ver_almacenes()
	{
		$("#datos2").hide();
		$("#almacenes1").show();		
	}
	
	function coloca_proveedor1(i,p)
	{
		$("#txt_idasociado1").attr("value",i);
		$("#hdn_asociado1b").attr("value",p);	
		//alert(i+'\n'+p);                  div_asociados2
		$("#datos2").show();
		cerrar('div_asociados2');
	}
	
	
	
	function crear_movimiento()
	{
		var t=$("#txt_tipo_mov1").attr("value");
		var f=$("#txt_fecha1").attr("value");
		var al=$("#txt_idalmacen1").attr("value");
		var r=$("#txt_referencia1").attr("value");
		var as=$("#txt_idasociado1").attr("value");
		var o=$("#txt_obs1").attr("value");
		//alert(t+'\n'+f+'\n'+al+'\n'+r+'\n'+as+'\n'+o);
		if (t==""||t=="undefined") return;
		if (f==""||f=="undefined") return;
		if (al==""||al=="undefined") return;
		if (as==""||as=="undefined") return;
		
			if (r==""||r=="undefined"||r==null) r="";
			if (o==""||o=="undefined"||o==null) o="";
		
		if (confirm("¿Desea iniciar El Movimiento?"))
		{
			$("#datos2").css("height","200px");
			$.ajax({
			async:true,
			type: "POST",
			dataType: "html",
			contentType: "application/x-www-form-urlencoded",
			url:"movimientos.php",
			data:"accion=crear_movimiento&t="+t+"&f="+f+"&al="+al+"&r="+r+"&as="+as+"&o="+o,
			beforeSend:function(){ 
				$("#div_movimiento").show().html('<center><br><img src="../img/loading2.gif"><br>Procesando informacion, espere un momento.</center>'); 
			},
			success:function(datos){ 
				$("#div_movimiento").show().html(datos); 
				$("#div_botones1").hide();
				$(".btn1").hide();
			},
			timeout:90000000,
			error:function() { $("#div_movimiento").show().html('<center>Error: El servidor no responde. <br>Por favor intente mas tarde. </center>'); }
			});	
		}	
	}
	
	function validarSiNumero(numero){
		if (!/^([0-9])*$/.test(numero))
		{
			alert("El valor de la OC (" + numero + ") no es un numero");
			return false;
		} else {
			return true;
		}	
	}	
	
	function elegir_producto1(n)
	{
		//alert("Elegir Producto y colocar en la fila "+n);
		/*var ndm=$("#hdn_ndm1").attr("value"); 			// Numero de Movimiento*/
		var tdm=$("#txt_tipo_mov1").attr("value");		// Tipo de Movimiento
		var cdm=$("#hdn_concepto1").attr("value");		// Tipo de Movimiento
		
		var alm=$("#txt_idalmacen1").attr("value");		// Almacen Operado en el Movimiento
		var aso=$("#hdn_asociado1").attr("value");	// Asociado al Movimiento
		var ias=$("#txt_idasociado1").attr("value");	// ID Asociado al Movimiento

		$("#datos2").hide();
		$("#div_items_movs1").hide();

		$.ajax({
		async:true,
		type: "POST",
		dataType: "html",
		contentType: "application/x-www-form-urlencoded",
		url:"movimientos.php",
		data:"accion=mostrar_productos&tdm="+tdm+"&alm="+alm+"&aso="+aso+"&ias="+ias+"&n="+n+"&cdm="+cdm,
		beforeSend:function(){ 
			$("#div_productos").show().html('<center><br><img src="../img/loading2.gif"><br>Procesando informacion, espere un momento.</center>'); 
		},
		success:function(datos){ 
			$("#div_productos").show().html(datos); 
		},
		timeout:90000000,
		error:function() { $("#div_productos").show().html('<center>Error: El servidor no responde. <br>Por favor intente mas tarde. </center>'); }
		});			
	}	
	
	function coloca_producto1(i,c,d,e,cp,n)
	{
		$("#datos2").show();
		$("#div_items_movs1").show();
				
		$("#idp"+n).attr("value",i);
		$("#clave"+n).attr("value",c);
		$("#ds"+n).attr("value",d);
		$("#es"+n).attr("value",e);
		//$("#cu"+n).attr("value",cp);
		
		cerrar('div_proveedores1');
		$("#div_items_movs1").show();
		$("#chk_"+n).attr('checked','checked');
	}
	
	function guarda_producto()
	{
			var claves2="";
			for (var i=0;i<document.frm1.elements.length;i++)
			{
				if (document.frm1.elements[i].type=="checkbox")
				{
					if (document.frm1.elements[i].checked)
					{
						//alert("Variable claves=["+claves+"]");
						if (claves2=="")
							claves2=claves2+document.frm1.elements[i].value;
						else
							claves2=claves2+","+document.frm1.elements[i].value;
					}	
				}
			}
			if (claves2==""||claves2=='undefined') return;
			//alert("Agregar: "+claves2);	
			var cs=claves2.split(",");
			var valoresX="";
			for (var i=0;i<cs.length;i++)
			{
				if (cs[i]!=="undefined")
				{
					
					var can=$("#ca"+cs[i]).attr("value");
					var idp=$("#idp"+cs[i]).attr("value");
					var cla=$("#clave"+cs[i]).attr("value");
					var cun=$("#cu"+cs[i]).attr("value");
					var existen=can;
					//alert("FILA: "+cs[i]+"\tCANTIDAD="+can+"\tID PRODUCTO="+idp+"\tCLAVE PRODUCTO="+cla+"\tCOSTO UNITARIO="+cun);
					if (can==""||can=="undefined"||idp==""||idp=="undefined"||cla==""||cla=="undefined"||cun==""||cun=="undefined")
					{
						alert("Error: No omita campos en las filas seleccionadas (Todos los campos son obligatorios).");
						return;
						
					} else {
						valoresX+=idp+"?"+can+"?"+existen+"?"+cla+"?"+cun+",";
					}
					//alert("VALORES ALMACENADOS="+valoresX);	
				}	
			}
			//alert("VALORES ALMACENADOS FINALES="+valoresX);
			
			
			var idm=$("#hdn_ndm1").attr("value");
			if (confirm("¿Desea guardar los productos en el movimiento: "+idm+"?"))
			{
				$.ajax({
				async:true,
				type: "POST",
				dataType: "html",
				contentType: "application/x-www-form-urlencoded",
				url:"movimientos.php",
				data:"accion=insertar_productos&idm="+idm+"&valores="+valoresX,
				beforeSend:function(){ 
					$("#div_productos_insertados").show().html('<center><br><img src="../img/loading2.gif"><br>Procesando informacion, espere un momento.</center>'); 
				},
				success:function(datos){ 
					$("#div_productos_insertados").show().html(datos); 
					document.frm1.reset();
					$(".troc1").html("<td colspan='7' height='20' align='left'>&nbsp;&nbsp; Insertado. </td>");
					$(".troc1").hide();
				},
				timeout:90000000,
				error:function() { $("#div_productos_insertados").show().html('<center>Error: El servidor no responde. <br>Por favor intente mas tarde. </center>'); }
				});			
			}		
	}
</script>
<style type="text/css">
	body,document,all { font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px; margin:0px 0px 0px 0px;}
	a:link { text-decoration:none; }
	a:visited { text-decoration:none; }
	a:hover { text-decoration:none; }
	
	.mensaje1 { position:absolute; width:400px; height:300px; left:50%; top:50%; margin-left:-200px; margin-top:-150px; border:#000000 3px solid; z-index:10; background-color:#FFFFFF;}
	
	#titulo{ text-align:center; font-weight:bold; font-size:16px; margin:5px; display:none;}
	
	/* ESTILOS DE LOS TIPOS DE MOVS */
	/*#titulo{ text-align:center; font-weight:bold; font-size:14px; margin:5px;}*/
	
	#almacenes1{ display:none;}
	
	#opciones2{ position:relative; width:802px; height:180px; left:50%; margin-left:-401px; padding:0px; border:#000000 1px solid; }
	.tit1 { border-bottom:#000000 1px solid; margin-bottom:10px; background-color:#333333;}	
		.tit_mov { width:720px; font-size:15px; font-weight:bold; float:left; text-align:center; margin-top:2px; }
		.cer_mov  { font-size:12px; font-weight:bold; float:right; margin-top:3px;}
	.tituloA2 { width:160px; height:190px; margin-top:5px; font-size:16px; text-align:center; font-weight:bold; float:left; }
		.ncentrado{ position:relative; width:100px; height:24px; left:20px; top:50%; margin-top:-12px; margin-right:40px; font-size:18px;}
	.imagenA { top:20px;  margin-top:5px; margin-left:45px; clear:right; background-color:#FFFFFF; width:200px; float:left; text-align:center; font-size:24px;}

	.contenedor_entradas { position:relative; width:800px; height:150px; float:left; color:#006600; }
	.contenedor_salidas {  position:relative; width:800px; height:130px; float:left; color:#FF0000; }
	/* ESTILOS DE LOS TIPOS DE MOVS */	
	
	
	/*.div_contenido_interno{ background-color:#00FFFF; width:100%; height:395px; overflow:auto;}*/
	.botones { text-align:center; clear:both; margin:5px;}
	.btn1 { font-size:9px; width:25px; height:18px;}
	.btn2 { font-size:9px; width:25px; height:18px;}
	.mensajeX { margin:20px; font-size:16px; font-weight:bold; text-align:center;}
	#lbl_oc0{ display:none;}
	#txt_oc0{ display:none;}
	/* ESTILOS DE DATOS2 */
	#datos2{ position:relative; width:802px; height:250px; left:50%; margin-left:-401px; padding:0px; border:#000000 1px solid; display:none; }
		.etiqueta { width:193px; height:30px; background-color:#efefef; float:left; font-weight:bold; padding:2px 2px 2px 5px; font-size:14px;}
		.campo {    width:193px; height:30px; /*background-color:#efefcc;*/ float:left; font-weight:bold; padding:2px 2px 2px 5px; font-size:14px;}
	/* ESTILOS DE DATOS2 */

	/* ESTILOS DE DATOS2 */
	#almacenes1{ position:relative; width:802px; /*height:420px;*/ left:50%; margin-left:-401px; padding:0px; border:#000000 1px solid; }

	/* ESTILOS DE DATOS2 */	
	
	
	/* ESTILOS DE ASOCIADOS */
	#div_asociados2 { position:relative; width:802px; /*height:420px;*/ left:50%; margin-left:-401px; padding:0px; border:#000000 1px solid; }
	
	/* ESTILOS DE ASOCIADOS */
	
	/* ESTILOS DE ITEMS MOVIMEINTOS */
	#div_items_movs1 { position:relative; width:802px; /*height:420px;*/ left:50%; margin-left:-401px; padding:0px; border:#000000 1px solid; }
	
	/* ESTILOS DE ITEMS MOVIMEINTOS */
	
	/* ESTILOS DE PROVEEDORES */
	#div_proveedores1 { position:relative; width:802px; /*height:420px;*/ left:50%; margin-left:-401px; padding:0px; border:#000000 1px solid; }
	
	/* ESTILOS DE PROVEEDORES */
	
	/* ESTILOS DE PRODUCTOS EN EL MOVIMEINTO X */
	#div_pem1 { position:relative; width:802px; /*height:420px;*/ left:50%; margin-left:-401px; padding:0px; /*border:#000000 2px solid;*/ }
	#div_prod_ninguno1{ position:relative; width:802px; /*height:420px;*/ left:50%; margin-left:-401px; padding:0px; border:#000000 1px solid; }
	#acciones_proceso{  position:relative; width:802px; /*height:420px;*/ left:50%; margin-left:-401px; padding:0px; border:#000000 1px solid; }
	/* ESTILOS DE PRODUCTOS EN EL MOVIMEINTO X*/		
		
	
</style>
</head>

<body>
	<?php include("../menu/menu.php"); ?>
	<br />
	<div id="all">
		<div id="titulo">MOVIMIENTOS </div>
		<!--<div id="mensaje">&nbsp;</div>//-->
		<!--<div id="opciones">&nbsp;</div>//-->
		<div id="contenido">
			<form action="<?=$_SERVER['PHP_SELF'];?>?action=guardamov" method="post" name="frm" id="frm">
			
			<div id="opciones2">
				<div class="tit1">
					<span class="tit_mov">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;TIPOS DE MOVIMIENTOS&nbsp;</span>
					<span class="cer_mov"><a href="javascript:cerrar('opciones2');">CERRAR</a>&nbsp;</span>
				</div><br />
				<div class="contenedor_entradas">
					<?php 
					$sql_conceptos="SELECT * FROM concepmov ORDER BY id_concep";
					$result_conceptos=mysql_db_query($sql_inv,$sql_conceptos);
					while($row_conceptos=mysql_fetch_array($result_conceptos))
					{
						?>
						<div class="imagenA"><a href="javascript:coloca_tipo('<?= $row_conceptos["id_concep"] ?>','<?= $row_conceptos["asociado"]; ?>','<?= $row_conceptos["concepto"]; ?>','<?= $row_conceptos["tipo"]; ?>')"><img src="<?= $row_conceptos["imagen"]; ?>" border="0" /><br /><?= $row_conceptos["concepto"]; ?></a></div>
						<?php
					}				
					?>
				</div>
			</div>		
			
			<br />
			<div id="almacenes1">
				<div class="tit1">
					<span class="tit_mov">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ALMACENES&nbsp;</span>
					<span class="cer_mov"><a href="javascript:cerrar('almacenes1');">CERRAR</a>&nbsp;</span>
				</div>
				<br />
				<div class="div_contenido_interno">			
				<?php
				$color="#D9FFB3";
				$sql="SELECT * FROM tipoalmacen";
				$result=mysql_db_query($sql_inv,$sql);
				?>
				  <table width="100%" border="0" align="center" cellspacing="0">
					<tr style="background-color:#333333; text-align:center; font-weight:bold; color:#FFFFFF;">
					  <td colspan="2" height="23">Movimiento al Almac&eacute;n </td>
					</tr>
					<tr style="background-color:#cccccc; text-align:center; font-weight:bold; color:#000000;">
					  <td width="93">ID</td>
					  <td width="820">Almac&eacute;n</td>
					</tr>
					<? while($row=mysql_fetch_array($result)) { ?>
					<tr bgcolor="<?=$color?>" onmouseover="this.style.background='#cccccc';" onmouseout="this.style.background='<? echo $color; ?>'" onclick="javascript:coloca_almacen1('<?= $row["id_almacen"]; ?>','<?= $row["almacen"]; ?>');" style="cursor:pointer;">
					<td align="center" style="border-right:#CCCCCC 1px solid; text-align:center;" height="20"><?= $row["id_almacen"]; ?></td>
					<td>&nbsp;<?= $row["almacen"]?></td>
					</tr>
					<?
					($color=="#D9FFB3")? $color="#FFFFFF": $color="#D9FFB3";
					}
					?>
				  </table>
				</div>
			</div>
	
			<div id="datos2">
				<div class="tit1">
					<span class="tit_mov" id="tit_mov7">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;NUEVO MOVIMIENTO&nbsp;</span>
					
				</div><br />			
				
				
				<div class="n_mov2">
					<div class="etiqueta">Tipo de Movimiento</div>
					<div class="campo">
						<input name="txt_tipo_mov1" type="text" class="txt1" id="txt_tipo_mov1" readonly="1" />
						<input name="btn_tipo1" type="button" value="..." class="btn1" onclick="muestra_opciones()" />
						<input name="hdn_concepto1" type="hidden"  id="hdn_concepto1" />
						<input name="hdn_asociado1" type="hidden" id="hdn_asociado1" />
						<input name="hdn_tipo01" type="hidden" id="hdn_tipo1" />
					</div>
					
					
					<div class="etiqueta">Fecha</div>
					<div class="campo">
						<input name="txt_fecha1" type="text" class="txt1" id="txt_fecha1" value="<?=date('Y-m-d')?>" readonly="1" />
						<input name="btn_fecha1" type="button" value="..." class="btn1" />
						<script language="javascript">
							Calendar.setup({
								inputField     :    "txt_fecha1", // id del campo de texto
								ifFormat       :    "%Y-%m-%d", // formato de la fecha, cuando se escriba en el campo de texto
								button         :    "btn_fecha1" // el id del botón que lanzará el calendario
							});		
						</script>	
					</div>	
					
					<div class="etiqueta">Almac&eacute;n</div>
					<div class="campo">
						<input name="txt_idalmacen1" type="text" class="txt1" id="txt_idalmacen1" value="" readonly="1" />
						<input name="btn_almacen1" type="button" value="..." class="btn1" onclick="ver_almacenes()" />
						<input name="hdn_almacen1" type="hidden"  id="hdn_almacen1" />
					</div>
					
					
					<div class="etiqueta">Asociado</div>
					<div class="campo">
						<input name="txt_idasociado1" type="text" class="txt1" id="txt_idasociado1" value="" readonly="1" />
						<input name="btn_asociado1" type="button" value="..." class="btn1" onclick="ver_asociado()" />
						<input name="hdn_asociado1b" type="hidden"  id="hdn_asociado1b" value="" />
					</div>
					
					<div class="etiqueta">Referencia</div>
					<div class="campo">
						<input name="txt_referencia1" type="text" class="txt1" id="txt_referencia1" value="" />
					</div>	
					
					<div class="etiqueta">Observaciones</div>
					<div class="campo">
						<input name="txt_obs1" type="text" class="txt1" id="txt_obs1" value="" />
					</div>								
				
				</div>
	
				<div class="botones" id="div_botones1">
					<br />
					<input type="reset" value="Limpiar Datos" />
					<input type="button" value="Crear Movimiento" onclick="crear_movimiento()" />
				</div>
			</div>
			<br />		
			</form>
		</div>
		
		<div id="div_asociado">&nbsp;</div>
		<div id="div_movimiento">&nbsp;</div>
		<div id="div_productos">&nbsp;</div>
		<div id="div_productos_insertados">&nbsp;</div>
		<div id="div_productos_enel_mov">&nbsp;</div>
		<div id="div_productos_enel_mov">&nbsp;</div>
		<? include("../../f.php"); ?>
	</div>
</body>
</html>
