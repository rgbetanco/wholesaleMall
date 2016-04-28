<?php

class Application_Form_BasicSettings extends Zend_Form
{

    public function init()
    {
         $this->setAttribs(array(
            'role' => 'form',
            'class' => 'form-horizontal'
        ));

        $this->removeDecorator('DtDdWrapper');
        $this->removeDecorator('Label');

        $expire = new Zend_Form_Element_Text('expire');
        $expire->removeDecorator('htmlTag')
                ->setRequired()
                ->removeDecorator('DtDdWrapper')
                ->removeDecorator('Label')
                ->setAttrib('size', '20')
                ->setAttribs(array(
                    'placeholder' => 'expiration days',
                    'class' => 'form-control'
                ));
        
        $min_amount = new Zend_Form_Element_Text('min_amount');
        $min_amount->removeDecorator('htmlTag')
                ->setRequired()
                ->removeDecorator('DtDdWrapper')
                ->removeDecorator('Label')
                ->setAttrib('size', '20')
                ->setAttribs(array(
                    'placeholder' => 'US$',
                    'class' => 'form-control'
                ));
        
        $min_items = new Zend_Form_Element_Text('min_items');
        $min_items->removeDecorator('htmlTag')
                ->setRequired()
                ->removeDecorator('DtDdWrapper')
                ->removeDecorator('Label')
                ->setAttrib('size', '20')
                ->setAttribs(array(
                    'placeholder' => '# of Items',
                    'class' => 'form-control'
                ));
        
        
        $percetage = new Zend_Form_Element_Text('percentage');
        $percetage->removeDecorator('htmlTag')
                ->setRequired()
                ->removeDecorator('DtDdWrapper')
                ->removeDecorator('Label')
                ->setAttrib('size', '20')
                ->setAttribs(array(
                    'placeholder' => '%',
                    'class' => 'form-control'
                ));
        
        
        $drop_ship = new Zend_Form_Element_Text('drop_ship');
        $drop_ship->removeDecorator('htmlTag')
                ->setRequired()
                ->removeDecorator('DtDdWrapper')
                ->removeDecorator('Label')
                ->setAttrib('size', '20')
                ->setAttribs(array(
                    'placeholder' => 'US$',
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
        
        $this->addElements(array($expire, $min_amount, $min_items, $percetage,$drop_ship, $submit, $reset,));
        $this->setMethod('post');
    }


}

