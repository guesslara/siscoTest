<?php

class grafico_refacciones_xml
{
   var $Db;
   var $Erro;
   var $Ini;
   var $Lookup;
   var $nm_data;

   var $arquivo;
   var $arquivo_view;
   var $tit_doc;
   var $sc_proc_grid; 
   var $NM_cmp_hidden = array();

   //---- 
   function grafico_refacciones_xml()
   {
      $this->nm_data   = new nm_data("es");
   }

   //---- 
   function monta_xml()
   {
      $this->inicializa_vars();
      $this->grava_arquivo();
      $this->monta_html();
   }

   //----- 
   function inicializa_vars()
   {
      global $nm_lang;
      $dir_raiz          = strrpos($_SERVER['PHP_SELF'],"/") ;  
      $dir_raiz          = substr($_SERVER['PHP_SELF'], 0, $dir_raiz + 1) ;  
      $this->nm_location = $this->Ini->sc_protocolo . $this->Ini->server . $dir_raiz; 
      $this->nm_data    = new nm_data("es");
      $this->arquivo      = "sc_xml";
      $this->arquivo     .= "_" . date("YmdHis") . "_" . rand(0, 1000);
      $this->arquivo     .= "_grafico_refacciones";
      $this->arquivo_view = $this->arquivo . "_view.xml";
      $this->arquivo     .= ".xml";
      $this->tit_doc      = "grafico_refacciones.xml";
      $this->Grava_view   = false;
      if (strtolower($_SESSION['scriptcase']['charset']) != strtolower($_SESSION['scriptcase']['charset_html']))
      {
          $this->Grava_view = true;
      }
   }

