<?php

class OrderdetailController extends Zend_Controller_Action
{
    public function init()
    {
       $this->table = new Application_Model_DbTable_OrderDetail();
    }
    public function indexAction()
    {
        $id = $this->_request->getParam('id');
        $data = $this->table->fetchAll('order_id ='.$id);
        
        $currency = new Zend_Currency('USD');
        Zend_Registry::set('Zend_Currency', $currency);
        
        $paginator = Zend_Paginator::factory($data);
        $paginator->setCurrentPageNumber($this->_request->getParam('page', 1));
        $paginator->setItemCountPerPage(10);
        $this->view->data = $paginator;
    }

    public function indexprintAction()
    {
        $id = $this->_request->getParam('id');
        $data = $this->table->fetchAll('order_id ='.$id);
        
        $currency = new Zend_Currency('USD');
        Zend_Registry::set('Zend_Currency', $currency);
        
        $paginator = Zend_Paginator::factory($data);
        $paginator->setCurrentPageNumber($this->_request->getParam('page', 1));
        $paginator->setItemCountPerPage(10);
        $this->view->data = $paginator;
    }

    public function updateAction(){
        $request = $this->getRequest();
        $id = $this->_request->getParam('id');
        $order_id = $this->_request->getParam('order_id');
        if($request->isPost()){
            if($this->_request->getParam('update')){
                $price = $this->_request->getParam('price');
                $quantity = $this->_request->getParam('quantity');
                $this->table->update(array(
                    'price'=>$price,
                    'quantity'=>$quantity
                    ), 'id = '.$id);
            } else if($this->_request->getParam('delete')){
                $this->table->update(array(
                    'deleted'=>true,
                    ), 'id = '.$id);
            } else if ($this->_request->getParam('undelete')) {
                $this->table->update(array(
                    'deleted' => false,
                    ), 'id = '.$id);
            }
        }
        $this->_redirect('orders/display/id/'.$order_id);
    }
}