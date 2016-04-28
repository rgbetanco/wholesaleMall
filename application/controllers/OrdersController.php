<?php

class OrdersController extends Zend_Controller_Action {

    public function init() {
        $this->table = new Application_Model_DbTable_Orders();
    }

    public function indexAction() {
        $order_id = $this->_request->getParam('id');
        $data = $this->table->find($order_id);

        $mdl_shipmethod = new Application_Model_ShippingMethods();
        $this->view->s_method = $mdl_shipmethod->getShippingMethod($data[0]['s_method']);

        $od = new Application_Model_Orderdetail();
        $h = $od->getOrderSubtotal($order_id);

        $this->view->total = $h['total'];
        $this->view->subtotal = $h['subtotal'];
        $this->view->discount = $h['discount'];

        $this->view->data = $data;

        $tbl_register = new Application_Model_DbTable_Register();
        $register = $tbl_register->fetchRow($tbl_register->select()->where('email = ?', $data[0]['email']));

        $tbl_ddollars = new Application_Model_DbTable_Ddollars();
        $ddollars_obj = $tbl_ddollars->fetchAll($tbl_ddollars->select()->where('reg_id = ?', $register['id']));
        $dogodollars = 0;
        foreach($ddollars_obj as $dd){
            $dogodollars += $dd->amount;
        }
        $this->view->ddollars = $dogodollars;
    }

    public function indexprintAction() {
        $order_id = $this->_request->getParam('id');
        $data = $this->table->find($order_id);

        $mdl_shipmethod = new Application_Model_ShippingMethods();
        $this->view->s_method = $mdl_shipmethod->getShippingMethod($data[0]['s_method']);

        $od = new Application_Model_Orderdetail();
        $h = $od->getOrderSubtotal($order_id);

        $this->view->total = $h['total'];
        $this->view->subtotal = $h['subtotal'];
        $this->view->discount = $h['discount'];

        $this->view->data = $data;

        $tbl_register = new Application_Model_DbTable_Register();
        $register = $tbl_register->fetchRow($tbl_register->select()->where('email = ?', $data[0]['email']));

        $tbl_ddollars = new Application_Model_DbTable_Ddollars();
        $ddollars_obj = $tbl_ddollars->fetchAll($tbl_ddollars->select()->where('reg_id = ?', $register['id']));
        $dogodollars = 0;
        foreach($ddollars_obj as $dd){
            $dogodollars += $dd->amount;
        }
        $this->view->ddollars = $dogodollars;
    }

    public function displayAction() {
        $id = $this->_request->getParam('id');
        $this->view->id = $id;
    }

    public function printAction(){
        $id = $this->_request->getParam('id');
        $this->view->id = $id;
    }

    public function deleteAction() {
        // action body
    }

