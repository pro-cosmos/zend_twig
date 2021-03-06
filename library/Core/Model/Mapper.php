<?php

class Core_Model_Mapper {

  protected $_dbTable;

  public function __construct(array $options = null) {
    if (is_array($options)) {
      $this->setOptions($options);
    }
  }

  public function __call($fname, $arguments) {

    if (preg_match('@^(set|get)(.+)$@i', $fname, $matches)) {
      $name = strtolower($matches[2]);
      $pref = $matches[1];
      if ($pref == 'get')
        return $this->$name;

      if ($pref == 'set') {
        $this->$name = $arguments;
      }
    }
  }

  public function __set($name, $value) {
    $method = 'set' . $name;
    if (('mapper' == $name) || !method_exists($this, $method)) {
      throw new Exception('Invalid model property ' . $name);
    }
    $this->$method($value);
  }

  public function __get($name) {
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
  public function setOptions(array $options) {
    $methods = get_class_methods($this);
    foreach ($options as $key => $value) {
      $method = 'set' . ucfirst(str_replace('_', '', $key));
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
      if (!empty($property) && property_exists($this, $property))
        $dataArray[$property] = $this->$m();
    }

    return $dataArray;
  }

  //---------mapper
  public function setDbTable($dbTable) {
    if (is_string($dbTable)) {
      $dbTable = new $dbTable();
    }
    if (!$dbTable instanceof Zend_Db_Table_Abstract) {
      throw new Exception('Invalid table data gateway provided');
    }
    $this->_dbTable = $dbTable;
    return $this;
  }

  public function getDbTable() {
    return $this->_dbTable;
  }

  /**
   *
   * @param type $obj
   * @return type
   */
  public function delete($obj) {
    $id = $obj->getId();
    if (empty($id)) {
      throw new Exception('Invalid model');
      return false;
    }
    $where = $this->getDbTable()
        ->getAdapter()
        ->quoteInto('id = ?', $id);
    $this->getDbTable()->delete($where);
  }

  /**
   *
   * @param type $params
   * @param type $extra
   * @return type
   */
  public function findBy($params, $extra = array()) {
    $extWhere = array('date_create_month' => " DATE_FORMAT(date_create,'%Y-%m') = ?");

    $table = $this->getDbTable();
    $select = $table->select();
    foreach ($params as $name => $value) {
      if (property_exists($this, $name) || isset($extWhere[$name])) {

        if (in_array($name, array_keys($extWhere))) {
          $select->where($extWhere[$name], $value);
        } else {
          if (is_array($value)) {
            $select->where("$name in (?)", $value);
          } elseif (is_bool($value)) {
            $select->where(sprintf('%s is %s', $name, $value ? 'true' : 'false'));
          } else {
            $select->where("$name = ?", $value);
          }
        }
      }
    }

    if (!empty($extra['limit'])) {
      $select->limit($extra['limit'], $extra['offset']);
    }

    //var_dump($select->__toString());
    return $table->fetchAll($select);
  }

}