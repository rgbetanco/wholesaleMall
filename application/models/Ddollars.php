<?php

class Application_Model_Ddollars
{
    public function getAmount($id){
        $table = new Application_Model_DbTable_Ddollars();
        $where = $table->getAdapter()->quoteInto('reg_id = ?', $id);
        $data = $table->fetchAll($where);
        
        $total = 0;
        
        foreach($data as $d){
            $total += $d->amount;
        }
        return $total;
    }
    
    public function addNewDdollar($data){
        $table = new Application_Model_DbTable_Ddollars();
        $table->insert($data);
    }
    
    public function updateDdollar($data, $id){
        $table = new Application_Model_DbTable_Ddollars();
        $where = $table->getAdapter()->quoteInto('id = ?', $id);
        $table->update($data, $where);
    }

    public function updateDdollarByOrder($data, $id){
        $table = new Application_Model_DbTable_Ddollars();
        //$where = $table->select()->where('order = ?', $id);
        $table->update($data, 'dogo_dollars.order = '.$id);
    }
    
    public function deleteDdollar($id){
        $table = new Application_Model_DbTable_Ddollars();
        $where = $table->getAdapter()->quoteInto('id = ?', $id);
        $table->delete($where);
    }
}

