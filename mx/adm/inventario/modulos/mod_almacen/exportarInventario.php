<?php
    session_start();
    //print_r($_SESSION);
    $camposSelect=$_SESSION["camposSelect"];
    $campos=$_SESSION["campos"];
    $camposExist=$_SESSION["camposExist"];
    $clienteExport=$_SESSION["clienteExport"];
    $camposWhere=$_SESSION["camposWhere"];
    
    //exit();
    exportarDatos($camposSelect,$campos,$camposExist,$clienteExport,$camposWhere);
    
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
    
    function exportarDatos($camposSelect,$campos,$camposExist,$clienteExport,$camposWhere){
        $nombreArchivo="catalogo_".date("Y-m-d");
	header('Content-type: application/vnd.ms-excel');
	header("Content-Disposition: attachment; filename=$nombreArchivo.xls");
	header("Pragma: no-cache");
	header("Expires: 0");
        
        
        $camposConsulta=$campos.",".$camposExist;
        $camposConsulta=explode(",",$camposConsulta);
        if($camposWhere==""){
            $sql="SELECT ".$campos.",".$camposExist." FROM catprod WHERE id_clientes='".$clienteExport."'";    
        }else{
            $sql="SELECT ".$campos.",".$camposExist." FROM catprod WHERE id_clientes='".$clienteExport."' AND ".$camposWhere;    
        }
        
        $res=mysql_query($sql,conectarBd());
        if(mysql_num_rows($res)==0){
            echo "Sin resultados";
        }else{
?>
        <table width="1900" border="1" cellpadding="1" cellspacing="1" style="" >
            <tr>
<?
            for($i=0;$i<count($camposSelect);$i++){
?>            
                <td><?=$camposSelect[$i];?></td>    
<?            
            }
?>
            </tr>
<?
            $i=0;
            while($row=mysql_fetch_array($res)){
?>
                <tr>
<?
                for($i=0;$i<count($camposConsulta);$i++){
?>
                    <td><?=utf8_encode($row[$camposConsulta[$i]]);?></td>
<?
                }              
?>
                </tr>
<?
            $i+=1;
            }
            
        }
?>
        </table>
<?
    }
?>