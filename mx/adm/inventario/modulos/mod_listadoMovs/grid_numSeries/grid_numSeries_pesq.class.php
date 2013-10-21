<?php

class grid_numSeries_pesq
{
   var $Db;
   var $Erro;
   var $Ini;
   var $Lookup;
   var $cmp_formatado;
   var $nm_data;
   var $Campos_Mens_erro;

   var $comando;
   var $comando_sum;
   var $comando_filtro;
   var $comando_ini;
   var $comando_fim;
   var $NM_operador;
   var $NM_data_qp;
   var $NM_path_filter;
   var $NM_curr_fil;
   var $nm_location;
   var $nmgp_botoes = array();
   var $NM_fil_ant = array();
   var $ajax_return_fields = array();

   /**
    * @access  public
    */
   function grid_numSeries_pesq()
   {
   }

   /**
    * @access  public
    * @global  string  $bprocessa  
    */
   function monta_busca()
   {
      global $bprocessa;
      include("../_lib/css/" . $this->Ini->str_schema_filter . "_filter.php");
      $this->Ini->Str_btn_filter = trim($str_button) . "/" . trim($str_button) . ".php";
      $this->Str_btn_filter_css  = trim($str_button) . "/" . trim($str_button) . ".css";
      include($this->Ini->path_btn . $this->Ini->Str_btn_filter);
      $_SESSION['sc_session'][$this->Ini->sc_page]['grid_numSeries']['path_libs_php'] = $this->Ini->path_lib_php;
      $this->Img_sep_filter = "/" . trim($str_toolbar_separator);
      $this->Block_img_col  = trim($str_block_col);
      $this->Block_img_exp  = trim($str_block_exp);
      $this->Bubble_tail    = trim($str_bubble_tail);
      $this->Ini->sc_Include($this->Ini->path_lib_php . "/nm_gp_config_btn.php", "F", "nmButtonOutput"); 
      if ($this->NM_ajax_flag)
      {
          $this->NM_ajax_info['param']['buffer_output'] = true;
          ob_start();
          $this->processa_ajax();
          $this->Db->Close(); 
          exit;
      }
      if (isset($bprocessa) && "pesq" == $bprocessa)
      {
         $this->processa_busca();
      }
      else
      {
         $this->monta_formulario();
      }
   }

   /**
    * @access  public
    */
   function monta_formulario()
   {
      $this->init();
      $this->monta_html_ini();
      $this->monta_cabecalho();
      $this->monta_form();
      $this->monta_html_fim();
   }

   /**
    * @access  public
    */
   function init()
   {
      $_SESSION['scriptcase']['sc_tab_meses']['int'] = array(
                                  $this->Ini->Nm_lang['lang_mnth_janu'],
                                  $this->Ini->Nm_lang['lang_mnth_febr'],
                                  $this->Ini->Nm_lang['lang_mnth_marc'],
                                  $this->Ini->Nm_lang['lang_mnth_apri'],
                                  $this->Ini->Nm_lang['lang_mnth_mayy'],
                                  $this->Ini->Nm_lang['lang_mnth_june'],
                                  $this->Ini->Nm_lang['lang_mnth_july'],
                                  $this->Ini->Nm_lang['lang_mnth_augu'],
                                  $this->Ini->Nm_lang['lang_mnth_sept'],
                                  $this->Ini->Nm_lang['lang_mnth_octo'],
                                  $this->Ini->Nm_lang['lang_mnth_nove'],
                                  $this->Ini->Nm_lang['lang_mnth_dece']);
      $_SESSION['scriptcase']['sc_tab_meses']['abr'] = array(
                                  $this->Ini->Nm_lang['lang_shrt_mnth_janu'],
                                  $this->Ini->Nm_lang['lang_shrt_mnth_febr'],
                                  $this->Ini->Nm_lang['lang_shrt_mnth_marc'],
                                  $this->Ini->Nm_lang['lang_shrt_mnth_apri'],
                                  $this->Ini->Nm_lang['lang_shrt_mnth_mayy'],
                                  $this->Ini->Nm_lang['lang_shrt_mnth_june'],
                                  $this->Ini->Nm_lang['lang_shrt_mnth_july'],
                                  $this->Ini->Nm_lang['lang_shrt_mnth_augu'],
                                  $this->Ini->Nm_lang['lang_shrt_mnth_sept'],
                                  $this->Ini->Nm_lang['lang_shrt_mnth_octo'],
                                  $this->Ini->Nm_lang['lang_shrt_mnth_nove'],
                                  $this->Ini->Nm_lang['lang_shrt_mnth_dece']);
      $_SESSION['scriptcase']['sc_tab_dias']['int'] = array(
                                  $this->Ini->Nm_lang['lang_days_sund'],
                                  $this->Ini->Nm_lang['lang_days_mond'],
                                  $this->Ini->Nm_lang['lang_days_tued'],
                                  $this->Ini->Nm_lang['lang_days_wend'],
                                  $this->Ini->Nm_lang['lang_days_thud'],
                                  $this->Ini->Nm_lang['lang_days_frid'],
                                  $this->Ini->Nm_lang['lang_days_satd']);
      $_SESSION['scriptcase']['sc_tab_dias']['abr'] = array(
                                  $this->Ini->Nm_lang['lang_shrt_days_sund'],
                                  $this->Ini->Nm_lang['lang_shrt_days_mond'],
                                  $this->Ini->Nm_lang['lang_shrt_days_tued'],
                                  $this->Ini->Nm_lang['lang_shrt_days_wend'],
                                  $this->Ini->Nm_lang['lang_shrt_days_thud'],
                                  $this->Ini->Nm_lang['lang_shrt_days_frid'],
                                  $this->Ini->Nm_lang['lang_shrt_days_satd']);
      $this->Ini->sc_Include($this->Ini->path_lib_php . "/nm_data.class.php", "C", "nm_data") ; 
      $this->nm_data = new nm_data("es");
      $pos_path = strrpos($this->Ini->path_prod, "/");
      $this->NM_path_filter = $this->Ini->root . substr($this->Ini->path_prod, 0, $pos_path) . "/conf/filters/";
      $_SESSION['sc_session'][$this->Ini->sc_page]['grid_numSeries']['opcao'] = "igual";
   }

   function processa_ajax()
   {
      global 
      $id_cond, $id,
             $serie_cond, $serie,
             $noparte_cond, $noparte,
             $status_cond, $status,
             $nombrecliente_cond, $nombrecliente,
             $almacenasociado_cond, $almacenasociado,
      $NM_filters, $NM_filters_del, $nmgp_save_name, $NM_operador, $nmgp_save_option, $bprocessa, $Ajax_label, $Ajax_val, $Campo_bi, $Opc_bi;
      $this->init();
      if (isset($this->NM_ajax_info['param']['id_cond']))
      {
          $id_cond = $this->NM_ajax_info['param']['id_cond'];
      }
      if (isset($this->NM_ajax_info['param']['id']))
      {
          $id = $this->NM_ajax_info['param']['id'];
      }
      if (isset($this->NM_ajax_info['param']['serie_cond']))
      {
          $serie_cond = $this->NM_ajax_info['param']['serie_cond'];
      }
      if (isset($this->NM_ajax_info['param']['serie']))
      {
          $serie = $this->NM_ajax_info['param']['serie'];
      }
      if (isset($this->NM_ajax_info['param']['noparte_cond']))
      {
          $noparte_cond = $this->NM_ajax_info['param']['noparte_cond'];
      }
      if (isset($this->NM_ajax_info['param']['noparte']))
      {
          $noparte = $this->NM_ajax_info['param']['noparte'];
      }
      if (isset($this->NM_ajax_info['param']['status_cond']))
      {
          $status_cond = $this->NM_ajax_info['param']['status_cond'];
      }
      if (isset($this->NM_ajax_info['param']['status']))
      {
          $status = $this->NM_ajax_info['param']['status'];
      }
      if (isset($this->NM_ajax_info['param']['nombrecliente_cond']))
      {
          $nombrecliente_cond = $this->NM_ajax_info['param']['nombrecliente_cond'];
      }
      if (isset($this->NM_ajax_info['param']['nombrecliente']))
      {
          $nombrecliente = $this->NM_ajax_info['param']['nombrecliente'];
      }
      if (isset($this->NM_ajax_info['param']['almacenasociado_cond']))
      {
          $almacenasociado_cond = $this->NM_ajax_info['param']['almacenasociado_cond'];
      }
      if (isset($this->NM_ajax_info['param']['almacenasociado']))
      {
          $almacenasociado = $this->NM_ajax_info['param']['almacenasociado'];
      }
      if (isset($this->NM_ajax_info['param']['NM_filters']))
      {
          $NM_filters = $this->NM_ajax_info['param']['NM_filters'];
      }
      if (isset($this->NM_ajax_info['param']['NM_filters_del']))
      {
          $NM_filters_del = $this->NM_ajax_info['param']['NM_filters_del'];
      }
      if (isset($this->NM_ajax_info['param']['nmgp_save_name']))
      {
          $nmgp_save_name = $this->NM_ajax_info['param']['nmgp_save_name'];
      }
      if (isset($this->NM_ajax_info['param']['NM_operador']))
      {
          $NM_operador = $this->NM_ajax_info['param']['NM_operador'];
      }
      if (isset($this->NM_ajax_info['param']['nmgp_save_option']))
      {
          $nmgp_save_option = $this->NM_ajax_info['param']['nmgp_save_option'];
      }
      if (isset($this->NM_ajax_info['param']['nmgp_refresh_fields']))
      {
          $nmgp_refresh_fields = $this->NM_ajax_info['param']['nmgp_refresh_fields'];
      }
      if (isset($this->NM_ajax_info['param']['bprocessa']))
      {
          $bprocessa = $this->NM_ajax_info['param']['bprocessa'];
      }
      if (isset($nmgp_refresh_fields))
      {
          $nmgp_refresh_fields = explode('_#fld#_', $nmgp_refresh_fields);
      }
      else
      {
          $nmgp_refresh_fields = array();
      }
//-- ajax metodos ---
      if (isset($bprocessa) && $bprocessa == "save_form")
      {
          $this->salva_filtro();
          $this->NM_fil_ant = $this->gera_array_filtros();
          $Nome_filter = "";
          $Opt_filter  = "<option value=\"\"></option>\r\n";
          foreach ($this->NM_fil_ant as $Cada_filter => $Tipo_filter)
          {
              if ($_SESSION['scriptcase']['charset'] != "UTF-8")
              {
                  $Tipo_filter[1] = mb_convert_encoding($Tipo_filter[1], "UTF-8", $_SESSION['scriptcase']['charset']);
              }
              if ($Tipo_filter[1] != $Nome_filter)
              {
                  $Nome_filter = $Tipo_filter[1];
                  $Opt_filter .= "<option value=\"\">" . grid_numSeries_pack_protect_string($Nome_filter) . "</option>\r\n";
              }
              $Opt_filter .= "<option value=\"" . grid_numSeries_pack_protect_string($Tipo_filter[0]) . "\">.." . grid_numSeries_pack_protect_string($Cada_filter) .  "</option>\r\n";
          }
          $Ajax_select = "<SELECT id=\"sel_recup_filters_bot\" name=\"NM_filters_bot\" onChange=\"nm_submit_filter(this, 'bot')\" size=\"1\">\r\n";
          $this->NM_ajax_info['fldList']['NM_filters_bot'] = array(
                     'type'    => "select",
                     'optList' => $Ajax_select . $Opt_filter . "</SELECT>\r\n",
                     );
          $Ajax_select = "<SELECT id=\"sel_filters_del_bot\" name=\"NM_filters_del_bot\" size=\"1\">\r\n";
          $this->NM_ajax_info['fldList']['NM_filters_del_bot'] = array(
                     'type'    => "select",
                     'optList' => $Ajax_select . $Opt_filter . "</SELECT>\r\n",
                     );
      }

      if (isset($bprocessa) && $bprocessa == "filter_delete")
      {
          $this->apaga_filtro();
          $this->NM_fil_ant = $this->gera_array_filtros();
          $Nome_filter = "";
          $Opt_filter  = "<option value=\"\"></option>\r\n";
          foreach ($this->NM_fil_ant as $Cada_filter => $Tipo_filter)
          {
              if ($_SESSION['scriptcase']['charset'] != "UTF-8")
              {
                  $Tipo_filter[1] = mb_convert_encoding($Tipo_filter[1], "UTF-8", $_SESSION['scriptcase']['charset']);
              }
              if ($Tipo_filter[1] != $Nome_filter)
              {
                  $Nome_filter  = $Tipo_filter[1];
                  $Opt_filter .= "<option value=\"\">" .  grid_numSeries_pack_protect_string($Nome_filter) . "</option>\r\n";
              }
              $Opt_filter .= "<option value=\"" . grid_numSeries_pack_protect_string($Tipo_filter[0]) . "\">.." . grid_numSeries_pack_protect_string($Cada_filter) .  "</option>\r\n";
          }
          $Ajax_select = "<SELECT id=\"sel_recup_filters_bot\" name=\"NM_filters_bot\" onChange=\"nm_submit_filter(this, 'bot')\" size=\"1\">\r\n";
          $this->NM_ajax_info['fldList']['NM_filters_bot'] = array(
                     'type'    => "select",
                     'optList' => $Ajax_select . $Opt_filter . "</SELECT>\r\n",
                     );
          $Ajax_select = "<SELECT id=\"sel_filters_del_bot\" name=\"NM_filters_del_bot\" size=\"1\">\r\n";
          $this->NM_ajax_info['fldList']['NM_filters_del_bot'] = array(
                     'type'    => "select",
                     'optList' => $Ajax_select . $Opt_filter . "</SELECT>\r\n",
                     );
      }

      if (isset($bprocessa) && $bprocessa == "filter_save")
      {
          $this->recupera_filtro();
          foreach ($this->ajax_return_fields as $cada_cmp => $cada_opt)
          {
              $this->NM_ajax_info['fldList'][$cada_cmp] = array(
                         'type'    => $cada_opt['obj'],
                         'valList' => $cada_opt['vallist'],
                         );
          }
      }

      if (isset($bprocessa) && $bprocessa == "proc_bi")
      {
          $this->process_cond_bi($Opc_bi, $BI_data1, $BI_data2);
          $this->NM_ajax_info['fldList'][$Campo_bi . "_dia"] = array('type' => 'text', 'valList' => array(substr($BI_data1, 0, 2)));
          $this->NM_ajax_info['fldList'][$Campo_bi . "_mes"] = array('type' => 'text', 'valList' => array(substr($BI_data1, 2, 2)));
          $this->NM_ajax_info['fldList'][$Campo_bi . "_ano"] = array('type' => 'text', 'valList' => array(substr($BI_data1, 4)));
          $this->NM_ajax_info['fldList'][$Campo_bi . "_input_2_dia"] = array('type' => 'text', 'valList' => array(substr($BI_data2, 0, 2)));
          $this->NM_ajax_info['fldList'][$Campo_bi . "_input_2_mes"] = array('type' => 'text', 'valList' => array(substr($BI_data2, 2, 2)));
          $this->NM_ajax_info['fldList'][$Campo_bi . "_input_2_ano"] = array('type' => 'text', 'valList' => array(substr($BI_data2, 4)));
      }
   }

