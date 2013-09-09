<?php
print_r($_POST);
    if($_POST["action"]=="mostrarBusquedaSeries"){
        mostrarFormularioBusqueda();
    }else if($_POST["action"]=="buscarSerie"){
        buscarSerieAAsignar(limpiar($_POST["serie"]));
    }
    
    function buscarSerieAAsignar($serieABuscar){        
        echo "<br>".$sql="SELECT * FROM num_series WHERE serie='".$serieABuscar."' AND status='almacen'";
        $res=mysql_query($sql,conectarBd());
        if(mysql_num_rows($res)==0){
            echo "<br>( 0 ) registros encontrados.";
        }else{
?>
            <table border="1" cellpadding="1" cellspacing="1" width="90%">
                <tr>
                    <td><input type="checkbox" name="" id="" style="height: 20px;padding: 5px;"></td>
                    <td style="text-align: center;">Serie</td>
                    <td style="text-align: center;"># Parte</td>
                    <td style="text-align: center;">Status</td>
                    <td style="text-align: center;">Descripci&oacute;n / Especificaci&oacute;n</td>
                </tr>
<?
            while($row=mysql_fetch_array($res)){
                
?>
                <tr>
                    <td style="text-align: center;"><input type="checkbox" name="" id="" style="height: 20px;padding: 5px;"></td>
                    <td style="text-align: center;"><?=$row["serie"];?></td>
                    <td style="text-align: center;"><?=$row["noParte"]?></td>
                    <td style="text-align: center;"><?=$row["status"];?></td>
                    <td style="text-align: center;"></td>
                </tr>
<?
            }
?>
            </table>
<?
        }
    }
    
    function mostrarFormularioBusqueda(){
?>
        <script type="text/javascript"> $("#txtSerieBusqueda").focus(); </script>
        <br>
        <table border="1" cellpadding="1" cellspacing="1" width="600" align="center">
            <tr>
                <td style="text-align: center;">Buscar Serie:<input type="text" name="txtSerieBusqueda" id="txtSerieBusqueda" style="font-size: 20px;height: 20px;padding: 5px;width: 250px;" onkeyup="buscarSerieAAsignar(event)" /></td>
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