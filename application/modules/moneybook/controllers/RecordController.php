<?php

// /application/modules/papers/controllers/IndexController.php

class Moneybook_RecordController extends Zend_Controller_Action {

  public function indexAction() {

    $Records = new Moneybook_Model_Records();
    $rec = $Records->fetchAll();

    $d = array();
    foreach ($rec as $r) {
      $d[] = $r;
    }

    $this->view->rows = $d;
  }

  public function deleteAction() {
    $this->_helper->viewRenderer->setNoRender(true);
    $Record = new Moneybook_Model_Records();
    $delRecord = $Record->find($this->getRequest()->getParam('id'), $Record);
    if ($delRecord)
      $delRecord->delete($delRecord);

    return $this->_helper->redirector('index', 'index');
  }

  public function addAction() {
    $this->view->headTitle('Добавить статью');

    $request = $this->getRequest();
    $form = new Moneybook_Form_Records_Add();

    if ($request->isPost()) {
      if ($form->isValid($request->getPost())) {
        $Record = new Moneybook_Model_Records($request->getPost()); //$form->getValues());
        $Record->setOptions($request->getPost());
        $Record->save($Record);
        return $this->_helper->redirector('index', 'index');
      }
    }

    $this->view->form = $form;
  }

  public function editAction() {
    $this->view->headTitle('Изменить расход');

    $request = $this->getRequest();

    $Record = new Moneybook_Model_Records();
    $editRecord = $Record->find($this->getRequest()->getParam('id'), $Record);
    $editRecord->setDatecreate(date('d-m-Y', strtotime($editRecord->getDate_create())));
    $form = new Moneybook_Form_Records_Edit();
    $form->populate($editRecord->getOptions());
    //$form->populate(array('authors' => $model->getAuthors(false)));

    if ($request->isPost()) {
      if ($form->isValid($request->getPost())) {
        $Record = new Moneybook_Model_Records($request->getPost()); //$form->getValues());

        $dataPost = $request->getPost();
        $dataPost['date_create'] = date('Y-m-d H:i:s', strtotime($dataPost['date_create']));

        $Record->setOptions($dataPost);

        $Record->save($Record);
        return $this->_helper->redirector('index', 'index');
      }
    }

    $this->view->form = $form;
  }

}