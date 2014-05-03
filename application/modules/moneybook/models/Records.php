<?php

class Moneybook_Model_Records extends Core_Model_Mapper
{
  protected $_dbTable = 'moneybook_records';
	protected $id, $amount, $category, $date_create;

  	public function __construct() {
		   $this->setDbTable('Moneybook_Model_DbTable_Records');
	  }

     public function fetchAll()
    {
        $resultSet = $this->getDbTable()->fetchAll();
        //var_dump($resultSet);
        $entries   = array();
        foreach ($resultSet as $row) {
          $r = $row->toArray();
          $entries[] = $r; 
        }
        return $entries;
    }
}