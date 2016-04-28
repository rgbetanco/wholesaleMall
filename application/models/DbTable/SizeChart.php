<?php

class Application_Model_DbTable_SizeChart extends Zend_Db_Table_Abstract
{

    protected $_name = 'size_chart';
    
    public function getTableName(){
        return $this->_name;
    }
    
}