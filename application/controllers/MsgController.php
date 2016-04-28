<?php

class MsgController extends Zend_Controller_Action
{

    public function init()
    {
        $this->table = new Application_Model_DbTable_Msg();
    }

    public function indexAction()
    {
        $this->view->msg = $this->table->fetchAll();
    }

    public function updateAction()
    {
        $msg = $this->_request->getParam('msg');
        $this->table->update(array('description'=>$msg),'id = 1');
        $this->_redirect('/news/index');
    }


}



