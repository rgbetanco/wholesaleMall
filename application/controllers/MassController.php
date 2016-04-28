<?php

class MassController extends Zend_Controller_Action {

    public function init() {
        $this->table = new Application_Model_DbTable_Mass();
    }

    public function indexAction() {
        $data = $this->table->fetchAll();

        $paginator = Zend_Paginator::factory($data);
        $paginator->setCurrentPageNumber($this->_request->getParam('page', 1));
        $paginator->setItemCountPerPage(10);
        $this->view->data = $paginator;
    }

    public function addAction() {
        $form = new Application_Form_Mass();
        $form->setDecorators(array(array('ViewScript', array('viewScript' => 'massDecorator.phtml'))));

        $request = $this->getRequest();
        if ($request->isPost()) {
            if ($form->isValid($this->_request->getPost())) {
                $this->table->insert(array(
                    'subject' => $form->getValue('subject'),
                    'content' => $form->getValue('description'),
                    'created' => date('Y-m-d')
                ));
                $this->_redirect('/mass/index');
            } else {
                $this->view->message = 'Please fill in the required fields and try again';
            }
        }
        $this->view->form = $form;
    }

    public function deleteAction() {
        if ($this->getRequest()->isPost()) {
            $delete = $this->_request->getParam('delete');
        }

        foreach ($delete as $d) {
            $this->table->delete('id =' . $d);
        }

        $this->_redirect('/mass/index');
    }

    public function editAction() {
        $id = $this->_request->getParam('id');

        $form = new Application_Form_Mass();
        $form->setDecorators(array(array('ViewScript', array('viewScript' => 'massDecorator.phtml'))));

        $data = $this->table->find($id);

        foreach ($data as $d) {
            $form->getElement('subject')->setValue($d->subject);
            $form->getElement('description')->setValue($d->content);
        }

        $request = $this->getRequest();
        if ($request->isPost()) {
            if ($form->isValid($this->_request->getPost())) {
                $this->table->update(array(
                    'subject' => $form->getValue('subject'),
                    'content' => $form->getValue('description')
                        ), 'id=' . $id);
                $this->_redirect('/mass/index');
            } else {
                $this->view->message('Please fill up the missing fields and submit again');
            }
        }
        $this->view->form = $form;
    }

    public function sendAction() {
        $id = $this->_request->getParam('mass_id');
        $master = $this->table->find($id);
        $detail_table = new Application_Model_DbTable_MassDetail();
        $detail = $detail_table->fetchAll('mass_id =' . $id);
        $products = new Application_Model_Product();
        $message = "";
        foreach ($master as $m) {
            $subject = $m->subject;
            $message .= $m->content;
            $message .= "<br>";
            foreach ($detail as $d) {
                $pro = $products->getProductName($d->pro_id);
                $message .= $pro[0]->name;
                $message .= '<br>';
            }
        }
        $mail = new Zend_Mail();
        $mail->addHeader('Content-Type', 'text/plain');
        $mail->setSubject($subject);
        $mail->setBodyHtml($message);
        $mail->setFrom('rgbetanco@gmail.com', 'Dogo Admin');

        $customer_table = new Application_Model_DbTable_Register();
        $customers = $customer_table->fetchAll(array('spam = 1'));

        foreach ($customers as $c) {
            $mail->addTo($c->email);
        }
        //Send it!
        try {
            $mail->send();
            $this->_redirect('/mass/index');
        } catch (Exception $e) {
            $e->getMessage();
        }
    }

    public function downloadAction() {
        
        $id = $this->_request->getParam('mass_id');
        
        $master = $this->table->find($id);
        $detail_table = new Application_Model_DbTable_MassDetail();
        $detail = $detail_table->fetchAll('mass_id =' . $id);
        $products = new Application_Model_Product();
        $message = "";
        foreach ($master as $m) {
         //   $subject = $m->subject;
            $message .= $m->content;
            $message .= "<br>";
            foreach ($detail as $d) {
                $pro = $products->getProductName($d->pro_id);
                $message .= $pro[0]->name;
                $message .= '<br>';
            }
        }
        
        $file = 'exports/email.txt';
        file_put_contents($file,'');
        file_put_contents($file, $message);
        
        if (file_exists($file)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/txt');
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

}
