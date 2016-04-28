<?php

class ShoppingController extends Zend_Controller_Action {

    public function init() {
        /* Initialize action controller here */
    }

    public function indexAction() {
        // action body
    }

    public function addAction() {
        $pid = $this->getRequest()->getParam('proid');
        $sid = $this->getRequest()->getParam('subpro_id');
        $q = $this->getRequest()->getparam('quantity');
        $p = $this->getRequest()->getParam('price');

        $model = new Application_Model_Shopping();
        if ($q) {
            $model->addtocart($pid, $q, $p, $sid);
        }
        $this->_helper->viewRenderer->setNoRender();
        $this->_helper->getHelper('layout')->disableLayout();  //makes disable layout

        echo $model->get_total();
    }

    public function deleteAction() {
        $id = $this->_request->getParam('id');
        $model = new Application_Model_Shopping();
        
        $this->_helper->viewRenderer->setNoRender();
        $this->_helper->getHelper('layout')->disableLayout();  //makes disable layout
        
        $model->remove_product($id);
    }
    //this action will list the shopping cart and the order form
    public function listAction() {
        $tbl_register = new Application_Model_DbTable_Register();
        $tbl_shipping_address = new Application_Model_DbTable_Shipping();
        $model = new Application_Model_Shopping();
        $sort = new Application_Model_Functions();
        $mdl_dogoDollars = new Application_Model_Ddollars();
        $tbl_basicSettings = new Application_Model_DbTable_Basicsettings();
        $tbl_procolorsizes = new Application_Model_DbTable_Procolorsizes();
        $form = new Application_Form_Placeorder();
        $form->setDecorators(array(array('ViewScript', array('viewScript' => 'placeorderDecorator.phtml'))));
    
        $b = $model->getShoppingCart();    
        $a = $sort->sorting($b);
        $discounts = 0;
        $pm = new Application_Model_Product();
        if(sizeof($a) > 0){
            foreach ($a as $k => $item) {
                $item_id = $item['productid'];
                $local_id = "";
                $complete_id = "";
                $i = 0;
                while ($i <= strlen($item_id)) {
                    $x = substr($item_id, $i, 1);
                    if($i < 1){
                        $local_id .= $x;
                          $complete_id .= $x;
                    } else {
                        if (is_numeric($x)) {
                            $local_id .= $x;
                            $complete_id .= $x;
                        } else {
                            $complete_id .= $x;
                        }
                    }
                    $i++;
                }
                $a[$k]['name'] = $pm->getProductField($local_id, 'name');
                $a[$k]['picture'] = $pm->getProductField($local_id, 'picture');
                $a[$k]['id'] = $pm->getProductField($local_id, 'id');
                $a[$k]['local_id'] = $local_id;
                $a[$k]['complete_id'] = $complete_id;

                $mdl_discounts = new Application_Model_Discounts();
                $discounts = $mdl_discounts->getDiscount();
            }
            
             $this->view->cart = $a;
        }
        
        if (sizeof($a) <= 0) {
            $this->view->message = "No items in your shopping cart";
        }
        //get available discount for combos
        $mdl_combos = new Application_Model_Combos();
        $combo_discount = $mdl_combos->getComboDiscount();

        $auth = Zend_Auth::getInstance();
        $username = $auth->getStorage()->read()->username;
        
        $this->view->combo_discount = $combo_discount;
        $this->view->discount = $discounts;
        
        $customer = $tbl_register->fetchRow($tbl_register->select()->where('email = ?', $username));

        $dogodollars = 0;
        $last_id = 0;

        $request = $this->getRequest();
            if ($request->isPost()) {
                if ($form->isValid($this->_request->getPost())) {
                    //first I need to save the order get the last id and save the order detail
                    $order_number = mt_rand(1000000, 9999999);
                    $total = $model->get_total();

                    // check if country is USA or other, drop ship
                    $b_country = 'United States';
                    $s_country = 'United States';
                    $drop_ship = 0;
                    if($form->getValue('b_country') != 'United States'){
                        $b_country = $form->getValue('b_other_country');
                    }
                    if($form->getValue('s_country') != 'United States'){
                        $s_country = $form->getValue('s_other_country');
                    }
                    if($form->getValue('addresses') == 1){
                        $drop_ship = 1;
                    }

                    $last_id = $model->addNewOrder(array(
                        'order_number' => $order_number,
                        'first_name' => $form->getValue('first_name'),
                        'last_name' => $form->getValue('last_name'),
                        'company' => $form->getValue('company'),
                        'phone' => $form->getValue('b_phone'),
                        'email' => $customer->email,
                        'b_address' => $form->getValue('b_address'),
                        'b_address_2' => $form->getValue('b_address_2'),
                        'b_city' => $form->getValue('b_city'),
                        'b_state' => $form->getValue('b_state'),
                        'b_zip' => $form->getValue('b_zip'),
                        'b_country' => $b_country,
                        'b_phone' => $form->getValue('b_phone'),
                        'note' => $form->getValue('note'),
                        's_first_name' => $form->getValue('s_first_name'),
                        's_last_name' => $form->getValue('s_last_name'),
                        's_company' => $form->getValue('s_company'),
                        's_address' => $form->getValue('s_address'),
                        's_address_2' => $form->getValue('s_address_2'),
                        's_city' => $form->getValue('s_city'),
                        's_state' => $form->getValue('s_state'),
                        's_zip' => $form->getValue('s_zip'),
                        's_country' => $s_country,
                        's_phone' => $form->getValue('s_phone'),
                        's_method' => $form->getValue('s_method'),
                        'drop_ship' => $drop_ship,
                        'taxes' => 0,
                        'shipping_cost' => 0,
                        'total' => $total,
                        'status' => 0,
                        'tracking_numbers' => 0,
                        'discount' => $discounts,
                        'discount_cmb' => $combo_discount,
                        'day'=>date('d'),
                        'month'=>date('m'),
                        'year'=>date('Y'),
                        'created' => date('Y-m-d H:i:s')
                    ));
                    //get basic settings
                    $reg_id = $customer['id'];

                    $basicSettings = $tbl_basicSettings->find(1);
                    $percentage = $basicSettings[0]['percentage'];
                    $percentage *= 0.01;
                    //Now save order detail
                    $c = $model->getShoppingCart();

                    foreach ($c as $k => $v) {
                        $item_id_s = $v['productid'];
                        $local_id_s = "";
                        $complete_id_s = "";
                        $i_s = 0;
                        $dogodollars += $v['price']*$v['qty']*$percentage;
                        while ($i_s <= strlen($item_id_s)) {
                            $x_s = substr($item_id_s, $i_s, 1);
                            if($i_s == 0){
                                $local_id_s .= $x_s;
                                $complete_id_s .= $x_s;
                            } else {
                                if (is_numeric($x_s)) {
                                    $local_id_s .= $x_s;
                                    $complete_id_s .= $x_s;
                                } else {
                                    $complete_id_s .= $x_s;
                                }
                            }
                            $i_s++;
                        }
                        $model->addNewOrderDetail(array(
                            'order_id'=> $last_id,
                            'pro_id'=>$v['id'],
                            'price'=>$v['price'],
                            'sub_id'=>$complete_id_s,
                            'quantity'=>$v['qty'],
                            'discount'=>0,
                            'discount_type'=>'Not defined'
                        ));
                     //   $sel = $tbl_procolorsizes->select()->where('p_id = ?',$v['id']);
                     //   $row = $tbl_procolorsizes->fetchRow($sel);
                     //   $inventory = $row->inventory;
                     //   $where = $tbl_procolorsizes->getAdapter()->quoteInto('p_id = ?',$v['id']);
                        $procolorsizes_obj = $tbl_procolorsizes->fetchRow($tbl_procolorsizes->getAdapter()->quoteInto("sub_id = ?", $v['productid']));

                        $tbl_procolorsizes->update(array('inventory'=>$procolorsizes_obj->inventory - $v['qty']), $tbl_procolorsizes->getAdapter()->quoteInto("sub_id = ?", $v['productid']));
                    }
                    //I need to save the dogo dollars                    
                    $expiration = date("Y-m-d", time() + ($basicSettings[0]['expire'])*86400);
                    
                    $ddata['reg_id'] = $reg_id;
                    $ddata['order'] = $last_id;
                    $ddata['amount'] = $dogodollars;
                    $ddata['expires'] = $expiration;
                    $ddata['created'] = date("Y-m-d H:i:s");
                    $mdl_dogoDollars->addNewDdollar($ddata);
                    //clear shopping cart
                    $model->clear_shopping_cart();
                    //add new shipping address
                    if($form->getValue('addresses') == 0) {
                    $tbl_shipping_address->insert(array(
                        'first_name' => $form->getValue('s_first_name'),
                        'last_name' => $form->getValue('s_last_name'),
                        'company' => $form->getValue('s_company'),
                        'reg_id' => $reg_id,
                        'address' => $form->getValue('s_address'),
                        'address_2' => $form->getValue('s_address_2'),
                        'city' => $form->getValue('s_city'),
                        'state' => $form->getValue('s_state'),
                        'zip' => $form->getValue('s_zip'),
                        'country' => $s_country,
                        'phone' => $form->getValue('s_phone'),
                        'created' => date('Y-m-d H:i:s')
                    ));
            }
                    $this->_redirect('shopping/thanks');
                } else {
                    $this->view->message = "Please fill up the required fields";
                }
            }

        $this->view->form = $form;

    }

    public function gettotalAction() {
        $model = new Application_Model_Shopping();
        $a = $model->getShoppingCart();
       
        if (sizeof($a) <= 0) {
            $this->view->message = "No items in your shopping cart";
            $this->view->total = 0;
        } else {
            $this->view->total = $model->get_total();
        }
    }

    public function clearAction() {
        $model = new Application_Model_Shopping();
        $model->clear_shopping_cart();
    }

    public function updateAction() {
        $pid = $this->_request->getParam('pro_id');
        $q = $this->_request->getParam('qty');
        $m = new Application_Model_Shopping();
        $this->view->id = $pid;
        $this->view->q = $q;
        $this->view->result = $m->quantity_update($pid, $q);
    }

    public function thanksAction(){

    }
}