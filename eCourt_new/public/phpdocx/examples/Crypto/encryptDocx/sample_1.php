<?php

require_once '../../../classes/CreateDocx.inc';

$docx = new CryptoPHPDOCX();
$source = '../../files/Text.docx';
$target = 'Crypted.docx';
$docx->encryptDocx($source, $target, array('password' => 'phpdocx'));
