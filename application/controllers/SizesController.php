<?php

class SizesController extends Zend_Controller_Action {

    public function init() {
        /* Initialize action controller here */
    }

    public function indexAction() {
        // action body
    }

    public function getnameAction() {
        $id = $this->_request->getParam('id');
        $table = new Application_Model_DbTable_Sizes();
        $this->view->nameRowSet = $table->find($id);
    }

    public function formAction() {
        $form = new Application_Form_Sizes();
        $form->setDecorators(array(array('ViewScript', array('viewScript' => 'sizesDecorator.phtml'))));

        $request = $this->getRequest();
        if ($request->isPost()) {
            if ($form->isValid($this->_request->getPost())) {
                $addRec = new Application_Model_Sizes();
                $addRec->addNewRecord(array(
                    'name' => $form->getValue('name'),
                    'sort' => $form->getValue('sort')
                ));
                $this->_redirect('colors/display/tab/sizeform');
            } else {
                $this->view->errorMessage = "Please Fill in the Requiered Fields";
            }
        }

        $this->view->form = $form;
    }

    public function listAction() {
        $table = new Application_Model_Sizes();
        
        $sort = $this->_getParam('sortz');
        $data = $table->getSizes($sort);
        
        $paginator = Zend_Paginator::factory($data);
        $paginator->setCurrentPageNumber($this->_getParam('pagez', 1));
        $paginator->setItemCountPerPage(10);
        $this->view->pagez = $this->_getParam('pagez');
        $this->view->data = $paginator;
    }

    public function updateAction() {
        $table = new Application_Model_DbTable_Sizes();

        $id = $this->_request->getParam('id');
        $name = $this->_request->getParam('name');
        $sort = $this->_request->getParam('sort');
        $delete = $this->_request->getParam('delete');
        
        $page = $this->_request->getParam('pagez');
        $tab = $this->_request->getParam('tab');

        foreach ($id as $k => $id) {
            $table->update(array('name' => $name[$k]), array('id=' . $id));
            $table->update(array('sort' => $sort[$k]), array('id=' . $id));

            if (in_array($id, $delete)) {
                $table->delete(array('id=' . $id));
            }
        }
        $this->_redirect('colors/display/tab/'.$tab.'/pagez/'.$page);
    }

    public function sizecategoryAction(){
        $table = new Application_Model_DbTable_SizeCategories();
        $data = $table->fetchAll();

        $request = $this->getRequest();
        if($request->isPost()){
            $id = $this->_request->getParam('id');
            $length = $this->_request->getParam('length');
            $neck = $this->_request->getParam('neck');
            $girth = $this->_request->getParam('girth');
            $width = $this->_request->getParam('width');

            $delete = $this->_request->getParam('delete');

            foreach ($id as $k => $v) {
                (in_array($v, $length))?$table->update(array('length'=>1),array('id ='.$v)):$table->update(array('length'=>0), array('id ='.$v));
                (in_array($v, $neck))?$table->update(array('neck'=>1),array('id ='.$v)):$table->update(array('neck'=>0), array('id ='.$v));
                (in_array($v, $girth))?$table->update(array('girth'=>1),array('id ='.$v)):$table->update(array('girth'=>0), array('id ='.$v));
                (in_array($v, $width))?$table->update(array('width'=>1),array('id ='.$v)):$table->update(array('width'=>0), array('id ='.$v));

                if(in_array($v, $delete)){
                    $table->delete(array('id = '.$v));
                }
            }
            $this->_redirect('sizes/sizecategory');
        }

        $this->view->data = $data;
    }

    public function addcategoryAction(){
        $table = new Application_Model_DbTable_SizeCategories();

        $request = $this->getRequest();
        if ($request->isPost()){
            $name = $this->_request->getParam('name');
            $table->insert(array('name'=>$name));
        }
        $this->_redirect('sizes/sizecategory');
    }

    public function chartAction(){
        $tbl_cat = new Application_Model_DbTable_SizeCategories();
        $table = new Application_Model_DbTable_SizeChart();
        $tbl_size = new Application_Model_DbTable_Sizes();

        $request = $this->getRequest();
        if($request->isPost()){
            $id = $this->_request->getParam('id');
            $delete = $this->_request->getParam('delete');
            foreach ($id as $k => $v) {
                if (in_array($v, $delete)){
                    $table->delete(array('id = '.$v));
                }   
            }
        }

        $data = $table->fetchAll();
        $categories = $tbl_cat->fetchAll();
        $sizes = $tbl_size->fetchAll();

        $this->view->data = $data;
        $this->view->categories = $categories;
        $this->view->sizes = $sizes;
    }

    public function addtochartAction(){
        $table = new Application_Model_DbTable_SizeChart();

        $request = $this->getRequest();
        if($request->isPost()){
            $catName  =  $this->_request->getParam('catName');
            $sizeName =  $this->_request->getParam('sizeName');
            $lengthCM =  $this->_request->getParam('lengthCM');
            $lengthIN =  $this->_request->getParam('lengthIN');
            $neckCM   =  $this->_request->getParam('neckCM');
            $neckIN   =  $this->_request->getParam('neckIN');
            $girthCM  =  $this->_request->getParam('girthCM');
            $girthIN  =  $this->_request->getParam('girthIN');
            $widthCM  =  $this->_request->getParam('widthCM');
            $widthIN  =  $this->_request->getParam('widthIN');
            $sort     =  $this->_request->getParam('sort');

            $table->insert(array('cat_name'=>$catName, 
                                 'size'=>$sizeName, 
                                 'length_cm'=>$lengthCM,
                                 'length_in'=>$lengthIN,
                                 'neck_cm'=>$neckCM,
                                 'neck_in'=>$neckIN,
                                 'girth_cm'=>$girthCM,
                                 'girth_in'=>$girthIN,
                                 'width_cm'=>$widthCM,
                                 'width_in'=>$widthIN,
                                 'sort'=>$sort
                                 ));
        }
        $this->_redirect('sizes/chart');
    }

    public function changemsgAction(){
        $table = new Application_Model_DbTable_Msgsize();

        $request = $this->getRequest();
        if($request->isPost()){
            $description = $this->_request->getParam('description');
            $table->update(array('description'=>$description), 'id = 1');
        }

        $msg = $table->fetchRow($table->select()->where('id = ?', 1));
        $this->view->message = $msg;
    }
}
