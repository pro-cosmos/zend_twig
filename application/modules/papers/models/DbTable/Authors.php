<?php
// /application/modules/papers/models/DbTable/Authors.php

class Papers_Model_DbTable_Authors extends Zend_Db_Table_Abstract
{
    protected $_name = 'authors';
    protected $_dependentTables = array('Papers_Model_DbTable_Papers2authors');
    protected $_referenceMap    = array(
	        'Organization' => array(
	            'columns'           => 'id',
	            'refTableClass'     => 'Papers_Model_DbTable_Organizations',
	            'refColumns'        => 'id'
	        ));
}