    public function listAction() {
        //this is for the admin, to show all the orders
        $search = $this->_request->getParam('search');
        $notshipped = $this->_request->getParam('notshipped');
        $confirmed = $this->_request->getParam('confirmed');
        $new = $this->_request->getParam('new');
        $shipped = $this->_request->getParam('shipped');
        $cancelled = $this->_request->getParam('cancelled');

        $init_date = $this->_request->getParam('init_date');
        $end_date = $this->_request->getParam('end_date');

        $timefilter = $this->_request->getParam('timefilter');
        $ordertype = $this->_request->getParam('ordertype');                    //ascending or descending - order date filter

        $url = '/orders/list/';
        $sort = 'created';

        $order_number = $this->_request->getParam('order_number');
        $email = $this->_request->getParam('email');
        $date = $this->_request->getParam('date');
        $amount = $this->_request->getParam('amount');

        $session_sorting = new Zend_Session_Namespace('sortingorders');

        if (!isset($session_sorting->sort)) {
            $session_sorting->sort = 'asc';
        }

        if ($session_sorting->sort == 'asc') {
            $session_sorting->sort = 'desc';
        } else {
            $session_sorting->sort = 'asc';
        }

        if ($order_number) {
            $sort = 'order_number';
        } else if ($email) {
            $sort = 'email';
        } else if ($date) {
            $sort = 'created';
        } else if ($amount) {
            $amount = 'total';
        }

        $strlength = -9;
        if ($timefilter) {
            if ($timefilter == 'day') {
                $strlength = -9;
            } else if ($timefilter == 'month') {
                $strlength = -12;
            } else if ($timefilter == 'year') {
                $strlength = -15;
            }
            $sort = 'created';
        }

        if ($ordertype) {
            $session_sorting->sort = $ordertype;
        }

        Zend_View_Helper_PaginationControl::setDefaultViewPartial('pagecontrol.phtml');

        if ($search) {
            $url = $url . 'search/' . $search . '/';
            $data = $this->table->fetchAll($this->table->select()->where("email LIKE ? OR order_number LIKE ?", '%' . $search . '%')->order($sort . ' ' . $session_sorting->sort));
        } else if ($new) {
            $url = $url . 'new/1/';
            $data = $this->table->fetchAll($this->table->select()->where("status = 0")->order($sort . ' ' . $session_sorting->sort));
        } else if ($confirmed) {
            $url = $url . 'confirmed/1/';
            $data = $this->table->fetchAll($this->table->select()->where("status = 1")->order($sort . ' ' . $session_sorting->sort));
        } else if ($shipped) {
            $url = $url . 'shipped/1/';
            $data = $this->table->fetchAll($this->table->select()->where("status = 2")->order($sort . ' ' . $session_sorting->sort));
        } else if ($cancelled) {
            $url = $url . 'cancelled/1/';
            $data = $this->table->fetchAll($this->table->select()->where("status = 3")->order($sort . ' ' . $session_sorting->sort));
        } else if ($notshipped) {
            $url = $url . 'notshipped/1/';
            $data = $this->table->fetchAll($this->table->select()->where("status <> 2")->order($sort . ' ' . $session_sorting->sort));
        } else if ($init_date && $end_date) {
            $url = '/orders/list/';
            $time1 = strtotime($init_date); $newDate1 = date('Y-m-d', $time1);
            $time2 = strtotime($end_date); $newDate2 = date('Y-m-d', $time2);
            $data = $this->table->fetchAll($this->table->select()->where("created >= ?", $newDate1)->where("created <= ? + INTERVAL 1 DAY", $newDate2)->order($sort . ' ' . $session_sorting->sort));
        } else {
            $data = $this->table->fetchAll($this->table->select()->order($sort . ' ' . $session_sorting->sort));
        }

        $tbl_ddollars = new Application_Model_DbTable_Ddollars();
        $ddollars = $tbl_ddollars->fetchAll();

        $tbl_shipping = new Application_Model_DbTable_ShippingMethods();
        $shipping_methods = $tbl_shipping->fetchAll();

        $paginator = Zend_Paginator::factory($data);
        $paginator->setCurrentPageNumber($this->_getParam('page', 1));
        $paginator->setItemCountPerPage(50);
        $this->view->page = $this->_getParam('page');
        $this->view->data = $paginator;
        $this->view->urlreturned = $url;

        $currency = new Zend_Currency('USD');
        Zend_Registry::set('Zend_Currency', $currency);

        $this->view->strlength = $strlength;
        $this->view->timefilter = $timefilter;
        $this->view->order = $ordertype;
        $this->view->init_date = $init_date;
        $this->view->end_date = $end_date;
        $this->view->ddollars = $ddollars;
        $this->view->shippingmethods = $shipping_methods;
    }

    public function getshippingurlAction(){
        $id = $this->_request->getParam('id');
        $this->_helper->viewRenderer->setNoRender();
        $model = new Application_Model_ShippingMethods();
        echo $model->getShippingUrl($id);
    }

    public function editAction() {
        $request = $this->getRequest();
        if ($request->isPost()) {
            $id = $this->_request->getParam('id');
            $status = $this->_request->getParam('status');
            $shipping_methods = $this->_request->getParam('shipping_methods');
            $tracking_numbers = $this->_request->getParam('tracking_numbers');
            $ddollars = $this->_request->getParam('ddollars');
            $delete = $this->_request->getParam('delete');

            $model_ddollars = new Application_Model_Ddollars();

            foreach ($id as $k => $i) {

                $this->table->update(array('status'=>$status[$k]), array('id='.$i));
                $this->table->update(array('s_method'=>$shipping_methods[$k]), array('id='.$i));
                $this->table->update(array('tracking_numbers'=>$tracking_numbers[$k]), array('id='.$i));
                $model_ddollars->updateDdollarByOrder(array('amount'=>$ddollars[$k]),$i);

                if ($delete) {
                    if (in_array($i, $delete)) {
                        $this->table->delete(array('id=' . $i));
                    }
                }

                if($status[$k] == 2){
                    $model_order = new Application_Model_Orders();
                    $model_order->statusShipped($i);
                }
            }
        }
        $this->_redirect('/orders/list');
    }

    public function updateAction() {
        $order_id = $this->_request->getParam('id');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $tracking_numbers = $this->_request->getParam('tracking_numbers');
            $taxes = $this->_request->getParam('taxes');
            $shipping_cost = $this->_request->getParam('shipping_cost');
            $status = $this->_request->getParam('status');
            $note_to_customer = $this->_request->getParam('note_to_customer');
            $note_for_admin = $this->_request->getParam('note_for_admin');
            $this->table->update(array(
                'tracking_numbers' => $tracking_numbers,
                'taxes' => $taxes,
                'shipping_cost' => $shipping_cost,
                'status' => $status,
                'note_to_customer'=>$note_to_customer,
                'note_for_admin'=>$note_for_admin
                    ), 'id = ' . $order_id);

            if($status == 2){
                //send email
                $model_order = new Application_Model_Orders();
                $model_order->statusShipped($order_id);
            }
        }

