<?php

// /application/modules/papers/controllers/IndexController.php

class Moneybook_RecordController extends Zend_Controller_Action {

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


  public function addAction()
    {
    	$this->view->headTitle('Добавить статью');

    	$request = $this->getRequest();
      $form    = new Moneybook_Form_Records_Add();

        if ($request->isPost()) {
        	if ($form->isValid($request->getPost())) {
//            	$paper = new Papers_Model_Paper($form->getValues());
//            	$paper->setTitle_en($form->title)
//            		  ->setFile($form->file)
//            		  ->setAuthors($form->authors);
//            	$mapper	= new Papers_Model_PaperMapper();
//                $mapper->save($paper);
//                return $this->_helper->redirector('index', 'index');
            }
        }

        $this->view->form = $form;
    }


    public function editAction()
    {
    	$this->view->headTitle('Добавить статью');
var_dump($this);
    	$request = $this->getRequest();
      $form    = new Moneybook_Form_Records_Add();

        if ($request->isPost()) {
        	if ($form->isValid($request->getPost())) {
//            	$paper = new Papers_Model_Paper($form->getValues());
//            	$paper->setTitle_en($form->title)
//            		  ->setFile($form->file)
//            		  ->setAuthors($form->authors);
//            	$mapper	= new Papers_Model_PaperMapper();
//                $mapper->save($paper);
//                return $this->_helper->redirector('index', 'index');
            }
        }

        $this->view->form = $form;
    }

}