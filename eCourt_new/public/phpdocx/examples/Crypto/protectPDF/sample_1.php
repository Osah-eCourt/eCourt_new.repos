<?php

require_once '../../../classes/CreateDocx.inc';

$pdf = new CryptoPHPDOCX();
$source = '../../files/Test.pdf';
$target = 'Protected.pdf';
$pdf->protectPDF($source, $target, array('permissionsBlocked' => array('print', 'annot-forms')));