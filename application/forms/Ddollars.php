<?php

class Application_Form_Ddollars extends ZendX_JQuery_Form {

    public function init() {

        $this->setAttribs(array(
            'role' => 'form',
            'class' => 'form-horizontal'
        ));

        $this->removeDecorator('DtDdWrapper');
        $this->removeDecorator('Label');

        $order = new Zend_Form_Element_Text('order');
        $order->setLabel('Order #:')
                ->removeDecorator('htmlTag')
                ->removeDecorator('DtDdWrapper')
                ->removeDecorator('Label')
                ->setAttrib('size', '20')
                ->setAttribs(array(
                    'placeholder' => 'Order Number',
                    'class' => 'form-control'
                ))
                ->addFilter('StringToLower');

        $amount = new Zend_Form_Element_Text('amount');
        $amount->setLabel('Amount:')
                ->removeDecorator('htmlTag')
                ->removeDecorator('DtDdWrapper')
                ->removeDecorator('Label')
                ->setAttribs(array(
                    'placeholder' => 'Amount',
                    'class' => 'form-control'
                ))
                ->setRequired();

        $expires = new ZendX_JQuery_Form_Element_DatePicker('expires', array('jQueryParams' => array('defaultDate' => '+120d', 'dateFormat' => 'yy-mm-dd')));
        $expires->setLabel('Expiration Date:')
                ->removeDecorator('htmlTag')
                ->removeDecorator('DtDdWrapper')
                ->removeDecorator('Label')
                ->setRequired()
                ->setAttribs(array(
                    'placeholder' => 'Expiration Date',
                    'class' => 'form-control',
                    'id'    => 'datepicker'
                ))
                ->addValidator(new Zend_Validate_Date(array('format' => 'yy-mm-dd')));

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

        $hash = new Zend_Form_Element_Hash('csrf', array('ignore' => true));

        $this->addElements(array($order, $amount, $expires, $submit, $reset, $hash));
        $this->setMethod('post');
    }

}
