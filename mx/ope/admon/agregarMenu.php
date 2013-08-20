<?php
    if($_POST["action"]=="nuevaFuncionForm"){
        nuevoMenuForm($_POST["idCliente"]);
    }else{
        echo "Accion incorrecta";
        exit;
    }
    
    function nuevoMenuForm($idCliente){
        include("../../../clases/clase_mysql.php");
        include("../../../includes/config.inc.php");
        $sql="SELECT * FROM cat_clientes";
        $mysql = new DB_mysql();
        $mysql->conectar($db,$host,$usuario,$pass);
        $mysql->consulta($sql);
        $res=$mysql->registrosConsulta();
?>
	<input type="hidden" name="hdnClienteMenu" id="hdnClienteMenu" value="<?=$idCliente;?>">
	<div style="padding:10px;">           
            <form method="get">			
		<div id="datosProceso" style="display:block; margin:5px;">
		    <table width="400" border="0" cellspacing="1" cellpadding="1" align="center" style="font-size:12px; border:0px solid #666;">                        
			<tr>
                            <td width="156" class="bordesTitulos" style="height:25px;">Nombre del Men&uacute;</td>
                            <td width="350" class="bordesContenido" style="height:25px;"><input type="text" name="txtModulo" id="txtModulo" style="width:200px; font-size:14px;" /></td>
			</tr>			
			<tr>
                            <td width="156" class="bordesTitulos" style="height:25px;">No. Men&uacute;</td>
                            <td width="350" class="bordesContenido" style="height:25px;"><input type="text" name="txtMenu" id="txtMenu" style="width:200px; font-size:14px;" /></td>
			</tr>
                        <!--<tr>
                            <td width="156" class="bordesTitulos" style="height:25px;">Cliente</td>
                            <td width="350" class="bordesContenido" style="height:25px;">
                                <select name="cboCliente" id="cboCliente">
                                    <option value="">Selecciona...</option>
<?
                                while($row=mysql_fetch_array($res)){
?>
                                    <option value="<?=$row["id_cliente"];?>"><?=$row["r_social"];?></option>
<?
                                }
?>
                                </select>
                            </td>
                        </tr>-->
			<tr>
                            <td colspan="2"><div id="listadoimagen" style=" display:none;height:250px; overflow:auto; border:1px solid #CCC;"></div></td>
			</tr>                     
			<tr>
                            <td colspan="2"><hr style="background: #CCC;"</td>
			</tr>
			<tr>
                            <td colspan="2" style="height:25px;" align="right">&nbsp;<input type="button" value="Guardar Informaci&oacute;n" onclick="guardaFuncion()" /><input type="reset"  value="Cancelar" class="elementosForm"  ></td>            
			</tr>  
                    </table>
		</div>
            </form>
        </div>
<?        
    }
?>