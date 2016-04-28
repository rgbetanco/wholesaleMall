<?php

class Application_Model_Shipping
{

       public function addShipping($data){
           $ship = new Application_Model_DbTable_Shipping();
            $ship->insert($data);
       }
       
       public function updateShip($data, $id){
            $ship = new Application_Model_DbTable_Shipping();
            $where = $ship->getAdapter()->quoteInto('id = ?', $id);
            $ship->update($data, $where);
       }

}

