<?php

class Application_Form_Registeradmin extends Zend_Form {

    public function init() {

        $tbl_states = new Application_Model_DbTable_States();
        $states = $tbl_states->getStates();

        $this->setAttribs(array(
            'role' => 'form',
            'class' => 'form-horizontal'
        ));
        $this->removeDecorator('DtDdWrapper');
        $this->removeDecorator('Label');

        $company = new Zend_Form_Element_Text('company');
        $company->setAttrib('size', '40')
                ->setRequired()
                ->removeDecorator('htmlTag')
                ->removeDecorator('Label')
                ->removeDecorator('DtDdWrapper')
                ->setAttribs(array(
                    'placeholder' => 'required',
                    'class' => 'form-control input-sm'
        ));

        $company_type = new Zend_Form_Element_Text('company_type');
        $company_type->setAttrib('size', '40')
                ->removeDecorator('htmlTag')
                ->removeDecorator('Label')
                ->removeDecorator('DtDdWrapper')
                ->setAttribs(array(
                    'placeholder' => 'required',
                    'class' => 'form-control input-sm'
                ))
                ->setRequired();

        $first_name = new Zend_Form_Element_Text('first_name');
        $first_name->setRequired()
                ->removeDecorator('htmlTag')
                ->removeDecorator('Label')
                ->removeDecorator('DtDdWrapper')
                ->setAttribs(array(
                    'placeholder' => 'required',
                    'class' => 'form-control input-sm'
        ));

        $last_name = new Zend_Form_Element_Text('last_name');
        $last_name->setRequired()
                ->removeDecorator('htmlTag')
                ->removeDecorator('Label')
                ->removeDecorator('DtDdWrapper')
                ->setAttribs(array(
                    'placeholder' => 'required',
                    'class' => 'form-control input-sm'
        ));

        $title = new Zend_Form_Element_Text('title');
        $title->setRequired()
                ->removeDecorator('htmlTag')
                ->removeDecorator('Label')
                ->removeDecorator('DtDdWrapper')
                ->setAttribs(array(
                    'placeholder' => 'required',
                    'class' => 'form-control input-sm'
        ));

        $address = new Zend_Form_Element_Text('address');
        $address->setRequired()
                ->removeDecorator('htmlTag')
                ->removeDecorator('Label')
                ->removeDecorator('DtDdWrapper')
                ->setAttrib('ROWS', '5')
                ->setAttribs(array(
                    'placeholder' => 'required',
                    'class' => 'form-control input-sm'
                ))
                ->setValidators(array(array('validator' => 'StringLength', 'options' => array(0, 500))));

        $city = new Zend_Form_Element_Text('city');
        $city->setRequired()
                ->removeDecorator('htmlTag')
                ->removeDecorator('Label')
                ->removeDecorator('DtDdWrapper')
                ->setAttribs(array(
                    'placeholder' => 'required',
                    'class' => 'form-control input-sm'
        ));

        $state = new Zend_Form_Element_Select('state');
        $state->setRequired()
                ->removeDecorator('htmlTag')
                ->removeDecorator('Label')
                ->removeDecorator('DtDdWrapper')
                ->setMultiOptions($states)
                ->setAttribs(array(
                    'class' => 'form-control input-sm'
        ));

        $zip = new Zend_Form_Element_Text('zip');
        $zip->setAttrib('size', '10')
                ->setRequired()
                ->removeDecorator('htmlTag')
                ->removeDecorator('Label')
                ->removeDecorator('DtDdWrapper')
                ->setAttribs(array(
                    'placeholder' => 'required',
                    'class' => 'form-control input-sm'
        ));

        $country = new Zend_Form_Element_Text('country');
        $country->setRequired()
                ->removeDecorator('htmlTag')
                ->removeDecorator('Label')
                ->removeDecorator('DtDdWrapper')
                ->setAttribs(array(
                    'placeholder' => 'required',
                    'class' => 'form-control input-sm'
        ));

        $email = new Zend_Form_Element_Text('email');
        $email->setRequired()
                ->removeDecorator('htmlTag')
                ->removeDecorator('Label')
                ->removeDecorator('DtDdWrapper')
                ->setAttrib('size', '40')
                ->addFilter('StringToLower')
                ->setValidators(array('EmailAddress'))
                ->setAttribs(array(
                    'placeholder' => 'required',
                    'class' => 'form-control input-sm'
        ));

        $phone = new Zend_Form_Element_Text('phone');
        $phone->setRequired()
                ->removeDecorator('htmlTag')
                ->removeDecorator('Label')
                ->removeDecorator('DtDdWrapper')
                ->setAttribs(array(
                    'placeholder' => 'required',
                    'class' => 'form-control input-sm'
        ));

        $fax = new Zend_Form_Element_Text('fax');
                $fax->removeDecorator('htmlTag')
                ->removeDecorator('Label')
                ->removeDecorator('DtDdWrapper');
                $fax->setAttribs(array(
                    'placeholder' => '',
                    'class' => 'form-control input-sm'
        ));

        $website = new Zend_Form_Element_Text('website');
        $website->setAttrib('size', '40')
                ->removeDecorator('htmlTag')
                ->removeDecorator('Label')
                ->removeDecorator('DtDdWrapper')
                ->addFilter('StringToLower')
                ->setAttribs(array(
                    'placeholder' => '',
                    'class' => 'form-control input-sm'
        ));

        $tax_id = new Zend_Form_Element_Text('tax_id');
        $tax_id->removeDecorator('htmlTag')
                ->removeDecorator('Label')
                ->removeDecorator('DtDdWrapper');
        $tax_id->setRequired()->setAttribs(array(
            'placeholder' => 'required',
            'class' => 'form-control input-sm'
        ));

        $spam = new Zend_Form_Element_Checkbox('spam');
        $spam->removeDecorator('htmlTag')
                ->removeDecorator('Label')
                ->removeDecorator('DtDdWrapper');
        $spam->setChecked(true);

        $submit = new Zend_Form_Element_Submit('Send');
        $submit->removeDecorator('Label')
                ->removeDecorator('DtDdWrapper')
                ->removeDecorator('htmlTag')
                ->setAttribs(array(
                    'class' => 'btn btn-primary'
        ));
        $submit->setLabel('Send');

        $reset = new Zend_Form_Element_Reset('Reset');
        $reset->removeDecorator('Label')
                ->removeDecorator('DtDdWrapper')
                ->removeDecorator('htmlTag')
                ->setAttribs(array(
                    'class' => 'btn btn-danger'
        ));

     //   $hash = new Zend_Form_Element_Hash('csrf', array('ignore' => true));

        $this->addElements(array($company, $company_type, $first_name, $last_name, $title, $address, $city, $state, $zip, $country, $email, $phone, $fax, $website, $tax_id, $spam, $submit, $reset));
        $this->setMethod('post');
    }
}