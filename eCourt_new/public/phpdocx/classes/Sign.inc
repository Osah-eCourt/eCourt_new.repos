<?php

/**
 * Sign a PDF file
 *
 * @category   Phpdocx
 * @package    sign
 * @copyright  Copyright (c) Narcea Producciones Multimedia S.L.
 *             (http://www.2mdc.com)
 * @license    http://www.phpdocx.com/wp-content/themes/lightword/pro_license.php
 * @version    2014.04.09
 * @link       http://www.phpdocx.com
 */
require_once dirname(__FILE__) . '/../lib/pdf/tcpdf/tcpdf.php';
require_once dirname(__FILE__) . '/../lib/fpdi/fpdi.php';
require_once dirname(__FILE__) . '/../lib/phpseclib/Math/BigInteger.php';
require_once dirname(__FILE__) . '/../lib/phpseclib/Crypt/Random.php';
require_once dirname(__FILE__) . '/../lib/phpseclib/Crypt/Hash.php';
require_once dirname(__FILE__) . '/../lib/phpseclib/Crypt/TripleDES.php';
require_once dirname(__FILE__) . '/../lib/phpseclib/Crypt/RSA.php';

interface Sign
{

    /**
     * Setter $_privatekey
     */
    public function setPrivateKey($file, $password = null);

    /**
     * Setter $_x509Certificate
     */
    public function setX509Certificate($file);
}
