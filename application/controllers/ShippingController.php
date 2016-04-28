<?php

class ShippingController extends Zend_Controller_Action {

    public function init() {
        
    }

    public function indexAction() {
        $id = $this->_request->getParam('reg_id');
        $this->view->id = $id;
        if ($id) {
            $form_ship = new Application_Form_Shipping();
            $form_ship->setDecorators(array(array('ViewScript', array('viewScript' => 'shippingDecorator.phtml'))));
            $request = $this->getRequest();
            if ($request->isPost()) {
                if ($form_ship->isValid($this->_request->getPost())) {
                    $addShipping = new Application_Model_Shipping();
                    $addShipping->addShipping(array(
                        'reg_id' => $id,
                        'first_name' => $form_ship->getValue('first_name'),
                        'last_name' => $form_ship->getValue('last_name'),
                        'address' => $form_ship->getValue('address'),
                        'city' => $form_ship->getValue('city'),
                        'state' => $form_ship->getValue('state'),
                        'zip' => $form_ship->getValue('zip'),
                        'country' => $form_ship->getValue('country'),
                        'phone' => $form_ship->getValue('phone'),
                        'created' => date('Y-m-d H:i:s')
                    ));
                    $this->_redirect('register/detail/tab/ship/reg_id/' . $id);
                } else {
                    $this->view->errorMessage = "Please Fill in the Requiered Fields";
                }
            }
            $this->view->form = $form_ship;
        } else {
            $this->_redirect('register/detail');
        }
    }

    public function listAction() {

        $id = $this->_request->getParam('reg_id');
        $tab = $this->_request->getParam('tab');
        $this->view->reg_id = $id;
        $table = new Application_Model_DbTable_Shipping();
        $data = $table->fetchAll($table->select()->where('reg_id = ?', $id));

        $paginator = Zend_Paginator::factory($data);
        $paginator->setCurrentPageNumber($this->_getParam('pages', 1));
        $paginator->setItemCountPerPage(50);

        $tbl_states = new Application_Model_DbTable_States();
        $states = $tbl_states->getStates();

        $this->view->data = $paginator;
        $this->view->states = $states;
        $this->view->tab = $tab;
    }

    public function deleteAction() {
        $id = $this->_request->getParam('add_id');
        $reg_id = $this->_request->getParam('reg_id');
        $table = new Application_Model_DbTable_Shipping();
        $where = $table->getAdapter()->quoteInto('id = ?', $id);
        $table->delete($where);
        $this->_redirect('shipping/list/reg_id/' . $reg_id);
    }

    public function editAction() {
        $id = $this->_request->getParam('id');
        $ship_id = $this->_request->getParam('reg_id');
        
        $table = new Application_Model_DbTable_Shipping();
        $data = $table->find($id);

        $this->view->id = $id;
        $this->view->ship_id = $ship_id;

        foreach ($data as $dat) {
            $address = $dat['address'];
            $city = $dat['city'];
            $state = $dat['state'];
            $zip = $dat['zip'];
            $country = $dat['country'];
        }

        $form_ship = new Application_Form_Shipping();
        $form_ship->setDecorators(array(array('ViewScript', array('viewScript' => 'shippingDecorator.phtml'))));
        $form_ship->getElement('address')->setValue($address);
        $form_ship->getElement('city')->setValue($city);
        $form_ship->getElement('state')->setValue($state);
        $form_ship->getElement('zip')->setValue($zip);
        $form_ship->getElement('country')->setValue($country);

        $request = $this->getRequest();
        if ($request->isPost()) {
            if ($form_ship->isValid($this->_request->getPost())) {
                $updateShip = new Application_Model_Shipping();
                $updateShip->updateShip(array(
                    'address' => $form_ship->getValue('address'),
                    'city' => $form_ship->getValue('city'),
                    'state' => $form_ship->getValue('state'),
                    'zip' => $form_ship->getValue('zip'),
                    'country' => $form_ship->getValue('country')
                        ), $id);
                $this->_redirect('register/detail/tab/ship/reg_id/' . $ship_id);
            } else {
                $this->view->errorMessage = "Please Fill in the Requiered Fields";
            }
        }
        $this->view->form_ship = $form_ship;
    }

    public function updateAction() {
        $table = new Application_Model_DbTable_Shipping();

        $pages = $this->_request->getParam('pages');
        $tab = $this->_request->getParam('tab');

        $rec_id = $this->_request->getParam('id');
        $reg_id = $this->_request->getParam('reg_id');
        $first_name = $this->_request->getParam('first_name');
        $last_name = $this->_request->getParam('last_name');
        $address = $this->_request->getParam('address');
        $city = $this->_request->getParam('city');
        $state = $this->_request->getParam('state');
        $zip = $this->_request->getParam('zip');
        $country = $this->_request->getParam('country');
        $phone = $this->_request->getParam('phone');
        $delete = $this->_request->getParam('delete');

        foreach ($rec_id as $k => $id) {
            $table->update(array('first_name' => $first_name[$k]), array('id=' . $id));
            $table->update(array('last_name' => $last_name[$k]), array('id=' . $id));
            $table->update(array('address' => $address[$k]), array('id=' . $id));
            $table->update(array('city' => $city[$k]), array('id=' . $id));
            $table->update(array('state' => $state[$k]), array('id=' . $id));
            $table->update(array('zip' => $zip[$k]), array('id=' . $id));
            $table->update(array('country' => $country[$k]), array('id=' . $id));
            $table->update(array('phone' => $phone[$k]), array('id=' . $id));

            if (in_array($id, $delete)) {
                $table->delete(array('id=' . $id));
            }
        }

        if (!$pages) {
            $this->_redirect('register/detail/tab/ship/reg_id/' . $reg_id);
        } else {
            $this->_redirect('register/detail/tab/ship/reg_id/' . $reg_id . '/pages/'.$pages);
        }
    }

}
