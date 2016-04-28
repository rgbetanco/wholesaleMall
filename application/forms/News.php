<?php

class Application_Form_News extends Zend_Form
{

    public function init()
    {
        $this->setAttribs(array(
            'role' => 'form',
            'class' => 'form-horizontal'
        ));

        $this->removeDecorator('DtDdWrapper');
        $this->removeDecorator('Label');
        $this->setAttrib('enctype', 'multipart/form-data');
        
        $title = new Zend_Form_Element_Text('title');
        $title->removeDecorator('htmlTag')
                ->setRequired()
                ->removeDecorator('DtDdWrapper')
                ->removeDecorator('Label')
                ->setAttrib('size', '20')
                ->setAttribs(array(
                    'placeholder' => 'News Title',
                    'class' => 'form-control'
                ));
        
        $description = new Zend_Form_Element_Textarea('description');
        $description->removeDecorator('htmlTag')
                ->setRequired()
                ->removeDecorator('DtDdWrapper')
                ->removeDecorator('Label')
                ->setAttribs(array(
                    'COLS' => 40,
                    'ROWS' => 4,
                    'placeholder' => 'News Content',
                    'class' => 'form-control'
                ));
        
       $active = new Zend_Form_Element_Checkbox('active');
       $active->removeDecorator('htmlTag')
               ->removeDecorator('Label')
              ->removeDecorator('DtDdWrapper');
        
       $sort = new Zend_Form_Element_Text('order');
       $sort->removeDecorator('htmlTag')
                ->removeDecorator('DtDdWrapper')
                ->removeDecorator('Label')
                ->setAttrib('size', '10')
                ->setAttribs(array(
                    'placeholder' => 'Sort',
                    'class' => 'form-control input-sm'
                ));
       
       $pic = new Zend_Form_Element_File('pic');
       $pic->setDestination(APPLICATION_PATH . '/../public/development/news_img')
                ->setIsArray(true)
                ->setValueDisabled(true)
                ->removeDecorator('htmlTag')
                ->removeDecorator('DtDdWrapper')
                ->removeDecorator('Label')
                ->addValidator('Size', false, '2MB')
                ->addValidator('Count', true, array('min' => 1, 'max' => 1))
                ->addValidator('Extension', false, 'jpg, png, gif')
                ->setAttrib('enctype', 'multipart/form-data');
       
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
        
        $this->addElements(array($title, $description, $active, $sort, $pic, $submit, $reset,));
        $this->setMethod('post');
    }
}