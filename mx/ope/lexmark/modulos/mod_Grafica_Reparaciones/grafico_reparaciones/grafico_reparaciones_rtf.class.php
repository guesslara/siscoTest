<?php

class grafico_reparaciones_rtf
{
   var $Db;
   var $Erro;
   var $Ini;
   var $Lookup;
   var $nm_data;
   var $texto_tag;
   var $arquivo;
   var $tit_doc;
   var $sc_proc_grid; 
   var $NM_cmp_hidden = array();

   //---- 
   function grafico_reparaciones_rtf()
   {
      $this->nm_data   = new nm_data("es");
      $this->texto_tag = "";
   }

   //---- 
   function monta_rtf()
   {
      $this->inicializa_vars();
      $this->gera_texto_tag();
      $this->grava_arquivo_rtf();
      $this->monta_html();
   }

   //----- 
   function inicializa_vars()
   {
      global $nm_lang;
      $dir_raiz          = strrpos($_SERVER['PHP_SELF'],"/") ;  
      $dir_raiz          = substr($_SERVER['PHP_SELF'], 0, $dir_raiz + 1) ;  
      $this->nm_location = $this->Ini->sc_protocolo . $this->Ini->server . $dir_raiz; 
      $this->arquivo    = "sc_rtf";
      $this->arquivo   .= "_" . date("YmdHis") . "_" . rand(0, 1000);
      $this->arquivo   .= "_grafico_reparaciones";
      $this->arquivo   .= ".rtf";
      $this->tit_doc    = "grafico_reparaciones.rtf";
   }