        $this->_redirect('/orders/display/id/' . $order_id);
    }

    public function saveorderAction() {
        $mdl_orders = new Application_Model_Orders();
        $tbl_orders = new Application_Model_DbTable_Orders();
        $mdl_dogoDollars = new Application_Model_Ddollars();
        $tbl_basicSettings = new Application_Model_DbTable_Basicsettings();
        $tbl_register = new Application_Model_DbTable_Register();

        $data = array();
        $request = $this->getRequest();
        if ($request->isPost()) {
            $id = $this->_request->getParam('id');
            $sub_id = $this->_request->getParam('pro_id');
            $price = $this->_request->getParam('price');
            $qty = $this->_request->getParam('qty');
            $discount = $this->_request->getParam('discount');
            $discount_cmb = $this->_request->getParam('combo_discount');
            $basicSettings = $tbl_basicSettings->find(1);
            $percentage = $basicSettings[0]['percentage'];
            $percentage *= 0.01;
            $j = 0;
            $dogodollars = 0;
            foreach ($id as $i) {
                $data[$j]['id'] = $id[$j];
                $data[$j]['sub_id'] = $sub_id[$j];
                $data[$j]['price'] = $price[$j];
                $data[$j]['qty'] = $qty[$j];
                $dogodollars += $price[$j]*$percentage;
                $j++;
            }
            $last_id = $mdl_orders->saveOrder($discount, $discount_cmb);
            $this->view->id = $last_id;
            $mdl_orders->saveOrderDetail($data, $last_id);
            // Save dogo dollars
            $reg = Zend_Auth::getInstance()->getStorage()->read()->username;
            $register = $tbl_register->fetchRow($tbl_register->select()->where('email = ?',$reg));
            $reg_id = $register['id'];
            
            $expiration = date("Y-m-d", time() + ($basicSettings[0]['expire'])*86400);
            
            $ddata['reg_id'] = $reg_id;
            $ddata['order'] = $last_id;
            $ddata['amount'] = $dogodollars;
            $ddata['expires'] = $expiration;
            $ddata['created'] = date("Y-m-d H:i:s");
            $mdl_dogoDollars->addNewDdollar($ddata);

            $order = $tbl_orders->find($last_id);
            foreach ($order as $o) {
                $form->getElement('first_name')->setValue($o['first_name']);
                $form->getElement('last_name')->setValue($o['last_name']);
                $form->getElement('company')->setValue($o['company']);
                $form->getElement('b_address')->setValue($o['b_address']);
                $form->getElement('b_address_2')->setValue($o['b_address_2']);
                $form->getElement('b_city')->setValue($o['b_city']);
                $form->getElement('b_state')->setValue($o['b_state']);
                $form->getElement('b_country')->setValue($o['b_country']);
                $form->getElement('b_other_country')->setValue($o['b_other_country']);
                $form->getElement('b_zip')->setValue($o['b_zip']);
                $form->getElement('b_phone')->setValue($o['b_phone']);
            }
            
            $form = new Application_Form_Placeorder();
            $form->addElement('hidden', 'last_id', $last_id);
            $form->getElement('last_id')->setValue($last_id);
            $form->setDecorators(array(array('ViewScript', array('viewScript' => 'placeorderDecorator.phtml'))));

            $this->view->form = $form;   
        }
    }

    public function getshippingaddressAction() {
        $id = $this->_request->getParam('id');
        $this->_helper->viewRenderer->setNoRender();
        $this->_helper->getHelper('layout')->disableLayout();  //makes disable layout

        $tbl_shipping_addresses = new Application_Model_DbTable_Shipping();
        $ad = $tbl_shipping_addresses->fetchRow($tbl_shipping_addresses->select()->where('id = ?', $id));
        echo $this->getHelper('json')->sendJson(array(
            'first_name' => $ad['first_name'],
            'last_name' => $ad['last_name'],
            'company' => $ad['company'],
            'address' => $ad['address'],
            'address_2' => $ad['address_2'],
            'city' => $ad['city'],
            'state' => $ad['state'],
            'zip' => $ad['zip'],
            'country' => $ad['country'],
            'phone' => $ad['phone']));
    }

    public function updateorderAction() {
        $tbl_orders = new Application_Model_DbTable_Orders();
        $tbl_shipping_address = new Application_Model_DbTable_Shipping();
        $tbl_register = new Application_Model_DbTable_Register();
        $mdl_register = new Application_Model_Register();
        $last_id = $this->_request->getParam('last_id');
        $this->view->last_id = $last_id;
        $request = $this->getRequest();
        //check if the country is USA
        $country = 'United States';
        $state = $request->getParam('s_state');
        if ($request->getParam('s_country') != 'United States') {
            $country = $request->getParam('s_other_country');
            $states = 'Not USA';
        }
        $drop_ship = 0;
        if ($request->getParam('addresses') == 1) {
            $drop_ship = 1;
        }

        if ($request->isPost()) {
            $tbl_orders->update(array(
                's_first_name' => $request->getParam('s_first_name'),
                's_last_name' => $request->getParam('s_last_name'),
                's_company' => $request->getParam('s_company'),
                's_address' => $request->getParam('s_address'),
                's_address_2' => $request->getParam('s_address_2'),
                's_city' => $request->getParam('s_city'),
                's_state' => $state,
                's_country' => $country,
                's_zip' => $request->getParam('s_zip'),
                's_phone' => $request->getParam('s_phone'),
                'note' => $request->getParam('note'),
                'drop_ship' => $drop,
                's_method' => $request->getParam('s_method'),
                    ), 'id = ' . $last_id);

            $email = Zend_Auth::getInstance()->getStorage()->read()->username;

            if ($request->getParam('addresses') == 0) {
                $reg_id = $mdl_register->getRegId($email);
                $tbl_shipping_address->insert(array(
                    'first_name' => $request->getParam('s_first_name'),
                    'last_name' => $request->getParam('s_last_name'),
                    'company' => $request->getParam('s_company'),
                    'reg_id' => $reg_id,
                    'address' => $request->getParam('s_address'),
                    'address_2' => $request->getParam('s_address_2'),
                    'city' => $request->getParam('s_city'),
                    'state' => $state,
                    'zip' => $request->getParam('s_zip'),
                    'country' => $country,
                    'phone' => $request->getParam('s_phone'),
                    'created' => date('Y-m-d H:i:s')
                ));
            }
/*
            $tbl_register->update(array(
                'first_name' => $request->getParam('first_name'),
                'last_name' => $request->getParam('last_name'),
                'company' => $request->getParam('company'),
                'address' => $request->getParam('b_address'),
                'address_2' => $request->getParam('b_address_2')
                'city' => $request->getParam('b_city'),
                'state' => $state,
                'country' => $country,
                'phone' => $request->getParam('b_phone')
            ), 'id = '.$reg_id);
*/
        }
    }

    public function memberlistAction() {
        //list of previous orders from customer
        $email = Zend_Auth::getInstance()->getStorage()->read()->username;
        $tbl_orders = new Application_Model_DbTable_Orders();
        $tbl_reg = new Application_Model_DbTable_Register();
        $tbl_ddollars = new Application_Model_DbTable_Ddollars();
        $orders_obj = $tbl_orders->fetchAll($tbl_orders->select()->where('email = ?', $email)->order('created DESC'));
        //i need to get the reg id from the register table using the email in the orders table, then use the reg id to get the dogo dollars from the dogo_dollars table
        $reg_obj = $tbl_reg->fetchRow($tbl_reg->select()->where('email = ?', $email));
        $regid = $reg_obj->id;

        $ddollars_obj = $tbl_ddollars->fetchAll($tbl_ddollars->select()->where('reg_id = ?', $regid));
        $dogodollars = 0;
        foreach($ddollars_obj as $dd){
            $dogodollars += $dd->amount;
        }
        $this->view->ddollars = $dogodollars;
        $this->view->orders = $orders_obj;
    }

    public function memberlistdetailAction() {
        $id = $this->_request->getParam('id');
        $mdl_products = new Application_Model_Product();
        
        Zend_View_Helper_PaginationControl::setDefaultViewPartial('pagecontrol.phtml');
        
        $db = Zend_Db_Table::getDefaultAdapter();
        $where = $db->select()->from(array('o'=>'order_detail'))->where('o.order_id = ?', $id);
        $result = $db->query($where);
        $to_view = array();
        foreach($result as $k => $r){
            $to_view[$k]['id']=$r['id'];
            $to_view[$k]['product_name']=$mdl_products->getProductFieldById($r['pro_id'],'name');
            $to_view[$k]['price']=$r['price'];
            $to_view[$k]['quantity']=$r['quantity'];
        }
        
        $paginator = Zend_Paginator::factory($to_view);
        $paginator->setCurrentPageNumber($this->_getParam('page', 1));
        $paginator->setItemCountPerPage(10);
        $this->view->page = $this->_getParam('page');
        $this->view->data = $paginator;
    }
}