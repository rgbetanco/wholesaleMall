<?php

class Application_Form_Combo extends Zend_Form
{

    public function init()
    {   
        $this->setAttribs(array(
            'role' => 'form',
            'class' => 'form-horizontal'
        ));

        $this->removeDecorator('DtDdWrapper');
        $this->removeDecorator('Label');
        
        $name = new Zend_Form_Element_Text('name');
        $name->removeDecorator('htmlTag')
                ->setRequired()
                ->removeDecorator('DtDdWrapper')
                ->removeDecorator('Label')
                ->setAttrib('size', '20')
                ->setAttribs(array(
                    'placeholder' => 'Combo Name',
                    'class' => 'form-control'
                ));
        
        $price = new Zend_Form_Element_Text('price');
        $price->removeDecorator('htmlTag')
                ->setRequired()
                ->removeDecorator('DtDdWrapper')
                ->removeDecorator('Label')
                ->setAttrib('size', '20')
                ->setAttribs(array(
                    'placeholder' => 'Combo Price',
                    'class' => 'form-control'
                ));
        
       $active = new Zend_Form_Element_Checkbox('active');
       $active->removeDecorator('htmlTag')
               ->removeDecorator('Label')
              ->removeDecorator('DtDdWrapper');
        
       $sort = new Zend_Form_Element_Text('order');
       $sort->removeDecorator('htmlTag')
                ->removeDecorator('DtDdWrapper')
                ->removeDecorator('Label')
                ->setAttrib('size', '20')
                ->setAttribs(array(
                    'placeholder' => 'Sort',
                    'class' => 'form-control'
                ));
        
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
        
        $this->addElements(array($name, $price, $active, $sort, $submit, $reset));
        $this->setMethod('post');
    }
}

