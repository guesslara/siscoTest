<?php

class grafico_almacen_destino_total
{
   var $Db;
   var $Erro;
   var $Ini;
   var $Lookup;

   var $nm_data;

   //----- 
   function grafico_almacen_destino_total($sc_page)
   {
      $this->sc_page = $sc_page;
      $this->nm_data = new nm_data("es");
      if (isset($_SESSION['sc_session'][$this->sc_page]['grafico_almacen_destino']['campos_busca']) && !empty($_SESSION['sc_session'][$this->sc_page]['grafico_almacen_destino']['campos_busca']))
      { 
      } 
   }

   //---- 
   function quebra_geral()
   {
      global $nada, $nm_lang ;
      if ($_SESSION['sc_session'][$this->Ini->sc_page]['grafico_almacen_destino']['contr_total_geral'] == "OK") 
      { 
          return; 
      } 
      $_SESSION['sc_session'][$this->Ini->sc_page]['grafico_almacen_destino']['tot_geral'] = array() ;  
      if (in_array(strtolower($this->Ini->nm_tpbanco), $this->Ini->nm_bases_mssql))
      { 
          $nm_comando = "select count(*) from " . $this->Ini->nm_tabela . " " . $_SESSION['sc_session'][$this->Ini->sc_page]['grafico_almacen_destino']['where_pesq']; 
      } 
      else 
      { 
          $nm_comando = "select count(*) from " . $this->Ini->nm_tabela . " " . $_SESSION['sc_session'][$this->Ini->sc_page]['grafico_almacen_destino']['where_pesq']; 
      } 
      $_SESSION['scriptcase']['sc_sql_ult_comando'] = $nm_comando;
      $_SESSION['scriptcase']['sc_sql_ult_conexao'] = '';
      if (!$rt = $this->Db->Execute($nm_comando)) 
      { 
         $this->Erro->mensagem (__FILE__, __LINE__, "banco", $this->Ini->Nm_lang['lang_errm_dber'], $this->Db->ErrorMsg()); 
         exit ; 
      }
      $_SESSION['sc_session'][$this->Ini->sc_page]['grafico_almacen_destino']['tot_geral'][0] = "" . $this->Ini->Nm_lang['lang_msgs_totl'] . ""; 
      $_SESSION['sc_session'][$this->Ini->sc_page]['grafico_almacen_destino']['tot_geral'][1] = $rt->fields[0] ; 
      $rt->Close(); 
      $_SESSION['sc_session'][$this->Ini->sc_page]['grafico_almacen_destino']['contr_total_geral'] = "OK";
   } 

   //-----  tipoalmacen_almacen
   function quebra_tipoalmacen_almacen_tecnico($tipoalmacen_almacen, $arg_sum_tipoalmacen_almacen) 
   {
      global $tot_tipoalmacen_almacen ;  
      $tot_tipoalmacen_almacen = array() ;  
      $tot_tipoalmacen_almacen[0] = $tipoalmacen_almacen ; 
   }

