<?php

require_once('tcpdf_include.php');
//$header_title = "Client Report: " . stripslashes($report->title);
//$fname = stripslashes($report->fname);
//$header_string = "by " . $fname;
//$header_string .= !empty($report->fcompany) ? " - " . stripslashes($report->fcompany) : "";      
//$header_string .= !empty($report->email) ? " - " . stripslashes($report->email) : "";      

// create new PDF document
$pdf = new CREPORT_TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
//$pdf->SetAuthor($fname);
$pdf->SetTitle('Client Report ' . stripslashes($report->title));
$pdf->SetSubject('Client Report');
$pdf->SetKeywords('Client Report');

// set default header data
//$pdf->SetHeaderData("", 0, $header_title, $header_string, array(127,177,0), array(127,177,0));
//$pdf->setFooterData(array(127,177,0), array(127,177,0));

// set header and footer fonts
//$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
//$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
//$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
//$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
//$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
//if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
//	require_once(dirname(__FILE__).'/lang/eng.php');
//	$pdf->setLanguageArray($l);
//}

// ---------------------------------------------------------

// set default font subsetting mode
$pdf->setFontSubsetting(true);

$time = 300; /*300 seconds = 5 minutes*/
$mem =  '512M';
@ini_set('memory_limit', $mem);
@ini_set('max_execution_time', $time);

// Set font
// dejavusans is a UTF-8 Unicode font, if you only need to
// print standard ASCII chars, you can use core fonts like
// helvetica or times to reduce file size.
$pdf->SetFont('dejavusans', '', 12, '', true);

$pdf->SetPrintHeader(false);
$pdf->SetPrintFooter(false);
// Add a page
// This method has several options, check the source code documentation for more information.
$pdf->AddPage();
$content = MainWPCReport::gen_email_content_pdf($report, true);
$html = "";
if (is_array($content)) {
    foreach($content as $ct) {
        $html .= $ct;
    }
} else {
    $html = $content;
}
$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
$pdf->Output('client-report.pdf', 'I');

