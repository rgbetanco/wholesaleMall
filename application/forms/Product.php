<?php

class Application_Form_Product extends ZendX_JQuery_Form
{

    public function init()
    {
        $this->setAttribs(array(
           'role' => 'form',
           'class' => 'form-horizontal'
       ));
        $this->removeDecorator('DtDdWrapper');
        $this->removeDecorator('Label');
       
       $name = new Zend_Form_Element_Text('name');
       $name->setRequired()
               ->removeDecorator('htmlTag')
               ->removeDecorator('Label')
               ->removeDecorator('DtDdWrapper')
                ->setAttribs(array(
                    'placeholder' => 'Product Name',
                    'class' => 'form-control'
                ));
       
       $product_id = new Zend_Form_Element_Text('product_id');
       $product_id->setRequired()
               ->removeDecorator('htmlTag')
               ->removeDecorator('Label')
               ->removeDecorator('DtDdWrapper')
                ->setAttribs(array(
                    'placeholder' => 'product id',
                    'class' => 'form-control'
                ));
       
       $description = new Zend_Form_Element_Textarea('description');
       $description->setRequired()
               ->removeDecorator('htmlTag')
               ->removeDecorator('Label')
               ->removeDecorator('DtDdWrapper')
                ->setAttribs(array(
                    'placeholder' => 'Product Decription',
                    'class' => 'form-control'
                ));

       $sec_description = new Zend_Form_Element_Textarea('sec_description');
       $sec_description->setRequired()
               ->removeDecorator('htmlTag')
               ->removeDecorator('Label')
               ->removeDecorator('DtDdWrapper')
                ->setAttribs(array(
                    'placeholder' => 'Second Product Decription',
                    'class' => 'form-control'
                ));

      $dogopet_url = new Zend_Form_Element_Text('dogopet_url');
      $dogopet_url->setRequired()
               ->removeDecorator('htmlTag')
               ->removeDecorator('Label')
               ->removeDecorator('DtDdWrapper')
                ->setAttribs(array(
                    'placeholder' => 'Dogopet URL',
                    'class' => 'form-control'
                ));

      $expires = new ZendX_JQuery_Form_Element_DatePicker('expires', array('jQueryParams' => array('dateFormat' => 'mm-dd-yy')));
      $expires->setLabel('Expiration Date:')
                ->removeDecorator('htmlTag')
                ->removeDecorator('DtDdWrapper')
                ->removeDecorator('Label')
                ->setRequired()
                ->setAttribs(array(
                    'placeholder' => 'Expiration Date for Second Product Description',
                    'class' => 'form-control',
                    'id'    => 'datepicker'
                ))
                ->addValidator(new Zend_Validate_Date(array('format' => 'mm-dd-yy')));
       
       $r_price = new Zend_Form_Element_Text('r_price');
       $r_price->setRequired()
               ->removeDecorator('htmlTag')
               ->removeDecorator('DtDdWrapper')
               ->removeDecorator('Label')
               ->setValidators(array('Float'))
               ->setAttribs(array(
                    'placeholder' => 'Retail Price',
                    'class' => 'form-control'
                ));
       
       $w_price = new Zend_Form_Element_Text('w_price');
       $w_price->setRequired()
               ->removeDecorator('htmlTag')
               ->removeDecorator('Label')
               ->removeDecorator('DtDdWrapper')
               ->setValidators(array('Float'))
               ->setAttribs(array(
                    'placeholder' => 'Wholesale Price',
                    'class' => 'form-control'
                ));
       
       $o_price = new Zend_Form_Element_Text('o_price');
       $o_price->removeDecorator('htmlTag')
               ->removeDecorator('Label')
               ->removeDecorator('DtDdWrapper')
               ->setValidators(array('Float'))
               ->setAttribs(array(
                    'placeholder' => 'On Sale Price - Not Required',
                    'class' => 'form-control'
                ));
       
       $active = new Zend_Form_Element_Checkbox('active');
       $active->removeDecorator('htmlTag')
               ->removeDecorator('Label')
              ->removeDecorator('DtDdWrapper');
       
       $new = new Zend_Form_Element_Checkbox('new');
       $new->removeDecorator('htmlTag')
               ->removeDecorator('Label')
              ->removeDecorator('DtDdWrapper');
       
       $preorder = new Zend_Form_Element_Checkbox('pre_order');
       $preorder->removeDecorator('htmlTag')
               ->removeDecorator('Label')
              ->removeDecorator('DtDdWrapper');
       
       $onsale = new Zend_Form_Element_Checkbox('on_sale');
       $onsale->removeDecorator('htmlTag')
               ->removeDecorator('Label')
              ->removeDecorator('DtDdWrapper');
       
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
       
       $hash = new Zend_Form_Element_Hash('csrf',array('ignore'=>true));
       $hash->removeDecorator('Label');
       $this->addElements(array($name, $product_id, $description, $sec_description, $dogopet_url, $expires, $r_price, $w_price, $o_price, $active, $new, $preorder, $onsale, $send, $reset));
       $this->setMethod('post');
    }
}

