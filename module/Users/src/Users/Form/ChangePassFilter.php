<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Users\Form;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;

/**
 * Description of ChangePassFilter
 *
 * @author nenadpaic
 */
class ChangePassFilter extends InputFilter {
    
    public function __construct() {
      $this->add(array(
            'name' => 'password',
            'required' => true,
            'filters' =>array(
              array('name' => 'StringTrim'),
              array('name' => 'StripTags'),  
            ),
            'validators' => array(
                array(
                'name' => 'StringLength',
                    'options' => array(
                      'encoding' => 'UTF-8',
                        'min'    => 4,
                        'max'    => 20,
                    ),
                ),
                array(
                    'name' => 'Regex',
                    'options' => array(
                       'pattern' => '/^[a-zA-Z0-9_-]*$/',
                       'message' => 'Allowed chars a-z A-Z 0-9 _ -'  
                    ),
                ),
                array(
                  'name' => 'identical',
                    'options' => array(
                      'token' => 'confirm_password',  
                    ),
                ),
             
              
                
                
            ),
            
            
        ));
                 $this->add(array(
            'name' => 'confirm_password',
            'required' => true,
            'filters' =>array(
              array('name' => 'StringTrim'),
              array('name' => 'StripTags'),  
            ),
            'validators' => array(
                array(
                'name' => 'StringLength',
                    'options' => array(
                      'encoding' => 'UTF-8',
                        'min'    => 4,
                        'max'    => 20,
                    ),
                ),
                array(
                    'name' => 'Regex',
                    'options' => array(
                       'pattern' => '/^[a-zA-Z0-9_-]*$/',
                       'message' => 'Allowed chars a-z A-Z 0-9 _ -'  
                    ),
                ),
             
              
                
                
            ),
            
            
        ));
    }
    //put your code here
}
