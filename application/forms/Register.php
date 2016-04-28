<?php

class Application_Form_Register extends Zend_Form {

    public function init() {

        $publickey = '6LfCJAwTAAAAAH-PZtCPij2_yjbSWuadbs4grysr';
        $privatekey = '6LfCJAwTAAAAAC5FKNe4fFYr_4nod3bk0lvxn7AW';
        $recaptcha = new Zend_Service_ReCaptcha($publickey, $privatekey);

        $tbl_states = new Application_Model_DbTable_States();
        $states = $tbl_states->getStates();

        $country_array = array('United States'=>'United States', 'Other'=>'Other');

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
                    'class' => 'form-control input-sm',
                    'tabindex' => 1
        ));

        $company_type = new Zend_Form_Element_Text('company_type');
        $company_type->setAttrib('size', '40')
                ->removeDecorator('htmlTag')
                ->removeDecorator('Label')
                ->removeDecorator('DtDdWrapper')
                ->setAttribs(array(
                    'placeholder' => 'required',
                    'class' => 'form-control input-sm',
                    'tabindex' => 2
                ))
                ->setRequired();

        $first_name = new Zend_Form_Element_Text('first_name');
        $first_name->setRequired()
                ->removeDecorator('htmlTag')
                ->removeDecorator('Label')
                ->removeDecorator('DtDdWrapper')
                ->setAttribs(array(
                    'placeholder' => 'required',
                    'class' => 'form-control input-sm',
                    'tabindex' => 3
        ));

        $last_name = new Zend_Form_Element_Text('last_name');
        $last_name->setRequired()
                ->removeDecorator('htmlTag')
                ->removeDecorator('Label')
                ->removeDecorator('DtDdWrapper')
                ->setAttribs(array(
                    'placeholder' => 'required',
                    'class' => 'form-control input-sm',
                    'tabindex' => 4
        ));

        $title = new Zend_Form_Element_Text('title');
        $title->setRequired()
                ->removeDecorator('htmlTag')
                ->removeDecorator('Label')
                ->removeDecorator('DtDdWrapper')
                ->setAttribs(array(
                    'placeholder' => 'required',
                    'class' => 'form-control input-sm',
                    'tabindex' => 5
        ));

        $address = new Zend_Form_Element_Text('address');
        $address->setRequired()
                ->removeDecorator('htmlTag')
                ->removeDecorator('Label')
                ->removeDecorator('DtDdWrapper')
                ->setAttrib('ROWS', '5')
                ->setAttribs(array(
                    'placeholder' => 'required',
                    'class' => 'form-control input-sm',
                    'tabindex' => 6
                ))
                ->setValidators(array(array('validator' => 'StringLength', 'options' => array(0, 500))));

        $address2 = new Zend_Form_Element_Text('address2');
        $address2->removeDecorator('htmlTag')
                ->removeDecorator('Label')
                ->removeDecorator('DtDdWrapper')
                ->setAttrib('ROWS', '5')
                ->setAttribs(array(
                    'class' => 'form-control input-sm',
                    'tabindex' => 7
                ))
                ->setValidators(array(array('validator' => 'StringLength', 'options' => array(0, 500))));


        $city = new Zend_Form_Element_Text('city');
        $city->setRequired()
                ->removeDecorator('htmlTag')
                ->removeDecorator('Label')
                ->removeDecorator('DtDdWrapper')
                ->setAttribs(array(
                    'placeholder' => 'required',
                    'class' => 'form-control input-sm',
                    'tabindex' => 8
        ));

        $state = new Zend_Form_Element_Select('state');
        $state->removeDecorator('htmlTag')
                ->removeDecorator('Label')
                ->removeDecorator('DtDdWrapper')
                ->setMultiOptions($states)
                ->setAttribs(array(
                    'id' => 'states',
                    'class' => 'form-control input-sm',
                    'tabindex' => 9
        ));

        $zip = new Zend_Form_Element_Text('zip');
        $zip->setAttrib('size', '10')
                ->setRequired()
                ->removeDecorator('htmlTag')
                ->removeDecorator('Label')
                ->removeDecorator('DtDdWrapper')
                ->setAttribs(array(
                    'placeholder' => 'required',
                    'class' => 'form-control input-sm',
                    'tabindex' => 10
        ));

        $country = new Zend_Form_Element_Select('country');
        $country->setRequired()
                ->removeDecorator('htmlTag')
                ->removeDecorator('Label')
                ->removeDecorator('DtDdWrapper')
                ->addMultiOptions($country_array)
                ->setAttribs(array(
                    'placeholder' => 'required',
                    'class' => 'form-control input-sm',
                    'tabindex' => 11,
                    'onChange' => 'changecountry(this)'
        ));

        $other_country = new Zend_Form_Element_Text('other_country');
        $other_country->removeDecorator('htmlTag')
                ->removeDecorator('DtDdWrapper')
                ->removeDecorator('Label')
                ->setAttribs(array(
                    'id' => 'other_country',
                    'placeholder' => 'Not USA',
                    'class' => 'form-control input-sm',
                    'disabled' => 'disabled',
                    'tabindex' => 12
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
                    'class' => 'form-control input-sm',
                    'tabindex' => 13
        ));

        $phone = new Zend_Form_Element_Text('phone');
        $phone->setRequired()
                ->removeDecorator('htmlTag')
                ->removeDecorator('Label')
                ->removeDecorator('DtDdWrapper')
                ->setAttribs(array(
                    'placeholder' => 'required',
                    'class' => 'form-control input-sm',
                    'tabindex' => 14
        ));

        $fax = new Zend_Form_Element_Text('fax');
                $fax->removeDecorator('htmlTag')
                    ->removeDecorator('Label')
                    ->removeDecorator('DtDdWrapper');
                $fax->setAttribs(array(
                    'placeholder' => '',
                    'class' => 'form-control input-sm',
                    'tabindex' => 15
        ));

        $website = new Zend_Form_Element_Text('website');
        $website->setAttrib('size', '40')
                ->removeDecorator('htmlTag')
                ->removeDecorator('Label')
                ->removeDecorator('DtDdWrapper')
                ->addFilter('StringToLower')
                ->setAttribs(array(
                    'placeholder' => '',
                    'class' => 'form-control input-sm',
                    'tabindex' => 16
        ));

        $tax_id = new Zend_Form_Element_Text('tax_id');
        $tax_id->removeDecorator('htmlTag')
                ->removeDecorator('Label')
                ->removeDecorator('DtDdWrapper');
        $tax_id->setRequired()->setAttribs(array(
            'placeholder' => 'required',
            'class' => 'form-control input-sm',
            'tabindex' => 17
        ));

        $spam = new Zend_Form_Element_Checkbox('spam');
        $spam->removeDecorator('htmlTag')
                ->removeDecorator('Label')
                ->removeDecorator('DtDdWrapper');
        $spam->setChecked(true);

        $captcha = new Zend_Form_Element_Captcha('captcha', array(
            'captcha' => 'ReCaptcha',
            'captchaOptions' => array('captcha' => 'ReCaptcha', 'service' => $recaptcha),
            'ignore'=> true
        ));

        $submit = new Zend_Form_Element_Submit('Send');
        $submit->removeDecorator('Label')
                ->removeDecorator('DtDdWrapper')
                ->removeDecorator('htmlTag')
                ->setAttribs(array(
                    'class' => 'btn btn-primary',
                    'tabindex' => 18
        ));
        $submit->setLabel('Send');

        $reset = new Zend_Form_Element_Reset('Reset');
        $reset->removeDecorator('Label')
                ->removeDecorator('DtDdWrapper')
                ->removeDecorator('htmlTag')
                ->setAttribs(array(
                    'class' => 'btn btn-danger',
                    'tabindex' => 19
        ));

     //   $hash = new Zend_Form_Element_Hash('csrf', array('ignore' => true));

        $this->addElements(array($company, $company_type, $first_name, $last_name, $title, $address, $address2, $city, $state, $zip, $country, $other_country, $email, $phone, $fax, $website, $tax_id, $spam, $captcha, $submit, $reset));
        $this->setMethod('post');
    }
}