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
use Zend\View\Model\ViewModel;



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
        $id = $this->params()->fromRoute('id');
        if(!$id) $this->redirect ()->toRoute ('users', array('controller' => 'users', 'action' => 'index'));
        $form = new UsersEditForm();
       $request = $this->getRequest();
       if($request->isPost()){
           
       }else{
           $form->setData($this->getModel()->getUsersTable()->select(array('id' => $id))->current());
       }
        return new ViewModel(array('form' => $form, 'id' => $id));
    }
    
        
    public function deleteAction(){
        return array();
    }
    public function getModel(){
        
        $sm = $this->getServiceLocator();
         $adapter = $sm->get('Zend\Db\Adapter\Adapter');
        $model= new User($adapter);
        
        return $model;
        
        
    }
}
