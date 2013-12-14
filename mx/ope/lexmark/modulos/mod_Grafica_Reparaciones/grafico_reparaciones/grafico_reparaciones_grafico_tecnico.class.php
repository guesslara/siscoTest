<?php

class grafico_reparaciones_grafico
{
   var $Db;
   var $Ini;
   var $Erro;
   var $Lookup;

   var $nm_data;
   var $total;
   var $array_datay_geral;
   var $array_label_geral;
   var $array_datay;
   var $array_label;
   var $campo;
   var $campo_val;
   var $comando;
   var $label;
   var $list_titulo;
   var $max_size_datay;
   var $max_size_label;
   var $total_datay;
   var $nivel;
   var $titulo;
   var $Decimais;
   var $sc_proc_grid; 
   var $sc_graf_sint = false;
   var $graf_cor_fundo;
   var $graf_cor_margens;
   var $graf_cor_label;
   var $graf_cor_valores;
   var $graf_tipo_marcas;
   var $NM_tit_val;
   var $NM_ind_val;

   //---- 
   function grafico_reparaciones_grafico()
   {
      $this->nm_data = new nm_data("es");
   }

   //---- 
   function monta_grafico($chart_key = '', $operation = 'chart')
   {
       $graf_field = false;
       if (is_array($chart_key) && isset($chart_key['field']))
       {
           $field = $chart_key['field'];
           $graf_field = true;
       }
       if ('pdf_lib' == $operation)
       {
           $_SESSION['sc_session'][$this->Ini->sc_page]['grafico_reparaciones']['parms_graf'] = $_SESSION['sc_session'][$this->Ini->sc_page]['grafico_reparaciones'];
           $this->grafico_flash_js();
           return;
       }
       if ($graf_field)
       {
           $this->sc_graf_sint = true;
       }
       elseif ($_SESSION['sc_session'][$this->Ini->sc_page]['grafico_reparaciones']['graf_opc_atual'] == 1)
       {
           $this->sc_graf_sint = true;
       }

       $b_export = false;
       if (isset($_GET['flash_graf']) && 'chart' == $_GET['flash_graf'])
       {
           $b_export = true;
           $chart_key = key($_SESSION['sc_session'][$this->Ini->sc_page]['grafico_reparaciones']['pivot_charts']);
       }
       elseif ('' == $chart_key)
       {
           $chart_key = isset($_POST['nmgp_parms']) ? $_POST['nmgp_parms'] : '';
       }

       if ($graf_field)
       {
           $chart_data = array();
           $chart_data['title']    = $chart_key['title'];
           $chart_data['label_x']  = $chart_key['label_x'];
           $chart_data['label_y']  = $chart_key['label_y'];
           $chart_data['labels']   = $chart_key['labels'];
           $chart_data['show_sub'] = true;
           $chart_data['subtitle'] = "";
           $chart_data['format']   = $chart_key['format'];
           $chart_data['legend']   = "";
           $chart_data['values']['sint'] = $chart_key['vals'];
           $arr_param = array(
               'type'        => $_SESSION['sc_session'][$this->Ini->sc_page]['grafico_reparaciones'][$field]['graf_tipo'],
               'width'       => $_SESSION['sc_session'][$this->Ini->sc_page]['grafico_reparaciones'][$field]['graf_larg'],
               'height'      => $_SESSION['sc_session'][$this->Ini->sc_page]['grafico_reparaciones'][$field]['graf_alt'],
               'barra_orien' => $_SESSION['sc_session'][$this->Ini->sc_page]['grafico_reparaciones'][$field]['graf_barra_orien'],
               'barra_forma' => $_SESSION['sc_session'][$this->Ini->sc_page]['grafico_reparaciones'][$field]['graf_barra_forma'],
               'barra_dimen' => $_SESSION['sc_session'][$this->Ini->sc_page]['grafico_reparaciones'][$field]['graf_barra_dimen'],
               'barra_sobre' => $_SESSION['sc_session'][$this->Ini->sc_page]['grafico_reparaciones'][$field]['graf_barra_sobre'],
               'barra_empil' => $_SESSION['sc_session'][$this->Ini->sc_page]['grafico_reparaciones'][$field]['graf_barra_empil'],
               'barra_inver' => $_SESSION['sc_session'][$this->Ini->sc_page]['grafico_reparaciones'][$field]['graf_barra_inver'],
               'barra_agrup' => $_SESSION['sc_session'][$this->Ini->sc_page]['grafico_reparaciones'][$field]['graf_barra_agrup'],
               'barra_funil' => $_SESSION['sc_session'][$this->Ini->sc_page]['grafico_reparaciones'][$field]['graf_barra_funil'],
               'pizza_forma' => $_SESSION['sc_session'][$this->Ini->sc_page]['grafico_reparaciones'][$field]['graf_pizza_forma'],
               'pizza_dimen' => $_SESSION['sc_session'][$this->Ini->sc_page]['grafico_reparaciones'][$field]['graf_pizza_dimen'],
               'pizza_orden' => $_SESSION['sc_session'][$this->Ini->sc_page]['grafico_reparaciones'][$field]['graf_pizza_orden'],
               'pizza_explo' => $_SESSION['sc_session'][$this->Ini->sc_page]['grafico_reparaciones'][$field]['graf_pizza_explo'],
               'pizza_valor' => $_SESSION['sc_session'][$this->Ini->sc_page]['grafico_reparaciones'][$field]['graf_pizza_valor'],
               'linha_forma' => $_SESSION['sc_session'][$this->Ini->sc_page]['grafico_reparaciones'][$field]['graf_linha_forma'],
               'linha_inver' => $_SESSION['sc_session'][$this->Ini->sc_page]['grafico_reparaciones'][$field]['graf_linha_inver'],
               'linha_agrup' => $_SESSION['sc_session'][$this->Ini->sc_page]['grafico_reparaciones'][$field]['graf_linha_agrup'],
               'area_forma'  => $_SESSION['sc_session'][$this->Ini->sc_page]['grafico_reparaciones'][$field]['graf_area_forma'],
               'area_empil'  => $_SESSION['sc_session'][$this->Ini->sc_page]['grafico_reparaciones'][$field]['graf_area_empil'],
               'area_inver'  => $_SESSION['sc_session'][$this->Ini->sc_page]['grafico_reparaciones'][$field]['graf_area_inver'],
               'area_agrup'  => $_SESSION['sc_session'][$this->Ini->sc_page]['grafico_reparaciones'][$field]['graf_area_agrup'],
               'marca_inver' => $_SESSION['sc_session'][$this->Ini->sc_page]['grafico_reparaciones'][$field]['graf_marca_inver'],
               'marca_agrup' => $_SESSION['sc_session'][$this->Ini->sc_page]['grafico_reparaciones'][$field]['graf_marca_agrup'],
               'gauge_forma' => $_SESSION['sc_session'][$this->Ini->sc_page]['grafico_reparaciones'][$field]['graf_gauge_forma'],
               'radar_forma' => $_SESSION['sc_session'][$this->Ini->sc_page]['grafico_reparaciones'][$field]['graf_radar_forma'],
               'radar_empil' => $_SESSION['sc_session'][$this->Ini->sc_page]['grafico_reparaciones'][$field]['graf_radar_empil'],
               'polar_forma' => $_SESSION['sc_session'][$this->Ini->sc_page]['grafico_reparaciones'][$field]['graf_polar_forma'],
               'funil_dimen' => $_SESSION['sc_session'][$this->Ini->sc_page]['grafico_reparaciones'][$field]['graf_funil_dimen'],
               'funil_inver' => $_SESSION['sc_session'][$this->Ini->sc_page]['grafico_reparaciones'][$field]['graf_funil_inver'],
               'pyram_dimen' => $_SESSION['sc_session'][$this->Ini->sc_page]['grafico_reparaciones'][$field]['graf_pyram_dimen'],
               'pyram_valor' => $_SESSION['sc_session'][$this->Ini->sc_page]['grafico_reparaciones'][$field]['graf_pyram_valor'],
               'pyram_forma' => $_SESSION['sc_session'][$this->Ini->sc_page]['grafico_reparaciones'][$field]['graf_pyram_forma'],
               'tit_datay'   => $chart_data['label_y'],
               'tit_label'   => $chart_data['label_x'],
               'tit_chart'   => $chart_data['title'],
               'export'      => 'N',
               'pdf'         => 'N',
               'xml'         => '',
           );
           $mode = 'full';
           $this->arr_param = $arr_param;
           $_SESSION['sc_session'][$this->Ini->sc_page]['grafico_reparaciones']['parms_graf'] = $_SESSION['sc_session'][$this->Ini->sc_page]['grafico_reparaciones'][$field];
           $this->grafico_flash($arr_param, $this->grafico_dados($chart_data, $arr_param['export']), $mode);
       }
       elseif (isset($_SESSION['sc_session'][$this->Ini->sc_page]['grafico_reparaciones']['pivot_charts'][$chart_key]))
       {
           $chart_data = $_SESSION['sc_session'][$this->Ini->sc_page]['grafico_reparaciones']['pivot_charts'][$chart_key];

           $arr_param = array(
               'type'        => $_SESSION['sc_session'][$this->Ini->sc_page]['grafico_reparaciones']['graf_tipo'],
               'width'       => $_SESSION['sc_session'][$this->Ini->sc_page]['grafico_reparaciones']['graf_larg'],
               'height'      => $_SESSION['sc_session'][$this->Ini->sc_page]['grafico_reparaciones']['graf_alt'],
               'barra_orien' => $_SESSION['sc_session'][$this->Ini->sc_page]['grafico_reparaciones']['graf_barra_orien'],
               'barra_forma' => $_SESSION['sc_session'][$this->Ini->sc_page]['grafico_reparaciones']['graf_barra_forma'],
               'barra_dimen' => $_SESSION['sc_session'][$this->Ini->sc_page]['grafico_reparaciones']['graf_barra_dimen'],
               'barra_sobre' => $_SESSION['sc_session'][$this->Ini->sc_page]['grafico_reparaciones']['graf_barra_sobre'],
               'barra_empil' => $_SESSION['sc_session'][$this->Ini->sc_page]['grafico_reparaciones']['graf_barra_empil'],
               'barra_inver' => $_SESSION['sc_session'][$this->Ini->sc_page]['grafico_reparaciones']['graf_barra_inver'],
               'barra_agrup' => $_SESSION['sc_session'][$this->Ini->sc_page]['grafico_reparaciones']['graf_barra_agrup'],
               'barra_funil' => $_SESSION['sc_session'][$this->Ini->sc_page]['grafico_reparaciones']['graf_barra_funil'],
               'pizza_forma' => $_SESSION['sc_session'][$this->Ini->sc_page]['grafico_reparaciones']['graf_pizza_forma'],
               'pizza_dimen' => $_SESSION['sc_session'][$this->Ini->sc_page]['grafico_reparaciones']['graf_pizza_dimen'],
               'pizza_orden' => $_SESSION['sc_session'][$this->Ini->sc_page]['grafico_reparaciones']['graf_pizza_orden'],
               'pizza_explo' => $_SESSION['sc_session'][$this->Ini->sc_page]['grafico_reparaciones']['graf_pizza_explo'],
               'pizza_valor' => $_SESSION['sc_session'][$this->Ini->sc_page]['grafico_reparaciones']['graf_pizza_valor'],
               'linha_forma' => $_SESSION['sc_session'][$this->Ini->sc_page]['grafico_reparaciones']['graf_linha_forma'],
               'linha_inver' => $_SESSION['sc_session'][$this->Ini->sc_page]['grafico_reparaciones']['graf_linha_inver'],
               'linha_agrup' => $_SESSION['sc_session'][$this->Ini->sc_page]['grafico_reparaciones']['graf_linha_agrup'],
               'area_forma'  => $_SESSION['sc_session'][$this->Ini->sc_page]['grafico_reparaciones']['graf_area_forma'],
               'area_empil'  => $_SESSION['sc_session'][$this->Ini->sc_page]['grafico_reparaciones']['graf_area_empil'],
               'area_inver'  => $_SESSION['sc_session'][$this->Ini->sc_page]['grafico_reparaciones']['graf_area_inver'],
               'area_agrup'  => $_SESSION['sc_session'][$this->Ini->sc_page]['grafico_reparaciones']['graf_area_agrup'],
               'marca_inver' => $_SESSION['sc_session'][$this->Ini->sc_page]['grafico_reparaciones']['graf_marca_inver'],
               'marca_agrup' => $_SESSION['sc_session'][$this->Ini->sc_page]['grafico_reparaciones']['graf_marca_agrup'],
               'gauge_forma' => $_SESSION['sc_session'][$this->Ini->sc_page]['grafico_reparaciones']['graf_gauge_forma'],
               'radar_forma' => $_SESSION['sc_session'][$this->Ini->sc_page]['grafico_reparaciones']['graf_radar_forma'],
               'radar_empil' => $_SESSION['sc_session'][$this->Ini->sc_page]['grafico_reparaciones']['graf_radar_empil'],
               'polar_forma' => $_SESSION['sc_session'][$this->Ini->sc_page]['grafico_reparaciones']['graf_polar_forma'],
               'funil_dimen' => $_SESSION['sc_session'][$this->Ini->sc_page]['grafico_reparaciones']['graf_funil_dimen'],
               'funil_inver' => $_SESSION['sc_session'][$this->Ini->sc_page]['grafico_reparaciones']['graf_funil_inver'],
               'pyram_dimen' => $_SESSION['sc_session'][$this->Ini->sc_page]['grafico_reparaciones']['graf_pyram_dimen'],
               'pyram_valor' => $_SESSION['sc_session'][$this->Ini->sc_page]['grafico_reparaciones']['graf_pyram_valor'],
               'pyram_forma' => $_SESSION['sc_session'][$this->Ini->sc_page]['grafico_reparaciones']['graf_pyram_forma'],
               'tit_datay'   => $chart_data['label_y'],
               'tit_label'   => $chart_data['label_x'],
               'tit_chart'   => $chart_data['title'],
               'export'      => $b_export ? 'Y' : ('xml' == $operation ? 'xml' : 'N'),
               'pdf'         => 'pdf' == $operation ? 'Y' : 'N',
               'xml'         => 'xml' == $operation ? $chart_data['xml'] : '',
           );
           $_SESSION['sc_session'][$this->Ini->sc_page]['grafico_reparaciones']['parms_graf'] = $_SESSION['sc_session'][$this->Ini->sc_page]['grafico_reparaciones'];
           if ('pdf' == $operation)
           {
               $mode = 'chart';
           }
           elseif ('xml' == $operation)
           {
               $mode = 'xml_only';
           }
           elseif (isset($_SESSION['sc_session'][$this->Ini->sc_page]['grafico_reparaciones']['graf_full']) && $_SESSION['sc_session'][$this->Ini->sc_page]['grafico_reparaciones']['graf_full'])
           {
               $mode = 'full';
               unset($_SESSION['sc_session'][$this->Ini->sc_page]['grafico_reparaciones']['graf_full']);
           }
           elseif (!$_SESSION['sc_session'][$this->Ini->sc_page]['grafico_reparaciones']['graf_bot'])
           {
               $mode = 'full';
           }
           elseif ($_SESSION['sc_session'][$this->Ini->sc_page]['grafico_reparaciones']['graf_first'])
           {
               $_SESSION['sc_session'][$this->Ini->sc_page]['grafico_reparaciones']['graf_first'] = false;
               $mode = array('js', 'chart');
           }
           else
           {
               $mode = 'chart';
           }
           $this->arr_param = $arr_param;
           $this->grafico_flash($arr_param, $this->grafico_dados($chart_data, $arr_param['export']), $mode);
           if ('pdf' == $operation || 'xml' == $operation)
           {
               return;
           }
           elseif ((!isset($_GET['flash_graf']) || 'chart' != $_GET['flash_graf']) && (!$_SESSION['sc_session'][$this->Ini->sc_page]['grafico_reparaciones']['graf_bot']))
           {
               exit;
           }
       }
       elseif (isset($_GET['flash_graf']) && 'chart' == $_GET['flash_graf'])
       {
?>
<html>
<body>
<?php
           $this->grafico_flash_form();
?>
<script type="text/javascript" language="javascript">
  document.flashRedir.submit();
 </script>
</body>
</html>
<?php
       }
   }

