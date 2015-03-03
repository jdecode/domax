<?php

App::uses('AppController', 'Controller');
App::uses('Department', 'Model');

/**
 * Staffs Controller
 *
 * @property Staff $Staff
 */
class StaffsController extends AppController {

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

		$this->Staff->recursive = 0;

		$con = array(1 => 1);


		if (!empty($this->request->query["staff_name"])) {
			$con["Staff.name LIKE"] = "%" . $this->request->query["staff_name"] . "%";
		}
		if (!empty($this->request->query["father_name"])) {
			$con["Staff.father_name LIKE"] = "%" . $this->request->query["father_name"] . "%";
		}
		if (!empty($this->request->query["dept"])) {
			$con["Staff.department_id"] = $this->request->query["dept"];
		}

		if (!empty($this->request->query)) {
			$this->request->data["Staff"] = $this->request->query;
		}

		$this->paginate["conditions"] = $con;

		$this->Paginator->settings = $this->paginate;

		$this->set('staffs', $this->paginate());
		$this->Department = new Department();
		$dept = $this->Department->find('list', array('fields' => array('name')));
		$dept_list = $this->Department->find('list', array('fields' => array('id', 'name')));
		$this->set('depart', $dept);
		$this->set('dept_list', $dept_list);
	}

	/**
	 * view method
	 *
	 * @param string $id
	 * @return void
	 */
	public function admin_view($id = null) {

		$this->Staff->id = $id;
		if (!$this->Staff->exists()) {
			throw new NotFoundException(__('Invalid staff'));
		}
		$this->set('staff', $this->Staff->read(null, $id));
		$this->set('depart', $this->Department->find('list', array('fields' => array('name'))));
	}

	/**
	 * add method
	 *
	 * @return void
	 */
	public function admin_add() {

		$this->Department = new Department();
		if ($this->request->is('post')) {
			$this->Staff->create();
			//pr($this->request->data);die;
			if ($this->Staff->saveAll($this->request->data)) {
				//die("here");
				$this->Session->setFlash('The staff has been saved', "success");
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash('The staff could not be saved. Please, try again.', 'error');
			}
		}
		$users = $this->Staff->User->find('list');
		$this->set(compact('users'));
		$dept = $this->Department->find('list', array('fields' => array('id', 'name')));

		$this->set('select', $dept);
	}

	/**
	 * edit method
	 *
	 * @param string $id
	 * @return void
	 */
	public function admin_edit($id = null) {

		$this->Staff->id = $id;
		if (!$this->Staff->exists()) {
			throw new NotFoundException(__('Invalid staff'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {

			if ($this->Staff->save($this->request->data)) {
				$this->Session->setFlash('The staff has been saved', "success");
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash('The staff could not be saved. Please, try again.', "error");
			}
		} else {
			$this->request->data = $this->Staff->read(null, $id);
		}
		$users = $this->Staff->User->find('list');
		$this->set(compact('users'));
		$this->set('select', $this->Department->find('list', array('fields' => array('name'))));
	}

	/**
	 * delete method
	 *
	 * @param string $id
	 * @return void
	 */
	public function admin_delete($id = null) {
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$this->Staff->id = $id;
		if (!$this->Staff->exists()) {
			throw new NotFoundException(__('Invalid staff'));
		}
		if ($this->Staff->delete()) {
			$this->Session->setFlash('Staff deleted', "success");
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Staff was not deleted', "error"));
		$this->redirect(array('action' => 'index'));
	}

	public function search() {
		error_reporting('0');
		$this->layout = '';
		if ($this->RequestHandler->isAjax()) {
			if ($_POST['search_by'] == 'staff_name') {
				$this->Staff->recursive = 0;
				$this->paginate = array('conditions' => array('name LIKE' => '%' . $_POST['value'] . '% '));
				$this->set('staffs', $this->paginate());
			}
		}
	}

}
