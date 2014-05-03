<?php
// /application/modules/papers/models/DbTable/Papers.php

class Papers_Model_DbTable_Papers extends Zend_Db_Table_Abstract
{
    protected $_name = 'papers';
    protected $_dependentTables = array('Papers_Model_DbTable_Papers2authors');
}