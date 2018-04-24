<?php 
/*
======================================
CLASE Plan
======================================
*/
include_once("../../includes/capa_datos.php");

class clase_plan 
{

 public  $pry;
 public  $ae;
 public  $des_ae;
 public  $ai;
 public  $des_ai;
 public  $eje;
 
 public  $um_id; 
 public  $um_nombre; 
 public  $um_nota;
 public  $um_ene; 
 public  $um_feb; 
 public  $um_mar; 
 public  $um_abr; 
 public  $um_may; 
 public  $um_jun; 
 public  $um_jul; 
 public  $um_ago; 
 public  $um_sep; 
 public  $um_oct; 
 public  $um_nov; 
 public  $um_dic; 
 public  $um_total;
 public  $um_ene_ren; 
 public  $um_feb_ren; 
 public  $um_mar_ren; 
 public  $um_abr_ren; 
 public  $um_may_ren; 
 public  $um_jun_ren; 
 public  $um_jul_ren; 
 public  $um_ago_ren; 
 public  $um_sep_ren; 
 public  $um_oct_ren; 
 public  $um_nov_ren; 
 public  $um_dic_ren; 
 public  $um_total_ren;

 public  $error;
 
 public function setpry($pry)
 {
    $this->pry= $pry;
 }
 
 public function setae($ae)
 {
    $this->ae= $ae;
 }
 
 public function setdes_ae($des_ae)
 {
	if (trim($des_ae)=='')$this->seterror('Acción Específica: El nombre no puede estar vacío'); 
    $this->des_ae= $des_ae;
 }
 
 public function seteje($eje)
 {
    $this->eje= $eje;
 }
 
 public function setum_id($um_id)
 {
    $this->um_id= $um_id;
 }
 
 public function setum_nombre($um_nombre)
 {
	if (trim($um_nombre)=='')$this->seterror('Unidad de Medida: El nombre no puede estar vacío'); 
    $this->um_nombre= $um_nombre;
 }
 
 public function setmeses($um_ene, $um_feb, $um_mar, $um_abr, $um_may, $um_jun, $um_jul, $um_ago, $um_sep, $um_oct, $um_nov, $um_dic)
 {
    $this->um_ene = $um_ene;
	$this->um_feb = $um_feb;
	$this->um_mar = $um_mar;
	$this->um_abr = $um_abr;
	$this->um_may = $um_may;
	$this->um_jun = $um_jun;
	$this->um_jul = $um_jul;
	$this->um_ago = $um_ago;
	$this->um_sep = $um_sep;
	$this->um_oct = $um_oct;
	$this->um_nov = $um_nov;
	$this->um_dic = $um_dic;
 }
 
 public function setai($ai)
 {
    $this->ai= $ai;
 }
 
 public function setdes_ai($des_ai)
 {
	if (trim($des_ai)=='')$this->seterror('Acción Intermedia: El nombre no puede estar vacío'); 
    $this->des_ai= $des_ai;
 }
 
 public function geterror()
 {
    return $this->error;
 }

 public function seterror($error)
 {
    if ($this->error=='' && $error!='')$this->error='Verifique los siguentes errores: \n\n';
    $this->error .= $error.'\n';
 }

