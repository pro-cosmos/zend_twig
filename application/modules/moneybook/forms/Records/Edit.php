<?php

class Moneybook_Form_Records_Edit extends Zend_Form
{

    public function init()
    {
        $this->setMethod('post');
        $this->setAttrib('enctype', 'multipart/form-data');

       	$this->addElement('hidden', 'id', array(
       		'decorators' => array('ViewHelper')
       	));

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
       						 Петров Семен Семенович". Способы ввода авторов можно комбинировать.',
        	//'decorators' => array(array('Description', array('escape' => false))),
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

        $this->addElement('file', 'file', array(
        	'label'		=> 'Прикрепить работу:',
        	'validators'=>	array(
         						array('Extension', false, 'doc, docx, odt, pages, pdf, tex, xps'),
         						array('Size', false, 52428800)),
        	//'destination'=>	realpath(APPLICATION_PATH . '/../public/media/papers'),
        ));

        $this->addElement ('submit', 'submit', array(
            'label'	=> 'Обновить',
        	'class'	=>	'ui-state-default ui-corner-all ui-button',
			'decorators'	=>	array('ViewHelper')
		));

        $this->addElement ('button', 'delete', array(
            	'label'	=> 'Удалить',
        		'id'	=>	'delete-button',
        		'class'	=>	'ui-state-default ui-corner-all ui-button',
        		'decorators'	=>	array('ViewHelper')
        ));

       $this->addDisplayGroup(array('submit', 'delete'), 'submitButtons', array(
	        'decorators' => array(
	            'FormElements',
	            array('HtmlTag', array('tag' => 'div', 'class' => 'form-buttons')),
	        ),
	   ));
    }

    /**
     *
     * @param $values array with model's values
     */
    public function populate(array $values) {
    	if (!empty($values['file'])) {
	    	$this->addElement('text', 'fileLink', array(
	    		'description'	=> '<a href="http://'. $_SERVER['HTTP_HOST'] . $values['file'] . '">Скачать прикрепленную работу</a>',
	    		'decorators' 	=> array(array('Description', array('escape'	=> false, 'tag' => false))),
	    		'order'			=> 8
	    	));
    	}

	    parent::populate($values);
    }
}