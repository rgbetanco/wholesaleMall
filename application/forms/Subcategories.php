<?php

class Application_Form_Subcategories extends Zend_Form
{

    public function init()
    {
        
        $model = new Application_Model_Categories();
        $option = $model->getCategories();
        
        $this->setAttribs(array(
            'role' => 'form',
            'class' => 'form-horizontal'
        ));

        $this->removeDecorator('DtDdWrapper');
        $this->removeDecorator('Label');

        $categories = new Zend_Form_Element_Select('categories');
        $categories->removeDecorator('htmlTag')
                ->removeDecorator('DtDdWrapper')
                ->removeDecorator('Label')
                ->setAttrib('size', '1')
                ->setAttribs(array(
                    'placeholder' => 'New Category',
                    'class' => 'form-control'
                ));
        $categories->addMultiOptions($option);
        
        $subcategory = new Zend_Form_Element_Text('subcategory');
        $subcategory->removeDecorator('htmlTag')
                ->removeDecorator('DtDWrapper')
                ->removeDecorator('Label')
                ->setAttribs(array(
                    'placeholder' => 'New Subcategory',
                    'class' => 'form-control'
                ));
        
        $sort = new Zend_Form_Element_Text('sort');
        $sort->removeDecorator('htmlTag')
                ->removeDecorator('DtDWrapper')
                ->removeDecorator('Label')
                ->setAttribs(array(
                    'placeholder' => 'sort order',
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
        
        $this->addElements(array($categories, $subcategory, $sort, $submit, $reset,));
        $this->setMethod('post');
    }


}

