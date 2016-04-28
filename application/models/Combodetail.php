<?php

class Application_Model_Combodetail
{
    public function __construct() {
        $this->table = new Application_Model_DbTable_ComboDetail();
    }

    public function saveComboDetail($data){
        $this->table->insert($data);
    }
    
    public function getComboDetail($id){
        $where = $this->table->getAdapter()->quoteInto('combo_id = ?',$id);
        return $this->table->fetchAll($where);
    }

}