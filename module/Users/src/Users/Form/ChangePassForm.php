<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Users\Form;

use Zend\Form\Form;

/**
 * Description of ChangePassForm
 *
 * @author nenadpaic
 */
class ChangePassForm extends Form {
    
    public function __construct() {
        parent::__construct();
        
        
      
          $this->add(array(
           'name' => 'password',
            'type' => 'password',
            'attributes' => array(
                'class' => 'form-control',
                'required' => 'true',
            ),
            'options' => array(
                'label' => 'Novi password',
            ),
        ));
            $this->add(array(
           'name' => 'confirm_password',
            'type' => 'password',
            'attributes' => array(
                'class' => 'form-control',
                'required' => 'true',
            ),
            'options' => array(
                'label' => 'Potvrdi password',
            ),
        ));
          $this->add(array(
       		'type' => 'Zend\Form\Element\Captcha',
       		'name' => 'captcha',
       		'options' => array(
       				'label' => 'Potvrdi da si covek',
       				'captcha' => new \Zend\Captcha\Figlet(),
       		),
       ));
       $this->add(array(
    'type' => 'Zend\Form\Element\Csrf',
    'name' => 'secret',
    'options' => array(
        'csrf_options' => array(
            'timeout' => 600
        )
    )
));
      $this->add(array(
       'name' => 'submit',
       'type' => 'submit',
       'attributes' => array(
         'class' => 'btn btn-primary btn-md',
         'required' => true,
         'Value'    => 'Promeni password'
        
       ),
      
   ));   
    }
}
