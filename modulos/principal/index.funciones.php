<?php
/*
======================================
FUNCTIONS Index
======================================
*/
include_once("../../includes/configuracion.php");
include_once(PATH."/includes/capa_datos.php");

class index_funciones extends saja
{	
	function Grid_Eje() 
    {
		include_once(PATH.'/gui/ObjetoGrid.class.php');
        $gr = new GridOj();
        $sql="SELECT 
					seniat_users_eje.seniat_users_eje, 
					safor_eje.descripcion, 
					IF(safor_eje.mes_rendicion>safor_eje.mes_rendicion_global,'SI','NO') AS Status
					FROM safor_eje INNER JOIN seniat_users_eje ON safor_eje.id_eje = seniat_users_eje.seniat_users_eje
					WHERE (((seniat_users_eje.seniat_users_id)='".$_SESSION['seniat_users_id_sigme']."'))
					ORDER BY seniat_users_eje.seniat_users_eje";
        $gr->setquery($sql);
        $gr->settipo_scroll("scroll_grande");
        $gr->setalias_columnas(array('Id', 'Descripcion', 'Rendido'));
        $gr->setnombre("ejes");
        $gr->setajax_file_root(PATH."/modulos/formulacion/index.funciones.php");
		$gr->setajax_class_name("index_funciones");
        $gr->setajax_div("eje");
        $gr->setccs_class_grid("grid");
        $gr->setpaginador(5);
        return $gr->GENERA_GRID(true,true,true);
    }
}
?>