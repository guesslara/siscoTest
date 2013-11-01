<?php

  /*$idLote=$_GET["idLote"];
  $idUsuario=$_GET["idUsuario"];
  $idProyecto=$_GET["idProyectoSeleccionado"];
  $noFormato=$_GET["noFormato"];
  print_r($_GET);*/
//============================================================+
// File name   : example_048.php
// Begin       : 2009-03-20
// Last Update : 2013-05-14
//
// Description : Example 048 for TCPDF class
//               HTML tables and table headers
//
// Author: Nicola Asuni
//
// (c) Copyright:
//               Nicola Asuni
//               Tecnick.com LTD
//               www.tecnick.com
//               info@tecnick.com
//============================================================+

/**
 * Creates an example PDF TEST document using TCPDF
 * @package com.tecnick.tcpdf
 * @abstract TCPDF - Example: HTML tables and table headers
 * @author Nicola Asuni
 * @since 2009-03-20
 */

// Include the main TCPDF library (search for installation path).
require('../prueba.php');
require_once('tcpdf_include.php');
require("../../../includes/config.inc.php"); 
function conectarBd(){
      require("../../../includes/config.inc.php");
      $link=mysql_connect($host,$usuario,$pass);
      if($link==false){
        echo "Error en la conexion a la base de datos";
      }else{
        mysql_select_db($db);
        return $link;
      }       
    }
// create new PDF document
$nombreTitulo=$idLote."_".$noFormato;
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
  
// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('IQElectronics');
$pdf->SetTitle($nombreTitulo);
$pdf->SetSubject('IQElectronics');
$pdf->SetKeywords($idLote,$noFormato);

// set default header data
//$pdf->SetHeaderData($pdf->writeHTML($tablaHead));
$pdf->SetHeaderData(PDF_HEADER_LOGO);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
  $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/spa.php')) {
    require_once(dirname(__FILE__).'/lang/spa.php');
    $pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set font
$pdf->SetFont('helvetica', 'B', 20);

// add a page
$pdf->AddPage();

//$pdf->Write(0, 'Example of HTML tables', true,  false, false, true, '');

$pdf->SetFont('helvetica', '', 8);

// -----------------------------------------------------------------------------
//$idProyecto=2;
$conRep="SELECT * FROM CAT_codigoReparacion WHERE id_proyecto='".$idProyecto."'";
$execRe=mysql_query($conRep,conectarBd());
$noReg=mysql_num_rows($execRe);
//print($noReg);
//<link rel='stylesheet' type='text/css' media='all' href='../css/estilos.css' />
$tbPag=<<<EOF
<style>
#encabezado{
  background: #CCC;
  border:1px solid #000;
  color:#000;
  font-size:12px;
}
.tab{
  border:1px solid #000;
  font-size: 12px;

}
.tab tr{
  border: 1px solid #000;
}
.tab td{
  border: 1px solid #000;
  text-align: center;
  color: #000;
}
.tab th {
  background-color:#CCC;
  border:1px solid #000;
  color:#151950;
  font-size:12px;
  text-align:center;
}
.codP{
  color:#000;
  font-size:14px;
  text-width:bold;
}
</style>
<br><p class="codP">1.- CÓDIGOS DE REPARACIÓN</p>
<br>
<table align="center" class="tab"><tr id="encabezado"><th>CÓDIGO</th><th>DESCRIPCIÓN</th></tr>
EOF;
if($noReg==0){
  $tabla=<<<EOF
<p style="text-align:center; font-width:bold;">NO HAY REGISTROS POR EL MOMENTO</p>
EOF;
}else{

  while($rowCRep=mysql_fetch_array($execRe)){
    $mas="<tr><td>".$rowCRep['codigo_reparacion']."</td><td>".strtoupper(utf8_encode($rowCRep['descripcion']))."</td><td>".$obs."</td></tr>";
    $tbPag=$tbPag.$mas;
  }
  $tbPag=<<<EOD
$tbPag </table>
EOD;
$tabla=$tbPag;
}
$pdf->writeHTML($tabla, true, false, false, false,'');

$pdf->AddPage();

// -----------------------------------------------------------------------------

//Close and output PDF document
$pdf->Output($nombreTitulo, 'I');

//============================================================+
// END OF FILE
//============================================================+
