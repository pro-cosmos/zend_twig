<?php

class Moneybook_Model_Records extends Core_Model_Mapper {

  protected $_dbTable = 'moneybook_records';
  protected $id, $amount, $category, $date_create;

  public function __construct() {
    $this->setDbTable('Moneybook_Model_DbTable_Records');
  }

  public function getId() {
    return $this->id;
  }

  public function getAmount() {
    return $this->amount;
  }

  public function getCategory() {
    return $this->category;
  }

  public function getDate_create() {
    return $this->date_create;
  }

  public function setId($id) {
    $this->id = (int) $id;
    return $this;
  }

  public function setAmount($value) {
    $this->amount = $value;
    return $this;
  }

  public function setCategory($value) {
    $this->category = $value;
    return $this;
  }

  public function setDatecreate($value) {
    $this->date_create = $value;
    return $this;
  }

//    public function setDate_create($value) {
//    $this->date_create = $value; //?$value : time();
//    return $this;
//  }

  public function fetchAll() {
    $Category = new Moneybook_Model_Category();
    $cat = $Category->getOptionArray();

    $resultSet = $this->getDbTable()->fetchAll();
    $entries = array();
    foreach ($resultSet as $row) {
      $r = $row->toArray();
      $r['category_title'] = $cat[$r['category']];
      $entries[] = $r;
    }
    return $entries;
  }

  /**
   *
   * @param Moneybook_Model_Records $record
   */
  public function save(Moneybook_Model_Records $record) {
    $data = array(
      'amount' => $record->getAmount(),
      'category' => $record->getCategory(),
      'date_create' => $record->getDate_create()
    );

    var_dump($data); //die;
    if (null === ($id = $record->getId())) {
      unset($data['id']);
      $this->getDbTable()->insert($data);
    } else {
      $this->getDbTable()->update($data, array('id = ?' => $id));
    }
  }

  /**
   *
   * @param type $id
   * @param Moneybook_Model_Records $record
   * @return type
   */
  public function find($id, Moneybook_Model_Records $record) {
    $result = $this->getDbTable()->find($id);
    if (0 == count($result)) {
      return;
    }
    $row = $result->current();

    return $record->setId($row->id)
            ->setAmount($row->amount)
            ->setCategory($row->category)
            ->setDatecreate($row->date_create);
  }

}