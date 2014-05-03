<?php 
/**
 * Standart model with all neccery stuff
 * Recommended to use with data mapper
 */
abstract class Np_Model {
	
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
}