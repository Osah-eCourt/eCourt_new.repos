<?php

require_once '../../../classes/CreateDocx.inc';

$docx = new CryptoPHPDOCX();
$source = '../../files/Text.docx';
$target = 'Protected.docx';
$docx->protectDocx($source, $target, array('password' => 'phpdocx'));