   //----- 
   function resumo_tecnico($destino_resumo, &$array_total_tipoalmacen_almacen)
   {
      global $nada, $nm_lang;
   if (isset($_SESSION['sc_session'][$this->Ini->sc_page]['grafico_almacen_destino']['campos_busca']) && !empty($_SESSION['sc_session'][$this->Ini->sc_page]['grafico_almacen_destino']['campos_busca']))
   { 
   } 
   $this->sc_where_orig   = $_SESSION['sc_session'][$this->Ini->sc_page]['grafico_almacen_destino']['where_orig'];
   $this->sc_where_atual  = $_SESSION['sc_session'][$this->Ini->sc_page]['grafico_almacen_destino']['where_pesq'];
   $this->sc_where_filtro = $_SESSION['sc_session'][$this->Ini->sc_page]['grafico_almacen_destino']['where_pesq_filtro'];
   $nmgp_order_by = " order by tipoalmacen.almacen asc"; 
      if (in_array(strtolower($this->Ini->nm_tpbanco), $this->Ini->nm_bases_sybase))
      { 
         $comando  = "select count(*), tipoalmacen.almacen from " . $this->Ini->nm_tabela . " " .  $this->sc_where_atual . " group by tipoalmacen.almacen $nmgp_order_by";
      } 
      elseif (in_array(strtolower($this->Ini->nm_tpbanco), $this->Ini->nm_bases_mssql))
      { 
          $comando  = "select count(*), tipoalmacen.almacen from " . $this->Ini->nm_tabela . " " .  $this->sc_where_atual . " group by tipoalmacen.almacen $nmgp_order_by";
      } 
      else 
      { 
         $comando  = "select count(*), tipoalmacen.almacen from " . $this->Ini->nm_tabela . " " . $this->sc_where_atual . " group by tipoalmacen.almacen $nmgp_order_by";
      } 
      if ($destino_resumo != "gra") 
      {
          $comando = str_replace("avg(", "sum(", $comando); 
      }
      $_SESSION['scriptcase']['sc_sql_ult_comando'] = $comando;
      $_SESSION['scriptcase']['sc_sql_ult_conexao'] = '';
      if (!$rt = $this->Db->Execute($comando))
      {
         $this->Erro->mensagem(__FILE__, __LINE__, "banco", $this->Ini->Nm_lang['lang_errm_dber'], $this->Db->ErrorMsg()); 
         exit;
      }
      $array_db_total = $this->get_array($rt);
      $rt->Close();
      foreach ($array_db_total as $registro)
      {
         $tipoalmacen_almacen      = $registro[1];
         $tipoalmacen_almacen_orig = $registro[1];
         $conteudo = $registro[1];
         $tipoalmacen_almacen = $conteudo;
         if (null === $tipoalmacen_almacen)
         {
             $tipoalmacen_almacen = '';
         }
         if (null === $tipoalmacen_almacen_orig)
         {
             $tipoalmacen_almacen_orig = '';
         }
         $val_grafico_tipoalmacen_almacen = $tipoalmacen_almacen;
         if (isset($tipoalmacen_almacen_orig))
         {
            //-----  tipoalmacen_almacen
            if (!isset($array_total_tipoalmacen_almacen[$tipoalmacen_almacen_orig]))
            {
               $array_total_tipoalmacen_almacen[$tipoalmacen_almacen_orig][0] = $registro[0];
               $array_total_tipoalmacen_almacen[$tipoalmacen_almacen_orig][1] = $val_grafico_tipoalmacen_almacen;
               $array_total_tipoalmacen_almacen[$tipoalmacen_almacen_orig][2] = $tipoalmacen_almacen_orig;
            }
            else
            {
               $array_total_tipoalmacen_almacen[$tipoalmacen_almacen_orig][0] += $registro[0];
            }
         } // isset
      }
   }
   //----- 
   function graficotecnico(&$array_label, &$array_label_orig, &$array_datay, $array_total_tipoalmacen_almacen)
   {
      $array_label         = array();
      $array_label_orig    = array();
      $array_label[0]      = array();
      $array_label_orig[0] = array();
      $array_datay    = array();
      $array_datay[0] = array();
      foreach ($array_total_tipoalmacen_almacen as $xcampo_tipoalmacen_almacen => $dados_tipoalmacen_almacen)
      {
         //-- Label
         $campo_tipoalmacen_almacen      = $dados_tipoalmacen_almacen[1];
         $campo_orig_tipoalmacen_almacen = $dados_tipoalmacen_almacen[2];
         if (!in_array($campo_tipoalmacen_almacen, $array_label[0]))
         {
            $array_label[0][]      = $campo_tipoalmacen_almacen;
            $array_label_orig[0][] = $campo_orig_tipoalmacen_almacen;
         }
         //-- Total NM_Count - C
         if (!isset($array_datay[0][0]))
         {
            $array_datay[0][0] = array();
         }
         $array_datay[0][0][] = $dados_tipoalmacen_almacen[0];
      }
   }

   //-----
   function get_array($rs)
   {
       if ('ado_mssql' != $this->Ini->nm_tpbanco)
       {
           return $rs->GetArray();
       }

       $array_db_total = array();
       while (!$rs->EOF)
       {
           $arr_row = array();
           foreach ($rs->fields as $k => $v)
           {
               $arr_row[$k] = $v . '';
           }
           $array_db_total[] = $arr_row;
           $rs->MoveNext();
       }
       return $array_db_total;
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
