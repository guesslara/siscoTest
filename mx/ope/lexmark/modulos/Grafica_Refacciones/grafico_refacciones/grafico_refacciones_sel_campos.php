<?php
   include_once('grafico_refacciones_session.php');
   session_start();
    if (!function_exists("NM_is_utf8"))
    {
        include_once("grafico_refacciones_nmutf8.php");
    }
    $Sel_Cmp = new grafico_refacciones_sel_cmp(); 
    $Sel_Cmp->Sel_cmp_init();
   
class grafico_refacciones_sel_cmp
{
function Sel_cmp_init()
{
   global $tab_ger_campos, $_POST, $_GET;
   $this->proc_ajax = false;
   if (isset($_POST['script_case_init']))
   {
       $this->sc_init     = $_POST['script_case_init'];
       $this->path_img    = $_POST['path_img'];
       $this->path_btn    = $_POST['path_btn'];
       $this->path_fields = $_POST['path_fields'];
   }
   elseif (isset($_GET['script_case_init']))
   {
       $this->sc_init     = $_GET['script_case_init'];
       $this->path_img    = $_GET['path_img'];
       $this->path_btn    = $_GET['path_btn'];
       $this->path_fields = $_GET['path_fields'];
   }
   if (isset($_POST['ajax_ctrl']) && $_POST['ajax_ctrl'] == "proc_ajax")
   {
       $this->proc_ajax = true;
   }
   $this->curr_fields = "";
   $this->ajax_return = array();
   $this->campos_sel  = isset($_POST['campos_sel']) ? $_POST['campos_sel'] : array();
   
   $tab_ger_campos = array();
   $tab_ger_campos['ot_id'] = "on";
   $tab_ger_campos['ot_ot'] = "on";
   $tab_ger_campos['ot_idp'] = "on";
   $tab_ger_campos['ot_nserie'] = "on";
   $tab_ger_campos['ot_u_recibe'] = "on";
   $tab_ger_campos['ot_f_recibo'] = "on";
   $tab_ger_campos['ot_fecha_fin'] = "on";
   $tab_ger_campos['ot_fecha_fin_rep'] = "on";
   $tab_ger_campos['ot_num_no_ok'] = "on";
   $tab_ger_campos['ot_status_proceso'] = "on";
   $tab_ger_campos['ot_status_cliente'] = "on";
   $tab_ger_campos['ot_shipdate'] = "on";
   $tab_ger_campos['tipoalmacen_almacen'] = "on";
   $tab_ger_campos['reg_consumo_prods_fecha'] = "on";
   $tab_ger_campos['cat_refacciones_descripcion'] = "on";
   
   if (isset($_POST['fsel_ok']) && $_POST['fsel_ok'] == "default")
   {
       $_SESSION['sc_session'][$this->sc_init]['grafico_refacciones']['field_order'] = $_SESSION['sc_session'][$this->sc_init]['grafico_refacciones']['field_order_orig'];
       unset($_SESSION['sc_session'][$this->sc_init]['grafico_refacciones']['usr_cmp_sel']);
       $_SESSION['sc_session'][$this->sc_init]['grafico_refacciones']['prim_cmp_sel'] = true;
   }
   if (!isset($_SESSION['sc_session'][$this->sc_init]['grafico_refacciones']['prim_cmp_sel']))
   {
       $_SESSION['sc_session'][$this->sc_init]['grafico_refacciones']['prim_cmp_sel'] = true;
   }
   if (isset($_SESSION['scriptcase']['sc_apl_conf']['grafico_refacciones']['field_display']) && !empty($_SESSION['scriptcase']['sc_apl_conf']['grafico_refacciones']['field_display']))
   {
       foreach ($_SESSION['scriptcase']['sc_apl_conf']['grafico_refacciones']['field_display'] as $NM_cada_field => $NM_cada_opc)
       {
           if ($NM_cada_opc == "off")
           {
              $tab_ger_campos[$NM_cada_field] = "none";
           }
       }
   }
   if (isset($_SESSION['sc_session'][$this->sc_init]['grafico_refacciones']['php_cmp_sel']) && !empty($_SESSION['sc_session'][$this->sc_init]['grafico_refacciones']['php_cmp_sel']))
   {
       foreach ($_SESSION['sc_session'][$this->sc_init]['grafico_refacciones']['php_cmp_sel'] as $NM_cada_field => $NM_cada_opc)
       {
           if ($NM_cada_opc == "off")
           {
              $tab_ger_campos[$NM_cada_field] = "none";
           }
       }
   }
   
   if (isset($_SESSION['sc_session'][$this->sc_init]['grafico_refacciones']['usr_cmp_sel']) && !empty($_SESSION['sc_session'][$this->sc_init]['grafico_refacciones']['usr_cmp_sel']))
   {
       foreach ($_SESSION['sc_session'][$this->sc_init]['grafico_refacciones']['usr_cmp_sel'] as $NM_cada_field => $NM_cada_opc)
       {
           $tab_ger_campos[$NM_cada_field] = $NM_cada_opc;
       }
   }
   
   if (isset($_POST['fsel_ok']) && $_POST['fsel_ok'] == "OK" && !empty($this->campos_sel))
   {
       $this->Sel_processa_out();
   }
   else
   {
       $this->Sel_processa_form();
   }
   exit;
   
}

function Sel_processa_out($opt_save=false)
{
   global $tab_ger_campos;
   $arr_temp = array();
   if (!isset($_SESSION['sc_session'][$this->sc_init]['grafico_refacciones']['usr_cmp_sel']))
   {
       $_SESSION['sc_session'][$this->sc_init]['grafico_refacciones']['usr_cmp_sel'] = array();
   }
   $arr_order = $_SESSION['sc_session'][$this->sc_init]['grafico_refacciones']['field_order'];
   $_SESSION['sc_session'][$this->sc_init]['grafico_refacciones']['field_order'] = array();
   $campos_sel = explode("@?@", $this->campos_sel);
   foreach ($campos_sel as $campo_order)
   {
       if (isset($tab_ger_campos[$campo_order]))
       {
           $_SESSION['sc_session'][$this->sc_init]['grafico_refacciones']['field_order'][] = $campo_order;
       }
   }
   foreach ($arr_order as $campo_order)
   {
       if (!in_array($campo_order, $_SESSION['sc_session'][$this->sc_init]['grafico_refacciones']['field_order']))
       {
           $_SESSION['sc_session'][$this->sc_init]['grafico_refacciones']['field_order'][] = $campo_order;
       }
   }
   foreach ($tab_ger_campos as $campo_cons => $opc)
   {
       if (!in_array($campo_cons, $campos_sel) && $opc != "none")
       {
           $arr_temp[$campo_cons] = "off";
       }
   }
   if ($arr_temp !== $_SESSION['sc_session'][$this->sc_init]['grafico_refacciones']['usr_cmp_sel'])
   {
       $_SESSION['sc_session'][$this->sc_init]['grafico_refacciones']['prim_cmp_sel'] = false;
   }
   $_SESSION['sc_session'][$this->sc_init]['grafico_refacciones']['usr_cmp_sel'] = $arr_temp;
   if ($opt_save)
   {
       return;
   }
?>
    <script language="javascript"> 
      self.parent.tb_remove(); 
      parent.nm_gp_move('igual', '0'); 
   </script>
<?php
}
   
function Sel_processa_form()
{
   global $tab_ger_campos;
   if ($this->proc_ajax)
   {
       ob_start();
   }
   $size = 10;
   $STR_lang    = (isset($_SESSION['scriptcase']['str_lang']) && !empty($_SESSION['scriptcase']['str_lang'])) ? $_SESSION['scriptcase']['str_lang'] : "es";
   $NM_arq_lang = "../_lib/lang/" . $STR_lang . ".lang.php";
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
  // Varre itens do destino
  Psel  = false;
  iDest = 0;
  iInit = oDest.length;
  arr_sel = new Array();
  for (i = 0; i < oDest.length; i++)
  {
   if (oDest.options[i].selected && !Psel)
   {
       Psel  = true;
       iInit = i + 1;
   }
   else
   if (Psel)
   {
     arr_sel[iDest] = new Array(oDest.options[i].value, oDest.options[i].text);
     iDest++;
   }
  }
  // Varre itens da origem
  for (i = 0; i < oOrig.length; i++)
  {
   // Item na origem selecionado e valido
   if (oOrig.options[i].selected && !oOrig.options[i].disabled)
   {
    // Recupera valores da origem
    sText  = oOrig.options[i].text;
    sValue = oOrig.options[i].value;
    // Cria item no destino
    oDest.options[iInit] = new Option(sText, sValue);
    // Desabilita item na origem
    oOrig.options[i].style.color = "#A0A0A0";
    oOrig.options[i].disabled    = true;
    oOrig.options[i].selected    = false;
    iInit++;
   }
  }
  // Completa itens do destino
  if (iDest > 0)
  {
   for (i = 0; i < iDest; i++)
   {
     oDest.options[iInit] = new Option();
     oDest.options[iInit].value = arr_sel[i][0];
     oDest.options[iInit].text  = arr_sel[i][1];
     iInit++;
   }
  }
  // Reset combos
  oOrig.selectedIndex = -1;
  oDest.selectedIndex = -1;
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
  // Varre itens do destino
  Psel  = false;
  iDest = 0;
  iInit = oDest.length;
  arr_sel = new Array();
  for (i = 0; i < oDest.length; i++)
  {
   if (oDest.options[i].selected && !Psel)
   {
       Psel  = true;
       iInit = i + 1;
   }
   else
   if (Psel)
   {
     arr_sel[iDest] = new Array(oDest.options[i].value, oDest.options[i].text);
     iDest++;
   }
  }
  // Varre itens da origem
  for (i = 0; i < oOrig.length; i++)
  {
   // Item na origem valido
   if (!oOrig.options[i].disabled)
   {
    // Recupera valores da origem
    sText  = oOrig.options[i].text;
    sValue = oOrig.options[i].value;
    // Cria item no destino
    oDest.options[iInit] = new Option(sText, sValue);
    // Desabilita item na origem
    oOrig.options[i].style.color = "#A0A0A0";
    oOrig.options[i].disabled    = true;
    oOrig.options[i].selected    = false;
    iInit++;
   }
  }
  // Completa itens do destino
  if (iDest > 0)
  {
   for (i = 0; i < iDest; i++)
   {
     oDest.options[iInit] = new Option();
     oDest.options[iInit].value = arr_sel[i][0];
     oDest.options[iInit].text  = arr_sel[i][1];
     iInit++;
   }
  }
  // Reset combos
  oOrig.selectedIndex = -1;
  oDest.selectedIndex = -1;
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
    aSel[j] = oOrig.options[i].value;
    atxt[j] = oOrig.options[i].text;
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
   aSel[j] = oOrig.options[i].value;
   atxt[j] = oOrig.options[i].text;
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
  if (Saida == "S")
  {
      document.Fsel.submit();
  }
 }
 // move elementos para baixo
 //--------------------------
 function nm_move_down(v_str_field)
 {
  obj_sel = document.Fsel.elements[v_str_field];
  if (1 < obj_sel.length)
  {
   for (i = (obj_sel.length - 2); i >= 0; i--)
   {
    if ((null != obj_sel.options[i]) && obj_sel.options[i].selected &&
        !obj_sel.options[i + 1].selected)
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
 // move elementos para cima
 //-------------------------
 function nm_move_up(v_str_field)
 {
  obj_sel = document.Fsel.elements[v_str_field];
  if (1 < obj_sel.length)
  {
   for (i = 1; i < obj_sel.length; i++)
   {
    if ((null != obj_sel.options[i]) && obj_sel.options[i].selected &&
        !obj_sel.options[i - 1].selected)
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
 }
 // empacota elementos selecionados
 //--------------------------------
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
 </script>
<FORM name="Fsel" method="POST">
  <INPUT type="hidden" name="script_case_init" value="<?php echo NM_encode_input($this->sc_init); ?>"> 
  <INPUT type="hidden" name="script_case_session" value="<?php echo NM_encode_input(session_id()); ?>"> 
  <INPUT type="hidden" name="path_img" value="<?php echo NM_encode_input($this->path_img); ?>"> 
  <INPUT type="hidden" name="path_btn" value="<?php echo NM_encode_input($this->path_btn); ?>"> 
  <INPUT type="hidden" name="path_fields" value="<?php echo NM_encode_input($this->path_fields); ?>"> 
  <INPUT type="hidden" name="campos_sel" value="">
  <INPUT type="hidden" name="fsel_ok" value="OK"> 
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
     <td class="scGridLabelVert" colspan=4 align="center">
        <?php echo $this->Nm_lang['lang_btns_clmn_hint']; ?>
     </td>
     </tr>
   <tr class="scGridFieldOddVert"><td id="select_orig">
<?php
   if ($this->proc_ajax)
   {
       ob_end_clean();
       ob_start();
   }
?>
    <select class="css_toolbar_obj" name="sel_orig" size=<?php echo $size; ?> multiple onDblClick="nm_add_sel('sel_orig', 'sel_dest', 'N')">
<?php
   $prep_combo = array();
   foreach ($tab_ger_campos as $NM_cada_field => $NM_cada_opc)
   {
       if ($NM_cada_opc != "none")
       {
           if ($NM_cada_opc == "on")
           {
               $tmp_sel = " disabled =\"disabled\" style=\"color: #A0A0A0\"" ;
           }
           else
           {
               $tmp_sel = "selected";
           }
           $prep_combo[strtolower($_SESSION['sc_session'][$this->sc_init]['grafico_refacciones']['labels'][$NM_cada_field])] = NM_encode_input($NM_cada_field) . '" ' . $tmp_sel . '>' . $_SESSION['sc_session'][$this->sc_init]['grafico_refacciones']['labels'][$NM_cada_field];
       }
   }
   foreach ($prep_combo as $ind => $cada_field)
   {
?>
       <OPTION value="<?php echo $cada_field; ?></OPTION>
<?php
   }
?>
    </select>
<?php
   if ($this->proc_ajax)
   {
       $this->ajax_return['setHtml'][] = array('field' => 'select_orig', 'value' => ob_get_contents());
   }
?>
   </td>
   <td align="center">
     <INPUT TYPE="image" SRC="<?php echo $this->path_img; ?>/img_move_right_all.gif" ALIGN="absmiddle" onClick="nm_add_all('sel_orig', 'sel_dest', 'N'); return false;"><br />
     <INPUT TYPE="image" SRC="<?php echo $this->path_img; ?>/img_move_right.gif" ALIGN="absmiddle" onClick="nm_add_sel('sel_orig', 'sel_dest', 'N'); return false;"><br />
     <INPUT TYPE="image" SRC="<?php echo $this->path_img; ?>/img_move_left.gif" ALIGN="absmiddle" onClick="nm_del_sel('sel_dest', 'sel_orig', 'N'); return false;"><br />
     <INPUT TYPE="image" SRC="<?php echo $this->path_img; ?>/img_move_left_all.gif" ALIGN="absmiddle" onClick="nm_del_all('sel_dest', 'sel_orig', 'N'); return false;"><br />
   </td>
   <td id="select_dest">
<?php
   if ($this->proc_ajax)
   {
       ob_end_clean();
       ob_start();
   }
?>
    <select class="css_toolbar_obj" name="sel_dest" size=<?php echo $size; ?>  multiple onDblClick="nm_del_sel('sel_dest', 'sel_orig', 'N')">"
<?php
   foreach ($_SESSION['sc_session'][$this->sc_init]['grafico_refacciones']['field_order'] as $NM_cada_field)
   {
       if ($tab_ger_campos[$NM_cada_field] == "on")
       {
?>
       <OPTION value="<?php echo NM_encode_input($NM_cada_field); ?>"><?php echo $_SESSION['sc_session'][$this->sc_init]['grafico_refacciones']['labels'][$NM_cada_field]; ?></OPTION>
<?php
       }
   }
?>
    </select>
<?php
   if ($this->proc_ajax)
   {
       $this->ajax_return['setHtml'][] = array('field' => 'select_dest', 'value' => ob_get_contents());
   }
?>
   </td>
   <td align="center">
     <INPUT TYPE="image" SRC="<?php echo $this->path_img; ?>/img_move_up.gif" ALIGN="absmiddle" onClick="nm_move_up('sel_dest'); return false;"><br />
     <INPUT TYPE="image" SRC="<?php echo $this->path_img; ?>/img_move_down.gif" ALIGN="absmiddle" onClick="nm_move_down('sel_dest'); return false;"><br />
   </td></tr>
   <tr class="scGridToolbar"><td colspan=4 align="center">
   <?php echo nmButtonOutput($this->arr_buttons, "bok", "submit_form()", "submit_form()", "f_sel_sub", "", "", "", "absmiddle", "", "0px", $this->path_btn, "", "", "", "", "", "only_text", "text_right", "", "");
?>
  &nbsp;&nbsp;&nbsp
   <?php echo nmButtonOutput($this->arr_buttons, "bsair", "self.parent.tb_remove()", "self.parent.tb_remove()", "Bsair", "", "", "", "absmiddle", "", "0px", $this->path_btn, "", "", "", "", "", "only_text", "text_right", "", "");
?>
   </td></tr></table>
  </td>
  </tr>
 </table>
</FORM>
<script language="javascript"> 
var bFixed = false;
$(function() {
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
    oDest.width(mWidth);
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
   if ($this->proc_ajax)
   {
       ob_end_clean();
       $oJson = new Services_JSON();
       echo $oJson->encode($this->ajax_return);
       exit;
   }
}
}
