<?php

class Application_Model_Colors
{
    public function __construct() {
        $this->table = new Application_Model_DbTable_Colors();
    }

    public function addNewRecord($data){
        //$table = new Application_Model_DbTable_Colors();
        $this->table->insert($data);
    }
    
    public function getColors($sort) {

        $session_sorting = new Zend_Session_Namespace('sortingcolors');
        
        $order = 'asc';
        if($sort){
            if($session_sorting->sort == 0){
                $order = 'desc';
                $session_sorting->sort = 1;
            } else {
                $order = 'asc';
                $session_sorting->sort = 0;
            }
        } else {
            $sort = 'sort';
        }
       
        $where = $this->table->select()->order($sort.' '.$order);
        return $this->table->fetchAll($where);
    }
    
}