   //----- 
   function gera_texto_tag()
   {
     global $nm_lang;
      global
             $nm_nada, $nm_lang;

      $_SESSION['scriptcase']['sc_sql_ult_conexao'] = ''; 
      $this->sc_proc_grid = false; 
      $nm_raiz_img  = ""; 
      if (isset($_SESSION['scriptcase']['sc_apl_conf']['grafico_reparaciones']['field_display']) && !empty($_SESSION['scriptcase']['sc_apl_conf']['grafico_reparaciones']['field_display']))
      {
          foreach ($_SESSION['scriptcase']['sc_apl_conf']['grafico_reparaciones']['field_display'] as $NM_cada_field => $NM_cada_opc)
          {
              $this->NM_cmp_hidden[$NM_cada_field] = $NM_cada_opc;
          }
      }
      if (isset($_SESSION['sc_session'][$this->Ini->sc_page]['grafico_reparaciones']['usr_cmp_sel']) && !empty($_SESSION['sc_session'][$this->Ini->sc_page]['grafico_reparaciones']['usr_cmp_sel']))
      {
          foreach ($_SESSION['sc_session'][$this->Ini->sc_page]['grafico_reparaciones']['usr_cmp_sel'] as $NM_cada_field => $NM_cada_opc)
          {
              $this->NM_cmp_hidden[$NM_cada_field] = $NM_cada_opc;
          }
      }
      if (isset($_SESSION['sc_session'][$this->Ini->sc_page]['grafico_reparaciones']['php_cmp_sel']) && !empty($_SESSION['sc_session'][$this->Ini->sc_page]['grafico_reparaciones']['php_cmp_sel']))
      {
          foreach ($_SESSION['sc_session'][$this->Ini->sc_page]['grafico_reparaciones']['php_cmp_sel'] as $NM_cada_field => $NM_cada_opc)
          {
              $this->NM_cmp_hidden[$NM_cada_field] = $NM_cada_opc;
          }
      }
      if (isset($_SESSION['sc_session'][$this->Ini->sc_page]['grafico_reparaciones']['campos_busca']) && !empty($_SESSION['sc_session'][$this->Ini->sc_page]['grafico_reparaciones']['campos_busca']))
      { 
      } 
      $this->nm_field_dinamico = array();
      $this->nm_order_dinamico = array();
      $this->sc_where_orig   = $_SESSION['sc_session'][$this->Ini->sc_page]['grafico_reparaciones']['where_orig'];
      $this->sc_where_atual  = $_SESSION['sc_session'][$this->Ini->sc_page]['grafico_reparaciones']['where_pesq'];
      $this->sc_where_filtro = $_SESSION['sc_session'][$this->Ini->sc_page]['grafico_reparaciones']['where_pesq_filtro'];
      if (isset($_SESSION['sc_session'][$this->Ini->sc_page]['grafico_reparaciones']['rtf_name']))
      {
          $this->arquivo = $_SESSION['sc_session'][$this->Ini->sc_page]['grafico_reparaciones']['rtf_name'];
          $this->tit_doc = $_SESSION['sc_session'][$this->Ini->sc_page]['grafico_reparaciones']['rtf_name'];
          unset($_SESSION['sc_session'][$this->Ini->sc_page]['grafico_reparaciones']['rtf_name']);
      }
      if (in_array(strtolower($this->Ini->nm_tpbanco), $this->Ini->nm_bases_sybase))
      { 
          $nmgp_select = "SELECT ot.id as ot_id, ot.ot as ot_ot, ot.idp as ot_idp, ot.nserie as ot_nserie, ot.u_recibe as ot_u_recibe, str_replace (convert(char(10),ot.f_recibo,102), '.', '-') + ' ' + convert(char(8),ot.f_recibo,20) as ot_f_recibo, str_replace (convert(char(10),ot.fecha_fin,102), '.', '-') + ' ' + convert(char(8),ot.fecha_fin,20) as ot_fecha_fin, str_replace (convert(char(10),ot.fecha_fin_rep,102), '.', '-') + ' ' + convert(char(8),ot.fecha_fin_rep,20) as ot_fecha_fin_rep, ot.num_no_ok as ot_num_no_ok, ot.status_proceso as ot_status_proceso, ot.status_cliente as ot_status_cliente, str_replace (convert(char(10),ot.shipdate,102), '.', '-') + ' ' + convert(char(8),ot.shipdate,20) as ot_shipdate, tipoalmacen.almacen as tipoalmacen_almacen, usuarios.dp_nombre as usuarios_dp_nombre, usuarios.dp_apaterno as usuarios_dp_apaterno, cat_reparaciones.descripcion as cat_reparaciones_descripcion, str_replace (convert(char(10),reg_rep_efectuadas.fecha,102), '.', '-') + ' ' + convert(char(8),reg_rep_efectuadas.fecha,20) as reg_rep_efectuadas_fecha from " . $this->Ini->nm_tabela; 
      } 
      elseif (in_array(strtolower($this->Ini->nm_tpbanco), $this->Ini->nm_bases_mysql))
      { 
          $nmgp_select = "SELECT ot.id as ot_id, ot.ot as ot_ot, ot.idp as ot_idp, ot.nserie as ot_nserie, ot.u_recibe as ot_u_recibe, ot.f_recibo as ot_f_recibo, ot.fecha_fin as ot_fecha_fin, ot.fecha_fin_rep as ot_fecha_fin_rep, ot.num_no_ok as ot_num_no_ok, ot.status_proceso as ot_status_proceso, ot.status_cliente as ot_status_cliente, ot.shipdate as ot_shipdate, tipoalmacen.almacen as tipoalmacen_almacen, usuarios.dp_nombre as usuarios_dp_nombre, usuarios.dp_apaterno as usuarios_dp_apaterno, cat_reparaciones.descripcion as cat_reparaciones_descripcion, reg_rep_efectuadas.fecha as reg_rep_efectuadas_fecha from " . $this->Ini->nm_tabela; 
      } 
      elseif (in_array(strtolower($this->Ini->nm_tpbanco), $this->Ini->nm_bases_mssql))
      { 
       $nmgp_select = "SELECT ot.id as ot_id, ot.ot as ot_ot, ot.idp as ot_idp, ot.nserie as ot_nserie, ot.u_recibe as ot_u_recibe, convert(char(23),ot.f_recibo,121) as ot_f_recibo, convert(char(23),ot.fecha_fin,121) as ot_fecha_fin, convert(char(23),ot.fecha_fin_rep,121) as ot_fecha_fin_rep, ot.num_no_ok as ot_num_no_ok, ot.status_proceso as ot_status_proceso, ot.status_cliente as ot_status_cliente, convert(char(23),ot.shipdate,121) as ot_shipdate, tipoalmacen.almacen as tipoalmacen_almacen, usuarios.dp_nombre as usuarios_dp_nombre, usuarios.dp_apaterno as usuarios_dp_apaterno, cat_reparaciones.descripcion as cat_reparaciones_descripcion, convert(char(23),reg_rep_efectuadas.fecha,121) as reg_rep_efectuadas_fecha from " . $this->Ini->nm_tabela; 
      } 
      elseif (in_array(strtolower($this->Ini->nm_tpbanco), $this->Ini->nm_bases_oracle))
      { 
          $nmgp_select = "SELECT ot.id as ot_id, ot.ot as ot_ot, ot.idp as ot_idp, ot.nserie as ot_nserie, ot.u_recibe as ot_u_recibe, ot.f_recibo as ot_f_recibo, ot.fecha_fin as ot_fecha_fin, ot.fecha_fin_rep as ot_fecha_fin_rep, ot.num_no_ok as ot_num_no_ok, ot.status_proceso as ot_status_proceso, ot.status_cliente as ot_status_cliente, ot.shipdate as ot_shipdate, tipoalmacen.almacen as tipoalmacen_almacen, usuarios.dp_nombre as usuarios_dp_nombre, usuarios.dp_apaterno as usuarios_dp_apaterno, cat_reparaciones.descripcion as cat_reparaciones_descripcion, reg_rep_efectuadas.fecha as reg_rep_efectuadas_fecha from " . $this->Ini->nm_tabela; 
      } 
      elseif (in_array(strtolower($this->Ini->nm_tpbanco), $this->Ini->nm_bases_informix))
      { 
          $nmgp_select = "SELECT ot.id as ot_id, ot.ot as ot_ot, ot.idp as ot_idp, ot.nserie as ot_nserie, ot.u_recibe as ot_u_recibe, EXTEND(ot.f_recibo, YEAR TO DAY) as ot_f_recibo, EXTEND(ot.fecha_fin, YEAR TO FRACTION) as ot_fecha_fin, EXTEND(ot.fecha_fin_rep, YEAR TO DAY) as ot_fecha_fin_rep, ot.num_no_ok as ot_num_no_ok, ot.status_proceso as ot_status_proceso, ot.status_cliente as ot_status_cliente, EXTEND(ot.shipdate, YEAR TO DAY) as ot_shipdate, tipoalmacen.almacen as tipoalmacen_almacen, usuarios.dp_nombre as usuarios_dp_nombre, usuarios.dp_apaterno as usuarios_dp_apaterno, cat_reparaciones.descripcion as cat_reparaciones_descripcion, EXTEND(reg_rep_efectuadas.fecha, YEAR TO DAY) as reg_rep_efectuadas_fecha from " . $this->Ini->nm_tabela; 
      } 
      else 
      { 
          $nmgp_select = "SELECT ot.id as ot_id, ot.ot as ot_ot, ot.idp as ot_idp, ot.nserie as ot_nserie, ot.u_recibe as ot_u_recibe, ot.f_recibo as ot_f_recibo, ot.fecha_fin as ot_fecha_fin, ot.fecha_fin_rep as ot_fecha_fin_rep, ot.num_no_ok as ot_num_no_ok, ot.status_proceso as ot_status_proceso, ot.status_cliente as ot_status_cliente, ot.shipdate as ot_shipdate, tipoalmacen.almacen as tipoalmacen_almacen, usuarios.dp_nombre as usuarios_dp_nombre, usuarios.dp_apaterno as usuarios_dp_apaterno, cat_reparaciones.descripcion as cat_reparaciones_descripcion, reg_rep_efectuadas.fecha as reg_rep_efectuadas_fecha from " . $this->Ini->nm_tabela; 
      } 
      $nmgp_select .= " " . $_SESSION['sc_session'][$this->Ini->sc_page]['grafico_reparaciones']['where_pesq'];
      if (isset($_SESSION['sc_session'][$this->Ini->sc_page]['grafico_reparaciones']['where_resumo']) && !empty($_SESSION['sc_session'][$this->Ini->sc_page]['grafico_reparaciones']['where_resumo'])) 
      { 
          if (empty($_SESSION['sc_session'][$this->Ini->sc_page]['grafico_reparaciones']['where_pesq'])) 
          { 
              $nmgp_select .= " where " . $_SESSION['sc_session'][$this->Ini->sc_page]['grafico_reparaciones']['where_resumo']; 
          } 
          else
          { 
              $nmgp_select .= " and (" . $_SESSION['sc_session'][$this->Ini->sc_page]['grafico_reparaciones']['where_resumo'] . ")"; 
          } 
      } 
      $nmgp_order_by = $_SESSION['sc_session'][$this->Ini->sc_page]['grafico_reparaciones']['order_grid'];
      $nmgp_select .= $nmgp_order_by; 
      $_SESSION['scriptcase']['sc_sql_ult_comando'] = $nmgp_select;
      $rs = $this->Db->Execute($nmgp_select);
      if ($rs === false && !$rs->EOF && $GLOBALS["NM_ERRO_IBASE"] != 1)
      {
         $this->Erro->mensagem(__FILE__, __LINE__, "banco", $this->Ini->Nm_lang['lang_errm_dber'], $this->Db->ErrorMsg());
         exit;
      }

      $this->texto_tag .= "<table>\r\n";
      $this->texto_tag .= "<tr>\r\n";
      foreach ($_SESSION['sc_session'][$this->Ini->sc_page]['grafico_reparaciones']['field_order'] as $Cada_col)
      { 
          $SC_Label = (isset($this->New_label['ot_id'])) ? $this->New_label['ot_id'] : "Id"; 
          if ($Cada_col == "ot_id" && (!isset($this->NM_cmp_hidden[$Cada_col]) || $this->NM_cmp_hidden[$Cada_col] != "off"))
          {
             if (!NM_is_utf8($SC_Label))
              {
                  $SC_Label = mb_convert_encoding($SC_Label, "UTF-8", $_SESSION['scriptcase']['charset']);
              }
              $SC_Label = str_replace('<', '&lt;', $SC_Label);
              $SC_Label = str_replace('>', '&gt;', $SC_Label);
              $this->texto_tag .= "<td>" . $SC_Label . "</td>\r\n";
          }
          $SC_Label = (isset($this->New_label['ot_ot'])) ? $this->New_label['ot_ot'] : "Ot"; 
          if ($Cada_col == "ot_ot" && (!isset($this->NM_cmp_hidden[$Cada_col]) || $this->NM_cmp_hidden[$Cada_col] != "off"))
          {
             if (!NM_is_utf8($SC_Label))
              {
                  $SC_Label = mb_convert_encoding($SC_Label, "UTF-8", $_SESSION['scriptcase']['charset']);
              }
              $SC_Label = str_replace('<', '&lt;', $SC_Label);
              $SC_Label = str_replace('>', '&gt;', $SC_Label);
              $this->texto_tag .= "<td>" . $SC_Label . "</td>\r\n";
          }
          $SC_Label = (isset($this->New_label['ot_idp'])) ? $this->New_label['ot_idp'] : "Id de Producto"; 
          if ($Cada_col == "ot_idp" && (!isset($this->NM_cmp_hidden[$Cada_col]) || $this->NM_cmp_hidden[$Cada_col] != "off"))
          {
             if (!NM_is_utf8($SC_Label))
              {
                  $SC_Label = mb_convert_encoding($SC_Label, "UTF-8", $_SESSION['scriptcase']['charset']);
              }
              $SC_Label = str_replace('<', '&lt;', $SC_Label);
              $SC_Label = str_replace('>', '&gt;', $SC_Label);
              $this->texto_tag .= "<td>" . $SC_Label . "</td>\r\n";
          }
          $SC_Label = (isset($this->New_label['ot_nserie'])) ? $this->New_label['ot_nserie'] : "No.Serie"; 
          if ($Cada_col == "ot_nserie" && (!isset($this->NM_cmp_hidden[$Cada_col]) || $this->NM_cmp_hidden[$Cada_col] != "off"))
          {
             if (!NM_is_utf8($SC_Label))
              {
                  $SC_Label = mb_convert_encoding($SC_Label, "UTF-8", $_SESSION['scriptcase']['charset']);
              }
              $SC_Label = str_replace('<', '&lt;', $SC_Label);
              $SC_Label = str_replace('>', '&gt;', $SC_Label);
              $this->texto_tag .= "<td>" . $SC_Label . "</td>\r\n";
          }
          $SC_Label = (isset($this->New_label['ot_u_recibe'])) ? $this->New_label['ot_u_recibe'] : "Recibe"; 
          if ($Cada_col == "ot_u_recibe" && (!isset($this->NM_cmp_hidden[$Cada_col]) || $this->NM_cmp_hidden[$Cada_col] != "off"))
          {
             if (!NM_is_utf8($SC_Label))
              {
                  $SC_Label = mb_convert_encoding($SC_Label, "UTF-8", $_SESSION['scriptcase']['charset']);
              }
              $SC_Label = str_replace('<', '&lt;', $SC_Label);
              $SC_Label = str_replace('>', '&gt;', $SC_Label);
              $this->texto_tag .= "<td>" . $SC_Label . "</td>\r\n";
          }
          $SC_Label = (isset($this->New_label['ot_f_recibo'])) ? $this->New_label['ot_f_recibo'] : " Fecha de Recibo"; 
          if ($Cada_col == "ot_f_recibo" && (!isset($this->NM_cmp_hidden[$Cada_col]) || $this->NM_cmp_hidden[$Cada_col] != "off"))
          {
             if (!NM_is_utf8($SC_Label))
              {
                  $SC_Label = mb_convert_encoding($SC_Label, "UTF-8", $_SESSION['scriptcase']['charset']);
              }
              $SC_Label = str_replace('<', '&lt;', $SC_Label);
              $SC_Label = str_replace('>', '&gt;', $SC_Label);
              $this->texto_tag .= "<td>" . $SC_Label . "</td>\r\n";
          }
          $SC_Label = (isset($this->New_label['ot_fecha_fin'])) ? $this->New_label['ot_fecha_fin'] : "Fecha Fin"; 
          if ($Cada_col == "ot_fecha_fin" && (!isset($this->NM_cmp_hidden[$Cada_col]) || $this->NM_cmp_hidden[$Cada_col] != "off"))
          {
             if (!NM_is_utf8($SC_Label))
              {
                  $SC_Label = mb_convert_encoding($SC_Label, "UTF-8", $_SESSION['scriptcase']['charset']);
              }
              $SC_Label = str_replace('<', '&lt;', $SC_Label);
              $SC_Label = str_replace('>', '&gt;', $SC_Label);
              $this->texto_tag .= "<td>" . $SC_Label . "</td>\r\n";
          }
          $SC_Label = (isset($this->New_label['ot_fecha_fin_rep'])) ? $this->New_label['ot_fecha_fin_rep'] : "Fecha Final Reparación"; 
          if ($Cada_col == "ot_fecha_fin_rep" && (!isset($this->NM_cmp_hidden[$Cada_col]) || $this->NM_cmp_hidden[$Cada_col] != "off"))
          {
             if (!NM_is_utf8($SC_Label))
              {
                  $SC_Label = mb_convert_encoding($SC_Label, "UTF-8", $_SESSION['scriptcase']['charset']);
              }
              $SC_Label = str_replace('<', '&lt;', $SC_Label);
              $SC_Label = str_replace('>', '&gt;', $SC_Label);
              $this->texto_tag .= "<td>" . $SC_Label . "</td>\r\n";
          }
          $SC_Label = (isset($this->New_label['ot_num_no_ok'])) ? $this->New_label['ot_num_no_ok'] : "Num No Ok"; 
          if ($Cada_col == "ot_num_no_ok" && (!isset($this->NM_cmp_hidden[$Cada_col]) || $this->NM_cmp_hidden[$Cada_col] != "off"))
          {
             if (!NM_is_utf8($SC_Label))
              {
                  $SC_Label = mb_convert_encoding($SC_Label, "UTF-8", $_SESSION['scriptcase']['charset']);
              }
              $SC_Label = str_replace('<', '&lt;', $SC_Label);
              $SC_Label = str_replace('>', '&gt;', $SC_Label);
              $this->texto_tag .= "<td>" . $SC_Label . "</td>\r\n";
          }
          $SC_Label = (isset($this->New_label['ot_status_proceso'])) ? $this->New_label['ot_status_proceso'] : "Status Proceso"; 
          if ($Cada_col == "ot_status_proceso" && (!isset($this->NM_cmp_hidden[$Cada_col]) || $this->NM_cmp_hidden[$Cada_col] != "off"))
          {
             if (!NM_is_utf8($SC_Label))
              {
                  $SC_Label = mb_convert_encoding($SC_Label, "UTF-8", $_SESSION['scriptcase']['charset']);
              }
              $SC_Label = str_replace('<', '&lt;', $SC_Label);
              $SC_Label = str_replace('>', '&gt;', $SC_Label);
              $this->texto_tag .= "<td>" . $SC_Label . "</td>\r\n";
          }
          $SC_Label = (isset($this->New_label['ot_status_cliente'])) ? $this->New_label['ot_status_cliente'] : "Status Cliente"; 
          if ($Cada_col == "ot_status_cliente" && (!isset($this->NM_cmp_hidden[$Cada_col]) || $this->NM_cmp_hidden[$Cada_col] != "off"))
          {
             if (!NM_is_utf8($SC_Label))
              {
                  $SC_Label = mb_convert_encoding($SC_Label, "UTF-8", $_SESSION['scriptcase']['charset']);
              }
              $SC_Label = str_replace('<', '&lt;', $SC_Label);
              $SC_Label = str_replace('>', '&gt;', $SC_Label);
              $this->texto_tag .= "<td>" . $SC_Label . "</td>\r\n";
          }
          $SC_Label = (isset($this->New_label['ot_shipdate'])) ? $this->New_label['ot_shipdate'] : "Shipdate"; 
          if ($Cada_col == "ot_shipdate" && (!isset($this->NM_cmp_hidden[$Cada_col]) || $this->NM_cmp_hidden[$Cada_col] != "off"))
          {
             if (!NM_is_utf8($SC_Label))
              {
                  $SC_Label = mb_convert_encoding($SC_Label, "UTF-8", $_SESSION['scriptcase']['charset']);
              }
              $SC_Label = str_replace('<', '&lt;', $SC_Label);
              $SC_Label = str_replace('>', '&gt;', $SC_Label);
              $this->texto_tag .= "<td>" . $SC_Label . "</td>\r\n";
          }
          $SC_Label = (isset($this->New_label['tipoalmacen_almacen'])) ? $this->New_label['tipoalmacen_almacen'] : "Almacen"; 
          if ($Cada_col == "tipoalmacen_almacen" && (!isset($this->NM_cmp_hidden[$Cada_col]) || $this->NM_cmp_hidden[$Cada_col] != "off"))
          {
             if (!NM_is_utf8($SC_Label))
              {
                  $SC_Label = mb_convert_encoding($SC_Label, "UTF-8", $_SESSION['scriptcase']['charset']);
              }
              $SC_Label = str_replace('<', '&lt;', $SC_Label);
              $SC_Label = str_replace('>', '&gt;', $SC_Label);
              $this->texto_tag .= "<td>" . $SC_Label . "</td>\r\n";
          }
          $SC_Label = (isset($this->New_label['usuarios_dp_nombre'])) ? $this->New_label['usuarios_dp_nombre'] : "Nombre"; 
          if ($Cada_col == "usuarios_dp_nombre" && (!isset($this->NM_cmp_hidden[$Cada_col]) || $this->NM_cmp_hidden[$Cada_col] != "off"))
          {
             if (!NM_is_utf8($SC_Label))
              {
                  $SC_Label = mb_convert_encoding($SC_Label, "UTF-8", $_SESSION['scriptcase']['charset']);
              }
              $SC_Label = str_replace('<', '&lt;', $SC_Label);
              $SC_Label = str_replace('>', '&gt;', $SC_Label);
              $this->texto_tag .= "<td>" . $SC_Label . "</td>\r\n";
          }
          $SC_Label = (isset($this->New_label['usuarios_dp_apaterno'])) ? $this->New_label['usuarios_dp_apaterno'] : "Técnico"; 
          if ($Cada_col == "usuarios_dp_apaterno" && (!isset($this->NM_cmp_hidden[$Cada_col]) || $this->NM_cmp_hidden[$Cada_col] != "off"))
          {
             if (!NM_is_utf8($SC_Label))
              {
                  $SC_Label = mb_convert_encoding($SC_Label, "UTF-8", $_SESSION['scriptcase']['charset']);
              }
              $SC_Label = str_replace('<', '&lt;', $SC_Label);
              $SC_Label = str_replace('>', '&gt;', $SC_Label);
              $this->texto_tag .= "<td>" . $SC_Label . "</td>\r\n";
          }
          $SC_Label = (isset($this->New_label['cat_reparaciones_descripcion'])) ? $this->New_label['cat_reparaciones_descripcion'] : "Tipo de reparación"; 
          if ($Cada_col == "cat_reparaciones_descripcion" && (!isset($this->NM_cmp_hidden[$Cada_col]) || $this->NM_cmp_hidden[$Cada_col] != "off"))
          {
             if (!NM_is_utf8($SC_Label))
              {
                  $SC_Label = mb_convert_encoding($SC_Label, "UTF-8", $_SESSION['scriptcase']['charset']);
              }
              $SC_Label = str_replace('<', '&lt;', $SC_Label);
              $SC_Label = str_replace('>', '&gt;', $SC_Label);
              $this->texto_tag .= "<td>" . $SC_Label . "</td>\r\n";
          }
          $SC_Label = (isset($this->New_label['reg_rep_efectuadas_fecha'])) ? $this->New_label['reg_rep_efectuadas_fecha'] : "Fecha"; 
          if ($Cada_col == "reg_rep_efectuadas_fecha" && (!isset($this->NM_cmp_hidden[$Cada_col]) || $this->NM_cmp_hidden[$Cada_col] != "off"))
          {
             if (!NM_is_utf8($SC_Label))
              {
                  $SC_Label = mb_convert_encoding($SC_Label, "UTF-8", $_SESSION['scriptcase']['charset']);
              }
              $SC_Label = str_replace('<', '&lt;', $SC_Label);
              $SC_Label = str_replace('>', '&gt;', $SC_Label);
              $this->texto_tag .= "<td>" . $SC_Label . "</td>\r\n";
          }
      } 
      $this->texto_tag .= "</tr>\r\n";
      while (!$rs->EOF)
      {
         $this->texto_tag .= "<tr>\r\n";
         $this->ot_id = $rs->fields[0] ;  
         $this->ot_id = (string)$this->ot_id;
         $this->ot_ot = $rs->fields[1] ;  
         $this->ot_idp = $rs->fields[2] ;  
         $this->ot_idp = (string)$this->ot_idp;
         $this->ot_nserie = $rs->fields[3] ;  
         $this->ot_u_recibe = $rs->fields[4] ;  
         $this->ot_u_recibe = (string)$this->ot_u_recibe;
         $this->ot_f_recibo = $rs->fields[5] ;  
         $this->ot_fecha_fin = $rs->fields[6] ;  
         $this->ot_fecha_fin_rep = $rs->fields[7] ;  
         $this->ot_num_no_ok = $rs->fields[8] ;  
         $this->ot_num_no_ok = (string)$this->ot_num_no_ok;
         $this->ot_status_proceso = $rs->fields[9] ;  
         $this->ot_status_cliente = $rs->fields[10] ;  
         $this->ot_shipdate = $rs->fields[11] ;  
         $this->tipoalmacen_almacen = $rs->fields[12] ;  
         $this->usuarios_dp_nombre = $rs->fields[13] ;  
         $this->usuarios_dp_apaterno = $rs->fields[14] ;  
         $this->cat_reparaciones_descripcion = $rs->fields[15] ;  
         $this->reg_rep_efectuadas_fecha = $rs->fields[16] ;  
         $this->sc_proc_grid = true; 
         foreach ($_SESSION['sc_session'][$this->Ini->sc_page]['grafico_reparaciones']['field_order'] as $Cada_col)
         { 
            if (!isset($this->NM_cmp_hidden[$Cada_col]) || $this->NM_cmp_hidden[$Cada_col] != "off")
            { 
                $NM_func_exp = "NM_export_" . $Cada_col;
                $this->$NM_func_exp();
            } 
         } 
         $this->texto_tag .= "</tr>\r\n";
         $rs->MoveNext();
      }
      $this->texto_tag .= "</table>\r\n";

      $rs->Close();
   }
   //----- ot_id
   function NM_export_ot_id()
   {
         if (!NM_is_utf8($this->ot_id))
         {
             $this->ot_id = mb_convert_encoding($this->ot_id, "UTF-8", $_SESSION['scriptcase']['charset']);
         }
          $this->ot_id = str_replace('<', '&lt;', $this->ot_id);
          $this->ot_id = str_replace('>', '&gt;', $this->ot_id);
         $this->texto_tag .= "<td>" . $this->ot_id . "</td>\r\n";
   }
   //----- ot_ot
   function NM_export_ot_ot()
   {
         if (!NM_is_utf8($this->ot_ot))
         {
             $this->ot_ot = mb_convert_encoding($this->ot_ot, "UTF-8", $_SESSION['scriptcase']['charset']);
         }
          $this->ot_ot = str_replace('<', '&lt;', $this->ot_ot);
          $this->ot_ot = str_replace('>', '&gt;', $this->ot_ot);
         $this->texto_tag .= "<td>" . $this->ot_ot . "</td>\r\n";
   }
   //----- ot_idp
   function NM_export_ot_idp()
   {
         if (!NM_is_utf8($this->ot_idp))
         {
             $this->ot_idp = mb_convert_encoding($this->ot_idp, "UTF-8", $_SESSION['scriptcase']['charset']);
         }
          $this->ot_idp = str_replace('<', '&lt;', $this->ot_idp);
          $this->ot_idp = str_replace('>', '&gt;', $this->ot_idp);
         $this->texto_tag .= "<td>" . $this->ot_idp . "</td>\r\n";
   }
   //----- ot_nserie
   function NM_export_ot_nserie()
   {
         if (!NM_is_utf8($this->ot_nserie))
         {
             $this->ot_nserie = mb_convert_encoding($this->ot_nserie, "UTF-8", $_SESSION['scriptcase']['charset']);
         }
          $this->ot_nserie = str_replace('<', '&lt;', $this->ot_nserie);
          $this->ot_nserie = str_replace('>', '&gt;', $this->ot_nserie);
         $this->texto_tag .= "<td>" . $this->ot_nserie . "</td>\r\n";
   }
   //----- ot_u_recibe
   function NM_export_ot_u_recibe()
   {
         if (!NM_is_utf8($this->ot_u_recibe))
         {
             $this->ot_u_recibe = mb_convert_encoding($this->ot_u_recibe, "UTF-8", $_SESSION['scriptcase']['charset']);
         }
          $this->ot_u_recibe = str_replace('<', '&lt;', $this->ot_u_recibe);
          $this->ot_u_recibe = str_replace('>', '&gt;', $this->ot_u_recibe);
         $this->texto_tag .= "<td>" . $this->ot_u_recibe . "</td>\r\n";
   }
   //----- ot_f_recibo
   function NM_export_ot_f_recibo()
   {
         if (!NM_is_utf8($this->ot_f_recibo))
         {
             $this->ot_f_recibo = mb_convert_encoding($this->ot_f_recibo, "UTF-8", $_SESSION['scriptcase']['charset']);
         }
          $this->ot_f_recibo = str_replace('<', '&lt;', $this->ot_f_recibo);
          $this->ot_f_recibo = str_replace('>', '&gt;', $this->ot_f_recibo);
         $this->texto_tag .= "<td>" . $this->ot_f_recibo . "</td>\r\n";
   }
   //----- ot_fecha_fin
   function NM_export_ot_fecha_fin()
   {
         if (!NM_is_utf8($this->ot_fecha_fin))
         {
             $this->ot_fecha_fin = mb_convert_encoding($this->ot_fecha_fin, "UTF-8", $_SESSION['scriptcase']['charset']);
         }
          $this->ot_fecha_fin = str_replace('<', '&lt;', $this->ot_fecha_fin);
          $this->ot_fecha_fin = str_replace('>', '&gt;', $this->ot_fecha_fin);
         $this->texto_tag .= "<td>" . $this->ot_fecha_fin . "</td>\r\n";
   }
   //----- ot_fecha_fin_rep
   function NM_export_ot_fecha_fin_rep()
   {
         if (!NM_is_utf8($this->ot_fecha_fin_rep))
         {
             $this->ot_fecha_fin_rep = mb_convert_encoding($this->ot_fecha_fin_rep, "UTF-8", $_SESSION['scriptcase']['charset']);
         }
          $this->ot_fecha_fin_rep = str_replace('<', '&lt;', $this->ot_fecha_fin_rep);
          $this->ot_fecha_fin_rep = str_replace('>', '&gt;', $this->ot_fecha_fin_rep);
         $this->texto_tag .= "<td>" . $this->ot_fecha_fin_rep . "</td>\r\n";
   }
   //----- ot_num_no_ok
   function NM_export_ot_num_no_ok()
   {
         if (!NM_is_utf8($this->ot_num_no_ok))
         {
             $this->ot_num_no_ok = mb_convert_encoding($this->ot_num_no_ok, "UTF-8", $_SESSION['scriptcase']['charset']);
         }
          $this->ot_num_no_ok = str_replace('<', '&lt;', $this->ot_num_no_ok);
          $this->ot_num_no_ok = str_replace('>', '&gt;', $this->ot_num_no_ok);
         $this->texto_tag .= "<td>" . $this->ot_num_no_ok . "</td>\r\n";
   }
   //----- ot_status_proceso
   function NM_export_ot_status_proceso()
   {
         if (!NM_is_utf8($this->ot_status_proceso))
         {
             $this->ot_status_proceso = mb_convert_encoding($this->ot_status_proceso, "UTF-8", $_SESSION['scriptcase']['charset']);
         }
          $this->ot_status_proceso = str_replace('<', '&lt;', $this->ot_status_proceso);
          $this->ot_status_proceso = str_replace('>', '&gt;', $this->ot_status_proceso);
         $this->texto_tag .= "<td>" . $this->ot_status_proceso . "</td>\r\n";
   }
   //----- ot_status_cliente
   function NM_export_ot_status_cliente()
   {
         if (!NM_is_utf8($this->ot_status_cliente))
         {
             $this->ot_status_cliente = mb_convert_encoding($this->ot_status_cliente, "UTF-8", $_SESSION['scriptcase']['charset']);
         }
          $this->ot_status_cliente = str_replace('<', '&lt;', $this->ot_status_cliente);
          $this->ot_status_cliente = str_replace('>', '&gt;', $this->ot_status_cliente);
         $this->texto_tag .= "<td>" . $this->ot_status_cliente . "</td>\r\n";
   }
   //----- ot_shipdate
   function NM_export_ot_shipdate()
   {
         if (!NM_is_utf8($this->ot_shipdate))
         {
             $this->ot_shipdate = mb_convert_encoding($this->ot_shipdate, "UTF-8", $_SESSION['scriptcase']['charset']);
         }
          $this->ot_shipdate = str_replace('<', '&lt;', $this->ot_shipdate);
          $this->ot_shipdate = str_replace('>', '&gt;', $this->ot_shipdate);
         $this->texto_tag .= "<td>" . $this->ot_shipdate . "</td>\r\n";
   }
   //----- tipoalmacen_almacen
   function NM_export_tipoalmacen_almacen()
   {
         if (!NM_is_utf8($this->tipoalmacen_almacen))
         {
             $this->tipoalmacen_almacen = mb_convert_encoding($this->tipoalmacen_almacen, "UTF-8", $_SESSION['scriptcase']['charset']);
         }
          $this->tipoalmacen_almacen = str_replace('<', '&lt;', $this->tipoalmacen_almacen);
          $this->tipoalmacen_almacen = str_replace('>', '&gt;', $this->tipoalmacen_almacen);
         $this->texto_tag .= "<td>" . $this->tipoalmacen_almacen . "</td>\r\n";
   }
   //----- usuarios_dp_nombre
   function NM_export_usuarios_dp_nombre()
   {
         if (!NM_is_utf8($this->usuarios_dp_nombre))
         {
             $this->usuarios_dp_nombre = mb_convert_encoding($this->usuarios_dp_nombre, "UTF-8", $_SESSION['scriptcase']['charset']);
         }
          $this->usuarios_dp_nombre = str_replace('<', '&lt;', $this->usuarios_dp_nombre);
          $this->usuarios_dp_nombre = str_replace('>', '&gt;', $this->usuarios_dp_nombre);
         $this->texto_tag .= "<td>" . $this->usuarios_dp_nombre . "</td>\r\n";
   }
   //----- usuarios_dp_apaterno
   function NM_export_usuarios_dp_apaterno()
   {
         if (!NM_is_utf8($this->usuarios_dp_apaterno))
         {
             $this->usuarios_dp_apaterno = mb_convert_encoding($this->usuarios_dp_apaterno, "UTF-8", $_SESSION['scriptcase']['charset']);
         }
          $this->usuarios_dp_apaterno = str_replace('<', '&lt;', $this->usuarios_dp_apaterno);
          $this->usuarios_dp_apaterno = str_replace('>', '&gt;', $this->usuarios_dp_apaterno);
         $this->texto_tag .= "<td>" . $this->usuarios_dp_apaterno . "</td>\r\n";
   }
   //----- cat_reparaciones_descripcion
   function NM_export_cat_reparaciones_descripcion()
   {
         if (!NM_is_utf8($this->cat_reparaciones_descripcion))
         {
             $this->cat_reparaciones_descripcion = mb_convert_encoding($this->cat_reparaciones_descripcion, "UTF-8", $_SESSION['scriptcase']['charset']);
         }
          $this->cat_reparaciones_descripcion = str_replace('<', '&lt;', $this->cat_reparaciones_descripcion);
          $this->cat_reparaciones_descripcion = str_replace('>', '&gt;', $this->cat_reparaciones_descripcion);
         $this->texto_tag .= "<td>" . $this->cat_reparaciones_descripcion . "</td>\r\n";
   }
   //----- reg_rep_efectuadas_fecha
   function NM_export_reg_rep_efectuadas_fecha()
   {
         $conteudo_x =  $this->reg_rep_efectuadas_fecha;
         nm_conv_limpa_dado($conteudo_x, "YYYY-MM-DD");
         if (is_numeric($conteudo_x) && $conteudo_x > 0) 
         { 
             $this->nm_data->SetaData($this->reg_rep_efectuadas_fecha, "YYYY-MM-DD");
             $this->reg_rep_efectuadas_fecha = $this->nm_data->FormataSaida($this->Nm_date_format("DT", "ddmmaaaa"));
         } 
         if (!NM_is_utf8($this->reg_rep_efectuadas_fecha))
         {
             $this->reg_rep_efectuadas_fecha = mb_convert_encoding($this->reg_rep_efectuadas_fecha, "UTF-8", $_SESSION['scriptcase']['charset']);
         }
          $this->reg_rep_efectuadas_fecha = str_replace('<', '&lt;', $this->reg_rep_efectuadas_fecha);
          $this->reg_rep_efectuadas_fecha = str_replace('>', '&gt;', $this->reg_rep_efectuadas_fecha);
         $this->texto_tag .= "<td>" . $this->reg_rep_efectuadas_fecha . "</td>\r\n";
   }

