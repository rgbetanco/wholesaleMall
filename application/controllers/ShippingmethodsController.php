<?php

class ShippingmethodsController extends Zend_Controller_Action {

    public function init() {
        $this->table = new Application_Model_DbTable_ShippingMethods();
    }

    public function indexAction() {
        $form = new Application_Form_ShippingMethods();
        $form->setDecorators(array(array('ViewScript', array('viewScript' => 'shippingMethodsDecorator.phtml'))));
        
        $request = $this->getRequest();
        if($request->isPost()){
            if($form->isValid($this->_request->getPost())){
                $this->table->insert(array('name'=>$form->getValue('name'), 'url'=>$form->getValue('url')));
                $this->_redirect('basicsettings/display/tab/shippingMethods');
            } else {
                $this->view->errormessage = 'Please fill up the requiered fields';
            }         
        }
   
        $this->view->form = $form;
        $data = $this->table->fetchAll();
        $this->view->data = $data;

    }

    public function deleteAction() {
        $id = $this->_getParam('id');
        $this->table->delete('id = '.$id);
        $this->_redirect('basicsettings/display/tab/shippingMethods');
    }
}