 /**
 * Clases para el trabajo con las Unidades de Medida.
 */ 
 public function Clase_BuscaUm($um, $eje)
 {
 	$SQL = "SELECT 
				safor_pry_ae_eje_um.id_um, 
				safor_pry_ae_eje_um.descripcion, 
				safor_pry_ae_eje_um.nota, 
				safor_pry_ae_eje_um.ene, 
				safor_pry_ae_eje_um.feb, 
				safor_pry_ae_eje_um.mar, 
				safor_pry_ae_eje_um.abr, 
				safor_pry_ae_eje_um.may, 
				safor_pry_ae_eje_um.jun, 
				safor_pry_ae_eje_um.jul, 
				safor_pry_ae_eje_um.ago, 
				safor_pry_ae_eje_um.sep, 
				safor_pry_ae_eje_um.oct, 
				safor_pry_ae_eje_um.nov, 
				safor_pry_ae_eje_um.dic, 
				safor_pry_ae_eje_um.total,
				safor_pry_ae_eje_um.ene_ren, 
				safor_pry_ae_eje_um.feb_ren, 
				safor_pry_ae_eje_um.mar_ren, 
				safor_pry_ae_eje_um.abr_ren, 
				safor_pry_ae_eje_um.may_ren, 
				safor_pry_ae_eje_um.jun_ren, 
				safor_pry_ae_eje_um.jul_ren, 
				safor_pry_ae_eje_um.ago_ren, 
				safor_pry_ae_eje_um.sep_ren, 
				safor_pry_ae_eje_um.oct_ren, 
				safor_pry_ae_eje_um.nov_ren, 
				safor_pry_ae_eje_um.dic_ren, 
				safor_pry_ae_eje_um.total_ren
			FROM safor_pry_ae_eje_um 
			WHERE (safor_pry_ae_eje_um.id_um = ". $um. ") AND 
				  (safor_pry_ae_eje_um.id_eje = ".$eje.")";
    $db=DB_CONECCION();
    $rs = $db->Execute($SQL ); // resultado sql
    if (!$rs->EOF)
    {
    	$this->um_id= $rs->fields['id_um'];
        $this->um_nombre= $rs->fields['descripcion'];
		$this->um_nota= $rs->fields['nota'];
		$this->um_ene= $rs->fields['ene'];
		$this->um_feb= $rs->fields['feb'];
		$this->um_mar= $rs->fields['mar'];
		$this->um_abr= $rs->fields['abr'];
		$this->um_may= $rs->fields['may'];
		$this->um_jun= $rs->fields['jun'];
		$this->um_jul= $rs->fields['jul'];
		$this->um_ago= $rs->fields['ago'];
		$this->um_sep= $rs->fields['sep'];
		$this->um_oct= $rs->fields['oct'];
		$this->um_nov= $rs->fields['nov'];
		$this->um_dic= $rs->fields['dic'];
		$this->um_total= $rs->fields['total'];
		$this->um_ene_ren= $rs->fields['ene_ren'];
		$this->um_feb_ren= $rs->fields['feb_ren'];
		$this->um_mar_ren= $rs->fields['mar_ren'];
		$this->um_abr_ren= $rs->fields['abr_ren'];
		$this->um_may_ren= $rs->fields['may_ren'];
		$this->um_jun_ren= $rs->fields['jun_ren'];
		$this->um_jul_ren= $rs->fields['jul_ren'];
		$this->um_ago_ren= $rs->fields['ago_ren'];
		$this->um_sep_ren= $rs->fields['sep_ren'];
		$this->um_oct_ren= $rs->fields['oct_ren'];
		$this->um_nov_ren= $rs->fields['nov_ren'];
		$this->um_dic_ren= $rs->fields['dic_ren'];
		$this->um_total_ren= $rs->fields['total_ren'];
     }
 }
 
public function Clase_GuardarUm() 
 {
    if ($this->error!="")return $array=array(false,$this->error,0);
    $SQL = "call grabar_um ('$this->pry', '$this->ae', '$this->eje', '$this->um_id', '$this->um_nombre', '$this->um_ene', '$this->um_feb', '$this->um_mar', '$this->um_abr', '$this->um_may', '$this->um_jun', '$this->um_jul', '$this->um_ago', '$this->um_sep', '$this->um_oct', '$this->um_nov', '$this->um_dic', '".$_SESSION['seniat_users_id_sigme']."', '".$_SERVER['REMOTE_ADDR']."')";
    $db=DB_CONECCION();
    $rs = $db->Execute($SQL) or die("Error guardando");
    $db->close();
    return $array=array($rs->fields[0],utf8_decode($rs->fields[1]),$rs->fields[2]);
 }

 /**
 * Clases para el trabajo con las acciones intermedias.
 */
 