   //---- 
   function inicializa_vars()
   {
      global 
             $nivel_quebra, $nm_lang, $campo, $campo_val;
      if ($_SESSION['sc_session'][$this->Ini->sc_page]['grafico_reparaciones']['graf_opc_atual'] == 1)
      {
         $this->sc_graf_sint = true;
      }
      //---- 
      $this->array_decimais = array();
      $this->NM_tit_val[0]     = "" .  $this->Ini->Nm_lang['lang_othr_rows'] . "";
      $this->NM_ind_val[0]     = 1;
      $this->array_decimais[0] = 0;
      $this->campo     = (isset($campo))        ? $campo        : 0;
      $this->nivel     = (isset($nivel_quebra)) ? $nivel_quebra : 0;
      $this->campo_val = (isset($campo_val))    ? $campo_val    : 1;
      //---- 
      $this->array_total_cat_reparaciones_descripcion = array();
      //---- 
      $ind_tit = $this->campo_val;
      if ($this->campo > 0)
      {
          foreach ($this->NM_ind_val as $i => $seq)
          {
              if ($ind_tit == $seq)
              {
                  $ind_tit = $i;
                  break;
              }
          }
      }
      $this->list_titulo = (isset($this->NM_tit_val[$ind_tit]))  ? $this->NM_tit_val[$ind_tit]  : "";
      $this->Decimais    = (isset($this->array_decimais[$ind_tit])) ? $this->array_decimais[$ind_tit] : 2;
      $this->titulo      = $this->list_titulo;
      //---- Label
      $this->label    = array();
      $this->label[0] = "Tipo de reparación";
      if (isset($_SESSION['sc_session'][$this->Ini->sc_page]['grafico_reparaciones']['contr_label_graf']['cat_reparaciones_descripcion']) && !empty($_SESSION['sc_session'][$this->Ini->sc_page]['grafico_reparaciones']['contr_label_graf']['cat_reparaciones_descripcion']))
      {
         $this->label[0] = $_SESSION['sc_session'][$this->Ini->sc_page]['grafico_reparaciones']['contr_label_graf']['cat_reparaciones_descripcion'];
      }
   }

