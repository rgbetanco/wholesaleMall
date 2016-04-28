<?php

class Application_Form_Shipping extends Zend_Form {

    public function init() {

        $tbl_states = new Application_Model_DbTable_States();
        $states = $tbl_states->getStates();

        $this->setAttribs(array(
            'role' => 'form',
            'class' => 'form-horizontal'
        ));
        $this->removeDecorator('DtDdWrapper');
        $this->removeDecorator('Label');

        $first_name = new Zend_Form_Element_Text('first_name');
        $first_name->setAttribs(array(
                    'placeholder' => 'first name',
                    'tabindex'=>1,
                    'class' => 'form-control'
                ))
                ->removeDecorator('htmlTag')
                ->removeDecorator('Label')
                ->removeDecorator('DtDdWrapper')
                ->setRequired();
        
        $last_name = new Zend_Form_Element_Text('last_name');
        $last_name->setAttribs(array(
                    'placeholder' => 'last name',
                    'class' => 'form-control',
                    'tabindex' => 6
                ))
                ->removeDecorator('htmlTag')
                ->removeDecorator('Label')
                ->removeDecorator('DtDdWrapper')
                ->setRequired();
        
        $address = new Zend_Form_Element_Text('address');
        $address->setRequired()
                ->setAttrib('COLS', '30')
                ->setAttrib('ROWS', '5')
                ->removeDecorator('htmlTag')
                ->removeDecorator('Label')
                ->removeDecorator('DtDdWrapper')
                ->setAttribs(array(
                    'tabindex' => 2,
                    'placeholder' => 'Shipping Address',
                    'class' => 'form-control'
                ))
                ->setValidators(array(array('validator' => 'StringLength', 'options' => array(0, 500))));

        $city = new Zend_Form_Element_Text('city');
        $city->setAttribs(array(
                    'tabindex' => 3,
                    'placeholder' => 'City',
                    'class' => 'form-control'
                ))
                ->removeDecorator('htmlTag')
                ->removeDecorator('Label')
                ->removeDecorator('DtDdWrapper')
                ->setRequired();

        $state = new Zend_Form_Element_Select('state');
        $state->setRequired()
                ->removeDecorator('htmlTag')
                ->removeDecorator('Label')
                ->removeDecorator('DtDdWrapper')
                ->setMultiOptions($states)
                ->setAttribs(array(
                    'class' => 'form-control input-sm',
                    'tabindex' => 7
        ));

        $zip = new Zend_Form_Element_Text('zip');
        $zip->setAttrib('size', '10')
                ->setAttribs(array(
                    'placeholder' => 'Zip Code',
                    'class' => 'form-control',
                    'tabindex' => 4
                ))
                ->removeDecorator('htmlTag')
                ->removeDecorator('Label')
                ->removeDecorator('DtDdWrapper')
                ->setRequired();

        $country = new Zend_Form_Element_Text('country');
        $country->setAttribs(array(
                    'placeholder' => 'Country',
                    'class' => 'form-control',
                    'tabindex' => 8
                ))
                ->removeDecorator('htmlTag')
                ->removeDecorator('Label')
                ->removeDecorator('DtDdWrapper')
                ->setRequired();
        
        $phone = new Zend_Form_Element_Text('phone');
        $phone->setAttribs(array(
                    'placeholder' => 'Phone number',
                    'class' => 'form-control',
                    'tabindex' => 5
                ))
                ->removeDecorator('htmlTag')
                ->removeDecorator('Label')
                ->removeDecorator('DtDdWrapper')
                ->setRequired();

        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setLabel('Submit')
                ->removeDecorator('htmlTag')
                ->removeDecorator('Label')
                ->removeDecorator('DtDdWrapper');
        $submit->setAttribs(array(
            'class' => 'btn btn-primary',
            'tabindex' => 9,
        ));

        $reset = new Zend_Form_Element_Reset('reset');
        $reset->removeDecorator('htmlTag')
                ->removeDecorator('Label')
                ->removeDecorator('DtDdWrapper')
                ->setLabel('Reset');
        $reset->setAttribs(array(
            'class' => 'btn btn-danger',
            'tabindex' => 10
        ));

        $hash = new Zend_Form_Element_Hash('csrf', array('ignore' => true));

        $this->addElements(array($first_name, $last_name, $address, $city, $state, $zip, $country, $phone, $submit, $hash, $reset));
        $this->setMethod('post');
    }

}
