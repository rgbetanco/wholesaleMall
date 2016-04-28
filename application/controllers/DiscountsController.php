<?php

class DiscountsController extends Zend_Controller_Action {

    public function init() {
        $this->table = new Application_Model_DbTable_Discounts();
        $this->model = new Application_Model_Discounts();
        $this->session_sorting = new Zend_Session_Namespace('discountsort');
    }

    public function indexAction() {
        
    }

    public function formAction() {
        $form = new Application_Form_Discounts();
        $form->setDecorators(array(array('ViewScript', array('viewScript' => 'discountsDecorator.phtml'))));

        $request = $this->getRequest();
        if ($request->isPost()) {
            if ($form->isValid($this->_request->getPost())) {
                $this->table->insert(array(
                    'code' => $form->getValue('code'),
                    'description' => $form->getValue('description'),
                    'init_date' => $form->getValue('init_date'),
                    'end_date' => $form->getValue('end_date'),
                    'status' => $form->getValue('status'),
                    'stackable' => $form->getValue('stackable'),
                    'min_purchase' => $form->getValue('min_purchase'),
                    'min_quantity' => $form->getValue('min_quantity'),
                    'subcat_id' => $form->getValue('subcat_id'),
                    'pro_id' => $form->getValue('pro_id'),
                    'percentage' => $form->getValue('percentage'),
                    'amount' => $form->getValue('amount'),
                    'created' => date('Y-m-d')
                ));
                $this->_redirect('discounts/form');
            } else {
                $this->view->errorMessage = "Please Fill in the Requiered Fields";
            }
        }

        $this->view->form = $form;
    }

    public function editAction() {
        $page = $this->_request->getParam('page');

        $id = $this->_request->getParam('id');
        $status = $this->_request->getParam('status');
        $delete = $this->_request->getParam('delete');

        foreach ($id as $k => $v) {
            $this->table->update(array('status' => $status[$k]), array('id=' . $v));
        }
        
        foreach($delete as $d){
            $this->table->delete(array('id='.$d));
        }
        
        $this->view->page = $page;
        $this->_redirect('/discounts/list');
    }

    public function listAction() {
        //write function to update status (expired) before showing the view
        $this->model->updateStatus();
        Zend_View_Helper_PaginationControl::setDefaultViewPartial('pagecontrol.phtml');

        $where = '1 = 1';

        $filter = $this->_request->getParam('search');
        $this->view->filter = $filter;

        if ($filter == 'active') {
            $where = 'status = 0';
        } else if ($filter == 'disabled') {
            $where = 'status = 2';
        } else if ($filter == 'expired') {
            $where = 'status = 1';
        }

        $sort = $this->_request->getParam('sort');
        if (!$sort) {
            $sort = 'description';
        }

        if (!isset($this->session_sorting->sort)) {
            $this->session_sorting->sort = 0;
        }

        if ($this->session_sorting->sort == 0) {
            $this->session_sorting->sort = 1;
            $data = $this->table->fetchAll($this->table->select()->where($where)->order($sort . ' desc'));
        } else {
            $this->session_sorting->sort = 0;
            $data = $this->table->fetchAll($this->table->select()->where($where)->order($sort . ' asc'));
        }

        $paginator = Zend_Paginator::factory($data);
        $paginator->setCurrentPageNumber($this->_getParam('page', 1));
        $paginator->setItemCountPerPage(10);

        $this->view->page = $this->_getParam('page');
        $this->view->discounts = $paginator;
    }

