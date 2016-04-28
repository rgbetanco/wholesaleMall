<?php

class CombosController extends Zend_Controller_Action {

    public function init() {
        $this->combos = new Application_Model_Combos();
        $this->combodetail = new Application_Model_Combodetail();
        $this->table = new Application_Model_DbTable_Combos();
    }

    public function indexAction() {
        //I am using this method for an ajax call from add action (combo controller)
        $this->_helper->viewRenderer->setNoRender(true);
        $this->_helper->layout->disableLayout();
        
        $db = Zend_Db_Table::getDefaultAdapter();
        
        $id = $this->_request->getParam('id');  
        $select = $db->select()->from(array('cd'=>'combo_detail'),array('id','combo_id','pro_id'))->join(array('p'=>'products'), 'p.id = cd.pro_id',array('name'))->where('combo_id = ?', $id);
 
        $stmt = $db->query($select);
        $result = $stmt->fetchAll();
 
        foreach($result as $k => $cd){
            echo "<tr>";
            echo "<input type='hidden' value=".$result[$k]['combo_id']." name='combo_id'>";
            echo "<td>".$result[$k]['name']."</td>";
            echo "<td align=center><input type='checkbox' name='delete[]' value='".$result[$k]['id']."' /></td>";
            echo "</tr>";
        }
    }

    public function listAction() {
        
        $sort = $this->_request->getParam('sort');
        $search = $this->_request->getParam('search');

        $combos = $this->combos->getCombos($sort,$search);
        
        $page = $this->_request->getParam('page');
        
        $paginator = Zend_Paginator::factory($combos);
        $paginator->setCurrentPageNumber($this->_request->getParam('page', 1));
        $paginator->setItemCountPerPage(10);
        $this->view->page = $page;
        $this->view->combos = $paginator;
    }

    public function addAction() {
        
    }

    public function displayAction() {
        $tab = $this->_request->getParam('tab');
        $page = $this->_request->getParam('page');
        $sort = $this->_request->getParam('sort');
        $search = $this->_request->getParam('search');
        $combo_id = $this->_request->getParam('id');
        $this->view->tab = $tab;
        $this->view->page = $page;
        $this->view->sort = $sort;
        $this->view->search = $search;
        $this->view->comboid = $combo_id;
    }

    public function updateAction() {

        $page = $this->_request->getParam('page');

        $id = $this->_request->getParam('id');
        $name = $this->_request->getParam('name');
        $price = $this->_request->getParam('price');
        $active = $this->_request->getParam('active');
        $order = $this->_request->getParam('order');
        $delete = $this->_request->getParam('delete');

        foreach ($id as $k => $id) {
            $this->table->update(array('name' => $name[$k]), array('id=' . $id));
            $this->table->update(array('price' => $price[$k]), array('id=' . $id));
            $this->table->update(array('sort' => $order[$k]), array('id=' . $id));

            if (in_array($id, $active)) {
                $this->table->update(array('active' => 1), array('id=' . $id));
            } else {
                $this->table->update(array('active' => 0), array('id=' . $id));
            }

            if (in_array($id, $delete)) {
                $this->table->delete(array('id=' . $id));
            }
        }

        if (!$page) {
            $this->_redirect('combos/display/tab/combolist');
        } else {
            $this->_redirect('combos/display/page/' . $page);
        }
    }

    public function searchAction() {
        // action body
    }

    public function formAction() {
        $form = new Application_Form_Combo();
        $form->setDecorators(array(array('ViewScript', array('viewScript' => 'comboDecorator.phtml'))));

        $request = $this->getRequest();
        if ($request->isPost()) {
            if ($form->isValid($this->_request->getPost())) {
                $name = $form->getValue('name');
                $price = $form->getValue('price');
                $active = $form->getValue('active');
                $order = $form->getValue('order');
                
                $this->combos->saveCombo(array(
                    'name' => $name,
                    'price' => $price,
                    'active' => $active,
                    'sort' => $order,
                    'created' => date('Y-m-d H:i:s')
                ));
            
                $this->_redirect('combos/display/tab/comboform');
            } else {
                $this->view->errorMessage = "Please Fill in the Requiered Fields";
            }
        }
        $this->view->form = $form;
    }
}