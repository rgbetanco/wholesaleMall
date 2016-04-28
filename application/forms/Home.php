<?php

class Application_Form_Home extends Zend_Form
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
        
        $banner = new Zend_Form_Element_File('banner');
        $banner->setDestination(APPLICATION_PATH . '/../public/development/img/banners')
                ->setIsArray(true)
                ->setValueDisabled(true)
                ->removeDecorator('htmlTag')
                ->removeDecorator('DtDdWrapper')
                ->removeDecorator('Label')
                ->addValidator('Size', false, '2MB')
                ->addValidator('Count', true, array('min' => 1, 'max' => 1))
                ->addValidator('Extension', false, 'jpg, png, gif')
                ->setAttrib('enctype', 'multipart/form-data');
        
        $link = new Zend_Form_Element_Text('link');
        $link->removeDecorator('htmlTag')
                ->setRequired()
                ->removeDecorator('DtDdWrapper')
                ->removeDecorator('Label')
                ->setAttribs(array(
                    'placeholder' => 'URL link',
                    'class' => 'form-control'
                ));
        
        $position = new Zend_Form_Element_Text('position');
        $position->removeDecorator('htmlTag')
                ->setRequired()
                ->removeDecorator('DtDdWrapper')
                ->removeDecorator('Label')
                ->setAttribs(array(
                    'placeholder' => 'Position',
                    'class' => 'form-control'
                ));
        
        $sort = new Zend_Form_Element_Text('sort');
        $sort->removeDecorator('htmlTag')
                ->setRequired()
                ->removeDecorator('DtDdWrapper')
                ->removeDecorator('Label')
                ->setAttribs(array(
                    'placeholder' => 'Order',
                    'class' => 'form-control'
                ));
        
        $send = new Zend_Form_Element_Submit('submit');
        $send->removeDecorator('Label');
        $send->removeDecorator('DtDdWrapper');
        $send->setLabel('Submit');
        $send->removeDecorator('htmlTag');
        $send->setAttribs(array(
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

        $this->addElements(array($banner, $link, $position, $sort, $send, $reset));
        $this->setMethod('post');
    }
}