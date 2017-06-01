<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'Osahform\Controller\Osahform' => 'Osahform\Controller\OsahformController',
            'Osahform\Controller\Dds' => 'Osahform\Controller\DdsController',
        ),
    ),
    'router' => array(
        'routes' => array(
            'Osahform' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/Osahform[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                       // 'id'     => '[0-9]+',
                        'id'     => '[a-zA-Z0-9_-]*',
                    ),
                    'defaults' => array(
                        'controller' => 'Osahform\Controller\Osahform',
                        'action'     => 'index',
                    ),
                ),
            ),
            'Dds' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/dds[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Osahform\Controller\Dds',
                        'action'     => 'index',
                    ),
                ),
            ),
        ),
    ),
    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => array(
            'layout/layout'           => __DIR__ . '/../view/layout/layout11.phtml',
            'application/index/index' => __DIR__ . '/../view/Osahform/index/index.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
   
'view_helpers' => array(
'invokables' => array(
 'mySuperViewHelper' => 'Osahform\View\Helper\OsahDbFunctionsAccess',
  'MyHelper' => 'Helper\MyHelper',
  ),
 )

);