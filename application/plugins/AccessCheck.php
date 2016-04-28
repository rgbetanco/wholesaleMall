<?php
Class Application_Plugin_AccessCheck extends Zend_Controller_Plugin_Abstract {

	private $_acl = null;

	public function __construct(Zend_Acl $acl){
		$this->_acl = $acl;
	}

	public function preDispatch(Zend_Controller_Request_Abstract $request){
		//this two variables are the name of the controller and the action the user is asking to access
		$resource = $request->getControllerName();
		$action = $request->getActionName();
	
		//check whether the user is allow to access the request
		
		if (!$this->_acl->isAllowed(Zend_Registry::get('role'), $resource, $action)) {
			$request->setControllerName('authentication')
					->setActionName('login');			//redirect to login if not allowed
		}
	}
}