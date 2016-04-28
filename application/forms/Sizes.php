<?php

class Application_Form_Sizes extends Zend_Form
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
                ->removeDecorator('DtDdWrapper')
                ->removeDecorator('Label')
                ->setRequired()
                ->setAttrib('size', '20')
                ->setAttribs(array(
                    'placeholder' => 'Size',
                    'class' => 'form-control'
                ));
        
        $sort = new Zend_Form_Element_Text('sort');
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
        
        $this->addElements(array($name, $sort, $submit, $reset,));
        $this->setMethod('post');
    }


}