   /**
    * @access  public
    */
   function processa_busca()
   {
      $this->inicializa_vars();
      $this->trata_campos();
      if (!empty($this->Campos_Mens_erro)) 
      {
          scriptcase_error_display($this->Campos_Mens_erro, ""); 
          $this->monta_formulario();
      }
      else
      {
          $this->finaliza_resultado();
      }
   }

   /**
    * @access  public
    */
   function and_or()
   {
      $posWhere = strpos(strtolower($this->comando), "where");
      if (FALSE === $posWhere)
      {
         $this->comando     .= " where ";
         $this->comando_sum .= " and ";
      }
      if ($this->comando_ini == "ini")
      {
          if (FALSE !== $posWhere)
          {
              $this->comando     .= " and ( ";
              $this->comando_sum .= " and ( ";
              $this->comando_fim  = " ) ";
          }
         $this->comando_ini  = "";
      }
      elseif ("or" == $this->NM_operador)
      {
         $this->comando        .= " or ";
         $this->comando_sum    .= " or ";
         $this->comando_filtro .= " or ";
      }
      else
      {
         $this->comando        .= " and ";
         $this->comando_sum    .= " and ";
         $this->comando_filtro .= " and ";
      }
   }

   /**
    * @access  public
    * @param  string  $nome  
    * @param  string  $condicao  
    * @param  mixed  $campo  
    * @param  mixed  $campo2  
    * @param  string  $nome_campo  
    * @param  string  $tp_campo  
    * @global  array  $nmgp_tab_label  
    */
   function monta_condicao($nome, $condicao, $campo, $campo2 = "", $nome_campo="", $tp_campo="")
   {
      global $nmgp_tab_label;
      $nm_aspas   = "'";
      $Nm_numeric = array();
      $nm_ini_lower = "";
      $nm_fim_lower = "";
      $Nm_numeric[] = "id";
      $campo_join = strtolower(str_replace(".", "_", $nome));
      if (in_array($campo_join, $Nm_numeric))
      {
         if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_numSeries']['decimal_db'] == ".")
         {
            $nm_aspas = "";
         }
         if ($condicao != "in")
         {
            if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_numSeries']['decimal_db'] == ".")
            {
               $campo  = str_replace(",", ".", $campo);
               $campo2 = str_replace(",", ".", $campo2);
            }
            if ($campo == "")
            {
               $campo = 0;
            }
            if ($campo2 == "")
            {
               $campo2 = 0;
            }
         }
      }
      if ($campo == "" && $condicao != "nu" && $condicao != "nn")
      {
         return;
      }
      else
      {
         $tmp_pos = strpos($campo, "##@@");
         if ($tmp_pos === false)
         {
             $res_lookup = $campo;
         }
         else
         {
             $res_lookup = substr($campo, $tmp_pos + 4);
             $campo = substr($campo, 0, $tmp_pos);
             if ($campo === "" && $condicao != "nu" && $condicao != "nn")
             {
                 return;
             }
         }
         $tmp_pos = strpos($this->cmp_formatado[$nome_campo], "##@@");
         if ($tmp_pos !== false)
         {
             $this->cmp_formatado[$nome_campo] = substr($this->cmp_formatado[$nome_campo], $tmp_pos + 4);
         }
         $this->and_or();
         $campo  = substr($this->Db->qstr($campo), 1, -1);
         $campo2 = substr($this->Db->qstr($campo2), 1, -1);
         $nome_sum = "num_series.$nome";
         if (substr($tp_campo, 0, 4) == "DATE" && in_array(strtolower($this->Ini->nm_tpbanco), $this->Ini->nm_bases_sybase))
         {
             $nome     = "str_replace (convert(char(10),$nome,102), '.', '-') + ' ' + convert(char(8),$nome,20)";
             $nome_sum = "str_replace (convert(char(10),$nome_sum,102), '.', '-') + ' ' + convert(char(8),$nome_sum,20)";
         }
         if (substr($tp_campo, 0, 4) == "DATE" && in_array(strtolower($this->Ini->nm_tpbanco), $this->Ini->nm_bases_mssql))
         {
             $nome     = "convert(char(23),$nome,121)";
             $nome_sum = "convert(char(23),$nome_sum,121)";
         }
         if (substr($tp_campo, 0, 5) == "TIMES" && in_array(strtolower($this->Ini->nm_tpbanco), $this->Ini->nm_bases_oracle))
         {
             $nome     = "TO_DATE(TO_CHAR($nome, 'yyyy-mm-dd hh24:mi:ss'), 'yyyy-mm-dd hh24:mi:ss')";
             $nome_sum = "TO_DATE(TO_CHAR($nome_sum, 'yyyy-mm-dd hh24:mi:ss'), 'yyyy-mm-dd hh24:mi:ss')";
             $tp_campo = "DATE" . substr($tp_campo, 5);
         }
         if (substr($tp_campo, 0, 8) == "DATETIME" && in_array(strtolower($this->Ini->nm_tpbanco), $this->Ini->nm_bases_informix))
         {
             $nome     = "EXTEND($nome, YEAR TO FRACTION)";
             $nome_sum = "EXTEND($nome_sum, YEAR TO FRACTION)";
         }
         elseif (substr($tp_campo, 0, 4) == "DATE" && in_array(strtolower($this->Ini->nm_tpbanco), $this->Ini->nm_bases_informix))
         {
             $nome     = "EXTEND($nome, YEAR TO DAY)";
             $nome_sum = "EXTEND($nome_sum, YEAR TO DAY)";
         }
         switch (strtoupper($condicao))
         {
            case "EQ":     // 
               $this->comando        .= $nm_ini_lower . $nome . $nm_fim_lower . " = " . $nm_aspas . $campo . $nm_aspas;
               $this->comando_sum    .= $nm_ini_lower . $nome_sum . $nm_fim_lower . " = " . $nm_aspas . $campo . $nm_aspas;
               $this->comando_filtro .= $nm_ini_lower . $nome . $nm_fim_lower. " = " . $nm_aspas . $campo . $nm_aspas;
               $_SESSION['sc_session'][$this->Ini->sc_page]['grid_numSeries']['cond_pesq'] .= $nmgp_tab_label[$nome_campo] . " " . $this->Ini->Nm_lang['lang_srch_equl'] . " " . $this->cmp_formatado[$nome_campo] . "##*@@";
            break;
            case "II":     // 
               $this->comando        .= $nm_ini_lower . $nome . $nm_fim_lower . " like '" . $campo . "%'";
               $this->comando_sum    .= $nm_ini_lower . $nome_sum . $nm_fim_lower . " like '" . $campo . "%'";
               $this->comando_filtro .= $nm_ini_lower . $nome . $nm_fim_lower . " like '" . $campo . "%'";
               $_SESSION['sc_session'][$this->Ini->sc_page]['grid_numSeries']['cond_pesq'] .= $nmgp_tab_label[$nome_campo] . " " . $this->Ini->Nm_lang['lang_srch_strt'] . " " . $this->cmp_formatado[$nome_campo] . "##*@@";
            break;
            case "QP":     // 
               if (substr($tp_campo, 0, 4) == "DATE")
               {
                   $NM_cond    = "";
                   $NM_cmd     = "";
                   $NM_cmd_sum = "";
                   if ($this->NM_data_qp['ano'] != "____")
                   {
                       $NM_cond    .= (empty($NM_cmd)) ? "" : " " . $this->Ini->Nm_lang['lang_srch_andd'] . " ";
                       $NM_cond    .= $this->Ini->Nm_lang['lang_srch_year'] . " " . $this->Ini->Nm_lang['lang_srch_equl'] . " " . $this->NM_data_qp['ano'];
                       $NM_cmd     .= (empty($NM_cmd)) ? "" : " and ";
                       $NM_cmd_sum .= (empty($NM_cmd_sum)) ? "" : " and ";
                       $NM_cmd     .= "year($nome) = " . $this->NM_data_qp['ano'];
                       $NM_cmd_sum .= "year($nome_sum) = " . $this->NM_data_qp['ano'];
                   }
                   if ($this->NM_data_qp['mes'] != "__")
                   {
                       $NM_cond    .= (empty($NM_cmd)) ? "" : " " . $this->Ini->Nm_lang['lang_srch_andd'] . " ";
                       $NM_cond    .= $this->Ini->Nm_lang['lang_srch_mnth'] . " " . $this->Ini->Nm_lang['lang_srch_equl'] . " " . $this->NM_data_qp['mes'];
                       $NM_cmd     .= (empty($NM_cmd)) ? "" : " and ";
                       $NM_cmd_sum .= (empty($NM_cmd_sum)) ? "" : " and ";
                       $NM_cmd     .= "month($nome) = " . $this->NM_data_qp['mes'];
                       $NM_cmd_sum .= "month($nome_sum) = " . $this->NM_data_qp['mes'];
                   }
                   if ($this->NM_data_qp['dia'] != "__")
                   {
                       $NM_cond    .= (empty($NM_cmd)) ? "" : " " . $this->Ini->Nm_lang['lang_srch_andd'] . " ";
                       $NM_cond    .= $this->Ini->Nm_lang['lang_srch_days'] . " " . $this->Ini->Nm_lang['lang_srch_equl'] . " " . $this->NM_data_qp['dia'];
                       $NM_cmd     .= (empty($NM_cmd)) ? "" : " and ";
                       $NM_cmd_sum .= (empty($NM_cmd_sum)) ? "" : " and ";
                       $NM_cmd     .= "day($nome) = " . $this->NM_data_qp['dia'];
                       $NM_cmd_sum .= "day($nome_sum) = " . $this->NM_data_qp['dia'];
                   }
                   if (!empty($NM_cmd))
                   {
                       $NM_cmd     = " (" . $NM_cmd . ")";
                       $NM_cmd_sum = " (" . $NM_cmd_sum . ")";
                       $this->comando        .= $NM_cmd;
                       $this->comando_sum    .= $NM_cmd_sum;
                       $this->comando_filtro .= $NM_cmd;
                       $_SESSION['sc_session'][$this->Ini->sc_page]['grid_numSeries']['cond_pesq'] .= $nmgp_tab_label[$nome_campo] . " " . $this->Ini->Nm_lang['lang_srch_like'] . " " . $NM_cond . "##*@@";
                   }
               }
               else
               {
                   $this->comando        .= $nm_ini_lower . $nome . $nm_fim_lower ." like '%" . $campo . "%'";
                   $this->comando_sum    .= $nm_ini_lower . $nome_sum . $nm_fim_lower . " like '%" . $campo . "%'";
                   $this->comando_filtro .= $nm_ini_lower . $nome . $nm_fim_lower . " like '%" . $campo . "%'";
                   $_SESSION['sc_session'][$this->Ini->sc_page]['grid_numSeries']['cond_pesq'] .= $nmgp_tab_label[$nome_campo] . " " . $this->Ini->Nm_lang['lang_srch_like'] . " " . $this->cmp_formatado[$nome_campo] . "##*@@";
               }
            break;
            case "DF":     // 
               if ($tp_campo == "DTDF" || $tp_campo == "DATEDF" || $tp_campo == "DATETIMEDF")
               {
                   $this->comando        .= $nm_ini_lower . $nome . $nm_fim_lower . " not like '%" . $campo . "%'";
                   $this->comando_sum    .= $nm_ini_lower . $nome_sum . $nm_fim_lower . " not like '%" . $campo . "%'";
                   $this->comando_filtro .= $nm_ini_lower . $nome . $nm_fim_lower . " not like '%" . $campo . "%'";
               }
               else
               {
                   $this->comando        .= $nm_ini_lower . $nome . $nm_fim_lower . " <> " . $nm_aspas . $campo . $nm_aspas;
                   $this->comando_sum    .= $nm_ini_lower . $nome_sum . $nm_fim_lower . " <> " . $nm_aspas . $campo . $nm_aspas;
                   $this->comando_filtro .= $nm_ini_lower . $nome . $nm_fim_lower . " <> " . $nm_aspas . $campo . $nm_aspas;
               }
               $_SESSION['sc_session'][$this->Ini->sc_page]['grid_numSeries']['cond_pesq'] .= $nmgp_tab_label[$nome_campo] . " " . $this->Ini->Nm_lang['lang_srch_diff'] . " " . $this->cmp_formatado[$nome_campo] . "##*@@";
            break;
            case "GT":     // 
               $this->comando        .= " $nome > " . $nm_aspas . $campo . $nm_aspas;
               $this->comando_sum    .= " $nome_sum > " . $nm_aspas . $campo . $nm_aspas;
               $this->comando_filtro .= " $nome > " . $nm_aspas . $campo . $nm_aspas;
               $_SESSION['sc_session'][$this->Ini->sc_page]['grid_numSeries']['cond_pesq'] .= $nmgp_tab_label[$nome_campo] . " " . $nmgp_lang['pesq_cond_maior'] . " " . $this->cmp_formatado[$nome_campo] . "##*@@";
            break;
            case "GE":     // 
               $this->comando        .= " $nome >= " . $nm_aspas . $campo . $nm_aspas;
               $this->comando_sum    .= " $nome_sum >= " . $nm_aspas . $campo . $nm_aspas;
               $this->comando_filtro .= " $nome >= " . $nm_aspas . $campo . $nm_aspas;
               $_SESSION['sc_session'][$this->Ini->sc_page]['grid_numSeries']['cond_pesq'] .= $nmgp_tab_label[$nome_campo] . " " . $this->Ini->Nm_lang['lang_srch_grtr_equl'] . " " . $this->cmp_formatado[$nome_campo] . "##*@@";
            break;
            case "LT":     // 
               $this->comando        .= " $nome < " . $nm_aspas . $campo . $nm_aspas;
               $this->comando_sum    .= " $nome_sum < " . $nm_aspas . $campo . $nm_aspas;
               $this->comando_filtro .= " $nome < " . $nm_aspas . $campo . $nm_aspas;
               $_SESSION['sc_session'][$this->Ini->sc_page]['grid_numSeries']['cond_pesq'] .= $nmgp_tab_label[$nome_campo] . " " . $this->Ini->Nm_lang['lang_srch_less'] . " " . $this->cmp_formatado[$nome_campo] . "##*@@";
            break;
            case "LE":     // 
               $this->comando        .= " $nome <= " . $nm_aspas . $campo . $nm_aspas;
               $this->comando_sum    .= " $nome_sum <= " . $nm_aspas . $campo . $nm_aspas;
               $this->comando_filtro .= " $nome <= " . $nm_aspas . $campo . $nm_aspas;
               $_SESSION['sc_session'][$this->Ini->sc_page]['grid_numSeries']['cond_pesq'] .= $nmgp_tab_label[$nome_campo] . " " . $this->Ini->Nm_lang['lang_srch_less_equl'] . " " . $this->cmp_formatado[$nome_campo] . "##*@@";
            break;
            case "BW":     // 
               if ($tp_campo == "DTDF" || $tp_campo == "DATEDF" || $tp_campo == "DATETIMEDF")
               {
                   $this->comando        .= " $nome not between " . $nm_aspas . $campo . $nm_aspas . " and " . $nm_aspas . $campo2 . $nm_aspas;
                   $this->comando_sum    .= " $nome_sum not between " . $nm_aspas . $campo . $nm_aspas . " and " . $nm_aspas . $campo2 . $nm_aspas;
                   $this->comando_filtro .= " $nome not between " . $nm_aspas . $campo . $nm_aspas . " and " . $nm_aspas . $campo2 . $nm_aspas;
                   $_SESSION['sc_session'][$this->Ini->sc_page]['grid_numSeries']['cond_pesq'] .= $nmgp_tab_label[$nome_campo] . " " . $this->Ini->Nm_lang['lang_srch_diff'] . " " . $this->cmp_formatado[$nome_campo] . "##*@@";
               }
               else
               {
                   $this->comando        .= " $nome between " . $nm_aspas . $campo . $nm_aspas . " and " . $nm_aspas . $campo2 . $nm_aspas;
                   $this->comando_sum    .= " $nome_sum between " . $nm_aspas . $campo . $nm_aspas . " and " . $nm_aspas . $campo2 . $nm_aspas;
                   $this->comando_filtro .= " $nome between " . $nm_aspas . $campo . $nm_aspas . " and " . $nm_aspas . $campo2 . $nm_aspas;
                   if ($tp_campo == "DTEQ" || $tp_campo == "DATEEQ" || $tp_campo == "DATETIMEEQ")
                   {
                       $_SESSION['sc_session'][$this->Ini->sc_page]['grid_numSeries']['cond_pesq'] .= $nmgp_tab_label[$nome_campo] . " " . $this->Ini->Nm_lang['lang_srch_equl'] . " " . $this->cmp_formatado[$nome_campo] . "##*@@";
                   }
                   else
                   {
                       $_SESSION['sc_session'][$this->Ini->sc_page]['grid_numSeries']['cond_pesq'] .= $nmgp_tab_label[$nome_campo] . " " . $this->Ini->Nm_lang['lang_srch_betw'] . " " . $this->cmp_formatado[$nome_campo] . " " . $this->Ini->Nm_lang['lang_srch_andd'] . " " . $this->cmp_formatado[$nome_campo . "_Input_2"] . "##*@@";
                   }
               }
            break;
            case "IN":     // 
               $nm_sc_valores = explode(",", $campo);
               $cond_str = "";
               $nm_cond  = "";
               if (!empty($nm_sc_valores))
               {
                   foreach ($nm_sc_valores as $nm_sc_valor)
                   {
                      if (in_array($campo_join, $Nm_numeric) && substr_count($nm_sc_valor, ".") > 1)
                      {
                         $nm_sc_valor = str_replace(".", "", $nm_sc_valor);
                      }
                      if ("" != $cond_str)
                      {
                         $cond_str .= ",";
                         $nm_cond  .= " " . $this->Ini->Nm_lang['lang_srch_orrr'] . " ";
                      }
                      $cond_str .= $nm_aspas . $nm_sc_valor . $nm_aspas;
                      $nm_cond  .= $nm_aspas . $nm_sc_valor . $nm_aspas;
                   }
               }
               $this->comando        .= $nm_ini_lower . $nome . $nm_fim_lower . " in (" . $cond_str . ")";
               $this->comando_sum    .= $nm_ini_lower . $nome_sum . $nm_fim_lower . " in (" . $cond_str . ")";
               $this->comando_filtro .= $nm_ini_lower . $nome . $nm_fim_lower . " in (" . $cond_str . ")";
               $_SESSION['sc_session'][$this->Ini->sc_page]['grid_numSeries']['cond_pesq'] .= $nmgp_tab_label[$nome_campo] . " " . $this->Ini->Nm_lang['lang_srch_like'] . " " . $nm_cond . "##*@@";
            break;
            case "NU":     // 
               $this->comando        .= " $nome IS NULL ";
               $this->comando_sum    .= " $nome_sum IS NULL ";
               $this->comando_filtro .= " $nome IS NULL ";
               $_SESSION['sc_session'][$this->Ini->sc_page]['grid_numSeries']['cond_pesq'] .= $nmgp_tab_label[$nome_campo] . " " . $this->Ini->Nm_lang['lang_srch_null'] ." " . $this->cmp_formatado[$nome_campo] . "##*@@";
            break;
            case "NN":     // 
               $this->comando        .= " $nome IS NOT NULL ";
               $this->comando_sum    .= " $nome_sum IS NOT NULL ";
               $this->comando_filtro .= " $nome IS NOT NULL ";
               $_SESSION['sc_session'][$this->Ini->sc_page]['grid_numSeries']['cond_pesq'] .= $nmgp_tab_label[$nome_campo] . " " . $this->Ini->Nm_lang['lang_srch_nnul'] . " " . $this->cmp_formatado[$nome_campo] . "##*@@";
            break;
         }
      }
   }

