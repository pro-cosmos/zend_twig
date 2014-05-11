<?php

class Moneybook_Form_Records_Add extends Zend_Form {

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

    $this->addElement('text', 'amount', array(
      'label' => 'Сумма:',
      'required' => true,
      'size' => 90,
      'filters' => array('StringTrim'),
    ));


    $this->addElement('submit', 'submit', array(
      'ignore' => true,
      'label' => 'Добавить',
      'class' => 'ui-state-default ui-corner-all ui-buttons btn btn-primary'
    ));
  }

}