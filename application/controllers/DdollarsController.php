<?php

class DdollarsController extends Zend_Controller_Action {

    public function init() {
        
    }

    public function indexAction() {
        
    }

    public function getamountAction() {
        $id = $this->_request->getParam('id');
        $ddollar_model = new Application_Model_Ddollars();
        $total = $ddollar_model->getAmount($id);

        $this->view->total = $total;
    }

    public function listAction() {
        $id = $this->_request->getParam('reg_id');
        $table = new Application_Model_DbTable_Ddollars();
        $where = $table->getAdapter()->quoteInto('reg_id = ?', $id);
        $dollars = $table->fetchAll($where);

        $paginator = Zend_Paginator::factory($dollars);
        $paginator->setCurrentPageNumber($this->_getParam('paged', 1));
        $paginator->setItemCountPerPage(10);

        $paged = $this->_getParam('paged');
        
        $this->view->paged = $paged;
        $this->view->reg_id = $id;
        $this->view->data = $paginator;
    }

    public function addAction() {
        $id = $this->_request->getParam('id');
        $paged = $this->_request->getParam('paged');
        $form = new Application_Form_Ddollars();
        $form->setDecorators(array(array('ViewScript', array('viewScript' => 'ddollarsDecorator.phtml'))));
        $request = $this->getRequest();
        if ($request->isPost()) {
            if ($form->isValid($this->_request->getPost())) {
                $addReg = new Application_Model_Ddollars();
                $addReg->addNewDdollar(array(
                    'reg_id' => $id,
                    'order' => $form->getValue('order'),
                    'amount' => $form->getValue('amount'),
                    'expires' => $form->getValue('expires'),
                    'created' => date('Y-m-d H:i:s')
                ));
                $this->_redirect('register/detail/tab/dd/reg_id/' . $id.'/paged/'.$paged);
            } else {
                $this->view->errorMessage = "Please Fill in the Requiered Fields";
            }
        }
        $this->view->reg_id = $id;
        $this->view->form = $form;
    }

    public function editAction() {
        $id = $this->_request->getParam('id');
        $reg_id = $this->_request->getParam('reg_id');
        $paged = $this->_request->getParam('paged');
        
        $table = new Application_Model_DbTable_Ddollars();
        $data = $table->find($id);

        $this->view->id = $id;

        foreach ($data as $dat) {
            $order = $dat['order'];
            $amount = $dat['amount'];
            $expires = $dat['expires'];
        }

        $form = new Application_Form_Ddollars();
        $form->setDecorators(array(array('ViewScript', array('viewScript' => 'ddollarsDecorator.phtml'))));
        $form->getElement('order')->setValue($order);
        $form->getElement('amount')->setValue($amount);
        $form->getElement('expires')->setValue($expires);

        $request = $this->getRequest();
        if ($request->isPost()) {
            if ($form->isValid($this->_request->getPost())) {
                $update = new Application_Model_Ddollars();
                $update->updateDdollar(array(
                    'order' => $form->getValue('order'),
                    'amount' => $form->getValue('amount'),
                    'expires' => $form->getValue('expires'),
                        ), $id);
                $this->_redirect('register/detail/reg_id/' . $reg_id.'/paged/'.$paged);
            } else {
                $this->view->errorMessage = "Please Fill in the Requiered Fields";
            }
        }

        $this->view->id = $id;
        $this->view->reg_id = $reg_id;
        $this->view->paged = $paged;
        $this->view->form = $form;
    }

    public function deleteAction() {
        $id = $this->_request->getParam('id');
        $reg_id = $this->_request->getParam('reg_id');

        $rec = new Application_Model_Ddollars();
        $rec->deleteDdollar($id);
        $this->_redirect('register/detail/reg_id/' . $reg_id . '/id/' . $id);
    }

    public function updateAction() {
        $table = new Application_Model_DbTable_Ddollars();

        $paged = $this->_request->getParam('paged');

        $dd_id = $this->_request->getParam('id');
        $reg_id = $this->_request->getParam('reg_id');
        $order = $this->_request->getParam('order');
        $amount = $this->_request->getParam('amount');
        $expires = $this->_request->getParam('expires');
        $delete = $this->_request->getParam('delete');

        foreach ($dd_id as $k => $id) {
            $table->update(array('order' => $order[$k]), array('id=' . $id));
            $table->update(array('amount' => $amount[$k]), array('id=' . $id));
            $table->update(array('expires' => $expires[$k]), array('id=' . $id));

            if (in_array($id, $delete)) {
                $table->delete(array('id=' . $id));
            }
        }

        if (!$paged) {
            $this->_redirect('register/detail/tab/dd/reg_id/'.$reg_id);
        } else {
            $this->_redirect('register/detail/tab/dd/reg_id/'.$reg_id.'/paged/' . $paged);
        }
    }

}
