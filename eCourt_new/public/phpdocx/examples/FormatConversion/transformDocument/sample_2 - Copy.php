<?php
require_once '../../../classes/CreateDocx.inc';

$docx = new CreateDocx();

$docx->enableCompatibilityMode();

$text = 'Lorem ipsum dolor sit amet.';

$docx->addText($text);

$docx->createDocx('example_text889');
//$docx = new TransformDocAdvLibreOffice();
$docx->transformDocument('example_text88.docx', 'example_text88.pdf', null, array('debug' => true));
