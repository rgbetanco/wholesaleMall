<?php

class Application_Model_Orderdetail
{
    public function __construct() {
        $this->table = new Application_Model_DbTable_OrderDetail();
    }
    
    public function getOrderSubtotal($id){
        $a = $this->table->fetchAll('order_id='.$id);
        $subtotal = 0;
        $total = 0;
        $discount = 0;
        foreach($a as $v){
            $discount += $v->discount;
            $subtotal += ($v->price*$v->quantity);
            $total += ($v->price*$v->quantity)-$v->discount;
        }
        return array('discount'=>$discount, 'subtotal'=>$subtotal, 'total'=>$total);
    }
}