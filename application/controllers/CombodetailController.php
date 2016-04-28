<?php

class CombodetailController extends Zend_Controller_Action {

    public function init() {
        $this->table = new Application_Model_Combodetail();
    }

    public function indexAction() {
        // I used this method to add items to combo detail table
        $combo_id = $this->_request->getParam('cdetail');
        $pro_id = $this->_request->getParam('pro_id');

        $tbl_combo_detail = new Application_Model_DbTable_ComboDetail();
        foreach ($pro_id as $p) {
            $tbl_combo_detail->insert(array('combo_id' => $combo_id, 'pro_id' => $p));
        }

        $this->view->combo = $combo_id;
        $this->view->pro_id = $pro_id;
        $this->_redirect('combos/display/tab/comboform');
    }

    public function listAction() {
        $combo_id = $this->_request->getParam('combo_id');
        $this->view->combodetail = $this->table->getComboDetail($combo_id);
    }

    public function addAction() {
        $form = new Application_Form_Combodetail();
        $form->setDecorators(array(array('ViewScript', array('viewScript' => 'combodetailDecorator.phtml'))));

        $this->view->form = $form;
    }

    public function deleteAction() {
        $tbl_combo_detail = new Application_Model_DbTable_ComboDetail();
        $id = $this->_request->getParam('delete');
        foreach ($id as $p){
            $tbl_combo_detail->delete('id ='.$p);
        }
        $this->_redirect('combos/display/tab/comboform');
    }
}