   /**
    * @access  public
    * @param  array  $data_arr  
    */
   function data_menor(&$data_arr)
   {
      $data_arr["ano"] = ("____" == $data_arr["ano"]) ? "0001" : $data_arr["ano"];
      $data_arr["mes"] = ("__" == $data_arr["mes"])   ? "01" : $data_arr["mes"];
      $data_arr["dia"] = ("__" == $data_arr["dia"])   ? "01" : $data_arr["dia"];
      $data_arr["hor"] = ("__" == $data_arr["hor"])   ? "00" : $data_arr["hor"];
      $data_arr["min"] = ("__" == $data_arr["min"])   ? "00" : $data_arr["min"];
      $data_arr["seg"] = ("__" == $data_arr["seg"])   ? "00" : $data_arr["seg"];
   }

   /**
    * @access  public
    * @param  array  $data_arr  
    */
   function data_maior(&$data_arr)
   {
      $data_arr["ano"] = ("____" == $data_arr["ano"]) ? "9999" : $data_arr["ano"];
      $data_arr["mes"] = ("__" == $data_arr["mes"])   ? "12" : $data_arr["mes"];
      $data_arr["hor"] = ("__" == $data_arr["hor"])   ? "23" : $data_arr["hor"];
      $data_arr["min"] = ("__" == $data_arr["min"])   ? "59" : $data_arr["min"];
      $data_arr["seg"] = ("__" == $data_arr["seg"])   ? "59" : $data_arr["seg"];
      if ("__" == $data_arr["dia"])
      {
          $data_arr["dia"] = "31";
          if ($data_arr["mes"] == "04" || $data_arr["mes"] == "06" || $data_arr["mes"] == "09" || $data_arr["mes"] == "11")
          {
              $data_arr["dia"] = 30;
          }
          elseif ($data_arr["mes"] == "02")
          { 
                  if  ($data_arr["ano"] % 4 == 0)
                  {
                       $data_arr["dia"] = 29;
                  }
                  else 
                  {
                       $data_arr["dia"] = 28;
                  }
          }
      }
   }

   /**
    * @access  public
    * @param  string  $nm_data_hora  
    */
   function limpa_dt_hor_pesq(&$nm_data_hora)
   {
      $nm_data_hora = str_replace("Y", "", $nm_data_hora); 
      $nm_data_hora = str_replace("M", "", $nm_data_hora); 
      $nm_data_hora = str_replace("D", "", $nm_data_hora); 
      $nm_data_hora = str_replace("H", "", $nm_data_hora); 
      $nm_data_hora = str_replace("I", "", $nm_data_hora); 
      $nm_data_hora = str_replace("S", "", $nm_data_hora); 
      $tmp_pos = strpos($nm_data_hora, "--");
      if ($tmp_pos !== FALSE)
      {
          $nm_data_hora = str_replace("--", "-", $nm_data_hora); 
      }
      $tmp_pos = strpos($nm_data_hora, "::");
      if ($tmp_pos !== FALSE)
      {
          $nm_data_hora = str_replace("::", ":", $nm_data_hora); 
      }
   }

   /**
    * @access  public
    */
   function retorna_pesq()
   {
      global $nm_apl_dependente;
   $NM_retorno = "./";
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
            "http://www.w3.org/TR/1999/REC-html401-19991224/loose.dtd">
<HTML>
<HEAD>
 <TITLE>Series Capturadas</TITLE>
 <META http-equiv="Content-Type" content="text/html; charset=<?php echo $_SESSION['scriptcase']['charset_html'] ?>" />
 <META http-equiv="Expires" content="Fri, Jan 01 1900 00:00:00 GMT"/>
 <META http-equiv="Last-Modified" content="<?php echo gmdate("D, d M Y H:i:s"); ?> GMT"/>
 <META http-equiv="Cache-Control" content="no-store, no-cache, must-revalidate"/>
 <META http-equiv="Cache-Control" content="post-check=0, pre-check=0"/>
 <META http-equiv="Pragma" content="no-cache"/>
</HEAD>
<BODY class="scGridPage">
<FORM style="display:none;" name="form_ok" method="POST" action="<?php echo $NM_retorno; ?>" target="_self">
<INPUT type="hidden" name="script_case_init" value="<?php echo NM_encode_input($this->Ini->sc_page); ?>"> 
<INPUT type="hidden" name="script_case_session" value="<?php echo NM_encode_input(session_id()); ?>"> 
<INPUT type="hidden" name="nmgp_opcao" value="pesq"> 
</FORM>
<SCRIPT type="text/javascript">
 document.form_ok.submit();
</SCRIPT>
</BODY>
</HTML>
<?php
}