 public function Clase_BuscaUm_Ai($um, $eje)
 {
 	$SQL = "SELECT 
				safor_pry_ae_ai_eje_um.id_um, 
				safor_pry_ae_ai_eje_um.descripcion, 
				safor_pry_ae_ai_eje_um.ene, 
				safor_pry_ae_ai_eje_um.feb, 
				safor_pry_ae_ai_eje_um.mar, 
				safor_pry_ae_ai_eje_um.abr, 
				safor_pry_ae_ai_eje_um.may, 
				safor_pry_ae_ai_eje_um.jun, 
				safor_pry_ae_ai_eje_um.jul, 
				safor_pry_ae_ai_eje_um.ago, 
				safor_pry_ae_ai_eje_um.sep, 
				safor_pry_ae_ai_eje_um.oct, 
				safor_pry_ae_ai_eje_um.nov, 
				safor_pry_ae_ai_eje_um.dic, 
				safor_pry_ae_ai_eje_um.total,
				safor_pry_ae_ai_eje_um.ene_ren, 
				safor_pry_ae_ai_eje_um.feb_ren, 
				safor_pry_ae_ai_eje_um.mar_ren, 
				safor_pry_ae_ai_eje_um.abr_ren, 
				safor_pry_ae_ai_eje_um.may_ren, 
				safor_pry_ae_ai_eje_um.jun_ren, 
				safor_pry_ae_ai_eje_um.jul_ren, 
				safor_pry_ae_ai_eje_um.ago_ren, 
				safor_pry_ae_ai_eje_um.sep_ren, 
				safor_pry_ae_ai_eje_um.oct_ren, 
				safor_pry_ae_ai_eje_um.nov_ren, 
				safor_pry_ae_ai_eje_um.dic_ren, 
				safor_pry_ae_ai_eje_um.total_ren
			FROM safor_pry_ae_ai_eje_um 
			WHERE (safor_pry_ae_ai_eje_um.id_um = ". $um. ") AND 
				  (safor_pry_ae_ai_eje_um.id_eje = ".$eje.")";
    $db=DB_CONECCION();
    $rs = $db->Execute($SQL ); // resultado sql
    if (!$rs->EOF)
    {
    	$this->um_id= $rs->fields['id_um'];
        $this->um_nombre= $rs->fields['descripcion'];
		$this->um_ene= $rs->fields['ene'];
		$this->um_feb= $rs->fields['feb'];
		$this->um_mar= $rs->fields['mar'];
		$this->um_abr= $rs->fields['abr'];
		$this->um_may= $rs->fields['may'];
		$this->um_jun= $rs->fields['jun'];
		$this->um_jul= $rs->fields['jul'];
		$this->um_ago= $rs->fields['ago'];
		$this->um_sep= $rs->fields['sep'];
		$this->um_oct= $rs->fields['oct'];
		$this->um_nov= $rs->fields['nov'];
		$this->um_dic= $rs->fields['dic'];
		$this->um_total= $rs->fields['total'];
		$this->um_ene_ren= $rs->fields['ene_ren'];
		$this->um_feb_ren= $rs->fields['feb_ren'];
		$this->um_mar_ren= $rs->fields['mar_ren'];
		$this->um_abr_ren= $rs->fields['abr_ren'];
		$this->um_may_ren= $rs->fields['may_ren'];
		$this->um_jun_ren= $rs->fields['jun_ren'];
		$this->um_jul_ren= $rs->fields['jul_ren'];
		$this->um_ago_ren= $rs->fields['ago_ren'];
		$this->um_sep_ren= $rs->fields['sep_ren'];
		$this->um_oct_ren= $rs->fields['oct_ren'];
		$this->um_nov_ren= $rs->fields['nov_ren'];
		$this->um_dic_ren= $rs->fields['dic_ren'];
		$this->um_total_ren= $rs->fields['total_ren'];
     }
 }
 
 public function Clase_GuardarUm_Ai() 
 {
    if ($this->error!="")return $array=array(false,$this->error,0);
    $SQL = "call grabar_um_ai ('$this->pry', '$this->ae', '$this->ai', '$this->eje', '$this->um_id', '$this->um_nombre', '$this->um_ene', '$this->um_feb', '$this->um_mar', '$this->um_abr', '$this->um_may', '$this->um_jun', '$this->um_jul', '$this->um_ago', '$this->um_sep', '$this->um_oct', '$this->um_nov', '$this->um_dic', '".$_SESSION['seniat_users_id_sigme']."', '".$_SERVER['REMOTE_ADDR']."')";
    $db=DB_CONECCION();
    $rs = $db->Execute($SQL) or die("Error guardando");
    $db->close();
    return $array=array($rs->fields[0],utf8_decode($rs->fields[1]),$rs->fields[2]);
 }
 
 public function Clase_RendirEje() 
 {
    if ($this->error!="")return $array=array(false,$this->error,0);
    $SQL = "call rendir ('$this->eje', '".$_SESSION['seniat_users_id_sigme']."', '".$_SERVER['REMOTE_ADDR']."')";
    $db=DB_CONECCION();
    $rs = $db->Execute($SQL) or die("Error guardando");
    $db->close();
    return $array=array($rs->fields[0],utf8_decode($rs->fields[1]),$rs->fields[2]);
 }
}?>
