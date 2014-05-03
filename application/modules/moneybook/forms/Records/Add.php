<?php

class Moneybook_Form_Records_Add extends Zend_Form
{

    public function init()
    {
        $this->setMethod('post');
        $this->setAttrib('enctype', 'multipart/form-data');

        $this->addElement('text', 'title', array(
        	'label'      => 'Название статьи:',
        	'required'   => true,
        	'size'		 => 90,
        	'filters'    => array('StringTrim'),
        ));

        $this->addElement('hidden', 'title_en', array(
       		'decorators' => array('ViewHelper')
       	));

        $this->addElement('text', 'authors', array(
        	'label'      => 'Авторы:',
       		'description'=> 'Вводите авторов через запятую.
       						 Например: "Креведко И. Я., Иванов А.Я." или "Иванов Иван Иванович,
       						 Петров Семен Семенович".',
        	'size'		 => 90,
        	'filters'    => array('StringTrim'),
        ));

        $this->addElement('text', 'source', array(
        	'label'      => 'Источник:',
        	'size'		 => 90,
        	'filters'    => array('StringTrim'),
        ));

        $this->addElement('text', 'publisher', array(
        	'label'      => 'Издатель:',
        	'size'		 => 50,
        	'filters'    => array('StringTrim'),
        ));

        $this->addElement('text', 'date', array(
        	'label'      => 'Дата публикации:',
        	'maxlength'	 => 10,
        	'size'		 => '11',
			'value'		 => date('Y-m-d'),
        	'filters'    => array('StringTrim'),
        	'validator'  => 'date'
        ));


        $this->addElement('submit', 'submit', array(
            'ignore'   => true,
            'label'    => 'Добавить статью',
        	'class'	   => 'ui-state-default ui-corner-all ui-buttons'
        ));
    }
}