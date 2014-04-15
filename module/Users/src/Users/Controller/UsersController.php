<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonModule for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Users\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Users\Model\User;
use Users\Form\UsersEditForm;
use Users\Form\UsersFilter;
use Zend\View\Model\ViewModel;
use Users\Form\RegisterForm;
use Users\Form\RegisterFilter;
use Zend\Crypt\BlockCipher;
use Zend\Crypt\Symmetric\Mcrypt;
use Zend\Mail\Message;




class UsersController extends AbstractActionController
{
    
 
     
     
     
     
    public function indexAction()
    {
     
                $paginator = new \Zend\Paginator\Paginator(new \Zend\Paginator\Adapter\DbTableGateway($this->getModel()->getUsersTable()));

		$page = 1;
		if ($this->params()->fromRoute('page')) $page = $this->params()->fromRoute('page');
              
		$paginator->setCurrentPageNumber((int)$page);
		$paginator->setItemCountPerPage(10);
		
                
		return new ViewModel(array('paginator' => $paginator));
        
    }

    public function updateAction()
    {
        $id = (int)$this->params()->fromRoute('id');
        if(!$id || $id < 1) $this->redirect ()->toRoute ('users', array('controller' => 'users', 'action' => 'index'));
        $form = new UsersEditForm();
       $request = $this->getRequest();
       if($request->isPost()){
           $form->setInputFilter(new UsersFilter($this->getServiceLocator()) );
           $form->setData($request->getPost());
           
           if($form->isValid()){
               
               $data = $form->getData();
               unset($data['submit']);
               
               $this->getModel()->getUsersTable()->update($data, array('id' => $id));
               
               return $this->redirect()->toRoute('users/default', array('controoler' => 'users', 'action' => 'index'));
               
           }
           
       }else{
           $form->setData($this->getModel()->getUsersTable()->select(array('id' => $id))->current());
       }
        return new ViewModel(array('form' => $form, 'id' => $id));
    }
    
        
    public function deleteAction(){
        
        $id = (int) $this->params()->fromRoute('id');
        if(!$id || $id < 1) $this->redirect ()->toRoute ('users');
        $this->getModel()->getUsersTable()->delete(array('id' => $id));
        
       return $this->redirect()->toRoute('users/default', array('controoler' => 'users', 'action' => 'index'));  
    }
    public function registerAction(){
         
     
        $form = new RegisterForm();
        
        $request = $this->getRequest();
      
        if($request->isPost()){
            $sm = $this->getServiceLocator();
            $adapter = $sm->get('Zend\Db\Adapter\Adapter');
            $form->setInputFilter(new RegisterFilter($adapter, $sm));
            $form->setData($request->getPost());
            if($form->isValid()){
                $data = $form->getData();
               $data['reg_token'] = md5(uniqid(rand(), TRUE));
               $data['role'] = 'user';
               $data['active'] = 0;
               $data['date_created'] = date('Y-m-d H:i:s');
               unset($data['submit']);
               unset($data['confirm']);
               $config = $sm->get('Config');
               $salt = $config['static_salt'];


                $blockCipher = new BlockCipher(new Mcrypt(array('algo' => 'aes')));
                $blockCipher->setKey($salt);
                $data['password'] = $blockCipher->encrypt($data['password']);
                $this->getModel()->getUsersTable()->insert($data);
                $user = $this->getModel()->getUsersTable()->select(array('username' => $data['username']))->current();
               
                
                
                $nas_mail = $config['email_nas'];
                $site = $config['site_name'];
                
                
                $transport = $this->getServiceLocator()->get('mail.transport');
                 
                $message =  new Message();
                
                $this->getRequest()->getServer();
                
                $message->addFrom($nas_mail)
                        ->addTo($user->email)
                        ->setSubject("Registracija na". $site)
                        ->setBody("Kliknite na link kako bi ste dovrsili registraciju na web sajtu popusti => " . 
					$this->getRequest()->getServer('HTTP_ORIGIN') .
					$this->url()->fromRoute('users/default', array(
						'controller' => 'users', 
						'action' => 'confirmEmail', 
						'id' => $user->reg_token)));
                
                $transport->send($message);
                
              return $this->redirect()->toRoute('users/default', array('controller' => 'users', 'action' => 'success'));
                
                
               
               
                
            }
        }
        
        
        return new ViewModel(array('form' => $form));
        
    }
    
    public function confirmEmailAction(){
    	
    	$token = $this->params()->fromRoute('id');
    	$view = new ViewModel();
    	
    	
    		$user = $this->getModel()->getUserByToken($token);
    		if($user == false){
    			return $this->redirect()->toRoute('users/default', array('controller' => 'users', 'action' => 'errorConfirm'));
    			exit();
    		}
    		if($user->active == 1){
    			return $this->redirect()->toRoute('users/default', array('controller' => 'users', 'action' => 'errorConfirm'));
    			exit();
    		}
    			
    		
    		$user_id = $user->id;
    		
    		$this->getModel()->activateUser($user_id);
    		
    	
    	
    	return $view;
    	
    }
    public function successAction(){
        
        return new ViewModel();
    }
    
    public function getModel(){
        
        $sm = $this->getServiceLocator();
         $adapter = $sm->get('Zend\Db\Adapter\Adapter');
        $model= new User($adapter);
        
        return $model;
        
        
    }
    public function errorConfirmAction(){
    	return new ViewModel();
    }
    public function forgotenPasswordAction(){
    	$form = "form";
    }
}

