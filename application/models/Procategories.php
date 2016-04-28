<?php

class Application_Model_Procategories
{
     public function getProcategories($id){
         $table = new Application_Model_DbTable_Procategories();
         $select = $table->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
         $select->setIntegrityCheck(FALSE)
                 ->where('pro_id=?',$id)
                 ->join('subcategories', 'subcategories.id = product_categories.subcat_id','name')
                 ;

         $data = $table->fetchAll($select);
         return $data;
     }
     public function updateSubcategories($id){
         $table = new Application_Model_DbTable_Products();
         $table->update(array('subcategories'=>''),'id = '.$id);
         
         foreach($this->getProcategories($id) as $k => $d){
             $str .= $d->name.',';
         }
         $table->update(array('subcategories'=>$str),'id = '.$id);
     }
}