<?php

require_once '../../../classes/CreateDocx.inc';

$pdf = new CryptoPHPDOCX();
$source = '../../files/Test.pdf';
$target = 'Crypted.pdf';
$pdf->encryptPDF($source, $target, array('password' => 'phpdocx'));