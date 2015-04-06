<?php

App::uses('AppController', 'Controller');

/**
 * Clients Controller
 *
 * @property Client $Client
 */
class ClientsController extends AppController {

	/**
	 * beforeFilter method
	 */
	function beforeFilter() {
		parent::beforeFilter();
		/**
		 * Stores array of deniable methods, without logging in.
		 */
		$this->_deny = array(
			'admin' => array(
				'admin_inbox',
				'admin_sent',
				'admin_draft',
				'admin_view',
				'admin_add',
				'admin_delete',
				'admin_ajax',
				'admin_delete1',
			),
			'user' => array(
				'dashboard',
				'logout',
			)
		);
		$this->_deny_url($this->_deny);
	}

	/**
	 * index method
	 *
	 * @return void
	 */
	public function admin_index() {


		if (isset($_SESSION['Auth']['User']['group_id']) && $_SESSION['Auth']['User']['group_id'] != 1) {
			$this->redirect(array("controller" => "uploads", "action" => "index"));
		}

		$this->Client->recursive = 0;
		//	$this->Paginator->settings = $this->paginate;

		$con = array(1 => 1);


		if (!empty($this->request->query["client_name"])) {
			$con["Client.name LIKE"] = "%" . $this->request->query["client_name"] . "%";
		}
		if (!empty($this->request->query["file_no"])) {
			$con["Client.fileno LIKE"] = "%" . $this->request->query["file_no"] . "%";
		}
		if (!empty($this->request->query["pancard"])) {
			$con["Client.pancard LIKE"] = "%" . $this->request->query["pancard"] . "%";
		}
		if (!empty($this->request->query["bussiness_name"])) {
			$con["Client.bussiness_name LIKE"] = "%" . $this->request->query["bussiness_name"] . "%";
		}

		if (!empty($this->request->query)) {
			$this->request->data["client"] = $this->request->query;
		}

		$this->paginate["conditions"] = $con;

		$this->Paginator->settings = $this->paginate;
		$this->set('clients', $this->paginate());
	}

	/**
	 * view method
	 *
	 * @param string $id
	 * @return void
	 */
	public function admin_view($id = null) {

		$this->Client->id = $id;
		if (!$this->Client->exists()) {
			throw new NotFoundException(__('Invalid client'));
		}
		$this->set('client', $this->Client->read(null, $id));
	}

	/**
	 * add method
	 *
	 * @return void
	 */
	public function admin_add() {

		if ($this->request->is('post')) {
			$this->Client->create();

			if ($this->Client->saveAll($this->request->data)) {
				$this->Session->setFlash('The client has been saved', "success");
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash('The client could not be saved. Please, try again.', "error");
			}
		}
		$users = $this->Client->User->find('list');
		$this->set(compact('users'));
	}

	/**
	 * edit method
	 *
	 * @param string $id
	 * @return void
	 */
	public function admin_edit($id = null) {

		$this->Client->id = $id;
		if (!$this->Client->exists()) {
			throw new NotFoundException(__('Invalid client'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Client->save($this->request->data)) {
				$this->Session->setFlash('The client has been saved', "success");
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash('The client could not be saved. Please, try again.', "error");
			}
		} else {
			$this->request->data = $this->Client->read(null, $id);
		}
		$users = $this->Client->User->find('list');
		$this->set(compact('users'));
	}

	/**
	 * delete method
	 *
	 * @param string $id
	 * @return void
	 */
	public function admin_delete($id = null) {
		if (!$this->request->is('get')) {
			throw new MethodNotAllowedException();
		}
		$this->Client->id = $id;
		if (!$this->Client->exists()) {
			throw new NotFoundException(__('Invalid client'));
		}
		if ($this->Client->delete()) {
			$this->Session->setFlash('Client deleted', "success");
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash('Client was not deleted', "error");
		$this->redirect(array('action' => 'index'));
	}

	public function search() {
		error_reporting('0');
		$this->layout = '';
		if ($this->RequestHandler->isAjax()) {
			if ($_POST['search_by'] == 'client_name') {
				$this->Client->recursive = 0;
				$this->paginate = array('conditions' => array('name LIKE' => '%' . $_POST['value'] . '%'));
				$this->set('clients', $this->paginate());
			} else if ($_POST['search_by'] == 'panno') {
				$this->Client->recursive = 0;
				$this->paginate = array('conditions' => array('pancard LIKE' => '%' . $_POST['value'] . '%'));
				$this->set('clients', $this->paginate());
			} else if ($_POST['search_by'] == 'fileno') {
				$this->Client->recursive = 0;
				$this->paginate = array('conditions' => array('fileno LIKE' => '%' . $_POST['value'] . '%'));
				$this->set('clients', $this->paginate());
			} else if ($_POST['search_by'] == 'bussiness') {
				$this->Client->recursive = 0;
				$this->paginate = array('conditions' => array('bussiness_name LIKE' => '%' . $_POST['value'] . '%'));
				$this->set('clients', $this->paginate());
			}
		}
	}

}