   /**
    * @access  public
    */
   function monta_html_ini()
   {
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
            "http://www.w3.org/TR/1999/REC-html401-19991224/loose.dtd">
<HTML<?php echo $_SESSION['scriptcase']['reg_conf']['html_dir'] ?>>
<HEAD>
 <TITLE>Series Capturadas</TITLE>
 <META http-equiv="Content-Type" content="text/html; charset=<?php echo $_SESSION['scriptcase']['charset_html'] ?>" />
 <META http-equiv="Expires" content="Fri, Jan 01 1900 00:00:00 GMT"/>
 <META http-equiv="Last-Modified" content="<?php echo gmdate("D, d M Y H:i:s"); ?> GMT"/>
 <META http-equiv="Cache-Control" content="no-store, no-cache, must-revalidate"/>
 <META http-equiv="Cache-Control" content="post-check=0, pre-check=0"/>
 <META http-equiv="Pragma" content="no-cache"/>
 <link rel="stylesheet" href="<?php echo $this->Ini->path_prod ?>/third/jquery_plugin/thickbox/thickbox.css" type="text/css" media="screen" />
 <link rel="stylesheet" type="text/css" href="../_lib/css/<?php echo $this->Ini->str_schema_filter ?>_filter.css" /> 
 <link rel="stylesheet" type="text/css" href="../_lib/css/<?php echo $this->Ini->str_schema_filter ?>_error.css" /> 
 <link rel="stylesheet" type="text/css" href="../_lib/buttons/<?php echo $this->Str_btn_filter_css ?>" /> 
 <link rel="stylesheet" type="text/css" href="../_lib/css/<?php echo $this->Ini->str_schema_filter ?>_form.css" /> 
</HEAD>
<BODY class="scFilterPage">
<?php echo $this->Ini->Ajax_result_set ?>
<SCRIPT type="text/javascript" src="<?php echo $this->Ini->path_js . "/browserSniffer.js" ?>"></SCRIPT>
 <script type="text/javascript" src="<?php echo $this->Ini->path_prod ?>/third/jquery/js/jquery.js"></script>
 <script type="text/javascript" src="<?php echo $this->Ini->path_prod ?>/third/jquery_plugin/malsup-blockui/jquery.blockUI.js"></script>
 <script type="text/javascript" src="../_lib/lib/js/jquery.scInput.js"></script>
 <script type="text/javascript">var sc_pathToTB = '<?php echo $this->Ini->path_prod ?>/third/jquery_plugin/thickbox/';</script>
 <script type="text/javascript" src="<?php echo $this->Ini->path_prod ?>/third/jquery_plugin/thickbox/thickbox-compressed.js"></script>
 <script type="text/javascript">
   var sc_ajaxBg = '<?php echo $this->Ini->Color_bg_ajax ?>';
   var sc_ajaxBordC = '<?php echo $this->Ini->Border_c_ajax ?>';
   var sc_ajaxBordS = '<?php echo $this->Ini->Border_s_ajax ?>';
   var sc_ajaxBordW = '<?php echo $this->Ini->Border_w_ajax ?>';
 </script>
<?php
$Cod_Btn = nmButtonOutput($this->arr_buttons, "berrm_clse", "scAjaxHideDebug()", "scAjaxHideDebug()", "", "", "", "", "", "", "", $this->Ini->path_botoes, "", "", "", "", "", "only_text", "text_right", "", "");
?>
<div id="id_debug_window" style="display: none; position: absolute; left: 50px; top: 50px"><table class="scFormMessageTable">
<tr><td class="scFormMessageTitle"><?php echo $Cod_Btn ?>&nbsp;&nbsp;Output</td></tr>
<tr><td class="scFormMessageMessage" style="padding: 0px; vertical-align: top"><div style="padding: 2px; height: 200px; width: 350px; overflow: auto" id="id_debug_text"></div></td></tr>
</table></div>
 <SCRIPT type="text/javascript">

<?php
if (is_file($this->Ini->root . $this->Ini->path_link . "_lib/js/tab_erro_" . $this->Ini->str_lang . ".js"))
{
    $Tb_err_js = file($this->Ini->root . $this->Ini->path_link . "_lib/js/tab_erro_" . $this->Ini->str_lang . ".js");
    foreach ($Tb_err_js as $Lines)
    {
        if (NM_is_utf8($Lines) && $_SESSION['scriptcase']['charset'] != "UTF-8")
        {
            $Lines = mb_convert_encoding($Lines, $_SESSION['scriptcase']['charset'], "UTF-8");
        }
        echo $Lines;
    }
}
$Msg_Inval = mb_convert_encoding("Inválido", $_SESSION['scriptcase']['charset']);
?>
var SC_crit_inv = "<?php echo $Msg_Inval ?>";
var nmdg_Form = "F1";

 $(function() {

   SC_carga_evt_jquery();
   $('input:text.sc-js-input').listen();
 });
var NM_index = 0;
var NM_hidden = new Array();
var NM_IE = (navigator.userAgent.indexOf('MSIE') > -1) ? 1 : 0;
function NM_hitTest(o, l)
{
    function getOffset(o){
        for(var r = {l: o.offsetLeft, t: o.offsetTop, r: o.offsetWidth, b: o.offsetHeight};
            o = o.offsetParent; r.l += o.offsetLeft, r.t += o.offsetTop);
        return r.r += r.l, r.b += r.t, r;
    }
    for(var b, s, r = [], a = getOffset(o), j = isNaN(l.length), i = (j ? l = [l] : l).length; i;
        b = getOffset(l[--i]), (a.l == b.l || (a.l > b.l ? a.l <= b.r : b.l <= a.r))
        && (a.t == b.t || (a.t > b.t ? a.t <= b.b : b.t <= a.b)) && (r[r.length] = l[i]));
    return j ? !!r.length : r;
}
var tem_obj = false;
function NM_show_menu(nn)
{
    if (!NM_IE)
    {
         return;
    }
    x = document.getElementById(nn);
    x.style.display = "block";
    obj_sel = document.body;
    tem_obj = true;
    x.ieFix = NM_hitTest(x, obj_sel.getElementsByTagName("select"));
    for (i = 0; i <  x.ieFix.length; i++)
    {
      if (x.ieFix[i].style.visibility != "hidden")
      {
          x.ieFix[i].style.visibility = "hidden";
          NM_hidden[NM_index] = x.ieFix[i];
          NM_index++;
      }
    }
}
function NM_hide_menu()
{
    if (!NM_IE)
    {
         return;
    }
    obj_del = document.body;
    if (tem_obj && obj_del == obj_sel)
    {
        for(var i = NM_hidden.length; i; NM_hidden[--i].style.visibility = "visible");
    }
    NM_index = 0;
    NM_hidden = new Array();
}
 function nm_save_form(pos)
 {
  if (pos == 'top' && document.F1.nmgp_save_name_top.value == '')
  {
      return;
  }
  if (pos == 'bot' && document.F1.nmgp_save_name_bot.value == '')
  {
      return;
  }
  document.F1.bprocessa.value = "save_form";
  grid_numSeries_do_ajax_save_filter(pos);
 }
 function nm_submit_filter(obj_sel, pos)
 {
  index   = obj_sel.selectedIndex;
  if (obj_sel.options[index].value == "") 
  {
      return false;
  }
  document.F1.bprocessa.value = "filter_save";
  grid_numSeries_do_ajax_change_filter(pos);
 }
 function nm_submit_filter_del(pos)
 {
  if (pos == 'top')
  {
      obj_sel = document.F1.elements['NM_filters_del_top'];
  }
  if (pos == 'bot')
  {
      obj_sel = document.F1.elements['NM_filters_del_bot'];
  }
  index   = obj_sel.selectedIndex;
  if (obj_sel.options[index].value == "") 
  {
      return false;
  }
  document.F1.bprocessa.value = "filter_delete";
  grid_numSeries_do_ajax_delete_filter(pos);
 }
function nm_open_popup(parms)
{
    NovaJanela = window.open (parms, '', 'resizable, scrollbars');
}
 </SCRIPT>
<?php
include_once("grid_numSeries_sajax_js.php");
?>
<script type="text/javascript">
 $(function() {
 });
</script>
 <FORM name="F1" action="./" method="post" target="_self"> 
 <INPUT type="hidden" name="script_case_init" value="<?php echo NM_encode_input($this->Ini->sc_page); ?>"> 
 <INPUT type="hidden" name="script_case_session" value="<?php echo NM_encode_input(session_id()); ?>"> 
 <INPUT type="hidden" name="nmgp_opcao" value="busca"> 
 <INPUT type="image" id="SC_No_submit" src="<?php echo $this->Ini->path_imag_cab; ?>/scriptcase__NM__nm_transparent.gif" onClick="return false;" width="0" height="0"> 
 <div id="idJSSpecChar" style="display:none;"></div>
 <div id="id_div_process" style="display: none; position: absolute"><table class="scFilterTable"><tr><td class="scFilterLabelOdd"><?php echo $this->Ini->Nm_lang['lang_othr_prcs']; ?>...</td></tr></table></div>
 <div id="id_fatal_error" class="scFilterFieldOdd" style="display:none; position: absolute"></div>
<TABLE id="main_table" class="scFilterBorder" align="center" valign="top" >
  <div id="id_div_process_block" style="display: none; margin: 10px; whitespace: nowrap"><span class="scFormProcess"><img border="0" src="<?php echo $this->Ini->path_icones ?>/scriptcase__NM__ajax_load.gif" align="absmiddle" />&nbsp;<?php echo $this->Ini->Nm_lang['lang_othr_prcs'] ?>...</span></div>
<?php
   }

   /**
    * @access  public
    * @global  string  $bprocessa  
    */
   /**
    * @access  public
    */
   function monta_cabecalho()
   {
      $Str_date = strtolower($_SESSION['scriptcase']['reg_conf']['date_format']);
      $Lim   = strlen($Str_date);
      $Ult   = "";
      $Arr_D = array();
      for ($I = 0; $I < $Lim; $I++)
      {
          $Char = substr($Str_date, $I, 1);
          if ($Char != $Ult)
          {
              $Arr_D[] = $Char;
          }
          $Ult = $Char;
      }
      $Prim = true;
      $Str  = "";
      foreach ($Arr_D as $Cada_d)
      {
          $Str .= (!$Prim) ? $_SESSION['scriptcase']['reg_conf']['date_sep'] : "";
          $Str .= $Cada_d;
          $Prim = false;
      }
      $Str = str_replace("a", "Y", $Str);
      $Str = str_replace("y", "Y", $Str);
      $nm_data_fixa = date($Str); 
?>
 <TR align="center">
  <TD class="scFilterTableTd">
<style>
#lin1_col1 { padding-left:9px; padding-top:7px;  height:27px; overflow:hidden; text-align:left;}			 
#lin1_col2 { padding-right:9px; padding-top:7px; height:27px; text-align:right; overflow:hidden;   font-size:12px; font-weight:normal;}
</style>

<div style="width: 100%">
 <div class="scFilterHeader" style="height:11px; display: block; border-width:0px; "></div>
 <div style="height:37px; border-width:0px 0px 1px 0px;  border-style: dashed; border-color:#ddd; display: block">
 	<table style="width:100%; border-collapse:collapse; padding:0;">
    	<tr>
        	<td id="lin1_col1" class="scFilterHeaderFont"><span>Series Capturadas</span></td>
            <td id="lin1_col2" class="scFilterHeaderFont"><span><?php echo $nm_data_fixa; ?></span></td>
        </tr>
    </table>		 
 </div>
</div>
  </TD>
 </TR>
<?php
   }

