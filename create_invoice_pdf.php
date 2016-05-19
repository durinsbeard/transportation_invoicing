<?php
include("includes/connect.php");
require('invoice.php');
setlocale(LC_MONETARY, 'en_US');

$invoice_number= $_GET["invoice_numbers"];

//$service_charge_trim= ltrim($_GET["service_charge"], "$");
//$service_charge_replace= str_replace(',','',$service_charge_trim);
		$sql =   "SELECT d.srcl_inv_id, 
						 d.carrier_id,
						 d.customer_id,
						 d.pro_number,
						 c.carrier_name,
						 cust.customer_name,
						 cust.cust_street,
						 cust.cust_city,
						 cust.cust_state,
						 cust.cust_zip,
						 cust.cust_phone,
						 sum(d.gross_amount) as total, 
						 count(d.srcl_inv_id) as shipments, 
						 i.srcl_inv_date 
				  FROM dayton d 
				  JOIN 
					  ( 
					   SELECT carrier_id, 
							  carrier_name 
					   FROM carriers 
					  ) 
				  AS c ON d.carrier_id = c.carrier_id
				  JOIN
					  (
					   SELECT *
					   FROM customers
					  )
				  as cust ON d.customer_id = cust.customer_id
				  JOIN 
					  ( 
					   SELECT srcl_inv_num, 
							  srcl_inv_date 
					   FROM srcl_invoice_table 
					  ) 
				  AS i ON d.srcl_inv_id = i.srcl_inv_num 
				  WHERE d.srcl_inv_id = '".$invoice_number."' 
				  GROUP BY d.srcl_inv_id";
        
		//echo $sql;
		$query = mysql_query($sql,$con);
		//$count = mysql_num_rows($query);*/
		//$address = mysql_fetch_array($query);
		//echo $count;

		/*$item_sql = "SELECT * FROM dayton WHERE line_item_id IN (".$invoice_items.")";
		$item_qry = mysql_query($item_sql,$con);
		$total_line_items = mysql_num_rows($item_qry);

		$totals_sql = "SELECT SUM( gross_amount ) AS total, SUM( weight ) AS weight,statement_number FROM dayton WHERE line_item_id IN  (".$invoice_items.")";
		$totals_qry = mysql_query($totals_sql,$con);
		$totals = mysql_fetch_assoc($totals_qry);
		$total_invoice_amount = $totals['total'] + $service_charge_replace;
		$total_invoice_amount_format=number_format($total_invoice_amount, 2, '.', ',');*/
	
		
		$pdf = new PDF_Invoice( 'P', 'mm', 'A4' );
		$pdf->AddPage();
		$pdf->IMAGE('images/srcfreight_new.jpg',10,5,33,0);
		$pdf->addSociete( "",
						  "2065 E Pythian St\n" .
						  "Springfield MO, 65802\n" .
						  "Phone: (417)-864-4946\n" .
						  "Fax:\n" .
						  "E-Mail: info@srclogisticsinc.com");
		
		//$pdf->temporaire( "Devis temporaire" );
		$pdf->addDate( DATE('m/d/Y'));
		//$pdf->addClient("CL01");
		//$pdf->addPageNumber("1");
		
		while($row=mysql_fetch_array($query)){
			$pdf->addReglement("Net 15");
			$pdf->addEcheance(date("d-m-Y"));
			$pdf->addNumTVA($row['srcl_inv_id']);
			//$pdf->addReference("Devis ... du ....");
			$cols=array( "Date" => 25,
						 "Description"    => 80,
						 "QTY"      => 12,
						 "Rate" => 35,
						 "Unit Price"  => 30,);
			$pdf->addCols( $cols);
			$cols=array( "Date" => "C",
			             "Description"    => "C",
						 "Qty"      => "C",
						 "Rate"  => "C",
						 "Unit Price"  => "C");
			$pdf->addLineFormat($cols);
			
			$y=75;
			$count = 0;
			$service_charge = number_format($row['total'] * .15 + 10,2,'.',',');
				//$size = $pdf->addLine( $y, $line_service_charge);
				
			//$pdf->fact_dev();
			$pdf->addClientAdresse( "Bill To:\n".$row['customer_name']."\n".
									 $row['cust_street']."\n".
									 $row['cust_city']." ". $row['cust_state'] ." ".$row['cust_zip']."\n".
									 "P.O. Box:\n".
									  $row['cust_phone']
								  );
			$line = array( "Date" => $row['srcl_inv_date'],
						   "Description"    => date("M-Y")."|".$row['shipments']." Shipments at 15%|Subscription Fee",
						   "QTY"      => "1",
						   "Rate" => "$".$service_charge,
						   "Unit Price"  => "$".$row['total']
						 );
			$y   += $size + 14;
			$size = $pdf->addLine($y, $line);
	
			$y   += $size + 2;
			$line = array( "Date" => $row['srcl_inv_date'],
						   "Description"    => "Admin Fee",
						   "QTY"  => "1",
						   "Rate" => "$10:00",
						   "Unit Price"      => "$10.00"
						 );
			$size = $pdf->addLine( $y, $line );
		
			//$size = $pdf->addLine($y, $line);
			//$y   += $size + 2;

			/*$line = array( "SHIPPER"    => "REF2",
						   "GROSS AMOUNT"  => "Câble RS232",
						   "WEIGHT"      => "10.00");
			$size = $pdf->addLine( $y, $line );*/
			$total = $row['total'] + $service_charge;
			$terms = " payment must be made with in 15 days of recieving invoice.";
			$pdf->addCadreEurosFrancs($total);
			
			
			$pdf->addCadreTVAs($terms);
		}
			//$invoice = $row['total'];	
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
			
			/*$tot_prods = array( array ( "px_unit" => 689.08, "qte" => 1, "tva" => 1 ),
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
							  "Remarque" => "Avec un acompte, svp..." );*/

			//$pdf->addTVAs( $params, $tab_tva,$invoice);
			
		
		$pdf->Output();

?>
