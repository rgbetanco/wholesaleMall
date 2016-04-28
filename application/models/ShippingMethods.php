<?php

class Application_Model_ShippingMethods
{
    public function getShippingMethod($id){
        $tbl_shipping = new Application_Model_DbTable_ShippingMethods();
        $shipping = $tbl_shipping->fetchRow($tbl_shipping->select()->where('id = ?', $id));
        return $shipping['name'];
    }

    public function getShippingUrl($id){
        $tbl_shipping = new Application_Model_DbTable_ShippingMethods();
        $shipping = $tbl_shipping->fetchRow($tbl_shipping->select()->where('id = ?', $id));
        return $shipping['url'];
    }
}