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
$ubicaSRC=dirname(__FILE__)."../../images/iqe.jpeg";
$tablaHead=<<<EOD
<table>
<table border=1 style="width:100%;">
<tr>
<td rowspan=2><img src="$ubicaSRC"></td>
</tr>
<tr>
<td>Revisión: 01 Fecha: 08/05/13</td>
<td>Clave: <?=$noFormato;?></td>
</tr>
</tr>
</table>
EOD;
//$pdf->SetHeaderData($pdf->writeHTML($tablaHead));
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

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

$CON="SELECT * FROM detalle_lotes WHERE id_lote='".$idLote."' and status='Empaque'";
$exeCon=mysql_query($CON,conectarBd());
$noReg=mysql_num_rows($exeCon);
$i=1;
//<link rel='stylesheet' type='text/css' media='all' href='../css/estilos.css' />
$tbPag=<<<EOF
<style>
#encabezado{
  background: #CCC;
  border:1px solid #000;
  color:#151950;
  font-size:12px;
}
.tab{
  //width:100%;
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
.cont{
  position:relative;
  height:100%; 
  width:100%; 
  margin:0px; 
  background-color:#fff;
  border:1px solid #000;

}
.tabla1{
  float:left;
  width:60%;
  height:80%;
  margin:5px;
  padding:5px;
  color:#0000ff;
  border: 1px solid #000;
  background-color:#ff0000;
}
.otroT{
  float:left;
  width:30%;
  height:80%;
  margin:5px;
  padding:5px;
  background-color:#0ff0ff;
}
</style>

<div class="cont"><div align="left" class="tabla1"><table class="tab"><tr id="encabezado"><th>#</th><th>FLOWTAG</th><th>Descripción</th><th>Número de Parte</th><th>Número de serie</th><th>Obs.</th></tr>
EOF;
if($noReg==0){
  $tabla=<<<EOF
<p style="text-align:center; font-width:bold;">NO HAY REGISTROS POR EL MOMENTO</p>
EOF;
}else{
  while($rowDe=mysql_fetch_array($exeCon)){
    $Condes="SELECT * from CAT_SENC where id_SENC='".$rowDe['id_Senc']."'";
    $exeSEN=mysql_query($Condes,conectarBd());
    $rowSENC=mysql_fetch_array($exeSEN);
    $desc=substr($rowSENC[4],0,15)."...";
    $noParte=$rowSENC[2];
   //print($rowSENC[2]."<br>");
   //exit;
    if($rowDe['observaciones']==""){
      $obs="--";
    }else{
      $obs=$rowDe['observaciones'];
    }
    $mas="<tr><td>".$i."</td><td>".$rowDe['flowTag']."</td><td>".$desc."</td><td>".$noParte."</td><td>".$rowDe['numSerie']."</td><td>".$obs."</td></tr>";
    $tbPag=$tbPag.$mas;
    $i++;
  }
  $tbPag=<<<EOD
$tbPag </table>
</div><div align="right" class="otroT">**</div></div>
EOD;
$tabla=$tbPag;
//print($tabla);
}
//$pdf->writeHTML($css,true,false,false,false,'');
$pdf->writeHTML($tabla, true, false, false, false,'');

// -----------------------------------------------------------------------------

//Close and output PDF document
$pdf->Output($nombreTitulo, 'I');

//============================================================+
// END OF FILE
//============================================================+
