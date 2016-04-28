<?php

class Application_Model_Shopping {
    
    public function __construct(){
        if(!isset($_SESSION['cart'])){
            $_SESSION['cart'] = array();
        }
    }

    function get_quantity() {
        $max = count($_SESSION['cart']);
        echo $max;
    }

    function addNewOrder($data){
        $tbl_order = new Application_Model_DbTable_Orders();
        $last_id = $tbl_order->insert($data);
        return $last_id;
    }

    function addNewOrderDetail($data){
        $tbl_order_detail = new Application_Model_DbTable_OrderDetail();
        $tbl_order_detail->insert($data);
    }

    function addtocart($pid, $q, $p, $sid) {
        if ($pid == '' or $q < 1 or $p < 1)
            return;
        
        if (is_array($_SESSION['cart'])) {
            if (!$this->product_exists($pid, $q, $p)) {
                $max = count($_SESSION['cart']);
                $_SESSION['cart'][$max]['productid'] = $pid;
                $_SESSION['cart'][$max]['qty'] = $q;
                $_SESSION['cart'][$max]['price'] = $p;
                $_SESSION['cart'][$max]['id'] = $sid;
            }
        } else {
            $_SESSION['cart'] = array();
            $_SESSION['cart'][0]['productid'] = $pid;
            $_SESSION['cart'][0]['qty'] = $q;
            $_SESSION['cart'][0]['price'] = $p;
            $_SESSION['cart'][0]['id'] = $sid;
        }
        return 1;
    }

    function product_exists($pid, $q, $p) {
        $quantity = intval($q);
        $max = count($_SESSION['cart']);
        $flag = 0;
        for ($i = 0; $i < $max; $i++) {
            if (strcmp(trim($pid),trim($_SESSION['cart'][$i]['productid'])) === 0) {
                $_SESSION['cart'][$i]['qty'] += $quantity;
                $flag = 1;
                break;
            }
        }
        return $flag;
    }
    
    function quantity_update($pid, $q) {
        $quantity = intval($q);
        $max = count($_SESSION['cart']);
        $flag = 0;

        for ($i = 0; $i < $max; $i++) {
            if (strcmp(trim($pid),trim($_SESSION['cart'][$i]['productid'])) === 0) {
                $_SESSION['cart'][$i]['qty'] = $quantity;
                $flag = 1;
                break;
            }
        }
        return $flag;
    }

    function remove_product($pid) {
        $max = count($_SESSION['cart']);
        for ($i = 0; $i < $max; $i++) {
            if (strcmp(trim($pid),trim($_SESSION['cart'][$i]['productid'])) === 0) {
                unset($_SESSION['cart'][$i]);
                break;
            }
        }
        $_SESSION['cart'] = array_values($_SESSION['cart']);
    }

    function remove_session_id($id) {
        $id = intval($id);
        unset($_SESSION['cart'][$id]);
        $_SESSION['cart'] = array_values($_SESSION['cart']);
    }

    function clear_shopping_cart() {
        unset($_SESSION['cart']);
    }

    function get_total() {
        $total = 0;
        try {
            if (is_array($_SESSION['cart'])) {
                $max = count($_SESSION['cart']);
                for ($i = 0; $i < $max; $i++) {
                    $total += $_SESSION['cart'][$i]['qty'] * $_SESSION['cart'][$i]['price'];
                }
            }
        } catch (Exception $e) {
            //
        }
        return $total;
    }

    function getShoppingCart() {
        if(isset($_SESSION['cart'])){
            return $_SESSION['cart'];
        } else {
            return null;
        }
    }

}
