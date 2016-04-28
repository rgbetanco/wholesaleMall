<?php

class Application_Model_Product {

    public function addNewPro($data) {
        $reg = new Application_Model_DbTable_Products();
        $reg->insert($data);
    }

    public function updatePro($data, $id) {
        $pro = new Application_Model_DbTable_Products();
        $where = $pro->getAdapter()->quoteInto('id = ?', $id);
        $pro->update($data, $where);
    }
    
    public function getProductName($id){
        $pro = new Application_Model_DbTable_Products();
        $data = $pro->find($id);
        return $data;
    }
    
    public function updatePicture($id){
        $images = new Application_Model_DbTable_Proimages();
        $row = $images->fetchRow($images->select()->where('p_id ='.$id)->order('sort asc'));
        $pic_name = $row->name; 
        
        $pro_table = new Application_Model_DbTable_Products();
        $pro_table->update(array('picture'=>$pic_name), 'id ='.$id);
    }
    
    public function getProductField($id, $field){
        $pro = new Application_Model_DbTable_Products();
        $row = $pro->fetchRow("product_id = '".$id."'");
        return $row->$field;
    }
    
    public function getProductFieldById($id, $field){
        $pro = new Application_Model_DbTable_Products();
        $row = $pro->fetchRow('id = '.$id);
        return $row->$field;
    }
}