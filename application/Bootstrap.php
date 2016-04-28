<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
	private $_acl = null;
	//ACL part
	protected function _initAutoload(){
		$fc = Zend_Controller_Front::getInstance();

		$this->_acl = new Application_Model_LibraryAcl;

		if(Zend_Auth::getInstance()->hasIdentity()){
                    Zend_Registry::set('role',Zend_Auth::getInstance()->getStorage()->read()->type);
		} else {
                    Zend_Registry::set('role','guest'); 
		}

		$fc->registerPlugin(new Application_Plugin_AccessCheck($this->_acl));
	}

	protected function _initPlaceholders(){
		$this->bootstrap('layout');
		$layout = $this->getResource('layout');
		$view = $layout->getView();
		//JQuery 		//$view = new Zend_View();
		$view->addHelperPath("ZendX/JQuery/View/Helper", "ZendX_JQuery_View_Helper");
		$view->addHelperPath("Views/Helpers","Views_Helpers");//just for testing
                $view->jQuery()->enable();
                $view->jQuery()->addStylesheet('http://ajax.googleapis.com/ajax/libs/jqueryui/1.7/themes/smoothness/jquery-ui.css');
                $view->jQuery()->uiEnable();
		$viewRenderer = new Zend_Controller_Action_Helper_ViewRenderer();
		$viewRenderer->setView($view);
		Zend_Controller_Action_HelperBroker::addHelper($viewRenderer);
		//end jquery

		$view->doctype('HTML4_STRICT');

		$view->headTitle('');

		$navContainerConfig = new Zend_Config_Xml(APPLICATION_PATH.'/configs/navigation.xml','nav');
		$navContainer = new Zend_Navigation($navContainerConfig);

		$view->navigation($navContainer)->setAcl($this->_acl)->setRole(Zend_Registry::get('role'));

	}
        
        protected function _initMail()
        {
            try {
                $config = array(
                    'auth' => 'login',
                    'username' => 'dogo@nicaraodev.com',
                    'password' => 'Iron164sag6521',   
                    'port'=>26
                );

                $mailTransport = new Zend_Mail_Transport_Smtp('mail.nicaraodev.com', $config);
                Zend_Mail::setDefaultTransport($mailTransport);
            } catch (Zend_Exception $e){
                //Do something with exception
            }
        }

        protected function _initAppAutoload()
        {
                $autoloader = new Zend_Application_Module_Autoloader(array(
                        'namespace' => '',
                        'basePath' => dirname(__FILE__),
                ));

                return $autoloader;
        }
}