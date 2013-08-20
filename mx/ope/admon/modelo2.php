<?php
    /*
     *Clase para las modificaciones del menus de la aplicacion
     *
    */
    include("../../../clases/clase_mysql.php");
    
    class modeloUsuario{       
        
        private $linkConexion;
        private $objConexion;
        
	private function objConexion(){
	    include("../../../includes/config.inc.php");
            $mysql = new DB_mysql();
            $mysql->conectar($db,$host,$usuario,$pass);
	    $this->linkConexion=$mysql;	    
	}
	
	public function guardarModificacionMenuTitulo($nombreMenuTitulo,$numeroMenuAct,$idElementoAct,$idCliente){
	    include("../../../includes/config.inc.php");
            $mysql = new DB_mysql();
            $mysql->conectar($db,$host,$usuario,$pass);	    
	    $sqlActMenu="UPDATE menu set nombreMenu='".$nombreMenuTitulo."',orden='".$numeroMenuAct."' WHERE id='".$idElementoAct."'";	    
	    $resActMenu=$mysql->consulta($sqlActMenu);	    	    
	    if($mysql->regsAfectados() >= 1){
		echo "<script type='text/javascript'> alert('Informacion actualizada'); actualizaPanelMenu('".$idCliente."'); </script>";
	    }else{
		echo "<script type='text/javascript'> alert('Ocurrieron errores al actualizar o no se hicieron cambios en la informacion'); actualizaPanelMenu('".$idCliente."');</script>";
	    }
	}
	
        public function modificaMenuTitulo($idMenuTitulo,$idCliente){
	    include("../../../includes/config.inc.php");
            $mysql = new DB_mysql();
            $mysql->conectar($db,$host,$usuario,$pass);
	    
	    $sqlMenuTitulo="SELECT * FROM menu WHERE id='".$idMenuTitulo."'";
	    
	    $resMenutitulo=$mysql->consulta($sqlMenuTitulo);//mysql_query($sqlMenuTitulo,$this->conexion);
	    $rowMenuTitulo=$mysql->registroUnico();//mysql_fetch_array($resMenutitulo);
?>
	    <input type="hidden" name="txtIdElementoMenuTitulo" id="txtIdElementoMenuTitulo" value="<?=$idMenuTitulo;?>">
	    <input type="hidden" name="txtIdClienteMod" id="txtIdClienteMod" value="<?=$idCliente?>">
	    <table border="0" cellpadding="1" cellspacing="1" width="400" style="margin: 10px;font-size: 12px;">		
		<tr>
		    <td style="width: 150px;height: 20px;padding: 5px;border: 1px solid #ccc;background: #f0f0f0;">Nombre</td>					
		    <td style="width: 250px;"><input type="text" name="txtNombreMenuAct" id="txtNombreMenuAct" value="<?=$rowMenuTitulo["nombreMenu"];?>"></td>
		</tr>
		<tr>
		    <td style="height: 20px;padding: 5px;border: 1px solid #ccc;background: #f0f0f0;">Numero de Menu:</td>
		    <td><input type="text" name="txtNumeroMenuAct" id="txtNumeroMenuAct" value="<?=$rowMenuTitulo["orden"];?>"></td>
		</tr>
		<tr>
		    <td colspan="2"><hr style="background: #666;"></td>
		</tr>
		<tr>
		    <td colspan="2" style="text-align: right;"><input type="button" value="Guardar" onclick="guardarMenuTituloActualizacion()"></td>
		</tr>
	    </table>
<?
	}
	
	public function guardarFuncion($txtModulo,$txtMenu,$idCliente){
            include("../../../includes/config.inc.php");
            $mysql = new DB_mysql();
            $mysql->conectar($db,$host,$usuario,$pass);
            //echo "<br>".
	    $sqlGuarda="INSERT INTO menu (nombreMenu,orden,activo,id_cliente) values('".$txtModulo."','".$txtMenu."','1','".$idCliente."')";
            $resultGuarda=$mysql->consulta($sqlGuarda);//mysql_query($sqlGuarda,$var);
            if($resultGuarda==true){
            	echo "<script type='text/javascript'> alert('Registro Agregado'); actualizaPanelMenu('".$idCliente."'); </script>";				
            }else{
            	echo "<script type='text/javascript' > alert('Error al Guardar.'); </script>";
            }
	}

	public function mostrarOpcionesMenu($idCliente){
            include("../../../includes/config.inc.php");
            echo $sql="Select * FROM menu WHERE activo=1 AND id_cliente='".$idCliente."' Order By orden";
            $mysql = new DB_mysql();
            $mysql->conectar($db,$host,$usuario,$pass);
            $res=$mysql->consulta($sql);                       
            $res=$mysql->registrosConsulta();
            
	    if($numRegistros=$mysql->numregistros()==0){
		echo "<br><span style='font-weight:bold;font-size:14px;'>No existe un menu Asociado con este Cliente</span><br>.";
	    }
?>
	        <div style="height: 20px;padding: 5px;background: #f0f0f0;border:1px solid #CCC;width: 95%;margin: 5px;">		    
		    <input type="button" value="Agregar Men&uacute;" onclick="nuevaFuncionalidad('<?=$idCliente;?>')">
		</div>
		<div style="border: 1px solid #000;height: 94%;width: 98%;margin: 3px;">
                    <!--<div style="float: left;width: 99%;height: 99%;border: 1px solid #CCC;margin: 2px;overflow: auto;">-->
                        <table border="0" cellpadding="1" cellspacing="1" width="400" style="margin: 10px;font-size: 12px;">                            
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
                                    <a href="#" title="Eliminar Menu" onclick="eliminarMenu('<?=$row["id"];?>','<?=$row["modulo"];?>')" style="color: blue;"><img src="../../../img/icon_delete.gif" border="0" /></a>
				    =><?=$row["orden"]." - ";?><a href="#" onclick="modificarMenuTitulo('<?=$row["id"]?>','<?=$idCliente;?>')" title="Modificar Menu" style="color: blue;font-size: 12px;text-decoration: none;"><?=$row["nombreMenu"];?></a>&nbsp;							
				</td>
				<td style="text-align: center;"><a href="#" title="Agregar Submenu" onclick="agregarItemSubMenu('<?=$row["id"];?>')" style="color: blue;"><img src="../../../img/add.png" border="0" /></a></td>
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
                            ==><a href="#" title="Eliminar Menu" onclick="eliminaSubmenu('<?=$rowsub['id']?>','<?=$rowsub["nombreSubMenu"];?>')" style="color: blue;"><img src="../../../img/icon_delete.gif" border="0" /></a>&nbsp;
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
                    <!--</div>-->
                    <!--<div id="divSubMenu" style="float: left;width: 47%;height: 99%;border: 1px solid #CCC;margin: 2px;overflow: auto;"></div>-->
		</div>
			
<?
            $mysql->cerrarConexion();
        }
                
    }
?>