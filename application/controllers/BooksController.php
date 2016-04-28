<?php

class BooksController extends Zend_Controller_Action
{

    public function init()
    {
       // 
    }

    public function indexAction()
    {
        // action body
    }

    public function listAction()
    {	
        $booksTBL = new Application_Model_DbTable_Book();
        $this->view->books = $booksTBL->fetchAll();
        $this->view->hello = $booksTBL->fetchAll();
    }


}



