<?php

class RegisterController extends Zend_Controller_Action {

    public function init() {
        
    }

    public function indexAction() {
        
    }

    public function addAction() {
//        echo "Record Successfully Added";
    }

    public function adminaddAction(){
        $request = $this->getRequest();
        if($request->isPost()){
            $addReg = new Application_Model_Register();
            if(!$addReg->addNewReg(array(
                    'company' => $_POST['company'],
                    'company_type' => $_POST['company_type'],
                    'first_name' => $_POST['first_name'],
                    'last_name' => $_POST['last_name'],
                    'title' => $_POST['title'],
                    'address' => $_POST['address'],
                    'address_2' => $_POST['address2'],
                    'city' => $_POST['city'],
                    'state' => $_POST['states'],
                    'zip' => $_POST['zip'],
                    'country' => $_POST['country'],
                    'email' => $_POST['email'],
                    'phone' => $_POST['phone'],
                    'fax' => $_POST['fax'],
                    'website' => $_POST['website'],
                    'tax_id' => $_POST['tax_id'],
                    'status' => 'active',
                    'spam' => 1,
                    'created' => date('Y-m-d H:i:s')
                ))){
                $this->view->errorMessage = "Error adding customer, make sure you are using a unique email account";
            } else {
                $this->view->errorMessage = "Success adding customer";
            }
        }
    }

    public function registerAction() {
        $form_reg = new Application_Form_Register();
        $form_reg->setDecorators(array(array('ViewScript', array('viewScript' => 'registerDecorator.phtml'))));
        $request = $this->getRequest();
        if ($request->isPost()) {
            if ($form_reg->isValid($this->_request->getPost())) {
                $addReg = new Application_Model_Register();
                $country = 'United States';
                if ($form_reg->getValue('country') != 'United States') {
                    $country = $form_reg->getValue('other_country');
                }
                if(!$addReg->addNewReg(array(
                    'company' => $form_reg->getValue('company'),
                    'company_type' => $form_reg->getValue('company_type'),
                    'first_name' => $form_reg->getValue('first_name'),
                    'last_name' => $form_reg->getValue('last_name'),
                    'title' => $form_reg->getValue('title'),
                    'address' => $form_reg->getValue('address'),
                    'address_2' => $form_reg->getValue('address2'),
                    'city' => $form_reg->getValue('city'),
                    'state' => $form_reg->getValue('state'),
                    'zip' => $form_reg->getValue('zip'),
                    'country' => $country,
                    'email' => $form_reg->getValue('email'),
                    'phone' => $form_reg->getValue('phone'),
                    'fax' => $form_reg->getValue('fax'),
                    'website' => $form_reg->getValue('website'),
                    'tax_id' => $form_reg->getValue('tax_id'),
                    'status' => 'disabled',
                    'spam' => 1,
                    'created' => date('Y-m-d H:i:s')
                    )))
                {
                    $this->view->errorMessage = "Error adding customer, make sure you are using a unique email account";
                } else {
                    $this->_redirect('register/add');
                }
            } else {
                $this->view->errorMessage = "Please Fill in the Requiered Fields";
            }
        }
        $this->view->form_reg = $form_reg;
    }

