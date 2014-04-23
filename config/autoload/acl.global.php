<?php

return array(
  'acl' => array(
    'roles' => array(
      'guest' => null,
      'user' => 'guest',
      'admin' => 'user',  
    ),  
      'resources' => array(
        'allow' => array(
            'Users\Controller\Users' =>array(
              'index' => 'admin',
              'update' => 'admin',
              'delete' => 'admin', 
              'register' => 'admin',
              'success' => 'admin',
              'changePassword' => 'admin',
              
              //'all' => 'guest',
            ),
            'Application\Controller\Index' => array(
               'all' => 'guest', 
            ),
            'Auth\Controller\Auth' => array(
                'index' => 'guest',
                'logout' => 'user',
                
                
            ),
            
            
        ),  
      ),
  ),  
);

