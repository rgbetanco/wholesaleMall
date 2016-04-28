<?php

class ProductsController extends Zend_Controller_Action {

    public function init() {
        $this->model = new Application_Model_Product();
        $this->table = new Application_Model_DbTable_Products();
    }

    public function indexAction() {
        Zend_View_Helper_PaginationControl::setDefaultViewPartial('pagecontrol.phtml');

        $session_sorting = new Zend_Session_Namespace('sorting');

        $sort = $this->_request->getParam('sort');

        $table = new Application_Model_DbTable_Products();
        $info = $this->_getParam('search');
        if ($info) {
            if ($info == "active") {
                $data = $table->fetchAll($table->select()->where('active = ?', 1));
            } elseif ($info == "new") {
                $data = $table->fetchAll($table->select()->where('new = ?', 1));
            } elseif ($info == "pre_order") {
                $data = $table->fetchAll($table->select()->where('pre_order = ?', 1));
            } elseif ($info == "on_sale") {
                $data = $table->fetchAll($table->select()->where('on_sale = ?', 1));
            } else {
                $data = $table->fetchAll($table->select()->where('name LIKE ? OR product_id LIKE ? OR description LIKE ?', '%' . $info . '%', '%' . $info . '%', '%' . $info . '%'));
            }
        } else {
            if ($sort) {

                if (!isset($session_sorting->sort)) {
                    $session_sorting->sort = 0;
                }

                if ($session_sorting->sort > 0) {
                    $session_sorting->sort = 0;
                    $data = $table->fetchAll($table->select()->order($sort . ' DESC'));
                } else {
                    $session_sorting->sort = 1;
                    $data = $table->fetchAll($table->select()->order($sort . ' ASC'));
                }
            } else {
                $data = $table->fetchAll();
            }
        }
        $paginator = Zend_Paginator::factory($data);
        $paginator->setCurrentPageNumber($this->_getParam('page', 1));
        $paginator->setItemCountPerPage(50);
        $this->view->page = $this->_getParam('page');
        $this->view->products = $paginator;
    }

    public function addAction() {
        $form = new Application_Form_Product();
        $form->setDecorators(array(array('ViewScript', array('viewScript' => 'productDecorator.phtml'))));
        $request = $this->getRequest();
        if ($request->isPost()) {
            if ($form->isValid($this->_request->getPost())) {
                $addPro = new Application_Model_Product();
                $time = strtotime($form->getValue('expires')); $newDate1 = date('Y-m-d', $time);
                $addPro->addNewPro(array(
                    'v_id' => $form->getValue('v_id'),
                    'name' => $form->getValue('name'),
                    'product_id' => $form->getValue('product_id'),
                    'description' => $form->getValue('description'),
                    'sec_description' => $form->getValue('sec_description'),
                    'dogopet_url' => $form->getValue('dogopet_url'),
                    'expiration' => $newDate1,
                    'r_price' => $form->getValue('r_price'),
                    'w_price' => $form->getValue('w_price'),
                    'o_price' => $form->getValue('o_price'),
                    'active' => $form->getValue('active'),
                    'new' => $form->getValue('new'),
                    'pre_order' => $form->getValue('pre_order'),
                    'on_sale' => $form->getValue('on_sale'),
                    'updated' => date('Y-m-d H:i:s'),
                    'created' => date('Y-m-d H:i:s')
                ));
                $this->_redirect('products/index');
            } else {
                $this->view->errorMessage = "Please Fill in the Requiered Fields";
            }
        }
        $this->view->form = $form;
    }

    public function updateAction() {
        $table = new Application_Model_DbTable_Products();

        $page = $this->_request->getParam('page');

        $id = $this->_request->getParam('id');
        $name = $this->_request->getParam('name');
        $product_id = $this->_request->getParam('product_id');
        $r_price = $this->_request->getParam('r_price');
        $w_price = $this->_request->getParam('w_price');
        $o_price = $this->_request->getParam('o_price');
        $active = $this->_request->getParam('active');
        $new = $this->_request->getParam('new');
        $pre_order = $this->_request->getParam('pre_order');
        $on_sale = $this->_request->getParam('on_sale');
        $delete = $this->_request->getParam('delete');

        foreach ($id as $k => $id) {
            $table->update(array('name' => $name[$k]), array('id=' . $id));
            $table->update(array('product_id' => $product_id[$k]), array('id=' . $id));
            $table->update(array('r_price' => $r_price[$k]), array('id=' . $id));
            $table->update(array('w_price' => $w_price[$k]), array('id=' . $id));
            $table->update(array('o_price' => $o_price[$k]), array('id=' . $id));

            if (in_array($id, $active)) {
                $table->update(array('active' => 1), array('id=' . $id));
            } else {
                $table->update(array('active' => 0), array('id=' . $id));
            }
            if (in_array($id, $new)) {
                $table->update(array('new' => 1), array('id=' . $id));
            } else {
                $table->update(array('new' => 0), array('id=' . $id));
            }
            if (in_array($id, $pre_order)) {
                $table->update(array('pre_order' => 1), array('id=' . $id));
            } else {
                $table->update(array('pre_order' => 0), array('id=' . $id));
            }
            if (in_array($id, $on_sale)) {
                $table->update(array('on_sale' => 1), array('id=' . $id));
            } else {
                $table->update(array('on_sale' => 0), array('id=' . $id));
            }

            if (in_array($id, $delete)) {
                $table->delete(array('id=' . $id));
            }
        }

        if (!$page) {
            $this->_redirect('products/index');
        } else {
            $this->_redirect('products/index/page/' . $page);
        }
    }