    public function updateAction() {
        $id = $this->_request->getParam('id');
        $discounts = $this->table->find($id);
        foreach ($discounts as $d) {
            $code = $d['code'];
            $description = $d['description'];
            $init_date = $d['init_date'];
            $end_date = $d['end_date'];
            $status = $d['status'];
            $stackable = $d['stackable'];
            $min_purchase = $d['min_purchase'];
            $min_quantity = $d['min_quantity'];
            $subcat_id = $d['subcat_id'];
            $pro_id = $d['pro_id'];
            $percentage = $d['percentage'];
            $amount = $d['amount'];
        }
        $form = new Application_Form_Discounts();
        $form->setDecorators(array(array('ViewScript', array('viewScript' => 'discountsDecorator.phtml'))));
        $form->getElement('code')->setValue($code);
        $form->getElement('description')->setValue($description);
        $form->getElement('init_date')->setValue($init_date);
        $form->getElement('end_date')->setValue($end_date);
        $form->getElement('status')->setValue($status);
        $form->getElement('stackable')->setValue($stackable);
        $form->getElement('min_purchase')->setValue($min_purchase);
        $form->getElement('min_quantity')->setValue($min_quantity);
        $form->getElement('subcat_id')->setValue($subcat_id);
        $form->getElement('pro_id')->setValue($pro_id);
        $form->getElement('percentage')->setValue($percentage);
        $form->getElement('amount')->setValue($amount);

        $request = $this->getRequest();

        if ($request->isPost()) {
            if ($form->isValid($this->_request->getPost())) {
                $this->table->update(array(
                    'code' => $form->getValue('code'),
                    'description' => $form->getValue('description'),
                    'init_date' => $form->getValue('init_date'),
                    'end_date' => $form->getValue('end_date'),
                    'status' => $form->getValue('status'),
                    'stackable' => $form->getValue('stackable'),
                    'min_purchase' => $form->getValue('min_purchase'),
                    'min_quantity' => $form->getValue('min_quantity'),
                    'subcat_id' => $form->getValue('subcat_id'),
                    'pro_id' => $form->getValue('pro_id'),
                    'percentage' => $form->getValue('percentage'),
                    'amount' => $form->getValue('amount')
                        ), 'id = ' . $id);
                $this->_redirect('/discounts/list');
            } else {
                $this->view->message('Error entering data, please fill up required fields');
            }
        }

        $this->view->form = $form;
        $this->view->subcat_id = $subcat_id;
        $this->view->pro_id = $pro_id;
    }

    public function showdiscountAction() {
        $id = $this->_request->getParam('id');
        $tbl_discount = new Application_Model_DbTable_Discounts();
        $tbl_products = new Application_Model_DbTable_Products();
        $tbl_products_cat = new Application_Model_DbTable_Procategories();
        $cat = $tbl_products_cat->fetchAll($tbl_products_cat->select()->where('pro_id = ?', $id));
        $product = $tbl_products->find($id);
        $today = date('Y-m-d');
        $this->view->cat_id = $cat[0]->subcat_id;
        $discounts = $tbl_discount->fetchAll($tbl_discount->select()->where('pro_id = ?', $id)->where('init_date <= ?', $today)->where('end_date >= ?', $today)->where('status = 0')->where('code = 0'));
        $discounts_cat = $tbl_discount->fetchAll($tbl_discount->select()->where('subcat_id = ?', $cat[0]->subcat_id)->where('pro_id < ?', 0)->where('init_date <= ?', $today)->where('end_date >= ?', $today)->where('status = 0')->where('code = 0'));
        if (count($discounts) > 0) {
            $this->view->count = count($discounts);
            $this->view->description = $discounts[0]->description;
            if ($discounts[0]->percentage > 0) {
                $this->view->discount = $product[0]->w_price * ($discounts[0]->percentage / 100);
            } else {
                $this->view->discount = $discounts[0]->amount;
            }
            if ($discounts[0]->min_purchase > 0) {
                $this->view->min = $discounts[0]->min_purchase;
            } else {
                $this->view->min = $discounts[0]->min_quantity;
            }
        } else if (count($discounts_cat) > 0) {
            $this->view->count = count($discounts_cat);
            $this->view->description = $discounts_cat[0]->description;
            if ($discounts_cat[0]->percentage > 0) {
                $this->view->discount = $product[0]->w_price * ($discounts_cat[0]->percentage / 100);
            } else {
                $this->view->discount = $discounts_cat[0]->amount;
            }
            if ($discounts_cat[0]->min_purchase > 0) {
                $this->view->min = $discounts_cat[0]->min_purchase;
            } else {
                $this->view->min = $discounts_cat[0]->min_quantity;
            }
        }
    }

    public function getdiscountsAction() {
        //user to get the discounts from the combos just for testing
        $mdl_combos = new Application_Model_Combos();
        $this->view->discount = $mdl_combos->getComboDiscount();
    }
}