   /**
    * @access  public
    * @global  string  $nm_url_saida  $this->Ini->Nm_lang['pesq_global_nm_url_saida']
    * @global  integer  $nm_apl_dependente  $this->Ini->Nm_lang['pesq_global_nm_apl_dependente']
    * @global  string  $nmgp_parms  
    * @global  string  $bprocessa  $this->Ini->Nm_lang['pesq_global_bprocessa']
    */
   function monta_form()
   {
      global 
             $id_cond, $id,
             $serie_cond, $serie,
             $noparte_cond, $noparte,
             $status_cond, $status,
             $nombrecliente_cond, $nombrecliente,
             $almacenasociado_cond, $almacenasociado,
             $nm_url_saida, $nm_apl_dependente, $nmgp_parms, $bprocessa, $nmgp_save_name, $NM_operador, $NM_filters, $nmgp_save_option, $NM_filters_del, $Script_BI;
      $Script_BI = "";
      $this->nmgp_botoes['clear'] = "on";
      $this->nmgp_botoes['save'] = "on";
      if (isset($_SESSION['scriptcase']['sc_apl_conf']['grid_numSeries']['btn_display']) && !empty($_SESSION['scriptcase']['sc_apl_conf']['grid_numSeries']['btn_display']))
      {
          foreach ($_SESSION['scriptcase']['sc_apl_conf']['grid_numSeries']['btn_display'] as $NM_cada_btn => $NM_cada_opc)
          {
              $this->nmgp_botoes[$NM_cada_btn] = $NM_cada_opc;
          }
      }
      if (isset($_SESSION['scriptcase']['sc_aba_iframe']))
      {
          foreach ($_SESSION['scriptcase']['sc_aba_iframe'] as $aba => $apls_aba)
          {
              if (in_array("grid_numSeries", $apls_aba))
              {
                  $this->aba_iframe = true;
                  break;
              }
          }
      }
      if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_numSeries']['iframe_menu'] && (!isset($_SESSION['scriptcase']['menu_mobile']) || empty($_SESSION['scriptcase']['menu_mobile'])))
      {
          $this->aba_iframe = true;
      }
      $nmgp_tab_label = "";
      $delimitador = "##@@";
      if (!empty($_SESSION['sc_session'][$this->Ini->sc_page]['grid_numSeries']['campos_busca']) && $bprocessa != "recarga" && $bprocessa != "save_form" && $bprocessa != "filter_save" && $bprocessa != "filter_delete")
      { 
          if ($_SESSION['scriptcase']['charset'] != "UTF-8")
          {
              $_SESSION['sc_session'][$this->Ini->sc_page]['grid_numSeries']['campos_busca'] = NM_conv_charset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_numSeries']['campos_busca'], $_SESSION['scriptcase']['charset'], "UTF-8");
          }
          $id = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_numSeries']['campos_busca']['id']; 
          $id_cond = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_numSeries']['campos_busca']['id_cond']; 
          $serie = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_numSeries']['campos_busca']['serie']; 
          $serie_cond = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_numSeries']['campos_busca']['serie_cond']; 
          $noparte = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_numSeries']['campos_busca']['noparte']; 
          $noparte_cond = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_numSeries']['campos_busca']['noparte_cond']; 
          $status = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_numSeries']['campos_busca']['status']; 
          $status_cond = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_numSeries']['campos_busca']['status_cond']; 
          $nombrecliente = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_numSeries']['campos_busca']['nombrecliente']; 
          $nombrecliente_cond = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_numSeries']['campos_busca']['nombrecliente_cond']; 
          $almacenasociado = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_numSeries']['campos_busca']['almacenasociado']; 
          $almacenasociado_cond = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_numSeries']['campos_busca']['almacenasociado_cond']; 
          $this->NM_operador = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_numSeries']['campos_busca']['NM_operador']; 
          if (strtoupper($id_cond) != "II" && strtoupper($id_cond) != "QP" && strtoupper($id_cond) != "IN") 
          { 
              nmgp_Form_Num_Val($id, $_SESSION['scriptcase']['reg_conf']['grup_num'], $_SESSION['scriptcase']['reg_conf']['dec_num'], "0", "S", "1", "", "N:" . $_SESSION['scriptcase']['reg_conf']['neg_num'] , $_SESSION['scriptcase']['reg_conf']['simb_neg'], $_SESSION['scriptcase']['reg_conf']['num_group_digit']) ; 
          } 
      } 
      if (isset($nmgp_save_name) && !empty($nmgp_save_name) && $bprocessa == "save_form")
      { 
          $this->salva_filtro();
      } 
      if (isset($NM_filters) && !empty($NM_filters) && $bprocessa == "filter_save")
      { 
          $this->recupera_filtro();
      } 
      if (isset($NM_filters_del) && !empty($NM_filters_del) && $bprocessa == "filter_delete")
      { 
          $this->apaga_filtro();
      } 
      if (!isset($id_cond) || empty($id_cond))
      {
         $id_cond = "eq";
      }
      if (!isset($serie_cond) || empty($serie_cond))
      {
         $serie_cond = "eq";
      }
      if (!isset($noparte_cond) || empty($noparte_cond))
      {
         $noparte_cond = "eq";
      }
      if (!isset($status_cond) || empty($status_cond))
      {
         $status_cond = "eq";
      }
      if (!isset($nombrecliente_cond) || empty($nombrecliente_cond))
      {
         $nombrecliente_cond = "eq";
      }
      if (!isset($almacenasociado_cond) || empty($almacenasociado_cond))
      {
         $almacenasociado_cond = "eq";
      }
      if (!isset($id) || $id == "")
      {
          $id = "";
      }
      if (isset($id) && !empty($id))
      {
         $tmp_pos = strpos($id, "##@@");
         if ($tmp_pos === false)
         { }
         else
         {
         $id = substr($id, 0, $tmp_pos);
         }
      }
      if (!isset($serie) || $serie == "")
      {
          $serie = "";
      }
      if (isset($serie) && !empty($serie))
      {
         $tmp_pos = strpos($serie, "##@@");
         if ($tmp_pos === false)
         { }
         else
         {
         $serie = substr($serie, 0, $tmp_pos);
         }
      }
      if (!isset($noparte) || $noparte == "")
      {
          $noparte = "";
      }
      if (isset($noparte) && !empty($noparte))
      {
         $tmp_pos = strpos($noparte, "##@@");
         if ($tmp_pos === false)
         { }
         else
         {
         $noparte = substr($noparte, 0, $tmp_pos);
         }
      }
      if (!isset($status) || $status == "")
      {
          $status = "";
      }
      if (isset($status) && !empty($status))
      {
         $tmp_pos = strpos($status, "##@@");
         if ($tmp_pos === false)
         { }
         else
         {
         $status = substr($status, 0, $tmp_pos);
         }
      }
      if (!isset($nombrecliente) || $nombrecliente == "")
      {
          $nombrecliente = "";
      }
      if (isset($nombrecliente) && !empty($nombrecliente))
      {
         $tmp_pos = strpos($nombrecliente, "##@@");
         if ($tmp_pos === false)
         { }
         else
         {
         $nombrecliente = substr($nombrecliente, 0, $tmp_pos);
         }
      }
      if (!isset($almacenasociado) || $almacenasociado == "")
      {
          $almacenasociado = "";
      }
      if (isset($almacenasociado) && !empty($almacenasociado))
      {
         $tmp_pos = strpos($almacenasociado, "##@@");
         if ($tmp_pos === false)
         { }
         else
         {
         $almacenasociado = substr($almacenasociado, 0, $tmp_pos);
         }
      }
?>
 <TR align="center">
  <TD class="scFilterTableTd">
   <table width="100%" class="scFilterToolbar"><tr>
    <td class="scFilterToolbarPadding" align="left" width="33%" nowrap>
    </td>
    <td class="scFilterToolbarPadding" align="center" width="33%" nowrap>
    </td>
    <td class="scFilterToolbarPadding" align="right" width="33%" nowrap>
<?php
   if (is_file("grid_numSeries_help.txt"))
   {
      $Arq_WebHelp = file("grid_numSeries_help.txt"); 
      if (isset($Arq_WebHelp[0]) && !empty($Arq_WebHelp[0]))
      {
          $Arq_WebHelp[0] = str_replace("\r\n" , "", trim($Arq_WebHelp[0]));
          $Tmp = explode(";", $Arq_WebHelp[0]); 
          foreach ($Tmp as $Cada_help)
          {
              $Tmp1 = explode(":", $Cada_help); 
              if (!empty($Tmp1[0]) && isset($Tmp1[1]) && !empty($Tmp1[1]) && $Tmp1[0] == "fil" && is_file($this->Ini->root . $this->Ini->path_help . $Tmp1[1]))
              {
?>
          <?php echo nmButtonOutput($this->arr_buttons, "bhelp", "nm_open_popup('" . $this->Ini->path_help . $Tmp1[1] . "')", "nm_open_popup('" . $this->Ini->path_help . $Tmp1[1] . "')", "sc_b_help_top", "", "", "", "absmiddle", "", "0px", $this->Ini->path_botoes, "", "", "", "", "", "only_text", "text_right", "", "");
?>
<?php
              }
          }
      }
   }
?>
    </td>
   </tr></table>
<?php
   if ($this->nmgp_botoes['save'] == "on")
   {
?>
    </TD></TR><TR><TD>
    <DIV id="Salvar_filters_top" style="display:none">
     <TABLE align="center" class="scFilterTable">
      <TR>
       <TD class="scFilterBlock">
        <table style="border-width: 0px; border-collapse: collapse" width="100%">
         <tr>
          <td style="padding: 0px" valign="top" class="scFilterBlockFont"><?php echo $this->Ini->Nm_lang['lang_othr_srch_head'] ?></td>
          <td style="padding: 0px" align="right" valign="top">
           <?php echo nmButtonOutput($this->arr_buttons, "bcancelar", "document.getElementById('Salvar_filters_top').style.display = 'none'", "document.getElementById('Salvar_filters_top').style.display = 'none'", "Cancel_frm_top", "", "", "", "absmiddle", "", "0px", $this->Ini->path_botoes, "", "", "", "", "", "only_text", "text_right", "", "");
?>
          </td>
         </tr>
        </table>
       </TD>
      </TR>
      <TR>
       <TD class="scFilterFieldOdd">
        <table style="border-width: 0px; border-collapse: collapse" width="100%">
         <tr>
          <td style="padding: 0px" valign="top">
           <input class="scFilterObjectOdd" type="text" name="nmgp_save_name_top" value="">
          </td>
          <td style="padding: 0px" align="right" valign="top">
           <?php echo nmButtonOutput($this->arr_buttons, "bsalvar", "nm_save_form('top')", "nm_save_form('top')", "Save_frm_top", "", "", "", "absmiddle", "", "0px", $this->Ini->path_botoes, "", "", "", "", "", "only_text", "text_right", "", "");
?>
          </td>
         </tr>
        </table>
       </TD>
      </TR>
      <TR>
       <TD class="scFilterFieldEven">
       <DIV id="Apaga_filters_top" style="display:''">
        <table style="border-width: 0px; border-collapse: collapse" width="100%">
         <tr>
          <td style="padding: 0px" valign="top">
          <div id="idAjaxSelect_NM_filters_del_top">
           <SELECT class="scFilterObjectOdd" id="sel_filters_del_top" name="NM_filters_del_top" size="1">
            <option value=""></option>
<?php
          $Nome_filter = "";
          foreach ($this->NM_fil_ant as $Cada_filter => $Tipo_filter)
          {
              $Select = "";
              if ($Cada_filter == $this->NM_curr_fil)
              {
                  $Select = "selected";
              }
              if (NM_is_utf8($Cada_filter) && $_SESSION['scriptcase']['charset'] != "UTF-8")
              {
                  $Cada_filter    = mb_convert_encoding($Cada_filter, $_SESSION['scriptcase']['charset'], "UTF-8");
                  $Tipo_filter[0] = mb_convert_encoding($Tipo_filter[0], $_SESSION['scriptcase']['charset'], "UTF-8");
              }
              elseif (!NM_is_utf8($Cada_filter) && $_SESSION['scriptcase']['charset'] == "UTF-8")
              {
                  $Cada_filter    = mb_convert_encoding($Cada_filter, "UTF-8");
                  $Tipo_filter[0] = mb_convert_encoding($Tipo_filter[0], "UTF-8");
              }
              if ($Tipo_filter[1] != $Nome_filter)
              {
                  $Nome_filter = $Tipo_filter[1];
                  echo "            <option value=\"\">" . NM_encode_input($Nome_filter) . "</option>\r\n";
              }
?>
            <option value="<?php echo NM_encode_input($Tipo_filter[0]) . "\" " . $Select . ">.." . $Cada_filter ?></option>
<?php
          }
?>
           </SELECT>
          </div>
          </td>
          <td style="padding: 0px" align="right" valign="top">
           <?php echo nmButtonOutput($this->arr_buttons, "bexcluir", "nm_submit_filter_del('top')", "nm_submit_filter_del('top')", "Exc_filtro_top", "", "", "", "absmiddle", "", "0px", $this->Ini->path_botoes, "", "", "", "", "", "only_text", "text_right", "", "");
?>
          </td>
         </tr>
        </table>
       </DIV>
       </TD>
      </TR>
     </TABLE>
    </DIV> 
<?php
   }
?>
  </TD>
 </TR>
 <TR align="center">
  <TD class="scFilterTableTd">
   <TABLE style="padding: 0px; spacing: 0px; border-width: 0px;" width="100%" height="100%">
   <TR valign="top" >
  <TD width="100%" height="">
   <TABLE class="scFilterTable" id="hidden_bloco_0" valign="top" width="100%" style="height: 100%;">
   <tr>





      <TD class="scFilterLabelOdd"><?php echo (isset($this->New_label['id'])) ? $this->New_label['id'] : "Id"; ?></TD>
     <TD class="scFilterFieldOdd"> 
      <SELECT class="scFilterObjectOdd" name="id_cond">
       <OPTION value="eq" <?php if ("eq" == $id_cond) { echo "selected"; } ?>><?php echo $this->Ini->Nm_lang['lang_srch_exac'] ?></OPTION>
       <OPTION value="ii" <?php if ("ii" == $id_cond) { echo "selected"; } ?>><?php echo $this->Ini->Nm_lang['lang_srch_stts_with'] ?></OPTION>
       <OPTION value="qp" <?php if ("qp" == $id_cond) { echo "selected"; } ?>><?php echo $this->Ini->Nm_lang['lang_srch_like'] ?></OPTION>
       <OPTION value="df" <?php if ("df" == $id_cond) { echo "selected"; } ?>><?php echo $this->Ini->Nm_lang['lang_srch_dife'] ?></OPTION>
      </SELECT>
       </TD>
     <TD  class="scFilterFieldOdd">
      <TABLE  border="0" cellpadding="0" cellspacing="0">
       <TR valign="top">
        <TD class="scFilterFieldFontOdd">
           <?php
 $SC_Label = (isset($this->New_label['id'])) ? $this->New_label['id'] : "Id";
 $nmgp_tab_label .= "id?#?" . $SC_Label . "?@?";
 $date_sep_bw = "";
?>
<INPUT  type="text" id="SC_id" name="id" value="<?php echo NM_encode_input($id) ?>" size=11 alt="{datatype: 'integer', maxLength: 11, thousandsSep: '<?php echo $_SESSION['scriptcase']['reg_conf']['grup_num'] ?>', allowNegative: false, onlyNegative: false, enterTab: false}" class="sc-js-input scFilterObjectOdd">

        </TD>
       </TR>
      </TABLE>
     </TD>

   </tr><tr>





      <TD class="scFilterLabelEven"><?php echo (isset($this->New_label['serie'])) ? $this->New_label['serie'] : "Serie"; ?></TD>
     <TD class="scFilterFieldEven"> 
      <SELECT class="scFilterObjectEven" name="serie_cond">
       <OPTION value="eq" <?php if ("eq" == $serie_cond) { echo "selected"; } ?>><?php echo $this->Ini->Nm_lang['lang_srch_exac'] ?></OPTION>
       <OPTION value="ii" <?php if ("ii" == $serie_cond) { echo "selected"; } ?>><?php echo $this->Ini->Nm_lang['lang_srch_stts_with'] ?></OPTION>
       <OPTION value="qp" <?php if ("qp" == $serie_cond) { echo "selected"; } ?>><?php echo $this->Ini->Nm_lang['lang_srch_like'] ?></OPTION>
       <OPTION value="df" <?php if ("df" == $serie_cond) { echo "selected"; } ?>><?php echo $this->Ini->Nm_lang['lang_srch_dife'] ?></OPTION>
      </SELECT>
       </TD>
     <TD  class="scFilterFieldEven">
      <TABLE  border="0" cellpadding="0" cellspacing="0">
       <TR valign="top">
        <TD class="scFilterFieldFontEven">
           <?php
 $SC_Label = (isset($this->New_label['serie'])) ? $this->New_label['serie'] : "Serie";
 $nmgp_tab_label .= "serie?#?" . $SC_Label . "?@?";
 $date_sep_bw = "";
?>
<INPUT  type="text" id="SC_serie" name="serie" value="<?php echo NM_encode_input($serie) ?>" size=50 alt="{datatype: 'text', maxLength: 50, allowedChars: '', lettersCase: '', autoTab: false, enterTab: false}" class="sc-js-input scFilterObjectEven">

        </TD>
       </TR>
      </TABLE>
     </TD>

   </tr><tr>





      <TD class="scFilterLabelOdd"><?php echo (isset($this->New_label['noparte'])) ? $this->New_label['noparte'] : "No Parte"; ?></TD>
     <TD class="scFilterFieldOdd"> 
      <SELECT class="scFilterObjectOdd" name="noparte_cond">
       <OPTION value="eq" <?php if ("eq" == $noparte_cond) { echo "selected"; } ?>><?php echo $this->Ini->Nm_lang['lang_srch_exac'] ?></OPTION>
       <OPTION value="ii" <?php if ("ii" == $noparte_cond) { echo "selected"; } ?>><?php echo $this->Ini->Nm_lang['lang_srch_stts_with'] ?></OPTION>
       <OPTION value="qp" <?php if ("qp" == $noparte_cond) { echo "selected"; } ?>><?php echo $this->Ini->Nm_lang['lang_srch_like'] ?></OPTION>
       <OPTION value="df" <?php if ("df" == $noparte_cond) { echo "selected"; } ?>><?php echo $this->Ini->Nm_lang['lang_srch_dife'] ?></OPTION>
      </SELECT>
       </TD>
     <TD  class="scFilterFieldOdd">
      <TABLE  border="0" cellpadding="0" cellspacing="0">
       <TR valign="top">
        <TD class="scFilterFieldFontOdd">
           <?php
 $SC_Label = (isset($this->New_label['noparte'])) ? $this->New_label['noparte'] : "No Parte";
 $nmgp_tab_label .= "noparte?#?" . $SC_Label . "?@?";
 $date_sep_bw = "";
?>
<INPUT  type="text" id="SC_noparte" name="noparte" value="<?php echo NM_encode_input($noparte) ?>" size=50 alt="{datatype: 'text', maxLength: 100, allowedChars: '', lettersCase: '', autoTab: false, enterTab: false}" class="sc-js-input scFilterObjectOdd">

        </TD>
       </TR>
      </TABLE>
     </TD>

   </tr><tr>





      <TD class="scFilterLabelEven"><?php echo (isset($this->New_label['status'])) ? $this->New_label['status'] : "Status"; ?></TD>
     <TD class="scFilterFieldEven"> 
      <SELECT class="scFilterObjectEven" name="status_cond">
       <OPTION value="eq" <?php if ("eq" == $status_cond) { echo "selected"; } ?>><?php echo $this->Ini->Nm_lang['lang_srch_exac'] ?></OPTION>
       <OPTION value="ii" <?php if ("ii" == $status_cond) { echo "selected"; } ?>><?php echo $this->Ini->Nm_lang['lang_srch_stts_with'] ?></OPTION>
       <OPTION value="qp" <?php if ("qp" == $status_cond) { echo "selected"; } ?>><?php echo $this->Ini->Nm_lang['lang_srch_like'] ?></OPTION>
       <OPTION value="df" <?php if ("df" == $status_cond) { echo "selected"; } ?>><?php echo $this->Ini->Nm_lang['lang_srch_dife'] ?></OPTION>
      </SELECT>
       </TD>
     <TD  class="scFilterFieldEven">
      <TABLE  border="0" cellpadding="0" cellspacing="0">
       <TR valign="top">
        <TD class="scFilterFieldFontEven">
           <?php
 $SC_Label = (isset($this->New_label['status'])) ? $this->New_label['status'] : "Status";
 $nmgp_tab_label .= "status?#?" . $SC_Label . "?@?";
 $date_sep_bw = "";
?>
<INPUT  type="text" id="SC_status" name="status" value="<?php echo NM_encode_input($status) ?>" size=15 alt="{datatype: 'text', maxLength: 15, allowedChars: '', lettersCase: '', autoTab: false, enterTab: false}" class="sc-js-input scFilterObjectEven">

        </TD>
       </TR>
      </TABLE>
     </TD>

   </tr><tr>





      <TD class="scFilterLabelOdd"><?php echo (isset($this->New_label['nombrecliente'])) ? $this->New_label['nombrecliente'] : "SR"; ?></TD>
     <TD class="scFilterFieldOdd"> 
      <SELECT class="scFilterObjectOdd" name="nombrecliente_cond">
       <OPTION value="eq" <?php if ("eq" == $nombrecliente_cond) { echo "selected"; } ?>><?php echo $this->Ini->Nm_lang['lang_srch_exac'] ?></OPTION>
       <OPTION value="ii" <?php if ("ii" == $nombrecliente_cond) { echo "selected"; } ?>><?php echo $this->Ini->Nm_lang['lang_srch_stts_with'] ?></OPTION>
       <OPTION value="qp" <?php if ("qp" == $nombrecliente_cond) { echo "selected"; } ?>><?php echo $this->Ini->Nm_lang['lang_srch_like'] ?></OPTION>
       <OPTION value="df" <?php if ("df" == $nombrecliente_cond) { echo "selected"; } ?>><?php echo $this->Ini->Nm_lang['lang_srch_dife'] ?></OPTION>
      </SELECT>
       </TD>
     <TD  class="scFilterFieldOdd">
      <TABLE  border="0" cellpadding="0" cellspacing="0">
       <TR valign="top">
        <TD class="scFilterFieldFontOdd">
           <?php
 $SC_Label = (isset($this->New_label['nombrecliente'])) ? $this->New_label['nombrecliente'] : "SR";
 $nmgp_tab_label .= "nombrecliente?#?" . $SC_Label . "?@?";
 $date_sep_bw = "";
?>
<INPUT  type="text" id="SC_nombrecliente" name="nombrecliente" value="<?php echo NM_encode_input($nombrecliente) ?>" size=50 alt="{datatype: 'text', maxLength: 100, allowedChars: '', lettersCase: '', autoTab: false, enterTab: false}" class="sc-js-input scFilterObjectOdd">

        </TD>
       </TR>
      </TABLE>
     </TD>

   </tr><tr>





      <TD class="scFilterLabelEven"><?php echo (isset($this->New_label['almacenasociado'])) ? $this->New_label['almacenasociado'] : "Almacen Asociado"; ?></TD>
     <TD class="scFilterFieldEven"> 
      <SELECT class="scFilterObjectEven" name="almacenasociado_cond">
       <OPTION value="eq" <?php if ("eq" == $almacenasociado_cond) { echo "selected"; } ?>><?php echo $this->Ini->Nm_lang['lang_srch_exac'] ?></OPTION>
       <OPTION value="ii" <?php if ("ii" == $almacenasociado_cond) { echo "selected"; } ?>><?php echo $this->Ini->Nm_lang['lang_srch_stts_with'] ?></OPTION>
       <OPTION value="qp" <?php if ("qp" == $almacenasociado_cond) { echo "selected"; } ?>><?php echo $this->Ini->Nm_lang['lang_srch_like'] ?></OPTION>
       <OPTION value="df" <?php if ("df" == $almacenasociado_cond) { echo "selected"; } ?>><?php echo $this->Ini->Nm_lang['lang_srch_dife'] ?></OPTION>
      </SELECT>
       </TD>
     <TD  class="scFilterFieldEven">
      <TABLE  border="0" cellpadding="0" cellspacing="0">
       <TR valign="top">
        <TD class="scFilterFieldFontEven">
           <?php
 $SC_Label = (isset($this->New_label['almacenasociado'])) ? $this->New_label['almacenasociado'] : "Almacen Asociado";
 $nmgp_tab_label .= "almacenasociado?#?" . $SC_Label . "?@?";
 $date_sep_bw = "";
?>
<INPUT  type="text" id="SC_almacenasociado" name="almacenasociado" value="<?php echo NM_encode_input($almacenasociado) ?>" size=50 alt="{datatype: 'text', maxLength: 200, allowedChars: '', lettersCase: '', autoTab: false, enterTab: false}" class="sc-js-input scFilterObjectEven">

        </TD>
       </TR>
      </TABLE>
     </TD>

   </tr>
   </TABLE>
  </TD>
 </TR>
 </TABLE>
 </TD>
 </TR>
 <TR align="center">
  <TD class="scFilterTableTd">
<INPUT type="hidden" name="NM_operador" value="and">   <INPUT type="hidden" name="nmgp_tab_label" value="<?php echo NM_encode_input($nmgp_tab_label); ?>"> 
   <INPUT type="hidden" name="bprocessa" value="pesq"> 
  </TD>
 </TR>
 <TR align="center">
  <TD class="scFilterTableTd">
   <table width="100%" class="scFilterToolbar"><tr>
    <td class="scFilterToolbarPadding" align="left" width="33%" nowrap>
    </td>
    <td class="scFilterToolbarPadding" align="center" width="33%" nowrap>
   <?php echo nmButtonOutput($this->arr_buttons, "bpesquisa", "document.F1.bprocessa.value='pesq'; nm_submit_form()", "document.F1.bprocessa.value='pesq'; nm_submit_form()", "sc_b_pesq_bot", "", "", "", "absmiddle", "", "0px", $this->Ini->path_botoes, "", "", "", "", "", "only_text", "text_right", "", "");
?>
<?php
   if ($this->nmgp_botoes['clear'] == "on")
   {
?>
          <?php echo nmButtonOutput($this->arr_buttons, "blimpar", "limpa_form()", "limpa_form()", "limpa_frm_bot", "", "", "", "absmiddle", "", "0px", $this->Ini->path_botoes, "", "", "", "", "", "only_text", "text_right", "", "");
?>
<?php
   }
?>
<?php
   if (!isset($this->nmgp_botoes['save']) || $this->nmgp_botoes['save'] == "on")
   {
       $this->NM_fil_ant = $this->gera_array_filtros();
?>
     <span id="idAjaxSelect_NM_filters_bot">
       <SELECT class="scFilterToolbar_obj" id="sel_recup_filters_bot" name="NM_filters_bot" onChange="nm_submit_filter(this, 'bot')" size="1">
           <option value=""></option>
<?php
          $Nome_filter = "";
          foreach ($this->NM_fil_ant as $Cada_filter => $Tipo_filter)
          {
              $Select = "";
              if ($Cada_filter == $this->NM_curr_fil)
              {
                  $Select = "selected";
              }
              if (NM_is_utf8($Cada_filter) && $_SESSION['scriptcase']['charset'] != "UTF-8")
              {
                  $Cada_filter    = mb_convert_encoding($Cada_filter, $_SESSION['scriptcase']['charset'], "UTF-8");
                  $Tipo_filter[0] = mb_convert_encoding($Tipo_filter[0], $_SESSION['scriptcase']['charset'], "UTF-8");
              }
              elseif (!NM_is_utf8($Cada_filter) && $_SESSION['scriptcase']['charset'] == "UTF-8")
              {
                  $Cada_filter    = mb_convert_encoding($Cada_filter, "UTF-8");
                  $Tipo_filter[0] = mb_convert_encoding($Tipo_filter[0], "UTF-8");
              }
              if ($Tipo_filter[1] != $Nome_filter)
              {
                  $Nome_filter = $Tipo_filter[1];
                  echo "           <option value=\"\">" . NM_encode_input($Nome_filter) . "</option>\r\n";
              }
?>
           <option value="<?php echo NM_encode_input($Tipo_filter[0]) . "\" " . $Select . ">.." . $Cada_filter ?></option>
<?php
          }
?>
       </SELECT>
     </span>
<?php
   }
?>
<?php
   if ($this->nmgp_botoes['save'] == "on")
   {
?>
          <?php echo nmButtonOutput($this->arr_buttons, "bedit_filter", "document.getElementById('Salvar_filters_bot').style.display = ''; document.F1.nmgp_save_name_bot.focus()", "document.getElementById('Salvar_filters_bot').style.display = ''; document.F1.nmgp_save_name_bot.focus()", "Ativa_save_bot", "", "", "", "absmiddle", "", "0px", $this->Ini->path_botoes, "", "", "", "", "", "only_text", "text_right", "", "");
?>
<?php
   }
?>
<?php
   if (is_file("grid_numSeries_help.txt"))
   {
      $Arq_WebHelp = file("grid_numSeries_help.txt"); 
      if (isset($Arq_WebHelp[0]) && !empty($Arq_WebHelp[0]))
      {
          $Arq_WebHelp[0] = str_replace("\r\n" , "", trim($Arq_WebHelp[0]));
          $Tmp = explode(";", $Arq_WebHelp[0]); 
          foreach ($Tmp as $Cada_help)
          {
              $Tmp1 = explode(":", $Cada_help); 
              if (!empty($Tmp1[0]) && isset($Tmp1[1]) && !empty($Tmp1[1]) && $Tmp1[0] == "fil" && is_file($this->Ini->root . $this->Ini->path_help . $Tmp1[1]))
              {
?>
          <?php echo nmButtonOutput($this->arr_buttons, "bhelp", "nm_open_popup('" . $this->Ini->path_help . $Tmp1[1] . "')", "nm_open_popup('" . $this->Ini->path_help . $Tmp1[1] . "')", "sc_b_help_bot", "", "", "", "absmiddle", "", "0px", $this->Ini->path_botoes, "", "", "", "", "", "only_text", "text_right", "", "");
?>
<?php
              }
          }
      }
   }
?>
<?php
   if (isset($_SESSION['scriptcase']['sc_apl_conf']['grid_numSeries']['start']) && $_SESSION['scriptcase']['sc_apl_conf']['grid_numSeries']['start'] == 'filter' && $nm_apl_dependente != 1)
   {
?>
       <?php echo nmButtonOutput($this->arr_buttons, "bsair", "document.form_cancel.submit()", "document.form_cancel.submit()", "sc_b_cancel_bot", "", "", "", "absmiddle", "", "0px", $this->Ini->path_botoes, "", "", "", "", "", "only_text", "text_right", "", "");
?>
<?php
   }
   else
   {
?>
       <?php echo nmButtonOutput($this->arr_buttons, "bvoltar", "document.form_cancel.submit()", "document.form_cancel.submit()", "sc_b_cancel_bot", "", "", "", "absmiddle", "", "0px", $this->Ini->path_botoes, "", "", "", "", "", "only_text", "text_right", "", "");
?>
<?php
   }
?>
    </td>
    <td class="scFilterToolbarPadding" align="right" width="33%" nowrap>
    </td>
   </tr></table>
<?php
   if ($this->nmgp_botoes['save'] == "on")
   {
?>
    </TD></TR><TR><TD>
    <DIV id="Salvar_filters_bot" style="display:none">
     <TABLE align="center" class="scFilterTable">
      <TR>
       <TD class="scFilterBlock">
        <table style="border-width: 0px; border-collapse: collapse" width="100%">
         <tr>
          <td style="padding: 0px" valign="top" class="scFilterBlockFont"><?php echo $this->Ini->Nm_lang['lang_othr_srch_head'] ?></td>
          <td style="padding: 0px" align="right" valign="top">
           <?php echo nmButtonOutput($this->arr_buttons, "bcancelar", "document.getElementById('Salvar_filters_bot').style.display = 'none'", "document.getElementById('Salvar_filters_bot').style.display = 'none'", "Cancel_frm_bot", "", "", "", "absmiddle", "", "0px", $this->Ini->path_botoes, "", "", "", "", "", "only_text", "text_right", "", "");
?>
          </td>
         </tr>
        </table>
       </TD>
      </TR>
      <TR>
       <TD class="scFilterFieldOdd">
        <table style="border-width: 0px; border-collapse: collapse" width="100%">
         <tr>
          <td style="padding: 0px" valign="top">
           <input class="scFilterObjectOdd" type="text" name="nmgp_save_name_bot" value="">
          </td>
          <td style="padding: 0px" align="right" valign="top">
           <?php echo nmButtonOutput($this->arr_buttons, "bsalvar", "nm_save_form('bot')", "nm_save_form('bot')", "Save_frm_bot", "", "", "", "absmiddle", "", "0px", $this->Ini->path_botoes, "", "", "", "", "", "only_text", "text_right", "", "");
?>
          </td>
         </tr>
        </table>
       </TD>
      </TR>
      <TR>
       <TD class="scFilterFieldEven">
       <DIV id="Apaga_filters_bot" style="display:''">
        <table style="border-width: 0px; border-collapse: collapse" width="100%">
         <tr>
          <td style="padding: 0px" valign="top">
          <div id="idAjaxSelect_NM_filters_del_bot">
           <SELECT class="scFilterObjectOdd" id="sel_filters_del_bot" name="NM_filters_del_bot" size="1">
            <option value=""></option>
<?php
          $Nome_filter = "";
          foreach ($this->NM_fil_ant as $Cada_filter => $Tipo_filter)
          {
              $Select = "";
              if ($Cada_filter == $this->NM_curr_fil)
              {
                  $Select = "selected";
              }
              if (NM_is_utf8($Cada_filter) && $_SESSION['scriptcase']['charset'] != "UTF-8")
              {
                  $Cada_filter    = mb_convert_encoding($Cada_filter, $_SESSION['scriptcase']['charset'], "UTF-8");
                  $Tipo_filter[0] = mb_convert_encoding($Tipo_filter[0], $_SESSION['scriptcase']['charset'], "UTF-8");
              }
              elseif (!NM_is_utf8($Cada_filter) && $_SESSION['scriptcase']['charset'] == "UTF-8")
              {
                  $Cada_filter    = mb_convert_encoding($Cada_filter, "UTF-8");
                  $Tipo_filter[0] = mb_convert_encoding($Tipo_filter[0], "UTF-8");
              }
              if ($Tipo_filter[1] != $Nome_filter)
              {
                  $Nome_filter = $Tipo_filter[1];
                  echo "            <option value=\"\">" . NM_encode_input($Nome_filter) . "</option>\r\n";
              }
?>
            <option value="<?php echo NM_encode_input($Tipo_filter[0]) . "\" " . $Select . ">.." . $Cada_filter ?></option>
<?php
          }
?>
           </SELECT>
          </div>
          </td>
          <td style="padding: 0px" align="right" valign="top">
           <?php echo nmButtonOutput($this->arr_buttons, "bexcluir", "nm_submit_filter_del('bot')", "nm_submit_filter_del('bot')", "Exc_filtro_bot", "", "", "", "absmiddle", "", "0px", $this->Ini->path_botoes, "", "", "", "", "", "only_text", "text_right", "", "");
?>
          </td>
         </tr>
        </table>
       </DIV>
       </TD>
      </TR>
     </TABLE>
    </DIV> 
<?php
   }
?>
  </TD>
 </TR>
<?php
   }

