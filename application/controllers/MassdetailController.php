<?php

class MassdetailController extends Zend_Controller_Action {

    public function init() {
        $this->table = new Application_Model_DbTable_MassDetail();
    }

    public function indexAction() {
        // action body
    }

    public function addAction() {
        $id = $this->_request->getParam('mass_id');
        $this->view->id = $id;
        $pro_id = $this->_request->getParam('pro_id');

        $form = new Application_Form_Massdetail();
        $form->setDecorators(array(array('ViewScript', array('viewScript' => 'massdetailDecorator.phtml'))));

        $request = $this->getRequest();
        if ($request->isPost()) {
            if ($form->isValid($this->_request->getPost())) {
                foreach ($pro_id as $p) {
                    $this->table->insert(array(
                        'mass_id' => $id,
                        'pro_id' => $p,
                    ));
                }
                $this->_redirect("/massdetail/add/mass_id/" . $id);
            } else {
                $this->view->message = "Please fill up the required field and submit again";
            }
        }
        try {
            $data = $this->table->fetchAll(array('mass_id = ' . $id));
        } catch (Exception $e) {
            echo $e;
        }

        $this->view->data = $data;
        $this->view->form = $form;
    }

    public function deleteAction() {
        $id = $this->_request->getParam('id');
        $delete = $this->_request->getParam('delete');
        foreach($delete as $d){
            $this->table->delete('id = '.$d);
        }
        $this->_redirect('/massdetail/add/mass_id/'.$id);
    }
}