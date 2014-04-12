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
 * Description of UsersFilter
 *
 * @author nenadpaic
 */
class UsersFilter extends InputFilter {
  
    public function __construct() {
        
        $this->add(array(
            'name' => 'username',
            'required' => true,
            'filters' =>array(
              array('name' => 'StringTrim'),
              array('name' => 'StripTags'),  
            ),
            'validators' => array(
                array(
                'name' => 'StringLength',
                    'options' => array(
                      'encoding' => 'UTF' 
                    ),
                ),
                
                
            ),
            
            
        ));
    }
}