   function monta_html_fim()
   {
       global $bprocessa, $nm_url_saida, $Script_BI;
?>

</TABLE>
   <INPUT type="hidden" name="form_condicao" value="3">
</FORM> 
<?php
   if (isset($_SESSION['scriptcase']['sc_apl_conf']['grid_numSeries']['start']) && $_SESSION['scriptcase']['sc_apl_conf']['grid_numSeries']['start'] == 'filter')
   {
?>
   <FORM style="display:none;" name="form_cancel"  method="POST" action="<?php echo $nm_url_saida; ?>" target="_self"> 
<?php
   }
   else
   {
?>
   <FORM style="display:none;" name="form_cancel"  method="POST" action="./" target="_self"> 
<?php
   }
?>
   <INPUT type="hidden" name="script_case_init" value="<?php echo NM_encode_input($this->Ini->sc_page); ?>"> 
   <INPUT type="hidden" name="script_case_session" value="<?php echo NM_encode_input(session_id()); ?>"> 
<?php
   if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_numSeries']['orig_pesq'] == "grid")
   {
       $Ret_cancel_pesq = "volta_grid";
   }
   else
   {
       $Ret_cancel_pesq = "resumo";
   }
?>
   <INPUT type="hidden" name="nmgp_opcao" value="<?php echo $Ret_cancel_pesq; ?>"> 
   </FORM> 
<SCRIPT type="text/javascript">
<?php
   if (empty($this->NM_fil_ant))
   {
?>
      document.getElementById('Apaga_filters_bot').style.display = 'none';
      document.getElementById('sel_recup_filters_bot').style.display = 'none';
<?php
   }
?>
 function nm_submit_form()
 {
    document.F1.submit();
 }
 function limpa_form()
 {
   document.F1.reset();
   if (document.F1.NM_filters)
   {
       document.F1.NM_filters.selectedIndex = -1;
   }
   document.getElementById('Salvar_filters_bot').style.display = 'none';
   document.F1.id.value = "";
   document.F1.serie.value = "";
   document.F1.noparte.value = "";
   document.F1.status.value = "";
   document.F1.nombrecliente.value = "";
   document.F1.almacenasociado.value = "";
 }
function nm_tabula(obj, tam, cond)
{
   if (obj.value.length == tam)
   {
       for (i=0; i < document.F1.elements.length;i++)
       {
            if (document.F1.elements[i].name == obj.name)
            {
                i++;
                campo = document.F1.elements[i].name;
                campo2 = campo.lastIndexOf('_input_2');
                if (document.F1.elements[i].type == 'text' && (campo2 == -1 || cond == 'bw'))
                {
                    eval('document.F1.' + campo + '.focus()');
                }
                break;
            }
       }
   }
}
 function SC_carga_evt_jquery()
 {
 }
</SCRIPT>
</BODY>
</HTML>
<?php
   }

