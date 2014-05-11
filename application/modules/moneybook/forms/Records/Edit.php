<?php

class Moneybook_Form_Records_Edit extends Zend_Form {

  public function init() {
    $this->setMethod('post');
    //$this->setAttrib('enctype', 'multipart/form-data');

    $Category = new Moneybook_Model_Category();
    $this->addElement('select', 'category', array(
      'label' => 'Категория:',
      'required' => true,
      'multiOptions' => $Category->getOptionArray(),
        //'filters'    => array('StringTrim'),
    ));

       	$this->addElement('hidden', 'id', array(
       		'decorators' => array('ViewHelper')
       	));

    $this->addElement('text', 'amount', array(
      'label' => 'Сумма:',
      'required' => true,
      'size' => 90,
      'filters' => array('StringTrim'),
    ));

    $this->addElement('text', 'date_create', array(
      'label' => 'Дата создания:',
      'maxlength' => 10,
      'size' => '11',
      'value' => date('Y-m-d'),
      'filters' => array('StringTrim'),
      'validator' => 'date',
      'class' => 'span2',
      'data-format'=>"dd-MM-yyyy",
      'decorators' => array(
        'ViewHelper',
        'label'
      )
    ));


    $this->addElement('submit', 'submit', array(
      'ignore' => true,
      'label' => 'Сохранить',
      'class' => 'ui-state-default ui-corner-all ui-buttons btn btn-primary'
    ));
  }

}