   //---- 
   function prep_modulos($modulo)
   {
      $this->$modulo->Ini    = $this->Ini;
      $this->$modulo->Db     = $this->Db;
      $this->$modulo->Erro   = $this->Erro;
      $this->$modulo->Lookup = $this->Lookup;
   }

   //---- 
   function monta_arrays()
   {
      $this->array_label = array();
      $this->array_datay = array();
      if ($this->campo > 0)
      {
          $this->sc_graf_sint = true;
      }
      if (isset($_SESSION['sc_session'][$this->Ini->sc_page]['grafico_reparaciones']['graf_total']))
      {
          foreach ($_SESSION['sc_session'][$this->Ini->sc_page]['grafico_reparaciones']['graf_total'] as $label => $valor)
          {
              $this->array_label[] = $valor[2];
              if ($this->campo == 0 && $this->nivel == 0)
              {
                  if ($this->sc_graf_sint)
                  {
                      $this->array_datay[" "][] = $valor[$this->campo_val];
                  }
              }
          }
          if (!$this->sc_graf_sint)
          {
              foreach ($_SESSION['sc_session'][$this->Ini->sc_page]['grafico_reparaciones']['graf_linhas'] as $cada_elemento)
              {
                  if (substr($cada_elemento[0], 0, 1) == 1)
                  {
                      $ind_val = $this->NM_ind_val[$this->campo_val];
                      $legenda = substr($cada_elemento[0], 1);
                      foreach ($this->array_label as $ind => $lixo)
                      {
                          if (isset($cada_elemento[$ind + 1]))
                          {
                              $this->array_datay[$legenda][] = $cada_elemento[$ind + 1][$ind_val];
                          }
                          else
                          {
                              $this->array_datay[$legenda][] = 0;
                          }
                      }
                  }
              }
          }
      }
      if (isset($_SESSION['sc_session'][$this->Ini->sc_page]['grafico_reparaciones']['graf_linhas']))
      {
          if ($this->campo > 0)
          {
              $lab_quebra    = substr($_SESSION['sc_session'][$this->Ini->sc_page]['grafico_reparaciones']['graf_linhas'][$this->campo][0], 1);
              $lab_quebra    = str_replace("&nbsp;", "", $lab_quebra);
              $this->titulo .= " - " . $this->label[$this->nivel] . " = " . $lab_quebra;
          }
          if ($this->campo > 0)
          {
              foreach ($_SESSION['sc_session'][$this->Ini->sc_page]['grafico_reparaciones']['graf_linhas'][$this->campo] as $ind => $valor)
              {
                  if ($ind > 0)
                  {
                      $this->array_datay[" "][$ind - 1] = $valor[$this->campo_val];
                  }
              }
              for ($i = 0; $i < count($this->array_label); $i++)
              {
                   if (!isset($this->array_datay[" "][$i]))
                   {
                       $this->array_datay[" "][$i] = 0;
                   }
              }
          }
      }
      if (isset($_SESSION['sc_session'][$this->Ini->sc_page]['grafico_reparaciones']['del_graph_col']))
      {
          $trab_graf = $this->array_label;
          $this->array_label = array();
          foreach ($trab_graf as $ind => $resto)
          {
              $tst_ind = $ind + 1;
              if (!isset($_SESSION['sc_session'][$this->Ini->sc_page]['grafico_reparaciones']['del_graph_col'][$tst_ind]))
              {
                  $this->array_label[] = $resto;
              }
          }
          $trab_graf = $this->array_datay;
          $this->array_datay = array();
          foreach ($trab_graf as $legenda => $dados)
          {
              ksort($dados);
              foreach ($dados as $ind => $resto)
              {
                  $tst_ind = $ind + 1;
                  if (!isset($_SESSION['sc_session'][$this->Ini->sc_page]['grafico_reparaciones']['del_graph_col'][$tst_ind]))
                  {
                      $this->array_datay[$legenda][] = $resto;
                  }
              }
          }
      }
      $this->max_size_label = 0;
      for ($i = 0; $i < sizeof($this->array_label); $i++)
      {
         $size_label           = strlen("" . $this->array_label[$i]);
         $this->max_size_label = ($this->max_size_label < $size_label) ? $size_label : $this->max_size_label;
      }
      $this->max_size_datay = 0;
      $this->total_datay = 0;
      foreach ($this->array_datay as $legenda => $dadosY)
      {
          for ($i = 0; $i < sizeof($dadosY); $i++)
          {
             $size_datay           = strlen("" . $dadosY[$i]);
             $this->max_size_datay = ($this->max_size_datay < $size_datay) ? $size_datay : $this->max_size_datay;
             $this->total_datay   += $dadosY[$i];
          }
      }
   }

