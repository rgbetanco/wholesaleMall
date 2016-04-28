<?php

class Application_Model_Combos {

    public function __construct() {
        $this->table = new Application_Model_DbTable_Combos();
    }

    public function saveCombo($data) {
        $this->table->insert($data);
        return $this->table->getAdapter()->lastInsertId();
    }

    public function getCombos($sort, $search) {

        $session_sorting = new Zend_Session_Namespace('sorting');
        
        $order = 'asc';
        if($sort){
            if($session_sorting->sort == 0){
                $order = 'desc';
                $session_sorting->sort = 1;
            } else {
                $order = 'asc';
                $session_sorting->sort = 0;
            }
        } else {
            $sort = 'sort';
        }
        $field = 'name LiKE ?';
        $lookfor = "";
        if(!$search || $search == "all"){
            $lookfor = '%%';
        } else {
            $lookfor = '%'.$search.'%';
        }
        if($search == 'active'){
            $field = 'active = ?';
            $lookfor = 1;
        } else if ($search == 'disabled'){
            $field = 'active = ?';
            $lookfor = 0;
        }
                
        $where = $this->table->select()->where($field,$lookfor)->order($sort.' '.$order);
        return $this->table->fetchAll($where);
    }
    
    public function getComboDiscount(){
        //get the shopping cart and put the product id in an array to be compared with the combos
        $mdl_cart = new Application_Model_Shopping();
        $cart = $mdl_cart->getShoppingCart();
        $cart_array = array();
        $discount = 0;
        foreach ($cart as $c){
            $cart_array[] = $c['id'];
        }
        
        //get the combos the combo table to compare with the products on the shopping cart and get a discount
        $db_adapter = Zend_Db_Table::getDefaultAdapter();
        $select = $db_adapter->select()->from('combos')->where('active = 1');
        $stmt = $db_adapter->query($select);
        $result = $stmt->fetchAll();
        $combo_array = array();
        foreach ($result as $r){
            $select_detail = $db_adapter->select()->from(array('c'=>'combo_detail'), array('c.pro_id'))->where('c.combo_id = ?', $r['id']);
            $stmtc = $db_adapter->query($select_detail);
            $resultc = $stmtc->fetchAll();
            foreach($resultc as $c){
                $combo_array[] = $c['pro_id'];
            }
            if(count(array_diff($combo_array, $cart_array))==0){
               $discount += abs($r['price']); 
            }
            unset($combo_array);
        }
        //tomorrow i need to show this discount to see if it work
        return $discount;
    }
}