<?php

class IndexController extends Zend_Controller_Action {

    public function init() {
        $banners = new Application_Model_DbTable_Banners();
        $this->view->banners = $banners->fetchAll();

        $cat = new Application_Model_DbTable_Subcategories();
        $this->view->clothing = $cat->getSubcategories(1);
        $this->view->accessories = $cat->getSubcategories(2);
    }

    public function indexAction() {
        $home = new Application_Model_DbTable_Home();
        
        $data = $home->fetchAll($home->select()->order('sort asc'));
        $this->view->pic1 = $data[0]->pic;
        $this->view->link1 = $data[0]->link;
        $this->view->pic2 = $data[1]->pic;
        $this->view->link2 = $data[1]->link;
        $this->view->pic3 = $data[2]->pic;
        $this->view->link3 = $data[2]->link;
        $this->view->pic4 = $data[3]->pic;
        $this->view->link4 = $data[3]->link;
        
        $data1 = $home->fetchAll($home->select()->order('position asc')->where('sort = 5'));
        $this->view->pic5 = $data1[0]->pic;
        $this->view->link5 = $data1[0]->link;
        $this->view->pic6 = $data1[1]->pic;
        $this->view->link6 = $data1[1]->link;
        $this->view->pic7 = $data1[2]->pic;
        $this->view->link7 = $data1[2]->link;
    }
    public function massAction() {
        // action body
    }
}