<?php
require_once("../../includes/funciones/funciones_iniciales.php");
$saja->set_process_file(PATH."/modulos/formulacion/plan.funciones.php");
$saja->set_process_class("plan_funciones");

echo $saja->saja_js();
$gui->pathway_recorrido("Plan",true);  

/*Integracion con SAI
$id = 'cdelfin';
$SQL = "SELECT * FROM seniat_users WHERE seniat_users_id='".$id."'";
$DB=DB_CONECCION();
$rs = $DB->Execute($SQL) or die("Error verificando");

if (!$rs->EOF){
		$_SESSION['seniat_users_id_sigme'] = $rs->fields['seniat_users_id'];
		$_SESSION['seniat_users_nombre_sigme'] = $rs->fields['seniat_users_nombre'];
		$_SESSION['seniat_users_eje_sigme'] = $rs->fields['seniat_users_eje'];			
}*/
//print_r($_SESSION);
?>

<body>
<?php $gui->marco_abrir("Ejecución del Plan");?>
<script language="JavaScript">
	<?php echo $saja->run("MuestraEje()->eje");?>

function eje_acc(){
	if (document.getElementById("txteje_id").value!=0){
		<?php 
			echo $saja->run("MuestraStatus(txteje_id:value)->st");
			echo $saja->run("MuestraRendicion(txteje_id:value)->st2");
			echo $saja->run("ListProyecto(txteje_id:value)->pry");
		?>
	}else{
		<?php echo $saja->run("LimpiaEje()");?>
	}
}

function pry_acc(){
	if (document.getElementById("txtpry_id").value!=0){
		<?php echo $saja->run("ListAE(txtpry_id:value, txteje_id:value)->ae");?>
	}else{
		<?php echo $saja->run("LimpiaPry()");?>
	}
}

function lisae_acc(){
	if (document.getElementById("txtae_id").value!=0){
		<?php 
			echo $saja->run("GridUM(txtae_id:value, txteje_id:value)->um:innerHTML");
			echo $saja->run("ListAi(txtpry_id:value, txtae_id:value, txteje_id:value)->ai");
			echo $saja->run("MuestraRendicionAE(txtpry_id:value, txtae_id:value, txteje_id:value)");
		?>
	}else{
		<?php echo $saja->run("LimpiaAe()");?>
	}
}

function lisai_acc(){
	if (document.getElementById("txtai_id").value!=0){
		<?php echo $saja->run("ListAi(txtpry_id:value, txtae_id:value, txteje_id:value)->ai");?>
	}else{
		<?php echo $saja->run("LimpiaAi()");?>
	}
}

function lisai2_acc(){
	<?php echo $saja->run("ListAi(txtpry_id:value, txtae_id:value, txteje_id:value)->ai");?>
}

function lisai_um_acc(){
	if (document.getElementById("txtai_id").value!=0){
		<?php 
			echo $saja->run("GridUM_Ai(txtai_id:value, txteje_id:value)->um_ai:innerHTML");
		?>
	}else{
		<?php echo $saja->run("LimpiaAi()");?>
	}
}
</script>

<script language="JavaScript">
function script_um(input){ 
var valor = parseInt(input.value);
if (isNaN(valor) ||  valor<0) { 
	document.getElementById(input.name).focus();
	alert('Campo vacío, no numérico o menor que cero'); 
	return input.value=0;
}else{
	document.getElementById(input.name).value = valor;
	var j_total = (parseInt(document.getElementById("um_txt_ene_ren").value) + parseInt(document.getElementById("um_txt_feb_ren").value) + parseInt(document.getElementById("um_txt_mar_ren").value) + parseInt(document.getElementById("um_txt_abr_ren").value) + parseInt(document.getElementById("um_txt_may_ren").value) + parseInt(document.getElementById("um_txt_jun_ren").value) + parseInt(document.getElementById("um_txt_jul_ren").value) + parseInt(document.getElementById("um_txt_ago_ren").value) + parseInt(document.getElementById("um_txt_sep_ren").value) + parseInt(document.getElementById("um_txt_oct_ren").value) + parseInt(document.getElementById("um_txt_nov_ren").value) + parseInt(document.getElementById("um_txt_dic_ren").value));

	document.getElementById("um_txt_total_ren").value = j_total;
}
}

function script_um_ai(input){ 
var valor = parseInt(input.value);
if (isNaN(valor) ||  valor<0) { 
	document.getElementById(input.name).focus();
	alert('Campo vacío, no numérico o menor que cero'); 
	return input.value=0;
}else{
	document.getElementById(input.name).value = valor;
	var j_total = (parseInt(document.getElementById("um_ai_txt_ene_ren").value) + parseInt(document.getElementById("um_ai_txt_feb_ren").value) + parseInt(document.getElementById("um_ai_txt_mar_ren").value) + parseInt(document.getElementById("um_ai_txt_abr_ren").value) + parseInt(document.getElementById("um_ai_txt_may_ren").value) + parseInt(document.getElementById("um_ai_txt_jun_ren").value) + parseInt(document.getElementById("um_ai_txt_jul_ren").value) + parseInt(document.getElementById("um_ai_txt_ago_ren").value) + parseInt(document.getElementById("um_ai_txt_sep_ren").value) + parseInt(document.getElementById("um_ai_txt_oct_ren").value) + parseInt(document.getElementById("um_ai_txt_nov_ren").value) + parseInt(document.getElementById("um_ai_txt_dic_ren").value));

	document.getElementById("um_ai_txt_total_ren").value = j_total;
}
}
</script>

