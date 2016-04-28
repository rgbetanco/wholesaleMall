<?php

class StoresController extends Zend_Controller_Action {

    public function init() {
        $this->table = new Application_Model_DbTable_Stores();
    }

    public function indexAction() {
        $id = $this->_request->getParam('id');
        $delete = $this->_request->getParam('delete');

        if ($id) {
            foreach ($id as $v) {
                if (in_array($v, $delete)) {
                    $this->table->delete('id=' . $v);
                }
            }
        }
        $data = $this->table->fetchAll();
        $paginator = Zend_Paginator::factory($data);
        $paginator->setCurrentPageNumber($this->_request->getParam('page', 1));
        $paginator->setItemCountPerPage(50);

        $this->view->stores = $paginator;
    }

    public function addAction() {
        $form = new Application_Form_Stores();
        $form->setDecorators(array(array('ViewScript', array('viewScript' => 'storesDecorator.phtml'))));

        $request = $this->getRequest();

        if ($request->isPost()) {
            if ($form->isValid($this->_request->getPost())) {
                $this->table->insert(array(
                    'name' => $form->getValue('name'),
                    'active' => $form->getValue('active'),
                    'address' => $form->getValue('address'),
                    'country' => $form->getValue('country'),
                    'state' => $form->getValue('state'),
                    'city' => $form->getValue('city'),
                    'zip_code' => $form->getValue('zip_code'),
                    'latlng' => $form->getValue('latlng'),
                    'website' => $form->getValue('website'),
                    'created' => date('Y-m-d'),
                ));

                $this->_redirect('/stores/index');
            }
        }
        $this->view->form = $form;
    }

    public function editAction() {
        $id = $this->_request->getParam('id');
        $data = $this->table->find($id);
        $form = new Application_Form_Stores();
        $form->setDecorators(array(array('ViewScript', array('viewScript' => 'storesDecorator.phtml'))));
        foreach ($data as $d) {
            $form->getElement('name')->setValue($d->name);
            $form->getElement('active')->setValue($d->active);
            $form->getElement('address')->setValue($d->address);
            $form->getElement('city')->setValue($d->city);
            $form->getElement('state')->setValue($d->state);
            $form->getElement('country')->setValue($d->country);
            $form->getElement('zip_code')->setValue($d->zip_code);
            $form->getElement('latlng')->setValue($d->latlng);
            $form->getElement('website')->setValue($d->website);
        }
        $request = $this->getRequest();
        if ($request->isPost()) {
            if ($form->isValid($this->_request->getPost())) {
                $this->table->update(array(
                    'name' => $form->getValue('name'),
                    'active' => $form->getValue('active'),
                    'address' => $form->getValue('address'),
                    'country' => $form->getValue('country'),
                    'state' => $form->getValue('state'),
                    'city' => $form->getValue('city'),
                    'zip_code' => $form->getValue('zip_code'),
                    'latlng' => $form->getValue('latlng'),
                    'website' => $form->getValue('website'),
                        ), 'id =' . $id);

                $this->_redirect('/stores/index');
            }
        }

        $this->view->form = $form;
    }

    public function exportAction() {
        $list = $this->table->fetchAll();
        $fp = fopen('exports/stores.csv', 'w');

        foreach ($list->toArray() as $f) {
            fputcsv($fp, $f);
        }
        fclose($fp);

        $file = 'exports/stores.csv';

        if (file_exists($file)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/csv');
            header('Content-Disposition: attachment; filename=' . basename($file));
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file));
            ob_clean();
            flush();
            readfile($file);
            exit;
        }
    }

    public function uploadAction() {
        $adapter = new Zend_File_Transfer_Adapter_Http();
        $adapter->addValidator('Size', false, '20000');
        $adapter->addValidator('Extension', false, 'csv');

        $adapter->setDestination(APPLICATION_PATH . '/../public/development/imports');

        if ($adapter->isValid()) {
            if (!$adapter->receive()) {
                $messages = $adapter->getMessages();
                $this->view->messages = implode("\n", $messages);
            } else {
                $this->table->delete('1=1');
                $filename = $adapter->getFileName();
                if (($handle = fopen($filename, "r")) !== FALSE) {
                    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                        $this->table->insert(array(
                            'name' => $data[1],
                            'active' => $data[2],
                            'address' => $data[3],
                            'country' => $data[4],
                            'state' => $data[5],
                            'city' => $data[6],
                            'zip_code' => $data[7],
                            'latlng' => $data[8],
                            'website' => $data[9],
                            'created' => $data[10],
                        ));
                    }
                    fclose($handle);
                }
            }
        } else {
            $this->view->messages = "Invalid File";
        }
        $this->_redirect('stores/index');
    }

    public function displayAction() {
        
        $country = $this->_request->getParam('country');
        $city = $this->_request->getParam('city');

        if(!$country){
            $country = 'USA';
        }

        if(!$city){
            $city = 'All';
        }
        
        $tbl_store = new Application_Model_DbTable_Stores();
        $where = $tbl_store->select()->group('country')->order('country DESC');
        $countries = $tbl_store->fetchAll($where);
        $this->view->countries = $countries;
        $this->view->selected_country = $country;

        $whereCity = $tbl_store->select()->group('city')->where('country LIKE ?',$country)->order('city ASC');
        $cities = $tbl_store->fetchAll($whereCity);
        $this->view->cities = $cities;
        $this->view->selected_city = $city;        
        
        if($city == 'All'){
            $search = $tbl_store->select()->where("country LIKE ?",$country)->order("city ASC");
            $stores = $tbl_store->fetchAll($search);
            $this->view->stores = $stores;
        } else {
            $search = $tbl_store->select()->where("city LIKE ?",$city);
            $stores = $tbl_store->fetchAll($search);
            $this->view->stores = $stores;
        }
    }
}