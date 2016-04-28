<?php

class Application_Model_DbTable_Procolorsizes extends Zend_Db_Table_Abstract
{
    protected $_name = 'procolorsizes';

    public function getArrayStyles(){
        $select = $this->select();
        $select->from($this->_name, array('key'=>'id', 'value'=>'sub_id'))->order('name asc');
        $result = $this->getAdapter()->fetchAll($select);

        return $result;
    }
}