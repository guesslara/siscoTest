<?php 
	session_start();
	/*
	if (!($_SESSION["usuario_nivel"]==7||$_SESSION["usuario_nivel"]==0||$_SESSION["usuario_nivel"]==1))
	{
		?><script language="javascript">history.back();</script><?php 
		exit();	
	}
	*/
	include ("../../conf/conectarbase.php");
	$numeroRegistros=0;
	$color=="#D9FFB3";
	
	if ($_GET)
	{
		if ($_GET["action"]=="eliminar_movimiento")
		{
			$id_eliminar=$_GET["id_mov"];
			// =====================================================================================================
			$sql_ultimo_id="SELECT max(id_mov) as ultimo FROM mov_almacen";
			$result_ultimo_id=mysql_db_query($sql_inv,$sql_ultimo_id);	
			while($row_ultimo_id=mysql_fetch_array($result_ultimo_id)){	
				$ultimo_id=$row_ultimo_id["ultimo"];
			}			
			echo "<br>El ultimo id es [$ultimo_id]";
			// =====================================================================================================
			echo $sql="DELETE FROM mov_almacen WHERE id_mov=".$id_eliminar." LIMIT 1";
			if (!mysql_db_query($sql_inv,$sql))
			{
				echo "<br>Error SQL ($sql): El movimiento ($id_eliminar) no se elimino.";
				exit();
			}			
			// =====================================================================================================
			if ($id_eliminar==$ultimo_id)
			{
				echo "<br>".$sql=$sql_regresar_indice="ALTER TABLE `mov_almacen`  AUTO_INCREMENT =$id_eliminar";
				if (!mysql_db_query($sql_inv,$sql_regresar_indice))
				{
					echo "<br>Error SQL ($sql): El movimiento ($id_eliminar) no se elimino.";
					exit();
				}
			}				
			// =====================================================================================================
		}	
		//echo "<br>La pagina es [".$_SERVER['PHP_SELF']."]";
		?>
		<script language="javascript">
			location.href="<?=$_SERVER['PHP_SELF']?>";
		</script>
		<?php
	}
	
	// =====================================================================================================
	if ($_POST)
	{
		if ($_POST["action"]=="listar_movimientos")
		{
			//print_r($_POST);
// ################################################################################################################			
			?>
			
			
<div id="movimientos">
<?php
		// sentencia SQL ...
		$campos_mov_almacen="mov_almacen.id_mov,mov_almacen.fecha,mov_almacen.tipo_mov,mov_almacen.almacen,mov_almacen.referencia,mov_almacen.asociado";
		$campos_concepmov="concepmov.id_concep,concepmov.concepto,concepmov.asociado,concepmov.tipo";
		$campos_tipoalmacen="tipoalmacen.id_almacen,tipoalmacen.almacen";
		
		$sql7="SELECT $campos_mov_almacen,$campos_concepmov,$campos_tipoalmacen FROM mov_almacen,concepmov,tipoalmacen 
		WHERE 
		mov_almacen.almacen=tipoalmacen.id_almacen AND mov_almacen.tipo_mov=concepmov.id_concep"; 
		$result=mysql_db_query($sql_inv,$sql7);  	
	?>
<table width="95%" border="0" align="center" cellspacing="0" class="tablax">
  <tr>
    <td colspan="6" height="23" style="background-color:#333333; text-align:center; color:#FFFFFF; font-weight:bold;"> MOVIMIENTOS VAC&Iacute;OS EN EL ALMAC&Eacute;N </td>
  </tr>
  <tr class="campos">
    <td height="20">ID</td>
    <td><a href="<?=$_SERVER["PHP_SELF"]?>?pagina=<?=$pagina?>&orden=concepmov.concepto,mov_almacen.fecha&cri=<?=$cri?>" title="Ordenar por Tipo Movimiento">Tipo Movimiento</a></td>
    <td>Almacen Operado.</td>
    <td>Asociado a: </td>
    <td><a href="<?=$_SERVER["PHP_SELF"]?>?pagina=<?=$pagina?>&orden=mov_almacen.referencia&cri=<?=$cri?>" title="Ordenar por Referencia">Referencia</a></td>
    <td><a href="<?=$_SERVER["PHP_SELF"]?>?pagina=<?=$pagina?>&orden=concepmov.concepto,mov_almacen.fecha&cri=<?=$cri?>" title="Ordenar por Fecha">Fecha</a></td>
  </tr>
<?
		while($row=mysql_fetch_array($result)){	
			$id_mov=$row[0];
			$tip_mov_id=$row["id_concep"];
			$tip_mov=$row["concepto"];
			$asoc=$row["asociado"];
			$aso2='';
	// =============================================================================================
			$sql_existe="SELECT id FROM prodxmov WHERE nummov='$id_mov'";
			$result_existe=mysql_db_query($sql_inv,$sql_existe);	
			$ndr_existe=mysql_num_rows($result_existe);
if ($ndr_existe==0)
{	
	++$numeroRegistros;
	// =============================================================================================
	$sql_aso="SELECT asociado FROM mov_almacen WHERE id_mov='$id_mov'";
	$result_aso=mysql_db_query($sql_inv,$sql_aso);	
	while($row_aso=mysql_fetch_array($result_aso)){	
		$id_aso=$row_aso["asociado"];
	}

	if ($asoc=='Almacenes')
	{
			$sql_aso2="SELECT almacen FROM `tipoalmacen` WHERE `id_almacen`='$id_aso'";
			$result_aso2=mysql_db_query($sql_inv,$sql_aso2);	
			while($row_aso2=mysql_fetch_array($result_aso2)){	
				$aso2=$row_aso2["almacen"];
			}
	}
	if ($asoc=='Proveedor'){
		$sql3="SELECT id_prov,nr FROM catprovee WHERE id_prov='$id_aso' ";
		$result3=mysql_db_query($dbcompras,$sql3);
		$row3=mysql_fetch_array($result3);
		$aso2=$row3["nr"];	
	}		
?>
  <tr bgcolor="<?=$color?>" onMouseOver="this.style.background='#cccccc';" onMouseOut="this.style.background='<?=$color; ?>'" style="font-size:11px; padding:1px; font-family:Verdana, Arial, Helvetica, sans-serif; text-align:left; cursor:pointer;" onClick="javascript:eliminar_movimiento(<?=$id_mov?>);">

    <td width="62" height="23" align="center" class="td1">&nbsp;<?=$id_mov?></td>
    <td width="217" class="td1">&nbsp;<?=$tip_mov; ?></td>
    <td width="283" class="td1"><?= $row["almacen"] ?></td>
    <td width="355" align="left" class="td1" style="padding:1px;">&nbsp;<? if ($aso2=='')	echo $row["asociado"]; else echo $aso2; ?></td>
    <td width="158" class="td1">&nbsp;<?=$row["referencia"]?></td>
    <td width="119" class="td1">&nbsp;<?= $row["fecha"]; ?></td>
  </tr>
  <?
  	($color=="#D9FFB3")? $color="#ffffff" : $color="#D9FFB3";
	}
}	 
  ?>
</table>
<p style="text-align:center; font-weight:bold; font-size:12px;"><?=$numeroRegistros?> Resultados</p>
</div>
<?php
// ################################################################################################################			
			exit();
		}
	}	
