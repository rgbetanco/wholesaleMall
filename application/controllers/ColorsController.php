<?php

class ColorsController extends Zend_Controller_Action {

    public function init() {
        /* Initialize action controller here */
    }

    public function indexAction() {
        // action body
    }

    public function getnameAction() {
        $id = $this->_request->getParam('id');
        $table = new Application_Model_DbTable_Colors();
        $this->view->nameRowSet = $table->find($id);
    }

    public function getnamesAction() {
        $table = new Application_Model_DbTable_Colors();
        $select = $table->select()->from('colors', array('key' => 'id', 'value' => 'name'));
        $result = $table->getAdapter()->fetchAll($select);
        $this->view->result = $result;
    }

    public function formcolorAction() {
        $form = new Application_Form_Color();
        $form->setDecorators(array(array('ViewScript', array('viewScript' => 'colorDecorator.phtml'))));
        
        $request = $this->getRequest();
        if ($request->isPost()) {
            if ($form->isValid($this->_request->getPost())) {
                $addRec = new Application_Model_Colors();
                $addRec->addNewRecord(array(
                    'name' => $form->getValue('name'),
                    'code' => $form->getValue('code'),
                    'rgb' => $form->getValue('rgb'),
                    'sort' => $form->getValue('sort')
                ));
                $this->_redirect('colors/display/tab/colorform');
            } else {
                $this->view->errorMessage = "Please Fill in the Requiered Fields";
            }
        }
        
        $this->view->form = $form;
    }

    public function listAction() {
        $table = new Application_Model_Colors();
        $sort = $this->_getParam('sortc');
        
        $data = $table->getColors($sort);
        
        $paginator = Zend_Paginator::factory($data);
        $paginator->setCurrentPageNumber($this->_getParam('pagec', 1));
        $paginator->setItemCountPerPage(10);
        $this->view->pagec = $this->_getParam('pagec');
        $this->view->data = $paginator;
    }

    public function displayAction() {
        $tab = $this->_request->getParam('tab');
        $pagec = $this->_request->getParam('pagec');
        $pagez = $this->_request->getParam('pagez');
        $sortc = $this->_request->getParam('sortc');
        $sortz = $this->_request->getParam('sortz');
        
        $this->view->sortc = $sortc;
        $this->view->sortz = $sortz;
        $this->view->tab = $tab;
        $this->view->pagec = $pagec;
        $this->view->pagez = $pagez;
    }

    public function updateAction() {
        $table = new Application_Model_DbTable_Colors();

        $id = $this->_request->getParam('id');
        $name = $this->_request->getParam('name');
        $code = $this->_request->getParam('code');
        $rgb = $this->_request->getParam('rgb');
        $sort = $this->_request->getParam('sort');
        $delete = $this->_request->getParam('delete');
        
        $page = $this->_request->getParam('pagec');
        $tab = $this->_request->getParam('tab');

        foreach ($id as $k => $id) {
            $table->update(array('name' => $name[$k]), array('id=' . $id));
            $table->update(array('code' => $code[$k]), array('id=' . $id));
            $table->update(array('rgb' => $rgb[$k]), array('id=' . $id));
            $table->update(array('sort' => $sort[$k]), array('id=' . $id));

            if (in_array($id, $delete)) {
                $table->delete(array('id=' . $id));
            }
        }
        $this->_redirect('colors/display/tab/'.$tab.'/pagec/'.$page);
    }

}