   function grafico_flash($arr_param, $arr_charts, $html_par = 'full')
   {
      global $nm_saida, $nm_retorno_graf;

         $this->orderCharts($arr_charts, $_SESSION['sc_session'][$this->Ini->sc_page]['grafico_reparaciones']['parms_graf']['graf_order']);

         $arr_series     = $arr_charts[0];

         $dp_settings    = array();
         $y_scale        = array();
         $shape_type     = '';
         $chart_series   = 'bar_series';
         $chart_series_a = array();
         $series_explode = '';

         $tipo           = $arr_param['type'];
         $width          = $arr_param['width'];
         $height         = $arr_param['height'];
         $tit_datay      = $arr_param['tit_datay'];
         $tit_label      = $arr_param['tit_label'];
         $tit_graf       = $arr_param['tit_chart'];
         $export         = $arr_param['export'];

         $host           = (isset($arr_param['host'])   && !empty($arr_param['host']))   ? $arr_param['host']   : '';
         $export         = (isset($arr_param['export']) && !empty($arr_param['export'])) ? $arr_param['export'] : 'N';

         if ('xml_only' == $html_par)
         {
             if (isset($arr_param['xml']) && '' != $arr_param['xml'])
             {
                 $sFileLocal = $this->Ini->path_imag_temp . '/' . $arr_param['xml'];
                 $ac         = fopen($this->Ini->root . $sFileLocal, 'w');
                 fwrite($ac, $this->grafico_flash_xml($arr_param, $arr_series));
                 fclose($ac);
             }
             return;
         }

         $sFileLocal = $this->Ini->path_imag_temp . '/sc_flashchart_' . md5(microtime() . mt_rand(1, 1000)) . '.xml';
         $ac         = fopen($this->Ini->root . $sFileLocal, 'w');
         fwrite($ac, $this->grafico_flash_xml($arr_param, $arr_series));
         fclose($ac);

         if ('full' == $html_par || 'page' == $html_par || in_array('page', $html_par))
         {
?>
<html>
<head>
<META http-equiv="Content-Type" content="text/html; charset=<?php echo $_SESSION['scriptcase']['charset_html'] ?>" />
<?php
             if (isset($_POST['summary_css']) && '' != $_POST['summary_css'])
             {
?>
<link rel="stylesheet" href="<?php echo NM_encode_input($_POST['summary_css']) ?>" type="text/css" media="screen" />
<?php
             }
?>
<title>
<?php
             if ('UTF-8' != $_SESSION['scriptcase']['charset'])
             {
                 echo mb_convert_encoding($tit_graf, $_SESSION['scriptcase']['charset'], 'UTF-8');
             }
             else
             {
                 echo $tit_graf;
             }
?>
</title>
<?php
         }
         if ('full' == $html_par || 'js' == $html_par || in_array('js', $html_par))
         {
            $this->grafico_flash_js();
         }
         if ('full' == $html_par || 'config' == $html_par || in_array('config', $html_par))
         {
            $this->grafico_flash_config_js();
            $nm_saida->saida("<link rel=\"stylesheet\" type=\"text/css\" href=\"../_lib/buttons/" . $this->Ini->Str_btn_css . "\" />\r\n");
         }
         if ('full' == $html_par || 'page' == $html_par || in_array('page', $html_par))
         {
?>
</head>
<body class="scGridPage">
<?php
         }
         if ('full' == $html_par || 'form' == $html_par || in_array('form', $html_par))
         {
            $this->grafico_flash_form();
         }
         if ('full' == $html_par || 'config' == $html_par || in_array('config', $html_par))
         {
            $this->grafico_flash_config_div();
         }
         if ('full' == $html_par || 'chart' == $html_par || in_array('chart', $html_par))
         {
            $this->grafico_flash_chart($width, $height, $sFileLocal, $export, $arr_charts, $arr_param['pdf']);
         }
         if ('full' == $html_par || 'page' == $html_par || in_array('chart', $html_par))
         {
            if ($_SESSION['sc_session'][$this->Ini->sc_page]['grafico_reparaciones']['opcao'] != "pdf")
            {
                if (empty($nm_retorno_graf))
                {
                    $nm_retorno_graf = "resumo";
                }
            }
?>
</body>
</html>
<?php
         }
   }

   function grafico_flash_xml($arr_param, $arr_series, $newline = "\r\n")
   {
       $tipo         = $arr_param['type'];
       $width        = $arr_param['width'];
       $height       = $arr_param['height'];
       $tit_datay    = $arr_param['tit_datay'];
       $tit_label    = $arr_param['tit_label'];
       $tit_graf     = $arr_param['tit_chart'];
       $export       = $arr_param['export'];
       $value_format = isset($arr_series[0]['format']) && '' != $arr_series[0]['format'] ? $arr_series[0]['format'] : '';

       $repeat_value = false;

       $chart_attr   = array();


       if ('Y' == $arr_param['pdf'] && !in_array("animation=\"0\"", $chart_attr))
       {
           $chart_attr[] = "animation=\"0\"";
       }

       switch ($tipo)
       {
           case 'Bar':
               if ('Percent' == $arr_param['barra_empil'] && 1 < sizeof($arr_series))
               {
                   $chart_attr[] = "stack100Percent=\"1\"";
                   $chart_attr[] = "showPercentValues=\"0\"";
               }
               if ('Yes' == $arr_param['barra_sobre'] && 1 < sizeof($arr_series))
               {
                   $chart_attr[] = "clustered=\"0\"";
               }
               $chart_attr[] = "labelDisplay=\"Rotate\"";
               $chart_attr[] = "placeValuesInside=\"1\"";
               break;

           case 'Pie':
               $chart_attr[] = "showLegend=\"1\"";
               if ('Percent' == $arr_param['pizza_valor'])
               {
                   $chart_attr[] = "showPercentValues=\"1\"";
               }
               else
               {
                   $chart_attr[] = "showPercentValues=\"0\"";
               }
               break;

           case 'Funnel':
               $chart_attr[] = "useSameSlantAngle=\"1\"";
               $chart_attr[] = "isHollow=\"0\"";
               $chart_attr[] = "showLegend=\"1\"";
               $chart_attr[] = "showLabels=\"0\"";
               if ('2d' == $arr_param['funil_dimen'])
               {
                   $chart_attr[] = "is2D=\"1\"";
               }
               break;

           case 'Pyramid':
               $chart_attr[] = "showLegend=\"1\"";
               $chart_attr[] = "showLabels=\"0\"";
               if ('2d' == $arr_param['pyram_dimen'])
               {
                   $chart_attr[] = "is2D=\"1\"";
               }
               if ('Percent' == $arr_param['pyram_valor'])
               {
                   $repeat_value = true;
                   $chart_attr[] = "showPercentValues=\"1\"";
               }
               else
               {
                   $chart_attr[] = "showPercentValues=\"0\"";
               }
               if ('S' == $arr_param['pyram_forma'])
               {
                   $chart_attr[] = "isSliced=\"1\"";
               }
               else
               {
                   $chart_attr[] = "isSliced=\"0\"";
               }
               break;

           case 'Gauge':
               if ('Circular' == $arr_param['gauge_forma'])
               {
                   $chart_attr[] = "gaugeStartAngle=\"0\"";
                   $chart_attr[] = "gaugeEndAngle=\"-360\"";
               }
               break;
       }

       if ('' != $arr_series[0]['subtitle'])
       {
           $chart_attr[] = "subCaption=\"" . $arr_series[0]['subtitle'] . "\"";
       }
       if (!empty($_SESSION['sc_session'][$this->Ini->sc_page]['grafico_reparaciones']['parms_graf']['graf_font']))
       {
           $chart_attr[] = "baseFontSize=\"" . $_SESSION['sc_session'][$this->Ini->sc_page]['grafico_reparaciones']['parms_graf']['graf_font'] . "\"";
       }
       if (!empty($_SESSION['sc_session'][$this->Ini->sc_page]['grafico_reparaciones']['parms_graf']['chartpallet']))
       {
           $chart_attr[] = "palette=\"" . $_SESSION['sc_session'][$this->Ini->sc_page]['grafico_reparaciones']['parms_graf']['chartpallet'] . "\"";
       }
       if ($_SESSION['sc_session'][$this->Ini->sc_page]['grafico_reparaciones']['parms_graf']['graf_subtitle_val'] == 'right')
       {
           $chart_attr[] = "legendPosition=\"RIGHT\"";
       }

       $s_xml = "<chart showValues=\"" . $_SESSION['sc_session'][$this->Ini->sc_page]['grafico_reparaciones']['parms_graf']['graf_exibe_val'] . "\" caption=\"" . $this->formatFusionLabel($tit_graf) . "\" xAxisName=\"" . $this->formatFusionLabel($tit_label) . "\" yAxisName=\"" . $this->formatFusionLabel($tit_datay) . "\" paletteColors=\"" . $this->getColorList($arr_series, $_SESSION["sc_session"][$this->Ini->sc_page]["grafico_reparaciones"]["parms_graf"]["paletteColors"]) . "\" " . implode(' ', $chart_attr) . " " . $value_format . ">" . $newline;
       $link_call = 'j-scGridLink-';
       if ('Gauge' == $tipo)
       {
           $iMin = 0;
           $iMax = 0;
           foreach ($arr_series as $arr_serie)
           {
               $label = $arr_serie['label'];
               $datay = $arr_serie['data'];
               $link  = $arr_serie['link'];
               foreach ($label as $iIndex => $sLabel)
               {
                   $iMin = min($iMin, $datay[$iIndex]);
                   $iMax = max($iMax, $datay[$iIndex]);
               }
           }
           if (10 > $iMax) $iMax = 10;
           $iMax    = ceil($iMax * 1.1);
           $iMaxInt = ($iMax -$iMin) / 10;
           $iMinInt = ($iMax -$iMin) / 40;

           $s_xml .= " <colorRange>" . $newline;
           $s_xml .= "  <color minValue=\"0\" maxValue=\"100\" code=\"\" />" . $newline;
           $s_xml .= " </colorRange>" . $newline;
           $s_xml .= " <dials>" . $newline;
           foreach ($arr_series as $arr_serie)
           {
               $label = $arr_serie['label'];
               $datay = $arr_serie['data'];
               $link  = $arr_serie['link'];
               foreach ($label as $iIndex => $sLabel)
               {
                   $s_xml .= " <dial value=\"" . $datay[$iIndex] . "\"";
                   if (isset($link[$iIndex]))
                   {
                       $s_xml .= " link=\"" . $link_call . $link[$iIndex] . "\"";
                   }
                   $s_xml .= " />" . $newline;
               }
           }
           $s_xml .= " </dials>" . $newline;
       }
       elseif (1 < sizeof($arr_series) || 'Radar' == $tipo || 'Step' == $arr_param['linha_forma'])
       {
           $label = $arr_series[0]['label'];
           $datay = $arr_series[0]['data'];
           $link  = $arr_series[0]['link'];
           $s_xml .= " <categories>" . $newline;
           foreach ($label as $iIndex => $sLabel)
           {
               $s_xml .= "  <category Label=\"" . $this->formatFusionLabel($sLabel) . "\" />" . $newline;
           }
           $s_xml .= " </categories>" . $newline;
           foreach ($arr_series as $arr_serie)
           {
               $label     = $arr_serie['label'];
               $datay     = $arr_serie['data'];
               $link      = $arr_serie['link'];
               $link_anal = $arr_serie['link_anal'];
               $s_xml    .= " <dataset seriesName=\"" . $this->formatFusionLabel($arr_serie['name']) . "\">" . $newline;
               foreach ($label as $iIndex => $sLabel)
               {
                   $s_xml .= "  <set value=\"" . $datay[$iIndex] . "\" ";
                   if (!$this->sc_graf_sint && isset($link_anal[$arr_serie['serie_val']][$iIndex]))
                   {
                       $s_xml .= " link=\"" . $link_call . $link_anal[$arr_serie['serie_val']][$iIndex] . "\"";
                   }
                   elseif (isset($link[$iIndex]))
                   {
                       $s_xml .= " link=\"" . $link_call . $link[$iIndex] . "\"";
                   }
                   $s_xml .= " />" . $newline;
               }
               $s_xml .= " </dataset>" . $newline;
           }
       }
       else
       {
           $label = $arr_series[0]['label'];
           $datay = $arr_series[0]['data'];
           $link  = $arr_series[0]['link'];
           foreach ($label as $iIndex => $sLabel)
           {
               $s_xml .= " <set label=\"" . $this->formatFusionLabel($sLabel) . "\" value=\"" . $datay[$iIndex] . "\"";
               if (isset($link[$iIndex]))
               {
                   $s_xml .= " link=\"" . $link_call . $link[$iIndex] . "\"";
               }
               if ($repeat_value)
               {
                   $s_xml .= " tooltext=\"" . $datay[$iIndex] . "\"";
               }
               $s_xml .= " />" . $newline;
           }
       }
       $s_xml .= "</chart>" . $newline;

       return $s_xml;
   }

