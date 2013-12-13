<?php
   include_once('grafico_pruebas_funcionales_session.php');
   session_start();
    $Ord_Cmp = new grafico_pruebas_funcionales_Ord_cmp(); 
    $Ord_Cmp->Ord_cmp_init();
   
class grafico_pruebas_funcionales_Ord_cmp
{
function Ord_cmp_init()
{
  global $sc_init, $path_img, $path_btn, $tab_ger_campos, $tab_def_campos, $tab_converte, $_POST, $_GET;
   if (isset($_POST['script_case_init']))
   {
       $sc_init    = $_POST['script_case_init'];
       $path_img   = $_POST['path_img'];
       $path_btn   = $_POST['path_btn'];
       $use_alias  = (isset($_POST['use_alias']))  ? $_POST['use_alias']  : "S";
       $fsel_ok    = (isset($_POST['fsel_ok']))    ? $_POST['fsel_ok']    : "";
       $campos_sel = (isset($_POST['campos_sel'])) ? $_POST['campos_sel'] : "";
       $sel_regra  = (isset($_POST['sel_regra']))  ? $_POST['sel_regra']  : "";
   }
   elseif (isset($_GET['script_case_init']))
   {
       $sc_init    = $_GET['script_case_init'];
       $path_img   = $_GET['path_img'];
       $path_btn   = $_GET['path_btn'];
       $use_alias  = (isset($_GET['use_alias']))  ? $_GET['use_alias']  : "S";
       $fsel_ok    = (isset($_GET['fsel_ok']))    ? $_GET['fsel_ok']    : "";
       $campos_sel = (isset($_GET['campos_sel'])) ? $_GET['campos_sel'] : "";
       $sel_regra  = (isset($_GET['sel_regra']))  ? $_GET['sel_regra']  : "";
   }
   
   $tab_ger_campos = array();
   $tab_def_campos = array();
   $tab_ger_campos['ot_id'] = "on";
   if ($use_alias == "S")
   {
       $tab_def_campos['ot_id'] = "ot_id";
       $tab_converte["ot_id"]   = "ot_id";
   }
   else
   {
       $tab_def_campos['ot_id'] = "ot.id";
       $tab_converte["ot.id"]   = "ot_id";
   }
   $tab_ger_campos['ot_ot'] = "on";
   if ($use_alias == "S")
   {
       $tab_def_campos['ot_ot'] = "ot_ot";
       $tab_converte["ot_ot"]   = "ot_ot";
   }
   else
   {
       $tab_def_campos['ot_ot'] = "ot.ot";
       $tab_converte["ot.ot"]   = "ot_ot";
   }
   $tab_ger_campos['ot_idp'] = "on";
   if ($use_alias == "S")
   {
       $tab_def_campos['ot_idp'] = "ot_idp";
       $tab_converte["ot_idp"]   = "ot_idp";
   }
   else
   {
       $tab_def_campos['ot_idp'] = "ot.idp";
       $tab_converte["ot.idp"]   = "ot_idp";
   }
   $tab_ger_campos['ot_nserie'] = "on";
   if ($use_alias == "S")
   {
       $tab_def_campos['ot_nserie'] = "ot_nserie";
       $tab_converte["ot_nserie"]   = "ot_nserie";
   }
   else
   {
       $tab_def_campos['ot_nserie'] = "ot.nserie";
       $tab_converte["ot.nserie"]   = "ot_nserie";
   }
   $tab_ger_campos['ot_u_recibe'] = "on";
   if ($use_alias == "S")
   {
       $tab_def_campos['ot_u_recibe'] = "ot_u_recibe";
       $tab_converte["ot_u_recibe"]   = "ot_u_recibe";
   }
   else
   {
       $tab_def_campos['ot_u_recibe'] = "ot.u_recibe";
       $tab_converte["ot.u_recibe"]   = "ot_u_recibe";
   }
   $tab_ger_campos['ot_f_recibo'] = "on";
   if ($use_alias == "S")
   {
       $tab_def_campos['ot_f_recibo'] = "ot_f_recibo";
       $tab_converte["ot_f_recibo"]   = "ot_f_recibo";
   }
   else
   {
       $tab_def_campos['ot_f_recibo'] = "ot.f_recibo";
       $tab_converte["ot.f_recibo"]   = "ot_f_recibo";
   }
   $tab_ger_campos['ot_fecha_fin'] = "on";
   if ($use_alias == "S")
   {
       $tab_def_campos['ot_fecha_fin'] = "ot_fecha_fin";
       $tab_converte["ot_fecha_fin"]   = "ot_fecha_fin";
   }
   else
   {
       $tab_def_campos['ot_fecha_fin'] = "ot.fecha_fin";
       $tab_converte["ot.fecha_fin"]   = "ot_fecha_fin";
   }
   $tab_ger_campos['ot_fecha_fin_rep'] = "on";
   if ($use_alias == "S")
   {
       $tab_def_campos['ot_fecha_fin_rep'] = "ot_fecha_fin_rep";
       $tab_converte["ot_fecha_fin_rep"]   = "ot_fecha_fin_rep";
   }
   else
   {
       $tab_def_campos['ot_fecha_fin_rep'] = "ot.fecha_fin_rep";
       $tab_converte["ot.fecha_fin_rep"]   = "ot_fecha_fin_rep";
   }
   $tab_ger_campos['ot_status_proceso'] = "on";
   if ($use_alias == "S")
   {
       $tab_def_campos['ot_status_proceso'] = "ot_status_proceso";
       $tab_converte["ot_status_proceso"]   = "ot_status_proceso";
   }
   else
   {
       $tab_def_campos['ot_status_proceso'] = "ot.status_proceso";
       $tab_converte["ot.status_proceso"]   = "ot_status_proceso";
   }
   $tab_ger_campos['ot_status_cliente'] = "on";
   if ($use_alias == "S")
   {
       $tab_def_campos['ot_status_cliente'] = "ot_status_cliente";
       $tab_converte["ot_status_cliente"]   = "ot_status_cliente";
   }
   else
   {
       $tab_def_campos['ot_status_cliente'] = "ot.status_cliente";
       $tab_converte["ot.status_cliente"]   = "ot_status_cliente";
   }
   $tab_ger_campos['ot_shipdate'] = "on";
   if ($use_alias == "S")
   {
       $tab_def_campos['ot_shipdate'] = "ot_shipdate";
       $tab_converte["ot_shipdate"]   = "ot_shipdate";
   }
   else
   {
       $tab_def_campos['ot_shipdate'] = "ot.shipdate";
       $tab_converte["ot.shipdate"]   = "ot_shipdate";
   }
   $tab_ger_campos['tipoalmacen_almacen'] = "on";
   if ($use_alias == "S")
   {
       $tab_def_campos['tipoalmacen_almacen'] = "tipoalmacen_almacen";
       $tab_converte["tipoalmacen_almacen"]   = "tipoalmacen_almacen";
   }
   else
   {
       $tab_def_campos['tipoalmacen_almacen'] = "tipoalmacen.almacen";
       $tab_converte["tipoalmacen.almacen"]   = "tipoalmacen_almacen";
   }
   $tab_ger_campos['cat_pruebas_funcionales_descripcion'] = "on";
   if ($use_alias == "S")
   {
       $tab_def_campos['cat_pruebas_funcionales_descripcion'] = "cmp_maior_30_1";
       $tab_converte["cmp_maior_30_1"]   = "cat_pruebas_funcionales_descripcion";
   }
   else
   {
       $tab_def_campos['cat_pruebas_funcionales_descripcion'] = "cat_pruebas_funcionales.descripcion";
       $tab_converte["cat_pruebas_funcionales.descripcion"]   = "cat_pruebas_funcionales_descripcion";
   }
   if (isset($_SESSION['scriptcase']['sc_apl_conf']['grafico_pruebas_funcionales']['field_display']) && !empty($_SESSION['scriptcase']['sc_apl_conf']['grafico_pruebas_funcionales']['field_display']))
   {
       foreach ($_SESSION['scriptcase']['sc_apl_conf']['grafico_pruebas_funcionales']['field_display'] as $NM_cada_field => $NM_cada_opc)
       {
           if ($NM_cada_opc == "off")
           {
              $tab_ger_campos[$NM_cada_field] = "none";
           }
       }
   }
   if (isset($_SESSION['sc_session'][$sc_init]['grafico_pruebas_funcionales']['php_cmp_sel']) && !empty($_SESSION['sc_session'][$sc_init]['grafico_pruebas_funcionales']['php_cmp_sel']))
   {
       foreach ($_SESSION['sc_session'][$sc_init]['grafico_pruebas_funcionales']['php_cmp_sel'] as $NM_cada_field => $NM_cada_opc)
       {
           if ($NM_cada_opc == "off")
           {
              $tab_ger_campos[$NM_cada_field] = "none";
           }
       }
   }
   if (!isset($_SESSION['sc_session'][$sc_init]['grafico_pruebas_funcionales']['ordem_select']))
   {
       $_SESSION['sc_session'][$sc_init]['grafico_pruebas_funcionales']['ordem_select'] = array();
   }
   
   if ($fsel_ok == "cmp" && !empty($campos_sel))
   {
       $this->Sel_processa_out_sel($campos_sel);
   }
   else
   {
       $this->Sel_processa_form();
   }
   exit;
   
}
function Sel_processa_out_sel($campos_sel)
{
   global $tab_ger_campos, $sc_init, $tab_def_campos;
   $arr_temp = array();
   $campos_sel = explode("@?@", $campos_sel);
   $_SESSION['sc_session'][$sc_init]['grafico_pruebas_funcionales']['ordem_select'] = array();
   $_SESSION['sc_session'][$sc_init]['grafico_pruebas_funcionales']['ordem_grid']   = "";
   $_SESSION['sc_session'][$sc_init]['grafico_pruebas_funcionales']['ordem_cmp']    = "";
   foreach ($campos_sel as $campo_sort)
   {
       $ordem = (substr($campo_sort, 0, 1) == "+") ? "asc" : "desc";
       $campo = substr($campo_sort, 1);
       $_SESSION['sc_session'][$sc_init]['grafico_pruebas_funcionales']['ordem_select'][$campo] = $ordem;
   }
?>
    <script language="javascript"> 
      self.parent.tb_remove(); 
      parent.nm_gp_move('inicio', '0'); 
   </script>
<?php
}
   
function Sel_processa_form()
{
  global $sc_init, $path_img, $path_btn, $tab_ger_campos, $tab_def_campos, $tab_converte;
   $size = 10;
   $STR_lang    = (isset($_SESSION['scriptcase']['str_lang']) && !empty($_SESSION['scriptcase']['str_lang'])) ? $_SESSION['scriptcase']['str_lang'] : "es";
   $NM_arq_lang = "../_lib/lang/" . $STR_lang . ".lang.php";
   if (!function_exists("NM_is_utf8"))
   {
       include_once("grafico_pruebas_funcionales_nmutf8.php");
   }
   $this->Nm_lang = array();
   if (is_file($NM_arq_lang))
   {
       include_once($NM_arq_lang);
   }
   $_SESSION['scriptcase']['charset']  = (isset($this->Nm_lang['Nm_charset']) && !empty($this->Nm_lang['Nm_charset'])) ? $this->Nm_lang['Nm_charset'] : "ISO-8859-15";
   foreach ($this->Nm_lang as $ind => $dados)
   {
      if ($_SESSION['scriptcase']['charset'] != "UTF-8" && NM_is_utf8($ind))
      {
          $ind = mb_convert_encoding($ind, $_SESSION['scriptcase']['charset'], "UTF-8");
          $this->Nm_lang[$ind] = $dados;
      }
      if ($_SESSION['scriptcase']['charset'] != "UTF-8" && NM_is_utf8($dados))
      {
          $this->Nm_lang[$ind] = mb_convert_encoding($dados, $_SESSION['scriptcase']['charset'], "UTF-8");
      }
   }
   $str_schema_all = (isset($_SESSION['scriptcase']['str_schema_all']) && !empty($_SESSION['scriptcase']['str_schema_all'])) ? $_SESSION['scriptcase']['str_schema_all'] : "Scriptcase7_BlueSky/Scriptcase7_BlueSky";
   include("../_lib/css/" . $str_schema_all . "_grid.php");
   $Str_btn_grid = trim($str_button) . "/" . trim($str_button) . ".php";
   include("../_lib/buttons/" . $Str_btn_grid);
   if (!function_exists("nmButtonOutput"))
   {
       include_once("../_lib/lib/php/nm_gp_config_btn.php");
   }
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
            "http://www.w3.org/TR/1999/REC-html401-19991224/loose.dtd">
<HTML<?php echo $_SESSION['scriptcase']['reg_conf']['html_dir'] ?>>
<HEAD>
 <TITLE><?php echo $this->Nm_lang['lang_othr_grid_titl'] ?> - ot</TITLE>
 <META http-equiv="Content-Type" content="text/html; charset=<?php echo $_SESSION['scriptcase']['charset_html'] ?>" />
 <META http-equiv="Expires" content="Fri, Jan 01 1900 00:00:00 GMT"/>
 <META http-equiv="Last-Modified" content="<?php echo gmdate("D, d M Y H:i:s"); ?> GMT"/>
 <META http-equiv="Cache-Control" content="no-store, no-cache, must-revalidate"/>
 <META http-equiv="Cache-Control" content="post-check=0, pre-check=0"/>
 <META http-equiv="Pragma" content="no-cache"/>
 <link rel="stylesheet" type="text/css" href="../_lib/css/<?php echo $_SESSION['scriptcase']['css_popup'] ?>" /> 
 <link rel="stylesheet" type="text/css" href="../_lib/buttons/<?php echo $_SESSION['scriptcase']['css_btn_popup'] ?>" /> 
</HEAD>
<BODY class="scGridPage" style="margin: 0px; overflow-x: hidden">
<script language="javascript" type="text/javascript" src="<?php echo $_SESSION['sc_session']['path_third'] ?>/jquery/js/jquery.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo $_SESSION['sc_session']['path_third'] ?>/tigra_color_picker/picker.js"></script>
<script language="javascript"> 
 var nm_quant_pack;
 // Adiciona um elemento
 //----------------------
 function nm_add_sel(sOrig, sDest, Saida)
 {
  // Recupera objetos
  oOrig = document.Fsel.elements[sOrig];
  oDest = document.Fsel.elements[sDest];
  // Varre itens da origem
  for (i = 0; i < oOrig.length; i++)
  {
   // Item na origem selecionado e valido
   if (oOrig.options[i].selected && !oOrig.options[i].disabled)
   {
    // Recupera valores da origem
    sText  = '+' + oOrig.options[i].text;
    sValue = '+' + oOrig.options[i].value;
    // Cria item no destino
    oDest.options[oDest.length] = new Option(sText, sValue);
    // Desabilita item na origem
    oOrig.options[i].style.color = "#A0A0A0";
    oOrig.options[i].disabled    = true;
    oOrig.options[i].selected    = false;
   }
  }
  // Reset combos
  oOrig.selectedIndex = -1;
  oDest.selectedIndex = -1;
  ajusta_window();
  if (Saida == "S")
  {
      document.Fsel.submit();
  }
 }
 // Adiciona todos os elementos
 //-----------------------------
 function nm_add_all(sOrig, sDest, Saida)
 {
  // Recupera objetos
  oOrig = document.Fsel.elements[sOrig];
  oDest = document.Fsel.elements[sDest];
  // Varre itens da origem
  for (i = 0; i < oOrig.length; i++)
  {
   // Item na origem valido
   if (!oOrig.options[i].disabled)
   {
    // Recupera valores da origem
    sText  = '+' + oOrig.options[i].text;
    sValue = '+' + oOrig.options[i].value;
    // Cria item no destino
    oDest.options[oDest.length] = new Option(sText, sValue);
    // Desabilita item na origem
    oOrig.options[i].style.color = "#A0A0A0";
    oOrig.options[i].disabled    = true;
    oOrig.options[i].selected    = false;
   }
  }
  // Reset combos
  oOrig.selectedIndex = -1;
  oDest.selectedIndex = -1;
  ajusta_window();
  if (Saida == "S")
  {
      document.Fsel.submit();
  }
 }
 // Remove um elemento
 //--------------------
 function nm_del_sel(sOrig, sDest, Saida)
 {
  // Recupera objetos
  oOrig = document.Fsel.elements[sOrig];
  oDest = document.Fsel.elements[sDest];
  aSel  = new Array();
  atxt  = new Array();
  solt  = new Array();
  j     = 0;
  z     = 0;
  // Remove itens selecionados na origem
  for (i = oOrig.length - 1; i >= 0; i--)
  {
   // Item na origem selecionado
   if (oOrig.options[i].selected)
   {
    aSel[j] = oOrig.options[i].value.substring(1);
    atxt[j] = oOrig.options[i].text.substring(1);
    j++;
    oOrig.options[i] = null;
   }
  }
  // Habilita itens no destino
  for (i = 0; i < oDest.length; i++)
  {
   if (oDest.options[i].disabled && in_array(aSel, oDest.options[i].value))
   {
    oDest.options[i].disabled    = false;
    oDest.options[i].style.color = "";
    solt[z] = oDest.options[i].value;
    z++;
   }
  }
  for (i = 0; i < aSel.length; i++)
  {
   if (!in_array(solt, aSel[i]))
   {
    oDest.options[oDest.length] = new Option(atxt[i], aSel[i]);
   }
  }
  // Reset combos
  oOrig.selectedIndex = -1;
  oDest.selectedIndex = -1;
  ajusta_window();
  if (Saida == "S")
  {
      document.Fsel.submit();
  }
 }
 // Remove todos os elementos
 //---------------------------
 function nm_del_all(sOrig, sDest, Saida)
 {
  // Recupera objetos
  oOrig = document.Fsel.elements[sOrig];
  oDest = document.Fsel.elements[sDest];
  aSel  = new Array();
  atxt  = new Array();
  solt  = new Array();
  j     = 0;
  z     = 0;
  // Remove todos os itens na origem
  while (0 < oOrig.length)
  {
   i       = oOrig.length - 1;
   aSel[j] = oOrig.options[i].value.substring(1);
   atxt[j] = oOrig.options[i].text.substring(1);
   j++;
   oOrig.options[i] = null;
  }
  // Habilita itens no destino
  for (i = 0; i < oDest.length; i++)
  {
   if (oDest.options[i].disabled && in_array(aSel, oDest.options[i].value))
   {
    oDest.options[i].disabled    = false;
    oDest.options[i].style.color = "";
    solt[z] = oDest.options[i].value;
    z++;
   }
  }
  for (i = 0; i < aSel.length; i++)
  {
   if (!in_array(solt, aSel[i]))
   {
    oDest.options[oDest.length] = new Option(atxt[i], aSel[i]);
   }
  }
  // Reset combos
  oOrig.selectedIndex = -1;
  oDest.selectedIndex = -1;
  ajusta_window();
  if (Saida == "S")
  {
      document.Fsel.submit();
  }
 }
 function nm_pack(sOrig, sDest)
 {
    obj_sel = document.Fsel.elements[sOrig];
    str_val = "";
    nm_quant_pack = 0;
    for (i = 0; i < obj_sel.length; i++)
    {
         if ("" != str_val)
         {
             str_val += "@?@";
             nm_quant_pack++;
         }
         str_val += obj_sel.options[i].value;
    }
    document.Fsel.elements[sDest].value = str_val;
 }
 // Teste se elemento pertence ao array
 //-------------------------------------
 function in_array(aArray, sElem)
 {
  for (iCount = 0; iCount < aArray.length; iCount++)
  {
   if (sElem == aArray[iCount])
   {
    return true;
   }
  }
  return false;
 }
 // Submeter o formularior
 //-------------------------------------
 function submit_form()
 {
      nm_pack('sel_dest', 'campos_sel');
      document.Fsel.submit();
 }
 // Mover para cima
 //-------------------------------------
 function nm_move_fld_up (v_str_form, v_str_field)
 {
     obj_sel = document.forms[v_str_form].elements[v_str_field];
     for (i = 1; i < obj_sel.length; i++)
     {
         if ((null != obj_sel.options[i]) && obj_sel.options[i].selected && !obj_sel.options[i - 1].selected)
         {
             bol_sel                         = obj_sel.options[i - 1].selected;
             str_txt                         = obj_sel.options[i].text;
             str_val                         = obj_sel.options[i].value;
             obj_sel.options[i].text         = obj_sel.options[i - 1].text;
             obj_sel.options[i].value        = obj_sel.options[i - 1].value;
             obj_sel.options[i - 1].text     = str_txt;
             obj_sel.options[i - 1].value    = str_val;
             obj_sel.options[i].selected     = bol_sel;
             obj_sel.options[i - 1].selected = true;
         }
     }
 }
 // Mover para baixo
 //-------------------------------------
 function nm_move_fld_down(v_str_form, v_str_field)
 {
     obj_sel = document.forms[v_str_form].elements[v_str_field];
     nm_field_release_blocks(obj_sel);
     if (1 < obj_sel.length)
     {
        for (i = (obj_sel.length - 2); i >= 0; i--)
        {
            if ((null != obj_sel.options[i]) && obj_sel.options[i].selected && !obj_sel.options[i + 1].selected)
            {
                bol_sel                         = obj_sel.options[i + 1].selected;
                str_txt                         = obj_sel.options[i].text;
                str_val                         = obj_sel.options[i].value;
                obj_sel.options[i].text         = obj_sel.options[i + 1].text;
                obj_sel.options[i].value        = obj_sel.options[i + 1].value;
                obj_sel.options[i + 1].text     = str_txt;
                obj_sel.options[i + 1].value    = str_val;
                obj_sel.options[i].selected     = bol_sel;
                obj_sel.options[i + 1].selected = true;
            }
        }
     }
 }
 // Ordem Ascendente
 //-------------------------------------
 function nm_order_asc()
 {
     obj_sel = document.forms['Fsel'].elements['sel_dest'];
     if (obj_sel.selectedIndex == -1)
     {
         return;
     }
     index   = obj_sel.selectedIndex;
     obj_sel.options[index].text  = "+" + obj_sel.options[index].text.substring(1);
     obj_sel.options[index].value = "+" + obj_sel.options[index].value.substring(1);
 }
 // Ordem Descendente
 //-------------------------------------
 function nm_order_desc()
 {
     obj_sel = document.forms['Fsel'].elements['sel_dest'];
     if (obj_sel.selectedIndex == -1)
     {
         return;
     }
     index   = obj_sel.selectedIndex;
     obj_sel.options[index].text  = "-" + obj_sel.options[index].text.substring(1);
     obj_sel.options[index].value = "-" + obj_sel.options[index].value.substring(1);
 }
 // Marca objeto radio
 //-------------------------------------
 function nm_marca_radio()
 {
     obj_sel = document.forms['Fsel'].elements['sel_dest'];
     index   = obj_sel.selectedIndex;
     str_txt = obj_sel.options[index].text.substring(0, 1);
     document.forms['Fsel'].elements['muda_ord'][(str_txt == '-') ? 1 : 0].checked = true;
 }
 </script>
<FORM name="Fsel" method="POST">
  <INPUT type="hidden" name="script_case_init" value="<?php echo NM_encode_input($sc_init); ?>"> 
  <INPUT type="hidden" name="script_case_session" value="<?php echo NM_encode_input(session_id()); ?>"> 
  <INPUT type="hidden" name="path_img" value="<?php echo NM_encode_input($path_img); ?>"> 
  <INPUT type="hidden" name="path_btn" value="<?php echo NM_encode_input($path_btn); ?>"> 
  <INPUT type="hidden" name="fsel_ok" value=""> 
<?php
if ($_SESSION['scriptcase']['reg_conf']['html_dir'] == " DIR='RTL'")
{
    echo "<table class=\"scGridBorder\" id=\"main_table\" style=\"position: relative; top: 20px; right: 20px\">";
}
else
{
    echo "<table class=\"scGridBorder\" id=\"main_table\" style=\"position: relative; top: 20px; left: 20px\">";
}
?>
 <tr>
  <td class="scGridTabelaTd">
   <table class="scGridTabela">
    <tr>
     <td class="scGridLabelVert"  colspan=5 align="center" >
        <?php echo $this->Nm_lang['lang_btns_sort_hint']; ?>
     </td>
     </tr>
   <tr class="scGridFieldOddVert"><td>
    <select class="css_toolbar_obj" name="sel_orig" size=<?php echo $size; ?> multiple onDblClick="nm_add_sel('sel_orig', 'sel_dest', 'N')">
<?php
   foreach ($tab_ger_campos as $NM_cada_field => $NM_cada_opc)
   {
       if ($NM_cada_opc != "none")
       {
           if (isset($_SESSION['sc_session'][$sc_init]['grafico_pruebas_funcionales']['ordem_select'][$tab_def_campos[$NM_cada_field]]))
           {
               $tmp_sel = " disabled =\"disabled\" style=\"color: #A0A0A0\"" ;
           }
           else
           {
               $tmp_sel = "selected";
           }
?>
       <OPTION value="<?php echo NM_encode_input($tab_def_campos[$NM_cada_field]); ?>" <?php echo $tmp_sel; ?>><?php echo $_SESSION['sc_session'][$sc_init]['grafico_pruebas_funcionales']['labels'][$NM_cada_field]; ?></OPTION>
<?php
       }
   }
?>
    </select>
   </td>
   <td align="center">
     <INPUT TYPE="image" SRC="<?php echo $path_img; ?>/img_move_right_all.gif" ALIGN="absmiddle" onClick="nm_add_all('sel_orig', 'sel_dest', 'N'); return false;"><br />
     <INPUT TYPE="image" SRC="<?php echo $path_img; ?>/img_move_right.gif" ALIGN="absmiddle" onClick="nm_add_sel('sel_orig', 'sel_dest', 'N'); return false;"><br />
     <INPUT TYPE="image" SRC="<?php echo $path_img; ?>/img_move_left.gif" ALIGN="absmiddle" onClick="nm_del_sel('sel_dest', 'sel_orig', 'N'); return false;"><br />
     <INPUT TYPE="image" SRC="<?php echo $path_img; ?>/img_move_left_all.gif" ALIGN="absmiddle" onClick="nm_del_all('sel_dest', 'sel_orig', 'N'); return false;"><br />
   </td>
   <td>
    <select class="css_toolbar_obj" name="sel_dest" size=<?php echo $size; ?>  multiple onDblClick="nm_del_sel('sel_dest', 'sel_orig', 'N')" onChange="nm_marca_radio(); ajusta_window();">
<?php
   foreach ($_SESSION['sc_session'][$sc_init]['grafico_pruebas_funcionales']['ordem_select'] as $NM_cada_field => $NM_cada_opc)
   {
       if (isset($tab_converte[$NM_cada_field]))
       {
           $class = "+";
           if ($NM_cada_opc == "desc")
           {
               $class = "-";
           }
?>
             <OPTION value="<?php echo NM_encode_input($class . $NM_cada_field); ?>" selected><?php echo $class . $_SESSION['sc_session'][$sc_init]['grafico_pruebas_funcionales']['labels'][$tab_converte[$NM_cada_field]]; ?></OPTION>
<?php
       }
   }
?>
    </select>
    <input type="hidden" name="campos_sel" value="">
   </td>
   <td align="center">
     <INPUT TYPE="image" SRC="<?php echo $path_img; ?>/img_move_up.gif" ALIGN="absmiddle" onClick="nm_move_fld_up ('Fsel', 'sel_dest'); return false;"><br />
     <INPUT TYPE="image" SRC="<?php echo $path_img; ?>/img_move_down.gif" ALIGN="absmiddle" onClick="nm_move_fld_down ('Fsel', 'sel_dest'); return false;"><br />
   </td>
   <td align="center">
    <table><tr class="scGridFieldOddVert"><td  style="padding:0px; spacing:0px;">
     <input class="css_toolbar_obj" type="radio" name="muda_ord" value="asc" onClick="nm_order_asc ();">ASC<br />
     <input class="css_toolbar_obj" type="radio" name="muda_ord" value="desc" onClick="nm_order_desc ();">DESC<br />
    </td></tr></table>
   </td>
   </tr>
   <tr class="scGridToolbar"><td colspan=5 align="center">
   <?php echo nmButtonOutput($this->arr_buttons, "bok", "document.Fsel.fsel_ok.value='cmp';submit_form()", "document.Fsel.fsel_ok.value='cmp';submit_form()", "f_sel_sub", "", "", "", "absmiddle", "", "0px", $path_btn, "", "", "", "", "", "only_text", "text_right", "", "");
?>
  &nbsp;&nbsp;&nbsp
   <?php echo nmButtonOutput($this->arr_buttons, "bsair", "self.parent.tb_remove()", "self.parent.tb_remove()", "Bsair", "", "", "", "absmiddle", "", "0px", $path_btn, "", "", "", "", "", "only_text", "text_right", "", "");
?>
   </td></tr>
   </table>
  </td>
 </tr>
</table>
</FORM>
<script language="javascript"> 
var bFixed = false;
$(function() {
  document.Fsel.sel_orig.selectedIndex = -1;
  document.Fsel.sel_dest.selectedIndex = -1;
  ajusta_window();
});
function ajusta_window()
{
  var mt = $(document.getElementById("main_table"));
  if (0 == mt.width() || 0 == mt.height())
  {
    setTimeout("ajusta_window()", 50);
    return;
  }
  else if(!bFixed)
  {
    var oOrig = $(document.Fsel.sel_orig),
        oDest = $(document.Fsel.sel_dest),
        mHeight = Math.max(oOrig.height(), oDest.height()),
        mWidth = Math.max(oOrig.width() + 5, oDest.width() + 5);
    oOrig.height(mHeight);
    oOrig.width(mWidth);
    oDest.height(mHeight);
    oDest.width(mWidth + 15);
    bFixed = true;
    if (navigator.userAgent.indexOf("Chrome/") > 0)
    {
      self.parent.tb_resize(mt.height() + 40, mt.width() + 40);
      setTimeout("ajusta_window()", 50);
      return;
    }
  }
  self.parent.tb_resize(mt.height() + 40, mt.width() + 40);
}
</script>
</BODY>
</HTML>
<?php
}
}