?>	
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title></title>
<script language="javascript" src="../../../../../clases/jquery.js"></script>
<script language="javascript">
	$(document).ready(listar_movimientos);
	// -----------------------------------------------------------------------------
	function listar_movimientos()
	{
		$.ajax({
			async:true,
   		 	type: "POST",
   		 	dataType: "html",
    		contentType: "application/x-www-form-urlencoded",
    		url:"<?=$_SERVER['PHP_SELF']?>",
    		data:"action=listar_movimientos",
    		beforeSend:function(){ $("#status2").show().html('&nbsp;<center><img src="../img/barra6.gif"><br>Cargando la p&aacute;gina, espere un momento.</center>'); },
    		success:function(datos){ $("#status2").show().html("&nbsp;"+datos); },
    		timeout:100000000,
    		error:function(){ $("#status2").html('Error: El servidor no responde.'); }
  		});		
	}	
	// -----------------------------------------------------------------------------
	function eliminar_movimiento(id_mov)
	{
		if (confirm("¿Desea eliminar el movimiento "+id_mov+"?"))
		{
			//alert("Movimiento a eliminar: "+id_mov);
			location.href="<?=$_SERVER['PHP_SELF']?>?action=eliminar_movimiento&id_mov="+id_mov;
		}
	}
	// -----------------------------------------------------------------------------
</script>
<link href="../../css/style.css" rel="stylesheet" type="text/css">
<style type="text/css">
body{ font-family:Verdana, Arial, Helvetica, sans-serif; font-size:14px; margin:0px 0px 0px 0px;}
#status{display:none; width:auto; background-color:#efefef; border:#333333 2px solid; overflow:auto; text-align:center; }
#seleccionar_movimiento{ display:none; width:auto; margin:5px 5px 5px 5px; padding:2px 2px 2px 2px; overflow:auto;}
#mover_productos{ width:auto; padding:10px; margin:5px 5px 5px 5px;}
	#mover_productos_0{ position:relative; width:400px;  float:left; margin:5px 5px 5px 5px; clear:left; overflow:auto;}
	#mover_productos_1{ position:relative; width:400px;  float:left; margin:5px 5px 5px 5px; clear:right; overflow:auto;}
	#flechas{ display:none;}
.td1{ border-right:#CCCCCC 1px solid; padding:1px; }
.tablax{ border:#333333 1px solid; }
#detalle{ position:absolute; display:none; border:#333333 3px solid; background-color:#ffffff; 
width:800px; height:500px; left:50%; top:50%; margin-left:-400px; margin-top:-250px; z-index:3;}
#d_tit{width:710px; height:20px; float:left; background-color:#333333; color:#FFFFFF;}
#d_cer{width:90px; height:20px; float:right; text-align:right; background-color:#333333;}
#d_con{ clear:both; margin:2px; margin-top:3px; padding:2px; height:470px; /*border:#333333 1px solid;*/ overflow:auto;}

.tdx{ background-color:#CCCCCC; font-weight:bold; text-align:left; padding-left:2px;}
.tex{ height:20px; font-size:12px; text-align:left; padding-left:5px; font-weight:normal; font-family:Verdana, Arial, Helvetica, sans-serif; width:300px; 
background-color:#FFFFFF; border:#CCCCCC 1px solid; padding:1px 1px 1px 1px; cursor:pointer;}
</style>
</head>

<body>
<?php include("../menu/menu.php"); ?>
<p>&nbsp;</p>
<div id="status2">&nbsp;</div>
</body>
</html>