   function formatFusionLabel($sLabel)
   {
       return str_replace('&nbsp;', ' ', $sLabel);
   }

   function grafico_flash_js()
   {
      global $nm_saida;

      $nm_saida->saida("<script type=\"text/javascript\" language=\"javascript\" src=\"" . $this->Ini->path_prod . "/third/fusioncharts/" . $this->getChartModule() . "/FusionCharts.js\"></script>\r\n");
      $nm_saida->saida("<script type=\"text/javascript\">\r\n");
      $nm_saida->saida("function scGridLink(chartLink) {\r\n");
      $nm_saida->saida("  nm_link_cons(chartLink);\r\n");
      $nm_saida->saida("}\r\n");
      $nm_saida->saida("</script>\r\n");
   }

   function grafico_flash_form()
   {
      global $nm_saida;

      $sOpcao = isset($_GET['nmgp_opcao']) && 'pdf_res' == $_GET['nmgp_opcao'] ? 'pdf_res' : 'pdf';
?>
<form name="flashRedir" method="GET" action="./" style="display: none">
  <input type="hidden" name="flash_graf" value="pdf" />
  <input type="hidden" name="nmgp_opcao" value="<?php       echo NM_encode_input($sOpcao);                         ?>" />
  <input type="hidden" name="script_case_init" value="<?php echo NM_encode_input($_GET['script_case_init']);       ?>" />
  <input type="hidden" name="script_case_session" value="<?php echo NM_encode_input(session_id());                  ?>" />
  <input type="hidden" name="pbfile" value="<?php           echo NM_encode_input($_GET['pbfile']);                 ?>" />
  <input type="hidden" name="sc_apbgcol" value="<?php       echo urlencode($this->Ini->path_css); ?>" />
  <input type="hidden" name="nmgp_tipo_pdf" value="<?php    echo NM_encode_input($_GET['nmgp_tipo_pdf']);          ?>" />
  <input type="hidden" name="nmgp_parms_pdf" value="<?php   echo NM_encode_input($_GET['nmgp_parms_pdf']);         ?>" />
  <input type="hidden" name="nmgp_graf_pdf" value="<?php    echo NM_encode_input($_GET['nmgp_graf_pdf']);          ?>" />
  <input type="hidden" name="pdf_base" value="<?php         echo NM_encode_input($_GET['pdf_base']);               ?>" />
  <input type="hidden" name="pdf_url" value="<?php          echo NM_encode_input($_GET['pdf_url']);                ?>" />
</form>
<?php
   }

   function grafico_flash_config_js()
   {
      global $nm_saida;

      $sUrlConfigSave = $this->Ini->path_link . "grafico_reparaciones/grafico_reparaciones_config_graf_flash.php?nome_apl=grafico_reparaciones&campo_apl=nm_resumo_graf&sc_page=" . NM_encode_input($this->Ini->sc_page) . "&language=es";

      $nm_saida->saida("<script type=\"text/javascript\" src=\"" . $this->Ini->path_prod . "/third/fusioncharts/" . $this->getChartModule() . "/jquery.min.js\"></script>\r\n");
      $nm_saida->saida("<script type=\"text/javascript\">\r\n");
      $nm_saida->saida("  $(function() {\r\n");
      $nm_saida->saida("    $(\"#sc-id-button-submit\").click(function() {\r\n");
      $nm_saida->saida("      $.ajax({\r\n");
      $nm_saida->saida("        type: \"POST\",\r\n");
      $nm_saida->saida("        url: \"" . $sUrlConfigSave . "\",\r\n");
      $nm_saida->saida("        data: {\r\n");
      $nm_saida->saida("          bok_graf: \"OK\",\r\n");
      $nm_saida->saida("          ajax: \"OK\",\r\n");
      $nm_saida->saida("          nome_apl: \"grafico_reparaciones\",\r\n");
      $nm_saida->saida("          campo_apl: \"nm_resumo_graf\",\r\n");
      $nm_saida->saida("          sc_page: \"" . NM_encode_input($this->Ini->sc_page) . "\",\r\n");
      $nm_saida->saida("          tipo: $(\"#sc-id-chart-type\").val(),\r\n");
      $nm_saida->saida("          opc_atual: $(\"#sc-id-chart-mode\").val(),\r\n");
      $nm_saida->saida("          largura: $(\"#sc-id-chart-width\").val(),\r\n");
      $nm_saida->saida("          altura: $(\"#sc-id-chart-height\").val(),\r\n");
      $nm_saida->saida("          order: $(\"#sc-id-chart-order\").val()\r\n");
      $nm_saida->saida("        }\r\n");
      $nm_saida->saida("      }).done(function(data) {\r\n");
      $nm_saida->saida("        document.refresh_chart.submit();\r\n");
      $nm_saida->saida("      });\r\n");
      $nm_saida->saida("    });\r\n");
      $nm_saida->saida("    $(\"#sc-id-button-cancel\").click(function() {\r\n");
      $nm_saida->saida("      $(\"#sc-id-div-config\").slideUp();\r\n");
      $nm_saida->saida("      $(\"#sc-id-div-control\").show();\r\n");
      $nm_saida->saida("    });\r\n");
      $nm_saida->saida("    $(\"#sc-id-div-open\").click(function() {\r\n");
      $nm_saida->saida("      $(\"#sc-id-div-control\").hide();\r\n");
      $nm_saida->saida("      $(\"#sc-id-div-config\").slideDown();\r\n");
      $nm_saida->saida("    }).mouseover(function() {\r\n");
      $nm_saida->saida("      $(this).css(\"cursor\", \"pointer\");\r\n");
      $nm_saida->saida("    });\r\n");
      $nm_saida->saida("  });\r\n");
      $nm_saida->saida("</script>\r\n");
   }