    public function editAction() {
        $id = $this->_request->getParam('id');
        $table = new Application_Model_DbTable_Products();
        $data = $table->find($id);

        $this->view->id = $id;

        foreach ($data as $dat) {
            $v_id = $dat['v_id'];
            $name = $dat['name'];
            $product_id = $dat['product_id'];
            $description = $dat['description'];
            $sec_description = $dat['sec_description'];
            $dogopet_url = $dat['dogopet_url'];
            $expires = $dat['expiration'];
            $r_price = $dat['r_price'];
            $w_price = $dat['w_price'];
            $o_price = $dat['o_price'];
            $active = $dat['active'];
            $new = $dat['new'];
            $pre_order = $dat['pre_order'];
            $on_sale = $dat['on_sale'];
        }

        $form = new Application_Form_Product();
        $form->setDecorators(array(array('ViewScript', array('viewScript' => 'productDecorator.phtml'))));
        $form->getElement('name')->setValue($name);
        $form->getElement('product_id')->setValue($product_id);
        $form->getElement('description')->setValue($description);
        $form->getElement('sec_description')->setValue($sec_description);
        $form->getElement('dogopet_url')->setValue($dogopet_url);
        $time1 = strtotime($expires); $newDate1 = date('m/d/Y', $time1);
        $form->getElement('expires')->setValue($newDate1);
        $form->getElement('r_price')->setValue($r_price);
        $form->getElement('w_price')->setValue($w_price);
        $form->getElement('o_price')->setValue($o_price);
        $form->getElement('active')->setValue($active);
        $form->getElement('new')->setValue($new);
        $form->getElement('pre_order')->setValue($pre_order);
        $form->getElement('on_sale')->setValue($on_sale);

        $request = $this->getRequest();
        if ($request->isPost()) {
            if ($form->isValid($this->_request->getPost())) {
                $updatePro = new Application_Model_Product();
                $time = strtotime($form->getValue('expires'));
                $newexpires = date('Y-m-d', $time);
                $updatePro->updatePro(array(
                    'v_id' => $form->getValue('v_id'),
                    'name' => $form->getValue('name'),
                    'product_id' => $form->getValue('product_id'),
                    'description' => $form->getValue('description'),
                    'sec_description' => $form->getValue('sec_description'),
                    'dogopet_url' => $form->getValue('dogopet_url'),
                    'expiration' => $newexpires,
                    'r_price' => $form->getValue('r_price'),
                    'w_price' => $form->getValue('w_price'),
                    'o_price' => $form->getValue('o_price'),
                    'active' => $form->getValue('active'),
                    'new' => $form->getValue('new'),
                    'pre_order' => $form->getValue('pre_order'),
                    'on_sale' => $form->getValue('on_sale'),
                        ), $id);
                $this->_redirect('products/detail/tab/edit/id/' . $id);
            } else {
                $this->view->errorMessage = "Please Fill in the Requiered Fields";
            }
        }
        $this->view->form = $form;
    }

    public function detailAction() {
        $tab = $this->_request->getParam('tab');
        $sort = $this->_request->getParam('sort');
        $this->view->tab = $tab;
        $this->view->id = $this->_request->getParam('id');
        $this->view->sort = $sort;
    }

    public function getproductnameAction() {
        $pro_id = $this->_request->getParam('pro_id');
        $this->view->productname = $this->model->getProductName($pro_id);
    }

    public function getproductsAction() {
        $this->_helper->layout->disableLayout();
        $id = $this->_request->getParam('subcat_id');
        $pro_id = $this->_request->getParam('pro_id');
        if (!$pro_id) {
            $pro_id = -1;
        }

        $pro_table = new Application_Model_DbTable_Products();
        $where = $pro_table->select()->from(array('p' => 'products'))->join(array('s' => 'product_categories'), 'p.id = s.pro_id', array())->where('s.subcat_id = ?', $id);

        $data = $pro_table->fetchAll($where);

        $this->view->data = $data;
        $this->view->pro_id = $pro_id;
    }

