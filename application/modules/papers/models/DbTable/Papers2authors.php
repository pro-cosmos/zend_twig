<?php
// /application/modules/papers/models/DbTable/Papers2authors.php

class Papers_Model_DbTable_Papers2authors extends Zend_Db_Table_Abstract
{

    protected $_name = 'papers2authors';
	
    protected $_referenceMap    = array(
        'Paper' => array(
            'columns'           => array('paper_id'),
            'refTableClass'     => 'Papers_Model_DbTable_Papers',
            'refColumns'        => array('id')
        ),
        'Author' => array(
            'columns'           => array('author_id'),
            'refTableClass'     => 'Papers_Model_DbTable_Authors',
            'refColumns'        => array('id')
        )
    );

}