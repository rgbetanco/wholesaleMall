<?php

class Application_Form_PaymentMethods extends Zend_Form
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
                    'placeholder' => 'Credit Card / Wire / etc',
                    'class' => 'form-control'
                ));
        
        $extra = new Zend_Form_Element_Text('extra');
        $extra->removeDecorator('htmlTag')
                ->setRequired()
                ->removeDecorator('DtDdWrapper')
                ->removeDecorator('Label')
                ->setAttrib('size', '20')
                ->setAttribs(array(
                    'placeholder' => 'Extra Information',
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
                ->setlabel('Submit')
                ->removeDecorator('Label');
        $submit->setAttribs(array(
            'class' => 'btn btn-primary'
        ));
        
        $this->addElements(array($name, $extra, $submit, $reset,));
        $this->setMethod('post');
    }
}