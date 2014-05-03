<?php

// /application/modules/papers/controllers/IndexController.php

class Moneybook_IndexController extends Zend_Controller_Action {

  public function indexAction() {

    $Records = new Moneybook_Model_Records();
    $rec = $Records->fetchAll();

    $d = array();
    foreach ($rec as $r) {
      //var_dump($r);
      $d[] = $r;
    }

    $this->view->rows = $d;
  }

 public function reportAction() {

    $Records = new Moneybook_Model_Records();
    $rec = $Records->fetchAll();

    $d = array();
    foreach ($rec as $r) {
      //var_dump($r);
      $d[] = $r;
    }
    $this->view->rows = $d;


    $url = explode('/',$this->getRequest()->getRequestUri());
    $this->view->pageheader = $url[4];


    }

}