   function gera_array_filtros()
   {
       $this->NM_fil_ant = array();
       $NM_patch   = "Lexmark/grid_numSeries";
       if (is_dir($this->NM_path_filter . $NM_patch))
       {
           $NM_dir = @opendir($this->NM_path_filter . $NM_patch);
           while (FALSE !== ($NM_arq = @readdir($NM_dir)))
           {
             if (@is_file($this->NM_path_filter . $NM_patch . "/" . $NM_arq))
             {
                 $Sc_v6 = false;
                 $NMcmp_filter = file($this->NM_path_filter . $NM_patch . "/" . $NM_arq);
                 $NMcmp_filter = explode("@NMF@", $NMcmp_filter[0]);
                 if (substr($NMcmp_filter[0], 0, 6) == "SC_V6_")
                 {
                     $Name_filter = substr($NMcmp_filter[0], 6);
                     if (!empty($Name_filter))
                     {
                         $nmgp_save_name = str_replace('/', ' ', $Name_filter);
                         $nmgp_save_name = str_replace('\\', ' ', $nmgp_save_name);
                         $nmgp_save_name = str_replace('.', ' ', $nmgp_save_name);
                         $this->NM_fil_ant[$Name_filter][0] = $NM_patch . "/" . $nmgp_save_name;
                         $this->NM_fil_ant[$Name_filter][1] = "" . $this->Ini->Nm_lang['lang_srch_public'] . "";
                         $Sc_v6 = true;
                     }
                 }
                 if (!$Sc_v6)
                 {
                     $this->NM_fil_ant[$NM_arq][0] = $NM_patch . "/" . $NM_arq;
                     $this->NM_fil_ant[$NM_arq][1] = "" . $this->Ini->Nm_lang['lang_srch_public'] . "";
                 }
             }
           }
       }
       return $this->NM_fil_ant;
   }
   /**
    * @access  public
    * @param  string  $NM_operador  $this->Ini->Nm_lang['pesq_global_NM_operador']
    * @param  array  $nmgp_tab_label  
    */
   function inicializa_vars()
   {
      global $NM_operador, $nmgp_tab_label;

      $dir_raiz          = strrpos($_SERVER['PHP_SELF'],"/");  
      $dir_raiz          = substr($_SERVER['PHP_SELF'], 0, $dir_raiz + 1);  
      $this->nm_location = $this->Ini->sc_protocolo . $this->Ini->server . $dir_raiz;
      $this->Campos_Mens_erro = ""; 
      $this->nm_data = new nm_data("es");
      $_SESSION['sc_session'][$this->Ini->sc_page]['grid_numSeries']['cond_pesq'] = "";
      if (!empty($nmgp_tab_label))
      {
         $nm_tab_campos = explode("?@?", $nmgp_tab_label);
         $nmgp_tab_label = array();
         foreach ($nm_tab_campos as $cada_campo)
         {
             $parte_campo = explode("?#?", $cada_campo);
             $nmgp_tab_label[$parte_campo[0]] = $parte_campo[1];
         }
      }
      $this->comando        = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_numSeries']['where_orig'];
      $this->comando_sum    = "";
      $this->comando_filtro = "";
      $this->comando_ini    = "ini";
      $this->comando_fim    = "";
      $this->NM_operador    = (isset($NM_operador) && ("and" == strtolower($NM_operador) || "or" == strtolower($NM_operador))) ? $NM_operador : "and";
   }

   function salva_filtro()
   {
      global 
             $id_cond, $id,
             $serie_cond, $serie,
             $noparte_cond, $noparte,
             $status_cond, $status,
             $nombrecliente_cond, $nombrecliente,
             $almacenasociado_cond, $almacenasociado,
             $nmgp_save_name, $NM_operador, $nmgp_save_option, $script_case_init;
      if (!function_exists("nm_limpa_valor"))
      {
          include_once($_SESSION['sc_session'][$script_case_init]['grid_numSeries']['path_libs_php'] . "/nm_gp_limpa.php");
      }
      if (isset($nmgp_save_name) && !empty($nmgp_save_name))
      { 
          if ($id_cond != "in")
          {
              nm_limpa_numero($id, $_SESSION['scriptcase']['reg_conf']['grup_num']) ; 
          }
          else
          {
              $Nm_sc_valores = explode(",", $id);
              foreach ($Nm_sc_valores as $II => $Nm_sc_valor)
              {
                  $Nm_sc_valor = trim($Nm_sc_valor);
                  nm_limpa_numero($Nm_sc_valor, $_SESSION['scriptcase']['reg_conf']['grup_num']); 
                  $Nm_sc_valores[$II] = $Nm_sc_valor;
              }
              $id = implode(",", $Nm_sc_valores);
          }
          $NM_str_filter  = "SC_V6_" . $nmgp_save_name . "@NMF@";
          $nmgp_save_name = str_replace('/', ' ', $nmgp_save_name);
          $nmgp_save_name = str_replace('\\', ' ', $nmgp_save_name);
          $nmgp_save_name = str_replace('.', ' ', $nmgp_save_name);
          if (!NM_is_utf8($nmgp_save_name))
          {
              $nmgp_save_name = mb_convert_encoding($nmgp_save_name, "UTF-8");
          }
          $NM_temp  = (isset($id_cond)) ? $id_cond : ""; 
          $NM_str_filter .= "id_cond#NMF#" . $NM_temp . "@NMF@"; 
          $NM_temp  = (isset($id)) ? $id : ""; 
          $NM_str_filter .= "id#NMF#" . $NM_temp . "@NMF@"; 
          $NM_temp  = (isset($serie_cond)) ? $serie_cond : ""; 
          $NM_str_filter .= "serie_cond#NMF#" . $NM_temp . "@NMF@"; 
          $NM_temp  = (isset($serie)) ? $serie : ""; 
          $NM_str_filter .= "serie#NMF#" . $NM_temp . "@NMF@"; 
          $NM_temp  = (isset($noparte_cond)) ? $noparte_cond : ""; 
          $NM_str_filter .= "noparte_cond#NMF#" . $NM_temp . "@NMF@"; 
          $NM_temp  = (isset($noparte)) ? $noparte : ""; 
          $NM_str_filter .= "noparte#NMF#" . $NM_temp . "@NMF@"; 
          $NM_temp  = (isset($status_cond)) ? $status_cond : ""; 
          $NM_str_filter .= "status_cond#NMF#" . $NM_temp . "@NMF@"; 
          $NM_temp  = (isset($status)) ? $status : ""; 
          $NM_str_filter .= "status#NMF#" . $NM_temp . "@NMF@"; 
          $NM_temp  = (isset($nombrecliente_cond)) ? $nombrecliente_cond : ""; 
          $NM_str_filter .= "nombrecliente_cond#NMF#" . $NM_temp . "@NMF@"; 
          $NM_temp  = (isset($nombrecliente)) ? $nombrecliente : ""; 
          $NM_str_filter .= "nombrecliente#NMF#" . $NM_temp . "@NMF@"; 
          $NM_temp  = (isset($almacenasociado_cond)) ? $almacenasociado_cond : ""; 
          $NM_str_filter .= "almacenasociado_cond#NMF#" . $NM_temp . "@NMF@"; 
          $NM_temp  = (isset($almacenasociado)) ? $almacenasociado : ""; 
          $NM_str_filter .= "almacenasociado#NMF#" . $NM_temp . "@NMF@"; 
          $NM_str_filter .= "NM_operador#NMF#" . $NM_operador; 
          $NM_patch = $this->NM_path_filter;
          if (!is_dir($NM_patch))
          {
              $NMdir = mkdir($NM_patch, 0755);
          }
          $NM_patch .= "Lexmark/";
          if (!is_dir($NM_patch))
          {
              $NMdir = mkdir($NM_patch, 0755);
          }
          $NM_patch .= "grid_numSeries/";
          if (!is_dir($NM_patch))
          {
              $NMdir = mkdir($NM_patch, 0755);
          }
          $Parms_usr  = "";
          $NM_filter = fopen ($NM_patch . $nmgp_save_name, 'w');
          if (!NM_is_utf8($NM_str_filter))
          {
              $NM_str_filter = mb_convert_encoding($NM_str_filter, "UTF-8");
          }
          fwrite($NM_filter, $NM_str_filter);
          fclose($NM_filter);
      } 
   }
   function recupera_filtro()
   {
      global 
      $id_cond, $id,
             $serie_cond, $serie,
             $noparte_cond, $noparte,
             $status_cond, $status,
             $nombrecliente_cond, $nombrecliente,
             $almacenasociado_cond, $almacenasociado,
      $NM_filters, $NM_operador, $script_case_init;
      if (!function_exists("nmgp_Form_Num_Val"))
      {
          include_once($_SESSION['sc_session'][$script_case_init]['grid_numSeries']['path_libs_php'] . "/nm_edit.php");
      }
      $Look_man = array();
      $tp_html['id_cond'] = 'select';
      $tp_html['serie_cond'] = 'select';
      $tp_html['noparte_cond'] = 'select';
      $tp_html['status_cond'] = 'select';
      $tp_html['nombrecliente_cond'] = 'select';
      $tp_html['almacenasociado_cond'] = 'select';
      $tp_html['id'] = 'text';
      $tp_html['serie'] = 'text';
      $tp_html['noparte'] = 'text';
      $tp_html['status'] = 'text';
      $tp_html['nombrecliente'] = 'text';
      $tp_html['almacenasociado'] = 'text';
      $tp_html['NM_operador'] = 'text';
      $NM_patch = $this->NM_path_filter . "/" . $NM_filters;
      if (!is_file($NM_patch))
      {
          $NM_filters = mb_convert_encoding($NM_filters, "UTF-8");
          $NM_patch = $this->NM_path_filter . "/" . $NM_filters;
      }
      if (is_file($NM_patch))
      {
          $this->ajax_return_fields = array();
          $SC_V6    = false;
          $NMfilter = file($NM_patch);
          $NMcmp_filter = explode("@NMF@", $NMfilter[0]);
          if (substr($NMcmp_filter[0], 0, 5) == "SC_V6")
          {
              $SC_V6 = true;
              unset($NMcmp_filter[0]);
          }
          foreach ($NMcmp_filter as $Cada_cmp)
          {
              $Cada_cmp = explode("#NMF#", $Cada_cmp);
              if (isset($tp_html[$Cada_cmp[0]]))
              {
                  if ($SC_V6 && ($Cada_cmp[0] == "id_cond"))
                  {
                      $$Cada_cmp[0] = trim($Cada_cmp[1]);
                  }
                  if ($SC_V6 && $Cada_cmp[0] == "id")
                  {
                      if (strtoupper($id_cond) != "II" && strtoupper($id_cond) != "QP" && strtoupper($id_cond) != "IN") 
                      { 
                          nmgp_Form_Num_Val($Cada_cmp[1], $_SESSION['scriptcase']['reg_conf']['grup_num'], $_SESSION['scriptcase']['reg_conf']['dec_num'], "0", "S", "1", "", "N:" . $_SESSION['scriptcase']['reg_conf']['neg_num'] , $_SESSION['scriptcase']['reg_conf']['simb_neg'], $_SESSION['scriptcase']['reg_conf']['num_group_digit']) ; 
                      } 
                  }
                  $this->ajax_return_fields[$Cada_cmp[0]]['obj'] = $tp_html[$Cada_cmp[0]];
                  if (substr($Cada_cmp[1], 0, 17) == "_NM_array_#NMARR#")
                  {
                      $Cada_val_sv  = array();
                      $Cada_val_sv1 = array();
                      $Sc_temp = explode("#NMARR#", substr($Cada_cmp[1], 17));
                      foreach ($Sc_temp as $Cada_val)
                      {
                         $v_fim = explode("##@@", $Cada_val);
                         $Cada_val_sv[] = trim($v_fim[0]);
                         if (isset($Look_man[$Cada_cmp[0]][$v_fim[0]]))
                         {
                             $v_fim[0] = $v_fim[0] . "##@@" . $Look_man[$Cada_cmp[0]][$v_fim[0]];
                         }
                         $Cada_val_sv1[] = grid_numSeries_pack_protect_string(trim($v_fim[0]));
                      }
                      if ($_SESSION['scriptcase']['charset'] != "UTF-8")
                      {
                          $Cada_val_sv = NM_conv_charset($Cada_val_sv, $_SESSION['scriptcase']['charset'], "UTF-8");
                      }
                      $$Cada_cmp[0] = $Cada_val_sv;
                      $this->ajax_return_fields[$Cada_cmp[0]]['vallist'] = $Cada_val_sv1;
                  }
                  else
                  {
                      $Cada_val_sv = trim($Cada_cmp[1]);
                      if ($_SESSION['scriptcase']['charset'] != "UTF-8")
                      {
                          $Cada_val_sv = NM_conv_charset($Cada_val_sv, $_SESSION['scriptcase']['charset'], "UTF-8");
                      }
                      $$Cada_cmp[0] = $Cada_val_sv;
                      $this->ajax_return_fields[$Cada_cmp[0]]['vallist'] = array(grid_numSeries_pack_protect_string(trim($Cada_cmp[1])));
                  }
              }
          }
          $this->NM_curr_fil = $NM_filters;
          $this->NM_operador = $NM_operador;
          unset($this->ajax_return_fields['NM_operador']);
      }
   }
   function apaga_filtro()
   {
      global $NM_filters_del;
      if (isset($NM_filters_del) && !empty($NM_filters_del))
      { 
          $NM_patch = $this->NM_path_filter . "/" . $NM_filters_del;
          if (!is_file($NM_patch))
          {
              $NM_filters_del = mb_convert_encoding($NM_filters_del, "UTF-8");
              $NM_patch = $this->NM_path_filter . "/" . $NM_filters_del;
          }
          if (is_file($NM_patch))
          {
              @unlink($NM_patch);
          }
          if ($NM_filters_del == $this->NM_curr_fil)
          {
              $this->NM_curr_fil = "";
          }
      }
   }
   /**
    * @access  public
    */
   function trata_campos()
   {
      global $id_cond, $id,
             $serie_cond, $serie,
             $noparte_cond, $noparte,
             $status_cond, $status,
             $nombrecliente_cond, $nombrecliente,
             $almacenasociado_cond, $almacenasociado, $nmgp_tab_label;

      $this->Ini->sc_Include($this->Ini->path_lib_php . "/nm_gp_limpa.php", "F", "nm_limpa_valor") ; 
      $this->Ini->sc_Include($this->Ini->path_lib_php . "/nm_conv_dados.php", "F", "nm_conv_limpa_dado") ; 
      $this->Ini->sc_Include($this->Ini->path_lib_php . "/nm_edit.php", "F", "nmgp_Form_Num_Val") ; 
      $id_cond_salva = $id_cond; 
      if (!isset($id_input_2) || $id_input_2 == "")
      {
          $id_input_2 = $id;
      }
      $serie_cond_salva = $serie_cond; 
      if (!isset($serie_input_2) || $serie_input_2 == "")
      {
          $serie_input_2 = $serie;
      }
      $noparte_cond_salva = $noparte_cond; 
      if (!isset($noparte_input_2) || $noparte_input_2 == "")
      {
          $noparte_input_2 = $noparte;
      }
      $status_cond_salva = $status_cond; 
      if (!isset($status_input_2) || $status_input_2 == "")
      {
          $status_input_2 = $status;
      }
      $nombrecliente_cond_salva = $nombrecliente_cond; 
      if (!isset($nombrecliente_input_2) || $nombrecliente_input_2 == "")
      {
          $nombrecliente_input_2 = $nombrecliente;
      }
      $almacenasociado_cond_salva = $almacenasociado_cond; 
      if (!isset($almacenasociado_input_2) || $almacenasociado_input_2 == "")
      {
          $almacenasociado_input_2 = $almacenasociado;
      }
      if ($id_cond != "in")
      {
          nm_limpa_numero($id, $_SESSION['scriptcase']['reg_conf']['grup_num']) ; 
      }
      else
      {
          $Nm_sc_valores = explode(",", $id);
          foreach ($Nm_sc_valores as $II => $Nm_sc_valor)
          {
              $Nm_sc_valor = trim($Nm_sc_valor);
              nm_limpa_numero($Nm_sc_valor, $_SESSION['scriptcase']['reg_conf']['grup_num']); 
              $Nm_sc_valores[$II] = $Nm_sc_valor;
          }
          $id = implode(",", $Nm_sc_valores);
      }
      $_SESSION['sc_session'][$this->Ini->sc_page]['grid_numSeries']['campos_busca']  = array(); 
      $_SESSION['sc_session'][$this->Ini->sc_page]['grid_numSeries']['campos_busca']['id'] = $id; 
      $_SESSION['sc_session'][$this->Ini->sc_page]['grid_numSeries']['campos_busca']['id_cond'] = $id_cond_salva; 
      $_SESSION['sc_session'][$this->Ini->sc_page]['grid_numSeries']['campos_busca']['serie'] = $serie; 
      $_SESSION['sc_session'][$this->Ini->sc_page]['grid_numSeries']['campos_busca']['serie_cond'] = $serie_cond_salva; 
      $_SESSION['sc_session'][$this->Ini->sc_page]['grid_numSeries']['campos_busca']['noparte'] = $noparte; 
      $_SESSION['sc_session'][$this->Ini->sc_page]['grid_numSeries']['campos_busca']['noparte_cond'] = $noparte_cond_salva; 
      $_SESSION['sc_session'][$this->Ini->sc_page]['grid_numSeries']['campos_busca']['status'] = $status; 
      $_SESSION['sc_session'][$this->Ini->sc_page]['grid_numSeries']['campos_busca']['status_cond'] = $status_cond_salva; 
      $_SESSION['sc_session'][$this->Ini->sc_page]['grid_numSeries']['campos_busca']['nombrecliente'] = $nombrecliente; 
      $_SESSION['sc_session'][$this->Ini->sc_page]['grid_numSeries']['campos_busca']['nombrecliente_cond'] = $nombrecliente_cond_salva; 
      $_SESSION['sc_session'][$this->Ini->sc_page]['grid_numSeries']['campos_busca']['almacenasociado'] = $almacenasociado; 
      $_SESSION['sc_session'][$this->Ini->sc_page]['grid_numSeries']['campos_busca']['almacenasociado_cond'] = $almacenasociado_cond_salva; 
      $_SESSION['sc_session'][$this->Ini->sc_page]['grid_numSeries']['campos_busca']['NM_operador'] = $this->NM_operador; 
      $Conteudo = $id;
      if (strtoupper($id_cond) != "II" && strtoupper($id_cond) != "QP" && strtoupper($id_cond) != "IN") 
      { 
          nmgp_Form_Num_Val($Conteudo, $_SESSION['scriptcase']['reg_conf']['grup_num'], $_SESSION['scriptcase']['reg_conf']['dec_num'], "0", "S", "1", "", "N:" . $_SESSION['scriptcase']['reg_conf']['neg_num'] , $_SESSION['scriptcase']['reg_conf']['simb_neg'], $_SESSION['scriptcase']['reg_conf']['num_group_digit']) ; 
      } 
      $this->cmp_formatado['id'] = $Conteudo;
      $Conteudo = $serie;
      $this->cmp_formatado['serie'] = $Conteudo;
      $Conteudo = $noparte;
      $this->cmp_formatado['noparte'] = $Conteudo;
      $Conteudo = $status;
      $this->cmp_formatado['status'] = $Conteudo;
      $Conteudo = $nombrecliente;
      $this->cmp_formatado['nombrecliente'] = $Conteudo;
      $Conteudo = $almacenasociado;
      $this->cmp_formatado['almacenasociado'] = $Conteudo;

      //----- $id
      if (isset($id) || $id_cond == "nu" || $id_cond == "nn")
      {
         $this->monta_condicao("id", $id_cond, $id, "", "id");
      }

      //----- $serie
      if (isset($serie) || $serie_cond == "nu" || $serie_cond == "nn")
      {
         $this->monta_condicao("serie", $serie_cond, $serie, "", "serie");
      }

      //----- $noparte
      if (isset($noparte) || $noparte_cond == "nu" || $noparte_cond == "nn")
      {
         $this->monta_condicao("noParte", $noparte_cond, $noparte, "", "noparte");
      }

      //----- $status
      if (isset($status) || $status_cond == "nu" || $status_cond == "nn")
      {
         $this->monta_condicao("status", $status_cond, $status, "", "status");
      }

      //----- $nombrecliente
      if (isset($nombrecliente) || $nombrecliente_cond == "nu" || $nombrecliente_cond == "nn")
      {
         $this->monta_condicao("nombreCliente", $nombrecliente_cond, $nombrecliente, "", "nombrecliente");
      }

      //----- $almacenasociado
      if (isset($almacenasociado) || $almacenasociado_cond == "nu" || $almacenasociado_cond == "nn")
      {
         $this->monta_condicao("almacenAsociado", $almacenasociado_cond, $almacenasociado, "", "almacenasociado");
      }
   }

