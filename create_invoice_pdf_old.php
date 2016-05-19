<?php
include("includes/connect.php");
require('invoice.php');
setlocale(LC_MONETARY, 'en_US');

$invoice_items= $_GET["invoice_items"];
$service_charge_trim= ltrim($_GET["service_charge"], "$");
$service_charge_replace= str_replace(',','',$service_charge_trim);

$sql = "SELECT * FROM srcl_invoice_table AS i
		LEFT JOIN (
					 SELECT DISTINCT line_item_id,
									  srcl_inv_id,
									  pro_number,
									  carrier_id,
									  status,
									  shipper_name, 
									  shipper_state, 
									  consignee_name, 
									  consignee_state,
									  pallets,
									  weight, 
									  gross_amount,
									  BOL
					 FROM dayton
				   ) 
		 AS d ON i.srcl_inv_num = d.srcl_inv_id
		 LEFT JOIN
				  (
					SELECT carrier_id, 
						   carrier_name 
					FROM carriers
				  ) 
		AS c ON d.carrier_id = c.carrier_id
        WHERE line_item_id IN (".$invoice_items.")";

$query = mysql_query($sql,$con);
$count = mysql_num_rows($query);
//$address = mysql_fetch_array($query);
//echo $count;

$item_sql = "SELECT * FROM dayton WHERE line_item_id IN (".$invoice_items.")";
$item_qry = mysql_query($item_sql,$con);
$total_line_items = mysql_num_rows($item_qry);

$totals_sql = "SELECT SUM( gross_amount ) AS total, SUM( weight ) AS weight,statement_number FROM dayton WHERE line_item_id IN  (".$invoice_items.")";
	$totals_qry = mysql_query($totals_sql,$con);
	$totals = mysql_fetch_assoc($totals_qry);
	$total_invoice_amount = $totals['total'] + $service_charge_replace;
	$total_invoice_amount_format=number_format($total_invoice_amount, 2, '.', ',');
	

		$pdf = new PDF_Invoice( 'P', 'mm', 'A4' );
		$pdf->AddPage();
		$pdf->IMAGE('images/srcfreight_new.jpg',10,5,33,0);
		$pdf->addSociete( "",
						  "2065 E Pythian St\n" .
						  "Springfield MO, 65802");
		
		//$pdf->temporaire( "Devis temporaire" );
		//$pdf->addDate( DATE('m/d/Y'));
		//$pdf->addClient("CL01");
		//$pdf->addPageNumber("1");
		
		
		$pdf->addReglement($total_line_items);
		$pdf->addEcheance("$".$total_invoice_amount_format);
		$pdf->addNumTVA($totals['statement_number']);
		//$pdf->addReference("Devis ... du ....");
		$cols=array( "SHIPPER"    => 85,
					 "WEIGHT"      => 36,
					 "GROSS AMOUNT"  => 80);
					 #"SERVICE CHARGE" => 40
		$pdf->addCols( $cols);
		$cols=array( "SHIPPER"    => "C",
					 "WEIGHT"      => "C",
					 "GROSS AMOUNT"  => "C");
					 #"SERVICE CHARGE"  => "C"
		$pdf->addLineFormat($cols);
		$pdf->addLineFormat($cols);

		$y=49;
		$count = 0;
			//$line_service_charge = array( "SERVICE CHARGE"    => "$".$service_charge);
			//$size = $pdf->addLine( $y, $line_service_charge);
			
		while($row=mysql_fetch_array($query)){
				$pdf->fact_dev("Customer",$row['customer_name']);
				//$pdf->addClientAdresse($row['cust_street']);
				$line = array( "SHIPPER"    => $row['shipper_name'],
							   "WEIGHT"      => $row['weight']." lbs",
							   "GROSS AMOUNT"  => "$".$row['gross_amount'],);
				$y   += $size + 3;
				$size = $pdf->addLine($y, $line);
		}
		
		
		
		//$size = $pdf->addLine( $y, $line );
		/*$y   += $size + 2;

		$line = array( "SHIPPER"    => "REF2",
					   "GROSS AMOUNT"  => "Câble RS232",
					   "WEIGHT"      => "10.00");*/
		//$size = $pdf->addLine( $y, $line );
		

		//$pdf->addCadreTVAs();
				
		// invoice = array( "px_unit" => value,
		//                  "qte"     => qte,
		//                  "tva"     => code_tva );
		// tab_tva = array( "1"       => 19.6,
		//                  "2"       => 5.5, ... );
		// params  = array( "RemiseGlobale" => [0|1],
		//                      "remise_tva"     => [1|2...],  // {la remise s'applique sur ce code TVA}
		//                      "remise"         => value,     // {montant de la remise}
		//                      "remise_percent" => percent,   // {pourcentage de remise sur ce montant de TVA}
		//                  "FraisPort"     => [0|1],
		//                      "portTTC"        => value,     // montant des frais de ports TTC
		//                                                     // par defaut la TVA = 19.6 %
		//                      "portHT"         => value,     // montant des frais de ports HT
		//                      "portTVA"        => tva_value, // valeur de la TVA a appliquer sur le montant HT
		//                  "AccompteExige" => [0|1],
		//                      "accompte"         => value    // montant de l'acompte (TTC)
		//                      "accompte_percent" => percent  // pourcentage d'acompte (TTC)
		//                  "Remarque" => "texte"              // texte
		
		$tot_prods = array( array ( "px_unit" => 700, "qte" => 1, "tva" => 1 ),
							array ( "px_unit" =>  10, "qte" => 1, "tva" => 1 ));
		$tab_tva = array( "1"       => 19.6,
						  "2"       => 5.5);
		$params  = array( "RemiseGlobale" => 1,
							  "remise_tva"     => 1,       // {la remise s'applique sur ce code TVA}
							  "remise"         => 0,       // {montant de la remise}
							  "remise_percent" => 10,      // {pourcentage de remise sur ce montant de TVA}
						  "FraisPort"     => 1,
							  "portTTC"        => 10,      // montant des frais de ports TTC
														   // par defaut la TVA = 19.6 %
							  "portHT"         => 0,       // montant des frais de ports HT
							  "portTVA"        => 19.6,    // valeur de la TVA a appliquer sur le montant HT
						  "AccompteExige" => 1,
							  "accompte"         => 0,     // montant de l'acompte (TTC)
							  "accompte_percent" => 15,    // pourcentage d'acompte (TTC)
						  "Remarque" => "Avec un acompte, svp..." );

		//$pdf->addTVAs( $params, $tab_tva, $tot_prods);
		//$pdf->addCadreEurosFrancs();
		$pdf->Output();
?>
