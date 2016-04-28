<?php

class Application_Form_Color extends Zend_Form
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
                ->setAttrib('size', '30')
                ->setAttribs(array(
                    'placeholder' => 'Color',
                    'class' => 'form-control'
                ));
        
        $code = new Zend_Form_Element_Text('code');
        $code->removeDecorator('htmlTag')
                ->setRequired()
                ->removeDecorator('DtDdWrapper')
                ->removeDecorator('Label')
                ->setAttrib('size', '30')
                ->setAttribs(array(
                    'placeholder' => 'Color Code',
                    'class' => 'form-control'
                ));
        
        $rgb = new Zend_Form_Element_Text('rgb');
        $rgb->removeDecorator('htmlTag')
                ->setRequired()
                ->removeDecorator('DtDdWrapper')
                ->removeDecorator('Label')
                ->setAttrib('size', '30')
                ->setAttribs(array(
                    'placeholder' => 'Click me',
                    'class' => 'form-control',
                    'autocomplete' => 'off',
                    'id'=>'picker',
                    'size' => '10'
                ));
        
        $sort = new Zend_Form_Element_Text('sort');
        $sort->removeDecorator('htmlTag')
                ->removeDecorator('DtDdWrapper')
                ->removeDecorator('Label')
                ->setAttrib('size', '30')
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
        
        $this->addElements(array($name, $code, $rgb, $sort, $submit, $reset,));
        $this->setMethod('post');
    }
}

