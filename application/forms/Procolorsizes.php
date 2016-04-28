<?php

class Application_Form_Procolorsizes extends Zend_Form {
    /* Form Elements & Other Definitions Here ... */

    public function init() {

        $dc = new Application_Model_DbTable_Colors();
        $colorsObj = $dc->select()->from('colors', array('key' => 'id', 'value' => 'name'));
        $colors = $dc->getAdapter()->fetchAll($colorsObj);
        
        $ds = new Application_Model_DbTable_Sizes();
        $sizesObj = $ds->select()->from('sizes', array('key' => 'id', 'value' => 'name'));
        $sizes = $ds->getAdapter()->fetchAll($sizesObj);

        $this->setAttribs(array(
            'role' => 'form',
            'class' => 'form-horizontal'
        ));
        $this->removeDecorator('DtDdWrapper');
        $this->removeDecorator('Label');

        $c_id = new Zend_Form_Element_Select('c_id');
        $c_id->setRequired()
                ->addMultiOptions($colors)
                ->removeDecorator('htmlTag')
                ->removeDecorator('Label')
                ->removeDecorator('DtDdWrapper')
                ->setAttribs(array(
                    'placeholder' => 'Product Name',
                    'class' => 'form-control'
                ));

        $s_id = new Zend_Form_Element_Select('s_id');
        $s_id->setRequired()
                ->addMultiOptions($sizes)
                ->removeDecorator('htmlTag')
                ->removeDecorator('Label')
                ->removeDecorator('DtDdWrapper')
                ->setAttribs(array(
                    'placeholder' => 'Product Name',
                    'class' => 'form-control'
                ))
                ->setOptions($sizes);
        
        $sub_id = new Zend_Form_Element_Text('sub_id');
        $sub_id->setRequired()
                ->removeDecorator('htmlTag')
                ->removeDecorator('Label')
                ->removeDecorator('DtDdWrapper')
                ->setAttribs(array(
                    'placeholder' => 'Sub-Product Id',
                    'class' => 'form-control'
        ));
        
        $v_id = new Zend_Form_Element_Text('v_id');
        $v_id->removeDecorator('htmlTag')
                ->removeDecorator('Label')
                ->removeDecorator('DtDdWrapper')
                ->setAttribs(array(
                    'placeholder' => 'Volusion Id, Not Required',
                    'class' => 'form-control'
        ));
       
        $r_price = new Zend_Form_Element_Text('r_price');
        $r_price->setRequired()
                ->removeDecorator('htmlTag')
                ->removeDecorator('DtDdWrapper')
                ->removeDecorator('Label')
                ->setValidators(array('Float'))
                ->setAttribs(array(
                    'placeholder' => 'Retail Price',
                    'class' => 'form-control',
                    'onChange' => 'changeWp()'
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
        $o_price->setRequired()
                ->removeDecorator('htmlTag')
                ->removeDecorator('Label')
                ->removeDecorator('DtDdWrapper')
                ->setValidators(array('Float'))
                ->setAttribs(array(
                    'placeholder' => 'On Sale Price - Not Required',
                    'class' => 'form-control'
        ));

        $inventory = new Zend_Form_Element_Text('inventory');
        $inventory->setRequired()
                ->removeDecorator('htmlTag')
                ->removeDecorator('Label')
                ->removeDecorator('DtDdWrapper')
                ->setValidators(array('Float'))
                ->setAttribs(array(
                    'placeholder' => 'Quantity available on Inventory - Not Required',
                    'class' => 'form-control'
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

        $hash = new Zend_Form_Element_Hash('csrf', array('ignore' => true));
        $hash->removeDecorator('Label');
        $this->addElements(array($c_id, $s_id, $sub_id, $v_id, $r_price, $w_price, $o_price, $inventory, $send, $reset, $hash));
        $this->setMethod('post');
    }

}
