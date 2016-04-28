<?php

class Application_Form_Aboutus extends Zend_Form
{

    public function init(){

    	$this->setAttribs(array(
            'role' => 'form',
            'class' => 'form-horizontal'
        ));

        $this->removeDecorator('DtDdWrapper');
        $this->removeDecorator('Label');

        $content = new Zend_Form_Element_Textarea('content');
        $content->setLabel('Content:')
                ->setAttrib('COLS', '30')
                ->setAttrib('ROWS', '5')
                ->setAttrib('id', 'content')
                ->removeDecorator('htmlTag')
                ->removeDecorator('DtDdWrapper')
                ->removeDecorator('Label')
                ->setAttribs(array(
                    'class' => 'form-control'
                ))
                ->setValidators(array(array('validator' => 'StringLength', 'options' => array(0, 2500))));
        
        
        $submit = new Zend_Form_Element_Submit('submit');
        $submit->removeDecorator('htmlTag')
                ->removeDecorator('DtDdWrapper')
                ->setLabel('Submit')
                ->removeDecorator('Label');
        $submit->setAttribs(array(
            'class' => 'btn btn-primary'
        ));
        $reset = new Zend_Form_Element_Reset('reset');
        $reset->removeDecorator('htmlTag')
                ->removeDecorator('DtDdWrapper')
                ->setLabel('Reset')
                ->removeDecorator('Label');
        $reset->setAttribs(array(
            'class' => 'btn btn-danger'
        ));

        $this->addElements(array($content, $submit, $reset));
        $this->setMethod('post');   

    }

}