<fieldset id="p0">
<legend>Datos B&aacute;sicos</legend>
  	  	<table border="0">
  	  <tr>
  	    <td align="center"><label><div id="des_eje" class="BoldTextGray">Unidad Ejecutora:</div></label></td>
        <td width="20">&nbsp;</td>
  	    <td align="center"><label><div id="des_rea" class="BoldTextGray">Realizado por:</div></label></td>
        <td width="20">&nbsp;</td>
  	    <td align="center"><label><div id="des_st" class="BoldTextGray">Proceso:</div></label></td>
        <td width="20">&nbsp;</td>
       	<td align="center"><label><div id="des_st2" class="BoldTextGray">Rendir:</div></label></td>
        <td width="20">&nbsp;</td>
        <td colspan="2" align="center"><label><div id="des_st3" class="BoldTextGray">Status:</div></label></td>
	   </tr>
       <tr>
        <td><label><div id="eje"></div></label></td>
        <td width="20">&nbsp;</td>
        <td><label><div id="txt_rea"><?php echo $_SESSION['seniat_users_nombre_sigme']; ?></div></label></td>     
        <td width="20">&nbsp;</td>
        <td><label><div id="st" style="display:none"></div></label></td>
        <td width="20">&nbsp;</td>
        <td><label><div id="b_ren" style="display:none"><a href="#" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('i_ren','','../../images/b_rendir_on.gif',1)" onClick="<?php echo $saja->run("RendirEje(txteje_id:value)->st2:innerHTML");?>;return false;"  ><img src="../../images/b_rendir_off.jpg" name="i_ren" width="75" height="25" border="0" id="i_ren" /></a></div></label></td>
        <td width="20">&nbsp;</td>
        <td><label>
        <div id="img_sin_rendir" style="display:none"><img src="../../images/sin_rendir.png" width="26" height="26" /></div>
        <div id="img_rendido" style="display:none"><img src="../../images/rendido.png" width="26" height="26" /></div>
        </label></td>
        <td><label><div id="st2" class="BoldTextRojo"></div></label></td>
	   </tr>
	  </table>
</fieldset>

<fieldset id="p1" style="display:none">
<legend>Parametros de Formulaci&oacute;n</legend>
  	<table border="0">
  	  <tr>
  	    <td width="192"><label><div id="des_pry" >Acci&oacute;n Centralizada / Proyecto:</div></label></td>
        <td width="23"></td>
  	    <td width="158"><label><div id="des_ae" style="display:none">Acci&oacute;n Especifica:</div></label></td>
        <td width="23">&nbsp;</td>
        <td></td>
        <td width="158"></td>
        <td width="23">&nbsp;</td>
        <td width="23">&nbsp;</td>
      </tr>
       <tr>
  	    <td><label><div id="pry"></div></label></td>
        <td width="23">&nbsp;</td>
  	    <td><label><div id="ae"></div></label></td>
        <td width="23">
        <div id="img_sin_rendir_ae" style="display:none"><img src="../../images/sin_rendir_peq.png" width="16" height="16" /></div>
        <div id="img_rendido_ae" style="display:none"><img src="../../images/rendido_peq.png" width="16" height="16" /></div></td>
        <td width="23"><label><div id="b_ver_ae"><a href="#" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('i_ver_ae','','../../images/b_mostrar_on.gif',1)" onClick="<?php echo $saja->run("GridAe(txtpry_id:value, txteje_id:value)->ae_unidad:innerHTML");?>;return false;"  ><img src="../../images/b_mostrar_off.gif" name="i_ver_ae" width="58" height="22" border="0" id="i_ver_ae" /></a></div>
<div id="b_no_ver_ae" style="display:none"><a href="#" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('i_no_ver_ae','','../../images/b_ocultar_on.gif',1)" onClick="<?php echo $saja->run("CancelarAe()");?>;return false;"  ><img src="../../images/b_ocultar_off.gif" name="i_no_ver_ae" width="58" height="22" border="0" id="i_no_ver_ae" /></a></div></label></td>
        <td></td>
        <td width="23"></td>
        <td width="23"></td>
	   </tr>
  </table>
<fieldset id="p1.1" style="display:none">
    <legend>Resumen  de Acciones Espec&iacute;fica de la unidad:</legend>
    <div id='ae_unidad'>
    </div>
</fieldset>
</fieldset>

