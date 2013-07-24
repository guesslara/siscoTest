<?php
error_reporting(E_ALL & ~E_NOTICE);
ini_set("display_errors", 1);
if(isset($_POST["ac"])){
	$a=$_POST["ac"];
	echo '<br>';	print_r($_POST);
	
	// ------------------------- F U N C I O N E S -------------------------
	function dame_resultados($im){
		$m_sql=Array();
		
		//echo '<br>';
		require("../../conf/conectarbase.php");
		/*$link=mysql_connect("localhost","root","m4tr1x");
		if(!$link){
			echo "Error de conexion";
			exit;
		}else{
			mysql_select_db("2012_Iqe_lex_inv");
		}*/
		echo "<br>".$sql="SELECT 
			mov_almacen.*,
			concepmov.id_concep, concepmov.concepto, concepmov.tipo  
		FROM mov_almacen,concepmov
		WHERE 
			mov_almacen.tipo_mov=concepmov.id_concep
			AND mov_almacen.id_mov=$im";
		if ($res=mysql_db_query($sql_inv,$sql,$link)){
			$ndr=mysql_num_rows($res);
			if($ndr>0){
				while($reg=mysql_fetch_array($res)){
					//echo '<br>';	print_r($reg);
					$a1=$reg["id_mov"];
					$a2=$reg["fecha"];
					$a3=$reg["fecha_real"];
					$a4=$reg["tipo_mov"];
					$a5=$reg["almacen"];
					$a6=$reg["referencia"];
					$a7=$reg["asociado"];
					$a8=$reg["oc"];
					$a9=$reg["observ"];
					$a10=$reg["concepto"];
					$a11=$reg["tipo"];
				}
			}else{ 	echo "<br>Sin resultados."; }
		} else {	echo "Error del Sistema (".mysql_error($link).").";	}
		?>
		<table align='center' border="1">
		<tr><td>id moviemiento</td><td><input type="text" value="<?=$a1?>" /></td><td>fecha</td><td><input type="text" value="<?=$a2?>" /></td></tr>
		<tr><td>fecha real</td><td><input type="text" value="<?=$a3?>" /></td><td>tipo movimiento</td><td>
			<input type="text" value="<?=$a4?>" />
			<input type="text" value="<?=$a10?>" />
			<input type="text" value="<?=$a11?>" />
		</td></tr>
		<tr><td>almacen</td><td><input type="text" value="<?=$a5?>" /></td><td>referencia</td><td><input type="text" value="<?=$a6?>" /></td></tr>	
		
		<tr><td>asociado</td><td><input type="text" value="<?=$a7?>" /></td><td>oc</td><td><input type="text" value="<?=$a8?>" /></td></tr>	
		<tr><td>obs</td><td colspan="3"><input type="text" value="<?=$a9?>" /></td></tr>	
		</table>
		<?php
		
		
		
		echo "<br>".$sql2="SELECT 
			prodxmov.*,
			catprod.descripgral,catprod.especificacion,catprod.exist_$a5,trans_$a5 
		FROM prodxmov,catprod 
		WHERE 
			prodxmov.id_prod=catprod.id
			AND prodxmov.nummov=$im
		
		";
		if ($res=mysql_db_query($sql_inv,$sql2,$link)){
			$ndr=mysql_num_rows($res);
			if($ndr>0){		
				?>
				<table align='center' border="1">
				<tr>
					<td>#</td>
					<td>idp</td>
					<td>clave</td>
					<td>descripcion</td>
					<td>especificacion</td>
					<td>existencias</td>
					<td>transferencias</td>
					<td>ubicacion</td>
					<td>cantidad</td>
					<td>existen</td>
					<td>$ CU</td>
					<td>subtotal</td>
					<td>SQL</td>
				</tr>
				<?php
					while($reg=mysql_fetch_array($res)){
						//echo '<br>';	print_r($reg);
						//if(!($a10=="Salida x Trasp"||$a10=="Entrada x Traspaso")){
							($a11=='Ent')? $simbolo='-':$simbolo='+';
							//if($reg["existen"]>=$reg["cantidad"]){
								$sql_update=" UPDATE catprod SET exist_$a5=exist_$a5$simbolo".$reg["cantidad"]." WHERE id=".$reg["id_prod"]." LIMIT 1; ";
								$sql_delete=" DELETE FROM prodxmov WHERE id=".$reg["id"]." LIMIT 1; ";
								array_push($m_sql,$sql_update); //$m_sql
								array_push($m_sql,$sql_delete);
							//}	
						//}	
						?>
						<tr>
							<td><input type="text" value="<?=$reg["id"]?>" class="txt2" /></td>
							<td><input type="text" value="<?=$reg["id_prod"]?>" class="txt2" /></td>
							<td><?=$reg["clave"]?></td>
							<td><?=$reg["descripgral"]?></td>
							<td><?=$reg["especificacion"]?></td>
							
							<td><?=$reg["exist_$a5"]?></td>
							<td><?=$reg["trans_$a5"]?></td>
							
							<td><input type="text" value="<?=$reg["ubicacion"]?>" class="txt2" /></td>
							<td><input type="text" value="<?=$reg["cantidad"]?>" class="txt2" /></td>
							<td><input type="text" value="<?=$reg["existen"]?>" class="txt2" /></td>
							<td><input type="text" value="<?=$reg["cu"]?>" class="txt2" /></td>
							<td><input type="text" value="subtotal" class="txt2" /></td>
							<td><?=$sql_update?><br /><?=$sql_delete?></td>
						</tr>						
						<?php	
					}					
				?>
				</table>
				<?php	
			}else{ 	echo "<br>Sin resultados."; }
		} else {	echo "Error del Sistema (".mysql_error($link).").";	}
					
		?>
		<br /><br /><div align="center">
		<textarea cols="100" rows="13">
			<? 
			foreach($m_sql as $sql3){
				echo "\n$sql3";
			} 
			?>
		</textarea>
		</div><br /><br />
		<?php		
	}
	// ------------------------------------------------------------------------------	
	if($a=="buscar_movimiento"){
		$im=$_POST["im"];
		//echo "<br>".$sql="SELECT * FROM mov_almacen WHERE id_mov=$im";
		$detalle_mov=dame_resultados($im);
		/*
		echo "<br>".$sql2="SELECT * FROM prodxmov WHERE nummov=$im";
		$detalle_mov=dame_resultados($sql2);
		*/
	}
	
	exit;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Deshacer Movimientos</title>
<script language="javascript" src="../../js/jquery.js"></script>
<script language="javascript">
function ajax(capa,datos,ocultar_capa){
	if (!(ocultar_capa==""||ocultar_capa==undefined||ocultar_capa==null)) { $("#"+ocultar_capa).hide(); }
	var url="<?=$_SERVER['PHP_SELF']?>";
	//alert("URL="+url+"\nCAPA="+capa+"\nDATOS="+datos);
	$.ajax({
		async:true,
		type: "POST",
		dataType: "html",
		contentType: "application/x-www-form-urlencoded",
		url:url,
		data:datos,
		beforeSend:function(){ 
			$("#"+capa).html('Procesando, espere un momento'); 
		},
		success:function(datos){ 
			$("#"+capa).show().html(datos);
		},
		timeout:90000000,
		error:function() { $("#"+capa).show().html('<center>Error: El servidor no responde. <br>Por favor intente mas tarde. </center>'); }
	});
}
function ocultar_capa(capa){	$("#"+capa).hide();		}
function mostrar_capa(capa){	$("#"+capa).show();		}
function ocultar_mostrar_capa(capa1,capa2){	
	//alert("OCULTAR="+capa1+","+"MOSTRAR="+capa2);	
	$("#"+capa1).hide();
	$("#"+capa2).show();
}
function limpiar_capa(capa){ $("#"+capa).html("&nbsp;"); }
function buscar(){
	var im=$("#txt_im").attr("value");
	if(!(im==""||im==undefined||im==null)){		ajax('a2','ac=buscar_movimiento&im='+im);	}
}
</script>
<style type="text/css">
body,input{ font-size:small; }
.txt2{ width:40px; text-align:center;}
.txt3{ width:40px; text-align:right;}
</style>
</head>

<body>
<div id="a">
	<div id="a1">No. Movimientos: <input type="text" id="txt_im" class="txt2" /> <a href="#" onClick="buscar()">buscar</a></div>
	<div id="a2"></div>
	<div id="a3"></div>
	<div id="a4"></div>
	<div id="a5"></div>
</div>

</body>
</html>
