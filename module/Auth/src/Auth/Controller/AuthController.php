<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonModule for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Auth\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Auth\Form\LoginForm;
use Auth\Form\LoginFilter;

use Zend\Authentication\Result;
use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Storage\Session as SessionStorage;
use Zend\Crypt\BlockCipher;
use Zend\Crypt\Symmetric\Mcrypt;

use Zend\Db\Adapter\Adapter as DbAdapter;

use Zend\Authentication\Adapter\DbTable as AuthAdapter;

class AuthController extends AbstractActionController
{
    public function indexAction()
    {       
       $auth = new AuthenticationService();
       if($auth->hasIdentity()){
           $this->redirect()->toRoute('auth/default', array('controller' => 'auth', 'action' => 'profile'));
       }
       
        $form = new LoginForm();
        $messages = null;
        
        $request = $this->getRequest();
        
        if($request->isPost()){
           
           $form->setInputFilter(new LoginFilter($this->getServiceLocator()));
           $form->setData($request->getPost());
           
           if($form->isValid()){
               $data = $form->getData();
               $sm = $this->getServiceLocator();
               $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
               $config = $sm->get('Config');
               $salt = $config['static_salt'];
               $data['password'] = md5($salt).sha1($data['password']);
               
              
               
               
               
               
               
               $authAdapter = new AuthAdapter($dbAdapter,
                       'users',
                       'username',
                       'password',
                       "SHA1(?) AND active = 1"
                      
                       
                       
                      );
               $authAdapter->setIdentity($data['username'])
                            ->setCredential($data['password']);
               $auth = new AuthenticationService();
               $result = $auth->authenticate($authAdapter);
               
               switch ($result->getCode()) {
					case Result::FAILURE_IDENTITY_NOT_FOUND:
						//
                                            
						break;

					case Result::FAILURE_CREDENTIAL_INVALID:
						// 
						break;

					case Result::SUCCESS:
						$storage = $auth->getStorage();
						$storage->write($authAdapter->getResultRowObject(
							null,
                                                        
							'password',
                                                        'role'
                                                      
						));
                                                
                                                
                                            
						$time = 1209600; // 14 days 1209600/3600 = 336 hours => 336/24 = 14 days
//						
						$this->redirect()->toRoute('auth/default', array('controller' => 'auth', 'action' => 'profile'));
						break;

					default:
						
						break;
				}
                                foreach ($result->getMessages() as $message) {
					$messages .= "$message\n";
                               } 
           }
        }
        return array(
            'form' => $form,
            'messages' => $messages
        );
    }

    public function logoutAction()
	{
		$auth = new AuthenticationService();
		

		if ($auth->hasIdentity()) {
			$identity = $auth->getIdentity();
		}			

		$auth->clearIdentity();


		return $this->redirect()->toRoute('auth/default', array('controller' => 'auth', 'action' => 'index'));		
	}
     private function encPass($pass){
	                $sm = $this->getServiceLocator();
                    
                    


                $blockCipher = new BlockCipher(new Mcrypt(array('algo' => 'aes')));
                $blockCipher->setKey($salt);
                $password = $blockCipher->encrypt($pass);
                return $password;
	}


}
