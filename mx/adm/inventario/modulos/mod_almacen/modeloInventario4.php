<?php
    class inventario{

        private function conectarBd(){
            require("../../../../../includes/config.inc.php");
            $link=mysql_connect($host,$usuario,$pass);
            if($link==false){
                echo "Error en la conexion a la base de datos";
            }else{
		mysql_select_db($db);
		return $link;
            }				
	}
        
        public function llenarFiltros($campo){
	    $sqlF="SELECT COUNT( * ) AS `Filas` , ".$campo." FROM `catprod` GROUP BY ".$campo." ORDER BY ".$campo."";
	    $resF=mysql_query($sqlF,$this->conectarBd());
	    if(mysql_num_rows($resF)==0){
		echo "(0) resultados";
	    }else{
		while($rowF=mysql_fetch_array($resF)){                        
?>
		    <div class='resultadosFiltrosConsulta'><form name="frmFiltro" id="frmFiltro"><input id="chkFiltros" name="chkFiltros" type='checkbox' onclick="aplicarFiltro('<?=$campo;?>','<?=utf8_encode($rowF[$campo]);?>',this.checked)"><?=utf8_encode($rowF[$campo]);?></form></div>
<?
		}
	    }
        }
        
                
        public function mostrarInventario($campos,$nombresCampo,$campoFiltro,$valorAFiltrar){	    
            $RegistrosAMostrar=20;
            //estos valores los recibo por GET
            if(isset($_POST['pag'])){
              $RegistrosAEmpezar=($_POST['pag']-1)*$RegistrosAMostrar;
              $PagAct=$_POST['pag'];
            //caso contrario los iniciamos
            }else{
              $RegistrosAEmpezar=0;
              $PagAct=1;
            }
            $camposSelectConsulta=explode(",",$campos);
	    $camposSelect=explode(",",$nombresCampo);
	    
            $tabla="catprod";
            if($campoFiltro=="N/A" || $valorAFiltrar=="N/A"){
		$sqlListar="SELECT ".$campos." FROM ".$tabla." ORDER BY id ASC LIMIT $RegistrosAEmpezar, $RegistrosAMostrar";
		$sqlListar1="SELECT ".$campos." FROM ".$tabla." ORDER BY id ASC";
	    }else{//se aplica el filtro en el listado
		$campoFiltro=explode(",",$campoFiltro);
		$valorAFiltrar=explode(",",$valorAFiltrar);
		$camposWhere="";
		for($i=0;$i<count($campoFiltro);$i++){
		    if($camposWhere==""){
			$camposWhere=" ".$campoFiltro[$i]." = '".$valorAFiltrar[$i]."'";
		    }else{
			$camposWhere=$camposWhere." AND ".$campoFiltro[$i]." = '".$valorAFiltrar[$i]."'";
		    }		    
		}
		$sqlListar="SELECT ".$campos." FROM ".$tabla." WHERE ".$camposWhere." ORDER BY id ASC LIMIT $RegistrosAEmpezar, $RegistrosAMostrar";
		$sqlListar1="SELECT ".$campos." FROM ".$tabla." WHERE ".$camposWhere." ORDER BY id ASC";
	    }
                        
            echo "<br>".$sqlListar;
            echo "<br>".$sqlListar1;
            
            $rs=mysql_query($sqlListar,$this->conectarBd());
            $rs1=mysql_query($sqlListar1,$this->conectarBd());
            
            //******--------determinar las páginas---------******//
            $NroRegistros=mysql_num_rows($rs1);
            $PagAnt=$PagAct-1;
            $PagSig=$PagAct+1;
            $PagUlt=$NroRegistros/$RegistrosAMostrar;
            
            //verificamos residuo para ver si llevará decimales
            $Res=$NroRegistros%$RegistrosAMostrar;
            // si hay residuo usamos funcion floor para que me devuelva la parte entera, SIN REDONDEAR, y le sumamos una unidad para obtener la ultima pagina
            if($Res>0) $PagUlt=floor($PagUlt)+1;
?>                
                <div class="tituloReporte">
                    <strong>Listado de Productos</strong><br />                    
                </div>
                <div class="paginadorGrid">
		    <div style="float: left;width: 20px;height: 15px;border: 1px solid #CCC;padding: 2px;"><a href="#" onclick="Pagina('1','<?=$campoFiltro;?>','<?=$valorAFiltrar;?>')" title="Primero" style="cursor:pointer; text-decoration:none;">|&lt;</a>&nbsp;</div>
<?
		if($PagAct>1){ 
?>
                    <div style="float: left;width: 20px;height: 15px;border: 1px solid #CCC;padding: 2px;"><a href="#" onclick="Pagina('<?=$PagAnt;?>','<?=$campoFiltro;?>','<?=$valorAFiltrar;?>')"  title="Anterior" style="cursor:pointer; text-decoration:none;">&lt;&lt;</a>&nbsp;</div>
<?
		}
		echo "<div style='float: left;width: 80px;height: 15px;border: 1px solid #CCC;padding: 2px;'><strong>".$PagAct."/".$PagUlt."</strong></div>";
		if($PagAct<$PagUlt){
?>
                    <div style="float: left;width: 20px;height: 15px;border: 1px solid #CCC;padding: 2px;"><a href="#" onclick="Pagina('<?=$PagSig;?>','<?=$campoFiltro;?>','<?=$valorAFiltrar;?>')"  title="Siguiente" style="cursor:pointer; text-decoration:none;">&gt;&gt;</a>&nbsp;</div>
<?
		}
?>     
                    <div style="float: left;width: 20px;height: 15px;border: 1px solid #CCC;padding: 2px;"><a href="#" onclick="Pagina('<?=$PagUlt;?>','<?=$campoFiltro;?>','<?=$valorAFiltrar;?>')" title="Ultimo" style="cursor:pointer; text-decoration:none;">&gt;|</a>&nbsp;</div>
		    <div style='float: left;width: 100px;height: 15px;border: 1px solid #CCC;padding: 2px;margin-left: 10px;'><strong>Mostrar Todo</strong></div>
		    <div style="float:right;width: 200px;height: 15px;text-align: left;border: 1px solid #CCC;padding: 2px;font-weight: bold;font-size: 12px;">Resultados:&nbsp;<?=$NroRegistros;?></div>
                </div>
                <div align="left" style="margin:5px 0px 0px 4px;">
                    <form name="frm_consultas" id="frm_contenedor">
                        <table width="1500" border="1" cellpadding="1" cellspacing="1" style="font-size: 10px;" >
                            <tr>                            
<?
			/*echo "<pre>";
			print_r($camposSelectConsulta);
			echo "</pre>";
			echo "<pre>";
			print_r($campoFiltro);
			echo "</pre>";*/			
			for($i=0;$i<count($camposSelect);$i++){			    
			    if($campoFiltro != "N/A"){
				if(in_array($camposSelectConsulta[$i],$campoFiltro)){	
				    $fondoTitulo="border:1px solid blue;background:#D5EAFF;";
				}else{
				    $fondoTitulo="border:1px solid #CCC;background:#F0F0F0;";
				}
			    }
?>
				<td align="center" class="estiloTitulosColumnas" valign="middle" style="background: <?=$fondoTitulo;?>">
				    <div style="float: left;width: auto;border: 0px solid #FF0000;margin-top: 4px;"><?=utf8_decode($camposSelect[$i]);?></div>
				    <div style="float: left;width: auto;margin-left: 10px;border: 0px solid #FF0000;"><a href="#" onclick="mostrarFiltro('<?=($i+1);?>','<?=$camposSelectConsulta[$i];?>')"><img src="../../../../../img/filtro.jpg" border="0"></a></div>
                                    <div id="div_<?=($i+1);?>" class="ventanaFiltro">
					<div class="contenedorTituloFiltro">
					    <div style="float: left;">Filtrar Datos</div>
					    <div style="float: right;"><a href="#" onclick="cerrarFiltroVentana('div_<?=($i+1);?>')" title="Cerrar Ventana"><img src="../../../../../img/close.gif" height="15" width="15" border="0"></a></div>
					</div>
					<div id="buscadorFiltro_<?=($i+1);?>" style="border: 1px solid #666;height: 20px;width: 240px;padding: 5px;text-align: left;">Buscar<input type="text" name="" id="" style="width: 195px;"></div>
					<div id="contenidoFiltro_<?=($i+1);?>" class="contenidoFiltroResultados"></div>
					<div id="filtrosAplicados_<?=$camposSelectConsulta[$i];?>" style="border: 1px solid #CCC;height: 83px;width: 248px;overflow: auto;"></div>
				    </div>
                                </td>
<?
			}
?>
			    </tr>
<?
                    while($row=mysql_fetch_array($rs)){
?>
                            <tr style="background:#FFF;" onMouseOver="anterior=this.style.backgroundColor;this.style.backgroundColor='#D5EAFF'" onmouseout="this.style.backgroundColor=anterior">
<?
			for($i=0;$i<count($camposSelectConsulta);$i++){
?>
				<td width="200" class="estiloResultados" style="<?=$borde1;?>">&nbsp;<?=utf8_encode($row[$camposSelectConsulta[$i]]);?></td>
<?
			}
?>
                            </tr>    
<?
                    }
?>                            
                        </table>
                    </form>
                </div>    
<?                
        }
    }//fin de la clase

?>