<?php

class Application_Form_Stores extends Zend_Form {

    public function init() {
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
                    'placeholder' => 'Store Name',
                    'class' => 'form-control'
        ));

        $active = new Zend_Form_Element_Checkbox('active');
        $active->removeDecorator('htmlTag')
                ->removeDecorator('Label')
                ->removeDecorator('DtDdWrapper');

        $address = new Zend_Form_Element_Textarea('address');
        $address->removeDecorator('htmlTag')
                ->setRequired()
                ->removeDecorator('DtDdWrapper')
                ->removeDecorator('Label')
                ->setAttribs(array(
                    'placeholder' => 'Store Address',
                    'COLS' => '40',
                    'ROWS' => '4',
                    'class' => 'form-control'
        ));

        $country = new Zend_Form_Element_Text('country');
        $country->removeDecorator('htmlTag')
                ->setRequired()
                ->removeDecorator('DtDdWrapper')
                ->removeDecorator('Label')
                ->setAttrib('size', '20')
                ->setAttribs(array(
                    'placeholder' => 'Country',
                    'class' => 'form-control'
        ));

        $state = new Zend_Form_Element_Text('state');
        $state->removeDecorator('htmlTag')
                ->setRequired()
                ->removeDecorator('DtDdWrapper')
                ->removeDecorator('Label')
                ->setAttrib('size', '20')
                ->setAttribs(array(
                    'placeholder' => 'State',
                    'class' => 'form-control'
        ));

        $city = new Zend_Form_Element_Text('city');
        $city->removeDecorator('htmlTag')
                ->setRequired()
                ->removeDecorator('DtDdWrapper')
                ->removeDecorator('Label')
                ->setAttrib('size', '20')
                ->setAttribs(array(
                    'placeholder' => 'City',
                    'class' => 'form-control'
        ));

        $zip_code = new Zend_Form_Element_Text('zip_code');
        $zip_code->removeDecorator('htmlTag')
                ->setRequired()
                ->removeDecorator('DtDdWrapper')
                ->removeDecorator('Label')
                ->setAttrib('size', '20')
                ->setAttribs(array(
                    'placeholder' => 'Zip Code',
                    'class' => 'form-control'
        ));
        $longitude = new Zend_Form_Element_Text('latlng');
        $longitude->removeDecorator('htmlTag')
                ->setRequired()
                ->removeDecorator('DtDdWrapper')
                ->removeDecorator('Label')
                ->setAttrib('size', '20')
                ->setAttribs(array(
                    'placeholder' => 'coordinate from google map',
                    'class' => 'form-control'
        ));
        
        $website = new Zend_Form_Element_Text('website');
        $website->removeDecorator('htmlTag')
                ->setRequired()
                ->removeDecorator('DtDdWrapper')
                ->removeDecorator('Label')
                ->setAttrib('size', '20')
                ->setAttribs(array(
                    'placeholder' => 'company website',
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

        $this->addElements(array($name, $active, $address, $city, $state, $country, $zip_code, $longitude,$website, $submit ,$reset,));
        $this->setMethod('post');
    }
}