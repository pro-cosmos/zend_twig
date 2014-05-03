<?php

class Moneybook_Model_DbTable_Category extends Zend_Db_Table_Abstract
{
  protected $_name = 'moneybook_category';
	protected $_dependentTables = array('Moneybook_Model_DbTable_Records');

}