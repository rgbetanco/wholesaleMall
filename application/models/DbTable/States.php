<?php

class Application_Model_DbTable_States extends Zend_Db_Table_Abstract
{

    protected $_name = 'states';

    public function getStates(){
        $select = $this->select();
        $select->from($this->_name, array('key'=>'code', 'value'=>'name'))->order('code asc');
        
        $result = $this->getAdapter()->fetchAll($select);
        return $result;   
    }

}