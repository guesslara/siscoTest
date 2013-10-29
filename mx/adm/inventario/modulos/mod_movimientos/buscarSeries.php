<?php
    session_start();
    //print_r($_SESSION);
    //include("../../../../../includes/txtAppAlmacen.php");
    //echo "<br>ID-USUARIO: ".$_SESSION[$txtApp['session']['idUsuario']];
          
    if($_POST["action"]=="mostrarBusquedaSeries"){
        mostrarFormularioBusqueda($_POST["noParte"],$_POST["cantidadAsig"]);
    }else if($_POST["action"]=="buscarSerie"){
        buscarSerieAAsignar(limpiar($_POST["serie"]),$_POST["noParte"]);
    }else if($_POST["action"]=="asignarSeries"){	
	asignarSeriesMovimiento($_POST["idSeries"]);
    }
    
    
    function asignarSeriesMovimiento($idSeries){
	if(isset($_SESSION[$txtApp['session']['idUsuario']])){
	    echo "Entre de nuevo al Sistema para verificar identidad"; exit();
	}else{
	    include("../../../../../includes/txtAppAlmacen.php");
	    $idSeries=explode(",",$idSeries);	
	    foreach($idSeries AS $idSerie){
		$sql="UPDATE num_series set status='asignado' where id='".$idSerie."'";
		$res=mysql_query($sql,conectarBd());
		if($res){
		    echo "<br>->Serie Actualizada";
		    //se actualiza el historial del numero de serie
		    $sql="INSERT INTO historial_numSeries (id_serie,fecha,hora,id_usuario,accion) VALUES ('".$idSerie."','".date("Y-m-d")."','".date("H:i:s")."','".$_SESSION[$txtApp['session']['idUsuario']]."','Asignacion de numero de Serie')";
		    $res=mysql_query($sql,conectarBd());
		    if($res){
			echo "<br>-->Detalle Guardado";
		    }else{
			echo "<br>-->Ocurrieron errores al guardar el detalle del numero de serie";
		    }
		}else{
		    echo "<br>->Error al actualizar el numero de Serie";
		}
	    }
	}
    }
    
    
    function buscarSerieAAsignar($serieABuscar,$noParte){        
        //echo "<br>".$sql="SELECT * FROM num_series WHERE noParte='".$serieABuscar."' AND status='almacen'";
	if($serieABuscar=="N/A"){
	    $sql="SELECT num_series.id, serie, num_series.noParte, clave_prod, mov, status , nombreCliente, almacenAsociado, control_alm,num_series.id AS idSerie
	    FROM num_series INNER JOIN catprod ON num_series.clave_prod = catprod.id
	    WHERE num_series.noParte = '".$noParte."' AND STATUS = 'almacen'";    
	}else{
	    $sql="SELECT num_series.id, serie, num_series.noParte, clave_prod, mov, status , nombreCliente, almacenAsociado, control_alm,num_series.id AS idSerie
	    FROM num_series INNER JOIN catprod ON num_series.clave_prod = catprod.id
	    WHERE num_series.noParte = '".$noParte."' AND num_series.serie='".$serieABuscar."' AND STATUS = 'almacen'"; 
	}
	
        
	$res=mysql_query($sql,conectarBd());
        if(mysql_num_rows($res)==0){
            echo "<br>( 0 ) registros encontrados.";
        }else{
?>
	    <form name="frmBusquedaSeriesAsignar" id="frmBusquedaSeriesAsignar">
	    <table border="0" cellpadding="1" cellspacing="1" width="99%" style="font-size: 12px;font-family: Verdana;">                
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
                    <td style="height: 15px;padding: 5px;border-bottom: 1px solid #CCC;text-align: center;"><input type="checkbox" value="<?=$row["idSerie"];?>" name="" id="" style="height: 20px;padding: 5px;"></td>
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
    
    function mostrarFormularioBusqueda($noParte,$cantidadAsig){
?>
        <script type="text/javascript">
	    $("#txtSerieBusqueda").focus();	    
	</script>
        <br>
        <table border="0" cellpadding="1" cellspacing="1" width="600" align="center">
            <tr>
                <td style="text-align: center;">Buscar Serie:<input type="text" name="txtSerieBusqueda" id="txtSerieBusqueda" style="font-size: 20px;height: 20px;padding: 5px;width: 250px;" onkeyup="buscarSerieAAsignar(event)" /></td>
            </tr>
            <tr>
                <td><div id="resultadosSerieBusqueda"></div></td>
            </tr>
        </table>
	<input type="hidden" name="hdnNoParteSel" id="hdnNoParteSel" value="<?=$noParte?>">
	<input type="hidden" name="hdnCantidadAsignar" id="hdnCantidadAsignar" value="<?=$cantidadAsig;?>">
	<script type="text/javascript">
	    buscarSeriesNoParte('<?=$noParte;?>');	    
	</script>
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