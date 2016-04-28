<?php

class Application_Model_Discounts {

    public function updateStatus() {
        $table = new Application_Model_DbTable_Discounts();
        $where['end_date < ?'] = date('Y-m-d');
        $table->update(array('status' => 1), $where);
    }

    public function getDiscount() {
        $sess_cart = new Application_Model_Shopping();
        $functions = new Application_Model_Functions();
        $ucart = $sess_cart->getShoppingCart();
        $cart = $functions->sorting($ucart);
        
        $ncart = array();
        $pre_id = "";
        $i = 0;
        foreach($cart as $c){
            if($c['id'] != $pre_id){
                $pre_id = $c['id'];
                $ncart[$i]['pro_id'] = $c['id'];
                $ncart[$i]['amount'] = $c['qty']*$c['price'];
                $ncart[$i]['qty'] = $c['qty'];
                $i++;
            } else {
                $ncart[$i-1]['amount'] += $c['qty']*$c['price'];
                $ncart[$i-1]['qty'] += $c['qty'];
            }
        }
        $discount = 0;
        foreach($ncart as $n){
            $discount += $this->getDiscountById($n['pro_id'], $n['amount']);
        }
        return $discount;
    }
    
    public function getDiscountById($id, $amount){
        $tbl_discount = new Application_Model_DbTable_Discounts();
        $tbl_products = new Application_Model_DbTable_Products();
        $tbl_products_cat = new Application_Model_DbTable_Procategories();
        $cat = $tbl_products_cat->fetchAll($tbl_products_cat->select()->where('pro_id = ?', $id));
        $product = $tbl_products->find($id);
        $today = date('Y-m-d');
        $discounts_cat = array();
        if(count($cat) > 0){
   //         $this->view->cat_id = $cat[0]->subcat_id;
            $discounts_cat = $tbl_discount->fetchAll($tbl_discount->select()->where('subcat_id = ?', $cat[0]->subcat_id)->where('pro_id < ?', 0)->where('init_date <= ?', $today)->where('end_date >= ?', $today)->where('status = ?', 0)->where('code = 0'));
        }
        $discounts = $tbl_discount->fetchAll($tbl_discount->select()->where('pro_id = ?', $id)->where('init_date <= ?', $today)->where('end_date >= ?', $today)->where('status = ?', 0)->where('code = 0'));
        $discount_amount = 0;
        if (count($discounts) > 0) {
            if ($discounts[0]->percentage > 0) {
                $discount_amount = $product[0]->w_price * ($discounts[0]->percentage / 100);
            } else {
                $discount_amount = $discounts[0]->amount;
            }
            if ($discounts[0]->min_purchase > $amount) {
                $discount_amount = 0;
            }
        } else if (count($discounts_cat) > 0) {
            if ($discounts_cat[0]->percentage > 0) {
                $discount_amount = $product[0]->w_price * ($discounts_cat[0]->percentage / 100);
            } else {
                $discount_amount = $discounts_cat[0]->amount;
            }
            if ($discounts_cat[0]->min_purchase > $amount) {
                $discount_amount = 0;
            }
        }
        return $discount_amount;
    }
}