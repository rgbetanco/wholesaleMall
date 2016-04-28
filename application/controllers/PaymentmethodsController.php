<?php

class PaymentmethodsController extends Zend_Controller_Action {

    public function init() {
        $this->table = new Application_Model_DbTable_PaymentMethods();
    }

    public function indexAction() {
        $form = new Application_Form_PaymentMethods();
        $form->setDecorators(array(array('ViewScript', array('viewScript' => 'paymentMethodsDecorator.phtml'))));

        $request = $this->getRequest();

        if ($request->isPost()) {
            if ($form->isValid($this->_request->getPost())) {
                $this->table->insert(array('name' => $form->getValue('name'), 'extra' => $form->getValue('extra')));
                $this->_redirect('basicsettings/display/tab/paymentMethods');
            } else {
                $this->view->errormessage = 'please fill in the requiered fields';
            }
        }

        $data = $this->table->fetchAll();

        $this->view->data = $data;
        $this->view->form = $form;
    }

    public function deleteAction() {
        $id = $this->_getParam('id');
        $this->table->delete('id = '.$id);
        $this->_redirect('basicsettings/display/tab/paymentMethods');
    }

}