<fieldset id="p2" style="display:none">
    <legend>Unidades de Medida de la Acci&oacute;n Espec&iacute;fica:</legend>
    <fieldset id="p3"  style="display:none">
        <legend>Programaci&oacute;n de la Unidad de Medida:</legend>
        <table border="0">
          <tr>
            <td><label><div id="des_id" >Id:</div></label></td>
            <td><label><input name="txt_id_um" type="text" id="txt_id_um" style="text-align:center" value="" size="10" readonly="readonly" maxlength=""/></label></td>
            <td><label><input name="txt_des_um" type="text" id="txt_des_um" style="text-align:left" value="" size="124" readonly="readonly" maxlength="250"/></label></td>
             <td width="100"><label><input name="txt_info" type="text" id="txt_info" style="display:none" size="5"/><div id="info_um" style="display:none"><a href="#" onClick="<?PHP echo $saja->run("Info_UM(txt_info:value)"); ?>;return false;"/>Ver Descripci&oacute;n</a></div></label></td>
          </tr>
        </table>
        <table border="0" cellspacing="5">
        <tr>
            <td align="center"><label><div id="um_des_ene" >Ene</div></label></td>
            <td align="center"><label><div id="um_des_feb" >Feb</div></label></td>
            <td align="center"><label><div id="um_des_mar" >Mar</div></label></td>
            <td align="center"><label><div id="um_des_abr" >Abr</div></label></td>
            <td align="center"><label><div id="um_des_may" >May</div></label></td>
            <td align="center"><label><div id="um_des_jun" >Jun</div></label></td>
            <td align="center"><label><div id="um_des_jul" >Jul</div></label></td>
            <td align="center"><label><div id="um_des_ago" >Ago</div></label></td>
            <td align="center"><label><div id="um_des_sep" >Sep</div></label></td>
            <td align="center"><label><div id="um_des_oct" >Oct</div></label></td>
            <td align="center"><label><div id="um_des_nov" >Nov</div></label></td>
            <td align="center"><label><div id="um_des_dic" >Dic</div></label></td>
            <td align="center"><label><div id="um_des_total" >Total</div></label></td>
          </tr>
          <tr>
            <td><label><input name="um_txt_ene" type="text" id="um_txt_ene" style="text-align:right"  value="" size="5" maxlength="11" readonly="readonly"/></label></td>
            <td><label><input name="um_txt_feb" type="text" id="um_txt_feb" style="text-align:right" value="" size="5" maxlength="11" readonly="readonly"/></label></td>
            <td><label><input name="um_txt_mar" type="text" id="um_txt_mar" style="text-align:right" value="" size="5" maxlength="11" readonly="readonly"/></label></td>
            <td><label><input name="um_txt_abr" type="text" id="um_txt_abr" style="text-align:right" value="" size="5" maxlength="11" readonly="readonly"/></label></td>
            <td><label><input name="um_txt_may" type="text" id="um_txt_may" style="text-align:right" value="" size="5" maxlength="11" readonly="readonly"/></label></td>
            <td><label><input name="um_txt_jun" type="text" id="um_txt_jun" style="text-align:right" value="" size="5" maxlength="11" readonly="readonly"/></label></td>
            <td><label><input name="um_txt_jul" type="text" id="um_txt_jul" style="text-align:right" value="" size="5" maxlength="11" readonly="readonly"/></label></td>
            <td><label><input name="um_txt_ago" type="text" id="um_txt_ago" style="text-align:right" value="" size="5" maxlength="11" readonly="readonly"/></label></td>
            <td><label><input name="um_txt_sep" type="text" id="um_txt_sep" style="text-align:right" value="" size="5" maxlength="11" readonly="readonly"/></label></td>
            <td><label><input name="um_txt_oct" type="text" id="um_txt_oct" style="text-align:right" value="" size="5" maxlength="11" readonly="readonly"/></label></td>
            <td><label><input name="um_txt_nov" type="text" id="um_txt_nov" style="text-align:right" value="" size="5" maxlength="11" readonly="readonly"/></label></td>
            <td><label><input name="um_txt_dic" type="text" id="um_txt_dic" style="text-align:right" value="" size="5" maxlength="11" readonly="readonly"/></label></td>
            <td><label><input name="um_txt_total" type="text" id="um_txt_total" style="text-align:right" value="" size="10" readonly="readonly"/></label></td>
	</tr>
        </table>
    
    
    
       <fieldset id="p3-rendicion"  style="display:none">
        <legend class='BoldTextRojo'>Rendici&oacute;n de la Unidad de Medida:</legend>
        <table border="0" cellspacing="5">
        <tr>
            <td align="center"><label><div id="um_des_ene_ren_verde" class='BoldTextVerde' style="display:none">Ene</div><div id="um_des_ene_ren_rojo" class='BoldTextRojo' style="display:none">Ene</div></label></td>
            <td align="center"><label><div id="um_des_feb_ren_verde" class='BoldTextVerde' style="display:none">Feb</div><div id="um_des_feb_ren_rojo" class='BoldTextRojo' style="display:none">Feb</div></label></td>
            <td align="center"><label><div id="um_des_mar_ren_verde" class='BoldTextVerde' style="display:none">Mar</div><div id="um_des_mar_ren_rojo" class='BoldTextRojo' style="display:none">Mar</div></label></td>
            <td align="center"><label><div id="um_des_abr_ren_verde" class='BoldTextVerde' style="display:none">Abr</div><div id="um_des_abr_ren_rojo" class='BoldTextRojo' style="display:none">Abr</div></label></td>
            <td align="center"><label><div id="um_des_may_ren_verde" class='BoldTextVerde' style="display:none">May</div><div id="um_des_may_ren_rojo" class='BoldTextRojo' style="display:none">May</div></label></td>
            <td align="center"><label><div id="um_des_jun_ren_verde" class='BoldTextVerde' style="display:none">Jun</div><div id="um_des_jun_ren_rojo" class='BoldTextRojo' style="display:none">Jun</div></label></td>
            <td align="center"><label><div id="um_des_jul_ren_verde" class='BoldTextVerde' style="display:none">Jul</div><div id="um_des_jul_ren_rojo" class='BoldTextRojo' style="display:none">Jul</div></label></td>
            <td align="center"><label><div id="um_des_ago_ren_verde" class='BoldTextVerde' style="display:none">Ago</div><div id="um_des_ago_ren_rojo" class='BoldTextRojo' style="display:none">Ago</div></label></td>
            <td align="center"><label><div id="um_des_sep_ren_verde" class='BoldTextVerde' style="display:none">Sep</div><div id="um_des_sep_ren_rojo" class='BoldTextRojo' style="display:none">Sep</div></label></td>
            <td align="center"><label><div id="um_des_oct_ren_verde" class='BoldTextVerde' style="display:none">Oct</div><div id="um_des_oct_ren_rojo" class='BoldTextRojo' style="display:none">Oct</div></label></td>
            <td align="center"><label><div id="um_des_nov_ren_verde" class='BoldTextVerde' style="display:none">Nov</div><div id="um_des_nov_ren_rojo" class='BoldTextRojo' style="display:none">Nov</div></label></td>
            <td align="center"><label><div id="um_des_dic_ren_verde" class='BoldTextVerde' style="display:none">Dic</div><div id="um_des_dic_ren_rojo" class='BoldTextRojo' style="display:none">Dic</div></label></td>
            <td align="center"><label><div id="um_des_total_ren" class="BoldTextGray">Total</div></label></td>
          </tr>
          <tr>
            <td><label><label><div id="um_ene_ren_block" style="display:none"><input name="um_txt_ene_ren2" type="text" id="um_txt_ene_ren2" style="text-align:right" size="5" maxlength="11" class="BoldTextRojo" readonly="readonly"/></div><div id="um_ene_ren_desblock" style="display:none"><input name="um_txt_ene_ren" type="text" id="um_txt_ene_ren" style="text-align:right" size="5" maxlength="11" class="BoldTextVerde" onBlur="script_um(this);"/></div></label></td>
             <td><label><label><div id="um_feb_ren_block" style="display:none"><input name="um_txt_feb_ren2" type="text" id="um_txt_feb_ren2" style="text-align:right" size="5" maxlength="11" class="BoldTextRojo" readonly="readonly"/></div><div id="um_feb_ren_desblock" style="display:none"><input name="um_txt_feb_ren" type="text" id="um_txt_feb_ren" style="text-align:right" size="5" maxlength="11" class="BoldTextVerde" onBlur="script_um(this);"/></div></label></td>
            <td><label><label><div id="um_mar_ren_block" style="display:none"><input name="um_txt_mar_ren2" type="text" id="um_txt_mar_ren2" style="text-align:right" size="5" maxlength="11" class="BoldTextRojo" readonly="readonly"/></div><div id="um_mar_ren_desblock" style="display:none"><input name="um_txt_mar_ren" type="text" id="um_txt_mar_ren" style="text-align:right" size="5" maxlength="11" class="BoldTextVerde" onBlur="script_um(this);"/></div></label></td>
           <td><label><label><div id="um_abr_ren_block" style="display:none"><input name="um_txt_abr_ren2" type="text" id="um_txt_abr_ren2" style="text-align:right" size="5" maxlength="11" class="BoldTextRojo" readonly="readonly"/></div><div id="um_abr_ren_desblock" style="display:none"><input name="um_txt_abr_ren" type="text" id="um_txt_abr_ren" style="text-align:right" size="5" maxlength="11" class="BoldTextVerde" onBlur="script_um(this);"/></div></label></td>
            <td><label><label><div id="um_may_ren_block" style="display:none"><input name="um_txt_may_ren2" type="text" id="um_txt_may_ren2" style="text-align:right" size="5" maxlength="11" class="BoldTextRojo" readonly="readonly"/></div><div id="um_may_ren_desblock" style="display:none"><input name="um_txt_may_ren" type="text" id="um_txt_may_ren" style="text-align:right" size="5" maxlength="11" class="BoldTextVerde" onBlur="script_um(this);"/></div></label></td>
            <td><label><label><div id="um_jun_ren_block" style="display:none"><input name="um_txt_jun_ren2" type="text" id="um_txt_jun_ren2" style="text-align:right" size="5" maxlength="11" class="BoldTextRojo" readonly="readonly"/></div><div id="um_jun_ren_desblock" style="display:none"><input name="um_txt_jun_ren" type="text" id="um_txt_jun_ren" style="text-align:right" size="5" maxlength="11" class="BoldTextVerde" onBlur="script_um(this);"/></div></label></td>
            <td><label><label><div id="um_jul_ren_block" style="display:none"><input name="um_txt_jul_ren2" type="text" id="um_txt_jul_ren2" style="text-align:right" size="5" maxlength="11" class="BoldTextRojo" readonly="readonly"/></div><div id="um_jul_ren_desblock" style="display:none"><input name="um_txt_jul_ren" type="text" id="um_txt_jul_ren" style="text-align:right" size="5" maxlength="11" class="BoldTextVerde" onBlur="script_um(this);"/></div></label></td>
            <td><label><label><div id="um_ago_ren_block" style="display:none"><input name="um_txt_ago_ren2" type="text" id="um_txt_ago_ren2" style="text-align:right" size="5" maxlength="11" class="BoldTextRojo" readonly="readonly"/></div><div id="um_ago_ren_desblock" style="display:none"><input name="um_txt_ago_ren" type="text" id="um_txt_ago_ren" style="text-align:right" size="5" maxlength="11" class="BoldTextVerde" onBlur="script_um(this);"/></div></label></td>
            <td><label><label><div id="um_sep_ren_block" style="display:none"><input name="um_txt_sep_ren2" type="text" id="um_txt_sep_ren2" style="text-align:right" size="5" maxlength="11" class="BoldTextRojo" readonly="readonly"/></div><div id="um_sep_ren_desblock" style="display:none"><input name="um_txt_sep_ren" type="text" id="um_txt_sep_ren" style="text-align:right" size="5" maxlength="11" class="BoldTextVerde" onBlur="script_um(this);"/></div></label></td>
            <td><label><label><div id="um_oct_ren_block" style="display:none"><input name="um_txt_oct_ren2" type="text" id="um_txt_oct_ren2" style="text-align:right" size="5" maxlength="11" class="BoldTextRojo" readonly="readonly"/></div><div id="um_oct_ren_desblock" style="display:none"><input name="um_txt_oct_ren" type="text" id="um_txt_oct_ren" style="text-align:right" size="5" maxlength="11" class="BoldTextVerde" onBlur="script_um(this);"/></div></label></td>
            <td><label><label><div id="um_nov_ren_block" style="display:none"><input name="um_txt_nov_ren2" type="text" id="um_txt_nov_ren2" style="text-align:right" size="5" maxlength="11" class="BoldTextRojo" readonly="readonly"/></div><div id="um_nov_ren_desblock" style="display:none"><input name="um_txt_nov_ren" type="text" id="um_txt_nov_ren" style="text-align:right" size="5" maxlength="11" class="BoldTextVerde" onBlur="script_um(this);"/></div></label></td>
            <td><label><label><div id="um_dic_ren_block" style="display:none"><input name="um_txt_dic_ren2" type="text" id="um_txt_dic_ren2" style="text-align:right" size="5" maxlength="11" class="BoldTextRojo" readonly="readonly"/></div><div id="um_dic_ren_desblock" style="display:none"><input name="um_txt_dic_ren" type="text" id="um_txt_dic_ren" style="text-align:right" size="5" maxlength="11" class="BoldTextVerde" onBlur="script_um(this);"/></div></label></td>
            <td><label><input name="um_txt_total_ren" type="text" id="um_txt_total_ren" style="text-align:right" value="" size="10" class="BoldTextGray" readonly="readonly"/></label></td>
            <td width="23"><label><div id="b_guardar_um"><a href="#" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('i_grabar_um','','../../images/b_grabar_on.gif',1)" onClick="<?php echo $saja->run("GuardarUM(txtpry_id:value, txtae_id:value, txteje_id:value, txt_id_um:value, txt_des_um:value, um_txt_ene_ren:value, um_txt_feb_ren:value, um_txt_mar_ren:value, um_txt_abr_ren:value, um_txt_may_ren:value, um_txt_jun_ren:value, um_txt_jul_ren:value, um_txt_ago_ren:value, um_txt_sep_ren:value, um_txt_oct_ren:value, um_txt_nov_ren:value, um_txt_dic_ren:value)->um:innerHTML");?>;return false;"  ><img src="../../images/b_grabar_off.gif" name="i_grabar_um" width="58" height="22" border="0" id="i_grabar_um" /></a></div></label></td>
          <td width="23"><label><div id="b_cancelar_um"><a href="#" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('i_cancelar_um','','../../images/b_cancelar_on.gif',1)" onClick="<?php echo $saja->run("CancelarUm()");?>;return false;"  ><img src="../../images/b_cancelar_off.gif" name="i_cancelar_um" width="58" height="22" border="0" id="i_cancelar_um" /></a></div></label></td>
	</tr>
        </table>
	</fieldset>
    </fieldset>
    <table border="0">
  	  <tr>
  	    <td><label><div id='um'></div></label></td>
      </tr>
    </table>    
