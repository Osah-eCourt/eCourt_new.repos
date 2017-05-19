<?php require_once '../../../classes/CreateDocx.inc';

$docx = new CreateDocx();

$docx->enableCompatibilityMode();

$text = 'Lorem ipsum dolor sit amet.';

$docx->addText($text);

$docx->createDocx('example_text333');

$docx->transformDocument('example_text.docx', 'example_text.pdf', null, array('debug' => true));
?>