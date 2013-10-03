<?php
	session_start();	
	/*echo "<pre>";
	print_r($_SESSION);
	echo "</pre>";*/
	if($_SESSION[$txtApp['session']['nivelUsuario']]!=0){
		echo "<script type='text/javascript'> alert('Ha intentado entrar a una zona protegida, sus datos seran ENVIADOS'); </script>";
		//falta la opcion para poder mandar un email con la especificacion de la infiltracion
	}
?>
<script type="text/javascript" src="../../../../../clases/jquery.js" ></script>
<script type="text/javascript"  src="js/funciones.js" ></script>
<script type="text/javascript">
	$(document).ready(function(){
		redimensionarAdmin();
	});
	function redimensionarAdmin(){
		anchoDoc=$("#contenedorAdmin").width();
		anchoDoc=parseInt(anchoDoc)-270;
		$("#detalleUsuarios").css("width",anchoDoc);
		//document.getElementById("detalleUsuarios").style.width=anchoDoc+"px";
	}
	window.onresize=redimensionarAdmin;
</script>


	<FORM id="form1" name="form1" action="<?php $_SERVER['PHP_SELF']; ?>" method="post" style="margin:0px;">
<table width=40% height=90% align="center" style="border:#333333 2px solid; background-color:#fefefe; font-size:11px; font-family:Verdana, Arial, Helvetica, sans-serif;" cellspacing="0">
  <tr>
    <td colspan="4" class="t0" height="20">Datos del Producto o Servicio</td>
  </tr>
  <tr>
    <td height="44" colspan="4" style="text-align:center; font-size:14px; padding:2px;">&nbsp;
<LABEL><INPUT onclick=habilita(1) type=radio CHECKED value=1 name=tipo> Producto </LABEL>
<LABEL><INPUT onclick=habilita(2) type=radio value=2 name=tipo disabled="disabled"> Servicio </LABEL>
<LABEL><INPUT onclick=habilita(3) type=radio value=3 name=tipo disabled="disabled"> Kit de productos </LABEL></td>
  </tr>
  <tr>
    <td width="150">Clave del Producto</td>
    <td colspan="3">
	  	<input id=id_prod size=40 name=id_prod readonly="1" value="automatico" style="text-align:center; background-color:#FFFFCC;" />
    </td>
  </tr>
  <tr>
    <td class="etiqueta">Descripci&oacute;n</td>
    <td colspan="3">
      <input id=descripgral size=40 name=descripgral />
    *</td>
  </tr>
  <tr>
    <td class="etiqueta">Especificaci&oacute;n</td>
    <td colspan="3">
      <input id=especificacion size=15 name=especificacion value=""/>* &nbsp;(Modelo,Matricula,otro)</td>
  </tr>
  <tr>
    <td class="etiqueta">Unidad</td>
    <td colspan="3">
      <select id=unidad name=unidad>
        <option value="">...</option>
        <?php 
		$sql_unidades="SELECT * FROM unidades ORDER BY id_unidad";
		$r_u=mysql_db_query($sql_inv,$sql_unidades);
		while ($row_u=mysql_fetch_array($r_u)){
			echo "<option value='".$row_u['prefijo']."'>".$row_u['prefijo'].' - '.$row_u['unidad']."</option>";
		}
		?>
      </select>
    *</td>
  </tr>
  <tr>
    <td class="etiqueta">Control de Almacen </td>
    <td colspan="3">
      <input id=control_alm size=15 name=control_alm />
    *</td>
  </tr>
  <tr>
    <td class="etiqueta">L&iacute;nea de Producto </td>
    <td colspan="3">
      <select id="linea" name="linea">
        <option value="">...</option>
        <?php 
		$sql_lineas="SELECT * FROM lineas ORDER BY linea";
		$r_l=mysql_db_query($sql_inv,$sql_lineas);
		while ($row_l=mysql_fetch_array($r_l)){
			echo "<option value='".$row_l['linea']."'>".$row_l['linea'].' - '.$row_l['descripcion']."</option>";
		}
		?>
      </select>
    *</td>
  </tr>
  <tr>
    <td class="etiqueta" id="div_ubicacion0">Ubicaci&oacute;n</td>
    <td colspan="3" id="div_ubicacion1">
      <input id=ubicacion size=15 name=ubicacion value="" />
    *</td>
    </tr>
  <tr>
    <td class="etiqueta">Marca</td>
    <td width="150">
      <input size=15 name=marca value="LEXMARK" />
        </td>
    <td width="150">&nbsp;</td>
    <td width="150">&nbsp;</td>
  </tr>
  <tr>
    <td height="39" colspan="2" class="cn" valign="bottom">Unidades de: </td>
    <td colspan="2" class="cn" valign="bottom" id="stock0">Stock:</td>
  </tr>
  <tr>
    <td class="dn">Entrada</td>
    <td><input type="text" id=uni_entrada  size=10 name=uni_entrada value="" />*</td>
	<td class="dn" id="stock1">M&iacute;nimo</td>  
    <td id="stock2"><input id=stock_min  size=10 name=stock_min value="" />*</td>
  </tr>
  <tr>
    <td class="dn">Salida</td>
    <td><input id=uni_salida name=uni_salida size=10 value="" />*</td>
    <td class="dn" id="stock3">M&aacute;ximo</td>
    <td id="stock4"><input id=stock_max  size=10 name=stock_max value="" />*</td>
  </tr>
  <tr>
    <td colspan="4">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4" class="cn">Almacenes Asociados: <br />
		<div style="text-align:left; padding:2px; height:100px; overflow-y:scroll; margin:20px; border:#CCCCCC 2px solid; ">
		<?php 
		$sql="Select * from tipoalmacen";
		$resultado=mysql_db_query($sql_inv,$sql);
		while($fila=mysql_fetch_array($resultado)){
		echo "<input name='a_".$fila['id_almacen']."_".$fila['almacen']."' type=\"checkbox\" value=\"1\" />a_".$fila['id_almacen']."_".$fila['almacen']."<br>";
		} ?>
	</div></td>
  </tr>
  <tr>
    <td colspan="2" align="center">&nbsp;
		<!--
		<div id="kit">
		Kit de Productos <a href="javascript:agregar_kit();">+++</a><br />
		<textarea name="kit_array" id="kit_array" rows="4" cols="25" readonly="readonly"></textarea>
		</div>
		//-->
						</td>
    <td colspan="2" align="center" style="font-weight:bold;">
	Observaciones<br />
      <textarea id="observa" name="observa" rows="4" cols="25"></textarea>    </td>
  </tr>
  <tr>
    <td colspan="4" align="right" style="text-align:right; font-size:10px; color:#666666; padding-right:2px;">&nbsp;Los campos con * son obligatorios</td>
  </tr>
  <tr>
    <td height="44" colspan="4" align="center">&nbsp;
	<INPUT class=boton type=reset value=Limpiar>&nbsp;
	<INPUT class=boton  type=submit value=Modificar  >	</td>
  </tr>
</table>
</FORM>

	
	
</div>
<!--<div id="cargando" style=" display:none;position: absolute; left: 0; top: 0; width: 100%; height: 100%; background: url(../../img/desv.png) repeat;">
	<div id="msgCargador"><div style="padding:6px;">&nbsp;<img src="../../img/cargador.gif" border="0" /></div></div>
</div>-->