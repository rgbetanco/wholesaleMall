<?php

class SubcategoriesController extends Zend_Controller_Action {

    public function init() {
        
    }

    public function indexAction() {
        
    }

    public function listAction() {
        $id = $this->_getParam('id');

        $subcat = new Application_Model_DbTable_Subcategories();
        $sub = $subcat->getSubcategories($id);
        $this->view->subcategories = $sub;
    }

    public function formAction() {
        $form = new Application_Form_Subcategories();
        $form->setDecorators(array(array('ViewScript', array('viewScript' => 'subcategoriesDecoractor.phtml'))));

        $request = $this->getRequest();
        if ($request->isPost()) {
            if ($form->isValid($this->_request->getPost())) {
                $addRec = new Application_Model_Subcategories();
                $addRec->addNewRecord(array(
                    'cat_id' => $form->getValue('categories'),
                    'name' => $form->getValue('subcategory'),
                    'sort' => $form->getValue('sort')
                ));
                $this->_redirect('categories/display/tab/subcategory');
            } else {
                $this->view->errorMessage = "Please Fill in the Requiered Fields";
            }
        }

        $this->view->form = $form;
    }

    public function displaylistAction() {
        $id = $this->_getParam('id');

        $subcat = new Application_Model_DbTable_Subcategories();
        $sub = $subcat->getSubcategories($id);
        $this->view->subcategories = $sub;
    }
    
    //This action should be called update instead
    public function deleteAction() {
       $table = new Application_Model_DbTable_Subcategories();

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
            $this->_redirect('categories/display/tab/subcategory');
    }

}
