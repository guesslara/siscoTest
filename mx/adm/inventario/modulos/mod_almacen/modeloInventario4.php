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
        
        public function llenarFiltros($campos){
            $campos=explode(",",$campos);
            for($i=0;$i<count($campos);$i++){
                $sqlF="SELECT COUNT( * ) AS `Filas` , ".$campos[$i]." FROM `catprod` GROUP BY ".$campos[$i]." ORDER BY ".$campos[$i]."";
                $resF=mysql_query($sqlF,$this->conectarBd());
                if(mysql_num_rows($resF)==0){
                    echo "(0) resultados";
                }else{
                    while($rowF=mysql_fetch_array($resF)){
                        $nombreDiv="#contenidoFiltro_".($i+1);
?>
                        <script type="text/javascript">
                            $("<?=$nombreDiv?>").append("<div class='resultadosFiltrosConsulta'><input type='checkbox'><?=utf8_encode($rowF[$campos[$i]]);?></div>");
                        </script>
                        
<?
                    }
                }
            }
        }
        
                
        public function mostrarInventario($campos){
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
            $campos=$campos;
            $tabla="catprod";
            
            //se ejecuta la operacion para llenar los filtros
            //$this->llenarFiltros($campos);
            
            $sqlListar="SELECT ".$campos." FROM ".$tabla." ORDER BY id ASC LIMIT $RegistrosAEmpezar, $RegistrosAMostrar";
            $sqlListar1="SELECT ".$campos." FROM ".$tabla." ORDER BY id ASC";
            
            //echo "<br>".$sqlListar;
            //echo "<br>".$sqlListar1;
            
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
            
            if($NroRegistros==0){
                    echo "<br>Sin registros.<br>";
            }else{
?>                
                <div class="tituloReporte">
                    <strong>Listado de Productos</strong><br />                    
                </div>
                <div class="paginadorGrid">
		    <div style="float: left;width: 20px;height: 15px;border: 1px solid #CCC;padding: 2px;"><a href="#" onclick="Pagina('1')" title="Primero" style="cursor:pointer; text-decoration:none;">|&lt;</a>&nbsp;</div>
<?
		if($PagAct>1){ 
?>
                    <div style="float: left;width: 20px;height: 15px;border: 1px solid #CCC;padding: 2px;"><a href="#" onclick="Pagina('<?=$PagAnt;?>')"  title="Anterior" style="cursor:pointer; text-decoration:none;">&lt;&lt;</a>&nbsp;</div>
<?
		}
		echo "<div style='float: left;width: 80px;height: 15px;border: 1px solid #CCC;padding: 2px;'><strong>".$PagAct."/".$PagUlt."</strong></div>";
		if($PagAct<$PagUlt){
?>
                    <div style="float: left;width: 20px;height: 15px;border: 1px solid #CCC;padding: 2px;"><a href="#" onclick="Pagina('<?=$PagSig;?>')"  title="Siguiente" style="cursor:pointer; text-decoration:none;">&gt;&gt;</a>&nbsp;</div>
<?
		}
?>     
                    <div style="float: left;width: 20px;height: 15px;border: 1px solid #CCC;padding: 2px;"><a href="#" onclick="Pagina('<?=$PagUlt;?>')" title="Ultimo" style="cursor:pointer; text-decoration:none;">&gt;|</a>&nbsp;</div>
		    <div style="float:right;width: 200px;height: 15px;text-align: left;border: 1px solid #CCC;padding: 2px;font-weight: bold;font-size: 12px;">Resultados:&nbsp;<?=$NroRegistros;?></div>
                </div>
                <div align="left" style="margin:5px 0px 0px 4px;">
                    <form name="frm_consultas" id="frm_contenedor">
                        <table border="1" cellpadding="1" cellspacing="1" style="font-size: 10px;width:auto;" >
                            <tr>
                                <td width="50" align="center" class="estiloTitulosColumnas" valign="middle">Id&nbsp;&nbsp;<a href="#" onclick="mostrarFiltro('1')"><img src="../../../../../img/filtro.jpg" border="0"></a>
                                    <div id="1" style="position: absolute;border: 1px solid #ff0000;"></div>
                                    <!--<div id="div_1" class="ventanaFiltro"><div class="contenedorTituloFiltro"><div style="float: left;">Filtrar Datos</div><div style="float: right;"><a href="#" onclick="cerrarFiltroVentana('div_1')" title="Cerrar Ventana"><img src="../../../../../img/close.gif" height="15" width="15" border="0"></a></div></div><div id="contenidoFiltro_1" class="contenidoFiltroResultados"></div></div>-->
                                </td>
                                <td width="150" align="center" class="estiloTitulosColumnas" valign="middle">No Parte&nbsp;&nbsp;<a href="#" onclick="mostrarFiltro('2')"><img src="../../../../../img/filtro.jpg" border="0"></a>
                                    <!--<div id="div_2" class="ventanaFiltro"><div class="contenedorTituloFiltro"><div style="float: left;">Filtrar Datos</div><div style="float: right;"><a href="#" onclick="cerrarFiltroVentana('div_2')" title="Cerrar Ventana"><img src="../../../../../img/close.gif" height="15" width="15" border="0"></a></div></div><div id="contenidoFiltro_2" class="contenidoFiltroResultados"></div></div>-->
                                </td>
                                <td width="200" align="center" class="estiloTitulosColumnas" valign="middle">Familia&nbsp;&nbsp;<a href="#" onclick="mostrarFiltro('3')"><img src="../../../../../img/filtro.jpg" border="0"></a>
                                    <!--<div id="div_3" class="ventanaFiltro"><div class="contenedorTituloFiltro"><div style="float: left;">Filtrar Datos</div><div style="float: right;"><a href="#" onclick="cerrarFiltroVentana('div_3')" title="Cerrar Ventana"><img src="../../../../../img/close.gif" height="15" width="15" border="0"></a></div></div><div id="contenidoFiltro_3" class="contenidoFiltroResultados"></div></div>-->
                                </td>
                                <td width="200" align="center" class="estiloTitulosColumnas" valign="middle">SubFamilia&nbsp;&nbsp;<a href="#" onclick="mostrarFiltro('4')"><img src="../../../../../img/filtro.jpg" border="0"></a>
                                    <!--<div id="div_4" class="ventanaFiltro"><div class="contenedorTituloFiltro"><div style="float: left;">Filtrar Datos</div><div style="float: right;"><a href="#" onclick="cerrarFiltroVentana('div_4')" title="Cerrar Ventana"><img src="../../../../../img/close.gif" height="15" width="15" border="0"></a></div></div><div id="contenidoFiltro_4" class="contenidoFiltroResultados"></div></div>-->
                                </td>
                                <td width="300" align="center" class="estiloTitulosColumnas" valign="middle">Descripgral&nbsp;&nbsp;<a href="#" onclick="mostrarFiltro('5')"><img src="../../../../../img/filtro.jpg" border="0"></a>
                                    <!--<div id="div_5" class="ventanaFiltro"><div class="contenedorTituloFiltro"><div style="float: left;">Filtrar Datos</div><div style="float: right;"><a href="#" onclick="cerrarFiltroVentana('div_5')" title="Cerrar Ventana"><img src="../../../../../img/close.gif" height="15" width="15" border="0"></a></div></div><div id="contenidoFiltro_5" class="contenidoFiltroResultados"></div></div>-->
                                </td>
                                <td width="100" align="center" class="estiloTitulosColumnas" valign="middle">L&iacute;nea&nbsp;&nbsp;<a href="#" onclick="mostrarFiltro('6')"><img src="../../../../../img/filtro.jpg" border="0"></a>
                                    <!--<div id="div_6" class="ventanaFiltro"><div class="contenedorTituloFiltro"><div style="float: left;">Filtrar Datos</div><div style="float: right;"><a href="#" onclick="cerrarFiltroVentana('div_6')" title="Cerrar Ventana"><img src="../../../../../img/close.gif" height="15" width="15" border="0"></a></div></div><div id="contenidoFiltro_6" class="contenidoFiltroResultados"></div></div>-->
                                </td>
                                <td width="100" align="center" class="estiloTitulosColumnas" valign="middle">Ctrl Alm.&nbsp;&nbsp;<a href="#" onclick="mostrarFiltro('7')"><img src="../../../../../img/filtro.jpg" border="0"></a>
                                    <!--<div id="div_7" class="ventanaFiltro"><div class="contenedorTituloFiltro"><div style="float: left;">Filtrar Datos</div><div style="float: right;"><a href="#" onclick="cerrarFiltroVentana('div_7')" title="Cerrar Ventana"><img src="../../../../../img/close.gif" height="15" width="15" border="0"></a></div></div><div id="contenidoFiltro_7" class="contenidoFiltroResultados"></div></div>-->
                                </td>
                            </tr>
<?
                    $color="#CCCCCC";
                    $i=0;
                    while($row=mysql_fetch_array($rs)){
?>
                            <tr style="background:#FFF;" onMouseOver="anterior=this.style.backgroundColor;this.style.backgroundColor='#D5EAFF'" onmouseout="this.style.backgroundColor=anterior">
                                <td width="200" class="estiloResultados" style="<?=$borde1;?>">&nbsp;<?=utf8_encode($row["id"]);?></td>
                                <td width="150" class="estiloResultados" style="<?=$borde1;?>">&nbsp;<?=utf8_encode($row["noParte"]);?></td>
                                <td width="200" class="estiloResultados" style="<?=$borde1;?>">&nbsp;<?=utf8_encode($row["familia"]);?></td>
                                <td width="200" class="estiloResultados" style="<?=$borde1;?>">&nbsp;<?=utf8_encode($row["subfamilia"]);?></td>
                                <td width="300" class="estiloResultados" style="<?=$borde1;?>">&nbsp;<?=utf8_encode($row["descripgral"]);?></td>
                                <td width="100" class="estiloResultados" style="<?=$borde1;?>">&nbsp;<?=utf8_encode($row["linea"]);?></td>
                                <td width="100" class="estiloResultados" style="<?=$borde1;?>">&nbsp;<?=utf8_encode($row["control_alm"]);?></td>
                            </tr>    
<?
                        ($color=="#F0F0F0") ? $color="#CCCCCC" : $color="#F0F0F0";
                        $i=$i+1;
                    }
?>                            
                        </table>
                    </form>
                </div>    
<?                
            }
        }
    }//fin de la clase
    
    
    /*
    
    <div class="paginadorGrid">
		    <div style="float: left;width: 20px;height: 15px;border: 1px solid #CCC;padding: 2px;"><a href="#" onclick="Pagina('1')" title="Primero" style="cursor:pointer; text-decoration:none;">|&lt;</a>&nbsp;</div>
<?
		if($PagAct>1){ 
?>
                    <div style="float: left;width: 20px;height: 15px;border: 1px solid #CCC;padding: 2px;"><a href="#" onclick="Pagina('<?=$PagAnt;?>')"  title="Anterior" style="cursor:pointer; text-decoration:none;">&lt;&lt;</a>&nbsp;</div>
<?
		}
		echo "<div style='float: left;width: 80px;height: 15px;border: 1px solid #CCC;padding: 2px;'><strong>".$PagAct."/".$PagUlt."</strong></div>";
		if($PagAct<$PagUlt){
?>
                    <div style="float: left;width: 20px;height: 15px;border: 1px solid #CCC;padding: 2px;"><a href="#" onclick="Pagina('<?=$PagSig;?>')"  title="Siguiente" style="cursor:pointer; text-decoration:none;">&gt;&gt;</a>&nbsp;</div>
<?
		}
?>     
                    <div style="float: left;width: 20px;height: 15px;border: 1px solid #CCC;padding: 2px;"><a href="#" onclick="Pagina('<?=$PagUlt;?>')" title="Ultimo" style="cursor:pointer; text-decoration:none;">&gt;|</a>&nbsp;</div>
		    <div style="float:right;width: 200px;height: 15px;text-align: left;border: 1px solid #CCC;padding: 2px;font-weight: bold;font-size: 12px;">Resultados:&nbsp;<?=$NroRegistros;?></div>
                </div>
    
    
    */
?>