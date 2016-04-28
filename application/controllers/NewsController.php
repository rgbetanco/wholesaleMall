<?php

class NewsController extends Zend_Controller_Action {

    public function init() {
        $this->table = new Application_Model_DbTable_News();
        $this->session_sorting = new Zend_Session_Namespace('sortingnews');
    }

    public function indexAction() {
        Zend_View_Helper_PaginationControl::setDefaultViewPartial('pagecontrol.phtml');

        if (!isset($this->session_sorting->sort)) {
            $this->session_sorting->sort = 0;
        }

        if ($this->session_sorting->sort == 0) {
            $this->session_sorting->sort = 1;
            $sort = 'asc';
        } else {
            $this->session_sorting->sort = 0;
            $sort = 'desc';
        }

        $field = $this->_request->getParam('sort');

        if (!$field) {
            $field = 'sort';
        }

        $where = $this->table->select()->order($field . ' ' . $sort);
        $data = $this->table->fetchAll($where);

        $paginator = Zend_Paginator::factory($data);
        $paginator->setCurrentPageNumber($this->_getParam('page', 1));
        $paginator->setItemCountPerPage(10);
        $this->view->page = $this->_getParam('page');
        $this->view->news = $paginator;

        $msgtable = new Application_Model_DbTable_Msg();
        $msg = $msgtable->fetchAll();

        $this->view->msg = $msg;
    }

    public function addAction() {
        $form = new Application_Form_News();
        $form->setDecorators(array(array('ViewScript', array('viewScript' => 'newsDecorator.phtml'))));

        $request = $this->getRequest();
        if ($request->isPost()) {
            if ($form->isValid($this->_request->getPost())) {
                
                $adapter = $form->pic->getTransferAdapter();
                $adapter->receive();
                
                $this->table->insert(array(
                    'title' => $form->getValue('title'),
                    'description' => $form->getValue('description'),
                    'active' => $form->getValue('active'),
                    'sort' => $form->getValue('order'),
                    'pic' => $form->getValue('pic'),
                    'created' => date('Y-m-d')
                ));
                $this->_redirect('/news/index');
            } else {
                $this->view->message = 'Please fill up all the required fields';
            }
        }

        $this->view->form = $form;
    }

    public function updateAction() {
        $request = $this->getRequest();

        if ($request->isPost()) {
            $id = $this->_request->getParam('id');
            $title = $this->_request->getParam('title');
            $order = $this->_request->getParam('order');
            $status = $this->_request->getParam('active');
            $delete = $this->_request->getParam('delete');
            foreach ($id as $k => $v) {
                $this->table->update(array('title' => $title[$k], 'sort' => $order[$k], 'active' => $status[$k]), 'id =' . $v);

                if (in_array($v, $delete)) {
                    $this->table->delete(array('id =' . $v));
                }
            }
        }
        $this->_redirect('/news/index');
    }

    public function editAction() {
        $form = new Application_Form_News();
        $form->setDecorators(array(array('ViewScript', array('viewScript' => 'newsDecorator.phtml'))));
        
        $request = $this->getRequest();
        $id = $this->_request->getParam('id');
        
        $data = $this->table->find($id);
        
        foreach ($data as $d){
            $form->getElement('title')->setValue($d->title);
            $form->getElement('description')->setValue($d->description);
            $form->getElement('active')->setValue($d->active);
            $form->getElement('order')->setValue($d->sort);
            $pic = $d->pic;
        }
        //HTML cannot repopulate a file field for security reasons
        if($request->isPost()){
            if($form->isValid($this->_request->getPost())){
                $adapter = $form->pic->getTransferAdapter();
                $adapter->receive();
                $this->table->update(array(
                                     'title'=>$form->getValue('title'),
                                     'description'=>$form->getValue('description'),
                                     'active'=>$form->getValue('active'),
                                     'sort'=>$form->getValue('order'),
                                     'pic'=>$form->getValue('pic')),'id ='.$id);
                $this->_redirect('/news/index');
            }
        }
        $this->view->pic = $pic;
        $this->view->form = $form;
    }
}