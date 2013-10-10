<?
	/*
	 *controladorEnsamble:contiene la instancia de la clase y las variables para cada una de las funciones de las clases
	 *Autor: Rocio Manuel Aguilar
	 *Fecha:20/Nov/2012
	*/
	include("modeloEnsamble.php");
	$objLote=new modeloEnsamble();
	//print_r($_POST);
	
	function clean($cadclean){
        $cadclean = mysql_real_escape_string(stripslashes(strip_tags($cadclean)));
        return $cadclean;
	}
	switch($_POST['action']){
		/***************************Lote******************************/
		case "mostrarLotes":
			$opt=clean($_POST['opt']);
			$id_usuario=clean($_POST['idUsuario']);
			$idProyecto=clean($_POST['idProyectoSeleccionado']);
			$objLote->mostrarLotesProyecto($opt,$id_usuario,$idProyecto);
		break;
		case "verFormatos":
			$idLote=clean($_POST["idLote"]);
			$idUsuario=clean($_POST["idUsuario"]);
			$idProyecto=clean($_POST["idProyectoSeleccionado"]);
			$numPo=clean($_POST["numPo"]);
			$objLote->verFormatos($idLote,$idUsuario,$idProyecto,$numPo);
		break;
		case "formatoPDF":
			$idLote=clean($_POST["idLote"]);
			$idUsuario=clean($_POST["idUsuario"]);
			$idProyecto=clean($_POST["idProyectoSeleccionado"]);
			$noFormato=clean($_POST["noFormato"]);
			$nombre=clean($_POST["nombre"]);
			$datoE=clean($_POST["datoE"]);
			if(fopen("../mod_formatos/nuevo$idLote.php","a")){
				unlink("../mod_formatos/nuevo$idLote.php");
			}
			$OFiel=fopen("../mod_formatos/nuevo$idLote.php","a");
			$datosArchivo="<?php".PHP_EOL."\$idUsuario=\"$idUsuario\";".PHP_EOL."\$idLote=\"$idLote\";".PHP_EOL."\$idProyecto=\"$idProyecto\";".PHP_EOL."\$noFormato=\"$noFormato\";".PHP_EOL."\$nombre=\"$nombre\";".PHP_EOL."\$datoE=\"$datoE\";".PHP_EOL."?>";
			fwrite($OFiel, $datosArchivo);
			fclose($OFiel);
			if($noFormato=="IQF0750301" || $noFormato=="IQF0750302" || $noFormato=="IQF0750305" || $noFormato=="IQF0750308" || $noFormato=="IQF0750309" || $noFormato=="IQF0750304" || $noFormato=="IQF0750307"){
				$cab=1;
			}else{
				$cab=2;
			}
			?>
			<script type="text/javascript">
				_blank=window.open("","_blank");
				_blank.location.href ="machoteCentrado.php?noFormato=<?=$noFormato;?>&idLote=<?=$idLote;?>&cab=<?=$cab;?>";
			</script>
			<?
		break;
		case "muestraTec":
			$idLote=clean($_POST["idLote"]);
			$idUsuario=clean($_POST["idUsuario"]);
			$idProyecto=clean($_POST["idProyectoSeleccionado"]);
			$noFormato=clean($_POST["noFormato"]);
			$nombre=clean($_POST["nombre"]);
			$datoE=clean($_POST["datoE"]);
			$objLote->muestraTec($idLote,$idUsuario,$idProyecto,$noFormato,$nombre,$datoE);
		break;
	        case "insertardatos":
                        $date=$_POST["fecha"];
			$hora=$_POST["timer"];
			$nom=$_POST['name'];
			$intrr=$_POST['introd'];
			$numparte=$_POST["nuparte"];
		        $foto=$_POST["fott"];
			$coment=$_POST["comenta"];
			$firma=$_POST["firma"];
			$objLote->insertardatos($date,$hora,$nom,$intrr,$numparte,$foto,$coment,$firma);
			/*window.location.href="uploader2.php?pic=<?=$foto?>";*/
                break;
	}