   //----- 
   function grava_arquivo()
   {
      global $nm_lang;
      global
             $nm_nada, $nm_lang;

      $_SESSION['scriptcase']['sc_sql_ult_conexao'] = ''; 
      $this->sc_proc_grid = false; 
      $nm_raiz_img  = ""; 
      if (isset($_SESSION['scriptcase']['sc_apl_conf']['grafico_refacciones']['field_display']) && !empty($_SESSION['scriptcase']['sc_apl_conf']['grafico_refacciones']['field_display']))
      {
          foreach ($_SESSION['scriptcase']['sc_apl_conf']['grafico_refacciones']['field_display'] as $NM_cada_field => $NM_cada_opc)
          {
              $this->NM_cmp_hidden[$NM_cada_field] = $NM_cada_opc;
          }
      }
      if (isset($_SESSION['sc_session'][$this->Ini->sc_page]['grafico_refacciones']['usr_cmp_sel']) && !empty($_SESSION['sc_session'][$this->Ini->sc_page]['grafico_refacciones']['usr_cmp_sel']))
      {
          foreach ($_SESSION['sc_session'][$this->Ini->sc_page]['grafico_refacciones']['usr_cmp_sel'] as $NM_cada_field => $NM_cada_opc)
          {
              $this->NM_cmp_hidden[$NM_cada_field] = $NM_cada_opc;
          }
      }
      if (isset($_SESSION['sc_session'][$this->Ini->sc_page]['grafico_refacciones']['php_cmp_sel']) && !empty($_SESSION['sc_session'][$this->Ini->sc_page]['grafico_refacciones']['php_cmp_sel']))
      {
          foreach ($_SESSION['sc_session'][$this->Ini->sc_page]['grafico_refacciones']['php_cmp_sel'] as $NM_cada_field => $NM_cada_opc)
          {
              $this->NM_cmp_hidden[$NM_cada_field] = $NM_cada_opc;
          }
      }
      if (isset($_SESSION['sc_session'][$this->Ini->sc_page]['grafico_refacciones']['campos_busca']) && !empty($_SESSION['sc_session'][$this->Ini->sc_page]['grafico_refacciones']['campos_busca']))
      { 
      } 
      $this->nm_field_dinamico = array();
      $this->nm_order_dinamico = array();
      $this->sc_where_orig   = $_SESSION['sc_session'][$this->Ini->sc_page]['grafico_refacciones']['where_orig'];
      $this->sc_where_atual  = $_SESSION['sc_session'][$this->Ini->sc_page]['grafico_refacciones']['where_pesq'];
      $this->sc_where_filtro = $_SESSION['sc_session'][$this->Ini->sc_page]['grafico_refacciones']['where_pesq_filtro'];
      if (isset($_SESSION['sc_session'][$this->Ini->sc_page]['grafico_refacciones']['xml_name']))
      {
          $this->arquivo = $_SESSION['sc_session'][$this->Ini->sc_page]['grafico_refacciones']['xml_name'];
          $this->tit_doc = $_SESSION['sc_session'][$this->Ini->sc_page]['grafico_refacciones']['xml_name'];
          unset($_SESSION['sc_session'][$this->Ini->sc_page]['grafico_refacciones']['xml_name']);
      }
      if (!$this->Grava_view)
      {
          $this->arquivo_view = $this->arquivo;
      }
      if (in_array(strtolower($this->Ini->nm_tpbanco), $this->Ini->nm_bases_sybase))
      { 
          $nmgp_select = "SELECT ot.id as ot_id, ot.ot as ot_ot, ot.idp as ot_idp, ot.nserie as ot_nserie, ot.u_recibe as ot_u_recibe, str_replace (convert(char(10),ot.f_recibo,102), '.', '-') + ' ' + convert(char(8),ot.f_recibo,20) as ot_f_recibo, str_replace (convert(char(10),ot.fecha_fin,102), '.', '-') + ' ' + convert(char(8),ot.fecha_fin,20) as ot_fecha_fin, str_replace (convert(char(10),ot.fecha_fin_rep,102), '.', '-') + ' ' + convert(char(8),ot.fecha_fin_rep,20) as ot_fecha_fin_rep, ot.num_no_ok as ot_num_no_ok, ot.status_proceso as ot_status_proceso, ot.status_cliente as ot_status_cliente, str_replace (convert(char(10),ot.shipdate,102), '.', '-') + ' ' + convert(char(8),ot.shipdate,20) as ot_shipdate, tipoalmacen.almacen as tipoalmacen_almacen, str_replace (convert(char(10),reg_consumo_prods.fecha,102), '.', '-') + ' ' + convert(char(8),reg_consumo_prods.fecha,20) as reg_consumo_prods_fecha, cat_refacciones.descripcion as cat_refacciones_descripcion from " . $this->Ini->nm_tabela; 
      } 
      elseif (in_array(strtolower($this->Ini->nm_tpbanco), $this->Ini->nm_bases_mysql))
      { 
          $nmgp_select = "SELECT ot.id as ot_id, ot.ot as ot_ot, ot.idp as ot_idp, ot.nserie as ot_nserie, ot.u_recibe as ot_u_recibe, ot.f_recibo as ot_f_recibo, ot.fecha_fin as ot_fecha_fin, ot.fecha_fin_rep as ot_fecha_fin_rep, ot.num_no_ok as ot_num_no_ok, ot.status_proceso as ot_status_proceso, ot.status_cliente as ot_status_cliente, ot.shipdate as ot_shipdate, tipoalmacen.almacen as tipoalmacen_almacen, reg_consumo_prods.fecha as reg_consumo_prods_fecha, cat_refacciones.descripcion as cat_refacciones_descripcion from " . $this->Ini->nm_tabela; 
      } 
      elseif (in_array(strtolower($this->Ini->nm_tpbanco), $this->Ini->nm_bases_mssql))
      { 
       $nmgp_select = "SELECT ot.id as ot_id, ot.ot as ot_ot, ot.idp as ot_idp, ot.nserie as ot_nserie, ot.u_recibe as ot_u_recibe, convert(char(23),ot.f_recibo,121) as ot_f_recibo, convert(char(23),ot.fecha_fin,121) as ot_fecha_fin, convert(char(23),ot.fecha_fin_rep,121) as ot_fecha_fin_rep, ot.num_no_ok as ot_num_no_ok, ot.status_proceso as ot_status_proceso, ot.status_cliente as ot_status_cliente, convert(char(23),ot.shipdate,121) as ot_shipdate, tipoalmacen.almacen as tipoalmacen_almacen, convert(char(23),reg_consumo_prods.fecha,121) as reg_consumo_prods_fecha, cat_refacciones.descripcion as cat_refacciones_descripcion from " . $this->Ini->nm_tabela; 
      } 
      elseif (in_array(strtolower($this->Ini->nm_tpbanco), $this->Ini->nm_bases_oracle))
      { 
          $nmgp_select = "SELECT ot.id as ot_id, ot.ot as ot_ot, ot.idp as ot_idp, ot.nserie as ot_nserie, ot.u_recibe as ot_u_recibe, ot.f_recibo as ot_f_recibo, ot.fecha_fin as ot_fecha_fin, ot.fecha_fin_rep as ot_fecha_fin_rep, ot.num_no_ok as ot_num_no_ok, ot.status_proceso as ot_status_proceso, ot.status_cliente as ot_status_cliente, ot.shipdate as ot_shipdate, tipoalmacen.almacen as tipoalmacen_almacen, reg_consumo_prods.fecha as reg_consumo_prods_fecha, cat_refacciones.descripcion as cat_refacciones_descripcion from " . $this->Ini->nm_tabela; 
      } 
      elseif (in_array(strtolower($this->Ini->nm_tpbanco), $this->Ini->nm_bases_informix))
      { 
          $nmgp_select = "SELECT ot.id as ot_id, ot.ot as ot_ot, ot.idp as ot_idp, ot.nserie as ot_nserie, ot.u_recibe as ot_u_recibe, EXTEND(ot.f_recibo, YEAR TO DAY) as ot_f_recibo, EXTEND(ot.fecha_fin, YEAR TO FRACTION) as ot_fecha_fin, EXTEND(ot.fecha_fin_rep, YEAR TO DAY) as ot_fecha_fin_rep, ot.num_no_ok as ot_num_no_ok, ot.status_proceso as ot_status_proceso, ot.status_cliente as ot_status_cliente, EXTEND(ot.shipdate, YEAR TO DAY) as ot_shipdate, tipoalmacen.almacen as tipoalmacen_almacen, EXTEND(reg_consumo_prods.fecha, YEAR TO DAY) as reg_consumo_prods_fecha, cat_refacciones.descripcion as cat_refacciones_descripcion from " . $this->Ini->nm_tabela; 
      } 
      else 
      { 
          $nmgp_select = "SELECT ot.id as ot_id, ot.ot as ot_ot, ot.idp as ot_idp, ot.nserie as ot_nserie, ot.u_recibe as ot_u_recibe, ot.f_recibo as ot_f_recibo, ot.fecha_fin as ot_fecha_fin, ot.fecha_fin_rep as ot_fecha_fin_rep, ot.num_no_ok as ot_num_no_ok, ot.status_proceso as ot_status_proceso, ot.status_cliente as ot_status_cliente, ot.shipdate as ot_shipdate, tipoalmacen.almacen as tipoalmacen_almacen, reg_consumo_prods.fecha as reg_consumo_prods_fecha, cat_refacciones.descripcion as cat_refacciones_descripcion from " . $this->Ini->nm_tabela; 
      } 
      $nmgp_select .= " " . $_SESSION['sc_session'][$this->Ini->sc_page]['grafico_refacciones']['where_pesq'];
      if (isset($_SESSION['sc_session'][$this->Ini->sc_page]['grafico_refacciones']['where_resumo']) && !empty($_SESSION['sc_session'][$this->Ini->sc_page]['grafico_refacciones']['where_resumo'])) 
      { 
          if (empty($_SESSION['sc_session'][$this->Ini->sc_page]['grafico_refacciones']['where_pesq'])) 
          { 
              $nmgp_select .= " where " . $_SESSION['sc_session'][$this->Ini->sc_page]['grafico_refacciones']['where_resumo']; 
          } 
          else
          { 
              $nmgp_select .= " and (" . $_SESSION['sc_session'][$this->Ini->sc_page]['grafico_refacciones']['where_resumo'] . ")"; 
          } 
      } 
      $nmgp_order_by = $_SESSION['sc_session'][$this->Ini->sc_page]['grafico_refacciones']['order_grid'];
      $nmgp_select .= $nmgp_order_by; 
      $_SESSION['scriptcase']['sc_sql_ult_comando'] = $nmgp_select;
      $rs = $this->Db->Execute($nmgp_select);
      if ($rs === false && !$rs->EOF && $GLOBALS["NM_ERRO_IBASE"] != 1)
      {
         $this->Erro->mensagem(__FILE__, __LINE__, "banco", $this->Ini->Nm_lang['lang_errm_dber'], $this->Db->ErrorMsg());
         exit;
      }

      $xml_charset = $_SESSION['scriptcase']['charset'];
      $xml_f = fopen($this->Ini->root . $this->Ini->path_imag_temp . "/" . $this->arquivo, "w");
      fwrite($xml_f, "<?xml version=\"1.0\" encoding=\"$xml_charset\" ?>\r\n");
      fwrite($xml_f, "<root>\r\n");
      if ($this->Grava_view)
      {
          $xml_charset_v = $_SESSION['scriptcase']['charset_html'];
          $xml_v         = fopen($this->Ini->root . $this->Ini->path_imag_temp . "/" . $this->arquivo_view, "w");
          fwrite($xml_v, "<?xml version=\"1.0\" encoding=\"$xml_charset_v\" ?>\r\n");
          fwrite($xml_v, "<root>\r\n");
      }
      while (!$rs->EOF)
      {
         $this->xml_registro = "<grafico_refacciones";
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
         $this->reg_consumo_prods_fecha = $rs->fields[13] ;  
         $this->cat_refacciones_descripcion = $rs->fields[14] ;  
         $this->sc_proc_grid = true; 
         foreach ($_SESSION['sc_session'][$this->Ini->sc_page]['grafico_refacciones']['field_order'] as $Cada_col)
         { 
            if (!isset($this->NM_cmp_hidden[$Cada_col]) || $this->NM_cmp_hidden[$Cada_col] != "off")
            { 
                $NM_func_exp = "NM_export_" . $Cada_col;
                $this->$NM_func_exp();
            } 
         } 
         $this->xml_registro .= " />\r\n";
         fwrite($xml_f, $this->xml_registro);
         if ($this->Grava_view)
         {
            fwrite($xml_v, $this->xml_registro);
         }
         $rs->MoveNext();
      }
      fwrite($xml_f, "</root>");
      fclose($xml_f);
      if ($this->Grava_view)
      {
         fwrite($xml_v, "</root>");
         fclose($xml_v);
      }

      $rs->Close();
   }
   //----- ot_id
   function NM_export_ot_id()
   {
         if ($_SESSION['scriptcase']['charset'] == "UTF-8" && !NM_is_utf8($this->ot_id))
         {
             $this->ot_id = mb_convert_encoding($this->ot_id, "UTF-8");
         }
         $this->xml_registro .= " ot_id =\"" . $this->trata_dados($this->ot_id) . "\"";
   }
   //----- ot_ot
   function NM_export_ot_ot()
   {
         if ($_SESSION['scriptcase']['charset'] == "UTF-8" && !NM_is_utf8($this->ot_ot))
         {
             $this->ot_ot = mb_convert_encoding($this->ot_ot, "UTF-8");
         }
         $this->xml_registro .= " ot_ot =\"" . $this->trata_dados($this->ot_ot) . "\"";
   }
   //----- ot_idp
   function NM_export_ot_idp()
   {
         if ($_SESSION['scriptcase']['charset'] == "UTF-8" && !NM_is_utf8($this->ot_idp))
         {
             $this->ot_idp = mb_convert_encoding($this->ot_idp, "UTF-8");
         }
         $this->xml_registro .= " ot_idp =\"" . $this->trata_dados($this->ot_idp) . "\"";
   }
   //----- ot_nserie
   function NM_export_ot_nserie()
   {
         if ($_SESSION['scriptcase']['charset'] == "UTF-8" && !NM_is_utf8($this->ot_nserie))
         {
             $this->ot_nserie = mb_convert_encoding($this->ot_nserie, "UTF-8");
         }
         $this->xml_registro .= " ot_nserie =\"" . $this->trata_dados($this->ot_nserie) . "\"";
   }
   //----- ot_u_recibe
   function NM_export_ot_u_recibe()
   {
         if ($_SESSION['scriptcase']['charset'] == "UTF-8" && !NM_is_utf8($this->ot_u_recibe))
         {
             $this->ot_u_recibe = mb_convert_encoding($this->ot_u_recibe, "UTF-8");
         }
         $this->xml_registro .= " ot_u_recibe =\"" . $this->trata_dados($this->ot_u_recibe) . "\"";
   }
   //----- ot_f_recibo
   function NM_export_ot_f_recibo()
   {
         if ($_SESSION['scriptcase']['charset'] == "UTF-8" && !NM_is_utf8($this->ot_f_recibo))
         {
             $this->ot_f_recibo = mb_convert_encoding($this->ot_f_recibo, "UTF-8");
         }
         $this->xml_registro .= " ot_f_recibo =\"" . $this->trata_dados($this->ot_f_recibo) . "\"";
   }
   //----- ot_fecha_fin
   function NM_export_ot_fecha_fin()
   {
         if ($_SESSION['scriptcase']['charset'] == "UTF-8" && !NM_is_utf8($this->ot_fecha_fin))
         {
             $this->ot_fecha_fin = mb_convert_encoding($this->ot_fecha_fin, "UTF-8");
         }
         $this->xml_registro .= " ot_fecha_fin =\"" . $this->trata_dados($this->ot_fecha_fin) . "\"";
   }
   //----- ot_fecha_fin_rep
   function NM_export_ot_fecha_fin_rep()
   {
         if ($_SESSION['scriptcase']['charset'] == "UTF-8" && !NM_is_utf8($this->ot_fecha_fin_rep))
         {
             $this->ot_fecha_fin_rep = mb_convert_encoding($this->ot_fecha_fin_rep, "UTF-8");
         }
         $this->xml_registro .= " ot_fecha_fin_rep =\"" . $this->trata_dados($this->ot_fecha_fin_rep) . "\"";
   }
   //----- ot_num_no_ok
   function NM_export_ot_num_no_ok()
   {
         if ($_SESSION['scriptcase']['charset'] == "UTF-8" && !NM_is_utf8($this->ot_num_no_ok))
         {
             $this->ot_num_no_ok = mb_convert_encoding($this->ot_num_no_ok, "UTF-8");
         }
         $this->xml_registro .= " ot_num_no_ok =\"" . $this->trata_dados($this->ot_num_no_ok) . "\"";
   }
   //----- ot_status_proceso
   function NM_export_ot_status_proceso()
   {
         if ($_SESSION['scriptcase']['charset'] == "UTF-8" && !NM_is_utf8($this->ot_status_proceso))
         {
             $this->ot_status_proceso = mb_convert_encoding($this->ot_status_proceso, "UTF-8");
         }
         $this->xml_registro .= " ot_status_proceso =\"" . $this->trata_dados($this->ot_status_proceso) . "\"";
   }
   //----- ot_status_cliente
   function NM_export_ot_status_cliente()
   {
         if ($_SESSION['scriptcase']['charset'] == "UTF-8" && !NM_is_utf8($this->ot_status_cliente))
         {
             $this->ot_status_cliente = mb_convert_encoding($this->ot_status_cliente, "UTF-8");
         }
         $this->xml_registro .= " ot_status_cliente =\"" . $this->trata_dados($this->ot_status_cliente) . "\"";
   }
   //----- ot_shipdate
   function NM_export_ot_shipdate()
   {
         if ($_SESSION['scriptcase']['charset'] == "UTF-8" && !NM_is_utf8($this->ot_shipdate))
         {
             $this->ot_shipdate = mb_convert_encoding($this->ot_shipdate, "UTF-8");
         }
         $this->xml_registro .= " ot_shipdate =\"" . $this->trata_dados($this->ot_shipdate) . "\"";
   }
   //----- tipoalmacen_almacen
   function NM_export_tipoalmacen_almacen()
   {
         if ($_SESSION['scriptcase']['charset'] == "UTF-8" && !NM_is_utf8($this->tipoalmacen_almacen))
         {
             $this->tipoalmacen_almacen = mb_convert_encoding($this->tipoalmacen_almacen, "UTF-8");
         }
         $this->xml_registro .= " tipoalmacen_almacen =\"" . $this->trata_dados($this->tipoalmacen_almacen) . "\"";
   }
   //----- reg_consumo_prods_fecha
   function NM_export_reg_consumo_prods_fecha()
   {
         $conteudo_x =  $this->reg_consumo_prods_fecha;
         nm_conv_limpa_dado($conteudo_x, "YYYY-MM-DD");
         if (is_numeric($conteudo_x) && $conteudo_x > 0) 
         { 
             $this->nm_data->SetaData($this->reg_consumo_prods_fecha, "YYYY-MM-DD");
             $this->reg_consumo_prods_fecha = $this->nm_data->FormataSaida($this->Nm_date_format("DT", "ddmmaaaa"));
         } 
         if ($_SESSION['scriptcase']['charset'] == "UTF-8" && !NM_is_utf8($this->reg_consumo_prods_fecha))
         {
             $this->reg_consumo_prods_fecha = mb_convert_encoding($this->reg_consumo_prods_fecha, "UTF-8");
         }
         $this->xml_registro .= " reg_consumo_prods_fecha =\"" . $this->trata_dados($this->reg_consumo_prods_fecha) . "\"";
   }
   //----- cat_refacciones_descripcion
   function NM_export_cat_refacciones_descripcion()
   {
         if ($_SESSION['scriptcase']['charset'] == "UTF-8" && !NM_is_utf8($this->cat_refacciones_descripcion))
         {
             $this->cat_refacciones_descripcion = mb_convert_encoding($this->cat_refacciones_descripcion, "UTF-8");
         }
         $this->xml_registro .= " cat_refacciones_descripcion =\"" . $this->trata_dados($this->cat_refacciones_descripcion) . "\"";
   }

