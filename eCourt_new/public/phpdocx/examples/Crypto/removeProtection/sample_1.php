<?php

require_once '../../../classes/CreateDocx.inc';

$docx = new CryptoPHPDOCX();
$source = '../../files/protectedDocument.docx';
$target = 'unprotected.docx';
$docx->removeProtection($source, $target);
