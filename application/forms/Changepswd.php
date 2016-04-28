<?php

class Application_Form_Changepswd extends Zend_Form {

    public function init() {
        $this->setElementDecorators(array('ViewHelper'));

        $this->setAttribs(array(
            'role' => 'form',
            'class' => 'form-horizontal'
        ));

        $pswd = new Zend_Form_Element_Password('pswd');
        $pswd->setLabel('New Password:');
        $pswd->setAttrib('size', 35);
        $pswd->setRequired(true);
        $pswd->removeDecorator('label');
        $pswd->removeDecorator('htmlTag');
        $pswd->removeDecorator('Errors');
        $pswd->addValidator('StringLength', false, array(4, 15));
        $pswd->addErrorMessage('Password length range is 4 - 15 characters');
        $pswd->setAttribs(array(
            'class' => 'form-control'
        ));

        $confirmPswd = new Zend_Form_Element_Password('confirm_pswd');
        $confirmPswd->setAttrib('size', 35);
        $confirmPswd->setRequired(true);
        $confirmPswd->removeDecorator('label');
        $confirmPswd->removeDecorator('htmlTag');
        $confirmPswd->removeDecorator('Errors');
        $confirmPswd->addValidator('Identical', false, array('token' => 'pswd'));
        $confirmPswd->addErrorMessage('Passwords are not the same, please try again');
        $confirmPswd->setAttribs(array(
            'class' => 'form-control'
        ));

        $login = new Zend_Form_Element_Submit('Submit');
        $login->setAttribs(array(
            'label' => 'Sign in',
            'class' => 'btn btn-primary'
        ));

        $reset = new Zend_Form_Element_Reset('reset');

        $reset->setAttribs(array(
            'label' => 'Reset',
            'class' => 'btn btn-danger'
        ));

        $this->addElements(array($pswd, $confirmPswd, $login, $reset));
        $this->setMethod('post');
        $this->setAction(Zend_Controller_Front::getInstance()->getBaseUrl() . '/authentication/changepswd');
    }

}
