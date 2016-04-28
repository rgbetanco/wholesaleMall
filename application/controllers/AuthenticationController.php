<?php

class AuthenticationController extends Zend_Controller_Action {

    public function init() {
        $banners = new Application_Model_DbTable_Banners();
        $this->view->banners = $banners->fetchAll();

        //  $cat = new Application_Model_DbTable_Categories();
        //  $this->view->categories = $cat->fetchAll();
    }

    public function indexAction() {
        
    }

    public function loginAction() {
        //check if user is already login
        if (Zend_Auth::getInstance()->hasIdentity()) {
            $this->_redirect('index/index');
        }
        //get request type        
        $form = new Application_Form_Login();
        $form->setDecorators(array(array('ViewScript', array('viewScript' => 'loginDecorator.phtml'))));
        $request = $this->getRequest();
        
        $mdl_register = new Application_Model_Register();
        if ($request->isPost()) {
            if (!empty($_POST['Login'])) {
                if ($form->isValid($this->_request->getPost())) {
                    $authAdapter = $this->getAuthAdapter();

                    $username = $form->getValue('username');
                    $password = $form->getValue('password');
                    //check if customer is enabled on register table before setting credentials
                    if ($mdl_register->isRegEnabled($username)){

                        $authAdapter->setIdentity($username)
                                ->setCredential($password);
                        $auth = Zend_Auth::getInstance();
                        $result = $auth->authenticate($authAdapter);

                        if ($result->isValid()) {
                            $identity = $authAdapter->getResultRowObject();
                            $authStorage = $auth->getStorage();  //session
                            $authStorage->write($identity);      //write to session

                            $this->_redirect('index/index');
                        } else {
                            $this->view->errorMessage = "User name or passworld is not valid";
                        }

                    } else {
                        $this->view->errorMessage = "User has not been activated by our staff, sorry for any inconvenience";
                    }
                }
            }
        }
        //if user is not login
        $this->view->form = $form;
    }

    public function forgotpswdAction(){
        $tbl_register = new Application_Model_DbTable_Register();
        $mdl_authentication = new Application_Model_Authentication();

        if ($_POST['forgot_email'] != '') {
            $customer = $tbl_register->fetchRow($tbl_register->select()->where('email = ?', $_POST['forgot_email']));
            if($customer->email != ''){
                $mdl_authentication->sendPassword('Password Sent',$customer->email);
                $this->view->message = "An email with your password has been sent successfully";
            } else {
                $this->view->message = "Error, please check your email address or contact us at info@dogopet.com";
            }
        } else {
            $this->view->message = "Error, please enter an email address or contact us at info@dogopet.com";
        }
    }

    public function logoutAction() {
        // erase session
        Zend_Auth::getInstance()->clearIdentity();
        $this->_redirect('index/index');
    }

    private function getAuthAdapter() {
        $authAdapter = new Zend_Auth_Adapter_DbTable(Zend_Db_Table::getDefaultAdapter());
        $authAdapter->setTableName('users')
                ->setIdentityColumn('username')
                ->setCredentialColumn('password')
                ->setCredentialTreatment('MD5(?)');
        return $authAdapter;
    }

    public function changepassAction() {
        // action body
    }

    public function changepswdAction() {
        $form = new Application_Form_Changepswd();
        $form->setDecorators(array(array('ViewScript', array('viewScript'=>'changepswdDecorator.phtml'))));

        $request = $this->getRequest();
        if($request->isPost()){
            if($form->isValid($this->_request->getPost())){
                 $chpswd = new Application_Model_Register();
                 $chpswd->changePswd($form->getValue('confirm_pswd'));
                $this->view->message = "Password changed successfully";   
            } else {
                $this->view->message = "Operation fail, please try again";
            }
            
        }

        $this->view->form = $form;
    }
}