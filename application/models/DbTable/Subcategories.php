<?php

class Application_Model_DbTable_Subcategories extends Zend_Db_Table_Abstract {

    protected $_name = 'subcategories';

    public function getSubcategories($id) {

        $select = $this->select();
        $select->where('cat_id = ' . $id);
        $select->order('sort ASC');
        $rows = $this->fetchAll($select);
        return $rows;
    }

    public function getArraySubCategories() {
        $select = $this->select();
        $select->from($this->_name, array('key'=>'id', 'value'=>'name'));
        $result = $this->getAdapter()->fetchAll($select);

        return $result;
    }
    
    public function getTableName(){
        return $this->_name;
    }
}