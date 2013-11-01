<style type="text/css">
    body,document,html{position: absolute; margin: 0px; height: 100%; width: 100%; overflow: hidden; background: #666;font-family:Verdana,Georgia,Serif;}
    #contenedor{position: relative; width: 99%; height: 99%; border:2px solid #000;background: #FFF;}
    .divEspacio{position: relative; float: left; width: 35%; height: 98%;margin: 5px; border: 1px solid#333;background: #EDEDED; overflow: auto}
    .divEspacio1{position: relative; float: left; width: 63%; height: 98%;margin: 5px; border: 1px solid#333;background: #FFF; overflow: auto}
    .tabla1{ margin-left:20px; border:#CCC 1px solid; font-family:Verdana, Arial, Helvetica, sans-serif; font-size:11px; margin-top:10px; margin-bottom:10px; background-color:#FFFFFF; }
    .tabla1 td{ height:20px; border-right:#CCC 1px solid; padding:5px; }
    .tabla_campos{ text-align:center; font-weight:bold; background-color:#CCC; color:#000; height:20px; /*border-bottom:#333333 2px solid;*/ }
    .tabla_zebra0{ background-color:#FFF; }
    .tabla_zebra1{ background-color:#E3E4E7;  }
</style>
                <script type='text/javascript' src='function.js'></script>
		<script type='text/javascript' src='jquery.js'></script>
<div id="contenedor">
    <?
		$prefijo="CAT_";
		$excepciones_tablas=array("");
	        $excepciones_campos=array("");
		$largo_prefijo=strlen($prefijo);
		//print_r($largo_prefijo);
		$matriz_tablas=array(); 
		//MOSTRAMOS TODAS LAS TABLAS  
		$Sql ="SHOW TABLES";
		include("../../includes/config.inc.php");
		$link=mysql_connect($host,$usuario,$pass);
		if($link==false){
			echo "Error en la conexion a la base de datos";
		}
		else{
		      //  mysql_select_db($db);//$db
		      mysql_select_db($db);
			//return $link;
			//echo "conectado";
			if ($result = mysql_query($Sql,$link)){
				while($Rs = mysql_fetch_array($result)) {  
				//echo "<br>";	print_r($Rs);
				       if (substr($Rs[0],0,$largo_prefijo)==$prefijo){
				 	// Agrego la tabla al arreglo.
					array_push($matriz_tablas,$Rs[0]);
				        }
			        }
		        }
			else{
			echo "<br>Error SQL [".mysql_error($link)."].";
			exit;
		        }
?>
    <div id="menu" class="divEspacio">
        <!--<table width="98%" cellpadding="1" cellspacing="1" border="1">
				<tr>
					<td width="30%;" valign="top">-->
						<table class="tabla1" cellspacing="0" cellpadding="3">
							<tr>
								<td colspan="4" class="tabla_campos">Cat&aacute;logos</td>
							</tr>
<?php
$clase_css="tabla_zebra0";
						foreach($matriz_tablas As $t){ $ta=str_replace($prefijo,"",$t);
?>
							<tr class="<?=$clase_css?>">
								<td width="243">&nbsp;<?=strtoupper($ta);?></td>
								<td width="20">
<?php
							if (!in_array($t,$excepciones_tablas)){
?>
								<a href="#" onclick="catalogo_listar('<?=$t;?>','<?=$prefijo;?>')" title="Listar"><img src="img/listar.png" border="0" width="17" height="17"></a>
<?php 							}else{
								echo "&nbsp;";
							}
?>
								</td>
								<td width="21">
<?php
							if (!in_array($t,$excepciones_tablas)){ ?>
								<a href="#" onclick="cdm_catalogox_agregar('<?=$t?>','<?=$prefijo?>');" title="Agregar registro"><img src="img/agregar.png" border="0" width="17" height="17"></a>
<?php
							}else{
								echo "&nbsp;";
							}
?>
								</td>
																<td width="21">
<?php
							if (!in_array($t,$excepciones_tablas)){ ?>
								<a href="#" onclick="catalogo_update('<?=$t?>','<?=$prefijo?>');" title="Modificar registro"><img src="img/actualiza.png" border="0" width="17" height="17"></a>
<?php
							}else{
								echo "&nbsp;";
							}
?>
								</td>

							</tr>
<?php 
						($clase_css=="tabla_zebra0")? $clase_css="tabla_zebra1" : $clase_css="tabla_zebra0";
						}
?>
						</table>						
						
					</td>
					<td width="78%" valign="top"><div id="accionesCatalogos"></div></td>
				</tr>
			</table>		
    </div>
    <div id="muestra" class="divEspacio1">
        
    </div>
    
</div>
<?
                }