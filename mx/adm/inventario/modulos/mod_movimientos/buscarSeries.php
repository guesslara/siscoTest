<?php
print_r($_POST);
    if($_POST["action"]=="mostrarBusquedaSeries"){
        mostrarFormularioBusqueda();
    }else if($_POST["action"]=="buscarSerie"){
        buscarSerieAAsignar(limpiar($_POST["serie"]));
    }
    
    function buscarSerieAAsignar($serieABuscar){        
        //echo "<br>".$sql="SELECT * FROM num_series WHERE noParte='".$serieABuscar."' AND status='almacen'";
	echo "<br>".$sql="SELECT num_series.id, serie, num_series.noParte, clave_prod, mov, status , nombreCliente, almacenAsociado, control_alm
	FROM num_series INNER JOIN catprod ON num_series.clave_prod = catprod.id
	WHERE num_series.noParte = '".$serieABuscar."' AND STATUS = 'almacen'";
        $res=mysql_query($sql,conectarBd());
        if(mysql_num_rows($res)==0){
            echo "<br>( 0 ) registros encontrados.";
        }else{
?>
	    <form name="frmBusquedaSeries" id="frmBusquedaSeriesx">
	    <table border="0" cellpadding="1" cellspacing="1" width="99%" style="font-size: 12px;font-family: Verdana;">
                <tr>
		    <td style="background: #F0F0F0;border: 1px solid #CCC;">Serie a Buscar:</td>
		    <td colspan="5"><input type="text" name="" id="" style="font-size: 20px;"></td>
		</tr>
		<tr>
		    <td colspan="6" style="background: #CCC;">&nbsp;</td>
		</tr>
		<tr>
                    <td style="border: 1px solid #CCC;background: #CCC;">&nbsp;</td>
                    <td style="text-align: center;border: 1px solid #CCC;background: #CCC;">Serie</td>
                    <td style="text-align: center;border: 1px solid #CCC;background: #CCC;"># Parte</td>
                    <td style="text-align: center;border: 1px solid #CCC;background: #CCC;">Status</td>
                    <td style="text-align: center;border: 1px solid #CCC;background: #CCC;">Almac&eacute;n Asociado</td>
		    <td style="text-align: center;border: 1px solid #CCC;background: #CCC;">Control Almac&eacute;n</td>
                </tr>
<?
            while($row=mysql_fetch_array($res)){
                
?>
                <tr>
                    <td style="height: 15px;padding: 5px;border-bottom: 1px solid #CCC;text-align: center;"><input type="checkbox" name="" id="" style="height: 20px;padding: 5px;"></td>
                    <td style="height: 15px;padding: 5px;border-bottom: 1px solid #CCC;text-align: center;"><?=$row["serie"];?></td>
                    <td style="height: 15px;padding: 5px;border-bottom: 1px solid #CCC;text-align: center;"><?=$row["noParte"]?></td>
                    <td style="height: 15px;padding: 5px;border-bottom: 1px solid #CCC;text-align: center;"><?=$row["status"];?></td>
                    <td style="height: 15px;padding: 5px;border-bottom: 1px solid #CCC;text-align: center;"><?=$row["almacenAsociado"];?></td>
		    <td style="height: 15px;padding: 5px;border-bottom: 1px solid #CCC;text-align: center;"><?=$row["control_alm"];?></td>
                </tr>
<?
            }
?>
            </table></form>
<?
        }
    }
    
    function mostrarFormularioBusqueda(){
?>
        <script type="text/javascript"> $("#txtSerieBusqueda").focus(); </script>
        <br>
        <table border="1" cellpadding="1" cellspacing="1" width="600" align="center">
            <tr>
                <td style="text-align: center;">Buscar No. Parte:<input type="text" name="txtSerieBusqueda" id="txtSerieBusqueda" style="font-size: 20px;height: 20px;padding: 5px;width: 250px;" onkeyup="buscarSerieAAsignar(event)" /></td>
            </tr>
            <tr>
                <td><div id="resultadosSerieBusqueda"></div></td>
            </tr>
        </table>
<?
    }
    
    function conectarBd(){
	require("../../../../../includes/config.inc.php");
	$link=mysql_connect($host,$usuario,$pass);
	if($link==false){
	    echo "Error en la conexion a la base de datos";
	}else{
	    mysql_select_db($db);
	    return $link;
	}				
    }
    
    function limpiar($cadena){
        //$cadena=addcslashes($cadena,);
        $cadena=mysql_real_escape_string($cadena);
        return $cadena;
    }
?>