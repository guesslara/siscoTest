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
        
        
        public function listarClientes(){
            $sql="SELECT * FROM cat_clientes WHERE activo=1";
            $res=mysql_query($sql,$this->conectarBd());
            if(mysql_num_rows($res)==0){
                echo "No existen Clientes Capturados";
            }else{
?>
                <div style="margin: 10px;font-size: 12px;">
                Seleccione el cliente para mostrar su inventario:<br><br>
                <select name="cboClienteInventario" id="cboClienteInventario" style="margin-left: 30px;width: 200px;font-size: 14px;" onchange="listarInventario('N/A','N/A')">
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
<?
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
        
                
        public function mostrarInventario($campos,$nombresCampo,$campoFiltro,$valorAFiltrar,$idCliente){	    
            session_start();
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
	    
	    //se extraen los almacenes del cliente seleccionado	    
	    $sqlAlm="SELECT almacenCliente.id_almacen AS id_almacen, almacen
	    FROM almacenCliente INNER JOIN tipoalmacen ON almacenCliente.id_almacen = tipoalmacen.id_almacen
	    WHERE id_cliente = '".$idCliente."'";
	    $resAlm=mysql_query($sqlAlm,$this->conectarBd());
	    if(mysql_num_rows($resAlm)==0){
		echo "No hay almacenes asociados con este cliente";
	    }else{
		$camposExist="";
		while($rowAlm=mysql_fetch_array($resAlm)){
		    if($camposExist==""){
			$camposExist="exist_".$rowAlm["id_almacen"];
			array_push($camposSelectConsulta,$camposExist);
			array_push($camposSelect,$rowAlm["almacen"]);
		    }else{
			$camposExist=$camposExist.",exist_".$rowAlm["id_almacen"];
			array_push($camposSelectConsulta,"exist_".$rowAlm["id_almacen"]);
			array_push($camposSelect,$rowAlm["almacen"]);
		    }
		}
	    }
	    //exit();
	    /*
	    echo "<br>".$campos."<br>";
	    echo "<br>".$camposExist."<br>";	    
	    echo "<br>".$campos.",".$camposExist."<br>";	    
	    exit();
	    echo "<pre>";
	    print_r($camposSelectConsulta);
	    echo "</pre>";
	    exit();
	    */
            if($campoFiltro=="N/A" || $valorAFiltrar=="N/A"){
		$sqlListar="SELECT ".$campos.",".$camposExist." FROM ".$tabla." WHERE id_clientes='".$idCliente."' ORDER BY id ASC LIMIT $RegistrosAEmpezar, $RegistrosAMostrar";
		$sqlListar1="SELECT ".$campos.",".$camposExist." FROM ".$tabla." WHERE id_clientes='".$idCliente."' ORDER BY id ASC";
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
		$sqlListar="SELECT ".$campos.",".$camposExist." FROM ".$tabla." WHERE id_clientes='".$idCliente."' AND ".$camposWhere." ORDER BY id ASC LIMIT $RegistrosAEmpezar, $RegistrosAMostrar";
		$sqlListar1="SELECT ".$campos.",".$camposExist." FROM ".$tabla." WHERE id_clientes='".$idCliente."' AND ".$camposWhere." ORDER BY id ASC";
	    }
            /*            
            echo "<br>".$sqlListar;
            echo "<br>".$sqlListar1;
            */
	    $_SESSION["camposSelect"]=$camposSelect;
	    $_SESSION["campos"]=$campos;
	    $_SESSION["camposExist"]=$camposExist;
	    $_SESSION["clienteExport"]=$idCliente;
	    $_SESSION["camposWhere"]=$camposWhere;
	    
	    
            $rs=mysql_query($sqlListar,$this->conectarBd());
            $rs1=mysql_query($sqlListar1,$this->conectarBd());
            if(mysql_num_rows($rs1)!=0){		
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
                    <div style="float: left;border: 0px solid #FF0000; width: auto;"><strong>Listado de Productos</strong><input type="hidden" name="hdnClienteInventario" id="hdnClienteInventario" value=""></div>
                    <div style="clear: both;"></div>
                    <div style="float: left;border: 1px solid #FF0000;width: auto;">
                        
                    </div>
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
		    <div class="btnMostrarTodo" onclick="listarInventario('N/A','N/A');"><strong>Mostrar Todo</strong></div>
		    <div class="btnMostrarTodo" style="width:150px;" onclick="cambiarCliente();"><strong>Cambiar Cliente</strong></div>
		    <div class="btnMostrarTodo" style="width:150px;" onclick="exportarExcel();"><strong>Exportar a Excel</strong></div>
		    <div style="float:right;width: 200px;height: 15px;text-align: left;border: 0px solid #CCC;padding: 2px;font-weight: bold;font-size: 12px;">Resultados:&nbsp;<?=$NroRegistros;?></div>
                </div>
                <div align="left" style="margin:5px 0px 0px 4px;">
                    <form name="frm_consultas" id="frm_contenedor">
                        <table width="1900" border="0" cellpadding="1" cellspacing="1" style="font-size: 10px;border:1px solid #000;" >
                            <tr>                            
<?			
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
				    <div style="border: 0px solid blue;width: auto;overflow: hidden;height: 15px;">
					<div style="float: left;width: auto;border: 0px solid #FF0000;margin-top: -4px;text-align: left;"><?=utf8_decode($camposSelect[$i]);?>&nbsp;<a href="#" onclick="mostrarFiltro('<?=($i+1);?>','<?=$camposSelectConsulta[$i];?>')"><img src="../../../../../img/filtro.jpg" border="0"></a></div>
					<!--<div style="float: left;width: auto;margin-left: 2px;border: 1px solid #FF0000;"><a href="#" onclick="mostrarFiltro('<?=($i+1);?>','<?=$camposSelectConsulta[$i];?>')"><img src="../../../../../img/filtro.jpg" border="0"></a></div>-->
				    </div>
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
                            if($i==1){
?>                                
                                <td class="estiloResultados" style="width: auto;">&nbsp;<a href="#" onclick="ver_kardex('<?=$row["id"];?>')" style="color:blue;"><?=utf8_encode($row[$camposSelectConsulta[$i]]);?></a></td>
<?                                
                            }else{
?>
				<td class="estiloResultados" style="width: auto;">&nbsp;<?=utf8_encode($row[$camposSelectConsulta[$i]]);?></td>
<?
                            }
                        }
?>
                            </tr>    
<?
                    }
?>                            
                        </table>
                    </form>
                </div>
		<script type="text/javascript">
		    $("#hdnClienteInventario").attr("value",'<?=$idCliente;?>');
		</script>
<?                
	    }else{
?>
		<div class="tituloReporte">
                    <div style="float: left;border: 0px solid #FF0000; width: auto;"><strong>( 0 ) Productos Encontrados</strong><input type="hidden" name="hdnClienteInventario" id="hdnClienteInventario" value=""></div>
                    <div class="btnMostrarTodo" style="width:150px;" onclick="cambiarCliente();"><strong>Cambiar Cliente</strong></div>
		    <div style="clear: both;"></div>
                    <div style="float: left;border: 1px solid #FF0000;width: auto;"></div>
                </div>
<?
	    }
	}
    }//fin de la clase

?>