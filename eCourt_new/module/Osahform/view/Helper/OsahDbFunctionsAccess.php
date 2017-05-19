<?php
/**
 * osahform\osahform
 * 
 * @author
 * @version 
 */
namespace Osahform\View\Helper;

use Osahform\Model\OsahDbFunctions;
use Zend\View\Helper\AbstractHelper;
;


/**
 * View Helper
 */
class OsahDbFunctionsAccess extends AbstractHelper
{

    public function __invoke()
    {
        // TODO Auto-generated OsahDbFunctionsAccess::__invoke
        
     //   $dbop=new OsahDbFunctions();
        $agencylist="<option>test</option>";
       // $agencylist=$dbop->getAgencyCode();
        return $agencylist;
    }
}