    public function listAction() {
        Zend_View_Helper_PaginationControl::setDefaultViewPartial('pagecontrol.phtml');
        $session_register = new Zend_Session_Namespace('register');
        $sort = $this->_request->getParam('sort');

        $table = new Application_Model_DbTable_Register();
        $info = $this->_getParam('search');
        if ($info) {
            $data = $table->fetchAll($table->select()->where('company LIKE ? OR
                                                                                             first_name LIKE ? OR
                                                                                             last_name LIKE ? OR 
                                                                                             email LIKE ? OR 
                                                                                             status LIKE ?', '%' . $info . '%', '%' . $info . '%', '%' . $info . '%', '%' . $info . '%', '%' . $info . '%'));
        } else {
            if ($sort) {
                if (!isset($session_register->sort)) {
                    $session_register->sort = 0;
                }

                if ($session_register->sort > 0) {
                    $session_register->sort = 0;
                    $data = $table->fetchAll($table->select()->order($sort . ' DESC'));
                } else {
                    $session_register->sort = 1;
                    $data = $table->fetchAll($table->select()->order($sort . ' ASC'));
                }
            } else {
                $data = $table->fetchAll();
            }
        }
        $paginator = Zend_Paginator::factory($data);
        $paginator->setCurrentPageNumber($this->_getParam('page', 1));
        $paginator->setItemCountPerPage(50);
        $this->view->page = $this->_getParam('page');
        $this->view->customers = $paginator;
    }

    public function searchAction() {
        
    }

    public function updateminAction() {
        $registerTbl = new Application_Model_DbTable_Register();

        $page = $this->_request->getParam('page');

        $id = $this->_request->getParam('id');
        $company = $this->_request->getParam('company');
        $email = $this->_request->getParam('email');
        $status = $this->_request->getParam('status');
        $delete = $this->_request->getParam('delete');

        foreach ($id as $k => $id) {
            $registerTbl->update(array('company' => $company[$k]), array('id=' . $id));
            $registerTbl->update(array('email' => $email[$k]), array('id=' . $id));
            $registerTbl->update(array('status' => $status[$k]), array('id=' . $id));

            if (in_array($id, $delete)) {
                $registerTbl->delete(array('id=' . $id));
            }
        }

        if (!$page) {
            $this->_redirect('register/list');
        } else {
            $this->_redirect('register/list/page/' . $page);
        }
    }

    public function editregisterAction() {
        $id = $this->_request->getParam('id');
        $registerTbl = new Application_Model_DbTable_Register();
        $data = $registerTbl->find($id);

        $this->view->id = $id;

        foreach ($data as $dat) {
            $company = $dat['company'];
            $company_type = $dat['company_type'];
            $first_name = $dat['first_name'];
            $last_name = $dat['last_name'];
            $title = $dat['title'];
            $address = $dat['address'];
            $city = $dat['city'];
            $state = $dat['state'];
            $zip = $dat['zip'];
            $country = $dat['country'];
            $email = $dat['email'];
            $phone = $dat['phone'];
            $fax = $dat['fax'];
            $website = $dat['website'];
            $tax = $dat['tax_id'];
            $spam = $dat['spam'];
        }

        $form_reg = new Application_Form_Registeradmin();
        $form_reg->setDecorators(array(array('ViewScript', array('viewScript' => 'registeradminDecorator.phtml'))));
        $form_reg->getElement('company')->setValue($company);
        $form_reg->getElement('company_type')->setValue($company_type);
        $form_reg->getElement('first_name')->setValue($first_name);
        $form_reg->getElement('last_name')->setValue($last_name);
        $form_reg->getElement('title')->setValue($title);
        $form_reg->getElement('address')->setValue($address);
        $form_reg->getElement('city')->setValue($city);
        $form_reg->getElement('state')->setValue($state);
        $form_reg->getElement('zip')->setValue($zip);
        $form_reg->getElement('country')->setValue($country);
        $form_reg->getElement('email')->setValue($email);
        $form_reg->getElement('phone')->setValue($phone);
        $form_reg->getElement('fax')->setValue($fax);
        $form_reg->getElement('website')->setValue($website);
        $form_reg->getElement('tax_id')->setValue($tax);
        $form_reg->getElement('spam')->setValue($spam);

        $request = $this->getRequest();
        if ($request->isPost()) {
            if ($form_reg->isValid($this->_request->getPost())) {
                $updateReg = new Application_Model_Register();
                $updateReg->updateReg(array(
                    'company' => $form_reg->getValue('company'),
                    'company_type' => $form_reg->getValue('company_type'),
                    'first_name' => $form_reg->getValue('first_name'),
                    'last_name' => $form_reg->getValue('last_name'),
                    'title' => $form_reg->getValue('title'),
                    'address' => $form_reg->getValue('address'),
                    'city' => $form_reg->getValue('city'),
                    'state' => $form_reg->getValue('state'),
                    'zip' => $form_reg->getValue('zip'),
                    'country' => $form_reg->getValue('country'),
                    'email' => $form_reg->getValue('email'),
                    'phone' => $form_reg->getValue('phone'),
                    'fax' => $form_reg->getValue('fax'),
                    'website' => $form_reg->getValue('website'),
                    'tax_id' => $form_reg->getValue('tax_id'),
                    'spam' => $form_reg->getValue('spam'),
                        ), $id);
                $this->_redirect('register/detail/reg_id/'.$id.'/tab/edit');
            } else {
                $this->view->errorMessage = "Please Fill in the Requiered Fields";
            }
        }
        $this->view->form_reg = $form_reg;
    }

    public function sendmailAction() {
        $id = $this->_request->getParam('reg_id');

        $form = new Application_Form_Email();
        $form->setDecorators(array(array('ViewScript', array('viewScript' => 'emailDecorator.phtml'))));

        $request = $this->getRequest();
        if ($request->isPost()) {
            if ($form->isValid($this->_request->getPost())) {
                $sendmail = new Application_Model_Register();
                if ($sendmail->sendmailReg(array(
                            'subject' => $form->getValue('subject'),
                            'description' => $form->getValue('description'),
                                ), $id)) {
                    $this->_redirect('register/detail/reg_id/'.$id.'/tab/message');
                    $this->view->sent = "Message Sent Successfully";
                } else {
                    $this->view->sent = "Message Not Sent, Please Try Again Later";
                }
            } else {
                $this->view->errorMessage = "Please Fill in the Requiered Fields";
            }
        }

        $this->view->form = $form;
    }

    public function changepasswordAction(){
        $mdl_reg = new Application_Model_Register();

        $id = $this->_request->getParam('reg_id');
        $success = $this->_request->getParam('success');

        $this->view->id = $id;
        $this->view->success = $success;
        
        $request = $this->getRequest();
        if ($request->isPost()) {
            if($mdl_reg->adminChangePassword($id, $_POST['pass1'])){
                $this->_redirect('register/detail/reg_id/'.$id.'/tab/password/success/true');
            } else {
                $this->_redirect('register/detail/reg_id/'.$id.'/tab/password/success/false');
            }
            
        }
    }

    public function activateAction() {
        $email = $this->_request->getParam('email');
        $table = new Application_Model_DbTable_Users();
        if ($email) {
            $where = $table->getAdapter()->quoteInto('username = ?', str_replace('_', '@', $email));
            $table->update(array('type' => 'member'), $where);
            $this->view->message = "The account was successfully activated";
        } else {
            $this->view->message = "Something went wrong, please contact administrator";
        }
    }

    public function detailAction() {
        $reg_id = $this->_request->getParam('reg_id');
        $tab = $this->_request->getParam('tab');
        $pages = $this->_request->getParam('pages');
        $paged = $this->_request->getParam('paged');
        $success = $this->_request->getParam('success');
        if(!$tab){$tab = 'edit';}
        if(!$pages){$pages = 1;}
        if(!$paged){$paged = 1;}
        if(!$success){$success = null;}
        
        $this->view->reg_id = $reg_id;
        $this->view->tab = $tab;
        $this->view->pages = $pages;
        $this->view->paged = $paged;   
        $this->view->success = $success;   
    }
}