   /**
    * @access  public
    */
   function finaliza_resultado()
   {
      if (isset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_numSeries']['campos_busca']) && $_SESSION['scriptcase']['charset'] != "UTF-8")
      {
          $_SESSION['sc_session'][$this->Ini->sc_page]['grid_numSeries']['campos_busca'] = NM_conv_charset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_numSeries']['campos_busca'], "UTF-8", $_SESSION['scriptcase']['charset']);
      }

      $_SESSION['sc_session'][$this->Ini->sc_page]['grid_numSeries']['where_pesq_lookup']  = $this->comando_sum . $this->comando_fim;
      $_SESSION['sc_session'][$this->Ini->sc_page]['grid_numSeries']['where_pesq']         = $this->comando . $this->comando_fim;
      $_SESSION['sc_session'][$this->Ini->sc_page]['grid_numSeries']['opcao']              = "pesq";
      if ("" == $this->comando_filtro)
      {
         $_SESSION['sc_session'][$this->Ini->sc_page]['grid_numSeries']['where_pesq_filtro'] = "";
      }
      else
      {
         $_SESSION['sc_session'][$this->Ini->sc_page]['grid_numSeries']['where_pesq_filtro'] = " (" . $this->comando_filtro . ")";
      }
      if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_numSeries']['where_pesq'] != $_SESSION['sc_session'][$this->Ini->sc_page]['grid_numSeries']['where_pesq_ant'])
      {
         $_SESSION['sc_session'][$this->Ini->sc_page]['grid_numSeries']['cond_pesq'] .= $this->NM_operador;
         $_SESSION['sc_session'][$this->Ini->sc_page]['grid_numSeries']['contr_array_resumo'] = "NAO";
         $_SESSION['sc_session'][$this->Ini->sc_page]['grid_numSeries']['contr_total_geral']  = "NAO";
         unset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_numSeries']['tot_geral']);
      }
      $_SESSION['sc_session'][$this->Ini->sc_page]['grid_numSeries']['where_pesq_ant'] = $this->comando . $this->comando_fim;
      unset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_numSeries']['fast_search']);

      $this->retorna_pesq();
   }
   function nm_gera_mask(&$nm_campo, $nm_mask)
   { 
      $trab_campo = $nm_campo;
      $trab_mask  = $nm_mask;
      $tam_campo  = strlen($nm_campo);
      $trab_saida = "";
      $mask_num = false;
      for ($x=0; $x < strlen($trab_mask); $x++)
      {
          if (substr($trab_mask, $x, 1) == "#")
          {
              $mask_num = true;
              break;
          }
      }
      if ($mask_num )
      {
          $ver_duas = explode(";", $trab_mask);
          if (isset($ver_duas[1]) && !empty($ver_duas[1]))
          {
              $cont1 = count(explode("#", $ver_duas[0])) - 1;
              $cont2 = count(explode("#", $ver_duas[1])) - 1;
              if ($cont2 >= $tam_campo)
              {
                  $trab_mask = $ver_duas[1];
              }
              else
              {
                  $trab_mask = $ver_duas[0];
              }
          }
          $tam_mask = strlen($trab_mask);
          $xdados = 0;
          for ($x=0; $x < $tam_mask; $x++)
          {
              if (substr($trab_mask, $x, 1) == "#" && $xdados < $tam_campo)
              {
                  $trab_saida .= substr($trab_campo, $xdados, 1);
                  $xdados++;
              }
              elseif ($xdados < $tam_campo)
              {
                  $trab_saida .= substr($trab_mask, $x, 1);
              }
          }
          if ($xdados < $tam_campo)
          {
              $trab_saida .= substr($trab_campo, $xdados);
          }
          $nm_campo = $trab_saida;
          return;
      }
      for ($ix = strlen($trab_mask); $ix > 0; $ix--)
      {
           $char_mask = substr($trab_mask, $ix - 1, 1);
           if ($char_mask != "x" && $char_mask != "z")
           {
               $trab_saida = $char_mask . $trab_saida;
           }
           else
           {
               if ($tam_campo != 0)
               {
                   $trab_saida = substr($trab_campo, $tam_campo - 1, 1) . $trab_saida;
                   $tam_campo--;
               }
               else
               {
                   $trab_saida = "0" . $trab_saida;
               }
           }
      }
      if ($tam_campo != 0)
      {
          $trab_saida = substr($trab_campo, 0, $tam_campo) . $trab_saida;
          $trab_mask  = str_repeat("z", $tam_campo) . $trab_mask;
      }
   
      $iz = 0; 
      for ($ix = 0; $ix < strlen($trab_mask); $ix++)
      {
           $char_mask = substr($trab_mask, $ix, 1);
           if ($char_mask != "x" && $char_mask != "z")
           {
               if ($char_mask == "." || $char_mask == ",")
               {
                   $trab_saida = substr($trab_saida, 0, $iz) . substr($trab_saida, $iz + 1);
               }
               else
               {
                   $iz++;
               }
           }
           elseif ($char_mask == "x" || substr($trab_saida, $iz, 1) != "0")
           {
               $ix = strlen($trab_mask) + 1;
           }
           else
           {
               $trab_saida = substr($trab_saida, 0, $iz) . substr($trab_saida, $iz + 1);
           }
      }
      $nm_campo = $trab_saida;
   } 
   function nm_conv_data_db($dt_in, $form_in, $form_out)
   {
       $dt_out = $dt_in;
       if (strtoupper($form_in) == "DB_FORMAT")
       {
           if ($dt_out == "null" || $dt_out == "")
           {
               $dt_out = "";
               return $dt_out;
           }
           $form_in = "AAAA-MM-DD";
       }
       if (strtoupper($form_out) == "DB_FORMAT")
       {
           if (empty($dt_out))
           {
               $dt_out = "null";
               return $dt_out;
           }
           $form_out = "AAAA-MM-DD";
       }
       nm_conv_form_data($dt_out, $form_in, $form_out);
       return $dt_out;
   }
}

?>
