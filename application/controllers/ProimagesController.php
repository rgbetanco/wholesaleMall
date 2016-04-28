<?php

class ProimagesController extends Zend_Controller_Action {

    public function init() {
        
    }

    public function indexAction() {

        $session_sorting = new Zend_Session_Namespace('sorting');
        $sort = $this->_request->getParam('sort');

        $id = $this->_request->getParam('id');

        Zend_View_Helper_PaginationControl::setDefaultViewPartial('pagecontrol.phtml');

        //list products
        $table = new Application_Model_DbTable_Proimages();

        if ($sort) {

            if (!isset($session_sorting->sort)) {
                $session_sorting->sort = 0;
            }

            if ($session_sorting->sort > 0) {
                $session_sorting->sort = 0;
                $data = $table->fetchAll($table->select()->where('p_id = ?', $id)->order($sort . ' DESC'));
            } else {
                $session_sorting->sort = 1;
                $data = $table->fetchAll($table->select()->where('p_id = ?', $id)->order($sort . ' ASC'));
            }
        } else {
            $data = $table->fetchAll($table->select()->where('p_id = ?', $id));
        }

        $paginator = Zend_Paginator::factory($data);
        $paginator->setCurrentPageNumber($this->_getParam('page', 1));
        $paginator->setItemCountPerPage(10);

        $product = new Application_Model_Product();
        $proName = $product->getProductName($id);

        $this->view->productname = $proName[0]->name;

        $czObject = new Application_Model_Procolorsizes();
        $colors = $czObject->getColors();
        $b[0] = 'default';
        foreach ($colors as $value) {
            $b[$value->id] = $value->name;
        }

        $this->view->colors = $b;

        $this->view->pictures = $paginator;
        $this->view->page = $this->_request->getParam('page');
        $this->view->id = $id;
    }

    public function updateAction() {
        $table = new Application_Model_DbTable_Proimages();
        $m = new Application_Model_Proimages();

        $page = $this->_getParam('page');

        $pic_id = $this->_request->getParam('pic_id');
        $pro_id = $this->_request->getParam('pro_id');

        $colors = $this->_request->getParam('colors');
        $names = $this->_request->getParam('names');
        $sort = $this->_request->getParam('sort');
        $delete = $this->_request->getParam('delete');

        foreach ($pic_id as $k => $v) {
            $table->update(array('c_id' => $colors[$k]), array('id=' . $v));
            $table->update(array('sort' => $sort[$k]), array('id=' . $v));

            if (in_array($v, $delete)) {
                $table->delete(array('id=' . $v));
                $records = $m->getImageByName($names[$k]);
                if ($records < 1) {
                    unlink(APPLICATION_PATH . '/../public/products_img' . DIRECTORY_SEPARATOR . $names[$k]);
                }
            }
        }

        //updating the picture field in the product table
        $model = new Application_Model_Product();
        $model->updatePicture($pro_id);

        if (!$page) {
            $this->_redirect('products/detail/tab/image/id/' . $pro_id);
        } else {
            $this->_redirect('products/detail/tab/image/id/' . $pro_id . '/page/' . $page);
        }
    }

    public function addformAction() {
        $id = $this->_request->getParam('id');

        $form = new Application_Form_Proimages();
        $form->setDecorators(array(array('ViewScript', array('viewScript' => 'proimagesDecorator.phtml'))));
        $request = $this->getRequest();
        if ($request->isPost()) {
            if ($form->isValid($this->_request->getPost())) {
                $proimages = new Application_Model_Proimages();
                $adapter = $form->file->getTransferAdapter();
                $i = 0;
                foreach ($adapter->getFileInfo() as $key => $info) {
                    if ($adapter->isUploaded($key)) {
                        $fname = $this->path . '../public/products_img/' . $info['name'];
                        $tfname = $this->path . '../public/products_thu/' . $info['name'];
                        $adapter->addFilter(new Zend_Filter_File_Rename(array('target' => $fname, 'overwrite' => true)), null, $key);

                        $adapter->receive($key);

                        copy($fname, $tfname);

                        $image = new Application_Model_Thumbnail($tfname);
                        $image->cropFromCenter(450);
                        $image->save($tfname);

                        $proimages->addNewPic(array(
                            'p_id' => $id,
                            'c_id' => $form->getValue('c_id'),
                            'name' => $info['name'],
                            'sort' => $i,
                            'created' => date('Y-m-d H:i:s')
                        ));
                        $i++;
                    }
                }
                //updating the picture field in the product table
                $model = new Application_Model_Product();
                $model->updatePicture($id);

                $this->_redirect('products/detail/tab/image/id/' . $id);
            } else {
                $this->view->errorMessage = "Please Fill in the Requiered Fields";
            }
        }
        $this->view->form = $form;
    }

}
