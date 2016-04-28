<?php

class CategoriesController extends Zend_Controller_Action {

    public function init() {
        
    }

    public function indexAction() {
        
    }

    public function listAction() {
        $cat = new Application_Model_DbTable_Categories();
        $categories = $cat->fetchAll($cat->select()->order('sort asc'));
        $this->view->categories = $categories;
    }

    public function formAction() {
        $form = new Application_Form_Categories();
        $form->setDecorators(array(array('ViewScript', array('viewScript' => 'categoriesDecorator.phtml'))));
        $request = $this->getRequest();
        if ($request->isPost()) {
            if ($form->isValid($this->_request->getPost())) {
                $addRec = new Application_Model_Categories();
                $addRec->addNewRecord(array(
                    'name' => $form->getValue('category'),
                    'sort' => $form->getValue('sort')
                ));
                $this->_redirect('categories/display/tab/category');
            } else {
                $this->view->errorMessage = "Please Fill in the Requiered Fields";
            }
        }
        $this->view->form = $form;
    }

    public function navigationAction() {
        
    }

    public function displayAction() {
        $tab = $this->_request->getParam('tab');
        $this->view->tab = $tab;
    }

    public function displaylistAction() {
        $cat = new Application_Model_DbTable_Categories();
        $categories = $cat->fetchAll($cat->select()->order('sort asc'));
        $this->view->categories = $categories;
    }

    public function listtoupdateAction() {
        $cat = new Application_Model_DbTable_Categories();
        $categories = $cat->fetchAll($cat->select()->order('sort asc'));
        $this->view->categories = $categories;
    }

    public function deleteAction() {
        $table = new Application_Model_DbTable_Categories();

        $id = $this->_request->getParam('id');
        $name = $this->_request->getParam('name');
        $sort = $this->_request->getParam('sort');
        $delete = $this->_request->getParam('delete');

        foreach ($id as $k => $id) {
            $table->update(array('name' => $name[$k]), array('id=' . $id));
            $table->update(array('sort' => $sort[$k]), array('id=' . $id));

            if (in_array($id, $delete)) {
                $table->delete(array('id=' . $id));
            }
        }
        $this->_redirect('categories/display/tab/category');
    }
}