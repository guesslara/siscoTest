<?php

class grafico_ot_garantias_total
{
   var $Db;
   var $Erro;
   var $Ini;
   var $Lookup;

   var $nm_data;

   //----- 
   function grafico_ot_garantias_total($sc_page)
   {
      $this->sc_page = $sc_page;
      $this->nm_data = new nm_data("es");
      if (isset($_SESSION['sc_session'][$this->sc_page]['grafico_ot_garantias']['campos_busca']) && !empty($_SESSION['sc_session'][$this->sc_page]['grafico_ot_garantias']['campos_busca']))
      { 
          $this->id = $_SESSION['sc_session'][$this->sc_page]['grafico_ot_garantias']['campos_busca']['id']; 
          $tmp_pos = strpos($this->id, "##@@");
          if ($tmp_pos !== false)
          {
              $this->id = substr($this->id, 0, $tmp_pos);
          }
          $this->ot = $_SESSION['sc_session'][$this->sc_page]['grafico_ot_garantias']['campos_busca']['ot']; 
          $tmp_pos = strpos($this->ot, "##@@");
          if ($tmp_pos !== false)
          {
              $this->ot = substr($this->ot, 0, $tmp_pos);
          }
          $this->idp = $_SESSION['sc_session'][$this->sc_page]['grafico_ot_garantias']['campos_busca']['idp']; 
          $tmp_pos = strpos($this->idp, "##@@");
          if ($tmp_pos !== false)
          {
              $this->idp = substr($this->idp, 0, $tmp_pos);
          }
          $this->nserie = $_SESSION['sc_session'][$this->sc_page]['grafico_ot_garantias']['campos_busca']['nserie']; 
          $tmp_pos = strpos($this->nserie, "##@@");
          if ($tmp_pos !== false)
          {
              $this->nserie = substr($this->nserie, 0, $tmp_pos);
          }
      } 
   }

   //---- 
   function quebra_geral()
   {
      global $nada, $nm_lang , $repara;
      if ($_SESSION['sc_session'][$this->Ini->sc_page]['grafico_ot_garantias']['contr_total_geral'] == "OK") 
      { 
          return; 
      } 
      $_SESSION['sc_session'][$this->Ini->sc_page]['grafico_ot_garantias']['tot_geral'] = array() ;  
      if (in_array(strtolower($this->Ini->nm_tpbanco), $this->Ini->nm_bases_mssql))
      { 
          $nm_comando = "select count(*) from " . $this->Ini->nm_tabela . " " . $_SESSION['sc_session'][$this->Ini->sc_page]['grafico_ot_garantias']['where_pesq']; 
      } 
      else 
      { 
          $nm_comando = "select count(*) from " . $this->Ini->nm_tabela . " " . $_SESSION['sc_session'][$this->Ini->sc_page]['grafico_ot_garantias']['where_pesq']; 
      } 
      $_SESSION['scriptcase']['sc_sql_ult_comando'] = $nm_comando;
      $_SESSION['scriptcase']['sc_sql_ult_conexao'] = '';
      if (!$rt = $this->Db->Execute($nm_comando)) 
      { 
         $this->Erro->mensagem (__FILE__, __LINE__, "banco", $this->Ini->Nm_lang['lang_errm_dber'], $this->Db->ErrorMsg()); 
         exit ; 
      }
      $_SESSION['sc_session'][$this->Ini->sc_page]['grafico_ot_garantias']['tot_geral'][0] = "" . $this->Ini->Nm_lang['lang_msgs_totl'] . ""; 
      $_SESSION['sc_session'][$this->Ini->sc_page]['grafico_ot_garantias']['tot_geral'][1] = $rt->fields[0] ; 
      $rt->Close(); 
      $_SESSION['sc_session'][$this->Ini->sc_page]['grafico_ot_garantias']['contr_total_geral'] = "OK";
   } 

   //-----  garantia
   function quebra_garantia_tecnico($garantia, $arg_sum_garantia) 
   {
      global $tot_garantia , $repara;  
      $tot_garantia = array() ;  
      $tot_garantia[0] = $garantia ; 
   }

