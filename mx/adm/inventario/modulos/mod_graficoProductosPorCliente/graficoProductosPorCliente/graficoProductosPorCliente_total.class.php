<?php

class graficoProductosPorCliente_total
{
   var $Db;
   var $Erro;
   var $Ini;
   var $Lookup;

   var $nm_data;

   //----- 
   function graficoProductosPorCliente_total($sc_page)
   {
      $this->sc_page = $sc_page;
      $this->nm_data = new nm_data("es");
      if (isset($_SESSION['sc_session'][$this->sc_page]['graficoProductosPorCliente']['campos_busca']) && !empty($_SESSION['sc_session'][$this->sc_page]['graficoProductosPorCliente']['campos_busca']))
      { 
          $this->id = $_SESSION['sc_session'][$this->sc_page]['graficoProductosPorCliente']['campos_busca']['id']; 
          $tmp_pos = strpos($this->id, "##@@");
          if ($tmp_pos !== false)
          {
              $this->id = substr($this->id, 0, $tmp_pos);
          }
          $this->id_prod = $_SESSION['sc_session'][$this->sc_page]['graficoProductosPorCliente']['campos_busca']['id_prod']; 
          $tmp_pos = strpos($this->id_prod, "##@@");
          if ($tmp_pos !== false)
          {
              $this->id_prod = substr($this->id_prod, 0, $tmp_pos);
          }
          $this->familia = $_SESSION['sc_session'][$this->sc_page]['graficoProductosPorCliente']['campos_busca']['familia']; 
          $tmp_pos = strpos($this->familia, "##@@");
          if ($tmp_pos !== false)
          {
              $this->familia = substr($this->familia, 0, $tmp_pos);
          }
          $this->subfamilia = $_SESSION['sc_session'][$this->sc_page]['graficoProductosPorCliente']['campos_busca']['subfamilia']; 
          $tmp_pos = strpos($this->subfamilia, "##@@");
          if ($tmp_pos !== false)
          {
              $this->subfamilia = substr($this->subfamilia, 0, $tmp_pos);
          }
      } 
   }

   //---- 
   function quebra_geral()
   {
      global $nada, $nm_lang , $id_clientes;
      if ($_SESSION['sc_session'][$this->Ini->sc_page]['graficoProductosPorCliente']['contr_total_geral'] == "OK") 
      { 
          return; 
      } 
      $_SESSION['sc_session'][$this->Ini->sc_page]['graficoProductosPorCliente']['tot_geral'] = array() ;  
      if (in_array(strtolower($this->Ini->nm_tpbanco), $this->Ini->nm_bases_mssql))
      { 
          $nm_comando = "select count(*) from " . $this->Ini->nm_tabela . " " . $_SESSION['sc_session'][$this->Ini->sc_page]['graficoProductosPorCliente']['where_pesq']; 
      } 
      else 
      { 
          $nm_comando = "select count(*) from " . $this->Ini->nm_tabela . " " . $_SESSION['sc_session'][$this->Ini->sc_page]['graficoProductosPorCliente']['where_pesq']; 
      } 
      $_SESSION['scriptcase']['sc_sql_ult_comando'] = $nm_comando;
      $_SESSION['scriptcase']['sc_sql_ult_conexao'] = '';
      if (!$rt = $this->Db->Execute($nm_comando)) 
      { 
         $this->Erro->mensagem (__FILE__, __LINE__, "banco", $this->Ini->Nm_lang['lang_errm_dber'], $this->Db->ErrorMsg()); 
         exit ; 
      }
      $_SESSION['sc_session'][$this->Ini->sc_page]['graficoProductosPorCliente']['tot_geral'][0] = "" . $this->Ini->Nm_lang['lang_msgs_totl'] . ""; 
      $_SESSION['sc_session'][$this->Ini->sc_page]['graficoProductosPorCliente']['tot_geral'][1] = $rt->fields[0] ; 
      $rt->Close(); 
      $_SESSION['sc_session'][$this->Ini->sc_page]['graficoProductosPorCliente']['contr_total_geral'] = "OK";
   } 

   //-----  id_clientes
   function quebra_id_clientes_cliente($id_clientes, $arg_sum_id_clientes) 
   {
      global $tot_id_clientes , $id_clientes;  
      $tot_id_clientes = array() ;  
      $tot_id_clientes[0] = $id_clientes ; 
   }

