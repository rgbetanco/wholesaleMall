<?php

class BasicsettingsController extends Zend_Controller_Action
{

    public function init()
    {
        $this->table = new Application_Model_DbTable_Basicsettings();
    }

    public function indexAction()
    {
        $form = new Application_Form_BasicSettings();
                $form->setDecorators(array(array('ViewScript', array('viewScript' => 'basicSettingsDecorator.phtml'))));
                $bs = $this->table->find(1);
                
                $request = $this->getRequest();
                if ($request->isPost()) {
                    if ($form->isValid($this->_request->getPost())) {  
                        $this->table->update(array(
                            'expire'=>$form->getValue('expire'),
                            'min_amount'=>$form->getValue('min_amount'),
                            'min_items'=>$form->getValue('min_items'),
                            'percentage'=>$form->getValue('percentage'),
                            'drop_ship'=>$form->getValue('drop_ship')), 'id = 1');
                  
                        $this->_redirect('basicsettings/display');
                    } else {
                        $this->view->errorMessage = "Please Fill in the Requiered Fields";
                    }
                }
                
                foreach ($bs as $b) {
                    $form->getElement('expire')->setValue($b['expire']);
                    $form->getElement('min_amount')->setValue($b['min_amount']);
                    $form->getElement('min_items')->setValue($b['min_items']);
                    $form->getElement('percentage')->setValue($b['percentage']);
                    $form->getElement('drop_ship')->setValue($b['drop_ship']);
                }
                
                $this->view->form = $form;
    }
    
    public function updateAction()
    {      
        //not being used
    }

    public function displayAction()
    {
        $tab = $this->_getParam('tab');
        $this->view->tab = $tab;
    }

    public function aboutusAction(){
        $frm =  new Application_Form_Aboutus();
        $frm->setDecorators(array(array('ViewScript', array('viewScript' => 'aboutusDecorator.phtml'))));

        $tbl_about = new Application_Model_DbTable_About();
        $data = $tbl_about->fetchAll();

        $frm->getElement('content')->setValue($data[0]->aboutus);

        $request = $this->getRequest();
        if ($request->isPost()) {
            if ($frm->isValid($this->_request->getPost())) {
                $tbl_about->update(array(
                    'aboutus' => $frm->getValue('content')
                ), 'id = 1');
                $this->_redirect('/basicsettings/aboutus');
            } else {
                $this->view->message = 'Please fill in the required fields and try again';
            }
        }

        $this->view->form = $frm;
    }

    public function contactusAction(){
        $frm =  new Application_Form_Contactus();
        $frm->setDecorators(array(array('ViewScript', array('viewScript' => 'contactusDecorator.phtml'))));

        $tbl_about = new Application_Model_DbTable_About();
        $data = $tbl_about->fetchAll();

        $frm->getElement('content')->setValue($data[0]->address);

        $request = $this->getRequest();
        if ($request->isPost()) {
            if ($frm->isValid($this->_request->getPost())) {
                $tbl_about->update(array(
                    'address' => $frm->getValue('content')
                ), 'id = 1');
                $this->_redirect('/basicsettings/contactus');
            } else {
                $this->view->message = 'Please fill in the required fields and try again';
            }
        }

        $this->view->form = $frm;
    }
}