</fieldset>

<fieldset id="p4" style="display:none">
	<legend>Acciones Intermedias:</legend>
    <table border="0">
    	<tr>
         	<td width="139">Acci&oacute;n Intermedia:</td>
            <td>&nbsp;</td>
          <td></td>
          <td></td>
          <td>&nbsp;</td>
        </tr>
        <tr>
         	<td width="139"><div id="ai"></div></td>
             <td></td>
        <td width="59"><label><div id="b_ver_ai"><a href="#" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('i_ver_ai','','../../images/b_mostrar_on.gif',1)" onClick="<?php echo $saja->run("GridAi(txtpry_id:value, txtae_id:value, txteje_id:value)->ai_unidad:innerHTML");?>;return false;"  ><img src="../../images/b_mostrar_off.gif" name="i_ver_ai" width="58" height="22" border="0" id="i_ver_ai" /></a></div>
<div id="b_no_ver_ai" style="display:none"><a href="#" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('i_no_ver_ai','','../../images/b_ocultar_on.gif',1)" onClick="<?php echo $saja->run("CancelarAi()");?>;return false;"  ><img src="../../images/b_ocultar_off.gif" name="i_no_ver_ai" width="58" height="22" border="0" id="i_no_ver_ai" /></a></div><div id="new_ai" style="display:none"><input name="txt_new_ai" type="text" id="txt_new_ai" value="" size="50" maxlength="250" onChange="javascript:this.value=this.value.toUpperCase();"/></div></label></td>
        <td width="19"></td>
        <td width="70"></td>
		</tr>
    </table>
    
