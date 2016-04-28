<?php

class Application_Form_Placeorder extends Zend_Form
{

    public function init()
    {

        $publickey = '6LfCJAwTAAAAAH-PZtCPij2_yjbSWuadbs4grysr';
        $privatekey = '6LfCJAwTAAAAAC5FKNe4fFYr_4nod3bk0lvxn7AW';
        $recaptcha = new Zend_Service_ReCaptcha($publickey, $privatekey);

        //get shipping address of the logged customer
        $email = Zend_Auth::getInstance()->getStorage()->read()->username;
        $tbl_register = new Application_Model_DbTable_Register();
        $reg = $tbl_register->fetchRow($tbl_register->select()->where('email = ?',$email));
        
        $tbl_address = new Application_Model_DbTable_Shipping();
        $address_array = $tbl_address->getShippingAddresses($reg['id']);
        array_unshift($address_array,'Use Billing Address');
        array_unshift($address_array,'Drop Ship');
        array_unshift($address_array,'Add New Shipping Address');
        
        $country_array = array('United States'=>'United States', 'Other'=>'Other');

        $tbl_states = new Application_Model_DbTable_States();
        $states = $tbl_states->getStates();
        
        //get shipping methods from the database
        $tbl_shipping_method = new Application_Model_DbTable_ShippingMethods();
        $shipping_methods = $tbl_shipping_method->getShippingMethods();
        
        $this->setAttribs(array(
            'role' => 'form',
            'class' => 'form-horizontal'
        ));
        $this->removeDecorator('DtDdWrapper');
        $this->removeDecorator('Label');

        $addresses = new Zend_Form_Element_Select('addresses');
        $addresses->setRequired()
                ->setValue('0')
                ->removeDecorator('htmlTag')
                ->removeDecorator('DtDdWrapper')
                ->removeDecorator('Label')
                ->setAttribs(array(
                    'class' => 'form-control',
                    'size' => 1,
                    'onChange' => 'updateShippingAddress(this)'
                ))
                ->addMultiOptions($address_array);
        
        $s_method = new Zend_Form_Element_Select('s_method');
        $s_method->setRequired()
                ->removeDecorator('htmlTag')
                ->removeDecorator('DtDdWrapper')
                ->removeDecorator('Label')
                ->setAttribs(array(
                    'class' => 'form-control',
                    'size' => 1
                ))
                ->addMultiOptions($shipping_methods);
        
        $first_name = new Zend_Form_Element_Text('first_name');
        $first_name->setRequired()
                ->setValue($reg->first_name)
                ->removeDecorator('htmlTag')
                ->removeDecorator('DtDdWrapper')
                ->removeDecorator('Label')
                ->setAttribs(array(
                    'placeholder' => 'First Name',
                    'class' => 'form-control input-sm'
        ));

        $last_name = new Zend_Form_Element_Text('last_name');
        $last_name->setRequired()
                ->setValue($reg->last_name)
                ->removeDecorator('htmlTag')
                ->removeDecorator('DtDdWrapper')
                ->removeDecorator('Label')
                ->setAttribs(array(
                    'placeholder' => 'Last Name',
                    'class' => 'form-control input-sm'
        ));

        $company = new Zend_Form_Element_Text('company');
        $company->setRequired()
                ->setValue($reg->company)
                ->removeDecorator('htmlTag')
                ->removeDecorator('DtDdWrapper')
                ->removeDecorator('Label')
                ->setAttribs(array(
                    'placeholder' => 'Company',
                    'class' => 'form-control input-sm'
        ));
        
//billing address

        $b_address = new Zend_Form_Element_Text('b_address');
        $b_address->setRequired()
                ->setValue($reg->address)
                ->removeDecorator('htmlTag')
                ->removeDecorator('DtDdWrapper')
                ->removeDecorator('Label')
                ->setAttrib('ROWS', '5')
                ->setAttribs(array(
                    'placeholder' => 'Address',
                    'class' => 'form-control input-sm'
                ))
                ->setValidators(array(array('validator' => 'StringLength', 'options' => array(0, 500))));

        $b_address_2 = new Zend_Form_Element_Text('b_address_2');
        $b_address_2->setValue($reg->address_2)
                ->removeDecorator('htmlTag')
                ->removeDecorator('DtDdWrapper')
                ->removeDecorator('Label')
                ->setAttrib('ROWS', '5')
                ->setAttribs(array(
                    'placeholder' => 'Address',
                    'class' => 'form-control input-sm'
                ))
                ->setValidators(array(array('validator' => 'StringLength', 'options' => array(0, 500))));


        $b_city = new Zend_Form_Element_Text('b_city');
        $b_city->setRequired()
                ->setValue($reg->city)
                ->removeDecorator('htmlTag')
                ->removeDecorator('DtDdWrapper')
                ->removeDecorator('Label')
                ->setAttribs(array(
                    'placeholder' => 'City',
                    'class' => 'form-control input-sm'
        ));

        $b_state = new Zend_Form_Element_Select('b_state');
        $b_state->addMultiOptions($states)
                ->setValue('0')
                ->removeDecorator('htmlTag')
                ->removeDecorator('DtDdWrapper')
                ->removeDecorator('Label')
                ->setAttribs(array(
                    'placeholder' => 'State',
                    'class' => 'form-control input-sm'
        ));

        $b_zip = new Zend_Form_Element_Text('b_zip');
        $b_zip->setAttrib('size', '10')
                ->removeDecorator('htmlTag')
                ->removeDecorator('DtDdWrapper')
                ->removeDecorator('Label')
                ->setValue($reg->zip)
                ->setAttribs(array(
                    'placeholder' => 'Numeric Value',
                    'class' => 'form-control input-sm'
        ));

        $b_country = new Zend_Form_Element_Select('b_country');
        $b_country->setRequired()
                ->setValue($reg->country)
                ->removeDecorator('htmlTag')
                ->removeDecorator('DtDdWrapper')
                ->removeDecorator('Label')
                ->addMultiOptions($country_array)
                ->setAttribs(array(
                    'placeholder' => 'Country',
                    'class' => 'form-control input-sm',
                    'onChange' => 'changebcountry(this)'
        ));

        $b_other_country = new Zend_Form_Element_Text('b_other_country');
        $b_other_country->setValue($reg->country)
                ->removeDecorator('htmlTag')
                ->removeDecorator('DtDdWrapper')
                ->removeDecorator('Label')
                ->setAttribs(array(
                    'placeholder' => 'Not USA',
                    'class' => 'form-control input-sm',
                    'disabled' => 'disabled'
        ));
        
        $b_phone = new Zend_Form_Element_Text('b_phone');
        $b_phone->setRequired()
                ->setValue($reg->phone)
                ->removeDecorator('htmlTag')
                ->removeDecorator('DtDdWrapper')
                ->removeDecorator('Label')
                ->setAttribs(array(
                    'placeholder' => 'Alphanumeric Values',
                    'class' => 'form-control input-sm'
        ));
        
//shipping address
        
        $s_first_name = new Zend_Form_Element_Text('s_first_name');
        $s_first_name->setRequired()
                ->removeDecorator('htmlTag')
                ->removeDecorator('DtDdWrapper')
                ->removeDecorator('Label')
                ->setAttribs(array(
                    'placeholder' => 'First Name',
                    'class' => 'form-control input-sm'
        ));

        $s_last_name = new Zend_Form_Element_Text('s_last_name');
        $s_last_name->setRequired()
                ->removeDecorator('htmlTag')
                ->removeDecorator('DtDdWrapper')
                ->removeDecorator('Label')
                ->setAttribs(array(
                    'placeholder' => 'Last Name',
                    'class' => 'form-control input-sm'
        ));

        $s_company = new Zend_Form_Element_Text('s_company');
        $s_company->setRequired()
                ->removeDecorator('htmlTag')
                ->removeDecorator('DtDdWrapper')
                ->removeDecorator('Label')
                ->setAttribs(array(
                    'placeholder' => 'Company',
                    'class' => 'form-control input-sm'
        ));
        
        $s_address = new Zend_Form_Element_Text('s_address');
        $s_address->setRequired()
                ->removeDecorator('htmlTag')
                ->removeDecorator('DtDdWrapper')
                ->removeDecorator('Label')
                ->setAttrib('ROWS', '5')
                ->setAttribs(array(
                    'placeholder' => 'Address',
                    'class' => 'form-control input-sm'
                ))
                ->setValidators(array(array('validator' => 'StringLength', 'options' => array(0, 500))));

        $s_address_2 = new Zend_Form_Element_Text('s_address_2');
        $s_address_2->removeDecorator('htmlTag')
                ->removeDecorator('DtDdWrapper')
                ->removeDecorator('Label')
                ->setAttrib('ROWS', '5')
                ->setAttribs(array(
                    'placeholder' => 'Address',
                    'class' => 'form-control input-sm'
                ))
                ->setValidators(array(array('validator' => 'StringLength', 'options' => array(0, 500))));


        $s_city = new Zend_Form_Element_Text('s_city');
        $s_city->setRequired()
                ->removeDecorator('htmlTag')
                ->removeDecorator('DtDdWrapper')
                ->removeDecorator('Label')
                ->setAttribs(array(
                    'placeholder' => 'City',
                    'class' => 'form-control input-sm'
        ));

        $s_state = new Zend_Form_Element_Select('s_state');
        $s_state->removeDecorator('htmlTag')
                ->setValue('0')
                ->removeDecorator('DtDdWrapper')
                ->removeDecorator('Label')
                ->addMultiOptions($states)
                ->setAttribs(array(
                    'placeholder' => 'State',
                    'class' => 'form-control input-sm'
        ));

        $s_zip = new Zend_Form_Element_Text('s_zip');
        $s_zip->setAttrib('size', '10')
                ->removeDecorator('htmlTag')
                ->removeDecorator('DtDdWrapper')
                ->removeDecorator('Label')
                ->setAttribs(array(
                    'placeholder' => 'Numeric Value',
                    'class' => 'form-control input-sm'
        ));

        $s_country = new Zend_Form_Element_Select('s_country');
        $s_country->setRequired()
                ->removeDecorator('htmlTag')
                ->removeDecorator('DtDdWrapper')
                ->removeDecorator('Label')
                ->addMultiOptions($country_array)
                ->setAttribs(array(
                    'placeholder' => 'Country',
                    'class' => 'form-control input-sm',
                    'onChange' => 'changescountry(this)'
        ));

        $s_other_country = new Zend_Form_Element_Text('s_other_country');
        $s_other_country->removeDecorator('htmlTag')
                ->removeDecorator('DtDdWrapper')
                ->removeDecorator('Label')
                ->setAttribs(array(
                    'placeholder' => 'Not USA',
                    'class' => 'form-control input-sm',
                    'disabled'=>'disabled'
        ));

        $s_phone = new Zend_Form_Element_Text('s_phone');
        $s_phone->removeDecorator('htmlTag')
                ->removeDecorator('DtDdWrapper')
                ->removeDecorator('Label')
                ->setAttribs(array(
                    'placeholder' => 'Alphanumeric Values',
                    'class' => 'form-control input-sm'
        ));
        
        $drop = new Zend_Form_Element_Checkbox('drop');
        $drop->setChecked(false);
        $drop->removeDecorator('htmlTag')
                ->removeDecorator('DtDdWrapper')
                ->removeDecorator('Label');
        
        $note = new Zend_Form_Element_Textarea('note');
        $note->removeDecorator('htmlTag')
                ->removeDecorator('DtDdWrapper')
                ->removeDecorator('Label');
        $note->setAttribs(array(
                    'placeholder' => 'comments, suggestions, questions, etc.',
                    'ROWS' => '3',
                    'COLS' => '22',
                    'class' => 'form-control'
        ));
        
        // $captcha = new Zend_Form_Element_Captcha('captcha', array(
        //     'captcha' => 'ReCaptcha',
        //     'captchaOptions' => array('captcha' => 'ReCaptcha', 'service' => $recaptcha),
        //     'ignore'=> true
        // ));

        $submit = new Zend_Form_Element_Submit('Submit');
        $submit->removeDecorator('Label')
                ->removeDecorator('DtDdWrapper')
                ->removeDecorator('htmlTag')
                ->setAttribs(array(
                    'class' => 'btn btn-primary'
        ));
        $submit->setLabel('Submit');

        $reset = new Zend_Form_Element_Reset('Reset');
        $reset->removeDecorator('Label')
                ->removeDecorator('DtDdWrapper')
                ->removeDecorator('htmlTag')
                ->setAttribs(array(
                    'class' => 'btn btn-danger'
        ));

        $this->addElements(array($s_method, $addresses, $first_name, $last_name, $company, $b_address, $b_address_2, $b_city, $b_state, $b_zip, $b_country,$b_other_country, $b_phone, $s_first_name, $s_last_name, $s_company, $s_address, $s_address_2, $s_city, $s_state, $s_zip, $s_country,$s_other_country, $s_phone, $drop, $note, $submit, $reset));
        $this->setMethod('post');
    }
}