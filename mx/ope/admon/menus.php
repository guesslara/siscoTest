<?php
    if($_POST["action"]=="panelMenus"){
        include("../../../clases/clase_mysql.php");
        include("../../../includes/config.inc.php");
        $sql="SELECT * FROM cat_clientes";
        $mysql = new DB_mysql();
        $mysql->conectar($db,$host,$usuario,$pass);
        $mysql->consulta($sql);
        $res=$mysql->registrosConsulta();
?>
        <div style="height: 20px;padding: 5px;background: #f0f0f0;border:1px solid #CCC;">
            Cliente: <select name="cboClienteMenu" id="cboClienteMenu" onchange="verificaMenuCliente()">
                <option value="" selected="selected">Selecciona...</option>
<?
            while($row=mysql_fetch_array($res)){
?>
                <option value="<?=$row["id_cliente"];?>"><?=$row["r_social"];?></option>
<?
            }
?>
            </select>
        </div>
        <div style="border: 1px solid #FF0000;height: 94%;width: 99.8%;">            
            <div id="detalleMenu" style="height: 99.5%;border: 1px solid #FF0000;overflow: auto;"></div>            
            <!--<div id="detalleOperacionesMenu" style="float: left;width: 40%;height: 99%;border: 1px solid #CCC;margin-left: 10px;overflow: auto;"></div>-->
        </div>
<?
    }
?>
