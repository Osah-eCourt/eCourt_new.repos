<?php
/**
 * Helper
 * 
 * @author
 * @version 
 */
namespace Helper;

use Zend\View\Helper\AbstractHelper;

/**
 * View Helper
 */
class MyHelper extends AbstractHelper
{

    public function __invoke($in)
    {
        // TODO Auto-generated MyHelper::__invoke
        $in="<options>Test your app</options>";
        return $in;
    }
}
