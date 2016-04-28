<?php

class Application_Model_Orders
{
    function saveOrderDetail($data, $last_id){
        $tbl_orders = new Application_Model_DbTable_OrderDetail();
        foreach($data as $d){
            $tbl_orders->insert(array(
                'order_id'=>$last_id,
                'pro_id'=>$d['id'],
                'price'=>$d['price'],
                'sub_id'=>$d['sub_id'],
                'style'=>'none',
                'quantity'=>$d['qty']
                ));
        }
    }
    
    public function saveOrder($discount, $discount_cmb){
        $tbl_register = new Application_Model_DbTable_Register();
        $tbl_order = new Application_Model_DbTable_Orders();
        $mdl_shopping = new Application_Model_Shopping();
        
        $total = $mdl_shopping->get_total();
        
        $order_number = 1;
        
        $auth = Zend_Auth::getInstance();
        $username = $auth->getStorage()->read()->username;
        //I need to get the information from the register table to insert into order table, capture the last id and insert it into order detail table
        //then create a form so that the user can edit that data and update the table, last update will update status of the order
        $customer = $tbl_register->fetchRow($tbl_register->select()->where('email = ?', $username));
        $last_id = $tbl_order->insert(array(
            'order_number'=>$order_number,
            'first_name'=>$customer->first_name,
            'last_name'=>$customer->last_name,
            'phone'=>$customer->phone,
            'email'=>$customer->email,
            'b_address'=>$customer->address,
            'b_city'=>$customer->city,
            'b_state'=>$customer->state,
            'b_zip'=>$customer->zip,
            'b_country'=>$customer->country,
            'b_phone'=>$customer->phone,
            'b_method'=>'not specified',
            'note'=>'',
            's_first_name'=>'',
            's_last_name'=>'',
            's_address'=>'',
            's_city'=>'',
            's_state'=>'',
            's_zip'=>'',
            's_country'=>'',
            's_phone'=>'',
            's_method'=>'',
            'drop_ship'=>0,
            'taxes'=>0,
            'shipping_cost'=>0,
            'total'=>$total,
            'status'=>-1,
            'tracking_numbers'=>0,
            'discount'=>$discount,
            'discount_cmb'=>$discount_cmb,
            'day'=>date('d'),
            'month'=>date('m'),
            'year'=>date('Y'),
            'created'=>date('Y-m-d H:s:i')
        ));
        $mdl_shopping->clear_shopping_cart();
        return $last_id;
    }

    public function statusShipped($order_id){
        $tbl_order = new Application_Model_DbTable_Orders();
        $order = $tbl_order->fetchRow($tbl_order->select()->where('id = ?', $order_id));
        $tbl_order_detail = new Application_Model_DbTable_OrderDetail();
        $product_model = new Application_Model_Product();
        $order_detail = $tbl_order_detail->fetchAll($tbl_order_detail->select()->where('order_id = ?', $order_id));
        foreach ($order_detail as $k => $v) {
            $pro = $product_model->getProductFieldById($v->pro_id, 'name');
            if(!$v->deleted){
                $data['detail'] .= '<strong>Product:</strong> '.$pro.'<br><strong>Quantity:</strong> '.$v->quantity.'<br><br>';
            } else {
                $data['detail'] .= '<span style=text-decoration:line-through><strong>Product:</strong> '.$pro.'<br><strong>Quantity:</strong></span> '.$v->quantity.'<br><br>';
            }
        }
        $data['order'] = '<strong>Tracking numbers:</strong> '.$order->tracking_numbers.'<br><strong>Ship to address</strong><br>'.$order->s_last_name.','.$order->s_first_name.'<br><strong>Address:</strong> '.$order->s_address.'<br><strong>City:</strong> '.$order->s_city.'<br><strong>State:</strong> '.$order->s_state.'<br><strong>Note:</strong> '.$order->note_to_customer;
        if(!$order->sent){
            $this->sendEmail($data, $order->email, $order->id);
        }
    }

    public function sendEmail($data, $email, $order_id){
        //Prepare email
        $mail = new Zend_Mail();
        $mail->addTo($email);
        $mail->setSubject('Dogo Order Shipped Notification');
        $mail->setBodyHtml($data['order'].'<br>'.$data['detail']);
        $mail->setFrom('dogo@nicaraodev.com', 'Ronald Garcia');

        //Send it!
        $sent = true;
        try {
            $mail->send();
            $tbl_order = new Application_Model_DbTable_Orders();
            $tbl_order->update(array('sent'=>1), 'id='.$order_id);
        } catch (Exception $e){
            echo $e->getMessage();
            $sent = false;
        }

        return $sent;
    }
}