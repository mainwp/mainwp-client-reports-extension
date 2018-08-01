<?php

/*
 * DOMPDF requires following configuration on your server
 * PHP > 5.3
 * DOM extension
 * GD extension
 * MB String extension
 * php-font-lib
 * php-svg-lib
*/

require_once __DIR__ . '/dompdf/autoload.inc.php';

use Dompdf\Dompdf;
use Dompdf\Options;

$options = new Options();
$options->setIsRemoteEnabled(true);
$dompdf = new Dompdf($options);

$html = false; // to fix bug
if ( isset( $_GET['id'] ) && $_GET['id'] && isset($_GET['time']) && !empty($_GET['time'])) {
    $time = $_GET['time'];
	$content = get_option( 'mwp_creport_pdf_' . $time . '_' . $_GET['id'], false );
	if ( !empty($content) ) {
        $html = '<html>' ;
        $html .= '<head><title>Client Report</title></head>' ;
        $html .= '<body>' . unserialize( $content ) . '</body>';
        $html .= '</html>' ;
		delete_option( 'mwp_creport_pdf_' . $time . '_' . $_GET['id'] );
	} else {
        echo 'Error: empty report content, please try again.';
    }

}

if ( !empty( $html) ) {
    $dompdf->loadHtml($html);
    $dompdf->render();
    $dompdf->stream('client-report.pdf', array("Attachment"=>0));
}


