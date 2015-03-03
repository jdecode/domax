<?php

App::uses('AppController', 'Controller');
App::uses('Client', 'Model');

/**
 * Uploads Controller
 *
 * @property Upload $Upload
 */
class ManageFoldersController extends AppController {

	public function admin_manage() {
		
		$this->loadModel('Uploads');

		//$this->paginate["conditions"] = $con;
		$this->Paginator->settings = $this->paginate;
		$this->set('manageFolders', $this->paginate());
		$this->set('manageFolders', $this->ManageFolder->find('list', array('fields' => array('name'))));

		$_user_id = $this->_admin_data['id'];


		$_table_data = $this->ManageFolder->find(
				"all", array(
			"conditions" => array(
				'ManageFolder.user_id' => $_user_id
			),
			"order" => array("ManageFolder.id")
				)
		);

		$_table_data['user_id'] = $this->Session->read('Auth.User.id');
		$this->set("table_data", $_table_data);
	}

	public function admin_add() {
		$this->Client = new Client();
		if ($this->request->is('Post')) {
			$_data_to_save = $this->request->data;
			$_data_to_save['ManageFolder']['user_id'] = $this->_admin_data['id'];
			if($this->ManageFolder->save($_data_to_save)) {
				$this->redirect(array('action' => 'manage'));
			}
		}
		//	3$users = $this->Upload->User->find('list');

		$this->set(compact('users'));
		$this->set('user', $this->Client->find('list', array('fields' => array('name'))));
	}

	public function admin_activate($id = null) {
		//echo $id;
		$status = 1;

		$this->ManageFolder->id = $id;
		$this->ManageFolder->saveField('Status', $status);


		$this->Session->setFlash('Folder deleted', "success");
		$this->redirect(array('action' => 'manage'));

		$this->Session->setFlash('Folder was not deleted', "error");
		$this->redirect(array('action' => 'manage'));
	}

	public function admin_deactivate($id = null) {
		/* if (!$this->request->is('post')) {
		  throw new MethodNotAllowedException();
		  } */
		//$data = $this->request->data;
		//	pr($data); die;
		/* $this->ManageFolder->id = $id;
		  if (!$this->ManageFolder->exists()) {
		  throw new NotFoundException(__('Invalid upload'));
		  } */
		$status = 2;
		$this->ManageFolder->id = $id;
		$this->ManageFolder->saveField('Status', $status);
		if ($this->ManageFolder->saveField('Status', $status)) {
			$this->Session->setFlash('Folder deleted', "success");
			$this->redirect(array('action' => 'manage'));
		}
		$this->Session->setFlash('Folder was not deleted', "error");
		$this->redirect(array('action' => 'manage'));
	}

	public function search() {
		error_reporting('0');
		$this->layout = '';
		if ($this->RequestHandler->isAjax()) {
			pr($_POST);die;
			if ($_POST['search_by'] == 'fileno') {
				$this->Staff->recursive = 0;
				$this->paginate = array('conditions' => array('filename LIKE' => '%' . $_POST['value'] . '%'));
				$this->set('uploads', $this->paginate());
				$this->set('users', $this->User->find('list', array('fields' => array('username'))));
			}
		}
	}

}
