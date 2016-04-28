<?php

class Application_Model_DbTable_SizeCategories extends Zend_Db_Table_Abstract
{

    protected $_name = 'size_categories';
    
    public function getTableName(){
        return $this->_name;
    }
    
}