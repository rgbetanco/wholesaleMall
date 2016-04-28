<?php

class Application_Form_Massdetail extends Zend_Form
{

    public function init()
    {
        $data = new Application_Model_DbTable_Products();
        $products = $data->getArrayProducts();
        
        $this->setAttribs(array(
            'role' => 'form',
            'class' => 'form-horizontal'
        ));

        $this->removeDecorator('DtDdWrapper');
        $this->removeDecorator('Label');

        $pro_id = new Zend_Form_Element_Multiselect('pro_id');
        $pro_id->setRequired()
                ->removeDecorator('htmlTag')
                ->removeDecorator('DtDdWrapper')
                ->removeDecorator('Label')
                ->setAttribs(array(
                    'class' => 'form-control',
                    'size' => 20,
                ))
                ->addMultiOptions($products);
        
        $submit = new Zend_Form_Element_Submit('submit');
        $submit->removeDecorator('htmlTag')
                ->removeDecorator('DtDdWrapper')
                ->removeDecorator('Label');
        $submit->setAttribs(array(
            'class' => 'btn btn-default'
        ));
        
        $this->addElements(array($pro_id, $submit));
        $this->setMethod('post');
        
    }
}