<?
function conectarBd(){
	require("../../../includes/config.inc.php");
	$link=mysql_connect($host,$usuario,$pass);
	if($link==false){
		echo "Error en la conexion a la base de datos";
	}else{
		mysql_select_db($db);
		return $link;
	}				
}
//print_r($_POST);
$idL=$_POST['idLote'];
include("../../mod_formatos/nuevo$idL.php");	
?><input type="hidden" id="idLote" name="idLote" value="<?=$idL;?>"/><?
$paginasT=$_POST['totalpag'];
$intervalo=$_POST['intervalo'];
$pagAct=$_POST['pagAct'];
$pag=12;//pag es el limite de registros
$lim=$pag+$intervalo;
if($intervalo==0){
	?><script>
		$("#ant").hide();
	</script><?
}
if($paginasT==$pagAct){
	?><script>
		$("#sig").hide();
	</script><?
}
if($paginasT==0 && $intervalo==0){
	$CON="SELECT * FROM detalle_lotes WHERE id_lote='".$idLote."' and status='Empaque' or  status='SCRAP'";
	$exeCon=mysql_query($CON,conectarBd());
	$noReg=mysql_num_rows($exeCon);
	//echo"noreg=$noReg";
	if($noReg>$pag){
		$paginasT=$noReg/$pag;
		if(is_int($paginasT)){}else{$paginasT=intval($paginasT+1);}
		//echo"$paginasT";
		?>
		<input type="hidden" id="pagAct" name="pagAct" value="<?=$pagAct;?>"/>
		<input type="hidden" id="limite" name="limite" value="<?=$lim;?>"/>
		<input type="hidden" id="tp" name="tp" value="<?=$paginasT;?>"/>
		<script>
			$("#paginador").show();
			$("#PAct").html("<?=$pagAct;?>");
			$("#TotPa").html("<?=$paginasT;?>")
		</script><?
		$CON="SELECT * FROM detalle_lotes WHERE id_lote='".$idLote."' and status='Empaque' or  status='SCRAP' limit 0,12";
		$exeCon=mysql_query($CON,conectarBd());
	}else{
		?><script>
			$("#PAct").html("1");
			$("#TotPa").html("1")
		</script><?
	}
}else{
	$CON="SELECT * FROM detalle_lotes WHERE id_lote='".$idLote."' and status='Empaque' or  status='SCRAP' limit ".$intervalo.",12";
	$exeCon=mysql_query($CON,conectarBd());
	$noReg=mysql_num_rows($exeCon);
	?>
	<input type="hidden" id="pagAct" name="pagAct" value="<?=$pagAct;?>"/>
	<input type="hidden" id="limite" name="limite" value="<?=$lim;?>"/>
	<input type="hidden" id="tp" name="tp" value="<?=$paginasT;?>"/>
	<script>
		//$("#paginador").show();
		$("#PAct").html("<?=$pagAct;?>");
		//$("#TotPa").html("<?=$paginasT;?>")
	</script><?
}
$conL="SELECT * FROM lote where id_lote='".$idLote."'";
$exeL=mysql_query($conL,conectarBd());
$roL=mysql_fetch_array($exeL);
$i=($intervalo)+1;
?>
<div id="cont" style="height:100%;width:100%">
	<input type="hidden" id="limreg" name="limreg" value="<?=$pag;?>"/>
<?
	if($noReg==0){
		echo"<p style='text-align:center;text-width:bold;'>Actualmente no hay registros</p>";
	}else{
?>
		<div id="tablaIz" style="width:100%;float:left; height:90%;background:#fff; border:0px solid #000;padding:0px;margin:20px auto 5px 0px;">
			<table class="tab">
				<tr id="encabezado">
					<th style="width:40px;">ITEM</th>
					<th style="width:40px;">NO.</th>
					<th style="width:80px;">FECHA DE INGRESO</th>
					<th style="width:90px;">N&Uacute;MERO DE PARTE</th>
					<th style="width:90px;">N&Uacute;MERO DE SERIE</th>
					<th style="width:150px;">OBSERVACIONES</th>
					<th style="width:90px;">TARIMA</th>
				</tr>
<?
				while($rowDe=mysql_fetch_array($exeCon)){
					$Condes="SELECT * from CAT_SENC where id_SENC='".$rowDe['id_Senc']."'";
	  			    $exeSEN=mysql_query($Condes,conectarBd());
				    $rowSENC=mysql_fetch_array($exeSEN);
				    $desc=utf8_encode($rowSENC['descripcion']);
				    $noParte=$rowSENC[2];
					if($rowDe['observaciones']==""){
					    $al="center";
						$obs="--";
					}else{
					    $al="justify";
					    $obs=$rowDe['observaciones'];
					}
?>
				 	<tr>
				 		<td><?=$rowDe['id_item']?></td>
					   	<td><?=$i?></td>
					   	<td><?=$roL["fecha_reg"]?></td>
					   	<td><?=$noParte?></td>
					   	<td><?=$rowDe['numSerie']?></td>
					   	<td class="desc"><?=$obs?></td>
					   	<td>tarima</td>
					</tr>
<?			
				$i++;
			}
				for($v=$i;$v<=$lim;$v++){
?>
				    	<tr>
				    		<td>&nbsp;</td>
				    		<td>&nbsp;</td>
				    		<td>&nbsp;</td>
				    		<td>&nbsp;</td>
				    		<td>&nbsp;</td>
				    		<td>&nbsp;</td>
				    	</tr>
<?
			    	
				}
?>
			</table>
		</div>
<?
	}
?>