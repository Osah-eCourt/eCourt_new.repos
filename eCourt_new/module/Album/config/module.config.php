<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'Album\Controller\Album' => 'Album\Controller\AlbumController',
        ),
    ),
    'router' => array(
    		'routes' => array(
    				'album' => array(
    						'type'    => 'segment',
    						'options' => array(
    								'route'    => '/album[/:action][/:id]',
    								'constraints' => array(
    										'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
    										'id'     => '[0-9]+',
    								),
    								'defaults' => array(
    										'controller' => 'Album\Controller\Album',
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
    		    'layout/layout'           => __DIR__ . '/../view/layout/layout1.phtml',    	
    		),
    		'template_path_stack' => array(
    				__DIR__ . '/../view',
    		),
    ),
    
    'view_manager' => array(
        'template_path_stack' => array(
            'album' => __DIR__ . '/../view',
        ),
    ),
);
