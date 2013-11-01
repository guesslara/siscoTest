<?
    /*
    *controladorEnsamble:contiene la instancia de la clase y las variables para cada una de las funciones de las clases
    *Autor: 
    *Fecha:
    */
    include("modelo.php");
    $objLote=new modelo();
    //print_r($_POST);
    function clean($cadclean){
        $cadclean = mysql_real_escape_string(stripslashes(strip_tags($cadclean)));
        return $cadclean;
    }
    switch($_POST['action']){
        case "datos":
            $idElemento=clean($_POST["idElemento"]);
            $valores=clean($_POST["valores"]);
            $objLote->guardarDatos($idElemento,$valores);
        break;
        case "verFoliosResumen":
            $objLote->verFoliosResumen();
        break;
        case "exportar":
            $objLote->exportar();
        break;
        case "exportarXLS":
            $lotes=clean($_POST["lotesEx"]);
            ?>
           <script type="text/javascript">
				window.location.href="archivo.php?lotes=<?=$lotes?>";
	    </script>
           <?
        break;
    }
?>