    public function prosearchAction() {
        $search = $this->_request->getParam('search');
        $data = $this->table->fetchAll($this->table->select()->where('subcategories LIKE ?', '%' . $search . '%')->orWhere('name LIKE ?', '%' . $search . '%')->orWhere('description LIKE ?', '%' . $search . '%')->where('active = 1'));

        //pagination style
        Zend_View_Helper_PaginationControl::setDefaultViewPartial('pageControlFront.phtml');

        //currency
        $currency = new Zend_Currency('USD');
        Zend_Registry::set('Zend_Currency', $currency);

        $paginator = Zend_Paginator::factory($data);
        $paginator->setCurrentPageNumber($this->_getParam('page', 1));
        $paginator->setItemCountPerPage(20);
        $this->view->page = $this->_getParam('page');
        $this->view->data = $paginator;
    }

    public function prodetailAction() {
        $id = $this->_request->getParam('id');
        $this->view->id = $id;
        $currency = new Zend_Currency('USD');
        Zend_Registry::set('Zend_Currency', $currency);

        $pro_data = $this->table->find($id);
        $this->view->pro_data = $pro_data;

        $img_data = new Application_Model_DbTable_Proimages();
        $images = $img_data->fetchAll('p_id =' . $id);
        $this->view->images = $images;

        // color size part

//        SELECT `p`.`id`, `p`.`p_id`, `p`.`c_id`, `p`.`s_id`, `p`.`sub_id`, `p`.`v_id`, `p`.`r_price`, `p`.`w_price`, `p`.`o_price`, `p`.`inventory`, `p`.`created`, `p`.`updated`, `z`.`id`, `z`.`name`, `z`.`sort` FROM `procolorsizes` AS `p` INNER JOIN `sizes` AS `z` ON p.s_id = z.id WHERE (p.p_id =1) ORDER BY `z`.`sort` ASC
//        SELECT p.*, z.* FROM `procolorsizes` AS p, `sizes` AS z WHERE p.s_id = z.id AND p.p_id = 1 ORDER BY z.sort ASC
//        $pro_colorsize_table = new Application_Model_DbTable_Procolorsizes();
//        $pro_colorsize = $pro_colorsize_table->fetchAll($pro_colorsize_table->select()
//                        ->where('p_id =' . $id));


        $db = Zend_Db_Table::getDefaultAdapter();
        
        //$id = $this->_request->getParam('id');  
        $select = $db->select()->from(array('p'=>'procolorsizes'),array('id','p_id','c_id','s_id','sub_id','v_id','r_price','w_price','o_price','inventory','created','updated'))->join(array('z'=>'sizes'), 'p.s_id = z.id',array('sort'))->where('p.p_id =' . $id)->order('z.sort ASC');
        $this->view->select = $select->__toString();

        $stmt = $db->query($select);
        $result = $stmt->fetchAll();

        $this->view->procolorsizes = $result;


        //end of color size part
        //search for combos 
        $tbl_combo_detail = new Application_Model_DbTable_ComboDetail();
        $combo_detail = $tbl_combo_detail->fetchAll($tbl_combo_detail->select()->where('pro_id = ' . $id));
        
        if (count($combo_detail) > 0) {
            $this->view->combo = $combo_detail;
        }
    }

    public function showcombosAction() {
        $id = $this->_request->getParam('id');
        $c_id = $this->_request->getParam('combo_id');
        
        $tbl_combo_detail = new Application_Model_DbTable_ComboDetail();
        $tbl_combos = new Application_Model_DbTable_Combos();
        $combo_detail = $tbl_combo_detail->fetchAll($tbl_combo_detail->select()->where('pro_id = ' . $id));
        $db = Zend_Db_Table::getDefaultAdapter();
        $s_model = new Application_Model_Shopping();
        $shoppingcart = $s_model->getShoppingCart();
        $combo_array = array('xzxzxzx');
        if (count($shoppingcart) > 0) {
            foreach ($shoppingcart as $item) {
                $combo_array[] = $item['id'];
            }
        }
        if (count($combo_detail) > 0) {
            
            $this->view->combo = $combo_detail;
            $combo_id = $combo_detail[$c_id]['combo_id'];           //get the first combo containing this product id in the database
            $this->view->combo_id = $combo_id;
            $discount = $tbl_combos->find($combo_id);
            $this->view->discount = $discount[0]['price'];
            $select = $db->select()->from('products')->join('combo_detail', 'products.id = combo_detail.pro_id')->where('combo_detail.combo_id = ?',$combo_id)->where('products.id <> ?', $id)->where('products.id NOT IN (?)',$combo_array);
            $result1 = $db->query($select);
            $result2 = $db->query($select);

            $this->view->combo = $result1;
            $j = 0;
            foreach($result2 as $r){
              $j++;  
            }

            $this->view->is_combo = $j;      
            $this->view->result = $combo_array;
        }
    }
}