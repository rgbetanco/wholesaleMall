<?php

class Application_Form_Import extends Zend_Form
{

    public function init()
    {
        $this->setAttribs(array(
           'role' => 'form',
           'class' => 'form-horizontal'
       ));
        $this->removeDecorator('DtDdWrapper');
        $this->removeDecorator('Label');
        $this->setAttrib('enctype', 'multipart/form-data');
        
        $filename = new Zend_Form_Element_File('filename');
        $filename->setDestination(APPLICATION_PATH . '/../public/development/imports')
                ->setIsArray(FALSE)
                ->setValueDisabled(true)
                ->removeDecorator('htmlTag')
                ->removeDecorator('DtDdWrapper')
                ->removeDecorator('Label')
                ->addValidator('Size', false, '2MB')
                ->addValidator('Count', true, array('min' => 1, 'max' => 1))
                ->addValidator('Extension', false, 'csv')
                ->setAttrib('enctype', 'multipart/form-data');

        $send = new Zend_Form_Element_Submit('submit');
        $send->removeDecorator('Label');
        $send->removeDecorator('DtDdWrapper');
        $send->setLabel('Submit');
        $send->removeDecorator('htmlTag');
        $send->setAttribs(array(
            'label' => 'submit',
            'class' => 'btn btn-primary'
        ));

        $reset = new Zend_Form_Element_Reset('reset');
        $reset->removeDecorator('Label');
        $reset->removeDecorator('DtDdWrapper');
        $reset->setLabel('Reset');
        $reset->removeDecorator('htmlTag');
        
        $reset->setAttribs(array(
            'label' => 'Reset',
            'class' => 'btn btn-danger'
        ));
        
        $this->addElements(array($filename, $send, $reset));
        $this->setMethod('post');
    }
}