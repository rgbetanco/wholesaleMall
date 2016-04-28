<?php

class Application_Model_Proimages
{

    public function addNewPic($data){
        $table = new Application_Model_DbTable_Proimages();
        $table->insert($data);
    }
    
    public function getImageByName($param){
        $table = new Application_Model_DbTable_Proimages();
        $where = $table->getAdapter()->quoteInto('name = ?', $param);
        $data = $table->fetchAll($where);
        $count = $data->count();
        return $count;
    }

}

