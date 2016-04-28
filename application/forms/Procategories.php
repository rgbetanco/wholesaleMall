<?php

class Application_Form_Procategories extends Zend_Form {

    public function init() {

        $data = new Application_Model_DbTable_Subcategories();
        $subcategories = $data->getArraySubCategories();

        $this->setAttribs(array(
            'role' => 'form',
            'class' => 'form-horizontal'
        ));
        $this->removeDecorator('DtDdWrapper');
        $this->removeDecorator('Label');

        $subcat_id = new Zend_Form_Element_Multiselect('subcat_id');
        $subcat_id->setRequired()
                ->removeDecorator('htmlTag')
                ->removeDecorator('DtDdWrapper')
                ->removeDecorator('Label')
                ->setAttribs(array(
                    'class' => 'form-control',
                    'size' => 20
                ))
                ->addMultiOptions($subcategories);
        
        $send = new Zend_Form_Element_Submit('Submit');
        $send->removeDecorator('Label');
        $send->removeDecorator('DtDdWrapper');
        $send->removeDecorator('htmlTag');
        $send->setAttribs(array(
            'label' => 'Submit',
            'class' => 'btn btn-primary'
        ));

        $reset = new Zend_Form_Element_Reset('Reset');
        $reset->removeDecorator('Label');
        $reset->removeDecorator('DtDdWrapper');
        $reset->removeDecorator('htmlTag');

        $reset->setAttribs(array(
            'label' => 'Reset',
            'class' => 'btn btn-danger'
        ));

        $hash = new Zend_Form_Element_Hash('csrf', array('ignore' => true));
        $hash->removeDecorator('Label');
        $this->addElements(array($subcat_id, $send, $reset, $hash));
        $this->setMethod('post');
    }
}