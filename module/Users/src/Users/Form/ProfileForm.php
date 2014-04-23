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
class ProfileForm extends Form {
    private $userData;
    public function __construct($userData) {
    	$this->userData = $userData;
        parent::__construct();
        
   
   $this->add(array(
       'name' => 'ime',
       'type' => 'text',

       'attributes' => array(
         'class' => 'form-control',
         'required' => true,
         'value' => $this->userData->ime,
       ),
       'options' => array(
         'label' => 'Ime:', 
       ),
   ));
     $this->add(array(
       'name' => 'prezime',
       'type' => 'text',
       'attributes' => array(
         'class' => 'form-control',
         'required' => true,
         'value' => $this->userData->prezime,
       ),
       'options' => array(
         'label' => 'Prezime:', 
       ),
   ));

       $this->add(array(
       'name' => 'adresa',
       'type' => 'text',
       'attributes' => array(
         'class' => 'form-control',
         'required' => true,
         'value' => $this->userData->adresa,
       ),
       'options' => array(
         'label' => 'Adresa:', 
       ),
   ));
    $this->add(array(
       'name' => 'grad',
       'type' => 'text',
       'attributes' => array(
         'class' => 'form-control',
         'required' => true,
         'value' => $this->userData->grad,
       ),
       'options' => array(
         'label' => 'Grad:', 
       ),
   ));
     $this->add(array(
       'name' => 'zip',
       'type' => 'text',
       'attributes' => array(
         'class' => 'form-control',
         'required' => true,
         'value' => $this->userData->zip,
       ),
       'options' => array(
         'label' => 'Zip:', 
       ),
   ));
       $this->add(array(
       'name' => 'tel',
       'type' => 'text',
       'attributes' => array(
         'class' => 'form-control',
         'required' => true,
         'value' => $this->userData->tel,
       ),
       'options' => array(
         'label' => 'Tel:', 
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
         'Value'    => 'Edit'
        
       ),
      
   ));
        }
  }