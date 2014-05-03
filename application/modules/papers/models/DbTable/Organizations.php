<?php

// /application/modules/papers/models/DbTable/Organizations.php

class Papers_Model_DbTable_Organizations extends Zend_Db_Table_Abstract
{
    protected $_name = 'organizations';
	protected $_dependentTables = array('Papers_Model_DbTable_Authors');

}