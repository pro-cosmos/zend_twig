<?php

class Moneybook_IndexController extends Zend_Controller_Action {

  public function indexAction() {

    $Records = new Moneybook_Model_Records();
    $rec = $Records->fetchAll();
    $d = array();
    foreach ($rec as $r) {
       $r['date_create'] = date('d-m-Y',strtotime($r['date_create']));
      $d[] = $r;
    }

    $this->view->rows = $d;
    $this->view->pageheader = 'Список всех расходов';
  }

 public function reportAction() {

    $datemonth = $this->getRequest()->getParam('date');

    $Category = new Moneybook_Model_Category();
    $cat = $Category->getOptionArray();

    $Records = new Moneybook_Model_Records();
    $rec = $Records->findBy(array('date_create_month'=>$datemonth));
    $d = array();
    foreach ($rec as $row) {
      $r = $row->toArray();
      $r['category_title'] = $cat[$r['category']];
      $d[] = $r;
    }

    $this->view->rows = $d;
    $this->view->pageheader = 'Расходы за '.$datemonth;
    $this->_helper->viewRenderer('index/index', null, true);
    }

}