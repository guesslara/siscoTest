<?php
include("cat_diagnosticos2.php");
	//$objLote=new cat_diagnosticos2();
        
        switch($_POST['action']){
            case "buscar":
                    $busc=$_POST["part"];
                    //print_r($busc);
                    //exit;
                    $objLote->buscar($busc);
		break;
        }
        
?>