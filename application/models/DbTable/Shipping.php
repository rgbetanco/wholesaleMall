<?php

class Application_Model_DbTable_Shipping extends Zend_Db_Table_Abstract
{

    protected $_name = 'shipping_addr';
    
    public function getShippingAddresses($reg_id){
        $select = $this->select();
        $select->from($this->_name, array('key'=>'id', 'value'=>'address'))->where('reg_id = ?',$reg_id)->order('address asc');
        
        $result = $this->getAdapter()->fetchAll($select);
        return $result;
    }
}