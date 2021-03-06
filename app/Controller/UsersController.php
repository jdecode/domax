<?php

App::uses('AppController', 'Controller');

/**
 * Users Controller
 *
 * @property User $User
 */
class UsersController extends AppController {

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
				'admin_dashboard',
				'admin_logout',
				'admin_index',
				'admin_view',
				'admin_add',
				'admin_delete',
				'admin_userlist',
				'admin_changepassword',
				'admin_reset_password',
				'admin_login_status',
			),
			'user' => array(
				'dashboard',
				'changepassword',
				'logout',
			),
			'client' => array(
				'client_dashboard',
				'client_changepassword',
				'client_logout',
			),
		);
                //pr($this->request->data); die;
                //pr($this->params); die;
		$this->_deny_url($this->_deny);
	}

	/**
	 * index method
	 *
	 * @return void
	 */
	public $components = array('Paginator');

	public function admin_index() {
		$this->User->recursive = 0;
		$this->set('users', $this->paginate());
	}

	function _load_view($id) {
		//$this->layout = 'admin';
		$this->loadModel('Message');
		$this->User->id = $id;
		if (!$this->User->exists()) {
			throw new NotFoundException(__('Invalid user'));
		}else{
		$this->set('user', $this->User->read(null, $id));
		$this->set('document', $this->Message->find('all', array('conditions' => array('Message.user2id' => $id))));
		//$this->loadModel('Upload');
		//$this->set('upload', $this->Upload->find('all', array('conditions' => array('user_id' => $this->User->id))));
		}
	}
	/**
	 * view method
	 *
	 * @param string $id
	 * @return void
	 */
	public function admin_view($id = null) {
		$this->_load_view($id);
	}
	
		/**
	 * view method
	 *
	 * @param string $id
	 * @return void
	 */
	public function view($id = null) {
		$this->_load_view($id);
	}


	/**
	 * add method
	 *
	 * @return void
	 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->User->create();
			if ($this->User->save($this->request->data)) {
				$this->Session->setFlash(__('The user has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash('The user could not be saved. Please, try again.', 'success');
			}
		}
		$groups = $this->User->Group->find('list');
		$this->set(compact('groups'));
	}

	/**
	 * Admin user's dashboard
	 */
	function admin_dashboard() {
		$this->layout = 'admin_dashboard';
		if ($this->request->is('post')) {
			//pr($this->request->data);
			$user = array('User' => array('active' => 1));
			$user['User']['first_name'] = $this->request->data['User']['first_name'];
			$user['User']['last_name'] = $this->request->data['User']['last_name'];
			$user['User']['email'] = $this->request->data['User']['email'];
			$user['User']['password'] = sha1($this->request->data['User']['password']);
			if ($this->User->save($user)) {
				$this->Session->setFlash('User has been saved');
				$this->redirect('/admin/dashboard');
			} else {
				$this->Session->setFlash('User could not be saved');
			}
		}
		$this->User->recursive = 0;
		$users = $this->Paginator->paginate('User', array('User.group_id' => 2));
		$this->set('users', $users);
	}

	/**
	 * edit method
	 *
	 * @param string $id
	 * @return void
	 */
	public function admin_edit($id = null) {
		$this->User->id = $id;
		if (!$this->User->exists()) {
			throw new NotFoundException(__('Invalid user'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->User->save($this->request->data)) {
				$this->Session->setFlash('The user has been saved', 'success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash('The user could not be saved. Please, try again.', 'error');
			}
		} else {
			$this->request->data = $this->User->read(null, $id);
		}
		$groups = $this->User->Group->find('list');
		$this->set(compact('groups'));
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
		$this->User->id = $id;
		if (!$this->User->exists()) {
			throw new NotFoundException(__('Invalid user'));
		}
		if ($this->User->delete()) {
			$this->Session->setFlash('User deleted', 'success');
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash('User was not deleted', 'error');
		$this->redirect(array('action' => 'index'));
	}

	public function index() {
		$this->layout = 'home';
		$this->recursive = '0';
		$this->set('file', $this->Upload->find('all', array('conditions' => array('Upload.user_id' => $this->Auth->user('id')))));
	}

	public function dashboard() {
		$this->layout = 'dashboard';
		$this->recursive = '0';
		$this->redirect('/uploads/inbox');
		//$this->set('file', $this->Upload->find('all', array('conditions' => array('Upload.user_id' => $this->Auth->user('id')))));
	}

	public function client_dashboard() {
		$this->layout = 'client_dashboard';
		$this->recursive = '0';
		$this->redirect('/client/uploads/inbox');
		//$this->set('file', $this->Upload->find('all', array('conditions' => array('Upload.user_id' => $this->Auth->user('id')))));
	}

	public function admin_userlist() {
		$this->layout = '';
		$this->set('user', $this->User->find('list', array('fields' => array('username'), 'conditions' => array('group_id' => $_POST['g_id']))));
	}

	function login() {
		$this->set('title_for_layout', 'Login');
		//die('user_login');
		if ($this->_user_auth_check()) {
			$this->redirect('/dashboard');
		}
		if ($this->request->is('post')) {
			$user = $this->User->find(
					'first', array(
				'conditions' => array(
					'User.username' => $this->request->data['User']['username'],
					'User.status' => 1,
					'User.group_id  ' => STAFF_GROUP_ID
				),
				'recursive' => -1
					)
			);
			if ($user) {
				if ($user['User']['password'] == sha1($this->request->data['User']['password'])) {
					$this->Session->write('user', $user);
					$this->Session->setFlash('You are now logged in', 'flash_close', array('class' => 'alert-success'));
					$this->redirect('/dashboard');

					$_redirect = @$this->Session->read('redirect');
					if (trim($_redirect) != '') {
						$this->Session->setFlash('Welcome back!', 'flash_close', array('class' => 'alert alert-success'));
						$this->Session->delete('redirect');
						$this->redirect("$_redirect");
					} else {
						$this->Session->setFlash('You are now logged in', 'flash_close', array('class' => 'alert alert-success'));
						$this->redirect('/dashboard');
					}
				} else {
					$this->check_login_retries();
					$this->Session->setFlash('Incorrect password. Please try again', 'flash_close', array('class' => 'alert alert-error'));
				}
			} else {
				$this->Session->setFlash('User not found, or is inactive', 'flash_close', array('class' => 'alert alert-error'));
			}
		}
	}

	function client_login() {
		$this->layout = 'client_login';
	//	$this->set('title_for_layout', 'Client Login');
		//die('client login');
		//pr($this->request->data); die;
		if ($this->_client_auth_check()) {
			//die('jndkj');
			$this->redirect('/client/dashboard');
		}
		
		if ($this->request->is('post')) {
			//pr($this->request->data); die;
			$user = $this->User->find(
					'first', array(
				'conditions' => array(
					'User.username' => $this->request->data['User']['username'],
					'User.status' => 1,
					'User.group_id' => CLIENT_GROUP_ID
				),
				'recursive' => -1
					)
			);
			//pr($user);die;
			if ($user) {
				//echo "hello";die;
				if ($user['User']['password'] == sha1($this->request->data['User']['password'])) {
					$this->Session->write('client', $user);
					$this->Session->setFlash('You are now logged in', 'flash_close', array('class' => 'alert-success'));
					$this->redirect('/client/dashboard');

					$_redirect = @$this->Session->read('redirect');
					if (trim($_redirect) != '') {
						$this->Session->setFlash('Welcome back!', 'flash_close', array('class' => 'alert alert-success'));
						$this->Session->delete('redirect');
						$this->redirect("$_redirect");
					} else {
						$this->Session->setFlash('You are now logged in', 'flash_close', array('class' => 'alert alert-success'));
						$this->redirect('/client/dashboard');
					}
				} else {
					$this->check_login_retries();
					$this->Session->setFlash('Incorrect password. Please try again', 'flash_close', array('class' => 'alert alert-error'));
				}
			} else {
				$this->Session->setFlash('User not found, or is inactive', 'flash_close', array('class' => 'alert alert-error'));
			}
		}
	}

	function check_login_retries() {
		
	}


	function admin_login() {
		$this->layout = 'admin_login';
		$this->set('title_for_layout', 'Admin Login');
		//die('admin_login');
		if ($this->_admin_auth_check()) {
			$this->redirect('/admin/dashboard');
		}
		if ($this->request->is('post')) {
			$user = $this->User->find(
					'first', array(
				'conditions' => array(
					'User.username' => $this->request->data['User']['username'],
					'User.status' => 1,
					'User.group_id' => ADMIN_GROUP_ID // Admin user
				),
				'recursive' => -1
					)
			);
			if ($user) {
				if ($user['User']['password'] == sha1($this->request->data['User']['password'])) {
					$this->Session->write('admin', $user);
					$this->Session->setFlash('You are now logged in', 'flash_close', array('class' => 'alert-success'));
					$this->redirect('/admin/dashboard');

					$_redirect = @$this->Session->read('redirect');
					if (trim($_redirect) != '') {
						$this->Session->setFlash('Welcome back!', 'flash_close', array('class' => 'alert alert-success'));
						$this->Session->delete('redirect');
						$this->redirect("$_redirect");
					} else {
						$this->Session->setFlash('You are now logged in', 'flash_close', array('class' => 'alert alert-success'));
						$this->redirect('/admin/dashboard');
					}
				} else {
					$this->Session->setFlash('We didn\'t recognize the password you entered. Please try again', 'flash_close', array('class' => 'alert alert-error'));
				}
			} else {
				$this->Session->setFlash('We didn\'t recognize the Username you entered. Please try again', 'flash_close', array('class' => 'alert alert-error'));
			}
		}
	}

	/**
	 * logout method
	 *
	 * @return void
	 */
	public function logout() {
		$this->Session->delete('user');
		$this->Session->setFlash('You are now logged out.', 'flash_close', array('class' => 'alert alert-success'));
		$this->redirect('/login');
	}

	/**
	 * admin logout method
	 *
	 * @return void
	 */
	public function admin_logout() {
		$this->Session->delete('admin');
		$this->Session->setFlash('You are now logged out.', 'flash_close', array('class' => 'alert alert-success'));
		$this->redirect('/login');
	}

	/**
	 * client logout method
	 *
	 * @return void
	 */
	public function client_logout() {
		$this->Session->delete('client');
		$this->Session->setFlash('You are now logged out.', 'flash_close', array('class' => 'alert alert-success'));
		$this->redirect('/login');
	}

	public function admin_changepassword() {
		if ($this->request->is('post') || $this->request->is('put')) {
			$this->User->id = $this->_admin_data['id'];
			$this->User->recursive = -1;
			$password = $this->User->find('first', array('conditions' => array('User.id' => $this->User->id)));
			//debug($password);
			if (empty($this->request->data['User']['old_password'])) {
				$this->Session->setFlash("Please Enter your Old Password", 'error');
				$this->redirect(array('controller' => 'Users', 'action' => 'changepassword'));
			} else if (empty($this->request->data['User']['new_password'])) {
				$this->Session->setFlash("Please Enter your New Password");
				$this->redirect(array('controller' => 'Users', 'action' => 'changepassword'));
			} else if (sha1($this->request->data['User']['old_password']) != $password['User']['password']) {
				//debug(AuthComponent::password($this->request->data['User']['old_password'])); exit;
				$this->Session->setFlash("Your old password did not matched.", 'error');
				$this->redirect(array('controller' => 'Users', 'action' => 'changepassword'));
			} else if ($this->request->data['User']['new_password'] != $this->request->data['User']['new_password']) {
				$this->Session->setFlash("Confirmed Password mismatch.", 'error');
				$this->redirect(array('controller' => 'Users', 'action' => 'changepassword'));
			} else {
				$this->request->data['User']['password'] = $this->request->data['User']['new_password'];
				$this->User->save($this->request->data);
				$this->Session->setFlash("Password Changed successfully.", 'success');
				$this->redirect(array('controller' => 'Users', 'action' => 'client'));
			}
		}
	}


	public function client_changepassword() {
		if ($this->request->is('post') || $this->request->is('put')) {
			$this->User->id = $this->_client_data['id'];
			$this->User->recursive = -1;
			$password = $this->User->find('first', array('conditions' => array('User.id' => $this->User->id)));
			//debug($password);
			if (empty($this->request->data['User']['old_password'])) {
				$this->Session->setFlash("Please Enter your Old Password", 'error');
				$this->redirect(array('controller' => 'Users', 'action' => 'changepassword'));
			} else if (empty($this->request->data['User']['new_password'])) {
				$this->Session->setFlash("Please Enter your New Password");
				$this->redirect(array('controller' => 'Users', 'action' => 'changepassword'));
			} else if (sha1($this->request->data['User']['old_password']) != $password['User']['password']) {
				//debug(AuthComponent::password($this->request->data['User']['old_password'])); exit;
				$this->Session->setFlash("Your old password did not matched.", 'error');
				$this->redirect(array('controller' => 'Users', 'action' => 'changepassword'));
			} else if ($this->request->data['User']['new_password'] != $this->request->data['User']['new_password']) {
				$this->Session->setFlash("Confirmed Password mismatch.", 'error');
				$this->redirect(array('controller' => 'Users', 'action' => 'changepassword'));
			} else {
				$this->request->data['User']['password'] = $this->request->data['User']['new_password'];
				$this->User->save($this->request->data);
				$this->Session->setFlash("Password Changed successfully.", 'success');
				$this->redirect(array('controller' => 'Users', 'action' => 'client'));
			}
		}
	}

	public function admin_reset_password() {
		if ($this->request->is('post')) {
			$this->request->data['User']['id'] = $this->request->data['User']['user_id'];
			$this->User->save($this->request->data);
			$this->Session->setFlash('Password has been changes', "success");
			// $this->redirect('controller');
		}
	}

	public function changepassword() {
		if ($this->request->is('post') || $this->request->is('put')) {
			$this->User->id = $this->_user_data['id'];
			$this->User->recursive = -1;
			$password = $this->User->find('first', array('conditions' => array('User.id' => $this->User->id)));
			//debug($password);
			if (empty($this->request->data['User']['old_password'])) {
				$this->Session->setFlash("Please Enter your Old Password");
				$this->redirect(array('controller' => 'Users', 'action' => 'changepassword'));
			} else if (empty($this->request->data['User']['new_password'])) {
				$this->Session->setFlash("Please Enter your New Password");
				$this->redirect(array('controller' => 'Users', 'action' => 'changepassword'));
			} else if (sha1($this->request->data['User']['old_password']) != $password['User']['password']) {
				//debug(AuthComponent::password($this->request->data['User']['old_password'])); exit;
				$this->Session->setFlash("Your old password did not matched.");
				$this->redirect(array('controller' => 'Users', 'action' => 'changepassword'));
			} else if ($this->request->data['User']['new_password'] != $this->request->data['User']['conf_password']) {
				$this->Session->setFlash("Confirm Password mismatch.");
				$this->redirect(array('controller' => 'Users', 'action' => 'changepassword'));
			} else {
				$password['User']['password'] = $this->request->data['User']['new_password'];
				$this->User->save($password);
				$this->Session->setFlash("Password Changed successfully.");
				$this->redirect('/');
			}
		}
	}

	public function admin_login_status($id = null) {
		if ($id == '1') {
			//debug($this->params);
			$this->User->query("UPDATE users set status='0' where id='" . $this->params['named']['pass'] . "'");
			$this->redirect(array('controller' => 'clients', 'action' => 'index'));
		} else {
			$this->User->query("UPDATE users set status='1' where id='" . $this->params['named']['pass'] . "'");
			$this->redirect(array('controller' => 'clients', 'action' => 'index'));
		}
	}

}
