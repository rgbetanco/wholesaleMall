<?php

class Application_Model_DbTable_Combos extends Zend_Db_Table_Abstract
{

    protected $_name = 'combos';

    public function getArrayCombo(){
        $select = $this->select();
        $select->from($this->_name, array('key'=>'id', 'value'=>'name'))->where('active = 1')->order('name asc');
        $result = $this->getAdapter()->fetchAll($select);
        return $result;
    }
    
    
}

