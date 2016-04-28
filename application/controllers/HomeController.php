<?php

class HomeController extends Zend_Controller_Action {

    public function init() {
        $this->table = new Application_Model_DbTable_Home();
    }

    public function indexAction() {
        $form1 = new Application_Form_Home();
        $form1->setDecorators(array(array('ViewScript', array('viewScript' => 'homeDecorator.phtml'))));

        $form2 = new Application_Form_Home();
        $form2->setDecorators(array(array('ViewScript', array('viewScript' => 'homeDecorator.phtml'))));

        $form3 = new Application_Form_Home();
        $form3->setDecorators(array(array('ViewScript', array('viewScript' => 'homeDecorator.phtml'))));

        $form4 = new Application_Form_Home();
        $form4->setDecorators(array(array('ViewScript', array('viewScript' => 'homeDecorator.phtml'))));

        $form5 = new Application_Form_Home();
        $form5->setDecorators(array(array('ViewScript', array('viewScript' => 'home1Decorator.phtml'))));

        $form6 = new Application_Form_Home();
        $form6->setDecorators(array(array('ViewScript', array('viewScript' => 'home1Decorator.phtml'))));

        $form7 = new Application_Form_Home();
        $form7->setDecorators(array(array('ViewScript', array('viewScript' => 'home1Decorator.phtml'))));

        $data = $this->table->fetchAll();
        foreach ($data as $k => $d) {
            switch ($k) {
                case 0:
                    $this->view->pic1 = $d->pic;
                    $form1->getElement('link')->setValue($d->link);
                    $form1->getElement('sort')->setValue($d->sort);
                case 1:
                    $this->view->pic2 = $d->pic;
                    $form2->getElement('link')->setValue($d->link);
                    $form2->getElement('sort')->setValue($d->sort);
                case 2:
                    $this->view->pic3 = $d->pic;
                    $form3->getElement('link')->setValue($d->link);
                    $form3->getElement('sort')->setValue($d->sort);
                case 3:
                    $this->view->pic4 = $d->pic;
                    $form4->getElement('link')->setValue($d->link);
                    $form4->getElement('sort')->setValue($d->sort);
                case 4:
                    $this->view->pic5 = $d->pic;
                    $form5->getElement('link')->setValue($d->link);
                    $form5->getElement('position')->setValue($d->position);
                case 5:
                    $this->view->pic6 = $d->pic;
                    $form6->getElement('link')->setValue($d->link);
                    $form6->getElement('position')->setValue($d->position);
                case 6:
                    $this->view->pic7 = $d->pic;
                    $form7->getElement('link')->setValue($d->link);
                    $form7->getElement('position')->setValue($d->position);
            }
        }

        $this->view->form1 = $form1;
        $this->view->form2 = $form2;
        $this->view->form3 = $form3;
        $this->view->form4 = $form4;
        $this->view->form5 = $form5;
        $this->view->form6 = $form6;
        $this->view->form7 = $form7;
    }

    public function updateAction() {
        $id = $this->_request->getParam('id');

        if ($this->_request->getParam('slidings')) {
            $adapter = new Zend_File_Transfer_Adapter_Http();
            $adapter->setDestination(getcwd() . '/img/banners');
            $adapter->receive();
            $filename = $adapter->getFileName('banner', FALSE);
            if ($filename) {
                $this->table->update(array('pic' => $filename, 'link' => $this->_request->getParam('link'), 'sort' => $this->_request->getParam('sort')), 'id =' . $id);
            } else {
                $this->table->update(array('link' => $this->_request->getParam('link'), 'sort' => $this->_request->getParam('sort')), 'id =' . $id);
            }
        } else {
            $adapter = new Zend_File_Transfer_Adapter_Http();
            $adapter->setDestination(getcwd() . '/img/banners');
            $adapter->receive();
            $filename = $adapter->getFileName('banner', FALSE);
            if ($filename) {
                $this->table->update(array('pic' => $filename, 'link' => $this->_request->getParam('link'), 'position' => $this->_request->getParam('position')), 'id =' . $id);
            } else {
                $this->table->update(array('link' => $this->_request->getParam('link'), 'position' => $this->_request->getParam('position')), 'id =' . $id);
            }
        }
        $this->_redirect('/home/index');
    }

    public function contactusAction() {
        $tbl_about = new Application_Model_DbTable_About();
        $about = $tbl_about->fetchAll();
        $this->view->about = $about;
    }

    public function aboutusAction() {
        $tbl_about = new Application_Model_DbTable_About();
        $about = $tbl_about->fetchAll();
        $this->view->about = $about;
    }

    public function sizechartAction() {
        $cate = new Application_Model_DbTable_SizeCategories();
        $table = new Application_Model_DbTable_SizeChart();
        $msg_size = new Application_Model_DbTable_Msgsize();
        $message = $msg_size->fetchRow($msg_size->select()->where('id = ?', 1));
        $cat = $cate->fetchAll();
        $data = $table->fetchAll($table->select()->order('sort ASC'));
        $this->view->data = $data;
        $this->view->cat = $cat;
        $this->view->message = $message;
    }
    
}
