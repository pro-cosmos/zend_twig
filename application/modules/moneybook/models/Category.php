<?php

class Moneybook_Model_Category extends Core_Model_Mapper
{
  protected $_dbTable = 'moneybook_category';
	protected $id, $title;

  	public function __construct() {
		   $this->setDbTable('Moneybook_Model_DbTable_Category');
	  }

     public function fetchAll()
    {
        $resultSet = $this->getDbTable()->selectAll();
        $entries   = array();
        foreach ($resultSet as $row) {
         $r = $row->toArray();
        }
        return $entries;
    }

        public function getOptionArray()
    {
        $options = $this->getDbTable()->fetchAll();
        $out = array();
        foreach($options as $op){
          $out[$op['id']] = $op['title'];
        }

        return $out;
    }
}