<?php 
	session_start();
	include("../../conf/validar_usuarios.php");
	validar_usuarios(0,1,2,3,11);	
	include ("../../conf/conectarbase.php");
	$sql="SELECT * FROM tipoalmacen";
	$result=mysql_query($sql,$link);
	$ndr=mysql_num_rows($result);
	$color="#ffffff";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<script type="text/javascript" src="../../../../../clases/jquery.js"></script>
<title></title>
<link href="../css/style.css" rel="stylesheet" type="text/css">
<script type="text/javascript">
	function ajaxApp(divDestino,url,parametros,metodo){	
		$.ajax({
		async:true,
		type: metodo,
		dataType: "html",
		contentType: "application/x-www-form-urlencoded",
		url:url,
		data:parametros,
		beforeSend:function(){ 
			$("#"+divDestino).show().html("<p>Cargando...</p>"); 
		},
		success:function(datos){	
			$("#"+divDestino).show().html(datos);
		},
		timeout:90000000,
		error:function() { $("#"+divDestino).show().html('<center>Error: El servidor no responde. <br>Por favor intente mas tarde. </center>'); }
		});
	}
	function agregarCliente(idAlmacen){
		ajaxApp("asociarCliente","funcionesTipoAlmListado.php","action=verClientes&idAlmacen="+idAlmacen,"POST");	
	}
	function asociarCliente(idAlmacen){
		//se recupera el cliente seleccionado
		idCliente=$("#cboClienteAsoc").val();
		if(idCliente=="" || idCliente==null || idCliente==undefined){
			alert("Error, debe seleccionar un cliente del listado para asociarlo");
		}else{
			ajaxApp("asociarCliente","funcionesTipoAlmListado.php","action=guardarAsoc&idAlmacen="+idAlmacen+"&idCliente="+idCliente,"POST");
		}
	}
	function cancelarAsociacion(){
		$("#asociarCliente").hide("slide");
	}
</script>
<style type="text/css">
	.estiloTituloCelda{height: 15px;padding: 5px;font-weight: bold;text-align: center;background: #F0F0F0;border: 1px solid #CCC;}
</style>
</head>
<body>
<br />
	<div id="asociarCliente" style="display: none;height: 50px;padding: 5px;border: 1px solid #CCC; background: #f0f0f0;width: 900px;margin: 0 auto;font-size: 12px;"></div>
	<table width="900" align="center" cellspacing="0" style="border: 1px solid #000; font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px;">
		<tr>
			<td colspan="5" class="estiloTituloCelda"><?=$ndr?> Almacenes</td>
		</tr>
		<tr>
			<td width="32" class="estiloTituloCelda">Id</td>
			<td width="200" class="estiloTituloCelda">Almac&eacute;n</td>
			<td width="150" class="estiloTituloCelda">Asociado con:</td>
			<td width="48" class="estiloTituloCelda">Status</td>
			<td width="200" class="estiloTituloCelda">Obsevaciones</td>
		</tr>
<?
	while($row=mysql_fetch_array($result)){
		//se extraen los asociados por almacen
		$sqlC="SELECT id, id_almacen, r_social FROM almacenCliente INNER JOIN cat_clientes ON almacenCliente.id_cliente = cat_clientes.id_cliente WHERE id_almacen = '".$row["id_almacen"]."'";
		$resC=mysql_query($sqlC,$link);
?>
		<tr bgcolor="<?=$color?>" onmouseover="this.style.background='#cccccc';" onmouseout="this.style.background='<? echo $color; ?>'">
			<td align="center" style=" border-right:#CCCCCC 1px solid;height: 15px;padding: 5px;"><?= $row["id_almacen"]; ?>      </td>
			<td style="border-right:1px solid #CCC;height: 15px;padding: 5px;">&nbsp;<?= $row["almacen"]; ?></td>
			<td style="border-right:1px solid #CCC;height: 15px;padding: 5px;">
				<div style="height: auto;border: 0px solid #CCC;width: 75%;float: left;">
<?
			while($rowC=mysql_fetch_array($resC)){
				echo "-".$rowC["r_social"]."<br>";
			}
?>
				</div>
				<div style="float: left;width: 18%;border: 0px solid #CCC;text-align: center;"><a href="#" onclick="agregarCliente('<?=$row["id_almacen"];?>')" style="text-decoration: none;">[ + ]</a></div>
			</td>
			<td style="border-right:1px solid #CCC;height: 15px;padding: 5px;text-align: center;"><? if($row["activo"]==1) echo "Activo"; else "Inactivo";?></td>
			<td><?= $row["observ"]; ?></td>
		</tr>
<?
  		($color=="#F0F0F0")? $color="#ffffff" : $color="#F0F0F0";
	}
?>
	</table>
<p>&nbsp;</p>
</body>
</html>