   function grafico_flash_config_div()
   {
      global $nm_saida;

      $translate = array();
      $language  = 'es';
      if (isset($_SESSION['scriptcase']['sc_idioma_graf_flash']))
      {
         $translate = $_SESSION['scriptcase']['sc_idioma_graf_flash'];
      }
      if (!isset($translate[$language]))
      {
         foreach ($translate as $language => $rest)
         {
            break;
         }
      }

      $aChartDisp        = (isset($_SESSION['sc_session'][$this->Ini->sc_page]['grafico_reparaciones']['graf_disp'])      && !empty($_SESSION['sc_session'][$this->Ini->sc_page]['grafico_reparaciones']['graf_disp']))    ? $_SESSION['sc_session'][$this->Ini->sc_page]['grafico_reparaciones']['graf_disp']      : array('Bar');
      $sChartType        = (isset($_SESSION['sc_session'][$this->Ini->sc_page]['grafico_reparaciones']['graf_tipo'])      && '' != $_SESSION['sc_session'][$this->Ini->sc_page]['grafico_reparaciones']['graf_tipo'])      ? $_SESSION['sc_session'][$this->Ini->sc_page]['grafico_reparaciones']['graf_tipo']      : 'Bar';
      $iSinteticAnalitic = (isset($_SESSION['sc_session'][$this->Ini->sc_page]['grafico_reparaciones']['graf_opc_atual']) && '' != $_SESSION['sc_session'][$this->Ini->sc_page]['grafico_reparaciones']['graf_opc_atual']) ? $_SESSION['sc_session'][$this->Ini->sc_page]['grafico_reparaciones']['graf_opc_atual'] : '1';
      $iChartWidth       = (isset($_SESSION['sc_session'][$this->Ini->sc_page]['grafico_reparaciones']['graf_larg'])      && '' != $_SESSION['sc_session'][$this->Ini->sc_page]['grafico_reparaciones']['graf_larg'])      ? $_SESSION['sc_session'][$this->Ini->sc_page]['grafico_reparaciones']['graf_larg']      : '800';
      $iChartHeight      = (isset($_SESSION['sc_session'][$this->Ini->sc_page]['grafico_reparaciones']['graf_alt'])       && '' != $_SESSION['sc_session'][$this->Ini->sc_page]['grafico_reparaciones']['graf_alt'])       ? $_SESSION['sc_session'][$this->Ini->sc_page]['grafico_reparaciones']['graf_alt']       : '600';
      $sChartOrder       = (isset($_SESSION['sc_session'][$this->Ini->sc_page]['grafico_reparaciones']['graf_order'])     && '' != $_SESSION['sc_session'][$this->Ini->sc_page]['grafico_reparaciones']['graf_order'])     ? $_SESSION['sc_session'][$this->Ini->sc_page]['grafico_reparaciones']['graf_order']     : 'desc';
      $sSinteticSelected = ('1' == $iSinteticAnalitic) ? ' selected="selected"' : '';
      $sAnaliticSelected = ('2' == $iSinteticAnalitic) ? ' selected="selected"' : '';
      $sOrderNone        = (''     == $sChartOrder) ? ' selected="selected"' : '';
      $sOrderAsc         = ('asc'  == $sChartOrder) ? ' selected="selected"' : '';
      $sOrderDesc        = ('desc' == $sChartOrder) ? ' selected="selected"' : '';

      $nm_saida->saida("<div id=\"sc-id-div-control\" class=\"scGridToolbar\" style=\"position: absolute; top: 0; left: 0; z-index: 100; box-shadow: 3px 3px 2px #888888\">\r\n");
      $nm_saida->saida("  <img id=\"sc-id-div-open\" src=\"" . $this->Ini->path_img_global . "/gear_24.png\" />\r\n");
      $nm_saida->saida("</div>\r\n");
      $nm_saida->saida("<br />\r\n");
      $nm_saida->saida("<div id=\"sc-id-div-config\" class=\"scGridToolbar\" style=\"position: absolute; top: 0; left: 0; padding: 5px 10px; z-index: 101; box-shadow: 3px 3px 2px #888888; display: none\">\r\n");
      $nm_saida->saida("  " . $translate[$language]['tipo_g'] . "\r\n");
      $nm_saida->saida("  <select id=\"sc-id-chart-type\" class=\"css_toolbar_obj\">\r\n");
      foreach ($aChartDisp as $sChartDisp)
      {
         switch ($sChartDisp) {
            case 'Bar':
               $sChartTitle = 'tp_barra';
               break;
            case 'Pie':
               $sChartTitle = 'tp_pizza';
               break;
            case 'Line':
               $sChartTitle = 'tp_linha';
               break;
            case 'Area':
               $sChartTitle = 'tp_area';
               break;
            case 'Mark':
               $sChartTitle = 'tp_marcador';
               break;
            case 'Gauge':
               $sChartTitle = 'tp_gauge';
               break;
            case 'Radar':
               $sChartTitle = 'tp_radar';
               break;
            case 'Polar':
               $sChartTitle = 'tp_polar';
               break;
            case 'Funnel':
               $sChartTitle = 'tp_funil';
               break;
            case 'Pyramid':
               $sChartTitle = 'tp_pyramid';
               break;
         }
         $sChartSelected = $sChartType == $sChartDisp ? ' selected="selected"' : '';
         $nm_saida->saida("    <option value=\"" . $sChartDisp . "\"" . $sChartSelected . ">" . $translate[$language][$sChartTitle] . "</option>\r\n");
      }
      $nm_saida->saida("  </select>\r\n");
      $nm_saida->saida("  &nbsp; &nbsp;\r\n");
      $nm_saida->saida("  " . $translate[$language]['modo_gera'] . "\r\n");
      $nm_saida->saida("  <select id=\"sc-id-chart-mode\" class=\"css_toolbar_obj\">\r\n");
      $nm_saida->saida("    <option value=\"1\"" . $sSinteticSelected . ">" . $translate[$language]['sintetico'] . "</option>\r\n");
      $nm_saida->saida("    <option value=\"2\"" . $sAnaliticSelected . ">" . $translate[$language]['analitico'] . "</option>\r\n");
      $nm_saida->saida("  </select>\r\n");
      $nm_saida->saida("  &nbsp; &nbsp;\r\n");
      $nm_saida->saida("  " . $translate[$language]['largura'] . "\r\n");
      $nm_saida->saida("  <input id=\"sc-id-chart-width\" type=\"text\" size=\"5\" value=\"" . $iChartWidth . "\" class=\"css_toolbar_obj\" style=\"text-align: right\" />\r\n");
      $nm_saida->saida("  &nbsp; &nbsp;\r\n");
      $nm_saida->saida("  " . $translate[$language]['altura'] . "\r\n");
      $nm_saida->saida("  <input id=\"sc-id-chart-height\" type=\"text\" size=\"5\" value=\"" . $iChartHeight . "\" class=\"css_toolbar_obj\" style=\"text-align: right\" />\r\n");
      $nm_saida->saida("  &nbsp; &nbsp;\r\n");
      $nm_saida->saida("  " . $translate[$language]['order'] . "\r\n");
      $nm_saida->saida("  <select id=\"sc-id-chart-order\" class=\"css_toolbar_obj\">\r\n");
      $nm_saida->saida("    <option value=\"\"" . $sOrderNone . ">" . $translate[$language]['order_none'] . "</option>\r\n");
      $nm_saida->saida("    <option value=\"asc\"" . $sOrderAsc . ">" . $translate[$language]['order_asc'] . "</option>\r\n");
      $nm_saida->saida("    <option value=\"desc\"" . $sOrderDesc . ">" . $translate[$language]['order_desc'] . "</option>\r\n");
      $nm_saida->saida("  </select>\r\n");
      $nm_saida->saida("  &nbsp; &nbsp;\r\n");
      $sBtnOk   = nmButtonOutput($this->arr_buttons, "bok", "", "", "sc-id-button-submit", "", "", "", "absmiddle", "", "0px", $this->Ini->path_botoes, "", "", "", "", "", "only_text", "text_right", "", "");
      $sBtnExit = nmButtonOutput($this->arr_buttons, "bcancelar", "", "", "sc-id-button-cancel", "", "", "", "absmiddle", "", "0px", $this->Ini->path_botoes, "", "", "", "", "", "only_text", "text_right", "", "");
      $nm_saida->saida("  " . $sBtnOk . "\r\n");
      $nm_saida->saida("  " . $sBtnExit . "\r\n");
      $nm_saida->saida("</div>\r\n");
      $sUrlConfigXml = "./";
      $nm_saida->saida("<form name=\"refresh_chart\" action=\"" . $sUrlConfigXml . "\" method=\"POST\">\r\n");
      foreach ($_POST as $postItem => $postValue)
      {
         $postData = 'name="' . $postItem . '" value="' . $postValue . '"';
         $nm_saida->saida("  <input type=\"hidden\" " . $postData . " />\r\n");
      }
      $nm_saida->saida("</form>\r\n");
   }

