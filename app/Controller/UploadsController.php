<?php

App::uses('AppController', 'Controller');
App::uses('User', 'Model');
App::uses('Client', 'Model');
App::uses('Document', 'Model');
App::uses('Message', 'Model');
App::uses('ManageFolder', 'Model');

/**
 * Uploads Controller
 *
 * @property Upload $Upload
 */
class UploadsController extends AppController {

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

		$this->Upload->recursive = 0;

		$con = array(1 => 1);


		if (isset($_SESSION['Auth']['User']['group_id']) && $_SESSION['Auth']['User']['group_id'] == 2) {
			$con["Upload.upload_by"] = $_SESSION['Auth']['User']['id'];
		}

		if (!empty($this->request->query["client"])) {
			$con["User.username LIKE"] = "%" . $this->request->query["client"] . "%";
		}
		if (!empty($this->request->query["file_name"])) {
			$con["Staff.filename LIKE"] = "%" . $this->request->query["file_name"] . "%";
		}

		if (!empty($this->request->query)) {
			$this->request->data["Upload"] = $this->request->query;
		}

		$this->paginate["conditions"] = $con;
		$this->Paginator->settings = $this->paginate;
		$this->set('uploads', $this->paginate());
		$this->User = new User();
		$this->set('users', $this->User->find('list', array('fields' => array('username'))));
	}

	/**
	 * view method
	 *
	 * @param string $id
	 * @return void
	 */
	public function admin_view($id = null) {

		$this->Upload->id = $id;
		if (!$this->Upload->exists()) {
			throw new NotFoundException(__('Invalid upload'));
		}
		$this->set('upload', $this->Upload->read(null, $id));
		$uploadby = $this->User->find('list', array('fields' => array('username')));
		$this->set('uploadby', $uploadby);
	}

	/**
	 * add method
	 *
	 * @return void
	 */
	public function admin_add($folder_id = 0) {
		if ($this->request->is('post')) {
			//pr($this->request->data); die;
			if ($this->request->data['Upload']['filename']['error'] == '0') {
				$tmp_name = $this->request->data['Upload']['filename']['tmp_name'];

				$_ext = explode('.', $this->request->data['Upload']['filename']['name']);
				$ext = $_ext[count($_ext) - 1];
				$file_name = sha1(time() . microtime() . rand()) . '.' . $ext;

				$movable = false;
				$destination = WWW_ROOT . 'files/uploads/';
				if (!is_dir($destination)) {
					if (!mkdir($destination)) {
						$this->Session->setFlash('Could not create appropriate folder', "Error");
					}
				}
				if (is_writable($destination)) {
					$movable = true;
				} else {
					$this->Session->setFlash('Destination directory not writable', "Error");
				}
				if ($movable) {
					if (move_uploaded_file($tmp_name, $destination . $file_name)) {
						$this->Document = new Document();
						$document = array('Document' => array());
						$document['Document']['name'] = $this->request->data['Upload']['filename']['name'];
						$document['Document']['filename'] = $file_name;
						if ($this->Document->save($document)) {
							$_insert_id = $this->Document->getLastInsertID();

							$message = array(
								'Message' => array(
									'status' => 0,
									'document_id' => $_insert_id,
									'folder_id' => $folder_id,
									'message' => $this->request->data['Upload']['description'],
									'user_id' => $this->_admin_data['id'],
								)
							);
							$this->Message = new Message();
							if (isset($this->request->data['Upload']['filetouser']) && is_array($this->request->data['Upload']['filetouser']) && count($this->request->data['Upload']['filetouser'])) {
								foreach ($this->request->data['Upload']['filetouser'] as $filetouser) {
									$this->Message->create();
									$message['Message']['user2id'] = $filetouser;
									$this->Message->save($message);
								}
							} else {
								$message['Message']['status'] = 4;
								$this->Message->save($message);
							}
						} else {
							$this->Session->setFlash('File could not be saved. Please try again');
						}
					} else {
						$this->Session->setFlash('File could not be uploaded. Please try again');
					}
				} else {
					$this->Session->setFlash('Could not upload file due to folder permissions.');
				}
				$this->redirect(array('action' => 'inbox'));
			} else {
				$this->Session->setFlash('Please make sure required options are selected');
			}
			die;
		}
		$this->set('_folder_id', $folder_id);
	}

	/**
	 * edit method
	 *
	 * @param string $id
	 * @return void
	 */
	public function admin_edit($id = null) {

		$this->Upload->id = $id;
		if (!$this->Upload->exists()) {
			throw new NotFoundException(__('Invalid upload'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->request->data['Upload']['filename']['error'] != '4') {
				$destination = WWW_ROOT . 'files/uploads/' . $this->request->data['Upload']['filetouser'] . '/';
				if (!is_dir($destination)) {
					mkdir($destination);
				}
				move_uploaded_file($this->request->data['Upload']['filename']['tmp_name'], $destination . $this->request->data['Upload']['filename']['name']);
				$this->request->data['Upload']['filename'] = $this->request->data['Upload']['filename']['name'];
			} else {
				$file = $this->Upload->find('first', array('conditions' => array('Upload.id' => $this->Upload->id)));

				$this->request->data['Upload']['filename'] = $file['Upload']['filename'];
			}
			$this->request->data['Upload']['user_id'] = $this->request->data['Upload']['filetouser'];
			if ($this->Upload->save($this->request->data)) {
				$this->Session->setFlash('The upload has been saved', "success");
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash('The upload could not be saved. Please, try again.', "error");
			}
		} else {
			$this->request->data = $this->Upload->read(null, $id);
		}
		$users = $this->Upload->User->find('list');

		$this->set(compact('users'));

		$users1 = $this->Upload->find('first', array('conditions' => array('Upload.id' => $id)));
		$option = array();
		if ($users1['Upload']['filetouser'] == '1') {
			$option = $this->Client->find('list', array('fields' => array('name')));
		} else if ($users1['Upload']['filetouser'] == '2') {
			$option = $this->Client->find('list', array('fields' => array('fileno')));
		} else if ($users1['Upload']['filetouser'] == '3') {
			$option = $this->Client->find('list', array('fields' => array('pancard')));
		} else if ($users1['Upload']['filetouser'] == '4') {
			$option = $this->Client->find('list', array('fields' => array('bussiness_name')));
		}

		$this->set('option', $option);
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
		$this->Upload->id = $id;
		if (!$this->Upload->exists()) {
			throw new NotFoundException(__('Invalid upload'));
		}
		if ($this->Upload->delete()) {
			$this->Session->setFlash('Upload deleted', "success");
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash('Upload was not deleted', "error");
		$this->redirect(array('action' => 'index'));
	}

	public function admin_ajax() {
		if ($this->RequestHandler->isAjax()) {
			$this->Client = new Client();
			if ($_POST['action_id'] == '1') {
				$this->set('option', $this->Client->find('list', array('fields' => array('user_id', 'name'))));
			} else if ($_POST['action_id'] == '2') {
				$this->set('option2', $this->Client->find('list', array('fields' => array('user_id', 'fileno'))));
			} else if ($_POST['action_id'] == '3') {
				$this->set('option3', $this->Client->find('list', array('fields' => array('user_id', 'pancard'))));
			} else if ($_POST['action_id'] == '4') {
				$this->set('option4', $this->Client->find('list', array('fields' => array('user_id', 'bussiness_name'))));
			} else {
				$this->loadModel('Staff');
				$this->set('option5', $this->Staff->find('list', array('fields' => array('user_id', 'name'))));
			}
		}
	}

	public function search() {
		error_reporting('0');
		$this->layout = '';
		if ($this->RequestHandler->isAjax()) {
			if ($_POST['search_by'] == 'fileno') {
				$this->Staff->recursive = 0;
				$this->paginate = array('conditions' => array('filename LIKE' => '%' . $_POST['value'] . '%'));
				$this->set('uploads', $this->paginate());
				$this->set('users', $this->User->find('list', array('fields' => array('username'))));
			}
		}
	}

	public function admin_delete1($id = null) {
		if ($this->request->is('post')) {
			//$count = count($this->request->data['Upload']['id']);
			$arr = $this->request->data['Upload']['id'];
			foreach ($arr as $arrs) :
				$this->Upload->query('delete from uploads where id="' . $arrs . '"');
				//echo $arrs;

			endforeach;
			$this->Session->setFlash(__('Upload deleted'));
			$this->redirect(array('action' => 'index'));
			$this->Session->setFlash(__('Upload was not deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Upload->id = $id;
		if (!$this->Upload->exists()) {
			throw new NotFoundException(__('Invalid upload'));
		}
	}

	public function admin_draft2($label = null) {


		if ($label == null && $label == '') {
			$label = 0;
		}
		$_current_login_user = $this->Session->read('Auth.User.id');
		$_draft_data = $this->Upload->find(
				"all", array(
			"conditions" => array("Upload.upload_by" => $_current_login_user, 'filetouser' => NULL, "label_id" => $label),
			"order" => array("Upload.id")
				)
		);
		$this->Paginator->settings = $this->paginate;
		$this->set('uploads', $this->paginate());
		$this->set('users', $this->User->find('list', array('fields' => array('username'))));
		$this->set("draft_data", $_draft_data);
	}

	public function admin_sent2() {

		$this->loadModel('SentUpload');
		$_current_login_user = $this->Session->read('Auth.User.id');
		$_sent_data = $this->SentUpload->find(
				"all", array(
			"conditions" => array("SentUpload.sent_from" => $_current_login_user, 'SentUpload.status !=' => 3),
			"order" => array("SentUpload.id")
				)
		);
		$this->Paginator->settings = $this->paginate;
		$this->set('uploads', $this->paginate());
		$this->set('users', $this->User->find('list', array('fields' => array('username'))));
		$this->set("sent_data", $_sent_data);
	}

	public function admin_inbox() {
		$this->_admin_list(0);
	}

	public function admin_sent() {
		$this->_admin_list(5);
	}

	public function admin_draft() {
		$this->_admin_list(4);
	}

	public function admin_folder($id) {
		$this->_admin_list($id, true);
	}

	public function _admin_list($status = 0, $folder = false) {
		$this->User = new User();
		$this->Message = new Message();
		$_current_login_user = $this->_admin_data['id'];
		$_label = '';
		if (!$folder) {
			switch ($status) {
				case 0:
					$this->set('uploads', $this->paginate('Message', array("Message.user2id" => $_current_login_user, 'Message.status' => 0)));
					$_messages = $this->Message->find(
							"all", array(
						"conditions" => array("Message.user2id" => $_current_login_user, 'Message.status' => 0),
						"order" => array("Message.id DESC")
							)
					);
					$_label = 'Inbox';
					break;
				case 4:
					$this->set('uploads', $this->paginate('Message', array("Message.user_id" => $_current_login_user, 'Message.status' => 4)));
					$_messages = $this->Message->find(
							"all", array(
						"conditions" => array("Message.user_id" => $_current_login_user, 'Message.status' => 4),
						"order" => array("Message.id DESC")
							)
					);
					$_label = 'Drafts';
					break;
				case 5:
					$this->set('uploads', $this->paginate('Message', array("Message.user_id" => $_current_login_user, 'Message.status' => 0)));
					$_messages = $this->Message->find(
							"all", array(
						"conditions" => array("Message.user_id" => $_current_login_user, 'Message.status' => 0),
						"order" => array("Message.id DESC")
							)
					);
					$_label = 'Sent';
					break;
				default :
					$this->set('uploads', $this->paginate('Message', array("Message.user_id" => $_current_login_user, 'Message.status' => 0)));
					$_messages = $this->Message->find(
							"all", array(
						"conditions" => array("Message.user_id" => $_current_login_user, 'Message.status' => 0),
						"order" => array("Message.id DESC")
							)
					);
					$_label = 'Inbox';
					break;
			}
			$this->set('folder_id', 0);
		} else {
			$this->set(
					'uploads',
					$this->paginate(
							'Message',
							array(
								"Message.user_id" => $_current_login_user,
								'Message.status' => 0,
								'Message.folder_id' => $status
							)
					)
			);
			$_messages = $this->Message->find(
					"all", array(
				"conditions" => array("Message.user_id" => $_current_login_user, 'Message.status' => 0, 'Message.folder_id' => $status),
				"order" => array("Message.id DESC")
					)
			);
			$this->ManageFolder = new ManageFolder();
			$folder = $this->ManageFolder->read(null, $status);
			$_label = ucwords(strtolower($folder['ManageFolder']['Name']));
			$this->set('folder_id', $status);
		}
		$this->Paginator->settings = $this->paginate;
		$this->set('users', $this->User->find('list', array('fields' => array('username'))));
		$this->set("messages", $_messages);
		$this->set("_label", $_label);
	}

}
