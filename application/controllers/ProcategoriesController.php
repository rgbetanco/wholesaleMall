<?php

class ProcategoriesController extends Zend_Controller_Action {

    public function init() {
        
    }

    public function indexAction() {
        Zend_View_Helper_PaginationControl::setDefaultViewPartial('pagecontrol.phtml');

        $id = $this->_request->getParam('id');
        if (!$id) {
            $this->_redirect('index/index');
        }
        $this->view->id = $id;

        $list = new Application_Model_Procategories();
        $data = $list->getProcategories($id);

        $paginator = Zend_Paginator::factory($data);
        $paginator->setCurrentPageNumber($this->_getParam('page', 1));
        $paginator->setItemCountPerPage(10);
        $this->view->page = $this->_getParam('page');
        $this->view->data = $paginator;
    }

    public function addAction() {
        $table = new Application_Model_DbTable_Procategories();
        
        $pro_id = $this->_request->getParam('id');
        $subcat = $this->_request->getParam('subcat_id');      //this parameter comes from the procategories form

        foreach ($subcat as $v) {
            try {
                $table->insert(array('pro_id' => $pro_id, 'subcat_id' => $v));
            } catch (Exception $ex) {
                echo "One or more subcategories are repeated";
            }
        }
        $model = new Application_Model_Procategories();
        $model->updateSubcategories($pro_id);
        
        $this->_redirect('products/detail/tab/category/id/' . $pro_id);
    }

    public function deleteAction() {
        $table = new Application_Model_DbTable_Procategories();
        
        $page = $this->_getParam('page');

        $id = $this->_request->getParam('pro_id');
        $delete = $this->_request->getParam('delete');

        foreach ($delete as $d) {
            $table->delete(array('pro_id =' . $id[0], 'subcat_id=' . $d));
        }

        $model = new Application_Model_Procategories();
        $model->updateSubcategories($id[0]);
        
        if (!$page) {
            $this->_redirect('products/detail/tab/category/id/' . $id[0]);
        } else {
            $this->_redirect('products/detail/tab/category/id/' . $id[0] . '/page/' . $page);
        }
    }

    public function addformAction() {
        $id = $this->_request->getParam('id');
        if (!$id) {
            $this->_redirect('index/index');
        }
        $this->view->id = $id;
        $form = new Application_Form_Procategories();
        $form->setDecorators(array(array('ViewScript', array('viewScript' => 'procategoriesDecorator.phtml'))));
        $this->view->form = $form;
    }

}
