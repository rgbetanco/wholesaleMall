<?php

class Application_Model_Procolorsizes
{

    public function addNew($data) {
        $reg = new Application_Model_DbTable_Procolorsizes();
        $reg->insert($data);
    }
    
    public function getColors(){
      $table = new Application_Model_DbTable_Colors();
      $result = $table->fetchAll();
      return $result;
    }
    
    public function getSizes(){
      $table = new Application_Model_DbTable_Sizes();
      $result = $table->fetchAll();
      return $result;
    }
}

