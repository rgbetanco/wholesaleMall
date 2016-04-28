<?php

class ProcolorsizesController extends Zend_Controller_Action {

    public function init() {
        /* Initialize action controller here */
    }

    public function indexAction() {
        $id = $this->_request->getParam('id');
        if (!$id) {
            $this->_redirect('index/index');
        }
        Zend_View_Helper_PaginationControl::setDefaultViewPartial('pagecontrol.phtml');

        $czObject = new Application_Model_Procolorsizes();
        $colors = $czObject->getColors();
        $sizes = $czObject->getSizes();

        foreach ($colors as $value) {
            $b[$value->id] = $value->name;
        }

        foreach ($sizes as $value) {
            $z[$value->id] = $value->name;
        }

        $this->view->colors = $b;
        $this->view->sizes = $z;
        
        if ($id) {
            $table = new Application_Model_DbTable_Procolorsizes();
            $data = $table->fetchAll($table->select()->where('p_id = ?', $id));
            //$data = $functions->array_sort($data_unsorted,'sub_id',SORT_ASC);            
            $paginator = Zend_Paginator::factory($data);
            $paginator->setCurrentPageNumber($this->_getParam('page', 1));
            $paginator->setItemCountPerPage(10);
            $this->view->id = $id;
            $this->view->page = $this->_getParam('page');
            $this->view->data = $paginator;
        } else {
            $this->_redirect('index/index');
        }
    }

    public function deleteAction() {
        $table = new Application_Model_DbTable_Procolorsizes();

        $page = $this->_getParam('page');

        $id = $this->_request->getParam('id');
        $pro_id = $this->_request->getParam('pro_id');
        $colors = $this->_request->getParam('colors');
        $sizes = $this->_request->getParam('sizes');
        $sub_id = $this->_request->getParam('sub_id');
        $v_id = $this->_request->getParam('v_id');
        $r_price = $this->_request->getParam('r_price');
        $w_price = $this->_request->getParam('w_price');
        $o_price = $this->_request->getParam('o_price');
        $inventory = $this->_request->getParam('inventory');
        $delete = $this->_request->getParam('delete');

        foreach ($id as $k => $v) {
            $table->update(array('c_id' => $colors[$k]), array('id=' . $v));
            $table->update(array('s_id' => $sizes[$k]), array('id=' . $v));
            $table->update(array('sub_id' => $sub_id[$k]), array('id=' . $v));
            $table->update(array('v_id' => $v_id[$k]), array('id=' . $v));
            $table->update(array('r_price' => $r_price[$k]), array('id=' . $v));
            $table->update(array('w_price' => $w_price[$k]), array('id=' . $v));
            $table->update(array('o_price' => $o_price[$k]), array('id=' . $v));
            $table->update(array('inventory' => $inventory[$k]), array('id=' . $v));

            if (in_array($v, $delete)) {
                $table->delete(array('id=' . $v));
            }
        }

        if (!$page) {
            $this->_redirect('products/detail/tab/colorsize/id/' . $pro_id);
        } else {
            $this->_redirect('products/detail/tab/colorsize/id/' . $pro_id . '/page/' . $page);
        }
    }

    function addformAction() {
        $id = $this->_request->getParam('id');
        if (!$id) {
            $this->_redirect('index/index');
        }
        $form = new Application_Form_Procolorsizes();
        $form->setDecorators(array(array('ViewScript', array('viewScript' => 'procolorsizesDecorator.phtml'))));
        
        $request = $this->getRequest();
        if ($request->isPost()) {
            if ($form->isValid($this->_request->getPost())) {
                $add = new Application_Model_Procolorsizes();
                $add->addNew(array(
                    'p_id' => $id,
                    'c_id' => $form->getValue('c_id'),
                    's_id' => $form->getValue('s_id'),
                    'sub_id' => $form->getValue('sub_id'),
                    'v_id' => $form->getValue('v_id'),
                    'r_price' => $form->getValue('r_price'),
                    'w_price' => $form->getValue('w_price'),
                    'o_price' => $form->getValue('o_price'),
                    'inventory' => $form->getValue('inventory'),
                    'created' => date('Y-m-d H:i:s'),
                    'updated' => date('Y-m-d H:i:s')
                ));
                $this->_redirect('products/detail/tab/colorsize/id/' . $id);
            } else {
                $this->view->errorMessage = "Please Fill in the Requiered Fields";
            }
        }
        $this->view->id = $id;
        $this->view->form = $form;
        
    }

}
