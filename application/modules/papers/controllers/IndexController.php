<?php
// /application/modules/papers/controllers/IndexController.php

class Papers_IndexController extends Zend_Controller_Action
{

    public function init()
    {

    }

    public function indexAction()
    {
        //$this->view->headTitle('Список статей');
        $paper = new Papers_Model_PaperMapper();
        //$this->view->entries = $paper->fetchAll();

          $this->view->content = phpversion();
        $this->view->phpversion = phpversion();
		$this->view->phpuname = php_uname();
$this->view->sections = array('11','22','33');;
       // $this->view->assign('sections', array('Section 11', 'Section 22', 'Section 33', 'Section 4'));
    }

    public function addPaperAction()
    {
    	$this->view->headTitle('Добавить статью');

    	$request = $this->getRequest();
        $form    = new Papers_Form_Paper_Add();
var_dump($request->getPost());

        if ($request->isPost()) {
        	if ($form->isValid($request->getPost())) {
            	$paper = new Papers_Model_Paper($form->getValues());
            	$paper->setTitle_en($form->title)
            		  ->setFile($form->file)
            		  ->setAuthors($form->authors);



            	$mapper	= new Papers_Model_PaperMapper();
                $mapper->save($paper);
               // return $this->_helper->redirector('index', 'index');
            }
        }

        $this->view->form = $form;

//$this->form->setAction($this->url());
//echo $this->form;
    }

    public function editPaperAction()
    {
        $this->view->headTitle('Редактировать статью');

    	$request = $this->getRequest();
        $model	 = new Papers_Model_Paper();
        $mapper  = new Papers_Model_PaperMapper();
        $mapper->find($request->getParam('id'), $model);
        $form    = new Papers_Form_Paper_Edit();
        $form->populate($model->getOptions());
        $form->populate(array('authors' => $model->getAuthors(false)));



if ($request->isPost()) {
        	if ($form->isValid($request->getPost())) {
            	$paper = new Papers_Model_Paper($form->getValues());
            	$paper->setTitle_en($form->title)
            		  ->setFile($form->file->isReceived() ?
            		  			$form->file:
            		  			$model->getFile())
            		  ->setAuthors($form->authors);
                $mapper->save($paper);
                //return $this->_helper->redirector('edit-paper');
            }
        }

        $this->view->form = $form;
    }

    public function deletePaperAction() {
		$this->_helper->viewRenderer->setNoRender(true);
    	$model	 = new Papers_Model_Paper();
        $mapper  = new Papers_Model_PaperMapper();
        $mapper->find($this->getRequest()->getParam('id'), $model);
    	$mapper->delete($model);

    	return $this->_helper->redirector('index','index');
    }

}