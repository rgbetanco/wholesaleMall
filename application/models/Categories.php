<?php

class Application_Model_Categories
{

    public function addNewRecord($data){
        $table = new Application_Model_DbTable_Categories();
        try{
            $table->insert($data);
        } catch(Exception $e){
            $e->getMessage();
        }
    }
    
    public function getCategories(){
        $table = new Application_Model_DbTable_Categories();
        $where = $table->select()->from('categories', array('key'=>'id','value'=>'name'));
        $data = $table->getAdapter()->fetchAll($where);
        return $data;
    }

}

