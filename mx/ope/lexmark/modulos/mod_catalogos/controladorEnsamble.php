<?php
include("cat_diagnosticos2.php");
include("cat_fallas_tecnicas2.php");
include("cat_pruebas_esteticas2.php");
include("cat_pruebas_funcionales2.php");
include("cat_refacciones2.php");
include("cat_reparaciones2.php");
//include ("../../conf/conectarbase.php");

        
        switch($_POST['action']){
            case "buscar":
                    $busc=$_POST["part"];
                    $idd=$_POST["idd"];
                    
                    buscar($busc,$idd);
		break;
            
        }
        
        function buscar($busc,$idd){
            include ("../../conf/conectarbase.php");
            
		  $sql1="SELECT id,noParte,descripgral,familia FROM catprod WHERE noParte='".$busc."'";
                
		if ($resultado1=mysql_query($sql1,$link)){
                    
			$ndr1=mysql_num_rows($resultado1);
		} else {
			echo "<div align=center>Error SQL. La consulta a la Base de Datos no se ejecuto.</div>";
			exit();
		}
		?>
               
		<form name="frm2">	
		<br /><table align="center" width="739" style="font-weight:bold; font-size:12px;">
			<tr>
			  <td colspan="5" align="center">El diagn&oacute;stico
                          <input type="hidden" id="txt_idd" value="<?=$idd?>" />  aplica a los productos seleccionados. </td>
		  </tr>
			<tr>
			  <td>&nbsp;</td>
			  <td>Id</td>
			  <td>No. Parte </td>
			  <td>Descripci&oacute;n</td>
			  <td>Familia</td>
		  </tr>
			<?php $col="#FFFFFF";	while($registro1=mysql_fetch_array($resultado1)){?>
			<tr style="font-weight:normal;">
			  <td width="37"><input type="checkbox" value="<?=$registro1["id"]?>" /></td>
			  <td width="26"><?=$registro1["id"]?></td>
			  <td width="118"><?=$registro1["noParte"]?></td>
			  <td width="381"><?=$registro1["descripgral"]?></td>
			  <td width="153"><?=$registro1["familia"]?></td>
		  </tr>
		  	<?php ($col=="#FFFFFF")? $col="#EFEFEF" : $col="#FFFFFF"; }	mysql_free_result($resultado1); ?>  
		</table>
		<br /><div id="aceptar" align="center"><input type="button" value="Aceptar" onclick="coloca_productos2(<?=$idd?>)" /></div><br />
		</form>
                
		<?php
	        }
?>