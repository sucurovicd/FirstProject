<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Users\Model;

use Zend\Db\TableGateway\TableGateway;


/**
 * Description of User
 *
 * @author nenadpaic
 */
class User {
    
    private $_usersTable;
    private $adapter;
    
    public function __construct($adapter) {
        $this->adapter = $adapter;
    }
    public function getUsersTable(){
        
    
       
        if(!$this->_usersTable){
            $this->_usersTable = new TableGateway(
                    'users',
                    $this->adapter
                    );
        }
        
       return $this->_usersTable;
    }
    
    public function getAllUsers(){
        
        $users = $this->getUsersTable()->select();
        return $users;
    }
}
