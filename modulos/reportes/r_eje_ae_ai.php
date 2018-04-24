<?php
ob_start();
session_start();
include_once("../../includes/configuracion.php");
include_once("../../includes/capa_datos.php");
include_once("../../clases/pdf/fpdf.php");

class PDF extends FPDF
{
	
	function Header()
	{		
		$this->SetTextColor(0,0,0);	
		
		$this->Image('../../images/logo.JPG',1,1,33);
    	$this->SetFont('Arial','B',12);
		$this->SetY(16);$this->SetX(90);$this->SetFillColor(255,255,255);$this->Cell(100,3,'DISTRIBUCIÓN MENSUAL DE METAS FÍSICAS AÑO 2011',0,0,'C',1);
	
		
		$this->SetFillColor(232,232,232);
		$this->SetFont('Arial','B',9);
		$this->SetY(30);$this->SetX(1);$this->Cell(100,3,'Acción Específica / Unidad de Medida ',0,0,'L',1);
		$this->SetY(30);$this->SetX(100);$this->Cell(173,3,'Meta Planificada (MP) / Meta Ejecutada (ME) = Porcentaje de Ejecución',0,0,'L',1);
		$this->SetY(33);$this->SetX(1);$this->Cell(272,3,'			Acción Intermedia / Unidad de Medida ',0,0,'L',1);
		
		$this->SetY(36);$this->SetX(18);$this->Cell(100,3,'Descripción',0,0,'L',1);
		$this->SetY(36);$this->SetX(42);$this->Cell(20,3,'Ene.',0,0,'L',1);
		$this->SetY(36);$this->SetX(60);$this->Cell(20,3,'Feb.',0,0,'L',1);
		$this->SetY(36);$this->SetX(81);$this->Cell(20,3,'Mar.',0,0,'L',1);
		$this->SetY(36);$this->SetX(100);$this->Cell(20,3,'Abr.',0,0,'L',1);
		$this->SetY(36);$this->SetX(117);$this->Cell(20,3,'May.',0,0,'L',1);
		$this->SetY(36);$this->SetX(134);$this->Cell(20,3,'Jun.',0,0,'L',1);
		$this->SetY(36);$this->SetX(153);$this->Cell(20,3,'Jul.',0,0,'L',1);
		$this->SetY(36);$this->SetX(170);$this->Cell(20,3,'Ago.',0,0,'L',1);
		$this->SetY(36);$this->SetX(188);$this->Cell(20,3,'Sep.',0,0,'L',1);
		$this->SetY(36);$this->SetX(208);$this->Cell(20,3,'Oct.',0,0,'L',1);
		$this->SetY(36);$this->SetX(225);$this->Cell(20,3,'Nov.',0,0,'L',1);
		$this->SetY(36);$this->SetX(244);$this->Cell(20,3,'Dic.',0,0,'L',1);
		$this->SetY(36);$this->SetX(263);$this->Cell(10,3,'Total',0,0,'L',1);
		
	}
	function Footer()
	{
		//COLOCAMOS LA FECHA EN ESPAÑOL
		// Obtenemos y traducimos el nombre del día
		$dia=date("l");
		if ($dia=="Monday") $dia="Lunes";
		if ($dia=="Tuesday") $dia="Martes";
		if ($dia=="Wednesday") $dia="Miércoles";
		if ($dia=="Thursday") $dia="Jueves";
		if ($dia=="Friday") $dia="Viernes";
		if ($dia=="Saturday") $dia="Sabado";
		if ($dia=="Sunday") $dia="Domingo";
 
		// Obtenemos el número del día
		$dia2=date("d");
 
		// Obtenemos y traducimos el nombre del mes
		$mes=date("F");
		if ($mes=="January") $mes="Enero";
		if ($mes=="February") $mes="Febrero";
		if ($mes=="March") $mes="Marzo";
		if ($mes=="April") $mes="Abril";
		if ($mes=="May") $mes="Mayo";
		if ($mes=="June") $mes="Junio";
		if ($mes=="July") $mes="Julio";
		if ($mes=="August") $mes="Agosto";
		if ($mes=="September") $mes="Setiembre";
		if ($mes=="October") $mes="Octubre";
		if ($mes=="November") $mes="Noviembre";
		if ($mes=="December") $mes="Diciembre";
		$ano=date("Y");
		$fecha= "$dia, $dia2 de $mes de $ano";
   		
		
		$this->SetTextColor(0,0,180);
 	    $this->SetFont('Arial','I',8);	
		$this->SetY(-15);
 	    $this->Cell(0,10,'Páginas '.$this->PageNo().'/{nb}',0,0,'C');
		
                
		$this->SetY(208);
		$this->Cell(0,10,$fecha);
		$this->SetX(100);$this->Cell(0,10,'Ejecución del Plan 2011 - Oficina de Planificación y Presupuesto');
	}
}
	$eje=base64_decode($_GET['eje']); // para el ejecutor
	
	$pdf=new PDF('L','mm','letter');
	$pdf->AliasNbPages();

	$pdf->AddPage();
	$pdf->SetFont('Arial','',8);
	
	$Y_Fields_Name_position = 20;
	
		$db=DB_CONECCION();
		$SQL = ("SELECT safor_eje.descripcion
				FROM safor_eje
				WHERE (safor_eje.id_eje=".$eje.")");
		$grupo_eje = $db->Execute($SQL) or die("Error consultando el ejecutor");
		if (!$grupo_eje ->EOF)
		{
			$pdf->SetFont('Arial','B',10);
			$pdf->SetY(26);$pdf->SetX(1);$pdf->Cell(40,3,'Unidad Ejecutora: '.$grupo_eje ->fields['descripcion'],0,0,'L');
			
			$SQL = ("SELECT safor_pry_ae_eje_um.id_ae, 
							safor_ae.descripcion
					FROM safor_ae INNER JOIN safor_pry_ae_eje_um ON safor_ae.id_ae = safor_pry_ae_eje_um.id_ae
					WHERE (safor_ae.id_eje=".$eje.") AND (safor_ae.poa=TRUE)
					GROUP BY safor_pry_ae_eje_um.id_ae, safor_ae.descripcion");

			$grupo_ae = $db->Execute($SQL) or die("Error consultando la accion especifica");			
			
			$pdf->SetY(40);
			while(!$grupo_ae ->EOF)
			{
			$pdf->SetFont('Arial','B',7);
			$pdf->SetX(1);
			$pdf->Cell(10,10,$grupo_ae ->fields['id_ae']." - ".$grupo_ae ->fields['descripcion'],0,0,'L');
			$pdf->Ln(); 
			
			$SQL = ("SELECT safor_pry_ae_eje_um.id_um,
							safor_pry_ae_eje_um.descripcion AS descrip,
							safor_pry_ae_eje_um.total,safor_pry_ae_eje_um.total_ren,(safor_pry_ae_eje_um.total_ren*100)/safor_pry_ae_eje_um.total as por_total,
							safor_pry_ae_eje_um.ene,safor_pry_ae_eje_um.ene_ren,(safor_pry_ae_eje_um.ene_ren*100)/safor_pry_ae_eje_um.ene as por_ene,
							safor_pry_ae_eje_um.feb,safor_pry_ae_eje_um.feb_ren,(safor_pry_ae_eje_um.feb_ren*100)/safor_pry_ae_eje_um.feb as por_feb,
							safor_pry_ae_eje_um.mar,safor_pry_ae_eje_um.mar_ren,(safor_pry_ae_eje_um.mar_ren*100)/safor_pry_ae_eje_um.mar as por_mar,
							safor_pry_ae_eje_um.abr,safor_pry_ae_eje_um.abr_ren,(safor_pry_ae_eje_um.abr_ren*100)/safor_pry_ae_eje_um.abr as por_abr,
							safor_pry_ae_eje_um.may,safor_pry_ae_eje_um.may_ren,(safor_pry_ae_eje_um.may_ren*100)/safor_pry_ae_eje_um.may as por_may,
							safor_pry_ae_eje_um.jun,safor_pry_ae_eje_um.jun_ren,(safor_pry_ae_eje_um.jun_ren*100)/safor_pry_ae_eje_um.jun as por_jun,
							safor_pry_ae_eje_um.jul,safor_pry_ae_eje_um.jul_ren,(safor_pry_ae_eje_um.jul_ren*100)/safor_pry_ae_eje_um.jul as por_jul,
							safor_pry_ae_eje_um.ago,safor_pry_ae_eje_um.ago_ren,(safor_pry_ae_eje_um.ago_ren*100)/safor_pry_ae_eje_um.ago as por_ago,
							safor_pry_ae_eje_um.sep,safor_pry_ae_eje_um.sep_ren,(safor_pry_ae_eje_um.sep_ren*100)/safor_pry_ae_eje_um.sep as por_sep,
							safor_pry_ae_eje_um.oct,safor_pry_ae_eje_um.oct_ren,(safor_pry_ae_eje_um.oct_ren*100)/safor_pry_ae_eje_um.oct as por_oct,
							safor_pry_ae_eje_um.nov,safor_pry_ae_eje_um.nov_ren,(safor_pry_ae_eje_um.nov_ren*100)/safor_pry_ae_eje_um.nov as por_nov,
							safor_pry_ae_eje_um.dic,safor_pry_ae_eje_um.dic_ren,(safor_pry_ae_eje_um.dic_ren*100)/safor_pry_ae_eje_um.dic as por_dic
				FROM safor_ae INNER JOIN safor_pry_ae_eje_um ON (safor_ae.id_eje = safor_pry_ae_eje_um.id_eje) AND (safor_ae.id_ae = safor_pry_ae_eje_um.id_ae)

					WHERE ((safor_ae.id_ae=".$grupo_ae->fields['id_ae'].") AND 
						   (safor_pry_ae_eje_um.id_eje=".$eje.") AND
						   (safor_ae.id_eje=".$eje."))");
					
					$grupo_part = $db->Execute($SQL) or die("Error consultando unidad de medida");
		
				
				while(!$grupo_part->EOF)
				{	
					$pdf->SetFont('Arial','',6);
					$pdf->SetX(3);$pdf->Cell(10,5,$grupo_part->fields['descrip'],'C');
					$pdf->Ln(); 
					$pdf->SetX(40);$pdf->Cell(5,5,number_format($grupo_part->fields['ene'],0,',','.'),0,0,'R');$pdf->Cell(1,5,'/');$pdf->Cell(5,5,number_format($grupo_part->fields['ene_ren'],0,',','.'),0,0,'R');
					$pdf->SetX(58);$pdf->Cell(5,5,number_format($grupo_part->fields['feb'],0,',','.'),0,0,'R');$pdf->Cell(1,5,'/');$pdf->Cell(5,5,number_format($grupo_part->fields['feb_ren'],0,',','.'),0,0,'R');
					$pdf->SetX(79);$pdf->Cell(5,5,number_format($grupo_part->fields['mar'],0,',','.'),0,0,'R');$pdf->Cell(1,5,'/');$pdf->Cell(5,5,number_format($grupo_part->fields['mar_ren'],0,',','.'),0,0,'R');
					$pdf->SetX(98);$pdf->Cell(5,5,number_format($grupo_part->fields['abr'],0,',','.'),0,0,'R');$pdf->Cell(1,5,'/');$pdf->Cell(5,5,number_format($grupo_part->fields['abr_ren'],0,',','.'),0,0,'R');
					$pdf->SetX(115);$pdf->Cell(5,5,number_format($grupo_part->fields['may'],0,',','.'),0,0,'R');$pdf->Cell(1,5,'/');$pdf->Cell(5,5,number_format($grupo_part->fields['may_ren'],0,',','.'),0,0,'R');
					$pdf->SetX(132);$pdf->Cell(5,5,number_format($grupo_part->fields['jun'],0,',','.'),0,0,'R');$pdf->Cell(1,5,'/');$pdf->Cell(5,5,number_format($grupo_part->fields['jun_ren'],0,',','.'),0,0,'R');		
					$pdf->SetX(151);$pdf->Cell(5,5,number_format($grupo_part->fields['jul'],0,',','.'),0,0,'R');$pdf->Cell(1,5,'/');$pdf->Cell(5,5,number_format($grupo_part->fields['jul_ren'],0,',','.'),0,0,'R');
					$pdf->SetX(168);$pdf->Cell(5,5,number_format($grupo_part->fields['ago'],0,',','.'),0,0,'R');$pdf->Cell(1,5,'/');$pdf->Cell(5,5,number_format($grupo_part->fields['ago_ren'],0,',','.'),0,0,'R');
					$pdf->SetX(186);$pdf->Cell(5,5,number_format($grupo_part->fields['sep'],0,',','.'),0,0,'R');$pdf->Cell(1,5,'/');$pdf->Cell(5,5,number_format($grupo_part->fields['sep_ren'],0,',','.'),0,0,'R');
					$pdf->SetX(206);$pdf->Cell(5,5,number_format($grupo_part->fields['oct'],0,',','.'),0,0,'R');$pdf->Cell(1,5,'/');$pdf->Cell(5,5,number_format($grupo_part->fields['oct_ren'],0,',','.'),0,0,'R');
					$pdf->SetX(223);$pdf->Cell(5,5,number_format($grupo_part->fields['nov'],0,',','.'),0,0,'R');$pdf->Cell(1,5,'/');$pdf->Cell(5,5,number_format($grupo_part->fields['nov_ren'],0,',','.'),0,0,'R');
					$pdf->SetX(242);$pdf->Cell(5,5,number_format($grupo_part->fields['dic'],0,',','.'),0,0,'R');$pdf->Cell(1,5,'/');$pdf->Cell(5,5,number_format($grupo_part->fields['dic_ren'],0,',','.'),0,0,'R');
					$pdf->SetX(261);$pdf->Cell(5,5,number_format($grupo_part->fields['total'],0,',','.'),0,0,'R');$pdf->Cell(1,5,'/');$pdf->Cell(5,5,number_format($grupo_part->fields['total_ren'],0,',','.'),0,0,'R');
					$pdf->Ln();

					//Porcentajes
					$pdf->SetX(41);$pdf->Cell(5,5,number_format($grupo_part->fields['por_ene'],0,',','.'),0,0,'R');$pdf->Cell(2,5,'%'); 
					$pdf->SetX(59);$pdf->Cell(5,5,number_format($grupo_part->fields['por_feb'],0,',','.'),0,0,'R');$pdf->Cell(1,5,'%'); 
					$pdf->SetX(80);$pdf->Cell(5,5,number_format($grupo_part->fields['por_mar'],0,',','.'),0,0,'R');$pdf->Cell(1,5,'%');
					$pdf->SetX(99); $pdf->Cell(5,5,number_format($grupo_part->fields['por_abr'],0,',','.'),0,0,'R');$pdf->Cell(1,5,'%'); 
					$pdf->SetX(116);$pdf->Cell(5,5,number_format($grupo_part->fields['por_may'],0,',','.'),0,0,'R');$pdf->Cell(1,5,'%');
					$pdf->SetX(133); $pdf->Cell(5,5,number_format($grupo_part->fields['por_jun'],0,',','.'),0,0,'R');$pdf->Cell(1,5,'%');
					$pdf->SetX(152); $pdf->Cell(5,5,number_format($grupo_part->fields['por_jul'],0,',','.'),0,0,'R');$pdf->Cell(1,5,'%'); 
					$pdf->SetX(169);$pdf->Cell(5,5,number_format($grupo_part->fields['por_ago'],0,',','.'),0,0,'R');$pdf->Cell(1,5,'%');
					$pdf->SetX(187);$pdf->Cell(5,5,number_format($grupo_part->fields['por_sep'],0,',','.'),0,0,'R');$pdf->Cell(1,5,'%');
					$pdf->SetX(207);$pdf->Cell(5,5,number_format($grupo_part->fields['por_oct'],0,',','.'),0,0,'R');$pdf->Cell(1,5,'%');
					$pdf->SetX(224);$pdf->Cell(5,5,number_format($grupo_part->fields['por_nov'],0,',','.'),0,0,'R');$pdf->Cell(1,5,'%');
					$pdf->SetX(243);$pdf->Cell(5,5,number_format($grupo_part->fields['por_dic'],0,',','.'),0,0,'R');$pdf->Cell(1,5,'%');
					$pdf->SetX(262); $pdf->Cell(5,5,number_format($grupo_part->fields['por_total'],0,',','.'),0,0,'R');$pdf->Cell(1,5,'%');					
					$pdf->Ln();
					$grupo_part->MoveNext();	
				}
				
					$SQL = ("SELECT safor_ai.id_ai, 
								safor_ai.descripcion AS descripcion
						FROM safor_pry_ae_ai_eje_um 
						INNER JOIN (safor_ae INNER JOIN safor_ai ON safor_ae.id_ae=safor_ai.id_ae) ON (safor_ai.id_ai=safor_pry_ae_ai_eje_um.id_ai) AND (safor_pry_ae_ai_eje_um.id_ae=safor_ae.id_ae)
						WHERE ((safor_ae.id_ae=".$grupo_ae->fields['id_ae'].") AND
							   (safor_ae.id_eje=".$eje.") AND 
							   (safor_ai.id_eje=".$eje.") AND
							   (safor_pry_ae_ai_eje_um.id_eje=".$eje."))
						GROUP BY safor_ae.id_ae, safor_ai.id_ai, safor_ai.descripcion");
					$grupo_ai = $db->Execute($SQL) or die("Error consultando accion interna");

					while(!$grupo_ai->EOF)
						{						
						$pdf->SetFont('Arial','I',6);
						$pdf->SetX(8);$pdf->Cell(80,10,$grupo_ai->fields['id_ai']." - ".$grupo_ai->fields['descripcion']);
						$pdf->Ln(); 
						
						///consulta mas interna
						$SQL = ("SELECT safor_pry_ae_ai_eje_um.id_um, 
								Left(safor_pry_ae_ai_eje_um.descripcion,30) AS descripci, 
								safor_pry_ae_ai_eje_um.total, safor_pry_ae_ai_eje_um.total_ren, (safor_pry_ae_ai_eje_um.total_ren*100)/safor_pry_ae_ai_eje_um.total as por_total,
								safor_pry_ae_ai_eje_um.ene,safor_pry_ae_ai_eje_um.ene_ren, (safor_pry_ae_ai_eje_um.ene_ren*100)/safor_pry_ae_ai_eje_um.ene as por_ene,
								safor_pry_ae_ai_eje_um.feb, safor_pry_ae_ai_eje_um.feb_ren, (safor_pry_ae_ai_eje_um.feb_ren*100)/safor_pry_ae_ai_eje_um.feb as por_feb, 
								safor_pry_ae_ai_eje_um.mar, safor_pry_ae_ai_eje_um.mar_ren, (safor_pry_ae_ai_eje_um.mar_ren*100)/safor_pry_ae_ai_eje_um.mar as por_mar,
								safor_pry_ae_ai_eje_um.abr, safor_pry_ae_ai_eje_um.abr_ren, (safor_pry_ae_ai_eje_um.abr_ren*100)/safor_pry_ae_ai_eje_um.abr as por_abr,
								safor_pry_ae_ai_eje_um.may, safor_pry_ae_ai_eje_um.may_ren, (safor_pry_ae_ai_eje_um.may_ren*100)/safor_pry_ae_ai_eje_um.may as por_may,
								safor_pry_ae_ai_eje_um.jun, safor_pry_ae_ai_eje_um.jun_ren, (safor_pry_ae_ai_eje_um.jun_ren*100)/safor_pry_ae_ai_eje_um.jun as por_jun,
								safor_pry_ae_ai_eje_um.jul, safor_pry_ae_ai_eje_um.jul_ren, (safor_pry_ae_ai_eje_um.jul_ren*100)/safor_pry_ae_ai_eje_um.jul as por_jul,
								safor_pry_ae_ai_eje_um.ago, safor_pry_ae_ai_eje_um.ago_ren, (safor_pry_ae_ai_eje_um.ago_ren*100)/safor_pry_ae_ai_eje_um.ago as por_ago,
								safor_pry_ae_ai_eje_um.sep, safor_pry_ae_ai_eje_um.sep_ren, (safor_pry_ae_ai_eje_um.sep_ren*100)/safor_pry_ae_ai_eje_um.sep as por_sep,
								safor_pry_ae_ai_eje_um.oct, safor_pry_ae_ai_eje_um.oct_ren, (safor_pry_ae_ai_eje_um.oct_ren*100)/safor_pry_ae_ai_eje_um.oct as por_oct,
								safor_pry_ae_ai_eje_um.nov, safor_pry_ae_ai_eje_um.nov_ren, (safor_pry_ae_ai_eje_um.nov_ren*100)/safor_pry_ae_ai_eje_um.nov as por_nov,
								safor_pry_ae_ai_eje_um.dic, safor_pry_ae_ai_eje_um.dic_ren, (safor_pry_ae_ai_eje_um.dic_ren*100)/safor_pry_ae_ai_eje_um.dic as por_dic
								FROM safor_pry_ae_ai_eje_um
								WHERE ((safor_pry_ae_ai_eje_um.id_ae=".$grupo_ae ->fields['id_ae'].") AND (safor_pry_ae_ai_eje_um.id_ai=".$grupo_ai->fields['id_ai'].") AND (safor_pry_ae_ai_eje_um.id_eje=".$eje."))");
							$grupo_ai_um = $db->Execute($SQL) or die("Error consultando accion interna um");

						while(!$grupo_ai_um->EOF)
							{
								$pdf->SetFont('Arial','',6);		
								$pdf->SetX(10);$pdf->Cell(20,5,$grupo_ai_um->fields['descripci']);
								$pdf->Ln(); 
								$pdf->SetX(40);$pdf->Cell(5,5,number_format($grupo_ai_um->fields['ene'],0,',','.'),0,0,'R');$pdf->Cell(1,5,'/');$pdf->Cell(5,5,number_format($grupo_ai_um->fields['ene_ren'],0,',','.'),0,0,'R');
								$pdf->SetX(58);$pdf->Cell(5,5,number_format($grupo_ai_um->fields['feb'],0,',','.'),0,0,'R');$pdf->Cell(1,5,'/');$pdf->Cell(5,5,number_format($grupo_ai_um->fields['feb_ren'],0,',','.'),0,0,'R');
								$pdf->SetX(79);$pdf->Cell(5,5,number_format($grupo_ai_um->fields['mar'],0,',','.'),0,0,'R');$pdf->Cell(1,5,'/');$pdf->Cell(5,5,number_format($grupo_ai_um->fields['mar_ren'],0,',','.'),0,0,'R');
								$pdf->SetX(98);$pdf->Cell(5,5,number_format($grupo_ai_um->fields['abr'],0,',','.'),0,0,'R');$pdf->Cell(1,5,'/');$pdf->Cell(5,5,number_format($grupo_ai_um->fields['abr_ren'],0,',','.'),0,0,'R');
								$pdf->SetX(115);$pdf->Cell(5,5,number_format($grupo_ai_um->fields['may'],0,',','.'),0,0,'R');$pdf->Cell(1,5,'/');$pdf->Cell(5,5,number_format($grupo_ai_um->fields['may_ren'],0,',','.'),0,0,'R');
								$pdf->SetX(132);$pdf->Cell(5,5,number_format($grupo_ai_um->fields['jun'],0,',','.'),0,0,'R');$pdf->Cell(1,5,'/');$pdf->Cell(5,5,number_format($grupo_ai_um->fields['jun_ren'],0,',','.'),0,0,'R');
								$pdf->SetX(151);$pdf->Cell(5,5,number_format($grupo_ai_um->fields['jul'],0,',','.'),0,0,'R');$pdf->Cell(1,5,'/');$pdf->Cell(5,5,number_format($grupo_ai_um->fields['jul_ren'],0,',','.'),0,0,'R');
								$pdf->SetX(168);$pdf->Cell(5,5,number_format($grupo_ai_um->fields['ago']),0,0,'R');$pdf->Cell(1,5,'/');$pdf->Cell(5,5,number_format($grupo_ai_um->fields['ago_ren'],0,',','.'),0,0,'R');
								$pdf->SetX(186);$pdf->Cell(5,5,number_format($grupo_ai_um->fields['sep'],0,',','.'),0,0,'R');$pdf->Cell(1,5,'/');$pdf->Cell(5,5,number_format($grupo_ai_um->fields['sep_ren'],0,',','.'),0,0,'R');
								$pdf->SetX(206);$pdf->Cell(5,5,number_format($grupo_ai_um->fields['oct'],0,',','.'),0,0,'R');$pdf->Cell(1,5,'/');$pdf->Cell(5,5,number_format($grupo_ai_um->fields['oct_ren'],0,',','.'),0,0,'R');
								$pdf->SetX(223);$pdf->Cell(5,5,number_format($grupo_ai_um->fields['nov'],0,',','.'),0,0,'R');$pdf->Cell(1,5,'/');$pdf->Cell(5,5,number_format($grupo_ai_um->fields['nov_ren'],0,',','.'),0,0,'R');
								$pdf->SetX(242);$pdf->Cell(5,5,number_format($grupo_ai_um->fields['dic'],0,',','.'),0,0,'R');$pdf->Cell(1,5,'/');$pdf->Cell(5,5,number_format($grupo_ai_um->fields['dic_ren'],0,',','.'),0,0,'R');
								$pdf->SetX(262);$pdf->Cell(5,5,number_format($grupo_ai_um->fields['total'],0,',','.'),0,0,'R');$pdf->Cell(1,5,'/');$pdf->Cell(5,5,number_format($grupo_ai_um->fields['total_ren'],0,',','.'),0,0,'R');
								$pdf->Ln();
								
								//Porcentaje de la UM de la AI
								$pdf->SetX(41);$pdf->Cell(5,5,number_format($grupo_ai_um->fields['por_ene'],0,',','.'),0,0,'R');$pdf->Cell(2,5,'%');
								$pdf->SetX(59);$pdf->Cell(5,5,number_format($grupo_ai_um->fields['por_feb'],0,',','.'),0,0,'R');$pdf->Cell(2,5,'%');
								$pdf->SetX(59);$pdf->Cell(5,5,number_format($grupo_ai_um->fields['por_feb'],0,',','.'),0,0,'R');$pdf->Cell(2,5,'%');
								$pdf->SetX(80);$pdf->Cell(5,5,number_format($grupo_ai_um->fields['por_mar'],0,',','.'),0,0,'R');$pdf->Cell(2,5,'%');
								$pdf->SetX(99);$pdf->Cell(5,5,number_format($grupo_ai_um->fields['por_abr'],0,',','.'),0,0,'R');$pdf->Cell(2,5,'%');
								$pdf->SetX(116);$pdf->Cell(5,5,number_format($grupo_ai_um->fields['por_may'],0,',','.'),0,0,'R');$pdf->Cell(2,5,'%');
								$pdf->SetX(133);$pdf->Cell(5,5,number_format($grupo_ai_um->fields['por_jun'],0,',','.'),0,0,'R');$pdf->Cell(2,5,'%');
								$pdf->SetX(152);$pdf->Cell(5,5,number_format($grupo_ai_um->fields['por_jul'],0,',','.'),0,0,'R');$pdf->Cell(2,5,'%');
								$pdf->SetX(169);$pdf->Cell(5,5,number_format($grupo_ai_um->fields['por_ago'],0,',','.'),0,0,'R');$pdf->Cell(2,5,'%');
								$pdf->SetX(187);$pdf->Cell(5,5,number_format($grupo_ai_um->fields['por_sep'],0,',','.'),0,0,'R');$pdf->Cell(2,5,'%');
								$pdf->SetX(207);$pdf->Cell(5,5,number_format($grupo_ai_um->fields['por_oct'],0,',','.'),0,0,'R');$pdf->Cell(2,5,'%');
								$pdf->SetX(224);$pdf->Cell(5,5,number_format($grupo_ai_um->fields['por_nov'],0,',','.'),0,0,'R');$pdf->Cell(2,5,'%');
								$pdf->SetX(243);$pdf->Cell(5,5,number_format($grupo_ai_um->fields['por_dic'],0,',','.'),0,0,'R');$pdf->Cell(2,5,'%');
								$pdf->SetX(263);$pdf->Cell(5,5,number_format($grupo_ai_um->fields['por_total'],0,',','.'),0,0,'R');$pdf->Cell(2,5,'%');
							$pdf->Ln();
							$grupo_ai_um->MoveNext();
							}
						$grupo_ai->MoveNext();
						}
			$grupo_ae -> MoveNext();
			}
$pdf->Ln();$pdf->Ln(); $pdf->Ln();$pdf->Ln(); $pdf->Ln();
$pdf->SetFont('Arial','',9);
$pdf->SetX(2);$pdf->Cell(100,5,'APROBADO POR:____________________________________',0,0,'L');$pdf->Ln();
$pdf->SetX(30);$pdf->Cell(10,10,'JEFE DE LA UNIDAD EJECUTORA',0,0,'L');$pdf->Ln();$pdf->Ln();$pdf->Ln();
$pdf->SetX(50);$pdf->Cell(100,5,'SELLO',0,0,'L');
					
}
	
$pdf->Output("r_eje_ae_ai.pdf","I");

?>