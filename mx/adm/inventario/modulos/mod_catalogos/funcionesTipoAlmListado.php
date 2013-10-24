<?php
    include ("../../conf/conectarbase.php");
    if($_POST["action"]=="verClientes"){
        $idAlmacen=$_POST["idAlmacen"];
        $sql="select id_cliente,r_social from cat_clientes";
        $res=mysql_query($sql,$link);
        if(mysql_num_rows($res)==0){
            echo "No hay clientes capturados";
        }else{
?>
            Seleccionar Cliente
            <select name="cboClienteAsoc" id="cboClienteAsoc" style="height: 25px;padding: 5px;">
                <option value="">Seleccionar</option>
<?
            while($row=mysql_fetch_array($res)){
?>
                <option value="<?=$row["id_cliente"];?>"><?=$row["r_social"];?></option>
<?
            }
?>
            </select>&nbsp;&nbsp;
            <input type="button" value="Cancelar" onclick="cancelarAsociacion()">
            <input type="button" value="Asociar Cliente" onclick="asociarCliente('<?=$idAlmacen;?>')">
<?
        }
    }else if($_POST["action"]=="guardarAsoc"){
        $idAlmacen=$_POST["idAlmacen"];
        $idCliente=$_POST["idCliente"];
        $sql="INSERT INTO almacenCliente (id_almacen,id_cliente) VALUES ('".$idAlmacen."','".$idCliente."')";
        $res=mysql_query($sql,$link);
        if($res){
            echo "<br>Asociaci&oacute; exitosa";
            echo "<script type='text/javascript'> window.location.href='tipo_alm_listado.php'; </script>";
        }else{
            echo "<br>Error al Asociar el almacen con el cliente.";
        }
    }
?>