   function grafico_flash_chart($width, $height, $sFileLocal, $export, $arr_charts, $isPDF = 'N')
   {
      global $nm_saida;

      $sChartId = 'id_chart_' . mt_rand(1, 1000);
      $sDivId   = 'id_div_' . mt_rand(1, 1000);
      $sStyle   = 'Y' == $export ? ' style="position:absolute; top: 0px; left: 0px"' : '';
      $bMulti   = 1 < sizeof($arr_charts[0]);
      $nm_saida->saida("<div id=\"" . $sDivId . "\"" . $sStyle . "></div>\r\n");
      $sPDFHtmlCall  = "  var chart = new FusionCharts('" . $this->Ini->path_prod . "/third/fusioncharts/" . $this->getChartModule() . "/" . $this->getChartRenderer($bMulti) . ".swf', '" . $sChartId . "', '" . $width . "', '" . $height . "', '0', '1');";
      $sPDFHtmlCall .= "  chart.setXMLUrl('" . $sFileLocal . "');";
      $sPDFHtmlCall .= "  chart.render('" . $sDivId . "');";
      if ("N" == $isPDF)
      {
         $nm_saida->saida("<script type=\"text/javascript\" language=\"javascript\">\r\n");
         $nm_saida->saida("  FusionCharts.setCurrentRenderer(\"javascript\");\r\n");
         $nm_saida->saida("$sPDFHtmlCall\r\n");
         $nm_saida->saida("</script>\r\n");
      }
      else
      {
         if (!isset($_SESSION['sc_session'][$this->Ini->sc_page]['grafico_reparaciones']['charts_html']) || '' == $_SESSION['sc_session'][$this->Ini->sc_page]['grafico_reparaciones']['charts_html'])
         {
             $_SESSION['sc_session'][$this->Ini->sc_page]['grafico_reparaciones']['charts_html'] = "  FusionCharts.setCurrentRenderer('javascript');";
         }
         $_SESSION['sc_session'][$this->Ini->sc_page]['grafico_reparaciones']['charts_html'] .= $sPDFHtmlCall;
      }
   }

   function string_to_utf8($str)
   {
       if ('UTF-8' != $_SESSION['scriptcase']['charset'])
       {
           $str = mb_convert_encoding($str, 'UTF-8', $_SESSION['scriptcase']['charset']);
       }
       return $str;
   }

   function grafico_dados($cht_data, $export)
   {
       $datay      = $cht_data['values'];
       $label      = $cht_data['labels'];
       $link       = $cht_data['grid_links'];
       $link_anal  = array();
       $value_anal = array();
       $xml        = $cht_data['xml_links'];
       $name       = $cht_data['label_x'];

       $arr_charts = array();

       if ('Y' != $export)
       {
           if ('xml' == $export)
           {
               $arr_data = $datay['sint'];
           }
           elseif (!$this->sc_graf_sint && isset($datay['anal']) && !empty($datay['anal']))
           {
               $arr_data   = $datay['anal'];
               $link_anal  = $datay['anal_links'];
               $value_anal = $datay['anal_values'];
               $label      = isset($cht_data['labels_anal']) && !empty($cht_data['labels_anal']) ? $cht_data['labels_anal'] : $cht_data['labels'];
           }
           else
           {
               $arr_data = $datay['sint'];
           }
           $arr_series = array();

           foreach ($label as $i => $v)
           {
               $label[$i] = $this->string_to_utf8($v);
           }

           foreach ($arr_data as $i_chart => $arr_chart)
           {
               $arr_series[] = array('name' => $this->string_to_utf8($i_chart), 'serie_val' => isset($value_anal[$i_chart]) ? $value_anal[$i_chart] : $i_chart, 'label' => $label, 'data' => $arr_chart, 'title' => $cht_data['title'], 'subtitle' => $cht_data['subtitle'], 'label_x' => $cht_data['label_x'], 'label_y' => $cht_data['label_y'], 'legend' => $cht_data['legend'], 'format' => $cht_data['format'], 'link' => $link, 'link_anal' => $link_anal, 'xml_link' => $xml);
           }

           $arr_charts[] = $arr_series;
       }
       else
       {
           foreach ($_SESSION['sc_session'][$this->Ini->sc_page]['grafico_reparaciones']['pivot_charts'] as $chart_index => $chart_data)
           {
               $datay = $chart_data['values'];
               $label = $chart_data['labels'];
               $link  = $chart_data['grid_links'];
               $xml   = $chart_data['xml_links'];
               $name  = $chart_data['label_x'];

               if (!$this->sc_graf_sint && isset($datay['anal']) && !empty($datay['anal']))
               {
                   $arr_data   = $datay['anal'];
                   $link_anal  = $datay['anal_links'];
                   $value_anal = $datay['anal_values'];
                   $label      = isset($chart_data['labels_anal']) && !empty($chart_data['labels_anal']) ? $chart_data['labels_anal'] : $chart_data['labels'];
               }
               else
               {
                   $arr_data = $datay['sint'];
               }
               $arr_series = array();

               foreach ($label as $i => $v)
               {
                   $label[$i] = $this->string_to_utf8($v);
               }

               foreach ($arr_data as $i_chart =>$arr_chart)
               {
                   $arr_series[] = array('name' => $this->string_to_utf8($i_chart), 'serie_val' => isset($value_anal[$i_chart]) ? $value_anal[$i_chart] : $i_chart, 'label' => $label, 'data' => $arr_chart, 'title' => $chart_data['title'], 'subtitle' => $chart_data['subtitle'], 'label_x' => $chart_data['label_x'], 'label_y' => $chart_data['label_y'], 'legend' => $chart_data['legend'], 'format' => $chart_data['format'], 'link' => $link, 'link_anal' => $link_anal, 'xml_link' => $xml);
               }

               $arr_charts[] = $arr_series;
           }
       }

       return $arr_charts;
   }

   function orderCharts(&$arr_charts, $rule = '')
   {
       if ('' == $rule)
       {
           return;
       }

       foreach ($arr_charts as $i => $c)
       {
           if (1 == sizeof($c))
           {
               $this->orderChart($arr_charts[$i][0]['label'], $arr_charts[$i][0]['data'], $arr_charts[$i][0]['link'], $rule);
           }
       }
   }

   function orderChart(&$label, &$data, &$link, $rule = '')
   {
       if ('' == $rule)
       {
           return;
       }
       elseif ('asc' == $rule)
       {
           asort($data);
       }
       elseif ('desc' == $rule)
       {
           arsort($data);
       }

       $new_data  = array();
       $new_label = array();
       $new_link  = array();
       foreach ($data as $i => $v)
       {
           $new_data[]  = $v;
           $new_label[] = $label[$i];
           $new_link[]  = $link[$i];
       }
       $data  = $new_data;
       $label = $new_label;
       $link  = $new_link;
   }

