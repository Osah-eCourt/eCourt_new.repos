<?php

require_once '../../../classes/CreateDocx.inc';
require_once '../../../classes/TransformDoc.inc';
require_once '../../../classes/TransformDoc.inc';

require_once '../../../lib/pdf/dompdf_config.inc.php';



	/*	dompdf-master\src
		use Dompdf\Adapter\CPDF;
use Dompdf\Dompdf;
use Dompdf\Exception; */
//$docx = new CreateDocx();

//$docx->enableCompatibilityMode();
//$docx = new TransformDocAdvOpenOffice();
$text = 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, ' .
    'sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut ' .
    'enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut' .
    'aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit ' .
    'in voluptate velit esse cillum dolore eu fugiat nulla pariatur. ' .
    'Excepteur sint occaecat cupidatat non proident, sunt in culpa qui ' .
    'officia deserunt mollit anim id est laborum.';

$paramsText = array(
    'b' => 'single',
    'font' => 'Arial'
);

//$docx->addText($text, $paramsText);

//$docx->createDocx('example_text8');

//$docx->transformDocument('example_text8.docx', 'example_text25.pdf',null, array('debug' => true,'method' => 'script'));

//require_once 'phpdocx_pro/classes/TransformDoc.inc';
$docx = new TransformDoc();
$docx->setStrFile('1638437_FD_Appeal Sheet.docx');
$docx->generateXHTML();
$html = $docx->getStrXHTML();

//Also, you can export the docx to PDF with

$docx->generatePDF();

//$docx->transformDocxUsingMSWord('example_text1.docx', 'example_text1.pdf')