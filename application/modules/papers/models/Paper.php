<?php
// /application/modules/papers/models/Paper.php

class Papers_Model_Paper
{
  	protected $id, $file, $title, $title_en, $authors, $source, $publisher, $date;
  	
  	/**
	 * Routine part. Suggest move it to external class and extend it
	 * =============================================================
	 */
	
	public function __construct(array $options = null)
    {
        if (is_array($options)) {
            $this->setOptions($options);
        }
    }
 
    public function __set($name, $value)
    {
        $method = 'set' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid model property ' . $name);
        }
        $this->$method($value);
    }
 
    public function __get($name)
    {
        $method = 'get' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid model property ' . $name);
        }
        return $this->$method();
    }
    
    /**
     * Set all properties
     * 
     * @param $options
     */
    public function setOptions(array $options)
    {
        $methods = get_class_methods($this);
        foreach ($options as $key => $value) {
            $method = 'set' . ucfirst($key);
            if (in_array($method, $methods)) {
                $this->$method($value);
            }
        }
        return $this;
    }
    
    /**
     * Get all properties with values
     * 
     * @return $dataArray  key-value array 'property' => 'value' 
     */
    public function getOptions() {
    	$methods = get_class_methods($this);
    	$dataArray = array();
    	foreach ($methods as $m) {
    		list($property) = sscanf($m, 'get%s');
    		$property = strtolower($property); 
    		if(!empty($property) && property_exists($this, $property))
    			$dataArray[$property] = $this->$m();   		
    	}
    	
    	return $dataArray;
    }
    
    /**
     * Routine end.
     * =====================================================================
     */
  	
  	
    public function getId()
    {
        return $this->id;
    }
    
    public function setId($id)
    {
        $this->id = (int) $id;
        return $this;
    }
 
    public function getFile()
    {
        return $this->file;
    }
 
    public function setFile($file)
    {
    	//Zend_Debug::dump($file);
    	if ($file instanceof Zend_Form_Element_File && $file->isReceived()) {
       		$extension = substr(strrchr($file->getFileName(null, false), '.'), 1);
       		//$newName = md5(uniqid(rand(), true)) . '.' . $extension;
       		$newName = $this->title_en . '.' . $extension;
       		$uploadPath = realpath(APPLICATION_PATH . '/../public/media/papers') . '/' . $newName;
       		$filterFileRename = new Zend_Filter_File_Rename(
	 					array('target' => $uploadPath, 'overwrite' => true));		
			$filterFileRename->filter($file->getFileName());

			$this->file = '/media/papers/' . $newName;
			return $this;
       }
       $this->file = $file;
       return $this;
    }

	public function getTitle() {
		return $this->title;
	}

	public function setTitle($title) {
		$this->title = $title;
		return $this;
	}
	
	public function getTitle_en() {
		return $this->title_en;
	}

	public function setTitle_en($title_en) {
		if ($title_en instanceof Zend_Form_Element_Text) {
			$title_enMaxLength = 42;
	    	$title_en = Np_Text_FromRussian2Translit::convert($title_en->getValue());
	        if (strlen($title_en) < $title_enMaxLength)
	        	$title_enMaxLength = strlen($title_en);
	        //cut title with full last word within next 42 letters
	        $title_en = (strtolower(substr($title_en, 0, strpos($title_en, '_', $title_enMaxLength))));	    	
		}
		$this->title_en = $title_en;
		return $this;
	}
	
	public function getAuthors($getArray = true) {
		if (!$getArray) {
			$array = $this->authors;
			$authors = '';
			foreach ($array as $author) {
				$authors .= $author->getFIO(false);
	    		if (true == next($array)) $authors .= ', ';
			}
			return $authors;
		}
		return $this->authors;
	}
	
	public function setAuthors($authors) {
		if ($authors instanceof Zend_Db_Table_Rowset_Abstract) {
			$this->authors  = array();
			foreach ($authors as $a) {
				$authorModel = new Papers_Model_Author();
				$authorModel->setOptions($a->toArray());
				$this->authors[] = $authorModel;
			}
			return $this;
		}
		
		// String with authors comes from form
		// All new authors must be added to DB and linked with this paper
		// Presented authors must be linked with this paper
		if ($authors instanceof Zend_Form_Element_Text && $authors->getValue() != null) {
			preg_match_all("/([^\s\.,]+)\s*([^\s\.]*)[\s\.]*([^\s\.,]*),*/", $authors->getValue(), $authorsArray, PREG_SET_ORDER);
			//Zend_Debug::dump($authorsArray);
			$authorMapper = new Papers_Model_AuthorMapper();
			$paperMapper = new Papers_Model_PaperMapper();
			//1. Delete all authors connections with this paper
			$p2aDbTable = new Papers_Model_DbTable_Papers2authors();
			$p2aDbTable->delete($p2aDbTable->getAdapter()->quoteInto('paper_id = ?', $this->getId()));
			foreach ($authorsArray as $key => $value) {
				$authorModel = new Papers_Model_Author(array(
					'l_name'	=>	$authorsArray[$key][1],
					'f_name'	=>	$authorsArray[$key][2],
					'm_name'	=>	$authorsArray[$key][3]
				));
				//2. Check if this author already in DB
				$authorMapper->findByFIO($authorModel);
				if(!$authorModel->getId()) {
					//if it's new author, add him to DB
					$authorMapper->save($authorModel); 
				}
				//3. Connect author with paper
				$p2aDbTable->insert(array(
					'author_id'	=>	$authorModel->getId(),
					'paper_id'	=>	$this->getId()	
				));			
			}
			return $this;
		}
		$this->authors = $authors;
		return $this;
	}
	
	public function getSource() {
		return $this->source;
	}

	public function setSource($source) {
		$this->source = $source;
		return $this;
	}
	
	
	public function getPublisher() {
		return $this->publisher;
	}

	public function setPublisher($publisher) {
		$this->publisher = $publisher;
		return $this;
	}

	public function getDate() {
		return $this->date;
	}

	public function setDate($date) {
		$this->date = $date;
		return $this;
	}
}