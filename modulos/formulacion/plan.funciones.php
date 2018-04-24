<?php 
/*
======================================
FUNCTIONS Plan
======================================
*/
include_once("../../includes/configuracion.php");
include_once("../../includes/capa_datos.php");

class plan_funciones extends saja 
{	
	public $eje;
	
	function LimpiaEje()
	{	
		$this->hide("des_st");
		$this->hide("st");
		$this->hide("p1");
		$this->LimpiaPry();
	}
	
	function Eje_Filtra()
	{	
		$this->show("des_st");
		$this->show("st");
		$this->show("st2");
		$this->LimpiaPry();
		
		$this->js('eje_acc()');
		$this->show("p1");	
	}
	
	function MuestraEje()
	{			
		include_once(PATH.'/gui/ObjetoListBox.class.php');
		$lb = new ListBoxObj();
		$lb->setquery(	"SELECT 
					  		seniat_users_eje.seniat_users_eje, 
							safor_eje.descripcion, 
							seniat_users_eje.seniat_users_cerrado_plan,
							seniat_users_eje.seniat_users_cerrado_ppto
						FROM seniat_users_eje INNER JOIN safor_eje ON
							 seniat_users_eje.seniat_users_eje = safor_eje.id_eje
						WHERE seniat_users_eje.seniat_users_id='".$_SESSION['seniat_users_id_sigme']."'
						ORDER BY seniat_users_eje.seniat_users_eje");
		$lb->setnombre_listbox('txteje_id');
		$lb->setvalor_inicial(array('0',''));
		$lb->setajax_event('onchange');
		$lb->setajax_div('ejes');
		$lb->setajax_file_root(PATH."/modulos/formulacion/plan.funciones.php");
		$lb->setajax_class_name("plan_funciones");
		$lb->setajax_parametro_function(0);
		$lb->setajax_function_on_event('Eje_Filtra');
		$lb->GENERA_LISTBOX($_SESSION['seniat_users_eje_sigme'],'',TRUE);		
		
		$this->Eje_Filtra(); //para mostrar al prestablecido 
	}
	
	function MuestraStatus($eje)
	{	
	   $_SESSION['seniat_users_eje_temp_sigme'] = $eje; //Asigna el ejecutor temporal
	   
		//para el status de la del proceso 
		$SQL = "SELECT seniat_users_cerrado_plan, seniat_users_rinde FROM seniat_users_eje WHERE seniat_users_eje='".$eje."' AND seniat_users_id='".$_SESSION['seniat_users_id_sigme']."'"; 
       $db=DB_CONECCION();
       $rs = $db->Execute($SQL ); // resultado sql
       if (!$rs->EOF)
       {
		 $_SESSION['seniat_users_cerrado_plan_sigme'] = $rs->fields['seniat_users_cerrado_plan'];
		  
		 if ($_SESSION['seniat_users_cerrado_plan_sigme']) 
		 {
         	 return "Proceso Cerrado (Solo Consulta)"; 
		 }else{
			 return "Proceso Abierto";
		 }
       }
	}
	
	function MuestraRendicion($eje)
	{	 
	
	 //para el mes que rinde
	   $SQL = "SELECT mes_rendicion, mes_rendicion_global FROM safor_eje WHERE id_eje='".$eje."'"; 
       $db=DB_CONECCION();
       $rs = $db->Execute($SQL ); // resultado sql
       if (!$rs->EOF)
       {
		 $_SESSION['mes_rendicion'] = $rs->fields['mes_rendicion'];
		 $_SESSION['mes_rendicion_global'] = $rs->fields['mes_rendicion_global'];
       }
	   
	   //para el status de la del proceso 
	   $SQL = "SELECT seniat_users_cerrado_plan, seniat_users_rinde FROM seniat_users_eje WHERE seniat_users_eje='".$eje."' AND seniat_users_id='".$_SESSION['seniat_users_id_sigme']."'"; 
       $db=DB_CONECCION();
       $rs = $db->Execute($SQL ); // resultado sql
       if (!$rs->EOF)
       {
		 $_SESSION['seniat_users_cerrado_plan_sigme'] = $rs->fields['seniat_users_cerrado_plan'];
		 $_SESSION['seniat_users_rinde_sigme'] = $rs->fields['seniat_users_rinde'];
	   }
	   
	  if (($_SESSION['mes_rendicion'])>($_SESSION['mes_rendicion_global'])) 
	   	  {	
			$this->hide("des_st2"); 
			$this->hide("b_ren");
			
			$this->show("img_rendido"); 
			$this->hide("img_sin_rendir");  
         	return "Rendido";
		 }else{
			if ($_SESSION['seniat_users_cerrado_plan_sigme'])
			{ 
				$this->hide("des_st2"); 
				$this->hide("b_ren");
			}else{
				if ($_SESSION['seniat_users_rinde_sigme'])
				{
					$this->show("des_st2"); 
					$this->show("b_ren"); 
				}else{
					$this->hide("des_st2"); 
					$this->hide("b_ren");
				}
			}
			
			$this->hide("img_rendido"); 
			$this->show("img_sin_rendir");  
			return "Sin Rendir";
		 }
	}
	
	function LimpiaPry()
	{	
		$this->hide("img_rendido_ae"); 
		$this->hide("img_sin_rendir_ae");  
		
		$this->hide("des_ae");
		$this->hide("ae");
		$this->hide("b_ver_ae");
		$this->hide("b_no_ver_ae");
		$this->hide("p1.1");
		$this->hide("p2");
		$this->hide("p3");
		$this->hide("p3-rendicion");
		$this->hide("p4");
	}
	
	function Pry_Filtra()
	{	
		$this->hide("img_rendido_ae"); 
		$this->hide("img_sin_rendir_ae");  
		
		$this->hide("b_ver_ae");
		$this->hide("b_no_ver_ae");
		$this->hide("p1.1");
		$this->hide("p2");
		$this->hide("p3");
		$this->hide("p3-rendicion");
		$this->hide("p4");
		
		$this->js('pry_acc()');
		$this->show("des_ae");
		$this->show("ae");
	}

    function ListProyecto($eje)
	{				
		include_once(PATH.'/gui/ObjetoListBox.class.php');
		$lb = new ListBoxObj();
		$lb->setquery(	"SELECT 
					  		safor_pry.id_pry, 
							safor_pry.descripcion
						FROM safor_pry 
						WHERE ((safor_pry.id_eje=".$eje.") AND 
							   (safor_pry.poa=TRUE))
						ORDER BY safor_pry.id_pry");
		$lb->setnombre_listbox('txtpry_id');
		$lb->setvalor_inicial(array('0',''));
		$lb->setajax_event('onchange');
		$lb->setajax_div('prys');
		$lb->setajax_file_root(PATH."/modulos/formulacion/plan.funciones.php");
		$lb->setajax_class_name("plan_funciones");
		$lb->setajax_parametro_function(0);
		$lb->setajax_function_on_event('Pry_Filtra');
		$lb->GENERA_LISTBOX(0,'',TRUE);				
	}
	
	function LimpiaAe()
	{	
		$this->show("b_ver_ae");
		$this->hide("b_no_ver_ae");
		$this->hide("p1.1");
		$this->hide("p2");
		$this->hide("p3");
		$this->hide("p3-rendicion");
		$this->hide("p4");
		$this->hide("p5");
		$this->hide("p6");
		$this->hide("p7");
	}
	
	function Ae_Filtra()
	{
		$this->js('lisae_acc()');
		
		$this->hide("img_rendido_ae"); 
		$this->hide("img_sin_rendir_ae");  
		
		$this->show("b_ver_ae");
		$this->hide("b_no_ver_ae");
		$this->hide("p1.1");
		$this->show("p2");
		$this->show("p4");
		$this->hide("p5");		
		$this->show("b_ver_ai");
		$this->hide("b_no_ver_ai");
		$this->hide("p6");
		$this->hide("p7");
		$this->hide("p7-rendicion");
	}
	
	function ListAE($pry, $eje)
	{
		include_once(PATH.'/gui/ObjetoListBox.class.php');
		$lb = new ListBoxObj();
		$lb->setquery(	"SELECT
							safor_ae.id_ae, 
							LEFT(safor_ae.descripcion,50)
						FROM safor_ae
						WHERE ((safor_ae.id_pry=".$pry.") AND 
							   (safor_ae.id_eje=".$eje.") AND 
							   (safor_ae.poa=TRUE))
						ORDER BY safor_ae.id_ae");
		$lb->setnombre_listbox('txtae_id');
		$lb->setvalor_inicial(array('0',''));
		$lb->setajax_event('onchange');
		$lb->setajax_div('aes');
		$lb->setajax_file_root(PATH."/modulos/formulacion/plan.funciones.php");
		$lb->setajax_class_name("plan_funciones");
		$lb->setajax_parametro_function(0);
		$lb->setajax_function_on_event('Ae_Filtra');
		$lb->GENERA_LISTBOX(0,'',TRUE);	
		
	  	$this->show("b_ver_ae");
	}
	
	
	function GridAe($pry, $eje) 
    {
		$this->show("p1.1");
		$this->hide("b_ver_ae");
		$this->show("b_no_ver_ae");
        include_once(PATH.'/gui/ObjetoGrid.class.php');
        $gr = new GridOj();
        $sql="SELECT 
					safor_ae.id_ae, 
					LEFT(safor_ae.descripcion,150),
					IF(safor_ae.rindio=1,'SI','NO') AS Status
				FROM safor_ae
				WHERE ((safor_ae.id_pry=".$pry.") AND 
				   	  (safor_ae.id_eje=".$eje.") AND
					  (safor_ae.poa=TRUE))	
				ORDER BY safor_ae.id_ae";
        $gr->setquery($sql);
        $gr->settipo_scroll("scroll_grande");
        $gr->setalias_columnas(array('Id', 'Descripcion', 'Rendido'));
        $gr->setnombre("GridAe");
        $gr->setajax_file_root(PATH."/modulos/formulacion/plan.funciones.php");
		$gr->setajax_class_name("plan_funciones");
        $gr->setajax_div("ae_unidad");
        $gr->setccs_class_grid("grid");
        $gr->setpaginador(10);
        return $gr->GENERA_GRID(true,true,true);
    }
	
	function CancelarAe() 
    {		
		$this->show("b_ver_ae");
		$this->hide("b_no_ver_ae");
		$this->hide("p1.1");
	}
	
	function MuestraRendicionAE($pry, $ae, $eje)
	{
	   $SQL = "SELECT safor_ae.rindio FROM safor_ae WHERE ((safor_ae.id_pry=".$pry.") 
	   			AND (safor_ae.id_ae=".$ae.") AND (safor_ae.id_eje=".$eje.") AND 
				(safor_ae.poa=TRUE))";
	   $db=DB_CONECCION();
       $rs = $db->Execute($SQL ); // resultado sql
       if (!$rs->EOF)
       {  
		 if ($rs->fields['rindio']) 
		 {	
		 	$this->show("img_rendido_ae"); 
			$this->hide("img_sin_rendir_ae");  
		 }else{
			$this->hide("img_rendido_ae"); 
			$this->show("img_sin_rendir_ae");  
		 }
       }
	}
	
	//**********************************************************
	//FUNCIONES PARA EL TRABAJO CON LO DE LAS UNIDADES DE MEDIDA
	//**********************************************************
	function GridUM($ae, $eje) 
    {
		$this->hide("p3"); //para ocultar cada vez que de doy a la unidad de medida
		$this->hide("p3-rendicion");
		
        include_once(PATH.'/gui/ObjetoGrid.class.php');
        $gr = new GridOj();
        $sql="SELECT 
					safor_pry_ae_eje_um.id_um, 
					Left(safor_pry_ae_eje_um.descripcion,50),
					FORMAT((ene_ren+feb_ren+mar_ren),0) AS trim1, 
					FORMAT((abr_ren+may_ren+jun_ren),0) AS trim2, 
					FORMAT((jul_ren+ago_ren+sep_ren),0) AS trim3, 
					FORMAT((oct_ren+nov_ren+dic_ren),0) AS trim4,
					FORMAT(safor_pry_ae_eje_um.total_ren,0),
					IF(safor_pry_ae_eje_um.rindio=1,'SI','NO') AS Status
				FROM safor_pry_ae_eje_um
				WHERE ((safor_pry_ae_eje_um.id_ae=".$ae.") AND 
				   	  (safor_pry_ae_eje_um.id_eje=".$eje."))
				ORDER BY safor_pry_ae_eje_um.id_um";
        $gr->setquery($sql);
        $gr->settipo_scroll('scroll_grande');
        $gr->setalias_columnas(array('Id', 'Descripcion', 'Trim 1', 'Trim 2' , 'Trim 3', 'Trim 4', 'Total', 'Rendido'));
        $gr->setnombre("GridUM");
        $gr->setajax_file_root(PATH."/modulos/formulacion/plan.funciones.php");
		$gr->setajax_class_name("plan_funciones");
		$gr->setajax_parametro_editar(0);
		$gr->setajax_funcion_editar("Llenar_UM");
        $gr->setajax_div("um");
        $gr->setccs_class_grid("grid");
        $gr->setpaginador(10);
        return $gr->GENERA_GRID(true,true,true);
    }
	
	
	function Info_UM($des) 
    {
		$this->js("alert('".$des."')");
	}
	
	function Llenar_UM($um) 
    {
		$this->eje = $_SESSION['seniat_users_eje_temp_sigme'];
		
		//para mostrar solo los meses que se quieren rendir
		if (($_SESSION['mes_rendicion'])>($_SESSION['mes_rendicion_global']) or ($_SESSION['seniat_users_cerrado_plan_sigme'])) 
		{
			$this->hide("b_guardar_um");
		}else{
			$this->show("b_guardar_um");
		}	
				
		$this->hide("um_des_ene_ren_rojo"); $this->hide("um_des_ene_ren_verde"); 
 		$this->hide("um_des_feb_ren_rojo"); $this->hide("um_des_feb_ren_verde"); 
		$this->hide("um_des_mar_ren_rojo"); $this->hide("um_des_mar_ren_verde"); 
		$this->hide("um_des_abr_ren_rojo"); $this->hide("um_des_abr_ren_verde"); 
		$this->hide("um_des_may_ren_rojo"); $this->hide("um_des_may_ren_verde"); 	
		$this->hide("um_des_jun_ren_rojo"); $this->hide("um_des_jun_ren_verde"); 
		$this->hide("um_des_jul_ren_rojo"); $this->hide("um_des_jul_ren_verde"); 
		$this->hide("um_des_ago_ren_rojo"); $this->hide("um_des_ago_ren_verde"); 
		$this->hide("um_des_sep_ren_rojo"); $this->hide("um_des_sep_ren_verde"); 
		$this->hide("um_des_oct_ren_rojo"); $this->hide("um_des_oct_ren_verde"); 
		$this->hide("um_des_nov_ren_rojo"); $this->hide("um_des_nov_ren_verde"); 
		$this->hide("um_des_dic_ren_rojo"); $this->hide("um_des_dic_ren_verde"); 
		
		$this->hide("um_ene_ren_block"); $this->hide("um_ene_ren_desblock"); 
		$this->hide("um_feb_ren_block"); $this->hide("um_feb_ren_desblock"); 
		$this->hide("um_mar_ren_block"); $this->hide("um_mar_ren_desblock"); 
		$this->hide("um_abr_ren_block"); $this->hide("um_abr_ren_desblock"); 
		$this->hide("um_may_ren_block"); $this->hide("um_may_ren_desblock"); 
		$this->hide("um_jun_ren_block"); $this->hide("um_jun_ren_desblock"); 
		$this->hide("um_jul_ren_block"); $this->hide("um_jul_ren_desblock"); 
		$this->hide("um_ago_ren_block"); $this->hide("um_ago_ren_desblock"); 
		$this->hide("um_sep_ren_block"); $this->hide("um_sep_ren_desblock"); 
		$this->hide("um_oct_ren_block"); $this->hide("um_oct_ren_desblock"); 
		$this->hide("um_nov_ren_block"); $this->hide("um_nov_ren_desblock"); 
		$this->hide("um_dic_ren_block"); $this->hide("um_dic_ren_desblock"); 
		
		if ((($_SESSION['mes_rendicion'])/($_SESSION['mes_rendicion_global']))<=1){
			//Para Mostrar los ya rendidos
			for($i = 0; $i < ($_SESSION['mes_rendicion']); $i+=1){
				 if ($i==1){ 
					$this->show("um_des_ene_ren_rojo"); $this->hide("um_des_ene_ren_verde");
					$this->show("um_ene_ren_block"); $this->hide("um_ene_ren_desblock");
				 }
 				 if ($i==2){ 
					$this->show("um_des_feb_ren_rojo"); $this->hide("um_des_feb_ren_verde");
					$this->show("um_feb_ren_block"); $this->hide("um_feb_ren_desblock");
				 }
				 if ($i==3){ 
					$this->show("um_des_mar_ren_rojo"); $this->hide("um_des_mar_ren_verde");
					$this->show("um_mar_ren_block"); $this->hide("um_mar_ren_desblock");
				 }
				 if ($i==4){ 
					$this->show("um_des_abr_ren_rojo"); $this->hide("um_des_abr_ren_verde");
					$this->show("um_abr_ren_block"); $this->hide("um_abr_ren_desblock");
				 }
				 if ($i==5){ 
					$this->show("um_des_may_ren_rojo"); $this->hide("um_des_may_ren_verde");
					$this->show("um_may_ren_block"); $this->hide("um_may_ren_desblock");
				 }
				 if ($i==6){ 
					$this->show("um_des_jun_ren_rojo"); $this->hide("um_des_jun_ren_verde");
					$this->show("um_jun_ren_block"); $this->hide("um_jun_ren_desblock");
				 }
				 if ($i==7){ 
					$this->show("um_des_jul_ren_rojo"); $this->hide("um_des_jul_ren_verde");
					$this->show("um_jul_ren_block"); $this->hide("um_jul_ren_desblock");
				 }
				 if ($i==8){ 
					$this->show("um_des_ago_ren_rojo"); $this->hide("um_des_ago_ren_verde");
					$this->show("um_ago_ren_block"); $this->hide("um_ago_ren_desblock");
				 }
				 if ($i==9){ 
					$this->show("um_des_sep_ren_rojo"); $this->hide("um_des_sep_ren_verde");
					$this->show("um_sep_ren_block"); $this->hide("um_sep_ren_desblock");
				 }
				 if ($i==10){ 
					$this->show("um_des_oct_ren_rojo"); $this->hide("um_des_oct_ren_verde");
					$this->show("um_oct_ren_block"); $this->hide("um_oct_ren_desblock");
				 }
				 if ($i==11){ 
					$this->show("um_des_nov_ren_rojo"); $this->hide("um_des_nov_ren_verde");
					$this->show("um_nov_ren_block"); $this->hide("um_nov_ren_desblock");
				 }
				 if ($i==12){ 
					$this->show("um_des_dic_ren_rojo"); $this->hide("um_des_dic_ren_verde");
					$this->show("um_dic_ren_block"); $this->hide("um_dic_ren_desblock");
				 }
			}
						
			//Para Mostrar los que se tienen que rendir
			for($i = ($_SESSION['mes_rendicion']); $i <= ($_SESSION['mes_rendicion_global']); $i+=1){
 				 if ($i==1){ 
					$this->hide("um_des_ene_ren_rojo"); $this->show("um_des_ene_ren_verde"); 
					$this->hide("um_ene_ren_block"); $this->show("um_ene_ren_desblock"); 
				 }
 				 if ($i==2){ 
					$this->hide("um_des_feb_ren_rojo"); $this->show("um_des_feb_ren_verde");
					$this->hide("um_feb_ren_block"); $this->show("um_feb_ren_desblock");
				 }
				 if ($i==3){ 
					$this->hide("um_des_mar_ren_rojo"); $this->show("um_des_mar_ren_verde");
					$this->hide("um_mar_ren_block"); $this->show("um_mar_ren_desblock");
				 }
				 if ($i==4){ 
					$this->hide("um_des_abr_ren_rojo"); $this->show("um_des_abr_ren_verde");
					$this->hide("um_abr_ren_block"); $this->show("um_abr_ren_desblock");
				 }
				 if ($i==5){ 
					$this->hide("um_des_may_ren_rojo"); $this->show("um_des_may_ren_verde");
					$this->hide("um_may_ren_block"); $this->show("um_may_ren_desblock");
				 }
				 if ($i==6){ 
					$this->hide("um_des_jun_ren_rojo"); $this->show("um_des_jun_ren_verde");
					$this->hide("um_jun_ren_block"); $this->show("um_jun_ren_desblock");
				 }
				 if ($i==7){ 
					$this->hide("um_des_jul_ren_rojo"); $this->show("um_des_jul_ren_verde");
					$this->hide("um_jul_ren_block"); $this->show("um_jul_ren_desblock");
				 }
				 if ($i==8){ 
					$this->hide("um_des_ago_ren_rojo"); $this->show("um_des_ago_ren_verde");
					$this->hide("um_ago_ren_block"); $this->show("um_ago_ren_desblock");
				 }
				 if ($i==9){ 
					$this->hide("um_des_sep_ren_rojo"); $this->show("um_des_sep_ren_verde");
					$this->hide("um_sep_ren_block"); $this->show("um_sep_ren_desblock");
				 }
				 if ($i==10){ 
					$this->hide("um_des_oct_ren_rojo"); $this->show("um_des_oct_ren_verde");
					$this->hide("um_oct_ren_block"); $this->show("um_oct_ren_desblock");
				 }
				 if ($i==11){ 
					$this->hide("um_des_nov_ren_rojo"); $this->show("um_des_nov_ren_verde");
					$this->hide("um_nov_ren_block"); $this->show("um_nov_ren_desblock");
				 }
				 if ($i==12){ 
					$this->hide("um_des_dic_ren_rojo"); $this->show("um_des_dic_ren_verde");
					$this->hide("um_dic_ren_block"); $this->show("um_dic_ren_desblock");
				 }
			}
		}else{
			//Para Mostrar los ya rendidos y esta cerrado
			for($i = 1; $i <= ($_SESSION['mes_rendicion_global']); $i+=1){
 				 if ($i==1){ 
					$this->show("um_des_ene_ren_rojo"); $this->hide("um_des_ene_ren_verde");
					$this->show("um_ene_ren_block"); $this->hide("um_ene_ren_desblock");
				 }
 				 if ($i==2){ 
					$this->show("um_des_feb_ren_rojo"); $this->hide("um_des_feb_ren_verde");
					$this->show("um_feb_ren_block"); $this->hide("um_feb_ren_desblock");
				 }
				 if ($i==3){ 
					$this->show("um_des_mar_ren_rojo"); $this->hide("um_des_mar_ren_verde");
					$this->show("um_mar_ren_block"); $this->hide("um_mar_ren_desblock");
				 }
				 if ($i==4){ 
					$this->show("um_des_abr_ren_rojo"); $this->hide("um_des_abr_ren_verde");
					$this->show("um_abr_ren_block"); $this->hide("um_abr_ren_desblock");
				 }
				 if ($i==5){ 
					$this->show("um_des_may_ren_rojo"); $this->hide("um_des_may_ren_verde");
					$this->show("um_may_ren_block"); $this->hide("um_may_ren_desblock");
				 }
				 if ($i==6){ 
					$this->show("um_des_jun_ren_rojo"); $this->hide("um_des_jun_ren_verde");
					$this->show("um_jun_ren_block"); $this->hide("um_jun_ren_desblock");
				 }
				 if ($i==7){ 
					$this->show("um_des_jul_ren_rojo"); $this->hide("um_des_jul_ren_verde");
					$this->show("um_jul_ren_block"); $this->hide("um_jul_ren_desblock");
				 }
				 if ($i==8){ 
					$this->show("um_des_ago_ren_rojo"); $this->hide("um_des_ago_ren_verde");
					$this->show("um_ago_ren_block"); $this->hide("um_ago_ren_desblock");
				 }
				 if ($i==9){ 
					$this->show("um_des_sep_ren_rojo"); $this->hide("um_des_sep_ren_verde");
					$this->show("um_sep_ren_block"); $this->hide("um_sep_ren_desblock");
				 }
				 if ($i==10){ 
					$this->show("um_des_oct_ren_rojo"); $this->hide("um_des_oct_ren_verde");
					$this->show("um_oct_ren_block"); $this->hide("um_oct_ren_desblock");
				 }
				 if ($i==11){ 
					$this->show("um_des_nov_ren_rojo"); $this->hide("um_des_nov_ren_verde");
					$this->show("um_nov_ren_block"); $this->hide("um_nov_ren_desblock");
				 }
				 if ($i==12){ 
					$this->show("um_des_dic_ren_rojo"); $this->hide("um_des_dic_ren_verde");
					$this->show("um_dic_ren_block"); $this->hide("um_dic_ren_desblock");
				 }
			}
		}
		
		//para mostrar los datos de la bd
		include('plan.objeto.class.php');
        $Obj= new clase_plan(); 
		$Obj->Clase_BuscaUm($um, $this->eje);
        $this->text("$Obj->um_id","txt_id_um:value");
        $this->text("$Obj->um_nombre","txt_des_um:value");
		$this->text("$Obj->um_nota","txt_info:value");
		$this->text("$Obj->um_ene","um_txt_ene:value");
        $this->text("$Obj->um_feb","um_txt_feb:value");
		$this->text("$Obj->um_mar","um_txt_mar:value");
        $this->text("$Obj->um_abr","um_txt_abr:value");
		$this->text("$Obj->um_may","um_txt_may:value");
        $this->text("$Obj->um_jun","um_txt_jun:value");
		$this->text("$Obj->um_jul","um_txt_jul:value");
        $this->text("$Obj->um_ago","um_txt_ago:value");
		$this->text("$Obj->um_sep","um_txt_sep:value");
        $this->text("$Obj->um_oct","um_txt_oct:value");
		$this->text("$Obj->um_nov","um_txt_nov:value");
        $this->text("$Obj->um_dic","um_txt_dic:value");
	    $this->text("$Obj->um_total","um_txt_total:value");
		$this->text("$Obj->um_ene_ren","um_txt_ene_ren2:value");
        $this->text("$Obj->um_feb_ren","um_txt_feb_ren2:value");
		$this->text("$Obj->um_mar_ren","um_txt_mar_ren2:value");
        $this->text("$Obj->um_abr_ren","um_txt_abr_ren2:value");
		$this->text("$Obj->um_may_ren","um_txt_may_ren2:value");
        $this->text("$Obj->um_jun_ren","um_txt_jun_ren2:value");
		$this->text("$Obj->um_jul_ren","um_txt_jul_ren2:value");
        $this->text("$Obj->um_ago_ren","um_txt_ago_ren2:value");
		$this->text("$Obj->um_sep_ren","um_txt_sep_ren2:value");
        $this->text("$Obj->um_oct_ren","um_txt_oct_ren2:value");
		$this->text("$Obj->um_nov_ren","um_txt_nov_ren2:value");
        $this->text("$Obj->um_dic_ren","um_txt_dic_ren2:value");
		$this->text("$Obj->um_ene_ren","um_txt_ene_ren:value");
        $this->text("$Obj->um_feb_ren","um_txt_feb_ren:value");
		$this->text("$Obj->um_mar_ren","um_txt_mar_ren:value");
        $this->text("$Obj->um_abr_ren","um_txt_abr_ren:value");
		$this->text("$Obj->um_may_ren","um_txt_may_ren:value");
        $this->text("$Obj->um_jun_ren","um_txt_jun_ren:value");
		$this->text("$Obj->um_jul_ren","um_txt_jul_ren:value");
        $this->text("$Obj->um_ago_ren","um_txt_ago_ren:value");
		$this->text("$Obj->um_sep_ren","um_txt_sep_ren:value");
        $this->text("$Obj->um_oct_ren","um_txt_oct_ren:value");
		$this->text("$Obj->um_nov_ren","um_txt_nov_ren:value");
        $this->text("$Obj->um_dic_ren","um_txt_dic_ren:value");
	    $this->text("$Obj->um_total_ren","um_txt_total_ren:value");
		
		if ($Obj->um_nota!="") $this->show("info_um"); else $this->hide("info_um");
				
		$this->show("p3");
		$this->show("p3-rendicion");
    }
	
	function GuardarUM($pry, $ae, $eje, $um, $um_nombre, $um_ene, $um_feb, $um_mar, $um_abr, $um_may, $um_jun, $um_jul, $um_ago, $um_sep, $um_oct, $um_nov, $um_dic) 
    {	
        include('plan.objeto.class.php');
        $Obj= new clase_plan(); 
		$Obj->setpry($pry);
		$Obj->setae($ae);
		$Obj->seteje($eje);
		$Obj->setum_id($um);
		$Obj->setum_nombre($um_nombre);
        $Obj->setmeses($um_ene, $um_feb, $um_mar, $um_abr, $um_may, $um_jun, $um_jul, $um_ago, $um_sep, $um_oct, $um_nov, $um_dic);
		$mensaje=$Obj->Clase_GuardarUm();
        $this->js("alert('". $mensaje[1] ."')");
		if ($mensaje[2]){ 
			$this->CancelarUm();
			$this->MuestraRendicionAE($pry, $ae, $eje);
        	return $this->GridUM($ae, $eje);
		}
    }
	
	function CancelarUm() 
    {		
		$this->hide("p3");
		$this->hide("p3-rendicion");
	}
	
	
	
	//*********************************************************
	//FUNCIONES PARA EL TRABAJO CON LO DE LAS ACCIONES INTERNAS
	//*********************************************************
	function LimpiaAi()
	{	
		$this->hide("p6");
		$this->hide("p7");
		$this->hide("p7-rendicion");
	}
	
	function Ai_Filtra()
	{
		$this->js('lisai_um_acc()');

		$this->show("b_ver_ai");
		$this->hide("b_no_ver_ai");
		$this->hide("p5");
		$this->show("p6");
		$this->hide("p7");
	}
	
	function ListAi($pry, $ae, $eje)
	{
		include_once(PATH.'/gui/ObjetoListBox.class.php');
		$lb = new ListBoxObj();
		$lb->setquery(	"SELECT
							safor_ai.id_ai, 
							LEFT(safor_ai.descripcion,50)
						FROM safor_ai
						WHERE ((safor_ai.id_pry=".$pry.") AND
							   (safor_ai.id_ae=".$ae.") AND
							   (safor_ai.id_eje=".$eje."))
						ORDER BY safor_ai.id_ai");
		$lb->setnombre_listbox('txtai_id');
		$lb->setvalor_inicial(array('0',''));
		$lb->setajax_event('onchange');
		$lb->setajax_div('ais');
		$lb->setajax_file_root(PATH."/modulos/formulacion/plan.funciones.php");
		$lb->setajax_class_name("plan_funciones");
		$lb->setajax_parametro_function(0);
		$lb->setajax_function_on_event('Ai_Filtra');
		$lb->GENERA_LISTBOX(0,'',TRUE);			
	}
	
	function GridAi($pry, $ae, $eje) 
    {
		$this->show("p5");
		$this->hide("b_ver_ai");
		$this->show("b_no_ver_ai");
        include_once(PATH.'/gui/ObjetoGrid.class.php');
        $gr = new GridOj();
        $sql="SELECT 
					safor_ai.id_ai, 
					LEFT(safor_ai.descripcion,100),
					IF(safor_ai.rindio=1,'SI','NO') AS Status
				FROM safor_ai
				WHERE ((safor_ai.id_pry=".$pry.") AND 
					  (safor_ai.id_ae=".$ae.") AND 
				   	  (safor_ai.id_eje=".$eje."))	
				ORDER BY safor_ai.id_ai";
        $gr->setquery($sql);
        $gr->settipo_scroll("scroll_grande");
        $gr->setalias_columnas(array('Id', 'Descripcion', 'Rendido'));
        $gr->setnombre("GridAi");
        $gr->setajax_file_root(PATH."/modulos/formulacion/plan.funciones.php");
		$gr->setajax_class_name("plan_funciones");
        $gr->setajax_div("ai_unidad");
        $gr->setccs_class_grid("grid");
        $gr->setpaginador(10);
        return $gr->GENERA_GRID(true,true,true);
    }
	
	function CancelarAi() 
    {	
		$this->hide("p5");
		$this->show("b_ver_ai");
		$this->hide("b_no_ver_ai");
	}
	
	//*******************************************************************
	//FUNCIONES PARA EL TRABAJO CON LO DE LAS UNIDADES DE MEDIDA DE LA AI
	//*******************************************************************
	function GridUM_Ai($ai, $eje) 
    {
		$this->hide('p5'); //para ocultar cada vez que de doy a la unidad de medida
		
        include_once(PATH.'/gui/ObjetoGrid.class.php');
        $gr = new GridOj();
        $sql="SELECT 
					safor_pry_ae_ai_eje_um.id_um, 
					Left(safor_pry_ae_ai_eje_um.descripcion,50),
					FORMAT((ene_ren+feb_ren+mar_ren),0) AS trim1, 
					FORMAT((abr_ren+may_ren+jun_ren),0) AS trim2, 
					FORMAT((jul_ren+ago_ren+sep_ren),0) AS trim3, 
					FORMAT((oct_ren+nov_ren+dic_ren),0) AS trim4,
					FORMAT(safor_pry_ae_ai_eje_um.total_ren,0), 
					IF(safor_pry_ae_ai_eje_um.rindio=1,'SI','NO') AS Status
				FROM safor_pry_ae_ai_eje_um
				WHERE ((safor_pry_ae_ai_eje_um.id_ai=".$ai.") AND 
				   	  (safor_pry_ae_ai_eje_um.id_eje=".$eje."))
				ORDER BY safor_pry_ae_ai_eje_um.id_um";
        $gr->setquery($sql);
        $gr->settipo_scroll('scroll_grande');
        $gr->setalias_columnas(array('Id', 'Descripcion', 'Trim 1', 'Trim 2' , 'Trim 3', 'Trim 4', 'Total','Rendido'));
        $gr->setnombre("GridUM_Ai");
        $gr->setajax_file_root(PATH."/modulos/formulacion/plan.funciones.php");
		$gr->setajax_class_name("plan_funciones");
		$gr->setajax_parametro_editar(0);
		$gr->setajax_funcion_editar("Llenar_UM_Ai");				
        $gr->setajax_div("um_ai");
        $gr->setccs_class_grid("grid");
        $gr->setpaginador(10);
        return $gr->GENERA_GRID(true,true,true);
    }
	
	function Llenar_UM_Ai($um) 
    {
		$this->eje = $_SESSION['seniat_users_eje_temp_sigme'];

		//para mostrar solo los meses que se quieren rendir
		if (($_SESSION['mes_rendicion'])>($_SESSION['mes_rendicion_global']) or ($_SESSION['seniat_users_cerrado_plan_sigme'])) 
		{
			$this->hide("b_guardar_um_ai");
		}else{
			$this->show("b_guardar_um_ai");
		}		
		
		$this->hide("um_ai_des_ene_ren_rojo"); $this->hide("um_ai_des_ene_ren_verde"); 
 		$this->hide("um_ai_des_feb_ren_rojo"); $this->hide("um_ai_des_feb_ren_verde"); 
		$this->hide("um_ai_des_mar_ren_rojo"); $this->hide("um_ai_des_mar_ren_verde"); 
		$this->hide("um_ai_des_abr_ren_rojo"); $this->hide("um_ai_des_abr_ren_verde"); 
		$this->hide("um_ai_des_may_ren_rojo"); $this->hide("um_ai_des_may_ren_verde"); 	
		$this->hide("um_ai_des_jun_ren_rojo"); $this->hide("um_ai_des_jun_ren_verde"); 
		$this->hide("um_ai_des_jul_ren_rojo"); $this->hide("um_ai_des_jul_ren_verde"); 
		$this->hide("um_ai_des_ago_ren_rojo"); $this->hide("um_ai_des_ago_ren_verde"); 
		$this->hide("um_ai_des_sep_ren_rojo"); $this->hide("um_ai_des_sep_ren_verde"); 
		$this->hide("um_ai_des_oct_ren_rojo"); $this->hide("um_ai_des_oct_ren_verde"); 
		$this->hide("um_ai_des_nov_ren_rojo"); $this->hide("um_ai_des_nov_ren_verde"); 
		$this->hide("um_ai_des_dic_ren_rojo"); $this->hide("um_ai_des_dic_ren_verde"); 
		
		$this->hide("um_ai_ene_ren_block"); $this->hide("um_ai_ene_ren_desblock"); 
		$this->hide("um_ai_feb_ren_block"); $this->hide("um_ai_feb_ren_desblock"); 
		$this->hide("um_ai_mar_ren_block"); $this->hide("um_ai_mar_ren_desblock"); 
		$this->hide("um_ai_abr_ren_block"); $this->hide("um_ai_abr_ren_desblock"); 
		$this->hide("um_ai_may_ren_block"); $this->hide("um_ai_may_ren_desblock"); 
		$this->hide("um_ai_jun_ren_block"); $this->hide("um_ai_jun_ren_desblock"); 
		$this->hide("um_ai_jul_ren_block"); $this->hide("um_ai_jul_ren_desblock"); 
		$this->hide("um_ai_ago_ren_block"); $this->hide("um_ai_ago_ren_desblock"); 
		$this->hide("um_ai_sep_ren_block"); $this->hide("um_ai_sep_ren_desblock"); 
		$this->hide("um_ai_oct_ren_block"); $this->hide("um_ai_oct_ren_desblock"); 
		$this->hide("um_ai_nov_ren_block"); $this->hide("um_ai_nov_ren_desblock"); 
		$this->hide("um_ai_dic_ren_block"); $this->hide("um_ai_dic_ren_desblock"); 
		
		if ((($_SESSION['mes_rendicion'])/($_SESSION['mes_rendicion_global']))<=1){
			//Para Mostrar los ya rendidos
			for($i = 0; $i < ($_SESSION['mes_rendicion']); $i+=1){
				 if ($i==1){ 
					$this->show("um_ai_des_ene_ren_rojo"); $this->hide("um_ai_des_ene_ren_verde");
					$this->show("um_ai_ene_ren_block"); $this->hide("um_ai_ene_ren_desblock");
				 }
 				 if ($i==2){ 
					$this->show("um_ai_des_feb_ren_rojo"); $this->hide("um_ai_des_feb_ren_verde");
					$this->show("um_ai_feb_ren_block"); $this->hide("um_ai_feb_ren_desblock");
				 }
				 if ($i==3){ 
					$this->show("um_ai_des_mar_ren_rojo"); $this->hide("um_ai_des_mar_ren_verde");
					$this->show("um_ai_mar_ren_block"); $this->hide("um_ai_mar_ren_desblock");
				 }
				 if ($i==4){ 
					$this->show("um_ai_des_abr_ren_rojo"); $this->hide("um_ai_des_abr_ren_verde");
					$this->show("um_ai_abr_ren_block"); $this->hide("um_ai_abr_ren_desblock");
				 }
				 if ($i==5){ 
					$this->show("um_ai_des_may_ren_rojo"); $this->hide("um_ai_des_may_ren_verde");
					$this->show("um_ai_may_ren_block"); $this->hide("um_ai_may_ren_desblock");
				 }
				 if ($i==6){ 
					$this->show("um_ai_des_jun_ren_rojo"); $this->hide("um_ai_des_jun_ren_verde");
					$this->show("um_ai_jun_ren_block"); $this->hide("um_ai_jun_ren_desblock");
				 }
				 if ($i==7){ 
					$this->show("um_ai_des_jul_ren_rojo"); $this->hide("um_ai_des_jul_ren_verde");
					$this->show("um_ai_jul_ren_block"); $this->hide("um_ai_jul_ren_desblock");
				 }
				 if ($i==8){ 
					$this->show("um_ai_des_ago_ren_rojo"); $this->hide("um_ai_des_ago_ren_verde");
					$this->show("um_ai_ago_ren_block"); $this->hide("um_ai_ago_ren_desblock");
				 }
				 if ($i==9){ 
					$this->show("um_ai_des_sep_ren_rojo"); $this->hide("um_ai_des_sep_ren_verde");
					$this->show("um_ai_sep_ren_block"); $this->hide("um_ai_sep_ren_desblock");
				 }
				 if ($i==10){ 
					$this->show("um_ai_des_oct_ren_rojo"); $this->hide("um_ai_des_oct_ren_verde");
					$this->show("um_ai_oct_ren_block"); $this->hide("um_ai_oct_ren_desblock");
				 }
				 if ($i==11){ 
					$this->show("um_ai_des_nov_ren_rojo"); $this->hide("um_ai_des_nov_ren_verde");
					$this->show("um_ai_nov_ren_block"); $this->hide("um_ai_nov_ren_desblock");
				 }
				 if ($i==12){ 
					$this->show("um_ai_des_dic_ren_rojo"); $this->hide("um_ai_des_dic_ren_verde");
					$this->show("um_ai_dic_ren_block"); $this->hide("um_ai_dic_ren_desblock");
				 }
			}
						
			//Para Mostrar los que se tienen que rendir
			for($i = ($_SESSION['mes_rendicion']); $i <= ($_SESSION['mes_rendicion_global']); $i+=1){
 				 if ($i==1){ 
					$this->hide("um_ai_des_ene_ren_rojo"); $this->show("um_ai_des_ene_ren_verde"); 
					$this->hide("um_ai_ene_ren_block"); $this->show("um_ai_ene_ren_desblock"); 
				 }
 				 if ($i==2){ 
					$this->hide("um_ai_des_feb_ren_rojo"); $this->show("um_ai_des_feb_ren_verde");
					$this->hide("um_ai_feb_ren_block"); $this->show("um_ai_feb_ren_desblock");
				 }
				 if ($i==3){ 
					$this->hide("um_ai_des_mar_ren_rojo"); $this->show("um_ai_des_mar_ren_verde");
					$this->hide("um_ai_mar_ren_block"); $this->show("um_ai_mar_ren_desblock");
				 }
				 if ($i==4){ 
					$this->hide("um_ai_des_abr_ren_rojo"); $this->show("um_ai_des_abr_ren_verde");
					$this->hide("um_ai_abr_ren_block"); $this->show("um_ai_abr_ren_desblock");
				 }
				 if ($i==5){ 
					$this->hide("um_ai_des_may_ren_rojo"); $this->show("um_ai_des_may_ren_verde");
					$this->hide("um_ai_may_ren_block"); $this->show("um_ai_may_ren_desblock");
				 }
				 if ($i==6){ 
					$this->hide("um_ai_des_jun_ren_rojo"); $this->show("um_ai_des_jun_ren_verde");
					$this->hide("um_ai_jun_ren_block"); $this->show("um_ai_jun_ren_desblock");
				 }
				 if ($i==7){ 
					$this->hide("um_ai_des_jul_ren_rojo"); $this->show("um_ai_des_jul_ren_verde");
					$this->hide("um_ai_jul_ren_block"); $this->show("um_ai_jul_ren_desblock");
				 }
				 if ($i==8){ 
					$this->hide("um_ai_des_ago_ren_rojo"); $this->show("um_ai_des_ago_ren_verde");
					$this->hide("um_ai_ago_ren_block"); $this->show("um_ai_ago_ren_desblock");
				 }
				 if ($i==9){ 
					$this->hide("um_ai_des_sep_ren_rojo"); $this->show("um_ai_des_sep_ren_verde");
					$this->hide("um_ai_sep_ren_block"); $this->show("um_ai_sep_ren_desblock");
				 }
				 if ($i==10){ 
					$this->hide("um_ai_des_oct_ren_rojo"); $this->show("um_ai_des_oct_ren_verde");
					$this->hide("um_ai_oct_ren_block"); $this->show("um_ai_oct_ren_desblock");
				 }
				 if ($i==11){ 
					$this->hide("um_ai_des_nov_ren_rojo"); $this->show("um_ai_des_nov_ren_verde");
					$this->hide("um_ai_nov_ren_block"); $this->show("um_ai_nov_ren_desblock");
				 }
				 if ($i==12){ 
					$this->hide("um_ai_des_dic_ren_rojo"); $this->show("um_ai_des_dic_ren_verde");
					$this->hide("um_ai_dic_ren_block"); $this->show("um_ai_dic_ren_desblock");
				 }
			}
		}else{
			//Para Mostrar los ya rendidos y esta cerrado
			for($i = 1; $i <= ($_SESSION['mes_rendicion_global']); $i+=1){
 				 if ($i==1){ 
					$this->show("um_ai_des_ene_ren_rojo"); $this->hide("um_ai_des_ene_ren_verde");
					$this->show("um_ai_ene_ren_block"); $this->hide("um_ai_ene_ren_desblock");
				 }
 				 if ($i==2){ 
					$this->show("um_ai_des_feb_ren_rojo"); $this->hide("um_ai_des_feb_ren_verde");
					$this->show("um_ai_feb_ren_block"); $this->hide("um_ai_feb_ren_desblock");
				 }
				 if ($i==3){ 
					$this->show("um_ai_des_mar_ren_rojo"); $this->hide("um_ai_des_mar_ren_verde");
					$this->show("um_ai_mar_ren_block"); $this->hide("um_ai_mar_ren_desblock");
				 }
				 if ($i==4){ 
					$this->show("um_ai_des_abr_ren_rojo"); $this->hide("um_ai_des_abr_ren_verde");
					$this->show("um_ai_abr_ren_block"); $this->hide("um_ai_abr_ren_desblock");
				 }
				 if ($i==5){ 
					$this->show("um_ai_des_may_ren_rojo"); $this->hide("um_ai_des_may_ren_verde");
					$this->show("um_ai_may_ren_block"); $this->hide("um_ai_may_ren_desblock");
				 }
				 if ($i==6){ 
					$this->show("um_ai_des_jun_ren_rojo"); $this->hide("um_ai_des_jun_ren_verde");
					$this->show("um_ai_jun_ren_block"); $this->hide("um_ai_jun_ren_desblock");
				 }
				 if ($i==7){ 
					$this->show("um_ai_des_jul_ren_rojo"); $this->hide("um_ai_des_jul_ren_verde");
					$this->show("um_ai_jul_ren_block"); $this->hide("um_ai_jul_ren_desblock");
				 }
				 if ($i==8){ 
					$this->show("um_ai_des_ago_ren_rojo"); $this->hide("um_ai_des_ago_ren_verde");
					$this->show("um_ai_ago_ren_block"); $this->hide("um_ai_ago_ren_desblock");
				 }
				 if ($i==9){ 
					$this->show("um_ai_des_sep_ren_rojo"); $this->hide("um_ai_des_sep_ren_verde");
					$this->show("um_ai_sep_ren_block"); $this->hide("um_ai_sep_ren_desblock");
				 }
				 if ($i==10){ 
					$this->show("um_ai_des_oct_ren_rojo"); $this->hide("um_ai_des_oct_ren_verde");
					$this->show("um_ai_oct_ren_block"); $this->hide("um_ai_oct_ren_desblock");
				 }
				 if ($i==11){ 
					$this->show("um_ai_des_nov_ren_rojo"); $this->hide("um_ai_des_nov_ren_verde");
					$this->show("um_ai_nov_ren_block"); $this->hide("um_ai_nov_ren_desblock");
				 }
				 if ($i==12){ 
					$this->show("um_ai_des_dic_ren_rojo"); $this->hide("um_ai_des_dic_ren_verde");
					$this->show("um_ai_dic_ren_block"); $this->hide("um_ai_dic_ren_desblock");
				 }
			}
		}
		
		include('plan.objeto.class.php');
        $Obj= new clase_plan(); 
		$Obj->Clase_BuscaUm_Ai($um, $this->eje);
        $this->text("$Obj->um_id","txt_id_um_ai:value");
        $this->text("$Obj->um_nombre","txt_des_um_ai:value");
		$this->text("$Obj->um_ene","um_ai_txt_ene:value");
        $this->text("$Obj->um_feb","um_ai_txt_feb:value");
		$this->text("$Obj->um_mar","um_ai_txt_mar:value");
        $this->text("$Obj->um_abr","um_ai_txt_abr:value");
		$this->text("$Obj->um_may","um_ai_txt_may:value");
        $this->text("$Obj->um_jun","um_ai_txt_jun:value");
		$this->text("$Obj->um_jul","um_ai_txt_jul:value");
        $this->text("$Obj->um_ago","um_ai_txt_ago:value");
		$this->text("$Obj->um_sep","um_ai_txt_sep:value");
        $this->text("$Obj->um_oct","um_ai_txt_oct:value");
		$this->text("$Obj->um_nov","um_ai_txt_nov:value");
        $this->text("$Obj->um_dic","um_ai_txt_dic:value");
	    $this->text("$Obj->um_total","um_ai_txt_total:value");
		$this->text("$Obj->um_ene_ren","um_ai_txt_ene_ren2:value");
        $this->text("$Obj->um_feb_ren","um_ai_txt_feb_ren2:value");
		$this->text("$Obj->um_mar_ren","um_ai_txt_mar_ren2:value");
        $this->text("$Obj->um_abr_ren","um_ai_txt_abr_ren2:value");
		$this->text("$Obj->um_may_ren","um_ai_txt_may_ren2:value");
        $this->text("$Obj->um_jun_ren","um_ai_txt_jun_ren2:value");
		$this->text("$Obj->um_jul_ren","um_ai_txt_jul_ren2:value");
        $this->text("$Obj->um_ago_ren","um_ai_txt_ago_ren2:value");
		$this->text("$Obj->um_sep_ren","um_ai_txt_sep_ren2:value");
        $this->text("$Obj->um_oct_ren","um_ai_txt_oct_ren2:value");
		$this->text("$Obj->um_nov_ren","um_ai_txt_nov_ren2:value");
        $this->text("$Obj->um_dic_ren","um_ai_txt_dic_ren2:value");
		$this->text("$Obj->um_ene_ren","um_ai_txt_ene_ren:value");
        $this->text("$Obj->um_feb_ren","um_ai_txt_feb_ren:value");
		$this->text("$Obj->um_mar_ren","um_ai_txt_mar_ren:value");
        $this->text("$Obj->um_abr_ren","um_ai_txt_abr_ren:value");
		$this->text("$Obj->um_may_ren","um_ai_txt_may_ren:value");
        $this->text("$Obj->um_jun_ren","um_ai_txt_jun_ren:value");
		$this->text("$Obj->um_jul_ren","um_ai_txt_jul_ren:value");
        $this->text("$Obj->um_ago_ren","um_ai_txt_ago_ren:value");
		$this->text("$Obj->um_sep_ren","um_ai_txt_sep_ren:value");
        $this->text("$Obj->um_oct_ren","um_ai_txt_oct_ren:value");
		$this->text("$Obj->um_nov_ren","um_ai_txt_nov_ren:value");
        $this->text("$Obj->um_dic_ren","um_ai_txt_dic_ren:value");
	    $this->text("$Obj->um_total_ren","um_ai_txt_total_ren:value");
		
		$this->show("p7");
		$this->show("p7-rendicion");
    }
	
	function GuardarUM_Ai($pry, $ae, $eje, $ai, $um, $um_nombre, $um_ene, $um_feb, $um_mar, $um_abr, $um_may, $um_jun, $um_jul, $um_ago, $um_sep, $um_oct, $um_nov, $um_dic) 
    {	
        include('plan.objeto.class.php');
        $Obj= new clase_plan(); 
		$Obj->setpry($pry);
		$Obj->setae($ae);
		$Obj->setai($ai);
		$Obj->seteje($eje);
		$Obj->setum_id($um);
		$Obj->setum_nombre($um_nombre);
        $Obj->setmeses($um_ene, $um_feb, $um_mar, $um_abr, $um_may, $um_jun, $um_jul, $um_ago, $um_sep, $um_oct, $um_nov, $um_dic);
		$mensaje=$Obj->Clase_GuardarUm_Ai();
        $this->js("alert('". $mensaje[1] ."')");
		if ($mensaje[2]){
			$this->CancelarUm_Ai();
			$this->MuestraRendicionAE($pry, $ae, $eje);
	        return $this->GridUM_Ai($ai, $eje);
		}
    }
	
	function CancelarUm_Ai() 
    {		
		$this->hide("p7");
		$this->hide("p7-rendicion");
	}
	
	function RendirEje($eje) 
    {		
		include('plan.objeto.class.php');
        $Obj= new clase_plan(); 
		$Obj->seteje($eje);
		$mensaje=$Obj->Clase_RendirEje();
        $this->js("alert('". $mensaje[1] ."')");
		if ($mensaje[2]){
	        return $this->MuestraRendicion($eje);
		}
	}
}
?>