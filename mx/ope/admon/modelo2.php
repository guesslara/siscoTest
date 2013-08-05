<?php
    /*
     *Clase para las modificaciones del menus de la aplicacion
     *
    */
    include("../../../clases/clase_mysql.php");
    
    class modeloUsuario{       
        
        private $linkConexion;
        private $objConexion;
        
        public function guardarFuncion($txtModulo,$txtPer,$txtMenu){
            include("../../../includes/config.inc.php");
            $mysql = new DB_mysql();
            $mysql->conectar($db,$host,$usuario,$pass);
            echo "<br>".$sqlGuarda="INSERT INTO menu (modulo,pertenece_a,numeroMenu) values('".$txtModulo."','".$txtPer."','".$txtMenu."')";
            
            
            /*$resultGuarda=mysql_query($sqlGuarda,$var);
            if($resultGuarda==true){
            	echo "<script type='text/javascript'> alert('Registro Agregado'); mostrarOpcionesMenu(); </script>";				
            }else{
            	echo "<script type='text/javascript' > alert('Error al Guardar.'); </script>";
            }*/
	}
                
        public function mostrarOpcionesMenu(){
            include("../../../includes/config.inc.php");
            $sql="Select * FROM menu WHERE activo=1 Order By orden";
            $mysql = new DB_mysql();
            $mysql->conectar($db,$host,$usuario,$pass);
            $res=$mysql->consulta($sql);                       
            $res=$mysql->registrosConsulta();
            
?>
	    <div style="height: 20px;padding: 5px;background: #f0f0f0;border:1px solid #CCC;"><a href="#" onclick="nuevaFuncionalidad()" style="text-decoration: none;color: blue;">Agregar Men&uacute;</a></div>
                <div style="border: 1px solid #000;height: 94%;width: 99%;margin: 3px;">
                    <div style="float: left;width: 47%;height: 99%;border: 1px solid #CCC;margin: 2px;overflow: auto;">
                        <table border="0" cellpadding="1" cellspacing="1" width="400" style="margin: 10px;font-size: 12px;">
                            <tr>
                                <td colspan="2" style="background: #000;color: #fff;height: 23px;padding: 5px;">Agregar Men&uacute; - Submen&uacute;</td>
                            </tr>
			    <tr>
                                <td width="350" style="border: 1px solid #CCC;background: #f0f0f0;height: 20px;padding: 5px;">Nombre</td>
                                <td width="50" style="border: 1px solid #CCC;background: #f0f0f0;height: 20px;padding: 5px;">Acci&oacute;n</td>				
                            </tr>
<?
	    $i=0;
	    while($row=mysql_fetch_array($res)){
		$nombreDiv="Submenu".$i;
		//se extraen los submenus si existen
		$sqlSub="SELECT * FROM submenu WHERE id_menu='".$row["id"]."' AND activo='1'";
		//$resSub=mysql_query($sqlSub,$this->conexion);
                $resSub=$mysql->consulta($sqlSub);
                
?>
			    <tr>
				<td style="text-align: left;background: #f0f0f0;border: 1px solid #CCC;height: 20px;padding: 5px;">
                                    <a href="#" title="Eliminar Menu" onclick="eliminarMenu('<?=$row["id"];?>','<?=$row["modulo"];?>')" style="color: blue;"><img src="../../img/icon_delete.gif" border="0" /></a>
							=><?=$row["numeroMenu"]." - ";?><a href="#" onclick="modificarMenuTitulo('<?=$row["id"]?>')" title="Modificar Menu" style="color: blue;font-size: 12px;text-decoration: none;"><?=$row["modulo"];?></a>&nbsp;							
				</td>
				<td style="text-align: center;"><a href="#" title="Agregar Submenu" onclick="agregarItemSubMenu('<?=$row["id"];?>')" style="color: blue;"><img src="../../img/add.png" border="0" /></a></td>
                            </tr>
                            <tr>
				<td colspan="2">
				<div id="<?=$nombreDiv;?>">
<?				
		//if(mysql_num_rows($resSub)!=0){
                if($mysql->numregistros()!=0){
                    while($rowsub=mysql_fetch_array($resSub)){
?>
                        <div style="height: 15px;padding: 5px;">							
                            ==><a href="#" title="Eliminar Menu" onclick="eliminaSubmenu('<?=$rowsub['id']?>','<?=$rowsub["nombreSubMenu"];?>')" style="color: blue;"><img src="../../img/icon_delete.gif" border="0" /></a>&nbsp;
                            <a href="#" title="Modificar Submen&uacute;" onclick="modificarSubmenu('<?=$rowsub["id"];?>')" style="font-size: 12px;"><?=$rowsub["nombreSubMenu"]?></a>
			</div>
<?
                    }
		}
?>							
                                </div>
				</td>
                            </tr>
<?
		$i+=1;
            }
?>
                        </table>	
                    </div>
                    <div id="divSubMenu" style="float: left;width: 47%;height: 99%;border: 1px solid #CCC;margin: 2px;overflow: auto;"></div>
		</div>
			
<?
            $mysql->cerrarConexion();
        }
                
    }
?>