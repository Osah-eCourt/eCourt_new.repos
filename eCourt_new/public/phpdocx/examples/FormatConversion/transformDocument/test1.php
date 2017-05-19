<?php // We instantiate the CreateDocx class in a new object

require_once '../../../classes/CreateDocx.inc';

$docx = new CreateDocx();

// Enable the compatibility mode to allow the library to warn us in case of using non-compatible content

$docx->enableCompatibilityMode();

// Add a text to the document

$text = 'Lorem ipsum dolor sit amet, consectetur adipisicing elit';

$docx->addText($text, $paramsText);

// Generate the new document

$docx->createDocx('test12.docx');

// And make the transformation to PDF file

$docx->transformDocument('test12.docx', 'test12.pdf');