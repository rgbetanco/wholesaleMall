<?php

class Application_Form_Discounts extends Zend_Form {

    public function init() {
        
        $subcat_table = new Application_Model_DbTable_Subcategories();
        $subcategories = $subcat_table->getArraySubCategories();
        array_unshift($subcategories, 'Not Specified');
        
        $this->setAttribs(array(
            'role' => 'form',
            'class' => 'form-horizontal'
        ));
        $this->removeDecorator('DtDdWrapper');
        $this->removeDecorator('Label');

        $code = new Zend_Form_Element_Text('code');
        $code->setRequired()
                ->removeDecorator('htmlTag')
                ->removeDecorator('DtDdWrapper')
                ->removeDecorator('Label')
                ->setValidators(array('Alnum'))
                ->setAttribs(array(
                    'placeholder' => 'Discount Code',
                    'class' => 'form-control',
        ));
       $description = new Zend_Form_Element_Textarea('description');
       $description->setRequired()
               ->removeDecorator('htmlTag')
               ->removeDecorator('Label')
               ->removeDecorator('DtDdWrapper')
                ->setAttribs(array(
                    'COLS' => 40,
                    'ROWS' => 4,
                    'placeholder' => 'Product Decription',
                    'class' => 'form-control'
                ));
       
       $subcat_id = new Zend_Form_Element_Select('subcat_id');
       $subcat_id->setRequired()
                ->removeDecorator('htmlTag')
                ->removeDecorator('DtDdWrapper')
                ->removeDecorator('Label')
                ->setAttribs(array(
                    'class' => 'form-control',
                    'size' => 1,
                    'onChange' => 'getProducts(this.value)'
                ))
                ->addMultiOptions($subcategories);
       
       $pro_id = new Zend_Form_Element_Select('pro_id', array('RegisterInArrayValidator'=>false));
       $pro_id->setRequired()
                ->removeDecorator('htmlTag')
                ->removeDecorator('DtDdWrapper')
                ->removeDecorator('Label')
                ->setAttribs(array(
                    'class' => 'form-control',
                    'size' => 1,
                ));
       
       $init_date = new Zend_Form_Element_Text('init_date');
       $init_date->setRequired()
                ->removeDecorator('htmlTag')
                ->removeDecorator('DtDdWrapper')
                ->removeDecorator('Label')
                ->setAttribs(array(
                    'placeholder' => 'Initial Date',
                    'class' => 'datepicker form-control',
        ));
       
       $end_date = new Zend_Form_Element_Text('end_date');
       $end_date->setRequired()
                ->removeDecorator('htmlTag')
                ->removeDecorator('DtDdWrapper')
                ->removeDecorator('Label')
                ->setAttribs(array(
                    'placeholder' => 'End Date',
                    'class' => 'datepicker form-control',
        ));
       
       $status = new Zend_Form_Element_Select('status');
       $status->setRequired()
                ->removeDecorator('htmlTag')
                ->removeDecorator('DtDdWrapper')
                ->removeDecorator('Label')
                ->setAttribs(array(
                    'class' => 'form-control',
                    'size' => 1
                ))
                ->addMultiOptions(array('0'=>'active','1'=>'expired','2'=>'disabled'));
       
       $stackable = new Zend_Form_Element_Checkbox('stackable');
       $stackable->removeDecorator('htmlTag')
               ->removeDecorator('Label')
              ->removeDecorator('DtDdWrapper');
       
       $min_purchase = new Zend_Form_Element_Text('min_purchase');
       $min_purchase->setRequired()
                ->removeDecorator('htmlTag')
                ->removeDecorator('DtDdWrapper')
                ->removeDecorator('Label')
                ->setAttribs(array(
                    'placeholder' => 'Minimum Purchase US$',
                    'class' => 'form-control',
        ));
       
       $min_quantity = new Zend_Form_Element_Text('min_quantity');
       $min_quantity->removeDecorator('htmlTag')
                    ->removeDecorator('DtDdWrapper')
                    ->removeDecorator('Label')
                    ->setAttribs(array(
                    'placeholder' => 'Minimum Quantity of Products',
                    'class' => 'form-control',
        ));
       
       $percentage = new Zend_Form_Element_Text('percentage');
       $percentage->removeDecorator('htmlTag')
                    ->removeDecorator('DtDdWrapper')
                    ->removeDecorator('Label')
                    ->setAttribs(array(
                    'placeholder' => '% off purchase',
                    'class' => 'form-control',
        ));
       
       $amount = new Zend_Form_Element_Text('amount');
       $amount->removeDecorator('htmlTag')
                    ->removeDecorator('DtDdWrapper')
                    ->removeDecorator('Label')
                    ->setAttribs(array(
                    'placeholder' => '$ off purchase',
                    'class' => 'form-control',
        ));
       
       $send = new Zend_Form_Element_Submit('Submit');
       $send->removeDecorator('Label');
       $send->removeDecorator('DtDdWrapper');
       $send->removeDecorator('htmlTag');
       $send->setAttribs(array(
           'label' => 'Submit',
           'class' => 'btn btn-primary'
       ));
       
       $reset = new Zend_Form_Element_Reset('Reset');
       $reset->removeDecorator('Label');
       $reset->removeDecorator('DtDdWrapper');
       $reset->removeDecorator('htmlTag');

       $reset->setAttribs(array(
           'label' => 'Reset',
           'class' => 'btn btn-danger'
       ));
       
       $this->addElements(array($code, $description, $init_date, $end_date,$status, $stackable, $min_purchase, $min_quantity, $subcat_id, $pro_id, $percentage, $amount, $send, $reset));
       $this->setMethod('post');
       
    }

}