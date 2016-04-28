<?php

class Application_Model_Subcategories
{

    public function addNewRecord($data){
        $table = new Application_Model_DbTable_Subcategories();
        $table->insert($data);
    }

}

