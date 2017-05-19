<?php
//require_once '../../../classes/CreateDocx.inc';

//$docx = new CreateDocx();

//$docx->enableCompatibilityMode();

//$text = 'Lorem ipsum dolor sit amet.';

//$docx->addText($text);
//$docx->createDocx('C:/test');
//$docx->createDocx('C:/Program Files (x86)/zend/Apache2/htdocs/osahcms/public/example_text88912234');
//$docx = new TransformDocAdvLibreOffice();
//$docx->transformDocument('example_text88.docx', 'example_text88.pdf', null, array('debug' => true, 'method'=> 'script'));
//passthru('C:/Program Files (x86)/zend/Apache2/htdocs/osahcms/public/OfficeToPDF.exe example_text889122.docx example_text889122.pdf');
//passthru("OfficeToPDF 'C:/Program Files (x86)/zend/Apache2/htdocs/osahcms/public/example_textgire.docx' 'C:/Program Files (x86)/zend/Apache2/htdocs/osahcms/public/example_textgire.pdf'");

$filename="test.docx";

//$filename=str_replace(' ', '%20', $filename);
$filename1="test1212.pdf";
exec('c:/iti/pdf/OfficeToPDF.exe ' . '"C:/iti/' . $filename .'" ' . '"C:/iti/' . $filename1 . '"');
