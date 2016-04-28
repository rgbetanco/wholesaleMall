<?php

class Application_Form_Combodetail extends Zend_Form {

    public function init() {
        $data = new Application_Model_DbTable_Products();
        $combo_table = new Application_Model_DbTable_Combos();
        $products = $data->getArrayProducts();
        $combodetail = $combo_table->getArrayCombo();
        
        $cdetail = new Zend_Form_Element_Select('cdetail');
        $cdetail->setRequired()
                ->removeDecorator('htmlTag')
                ->removeDecorator('DtDdWrapper')
                ->removeDecorator('Label')
                ->setAttribs(array(
                    'class' => 'form-control',
                    'size' => 1,
                    'onChange' => 'showDetail(this)'
                ))
                ->addMultiOptions($combodetail);
        
        $pro_id = new Zend_Form_Element_Multiselect('pro_id');
        $pro_id->setRequired()
                ->removeDecorator('htmlTag')
                ->removeDecorator('DtDdWrapper')
                ->removeDecorator('Label')
                ->setAttribs(array(
                    'class' => 'form-control',
                    'size' => 10
                ))
                ->addMultiOptions($products);
        
        $reset = new Zend_Form_Element_Reset('reset');
        $reset->removeDecorator('htmlTag')
                ->removeDecorator('DtDdWrapper')
                ->setLabel('Reset')
                ->removeDecorator('Label');
        $reset->setAttribs(array(
            'class' => 'btn btn-danger'
        ));

        $submit = new Zend_Form_Element_Submit('submit');
        $submit->removeDecorator('htmlTag')
                ->removeDecorator('DtDdWrapper')
                ->setLabel('Submit')
                ->removeDecorator('Label');
        $submit->setAttribs(array(
            'class' => 'btn btn-primary'
        ));

        $this->addElements(array($cdetail, $pro_id, $submit, $reset));
        $this->setMethod('post');
    }
}