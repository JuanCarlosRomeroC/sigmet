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
		
		$this->SetTextColor(0,0,0);	
		
		$this->Image('../../images/logo.JPG',1,1,33);
    		$this->SetFont('Arial','B',8);
		$this->SetY(8);
		$this->SetX(1);
		$this->Cell(277,0.5,'',1,0,'L',1);
		$this->SetY(9);$this->SetX(90);$this->SetFillColor(255,255,255);$this->Cell(100,3,'DISTRIBUCIÓN MENSUAL DE METAS FÍSICAS AÑO 2011',0,0,'C',1);
		
				
		//TITULO
		$this->SetFillColor(255,255,255);
		$this->SetFont('Arial','B',7);
		$this->SetY(12);$this->SetX(1);$this->Cell(90,3,'Directriz: Modelo Productivo Socialista',0,0,'L',1);
		$this->Ln();$this->SetX(1);$this->Cell(100,3,'Objetivo estratégico nacional: Desarrollar el nuevo modelo productivo endógeno como base económica del Socialismo del siglo XXI y alcanzar un desarrollo sostenido.',0,0,'L',1);
		$this->Ln();$this->SetX(1);$this->Cell(100,3,'Estrategia: Consolidar el carácter endógeno de la economía',0,0,'L',1);
		$this->Ln();$this->SetX(1);$this->Cell(100,3,'Objetivo Estratégico Inst: Reordenar el Sistema Tributario a la concepción Socialista del Estado Venezolano, para garantizar estructuras impositivas que distribuyan la carga en función del esfuerzo humano productivo requerido',0,0,'L',1);
		$this->Ln();$this->SetX(32);$this->Cell(100,3,'para generar la riqueza.',0,0,'L',1);
		$this->Ln();$this->SetX(1);$this->Cell(100,3,'Enunciado del Objetivo del Proyecto: Desarrollado un Sistema Integral de Gestión de Cobranzas y Control Fiscal.',0,0,'L',1);
		$this->Ln();$this->SetX(1);$this->Cell(277,0,'',1,0,'L',1);

		
		//TITULOS
		//$this->SetY(36);$this->SetX(90);
		//$this->Cell(189,4,'META FÍSICA AÑO 2011',1,0,'C',1);	
		$this->SetFillColor(232,232,232);
		$this->SetFont('Arial','B',9);
		$this->SetY(33);$this->SetX(1);
		$this->Cell(30,3,'Acción Específica',0,0,'L',1);
		$this->SetY(36);$this->SetX(1);
		$this->Cell(30,3,'Partida',0,0,'L',1);
		$this->SetY(36);$this->SetX(28);
		$this->Cell(100,3,'Descripción',0,0,'L',1);
		$this->SetY(36);$this->SetX(90);
		$this->Cell(20,3,'Ene.',0,0,'L',1);
		$this->SetY(36);$this->SetX(105);
		$this->Cell(20,3,'Feb.',0,0,'L',1);
		$this->SetY(36);$this->SetX(120);
		$this->Cell(20,3,'Mar.',0,0,'L',1);
		$this->SetY(36);$this->SetX(135);
		$this->Cell(20,3,'Abr.',0,0,'L',1);
		$this->SetY(36);$this->SetX(150);
		$this->Cell(20,3,'May.',0,0,'L',1);
		$this->SetY(36);$this->SetX(165);
		$this->Cell(20,3,'Jun.',0,0,'L',1);
		$this->SetY(36);$this->SetX(180);
		$this->Cell(20,3,'Jul.',0,0,'L',1);
		$this->SetY(36);$this->SetX(195);
		$this->Cell(20,3,'Ago.',0,0,'L',1);
		$this->SetY(36);$this->SetX(210);
		$this->Cell(20,3,'Sep.',0,0,'L',1);
		$this->SetY(36);$this->SetX(225);
		$this->Cell(20,3,'Oct.',0,0,'L',1);
		$this->SetY(36);$this->SetX(240);
		$this->Cell(20,3,'Nov.',0,0,'L',1);
		$this->SetY(36);$this->SetX(255);
		$this->Cell(20,3,'Dic.',0,0,'L',1);
		$this->SetY(36);$this->SetX(270);
		$this->Cell(10,3,'Total',0,0,'L',1);

	}

	function Footer()
	{
   		$this->SetTextColor(0,0,180);	
		$this->SetY(-15);
 	        $this->SetFont('Arial','I',8);
 	        $this->Cell(0,10,'Páginas '.$this->PageNo().'/{nb}',0,0,'C');
                
		$this->SetY(208);
		$this->SetX(90);
		$this->Cell(0,10,'FORMULACION DEL PRESUPUESTO 2011 - Oficina de Planificación y Presupuesto');

	}
}
	
	$eje=$_GET['eje']; // para el ejecutor
	
	$pdf=new PDF('L','mm','letter');
	$pdf->AliasNbPages();

	$pdf->AddPage();
	$pdf->SetFont('Arial','',8);
	
	$Y_Fields_Name_position = 20;
	$db=DB_CONECCION();
		
		$pdf->SetFont('Arial','I','B',10);
		$pdf->SetY(38);
		$pdf->Cell(10,10,'ACCIÓN ESPECÍFICA',0,0,'C');


		$SQL = ("SELECT safor_eje.descripcion
				FROM safor_eje
				WHERE (safor_eje.id_eje=".$eje.")");
		$grupo_eje = $db->Execute($SQL) or die("Error consultando el ejecutor");
		if (!$grupo_eje ->EOF)
		{
			$pdf->SetFont('Arial','B',7);
			$pdf->SetY(30);$pdf->SetX(1);$pdf->Cell(40,3,'Gerencia de Tributos Internos:',0,0,'L');
			$pdf->Cell(100,3,$grupo_eje ->fields['descripcion'],0,0,'L');
			
			$pdf->SetFont('Arial','I',8);


			$SQL = ("SELECT safor_pry_ae_eje_um.id_ae, 
							safor_ae.descripcion
					FROM safor_ae INNER JOIN safor_pry_ae_eje_um ON safor_ae.id_ae = safor_pry_ae_eje_um.id_ae
					WHERE (safor_ae.id_eje=".$eje.") AND (safor_ae.poa=TRUE)
					GROUP BY safor_pry_ae_eje_um.id_ae, safor_ae.descripcion");

					$grupo_ae = $db->Execute($SQL) or die("Error consultando la accion especifica");
			
			$pdf->SetY(44);
			$pdf->SetX(1);
			while(!$grupo_ae ->EOF)
			{
			$pdf->SetFont('Arial','',8);
			$pdf->SetX(1);
			$pdf->Cell(10,10,$grupo_ae ->fields['id_ae'],0,0,'L');
			$pdf->Cell(100,10,$grupo_ae ->fields['descripcion'],0,0,'L');
			$pdf->Ln();
	

			$SQL = ("SELECT safor_pry_ae_eje_um.id_um, 
							Left(safor_pry_ae_eje_um.descripcion,40) AS descrip, 
							safor_pry_ae_eje_um.total, 
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
							safor_pry_ae_eje_um.dic
					FROM safor_ae INNER JOIN safor_pry_ae_eje_um ON (safor_ae.id_eje = safor_pry_ae_eje_um.id_eje) AND (safor_ae.id_ae = safor_pry_ae_eje_um.id_ae)
					WHERE ((safor_ae.id_ae=".$grupo_ae->fields['id_ae'].") AND 
						   (safor_pry_ae_eje_um.id_eje=".$eje.") AND
						   (safor_ae.id_eje=".$eje."))");
					
					$grupo_part = $db->Execute($SQL) or die("Error consultando unidad de medida");
		
				
				while(!$grupo_part->EOF)
				{	
					$pdf->SetFont('Arial','',8);
					$pdf->SetX(6);$pdf->Cell(10,10,$grupo_part->fields['id_um'],'C');
					$pdf->SetX(18);$pdf->Cell(40,10,$grupo_part->fields['descrip']);

					$pdf->SetX(90);$pdf->Cell(5,10,number_format($grupo_part->fields['ene'],0,',','.'),0,0,'R');
					$pdf->SetX(105);$pdf->Cell(5,10,number_format($grupo_part->fields['feb'],0,',','.'),0,0,'R');
					$pdf->SetX(120);$pdf->Cell(5,10,number_format($grupo_part->fields['mar'],0,',','.'),0,0,'R');
					$pdf->SetX(135);$pdf->Cell(5,10,number_format($grupo_part->fields['abr'],0,',','.'),0,0,'R');
					$pdf->SetX(150);$pdf->Cell(5,10,number_format($grupo_part->fields['may'],0,',','.'),0,0,'R');
					$pdf->SetX(165);$pdf->Cell(5,10,number_format($grupo_part->fields['jun'],0,',','.'),0,0,'R');
					$pdf->SetX(180);$pdf->Cell(5,10,number_format($grupo_part->fields['jul'],0,',','.'),0,0,'R');
					$pdf->SetX(195);$pdf->Cell(5,10,number_format($grupo_part->fields['ago'],0,',','.'),0,0,'R');
					$pdf->SetX(210);$pdf->Cell(5,10,number_format($grupo_part->fields['sep'],0,',','.'),0,0,'R');
					$pdf->SetX(225);$pdf->Cell(5,10,number_format($grupo_part->fields['oct'],0,',','.'),0,0,'R');
					$pdf->SetX(240);$pdf->Cell(5,10,number_format($grupo_part->fields['nov'],0,',','.'),0,0,'R');
					$pdf->SetX(255);$pdf->Cell(5,10,number_format($grupo_part->fields['dic'],0,',','.'),0,0,'R');
					$pdf->SetX(270);$pdf->Cell(5,10,number_format($grupo_part->fields['total'],0,',','.'),0,0,'R');
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

						
						$pdf->SetFont('Arial','I',8);
						//$pdf->SetX(8);$pdf->Cell(10,10,$grupo_ai->fields['id_ai'],'C');
						$pdf->SetX(20);$pdf->Cell(100,10,$grupo_ai->fields['descripcion']);
						$pdf->Ln();

						///consulta mas interna

						$SQL = ("SELECT safor_pry_ae_ai_eje_um.id_um, 
								Left(safor_pry_ae_ai_eje_um.descripcion,30) AS descripci, 
								safor_pry_ae_ai_eje_um.total, 
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
								safor_pry_ae_ai_eje_um.dic
								FROM safor_pry_ae_ai_eje_um
								WHERE ((safor_pry_ae_ai_eje_um.id_ae=".$grupo_ae ->fields['id_ae'].") AND (safor_pry_ae_ai_eje_um.id_ai=".$grupo_ai->fields['id_ai'].") AND (safor_pry_ae_ai_eje_um.id_eje=".$eje."))");
							$grupo_ai_um = $db->Execute($SQL) or die("Error consultando accion interna um");

						while(!$grupo_ai_um->EOF)
							{
								$pdf->SetFont('Arial','',8);
								//$pdf->SetX(12);$pdf->Cell(10,10,$grupo_ai_um->fields['id_um'],'C');
								$pdf->SetX(26);$pdf->Cell(40,10,$grupo_ai_um->fields['descripci']);
								$pdf->SetX(90);$pdf->Cell(5,10,number_format($grupo_ai_um->fields['ene'],0,',','.'),0,0,'R');
								$pdf->SetX(105);$pdf->Cell(5,10,number_format($grupo_ai_um->fields['feb'],0,',','.'),0,0,'R');
								$pdf->SetX(120);$pdf->Cell(5,10,number_format($grupo_ai_um->fields['mar'],0,',','.'),0,0,'R');
								$pdf->SetX(135);$pdf->Cell(5,10,number_format($grupo_ai_um->fields['abr'],0,',','.'),0,0,'R');
								$pdf->SetX(150);$pdf->Cell(5,10,number_format($grupo_ai_um->fields['may'],0,',','.'),0,0,'R');
								$pdf->SetX(165);$pdf->Cell(5,10,number_format($grupo_ai_um->fields['jun'],0,',','.'),0,0,'R');
								$pdf->SetX(180);$pdf->Cell(5,10,number_format($grupo_ai_um->fields['jul'],0,',','.'),0,0,'R');
								$pdf->SetX(195);$pdf->Cell(5,10,number_format($grupo_ai_um->fields['ago'],0,',','.'),0,0,'R');
								$pdf->SetX(210);$pdf->Cell(5,10,number_format($grupo_ai_um->fields['sep'],0,',','.'),0,0,'R');
								$pdf->SetX(225);$pdf->Cell(5,10,number_format($grupo_ai_um->fields['oct'],0,',','.'),0,0,'R');
								$pdf->SetX(240);$pdf->Cell(5,10,number_format($grupo_ai_um->fields['nov'],0,',','.'),0,0,'R');
								$pdf->SetX(255);$pdf->Cell(5,10,number_format($grupo_ai_um->fields['dic'],0,',','.'),0,0,'R');
								$pdf->SetX(270);$pdf->Cell(5,10,number_format($grupo_ai_um->fields['total'],0,',','.'),0,0,'R');
								$pdf->Ln();
							$grupo_ai_um->MoveNext();
							}
						$grupo_ai->MoveNext();
					
						}
			$grupo_ae -> MoveNext();
			}

$pdf->Ln();$pdf->Ln();
$pdf->SetFont('Arial','',9);
$pdf->SetX(2);$pdf->Cell(100,5,'APROBADO POR:____________________________________',0,0,'L');$pdf->Ln();
$pdf->SetX(30);$pdf->Cell(10,10,'JEFE DE LA UNIDAD EJECUTORA',0,0,'L');$pdf->Ln();$pdf->Ln();$pdf->Ln();
$pdf->SetX(50);$pdf->Cell(100,5,'SELLO',0,0,'L');

					
}
	
$pdf->Output("r_eje_ae_ai.pdf","I");

?>