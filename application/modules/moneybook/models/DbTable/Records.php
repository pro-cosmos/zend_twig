<?php

class Moneybook_Model_DbTable_Records extends Zend_Db_Table_Abstract
{
    protected $_name = 'moneybook_records';
    protected $_dependentTables = array('Moneybook_Model_DbTable_Category');
    protected $_referenceMap    = array(
	        'Category' => array(
	            'columns'           => 'category',
	            'refTableClass'     => 'Moneybook_Model_DbTable_Category',
	            'refColumns'        => 'id'
	        ));
}