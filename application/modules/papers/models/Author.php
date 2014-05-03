<?php
// /application/modules/papers/models/Author.php

class Papers_Model_Author
{
	protected $id, $f_name, $m_name, $l_name, $organization_id;
	
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
	
	
	
	/**
	 * 
	 * @param boolean $short
	 * @return if $short = true returns Last_Name F.M., else Last_Name First_Name Middle_Name
	 */
	public function getFIO($short = true) {
		if ($short) {
			return $this->l_name . ' ' .
	    				mb_substr($this->f_name, 0, 1, 'utf-8') . '.' . 
	    				(empty($this->m_name) ?
	    			 	'' : (mb_substr($this->m_name, 0, 1, 'utf-8') . '.'));
		} else { 
	    	return $this->l_name . ' ' . 
	    		   $this->f_name . ' ' .
	    		   $this->m_name;
		}
	}
	
	public function getId() {
		return $this->id;
	}

	public function setId($id) {
		$this->id = $id;
		return $this;
	}

	public function getF_name() {
		return $this->f_name;
	}

	public function setF_name($f_name) {
		$this->f_name = $f_name;
		return $this;
	}

	public function getM_name() {
		return $this->m_name;
	}

	public function setM_name($m_name) {
		$this->m_name = $m_name;
		return $this;
	}

	public function getL_name() {
		return $this->l_name;
	}

	public function setL_name($l_name) {
		$this->l_name = $l_name;
		return $this;
	}

	public function getOrganization_id() {
		return $this->organization_id;
	}

	public function setOrganization_id($organization_id) {
		$this->organization_id = $organization_id;
		return $this;
	}
}