   //----- 
   function grava_arquivo_rtf()
   {
      global $nm_lang, $doc_wrap;
      $rtf_f = fopen($this->Ini->root . $this->Ini->path_imag_temp . "/" . $this->arquivo, "w");
      require_once($this->Ini->path_third      . "/rtf_new/document_generator/cl_xml2driver.php"); 
      $text_ok  =  "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>\r\n"; 
      $text_ok .=  "<DOC config_file=\"" . $this->Ini->path_third . "/rtf_new/doc_config.inc\" >\r\n"; 
      $text_ok .=  $this->texto_tag; 
      $text_ok .=  "</DOC>\r\n"; 
      $xml = new nDOCGEN($text_ok,"RTF"); 
      fwrite($rtf_f, $xml->get_result_file());
      fclose($rtf_f);
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
   //---- 
   function monta_html()
   {
      global $nm_url_saida, $nm_lang;
      include($this->Ini->path_btn . $this->Ini->Str_btn_grid);
      unset($_SESSION['sc_session'][$this->Ini->sc_page]['grafico_reparaciones']['rtf_file']);
      if (is_file($this->Ini->root . $this->Ini->path_imag_temp . "/" . $this->arquivo))
      {
          $_SESSION['sc_session'][$this->Ini->sc_page]['grafico_reparaciones']['rtf_file'] = $this->Ini->root . $this->Ini->path_imag_temp . "/" . $this->arquivo;
      }
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
            "http://www.w3.org/TR/1999/REC-html401-19991224/loose.dtd">
<HTML<?php echo $_SESSION['scriptcase']['reg_conf']['html_dir'] ?>>
<HEAD>
 <TITLE><?php echo $this->Ini->Nm_lang['lang_othr_grid_titl'] ?> - ot :: RTF</TITLE>
 <META http-equiv="Content-Type" content="text/html; charset=<?php echo $_SESSION['scriptcase']['charset_html'] ?>" />
  <META http-equiv="Expires" content="Fri, Jan 01 1900 00:00:00 GMT"/>
  <META http-equiv="Last-Modified" content="<?php echo gmdate("D, d M Y H:i:s"); ?> GMT"/>
  <META http-equiv="Cache-Control" content="no-store, no-cache, must-revalidate"/>
  <META http-equiv="Cache-Control" content="post-check=0, pre-check=0"/>
  <META http-equiv="Pragma" content="no-cache"/>
  <link rel="stylesheet" type="text/css" href="../_lib/css/<?php echo $this->Ini->str_schema_all ?>_export.css" /> 
  <link rel="stylesheet" type="text/css" href="../_lib/buttons/<?php echo $this->Ini->Str_btn_css ?>" /> 
</HEAD>
<BODY class="scExportPage">
<?php echo $this->Ini->Ajax_result_set ?>
<table style="border-collapse: collapse; border-width: 0; height: 100%; width: 100%"><tr><td style="padding: 0; text-align: center; vertical-align: middle">
 <table class="scExportTable" align="center">
  <tr>
   <td class="scExportTitle" style="height: 25px">RTF</td>
  </tr>
  <tr>
   <td class="scExportLine" style="width: 100%">
    <table style="border-collapse: collapse; border-width: 0; width: 100%"><tr><td class="scExportLineFont" style="padding: 3px 0 0 0" id="idMessage">
    <?php echo $this->Ini->Nm_lang['lang_othr_file_msge'] ?>
    </td><td class="scExportLineFont" style="text-align:right; padding: 3px 0 0 0">
     <?php echo nmButtonOutput($this->arr_buttons, "bexportview", "document.Fview.submit()", "document.Fview.submit()", "idBtnView", "", "", "", "", "", "", $this->Ini->path_botoes, "", "", "", "", "", "only_text", "text_right", "", "");
 ?>
     <?php echo nmButtonOutput($this->arr_buttons, "bdownload", "document.Fdown.submit()", "document.Fdown.submit()", "idBtnDown", "", "", "", "", "", "", $this->Ini->path_botoes, "", "", "", "", "", "only_text", "text_right", "", "");
 ?>
     <?php echo nmButtonOutput($this->arr_buttons, "bvoltar", "document.F0.submit()", "document.F0.submit()", "idBtnBack", "", "", "", "", "", "", $this->Ini->path_botoes, "", "", "", "", "", "only_text", "text_right", "", "");
 ?>
    </td></tr></table>
   </td>
  </tr>
 </table>
</td></tr></table>
<form name="Fview" method="get" action="<?php echo $this->Ini->path_imag_temp . "/" . $this->arquivo ?>" target="_blank" style="display: none"> 
</form>
<form name="Fdown" method="get" action="grafico_reparaciones_download.php" target="_blank" style="display: none"> 
<input type="hidden" name="nm_tit_doc" value="<?php echo NM_encode_input($this->tit_doc); ?>"> 
<input type="hidden" name="nm_name_doc" value="<?php echo NM_encode_input($this->Ini->path_imag_temp . "/" . $this->arquivo) ?>"> 
</form>
<FORM name="F0" method=post action="./"> 
<INPUT type="hidden" name="script_case_init" value="<?php echo NM_encode_input($this->Ini->sc_page); ?>"> 
<INPUT type="hidden" name="script_case_session" value="<?php echo NM_encode_input(session_id()); ?>"> 
<INPUT type="hidden" name="nmgp_opcao" value="volta_grid"> 
</FORM> 
</BODY>
</HTML>
<?php
   }

 function Nm_date_format($Type, $Format)
 {
     $Form_base = str_replace("/", "", $Format);
     $Form_base = str_replace("-", "", $Form_base);
     $Form_base = str_replace(":", "", $Form_base);
     $Form_base = str_replace(";", "", $Form_base);
     $Form_base = str_replace(" ", "", $Form_base);
     $Form_base = str_replace("a", "Y", $Form_base);
     $Form_base = str_replace("y", "Y", $Form_base);
     $Form_base = str_replace("h", "H", $Form_base);
     $date_format_show = "";
     if ($Type == "DT" || $Type == "DH")
     {
         $Str_date = str_replace("a", "y", strtolower($_SESSION['scriptcase']['reg_conf']['date_format']));
         $Str_date = str_replace("y", "Y", $Str_date);
         $Str_date = str_replace("h", "H", $Str_date);
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
         foreach ($Arr_D as $Cada_d)
         {
             if (strpos($Form_base, $Cada_d) !== false)
             {
                 $date_format_show .= (!$Prim) ? $_SESSION['scriptcase']['reg_conf']['date_sep'] : "";
                 $date_format_show .= $Cada_d;
                 $Prim = false;
             }
         }
     }
     if ($Type == "DH" || $Type == "HH")
     {
         if ($Type == "DH")
         {
             $date_format_show .= " ";
         }
         $Str_time = strtolower($_SESSION['scriptcase']['reg_conf']['time_format']);
         $Str_time = str_replace("h", "H", $Str_time);
         $Lim   = strlen($Str_time);
         $Ult   = "";
         $Arr_T = array();
         for ($I = 0; $I < $Lim; $I++)
         {
              $Char = substr($Str_time, $I, 1);
              if ($Char != $Ult)
              {
                  $Arr_T[] = $Char;
              }
              $Ult = $Char;
         }
         $Prim = true;
         foreach ($Arr_T as $Cada_t)
         {
             if (strpos($Form_base, $Cada_t) !== false)
             {
                 $date_format_show .= (!$Prim) ? $_SESSION['scriptcase']['reg_conf']['time_sep'] : "";
                 $date_format_show .= $Cada_t;
                 $Prim = false;
             }
         }
     }
     return $date_format_show;
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
}

?>
