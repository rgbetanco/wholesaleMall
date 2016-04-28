<?php

class Application_Form_Proimages extends Zend_Form {

    public function init() {
        $dc = new Application_Model_DbTable_Colors();
        $colorsObj = $dc->select()->from('colors', array('key' => 'id', 'value' => 'name'));
        $colors = $dc->getAdapter()->fetchAll($colorsObj);

        $colors[0] = 'default';

        $this->setAttribs(array(
            'role' => 'form',
            'class' => 'form-horizontal'
        ));
        $this->removeDecorator('DtDdWrapper');
        $this->removeDecorator('Label');
        $this->setAttrib('enctype', 'multipart/form-data');

        $c_id = new Zend_Form_Element_Select('c_id');
        $c_id->setRequired()
                ->addMultiOptions($colors)
                ->removeDecorator('htmlTag')
                ->removeDecorator('Label')
                ->removeDecorator('DtDdWrapper')
                ->setAttribs(array(
                    'class' => 'form-control'
        ));

        $name = new Zend_Form_Element_File('file');
        $name->setDestination(APPLICATION_PATH . '/../public/development/products_img')
                ->setIsArray(true)
                ->setValueDisabled(true)
                ->removeDecorator('htmlTag')
                ->removeDecorator('DtDdWrapper')
                ->removeDecorator('Label')
                ->addValidator('Size', false, '2MB')
                ->addValidator('Count', true, array('min' => 1, 'max' => 10))
                ->addValidator('Extension', false, 'jpg, png, gif')
                ->setAttrib('enctype', 'multipart/form-data')
                ->setAttrib('multiple', 'multiple');

        $send = new Zend_Form_Element_Submit('submit');
        $send->removeDecorator('Label');
        $send->removeDecorator('DtDdWrapper');
        $send->removeDecorator('htmlTag');
        $send->setLabel('Submit');
        $send->setAttribs(array(
            'label' => 'Submit',
            'class' => 'btn btn-primary'
        ));

        $reset = new Zend_Form_Element_Reset('reset');
        $reset->removeDecorator('Label');
        $reset->setLabel('Reset');
        $reset->removeDecorator('DtDdWrapper');
        $reset->removeDecorator('htmlTag');

        $reset->setAttribs(array(
            'label' => 'Reset',
            'class' => 'btn btn-danger'
        ));

 //       $hash = new Zend_Form_Element_Hash('csrf', array('ignore' => true));
 //       $hash->removeDecorator('Label');
        $this->addElements(array($c_id, $name, $send, $reset));
        $this->setMethod('post');
    }

}
