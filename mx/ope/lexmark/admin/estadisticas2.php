<?php 
	session_start();
	header("Cache-Control: no-store, no-cache, must-revalidate");
	header("Content-Type: text/xml; charset=ISO-8859-1");
	include ("../../conf/conectarbase.php");
	//print_r($_SESSION);
	
	//print_r($_POST);
	$a=$_POST["action"];

	if ($a=="listar"){
		
		// TOTAL DE OT'S.
		$sql1="SELECT id FROM ot";
		if ($resultado1=mysql_db_query($sql_ing,$sql1)){
			$ndr1=mysql_num_rows($resultado1);
		} else {
			echo "<div align=center>Error SQL. La consulta a la Base de Datos no se ejecuto.</div>";
			exit();
		}
		
		// TOTAL DE OT'S EN RECIBO.
		$sql2="SELECT id FROM ot WHERE status_cliente='REC'";
		if ($resultado2=mysql_db_query($sql_ing,$sql2)){
			$ndr2=mysql_num_rows($resultado2);
		} else {
			echo "<div align=center>Error SQL. La consulta a la Base de Datos no se ejecuto.</div>";
			exit();
		}
		
		// TOTAL DE OT'S EN REPARACION.
		$sql3="SELECT id FROM ot WHERE status_cliente='REP'";
		if ($resultado3=mysql_db_query($sql_ing,$sql3)){
			$ndr3=mysql_num_rows($resultado3);
		} else {
			echo "<div align=center>Error SQL. La consulta a la Base de Datos no se ejecuto.</div>";
			exit();
		}

		// TOTAL DE OT'S EN CALIDAD.
		$sql4="SELECT id FROM ot WHERE status_cliente='CC'";
		if ($resultado4=mysql_db_query($sql_ing,$sql4)){
			$ndr4=mysql_num_rows($resultado4);
		} else {
			echo "<div align=center>Error SQL. La consulta a la Base de Datos no se ejecuto.</div>";
			exit();
		}		

		// TOTAL DE OT'S EN DESPACHO.
		$sql5="SELECT id FROM ot WHERE status_cliente='DES'";
		if ($resultado5=mysql_db_query($sql_ing,$sql5)){
			$ndr5=mysql_num_rows($resultado5);
		} else {
			echo "<div align=center>Error SQL. La consulta a la Base de Datos no se ejecuto.</div>";
			exit();
		}
		
		// TOTAL DE OT'S ENVIADAS.
		$sql6="SELECT id FROM ot WHERE status_cliente='ENV'";
		if ($resultado6=mysql_db_query($sql_ing,$sql6)){
			$ndr6=mysql_num_rows($resultado6);
		} else {
			echo "<div align=center>Error SQL. La consulta a la Base de Datos no se ejecuto.</div>";
			exit();
		}		
		?>
		<form name="frm1">
       <br><table border="0" width="400" align="center" cellspacing="0" style="border:#000 1px solid;">
        <tr>
          <td colspan="3" height="20" style="text-align:center; font-weight:bold; background-color:#666; color:#FFF;">Distribuci&oacute;n General de las OT.</td>
          </tr>
        <tr style="text-align:center; font-weight:bold; background-color:#CCC; color:#000;">
          <td height="20">M&oacute;dulo</td>
          <td><a href="javascript:graficar_cantidad();" title="Graficar">Cantidad</a></td>
          <td><a href="javascript:graficar_porcentaje();" title="Graficar">Porc. (%)</a></td>
        </tr>
        <tr>
          <td><a href="javascript:ver_detalle('rec');" title="Ver detalle.">1. Recibo</a></td>
          <td align="right"><input type="text" id="1a" size="10" class="txt_numero" readonly="readonly" value="<?=$ndr2?>"></td>
          <td align="right"><input type="text" id="1b" size="10" class="txt_numero" readonly="readonly" value="<?=number_format($ndr2/$ndr1*100,2,'.',',')?>"></td>
        </tr>
        <tr>
          <td><a href="javascript:ver_detalle('rep');" title="Ver detalle.">2. Reparaci&oacute;n</a></td>
          <td align="right"><input type="text" id="2a" size="10" class="txt_numero" readonly="readonly" value="<?=$ndr3?>"></td>
          <td align="right"><input type="text" id="2b" size="10" class="txt_numero" readonly="readonly" value="<?=number_format($ndr3/$ndr1*100,2,'.',',')?>"></td>
        </tr>
        <tr>
          <td><a href="javascript:ver_detalle('cc');" title="Ver detalle.">3. Control de Calidad</a></td>
          <td align="right"><input type="text" id="3a" size="10" class="txt_numero" readonly="readonly" value="<?=$ndr4?>"></td>
          <td align="right"><input type="text" id="3b" size="10" class="txt_numero" readonly="readonly" value="<?=number_format($ndr4/$ndr1*100,2,'.',',')?>"></td>
        </tr>
        <tr>
          <td><a href="javascript:ver_detalle('des');" title="Ver detalle.">4. Despacho</a></td>
          <td align="right"><input type="text" id="4a" size="10" class="txt_numero" readonly="readonly" value="<?=$ndr5?>"></td>
          <td align="right"><input type="text" id="4b" size="10" class="txt_numero" readonly="readonly" value="<?=number_format($ndr5/$ndr1*100,2,'.',',')?>"></td>
        </tr>
        <tr>
          <td><a href="javascript:ver_detalle('env');" title="Ver detalle.">5. Enviados (Almac&eacute;n)</a></td>
          <td align="right"><input type="text" id="5a" size="10" class="txt_numero" readonly="readonly" value="<?=$ndr6?>"></td>
          <td align="right"><input type="text" id="5b" size="10" class="txt_numero" readonly="readonly" value="<?=number_format($ndr6/$ndr1*100,2,'.',',')?>"></td>
        </tr>
        <tr style="font-weight:bold;">
        	<td style="text-align:center;">Total</td>
            <td align="right"><input type="text" id="0a" size="10" class="txt_numero" readonly="readonly" value="<?=$ndr1?>"></td>
            <td align="right"><input type="text" id="0a" size="10" class="txt_numero" readonly="readonly" value="<?=number_format($ndr1/$ndr1*100,2,'.',',')?>"></td>
        </tr>
        </table>
        </form>
		<?php
	}
	if ($a=="ver_detalle"){
		$m=$_POST["m"];
		$modulos=array('rec'=>'RECIBO','rep'=>'REPARACION','cc'=>'CONTROL DE CALIDAD','des'=>'DESPACHO','env'=>'ENVIADOS');
		
		$sql1="SELECT id,status_proceso FROM ot WHERE status_cliente='$m' GROUP BY status_proceso ORDER BY status_proceso,id";
		if ($resultado1=mysql_db_query($sql_ing,$sql1)){
			$ndr1=mysql_num_rows($resultado1);
			if ($ndr1==0){ echo "<br><div align=center>Error: No se encontradron resultados.</div>"; exit(); }
			?>
            <form name="frm2">
            <br><table border="0" width="400" align="center" style="border:#000 1px solid;" cellspacing="0">
            <tr>
              <td colspan="2" style="text-align:center; font-weight:bold; background-color:#666; color:#FFF;">Detalle de las  OT ( 
              <?=$modulos[$m]?>).</td>
              </tr>
            <tr style="text-align:center; font-weight:bold; background-color:#CCC; color:#000;">
              <td width="285" height="20">Status</td>
              <td width="99">Cantidad</td>
              </tr>
            <?php 
				$color="#FFFFFF";
				while($registro1=mysql_fetch_array($resultado1)){ 
				$sp=$registro1["status_proceso"];
				$sql2="SELECT id FROM ot WHERE status_cliente='$m' AND status_proceso='$sp'";
				if ($resultado2=mysql_db_query($sql_ing,$sql2)){
					$ndr2=mysql_num_rows($resultado2);	
				}
				?>
            <tr bgcolor="<?=$color?>">
              <td>&nbsp;<?=$sp?></td>
              <td align="right"><input type="text" id="1a" size="10" class="txt_numero" readonly="readonly" value="<?=$ndr2?>"></td>
              </tr>
            <?php ($color=="#FFFFFF")? $color="#EFEFEF" : $color="#FFFFFF"; } ?>
            
            
            </table>
            </form>			
			<?php
			
			/*
			while($registro1=mysql_fetch_array($resultado1)){
				echo "<br>"; 	print_r($registro1);	
			}
			*/
		} else {
			echo "<div align=center>Error SQL. La consulta a la Base de Datos no se ejecuto.</div>";
			exit();
		}
	}
?>	