   function getChartRenderer($bMulti)
   {
       $sChart = '';
       $sMulti = $bMulti ? 'MS' : '';
       switch ($_SESSION['sc_session'][$this->Ini->sc_page]['grafico_reparaciones']['parms_graf']['graf_tipo'])
       {
           case 'Bar':
               if ('Horizontal' == $_SESSION['sc_session'][$this->Ini->sc_page]['grafico_reparaciones']['parms_graf']['graf_barra_orien'])
               {
                   if ('Off' != $_SESSION['sc_session'][$this->Ini->sc_page]['grafico_reparaciones']['parms_graf']['graf_barra_empil'] && $bMulti)
                   {
                       $sChart .= 'StackedBar';
                       $sChart .= '3d' == $_SESSION['sc_session'][$this->Ini->sc_page]['grafico_reparaciones']['parms_graf']['graf_barra_dimen'] && $bMulti ? '3D' : '2D';
                   }
                   else
                   {
                       $sChart .= $sMulti . 'Bar';
                       $sChart .= '3d' == $_SESSION['sc_session'][$this->Ini->sc_page]['grafico_reparaciones']['parms_graf']['graf_barra_dimen'] && $bMulti ? '3D' : '2D';
                   }
               }
               else
               {
                   if ('Off' != $_SESSION['sc_session'][$this->Ini->sc_page]['grafico_reparaciones']['parms_graf']['graf_barra_empil'] && $bMulti)
                   {
                       $sChart .= 'StackedColumn';
                       $sChart .= '2d' == $_SESSION['sc_session'][$this->Ini->sc_page]['grafico_reparaciones']['parms_graf']['graf_barra_dimen'] ? '2D' : '3D';
                   }
                   else
                   {
                       $sChart .= $sMulti . 'Column';
                       $sChart .= '2d' == $_SESSION['sc_session'][$this->Ini->sc_page]['grafico_reparaciones']['parms_graf']['graf_barra_dimen'] ? '2D' : '3D';
                   }
               }
               break;
           case 'Pie':
               if ('Pie' == $_SESSION['sc_session'][$this->Ini->sc_page]['grafico_reparaciones']['parms_graf']['graf_pizza_forma'])
               {
                   $sChart .= 'Pie';
               }
               else
               {
                   $sChart .= 'Doughnut';
               }
               $sChart .= '2d' == $_SESSION['sc_session'][$this->Ini->sc_page]['grafico_reparaciones']['parms_graf']['graf_pizza_dimen'] ? '2D' : '3D';
               break;
           case 'Line':
               if ('Line' == $_SESSION['sc_session'][$this->Ini->sc_page]['grafico_reparaciones']['parms_graf']['graf_linha_forma'])
               {
                   $sChart .= $sMulti . 'Line';
               }
               elseif ('Spline' == $_SESSION['sc_session'][$this->Ini->sc_page]['grafico_reparaciones']['parms_graf']['graf_linha_forma'])
               {
                   $sChart .= $sMulti . 'Spline';
               }
               else
               {
                   $sChart .= 'MSStepLine';
               }
               break;
           case 'Area':
               if ('Area' == $_SESSION['sc_session'][$this->Ini->sc_page]['grafico_reparaciones']['parms_graf']['graf_area_forma'])
               {
                   if ($bMulti)
                   {
                       $sChart .= $sMulti . 'Area';
                   }
                   else
                   {
                       $sChart .= 'Area2D';
                   }
               }
               else
               {
                   $sChart .= $sMulti . 'SplineArea';
               }
               break;
           case 'Mark':
               $sChart .= 'Column3D';
               break;
           case 'Gauge':
               $sChart .= 'AngularGauge';
               break;
           case 'Radar':
           case 'Polar':
               $sChart .= 'Radar';
               break;
           case 'Funnel':
               $sChart .= 'Funnel';
               break;
           case 'Pyramid':
               $sChart = 'Pyramid';
               break;
       }
       return $sChart;
   }

   function getChartModule($sChartType = '')
   {
       if ('' == $sChartType)
       {
           $sChartType = $_SESSION['sc_session'][$this->Ini->sc_page]['grafico_reparaciones']['parms_graf']['graf_tipo'];
       }
       switch ($sChartType)
       {
           case 'Bar':
               return 'FusionCharts';
               break;
           case 'Pie':
               return 'FusionCharts';
               break;
           case 'Line':
               if ('Line' == $_SESSION['sc_session'][$this->Ini->sc_page]['grafico_reparaciones']['parms_graf']['graf_linha_forma'])
               {
                   return 'FusionCharts';
               }
               elseif ('Spline' == $_SESSION['sc_session'][$this->Ini->sc_page]['grafico_reparaciones']['parms_graf']['graf_linha_forma'])
               {
                   return 'PowerCharts';
               }
               else
               {
                   return 'PowerCharts';
               }
               break;
           case 'Area':
               if ('Area' == $_SESSION['sc_session'][$this->Ini->sc_page]['grafico_reparaciones']['parms_graf']['graf_area_forma'])
               {
                   return 'FusionCharts';
               }
               else
               {
                   return 'PowerCharts';
               }
               break;
           case 'Mark':
               return 'FusionCharts';
               break;
           case 'Gauge':
               return 'FusionWidgets';
               break;
           case 'Radar':
           case 'Polar':
               return 'PowerCharts';
               break;
           case 'Pyramid':
               return 'FusionWidgets';
               break;
           case 'Funnel':
               return 'FusionWidgets';
               break;
       }
       return $sChart;
   }

   function getColorList($values, $colors)
   {
       $iValCount = 0;
       foreach ($values as $serie)
       {
           $iValCount = max($iValCount, sizeof($serie['label']));
       }
       $aColors   = explode(',', $colors);
       $iColCount = sizeof($aColors);
       $aMulti    = $this->getDivisions($iValCount, $iColCount);
       if (1 == $aMulti)
       {
           return $aColors[0];
       }
       $aAllColors = $this->getAllColors($aMulti[2], $aColors);
       return implode(',', $this->getUsedColors($aMulti[1], $iValCount, $aAllColors));
   }

   function getDivisions($a, $b)
   {
       if (1 >= $a || 1 >= $b)
       {
           return 1;
       }
       return $this->getSubDivisions($a, 0, $b, 0);
   }

   function getSubDivisions($a, $am, $b, $bm)
   {
       $v1 = $a + (($a - 1) * $am);
       $v2 = $b + (($b - 1) * $bm);
       if ($v1 == $v2)
       {
           return array($v1, $am, $bm);
       }
       elseif ($v1 > $v2)
       {
           return $this->getSubDivisions($a, $am, $b, $bm + 1);
       }
       else
       {
           return $this->getSubDivisions($a, $am + 1, $b, $bm);
       }
   }

   function getAllColors($div, $colors)
   {
       $aNewColors = array($colors[0]);
       for ($i = 1; $i < sizeof($colors); $i++)
       {
           $this->getColorIntervals($aNewColors, $colors[$i - 1], $colors[$i], $div);
           $aNewColors[] = $colors[$i];
       }
       return $aNewColors;
   }

   function getUsedColors($div, $count, $colors)
   {
       $used = array();
       for ($i = 0; $i < $count; $i++)
       {
           $used[] = $colors[($div + 1) * $i];
       }
       return $used;
   }

   function getColorIntervals(&$colors, $first, $last, $div)
   {
       $RGBini = $this->hex2dec($first);
       $RGBend = $this->hex2dec($last);
       $RGBint = array(
           abs(($RGBini[0] - $RGBend[0]) / ($div + 1)),
           abs(($RGBini[1] - $RGBend[1]) / ($div + 1)),
           abs(($RGBini[2] - $RGBend[2]) / ($div + 1)),
       );
       for ($i = 1; $i <= $div; $i++)
       {
           $newR = $RGBini[0] > $RGBend[0] ? $RGBini[0] - ($i * $RGBint[0]) : $RGBini[0] + ($i * $RGBint[0]);
           $newG = $RGBini[1] > $RGBend[1] ? $RGBini[1] - ($i * $RGBint[1]) : $RGBini[1] + ($i * $RGBint[1]);
           $newB = $RGBini[2] > $RGBend[2] ? $RGBini[2] - ($i * $RGBint[2]) : $RGBini[2] + ($i * $RGBint[2]);
           $colors[] = $this->dec2hex($newR, $newG, $newB);
       }
   }

   function hex2dec($color)
   {
       $dec = explode(' ', chunk_split($color, 2, ' '));
       return array(
           hexdec($dec[0]),
           hexdec($dec[1]),
           hexdec($dec[2]),
       );
   }

   function dec2hex($r, $g, $b)
   {
       $newr = dechex(round($r));
       if (1 == strlen($newr))
       {
           $newr = '0' . $newr;
       }
       $newg = dechex(round($g));
       if (1 == strlen($newg))
       {
           $newg = '0' . $newg;
       }
       $newb = dechex(round($b));
       if (1 == strlen($newb))
       {
           $newb = '0' . $newb;
       }
       return $newr . $newg . $newb;
   }

//
}

?>
