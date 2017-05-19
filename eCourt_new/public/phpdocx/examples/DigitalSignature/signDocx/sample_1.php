<?php

require_once '../../../classes/SignDocx.inc';

$sign = new SignDocx();
$sign->setDocx('../../files/Text.docx');
$sign->setPrivateKey('../../files/Test.pem', 'phpdocx_pass');
$sign->setX509Certificate('../../files/Test.pem');
$sign->setSignatureComments('This document has been signed by me');
$sign->sign();