   //----- 
   function trata_dados($conteudo)
   {
      $str_temp =  $conteudo;
      $str_temp =  str_replace("<br />", "",  $str_temp);
      $str_temp =  str_replace("&", "&amp;",  $str_temp);
      $str_temp =  str_replace("<", "&lt;",   $str_temp);
      $str_temp =  str_replace(">", "&gt;",   $str_temp);
      $str_temp =  str_replace("'", "&apos;", $str_temp);
      $str_temp =  str_replace('"', "&quot;",  $str_temp);
      $str_temp =  str_replace('(', "_",  $str_temp);
      $str_temp =  str_replace(')', "",  $str_temp);
      return ($str_temp);
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
      unset($_SESSION['sc_session'][$this->Ini->sc_page]['grafico_refacciones']['xml_file']);
      if (is_file($this->Ini->root . $this->Ini->path_imag_temp . "/" . $this->arquivo))
      {
          $_SESSION['sc_session'][$this->Ini->sc_page]['grafico_refacciones']['xml_file'] = $this->Ini->root . $this->Ini->path_imag_temp . "/" . $this->arquivo;
      }
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
            "http://www.w3.org/TR/1999/REC-html401-19991224/loose.dtd">
<HTML<?php echo $_SESSION['scriptcase']['reg_conf']['html_dir'] ?>>
<HEAD>
 <TITLE><?php echo $this->Ini->Nm_lang['lang_othr_grid_titl'] ?> - ot :: XML</TITLE>
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
   <td class="scExportTitle" style="height: 25px">XML</td>
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
<form name="Fview" method="get" action="<?php echo $this->Ini->path_imag_temp . "/" . $this->arquivo_view ?>" target="_blank" style="display: none"> 
</form>
<form name="Fdown" method="get" action="grafico_refacciones_download.php" target="_blank" style="display: none"> 
<input type="hidden" name="nm_tit_doc" value="<?php echo NM_encode_input($this->tit_doc); ?>"> 
<input type="hidden" name="nm_name_doc" value="<?php echo NM_encode_input($this->Ini->path_imag_temp . "/" . $this->arquivo) ?>"> 
</form>
<FORM name="F0" method=post action="./" style="display: none"> 
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
