<?php

class Application_Form_Login extends Zend_Form
{

    public function init()
    {
       $this->setElementDecorators(array('ViewHelper'));

       $this->removeDecorator('DtDdWrapper');
       $this->removeDecorator('Label');  
      
       $this->setAttribs(array(
           'role' => 'form',
           'class' => 'form-horizontal'
       ));
       
       $username = new Zend_Form_Element_Text('username');
       $username->setRequired()
                ->removeDecorator('htmlTag')
                ->setAttribs(array(
                    'placeholder' => 'username',
                    'class' => 'form-control input-sm'
                ));

       $password = new Zend_Form_Element_Password('password');
       $password->setRequired()
               ->removeDecorator('htmlTag')
                ->setAttribs(array(
                    'placeholder' => 'Password',
                    'class' => 'form-control input-sm custom-sm'
                ));

       $login = new Zend_Form_Element_Submit('Login');
       $login->setAttribs(array(
           'label' => 'Sign in',
           'class' => 'btn btn-primary'
       ));
       
       $reset = new Zend_Form_Element_Reset('reset');

       $reset->setAttribs(array(
           'label' => 'Reset',
           'class' => 'btn btn-danger'
       ));
       
       //$hash = new Zend_Form_Element_Hash('csrf',array('ignore'=>true));
       
       $this->addElements(array($username, $password, $login, $reset));
       $this->setMethod('post');
       $this->setAction(Zend_Controller_Front::getInstance()->getBaseUrl().'/authentication/login');
    }
}