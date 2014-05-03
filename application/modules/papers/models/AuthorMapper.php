<?php
// /application/modules/papers/models/PaperMapper.php

class Papers_Model_AuthorMapper extends Np_Model_Mapper {	

	public function __construct() {
		$this->setDbTable('Papers_Model_DbTable_Authors');
	}
 
    public function save(Papers_Model_Author $author)
    {
    	$data = $author->getOptions();
        if (null === ($id = $author->getId())) {
            unset($data['id']);
            $author->setId($this->getDbTable()->insert($data));
        } else {
            $this->getDbTable()->update($data, array('id = ?' => $id));
        }
    }
 
    public function find($id, Papers_Model_Author $author)
    {
        $result = $this->getDbTable()->find($id);
        if (0 == count($result)) {
            return;
        }
        $row = $result->current();
        $author->setOptions($row->toArray());
    }
    
    /**
     * @return author's id, if he is found, else return null
     * @param $author Papers_Model_Author
     */
    public function findByFIO(Papers_Model_Author $author) {
    	$where = $this->getDbTable()->select()
    				  ->where('f_name = ?', $author->getF_name())
    				  ->where('m_name = ?', $author->getM_name())
    				  ->where('l_name = ?', $author->getL_name());
    	$result = $this->getDbTable()->fetchAll($where);
    	if (0 == count($result)) {	
    		$author->setId(null);
    	} else {
    		$row = $result->current();
    		$author->setId($row->id);
    	}
    }
    
	public function delete(Papers_Model_Author $author){
		$id = $author->getId();
		if (empty($id)) {
			throw new Exception('Invalid model');
			return false;
		}
		$where = $this->getDbTable()
					  ->getAdapter()
					  ->quoteInto('id = ?', $id);
		$this->getDbTable()->delete($where);
	}
 
    public function fetchAll()
    {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries   = array();
        foreach ($resultSet as $row) {
            $entry = new Papers_Model_Author();
            $entry->setOptions($entry->toArray());
            $entries[] = $entry;
        }
        return $entries;
    }
	
}