   //----- 
   function resumo_tecnico($destino_resumo, &$array_total_garantia)
   {
      global $nada, $nm_lang, $repara;
   if (isset($_SESSION['sc_session'][$this->Ini->sc_page]['grafico_ot_garantias']['campos_busca']) && !empty($_SESSION['sc_session'][$this->Ini->sc_page]['grafico_ot_garantias']['campos_busca']))
   { 
       $this->id = $_SESSION['sc_session'][$this->Ini->sc_page]['grafico_ot_garantias']['campos_busca']['id']; 
       $tmp_pos = strpos($this->id, "##@@");
       if ($tmp_pos !== false)
       {
           $this->id = substr($this->id, 0, $tmp_pos);
       }
       $this->ot = $_SESSION['sc_session'][$this->Ini->sc_page]['grafico_ot_garantias']['campos_busca']['ot']; 
       $tmp_pos = strpos($this->ot, "##@@");
       if ($tmp_pos !== false)
       {
           $this->ot = substr($this->ot, 0, $tmp_pos);
       }
       $this->idp = $_SESSION['sc_session'][$this->Ini->sc_page]['grafico_ot_garantias']['campos_busca']['idp']; 
       $tmp_pos = strpos($this->idp, "##@@");
       if ($tmp_pos !== false)
       {
           $this->idp = substr($this->idp, 0, $tmp_pos);
       }
       $this->nserie = $_SESSION['sc_session'][$this->Ini->sc_page]['grafico_ot_garantias']['campos_busca']['nserie']; 
       $tmp_pos = strpos($this->nserie, "##@@");
       if ($tmp_pos !== false)
       {
           $this->nserie = substr($this->nserie, 0, $tmp_pos);
       }
   } 
   $this->sc_where_orig   = $_SESSION['sc_session'][$this->Ini->sc_page]['grafico_ot_garantias']['where_orig'];
   $this->sc_where_atual  = $_SESSION['sc_session'][$this->Ini->sc_page]['grafico_ot_garantias']['where_pesq'];
   $this->sc_where_filtro = $_SESSION['sc_session'][$this->Ini->sc_page]['grafico_ot_garantias']['where_pesq_filtro'];
   $nmgp_order_by = " order by garantia asc"; 
      if (in_array(strtolower($this->Ini->nm_tpbanco), $this->Ini->nm_bases_sybase))
      { 
         $comando  = "select count(*), garantia from " . $this->Ini->nm_tabela . " " .  $this->sc_where_atual . " group by garantia $nmgp_order_by";
      } 
      elseif (in_array(strtolower($this->Ini->nm_tpbanco), $this->Ini->nm_bases_mssql))
      { 
          $comando  = "select count(*), garantia from " . $this->Ini->nm_tabela . " " .  $this->sc_where_atual . " group by garantia $nmgp_order_by";
      } 
      else 
      { 
         $comando  = "select count(*), garantia from " . $this->Ini->nm_tabela . " " . $this->sc_where_atual . " group by garantia $nmgp_order_by";
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
         $garantia      = $registro[1];
         $garantia_orig = $registro[1];
         $conteudo = $registro[1];
        nmgp_Form_Num_Val($conteudo, $_SESSION['scriptcase']['reg_conf']['grup_num'], $_SESSION['scriptcase']['reg_conf']['dec_num'], "0", "S", "2", "", "N:" . $_SESSION['scriptcase']['reg_conf']['neg_num'] , $_SESSION['scriptcase']['reg_conf']['simb_neg'], $_SESSION['scriptcase']['reg_conf']['num_group_digit']) ; 
         $garantia = $conteudo;
         if (null === $garantia)
         {
             $garantia = '';
         }
         if (null === $garantia_orig)
         {
             $garantia_orig = '';
         }
         $val_grafico_garantia = $garantia;
         if (isset($garantia_orig))
         {
            //-----  garantia
            if (!isset($array_total_garantia[$garantia_orig]))
            {
               $array_total_garantia[$garantia_orig][0] = $registro[0];
               $array_total_garantia[$garantia_orig][1] = $val_grafico_garantia;
               $array_total_garantia[$garantia_orig][2] = $garantia_orig;
            }
            else
            {
               $array_total_garantia[$garantia_orig][0] += $registro[0];
            }
         } // isset
      }
   }
   //----- 
   function graficotecnico(&$array_label, &$array_label_orig, &$array_datay, $array_total_garantia)
   {
      $array_label         = array();
      $array_label_orig    = array();
      $array_label[0]      = array();
      $array_label_orig[0] = array();
      $array_datay    = array();
      $array_datay[0] = array();
      foreach ($array_total_garantia as $xcampo_garantia => $dados_garantia)
      {
         //-- Label
         $campo_garantia      = $dados_garantia[1];
         $campo_orig_garantia = $dados_garantia[2];
         if (!in_array($campo_garantia, $array_label[0]))
         {
            $array_label[0][]      = $campo_garantia;
            $array_label_orig[0][] = $campo_orig_garantia;
         }
         //-- Total NM_Count - C
         if (!isset($array_datay[0][0]))
         {
            $array_datay[0][0] = array();
         }
         $array_datay[0][0][] = $dados_garantia[0];
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

}

?>
