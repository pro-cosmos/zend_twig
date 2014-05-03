<?php 
// /application/modules/papers/models/PaperMapper.php

class Papers_Model_PaperMapper extends Np_Model_Mapper {	

	public function __construct() {
		$this->setDbTable('Papers_Model_DbTable_Papers');
	}
 
    public function save(Papers_Model_Paper $paper)
    {
    	$data = array(
            'file'		=> $paper->getFile(),
            'title'		=> $paper->getTitle(),
        	'title_en'	=> $paper->getTitle_en(),
            'source'	=> $paper->getSource(),
        	'publisher'	=> $paper->getPublisher(),
        	'date'		=> $paper->getDate(),
        );
        if (null === ($id = $paper->getId())) {
            unset($data['id']);
            $this->getDbTable()->insert($data);
        } else {
            $this->getDbTable()->update($data, array('id = ?' => $id));
        }
    }
 
    public function find($id, Papers_Model_Paper $paper)
    {
        $result = $this->getDbTable()->find($id);
        if (0 == count($result)) {
            return;
        }
        $row = $result->current();
        $paper->setId($row->id)
              ->setFile($row->file)
              ->setTitle($row->title)
              ->setTitle_en($row->title_en)
              ->setSource($row->source)
              ->setPublisher($row->publisher)
              ->setDate($row->date)
              ->setAuthors($row->findManyToManyRowset('Papers_Model_DbTable_Authors',
	              									  'Papers_Model_DbTable_Papers2authors'));
    }
    
	public function delete(Papers_Model_Paper $paper){
		$id = $paper->getId();
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
            $entry = new Papers_Model_Paper();
            $entry->setId($row->id)
	              ->setFile($row->file)
	              ->setTitle($row->title)
	              ->setTitle_en($row->title_en)
	              ->setSource($row->source)
	              ->setPublisher($row->publisher)
	              ->setDate($row->date)
	              ->setAuthors($row->findManyToManyRowset('Papers_Model_DbTable_Authors',
	              										  'Papers_Model_DbTable_Papers2authors'));
            $entries[] = $entry;
        }
        return $entries;
    }
	
}