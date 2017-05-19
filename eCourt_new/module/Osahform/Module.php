<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/Osahform for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Osahform;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Osahform\Model\itemsTable;
use Zend\Db\ResultSet\ResultSet;
use Osahform\Model\items;

class Module implements AutoloaderProviderInterface
{
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
		    // if we're in a namespace deeper than one level we need to fix the \ in the path
                    __NAMESPACE__ => __DIR__ . '/src/' . str_replace('\\', '/' , __NAMESPACE__),
                	'PHPWord' => __DIR__ . '/../../vendor/PHPWord',
                	 'PHPWord_DocumentProperties' => __DIR__ . '/../../vendor/PHPWord/PHPWord',
                	  'PHPWord_IOFactory' => __DIR__ . '/../../vendor/PHPWord',
                ),
            ),
        );
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function onBootstrap(MvcEvent $e)
    {
        // You may not need to do this if you're doing it elsewhere in your
        // application
        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
     }
    
   
     public function getViewHelperConfig()   {
        /* return array(
         		'invokables' => array(
         				'mySuperViewHelper' => 'Osahform\View\Helper\OsahDbFunctionsAccess',
         		)
         ); */
     	
     /*	return array(
     			'helpers' => array(
     					'factories' => array(
     							'config' => function ($sm) {
     								return new \Application\View\Helper\OsahDbFunctionsAccess(
     										$sm->getServiceLocator()->get('Application\Config')->get('config')
     								);
     							},
     					),
     					),
     			);
     	*/
     }
    
public function getServiceConfig()
    {
      return array();
    }
}