<fieldset id="p5" style="display:none">
    <legend>Resumen de acciones intermedias de la unidad:</legend>
    	<div id='ai_unidad'></div>
</fieldset>

<fieldset id="p6" style="display:none">
    <legend>Unidades de Medida de la Acci&oacute;n Intermedia:</legend>
    <fieldset id="p7"  style="display:none">
       <legend>Programaci&oacute;n de la Unidad de Medida de la Acci&oacute;n Intermedia:</legend>
        <table border="0">
          <tr>
            <td><label><div id="des_id_ai" >Id:</div></label></td>
            <td><label><input name="txt_id_um_ai" type="text" id="txt_id_um_ai" style="text-align:center" value="" size="10" readonly="readonly" maxlength=""/></label></td>
            <td><label><input name="txt_des_um_ai" type="text" id="txt_des_um_ai" style="text-align:left" value="" size="124" readonly="readonly" maxlength="250"/></label></td>
          </tr>
        </table>
        <table border="0" cellspacing="5">
        <tr>
            <td align="center"><label><div id="um_ai_des_ene" >Ene</div></label></td>
            <td align="center"><label><div id="um_ai_des_feb" >Feb</div></label></td>
            <td align="center"><label><div id="um_ai_des_mar" >Mar</div></label></td>
            <td align="center"><label><div id="um_ai_des_abr" >Abr</div></label></td>
            <td align="center"><label><div id="um_ai_des_may" >May</div></label></td>
            <td align="center"><label><div id="um_ai_des_jun" >Jun</div></label></td>
            <td align="center"><label><div id="um_ai_des_jul" >Jul</div></label></td>
            <td align="center"><label><div id="um_ai_des_ago" >Ago</div></label></td>
            <td align="center"><label><div id="um_ai_des_sep" >Sep</div></label></td>
            <td align="center"><label><div id="um_ai_des_oct" >Oct</div></label></td>
            <td align="center"><label><div id="um_ai_des_nov" >Nov</div></label></td>
            <td align="center"><label><div id="um_ai_des_dic" >Dic</div></label></td>
            <td align="center"><label><div id="um_ai_des_total" >Total</div></label></td>
          </tr>
          <tr>
            <td><label><input name="um_ai_txt_ene" type="text" id="um_ai_txt_ene" style="text-align:right"  value="" size="5" maxlength="11" readonly="readonly"/></label></td>
            <td><label><input name="um_ai_txt_feb" type="text" id="um_ai_txt_feb" style="text-align:right" value="" size="5" maxlength="11" readonly="readonly"/></label></td>
            <td><label><input name="um_ai_txt_mar" type="text" id="um_ai_txt_mar" style="text-align:right" value="" size="5" maxlength="11" readonly="readonly"/></label></td>
            <td><label><input name="um_ai_txt_abr" type="text" id="um_ai_txt_abr" style="text-align:right" value="" size="5" maxlength="11" readonly="readonly"/></label></td>
            <td><label><input name="um_ai_txt_may" type="text" id="um_ai_txt_may" style="text-align:right" value="" size="5" maxlength="11" readonly="readonly"/></label></td>
            <td><label><input name="um_ai_txt_jun" type="text" id="um_ai_txt_jun" style="text-align:right" value="" size="5" maxlength="11" readonly="readonly"/></label></td>
            <td><label><input name="um_ai_txt_jul" type="text" id="um_ai_txt_jul" style="text-align:right" value="" size="5" maxlength="11" readonly="readonly"/></label></td>
            <td><label><input name="um_ai_txt_ago" type="text" id="um_ai_txt_ago" style="text-align:right" value="" size="5" maxlength="11" readonly="readonly"/></label></td>
            <td><label><input name="um_ai_txt_sep" type="text" id="um_ai_txt_sep" style="text-align:right" value="" size="5" maxlength="11" readonly="readonly"/></label></td>
            <td><label><input name="um_ai_txt_oct" type="text" id="um_ai_txt_oct" style="text-align:right" value="" size="5" maxlength="11" readonly="readonly"/></label></td>
            <td><label><input name="um_ai_txt_nov" type="text" id="um_ai_txt_nov" style="text-align:right" value="" size="5" maxlength="11" readonly="readonly"/></label></td>
            <td><label><input name="um_ai_txt_dic" type="text" id="um_ai_txt_dic" style="text-align:right" value="" size="5" maxlength="11" readonly="readonly"/></label></td>
            <td><label><input name="um_ai_txt_total" type="text" id="um_ai_txt_total" style="text-align:right" value="" size="10" readonly="readonly"/></label></td>
	</tr>
        </table>
       <fieldset id="p7-rendicion"  style="display:none">
        <legend class='BoldTextRojo'>Rendici&oacute;n de la Unidad de Medida de la Acci&oacute;n Intermedia:</legend>
        <table border="0" cellspacing="5">
        <tr>
            <td align="center"><label><div id="um_ai_des_ene_ren_verde" class='BoldTextVerde' style="display:none">Ene</div><div id="um_ai_des_ene_ren_rojo" class='BoldTextRojo' style="display:none">Ene</div></label></td>
            <td align="center"><label><div id="um_ai_des_feb_ren_verde" class='BoldTextVerde' style="display:none">Feb</div><div id="um_ai_des_feb_ren_rojo" class='BoldTextRojo' style="display:none">Feb</div></label></td>
            <td align="center"><label><div id="um_ai_des_mar_ren_verde" class='BoldTextVerde' style="display:none">Mar</div><div id="um_ai_des_mar_ren_rojo" class='BoldTextRojo' style="display:none">Mar</div></label></td>
            <td align="center"><label><div id="um_ai_des_abr_ren_verde" class='BoldTextVerde' style="display:none">Abr</div><div id="um_ai_des_abr_ren_rojo" class='BoldTextRojo' style="display:none">Abr</div></label></td>
            <td align="center"><label><div id="um_ai_des_may_ren_verde" class='BoldTextVerde' style="display:none">May</div><div id="um_ai_des_may_ren_rojo" class='BoldTextRojo' style="display:none">May</div></label></td>
            <td align="center"><label><div id="um_ai_des_jun_ren_verde" class='BoldTextVerde' style="display:none">Jun</div><div id="um_ai_des_jun_ren_rojo" class='BoldTextRojo' style="display:none">Jun</div></label></td>
            <td align="center"><label><div id="um_ai_des_jul_ren_verde" class='BoldTextVerde' style="display:none">Jul</div><div id="um_ai_des_jul_ren_rojo" class='BoldTextRojo' style="display:none">Jul</div></label></td>
            <td align="center"><label><div id="um_ai_des_ago_ren_verde" class='BoldTextVerde' style="display:none">Ago</div><div id="um_ai_des_ago_ren_rojo" class='BoldTextRojo' style="display:none">Ago</div></label></td>
            <td align="center"><label><div id="um_ai_des_sep_ren_verde" class='BoldTextVerde' style="display:none">Sep</div><div id="um_ai_des_sep_ren_rojo" class='BoldTextRojo' style="display:none">Sep</div></label></td>
            <td align="center"><label><div id="um_ai_des_oct_ren_verde" class='BoldTextVerde' style="display:none">Oct</div><div id="um_ai_des_oct_ren_rojo" class='BoldTextRojo' style="display:none">Oct</div></label></td>
            <td align="center"><label><div id="um_ai_des_nov_ren_verde" class='BoldTextVerde' style="display:none">Nov</div><div id="um_ai_des_nov_ren_rojo" class='BoldTextRojo' style="display:none">Nov</div></label></td>
            <td align="center"><label><div id="um_ai_des_dic_ren_verde" class='BoldTextVerde' style="display:none">Dic</div><div id="um_ai_des_dic_ren_rojo" class='BoldTextRojo' style="display:none">Dic</div></label></td>
            <td align="center"><label><div id="um_ai_des_total_ren" class="BoldTextGray">Total</div></label></td>
          </tr>
          <tr>
            <td><label><label><div id="um_ai_ene_ren_block" style="display:none"><input name="um_ai_txt_ene_ren2" type="text" id="um_ai_txt_ene_ren2" style="text-align:right" size="5" maxlength="11" class="BoldTextRojo" readonly="readonly"/></div><div id="um_ai_ene_ren_desblock" style="display:none"><input name="um_ai_txt_ene_ren" type="text" id="um_ai_txt_ene_ren" style="text-align:right" size="5" maxlength="11" class="BoldTextVerde" onBlur="script_um_ai(this);"/></div></label></td>
             <td><label><label><div id="um_ai_feb_ren_block" style="display:none"><input name="um_ai_txt_feb_ren2" type="text" id="um_ai_txt_feb_ren2" style="text-align:right" size="5" maxlength="11" class="BoldTextRojo" readonly="readonly"/></div><div id="um_ai_feb_ren_desblock" style="display:none"><input name="um_ai_txt_feb_ren" type="text" id="um_ai_txt_feb_ren" style="text-align:right" size="5" maxlength="11" class="BoldTextVerde" onBlur="script_um_ai(this);"/></div></label></td>
            <td><label><label><div id="um_ai_mar_ren_block" style="display:none"><input name="um_ai_txt_mar_ren2" type="text" id="um_ai_txt_mar_ren2" style="text-align:right" size="5" maxlength="11" class="BoldTextRojo" readonly="readonly"/></div><div id="um_ai_mar_ren_desblock" style="display:none"><input name="um_ai_txt_mar_ren" type="text" id="um_ai_txt_mar_ren" style="text-align:right" size="5" maxlength="11" class="BoldTextVerde" onBlur="script_um_ai(this);"/></div></label></td>
           <td><label><label><div id="um_ai_abr_ren_block" style="display:none"><input name="um_ai_txt_abr_ren2" type="text" id="um_ai_txt_abr_ren2" style="text-align:right" size="5" maxlength="11" class="BoldTextRojo" readonly="readonly"/></div><div id="um_ai_abr_ren_desblock" style="display:none"><input name="um_ai_txt_abr_ren" type="text" id="um_ai_txt_abr_ren" style="text-align:right" size="5" maxlength="11" class="BoldTextVerde" onBlur="script_um_ai(this);"/></div></label></td>
            <td><label><label><div id="um_ai_may_ren_block" style="display:none"><input name="um_ai_txt_may_ren2" type="text" id="um_ai_txt_may_ren2" style="text-align:right" size="5" maxlength="11" class="BoldTextRojo" readonly="readonly"/></div><div id="um_ai_may_ren_desblock" style="display:none"><input name="um_ai_txt_may_ren" type="text" id="um_ai_txt_may_ren" style="text-align:right" size="5" maxlength="11" class="BoldTextVerde" onBlur="script_um_ai(this);"/></div></label></td>
            <td><label><label><div id="um_ai_jun_ren_block" style="display:none"><input name="um_ai_txt_jun_ren2" type="text" id="um_ai_txt_jun_ren2" style="text-align:right" size="5" maxlength="11" class="BoldTextRojo" readonly="readonly"/></div><div id="um_ai_jun_ren_desblock" style="display:none"><input name="um_ai_txt_jun_ren" type="text" id="um_ai_txt_jun_ren" style="text-align:right" size="5" maxlength="11" class="BoldTextVerde" onBlur="script_um_ai(this);"/></div></label></td>
            <td><label><label><div id="um_ai_jul_ren_block" style="display:none"><input name="um_ai_txt_jul_ren2" type="text" id="um_ai_txt_jul_ren2" style="text-align:right" size="5" maxlength="11" class="BoldTextRojo" readonly="readonly"/></div><div id="um_ai_jul_ren_desblock" style="display:none"><input name="um_ai_txt_jul_ren" type="text" id="um_ai_txt_jul_ren" style="text-align:right" size="5" maxlength="11" class="BoldTextVerde" onBlur="script_um_ai(this);"/></div></label></td>
            <td><label><label><div id="um_ai_ago_ren_block" style="display:none"><input name="um_ai_txt_ago_ren2" type="text" id="um_ai_txt_ago_ren2" style="text-align:right" size="5" maxlength="11" class="BoldTextRojo" readonly="readonly"/></div><div id="um_ai_ago_ren_desblock" style="display:none"><input name="um_ai_txt_ago_ren" type="text" id="um_ai_txt_ago_ren" style="text-align:right" size="5" maxlength="11" class="BoldTextVerde" onBlur="script_um_ai(this);"/></div></label></td>
            <td><label><label><div id="um_ai_sep_ren_block" style="display:none"><input name="um_ai_txt_sep_ren2" type="text" id="um_ai_txt_sep_ren2" style="text-align:right" size="5" maxlength="11" class="BoldTextRojo" readonly="readonly"/></div><div id="um_ai_sep_ren_desblock" style="display:none"><input name="um_ai_txt_sep_ren" type="text" id="um_ai_txt_sep_ren" style="text-align:right" size="5" maxlength="11" class="BoldTextVerde" onBlur="script_um_ai(this);"/></div></label></td>
            <td><label><label><div id="um_ai_oct_ren_block" style="display:none"><input name="um_ai_txt_oct_ren2" type="text" id="um_ai_txt_oct_ren2" style="text-align:right" size="5" maxlength="11" class="BoldTextRojo" readonly="readonly"/></div><div id="um_ai_oct_ren_desblock" style="display:none"><input name="um_ai_txt_oct_ren" type="text" id="um_ai_txt_oct_ren" style="text-align:right" size="5" maxlength="11" class="BoldTextVerde" onBlur="script_um_ai(this);"/></div></label></td>
            <td><label><label><div id="um_ai_nov_ren_block" style="display:none"><input name="um_ai_txt_nov_ren2" type="text" id="um_ai_txt_nov_ren2" style="text-align:right" size="5" maxlength="11" class="BoldTextRojo" readonly="readonly"/></div><div id="um_ai_nov_ren_desblock" style="display:none"><input name="um_ai_txt_nov_ren" type="text" id="um_ai_txt_nov_ren" style="text-align:right" size="5" maxlength="11" class="BoldTextVerde" onBlur="script_um_ai(this);"/></div></label></td>
            <td><label><label><div id="um_ai_dic_ren_block" style="display:none"><input name="um_ai_txt_dic_ren2" type="text" id="um_ai_txt_dic_ren2" style="text-align:right" size="5" maxlength="11" class="BoldTextRojo" readonly="readonly"/></div><div id="um_ai_dic_ren_desblock" style="display:none"><input name="um_ai_txt_dic_ren" type="text" id="um_ai_txt_dic_ren" style="text-align:right" size="5" maxlength="11" class="BoldTextVerde" onBlur="script_um_ai(this);"/></div></label></td>
            <td><label><input name="um_ai_txt_total_ren" type="text" id="um_ai_txt_total_ren" style="text-align:right" value="" size="10" class="BoldTextGray" readonly="readonly"/></label></td>
            <td width="23"><label><div id="b_guardar_um_ai"><a href="#" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('i_grabar_um_ai','','../../images/b_grabar_on.gif',1)" onClick="<?php echo $saja->run("GuardarUM_Ai(txtpry_id:value, txtae_id:value, txteje_id:value, txtai_id:value, txt_id_um_ai:value, txt_des_um_ai:value, um_ai_txt_ene_ren:value, um_ai_txt_feb_ren:value, um_ai_txt_mar_ren:value, um_ai_txt_abr_ren:value, um_ai_txt_may_ren:value, um_ai_txt_jun_ren:value, um_ai_txt_jul_ren:value, um_ai_txt_ago_ren:value, um_ai_txt_sep_ren:value, um_ai_txt_oct_ren:value, um_ai_txt_nov_ren:value, um_ai_txt_dic_ren:value)->um_ai:innerHTML");?>;return false;"  ><img src="../../images/b_grabar_off.gif" name="i_grabar_um_ai" width="58" height="22" border="0" id="i_grabar_um_ai" /></a></div></label></td>
          <td width="23"><label><div id="b_cancelar_um_ai"><a href="#" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('i_cancelar_um_ai','','../../images/b_cancelar_on.gif',1)" onClick="<?php echo $saja->run("CancelarUm_Ai()");?>;return false;"  ><img src="../../images/b_cancelar_off.gif" name="i_cancelar_um_ai" width="58" height="22" border="0" id="i_cancelar_um_ai" /></a></div></label></td>
	</tr>
        </table>
	</fieldset>
    </fieldset>
    <table border="0">
  	  <tr>
  	    <td><label><div id='um_ai'></div></label></td>
      </tr>
    </table>    
</fieldset>
</fieldset>
<?php $gui->marco_cerrar(); ?>
</body>
</html>
