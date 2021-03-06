<?php

class Application_Model_DbTable_Products extends Zend_Db_Table_Abstract
{

    protected $_name = 'products';

    public function getArrayProducts(){
        $select = $this->select();
        $select->from($this->_name, array('key'=>'id', 'value'=>'name'))->order('name asc');
        $result = $this->getAdapter()->fetchAll($select);

        return $result;
    }
}