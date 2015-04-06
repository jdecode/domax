<?php

App::uses('AppController', 'Controller');

class DepartmentsController extends AppController {

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

	public function admin_index() {

		//$this->Upload->recursive = 0;
		$this->set('departments', $this->paginate());
	}

	public function admin_add() {

		if ($this->request->is('post')) {
			if ($this->Department->saveAll($this->request->data)) {
				$this->Session->setFlash('Department has been saved', 'success');
				$this->redirect(array('controller' => 'departments', 'action' => 'admin_index'));
			}
		}
	}

	public function admin_edit($id = null) {

		$this->Department->id = $id;
		if (!$this->Department->exists()) {
			throw new NotFoundException(__('Invalid upload'));
		}if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Department->save($this->request->data)) {
				$this->Session->setFlash('The upload has been saved', 'success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash('The upload could not be saved. Please, try again.', 'error');
			}
		} else {
			$this->request->data = $this->Department->read(null, $id);
		}
	}

	public function admin_delete($id = null) {

		$this->Department->id = $id;
		if (!$this->Department->exists()) {
			throw new NotFoundException(__('Invalid Department'));
		}
		if ($this->Department->delete()) {
			$this->Session->setFlash('Department deleted', 'success');
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash('Department was not deleted', 'error');
		$this->redirect(array('action' => 'index'));
	}

}

?>