   //----- 
   function resumo_cliente($destino_resumo, &$array_total_id_clientes)
   {
      global $nada, $nm_lang, $id_clientes;
   if (isset($_SESSION['sc_session'][$this->Ini->sc_page]['graficoProductosPorCliente']['campos_busca']) && !empty($_SESSION['sc_session'][$this->Ini->sc_page]['graficoProductosPorCliente']['campos_busca']))
   { 
       $this->id = $_SESSION['sc_session'][$this->Ini->sc_page]['graficoProductosPorCliente']['campos_busca']['id']; 
       $tmp_pos = strpos($this->id, "##@@");
       if ($tmp_pos !== false)
       {
           $this->id = substr($this->id, 0, $tmp_pos);
       }
       $this->id_prod = $_SESSION['sc_session'][$this->Ini->sc_page]['graficoProductosPorCliente']['campos_busca']['id_prod']; 
       $tmp_pos = strpos($this->id_prod, "##@@");
       if ($tmp_pos !== false)
       {
           $this->id_prod = substr($this->id_prod, 0, $tmp_pos);
       }
       $this->familia = $_SESSION['sc_session'][$this->Ini->sc_page]['graficoProductosPorCliente']['campos_busca']['familia']; 
       $tmp_pos = strpos($this->familia, "##@@");
       if ($tmp_pos !== false)
       {
           $this->familia = substr($this->familia, 0, $tmp_pos);
       }
       $this->subfamilia = $_SESSION['sc_session'][$this->Ini->sc_page]['graficoProductosPorCliente']['campos_busca']['subfamilia']; 
       $tmp_pos = strpos($this->subfamilia, "##@@");
       if ($tmp_pos !== false)
       {
           $this->subfamilia = substr($this->subfamilia, 0, $tmp_pos);
       }
   } 
   $this->sc_where_orig   = $_SESSION['sc_session'][$this->Ini->sc_page]['graficoProductosPorCliente']['where_orig'];
   $this->sc_where_atual  = $_SESSION['sc_session'][$this->Ini->sc_page]['graficoProductosPorCliente']['where_pesq'];
   $this->sc_where_filtro = $_SESSION['sc_session'][$this->Ini->sc_page]['graficoProductosPorCliente']['where_pesq_filtro'];
   $nmgp_order_by = " order by id_clientes asc"; 
      if (in_array(strtolower($this->Ini->nm_tpbanco), $this->Ini->nm_bases_sybase))
      { 
         $comando  = "select count(*), id_clientes from " . $this->Ini->nm_tabela . " " .  $this->sc_where_atual . " group by id_clientes $nmgp_order_by";
      } 
      elseif (in_array(strtolower($this->Ini->nm_tpbanco), $this->Ini->nm_bases_mssql))
      { 
          $comando  = "select count(*), id_clientes from " . $this->Ini->nm_tabela . " " .  $this->sc_where_atual . " group by id_clientes $nmgp_order_by";
      } 
      else 
      { 
         $comando  = "select count(*), id_clientes from " . $this->Ini->nm_tabela . " " . $this->sc_where_atual . " group by id_clientes $nmgp_order_by";
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
         $id_clientes      = $registro[1];
         $id_clientes_orig = $registro[1];
         $conteudo = $registro[1];
         $this->Lookup->lookup_id_clientes($conteudo , $id_clientes_orig) ; 
         $id_clientes = $conteudo;
         if (null === $id_clientes)
         {
             $id_clientes = '';
         }
         if (null === $id_clientes_orig)
         {
             $id_clientes_orig = '';
         }
         $val_grafico_id_clientes = $id_clientes;
         if (isset($id_clientes_orig))
         {
            //-----  id_clientes
            if (!isset($array_total_id_clientes[$id_clientes_orig]))
            {
               $array_total_id_clientes[$id_clientes_orig][0] = $registro[0];
               $array_total_id_clientes[$id_clientes_orig][1] = $val_grafico_id_clientes;
               $array_total_id_clientes[$id_clientes_orig][2] = $id_clientes_orig;
            }
            else
            {
               $array_total_id_clientes[$id_clientes_orig][0] += $registro[0];
            }
         } // isset
      }
   }
   //----- 
   function graficocliente(&$array_label, &$array_label_orig, &$array_datay, $array_total_id_clientes)
   {
      $array_label         = array();
      $array_label_orig    = array();
      $array_label[0]      = array();
      $array_label_orig[0] = array();
      $array_datay    = array();
      $array_datay[0] = array();
      foreach ($array_total_id_clientes as $xcampo_id_clientes => $dados_id_clientes)
      {
         //-- Label
         $campo_id_clientes      = $dados_id_clientes[1];
         $campo_orig_id_clientes = $dados_id_clientes[2];
         if (!in_array($campo_id_clientes, $array_label[0]))
         {
            $array_label[0][]      = $campo_id_clientes;
            $array_label_orig[0][] = $campo_orig_id_clientes;
         }
         //-- Total NM_Count - C
         if (!isset($array_datay[0][0]))
         {
            $array_datay[0][0] = array();
         }
         $array_datay[0][0][] = $dados_id_clientes[0];
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
