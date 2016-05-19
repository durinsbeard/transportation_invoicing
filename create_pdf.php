<?
 //download fpdf class (http://fpdf.org)
//define FPDF font path
    define('FPDF_FONTPATH', 'fpdf/font/');
    //include FPDF class library file
    require_once 'fpdf/fpdf.php';
 
    //create an instance of FPDF
    //The first parameter should be paper orientation
    //P refers to potrait and L refers to Letter
    //The second parameter should be measuring-unit used
    //Available units: cm, mm, in and pt
    //The last parameter should be paper type
    //Availale paper types: A4, Letter, and Legal
    $pdf = new FPDF('P', 'cm', 'A4');
 
    //Init PDF creation
    $pdf->open();
 
    //Add a new PDF blank page
    $pdf->AddPage();
 
    //You may set the margin (optional)
    //The first param is the left margin
    //The second param is the top margin
    //The third param is the right margin
    //The fourth param is the bottom margin
    $pdf->SetMargins(1,1,1,1);
 
    //Set font
    //The first param should be the font family
    //Available fonts: courier, helvetica, times
    //The second param should be the font style
    //Available style: B(Bold), U(Underline) and I(Italic)
    //The third param should be the font size
    $pdf->SetFont('Arial', 'BUI', 21);
 
    //Set font color
    //Color is represent by RGB
    //The first param is Red color index
    //The second param is Green color index
    //The third param is Blue color index
    $pdf->SetTextColor(200,75,75);
 
    //Print a text on the page
    //The first param should be the width of text area
    //0 value will make the FPDF automate the width
    //The second param is the height
    //The third param is the text
    //$pdf->Cell(0, 2, Image('images/src_logo_clear.gif', 1, 10, 5.8, 1.5));
	$pdf->Image('images/src_logo_clear.gif', 9, 1, 3, 1);
 
    //Print a line break
    //The param is the height of line spacing
    //If you leave it empty, it will use default size
    //$pdf->Ln(2);
 
    //Set text alignment and bordering
    //The fourth param is the size of border
    //0 means borderless
    //The fifth param is the size of line spacing
    //0 means no spacing after the text is printed
    //The last param is the text alignment
    //C(Center), L(Left), R(Right)
    //$pdf->Cell(0, 2, 'Hello there!',0, 0, 'C');
 
    $pdf->Ln(1.5);
 
    //You may re-define the font style as you wish
    $pdf->SetFont('Arial', 'I', 12);
    $pdf->SetTextColor(0,0,255);
 
    //Print a multiline/paragraph text
    /*$text = '
        this is a long paragraph. this is a long paragraph.
        this is a long paragraph. this is a long paragraph.
        this is a long paragraph. this is a long paragraph.
        this is a long paragraph. this is a long paragraph.
        this is a long paragraph. this is a long paragraph.
        this is a long paragraph. this is a long paragraph.
    ';*/
    //The first param should be the width of text area
    //0 value will make the FPDF automate the width
    //The second param is the line spacing for this paragraph
    //The third param is the text
    //$pdf->MultiCell(17.5,0.5,$text);
    //You may add more param for multicell
    //The fourth param is the border width
    //The fifth param is the alignment
    //e.g: $pdf->MultiCell(8,1,$text,1,'L');
 
    $pdf->Ln(0.5);
 
    $pdf->SetFont('Arial', 'U', 8);
    $pdf->SetTextColor(0,0,200);
 
    //Add a link
    //The first param is the line height
    //The second param is the link text
    //The last param is the link URL
    //$pdf->Write(1, 'FPDF Example by Xhanch', 'http://xhanch.com');
 
    //$pdf->Ln(0.5);
    //Adding image
    //The first param is the file path
    //Allowed type: jpg, jpeg, gif and png
    //The second param is the x coordinate of the page
    //The third param is the y coordinate of the page
    //The fourth param is the width of the image
    //The fifth param is the height of the image
    
 
    //Creating table
    //Table can be created by using Cell function
    //We just need to set the cell border
 
    //$pdf->Ln(5.5);
 
    //Data for the table
    $header = array('Col A', 'Col B', 'Col C');
    $data = array(
				array('A1', 'B1', 'C1'),
				array('A2', 'B2', 'C2'),
				array('A2', 'B2', 'C2')
			);
 
    //Simple table
   /* foreach($header as $col)
    $pdf->Cell(2, 0.5, $col, 1);
    $pdf->Ln();
    foreach($data as $row){
        foreach($row as $col)
            $pdf->Cell(2, 0.5, $col, 1);
        $pdf->Ln();
    }
 
    $pdf->Ln(0.5);*/
 
    //Improved table
    //Set Column widths
    /*$w=array(2,2,2);
    for($i=0;$i<count($header);$i++)
        $pdf->Cell($w[$i],0.5,$header[$i],1,0,'C');
    $pdf->Ln();
    foreach($data as $row){
        $pdf->Cell($w[0],0.5,$row[0],'LR');
        $pdf->Cell($w[1],0.5,$row[1],'LR');
        $pdf->Cell($w[2],0.5,$row[2],'LR');
        $pdf->Ln();
    }
    $pdf->Cell(array_sum($w),0,'','T');*/
 
    $pdf->Ln(0.25);
 
    //Colored table
    $pdf->SetFillColor(255,0,0);
    $pdf->SetTextColor(255);
    $pdf->SetDrawColor(128,0,0);
    $pdf->SetLineWidth(0.01);
    $pdf->SetFont('','B');
    $w=array(2,2,2);
    for($i=0;$i<count($header);$i++)
        $pdf->Cell($w[$i],0.5,$header[$i],1,0,'C',true);
    $pdf->Ln();
    $pdf->SetFillColor(224,235,255);
    $pdf->SetTextColor(0);
    $pdf->SetFont('');
    //Data
    $fill=false;
    foreach($data as $row){
        $pdf->Cell($w[0],0.5,$row[0],'LR',0,'L',$fill);
        $pdf->Cell($w[1],0.5,$row[1],'LR',0,'L',$fill);
        $pdf->Cell($w[2],0.5,$row[2],'LR',0,'L',$fill);
        $pdf->Ln();
        $fill=!$fill;
    }
    $pdf->Cell(array_sum($w),0,'','T');
 
    //Displaying PDF page
    $pdf->Output();
 
    //If you want to force the viewer to download
    //the PDF file use the following command instead
    //of $pdf->Output()
    //$pdf->Output('file_name.pdf', 'D');

 
