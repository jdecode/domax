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
				'admin_folder',
			),
			'user' => array(
				'dashboard',
				'add',
				'inbox',
				'sent',
				'draft',
				'folder',
				'view',
				'logout',
			),
			'client' => array(
				'client_dashboard',
				'client_add',
				'client_inbox',
				'client_sent',
				'client_draft',
				'client_folder',
				'client_logout',
			),
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

	public function index() {

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
		//echo $id; die;
		$this->loadModel('Message');
		$this->Message->id = $id;
		if (!$this->Message->exists()) {
			throw new NotFoundException(__('Invalid upload'));
		}
		$this->set('message', $this->Message->read(null, $id));
		//$uploadby = $this->User->find('list', array('fields' => array('username')));
		//$this->set('uploadby', $uploadby);
	}

	public function view($id = null) {
		//echo $id;
		$this->loadModel('Message');
		$this->Message->id = $id;
		if (!$this->Message->exists()) {
			throw new NotFoundException(__('Invalid upload'));
		}
		$this->set('message', $this->Message->read(null, $id));
		//$uploadby = $this->User->find('list', array('fields' => array('username')));
		//$this->set('uploadby', $uploadby);
	}

	/**
	 * admin_add method
	 *
	 * @return void
	 */
	public function admin_add($folder_id = 0) {
		if ($this->request->is('post')) {
			//pr($this->request->data); die;
			foreach ($this->request->data['Upload']['filename'] as $filename) {
				if ($filename['error'] == '0') {
					$tmp_name = $filename['tmp_name'];

					$_ext = explode('.', $filename['name']);
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
							$document['Document']['name'] = $filename['name'];
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
								//pr($document);die;

								$this->Message = new Message();
								foreach ($this->request->data['Upload']['folder_id'] as $folder_id) {
									//pr($folder_id);
									if (isset($this->request->data['Upload']['filetouser']) && is_array($this->request->data['Upload']['filetouser']) && count($this->request->data['Upload']['filetouser'])) {

										foreach ($this->request->data['Upload']['filetouser'] as $filetouser) {

											$this->Message->create();
											$message['Message']['user2id'] = $filetouser;
											$message['Message']['folder_id'] = $folder_id;
											//pr($message);
											$this->Message->save($message);
										}
									} else {
										$message['Message']['status'] = 4;
										$message['Message']['folder_id'] = $folder_id;
										//pr($message);
										$this->Message->save($message);
									}
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
				} else {
					$this->Session->setFlash('Please make sure required options are selected');
				}
			} $this->redirect(array('action' => 'inbox'));

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
		echo $id;
		die;
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
			$this->loadModel('ManageFolder');
			$this->ManageFolder = new ManageFolder();
			$_folders = $this->ManageFolder->find(
					'all', array(
				'conditions' => array(
					'ManageFolder.status' => 1,
					'ManageFolder.user_id ' => 1  // $this->_admin_data['id']
				)
					)
			);

			$this->set('_folders', $_folders);


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

	public function ajax() {
		//pr($_POST['action_id']);die;
		if ($this->RequestHandler->isAjax()) {
			$this->loadModel('ManageFolder');
			$this->ManageFolder = new ManageFolder();
			$_folders = $this->ManageFolder->find(
					'all', array(
				'conditions' => array(
					'ManageFolder.status' => 1,
					'ManageFolder.user_id ' => 1  // $this->_admin_data['id']
				)
					)
			);

			$this->set('_folders', $_folders);

			$this->Client = new Client();
			//pr($_POST);die;

			if ($_POST['action_id'] == '1') {
				$this->set('option', $this->Client->find('list', array('fields' => array('user_id', 'name'))));
			} else if ($_POST['action_id'] == '2') {
				$this->set('option2', $this->Client->find('list', array('fields' => array('user_id', 'fileno'))));
			} else if ($_POST['action_id'] == '3') {
				$this->set('option3', $this->Client->find('list', array('fields' => array('user_id', 'pancard'))));
			} else if ($_POST['action_id'] == '4') {
				$this->set('option4', $this->Client->find('list', array('fields' => array('user_id', 'bussiness_name'))));
			} else if ($_POST['action_id'] == '6') {

				$this->loadModel('User');
				$option6 = $this->User->find('list', array('fields' => array('User.id', 'username'), 'conditions' => array('group_id' => 1), "recursive" => -1));
				//pr($option6);die;
				$this->set('option6', $option6);
			} else if($_POST['action_id']== '5') {
				$this->loadModel('Staff');
				$this->set('option5', $this->Staff->find('list', array('fields' => array('user_id', 'name'))));
			}else{
				$this->Session->setFlash('Inappropriate Selection');
			}
		}
	}

	public function client_ajax() {
		if ($this->RequestHandler->isAjax()) {
			$this->loadModel('ManageFolder');
			$this->ManageFolder = new ManageFolder();
			$_folders = $this->ManageFolder->find(
					'all', array(
				'conditions' => array(
					'ManageFolder.status' => 1,
					'ManageFolder.user_id ' => 1  // $this->_admin_data['id']
				)
					)
			);

			$this->set('_folders', $_folders);

			$this->Client = new Client();


			if ($_POST['action_id'] == '1') {
				$this->set('option', $this->Client->find('list', array('fields' => array('user_id', 'name'))));
			} else if ($_POST['action_id'] == '2') {
				$this->set('option2', $this->Client->find('list', array('fields' => array('user_id', 'fileno'))));
			} else if ($_POST['action_id'] == '3') {
				$this->set('option3', $this->Client->find('list', array('fields' => array('user_id', 'pancard'))));
			} else if ($_POST['action_id'] == '4') {
				$this->set('option4', $this->Client->find('list', array('fields' => array('user_id', 'bussiness_name'))));
			} else if ($_POST['action_id'] == '6') {

				$this->loadModel('User');
				$option6 = $this->User->find('list', array('fields' => array('User.id', 'username'), 'conditions' => array('group_id' => 1), "recursive" => -1));
				//pr($option6);die;
				$this->set('option6', $option6);
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

	public function delete_inbox($id = null) {
		$this->loadModel('Message');

		$data = $this->Message->find('all', array('conditions' => array('Message.id' => $id), 'recursive' => -1)
		);
		//pr($data);die;
		if ($data['0']['Message']['status'] != '2') {

			if ($data['0']['Message']['status'] != '1') {
				$status = 2;
				$this->Message->id = $id;
				//pr($data['0']['InboxUpload']);die;
				$this->Message->saveField('status', $status);
				if ($this->Message->saveField('status', $status)) {
					$this->Session->setFlash('Upload deleted', "success");
					$this->redirect(array('action' => 'inbox'));
				}
			} else {
				$status = 3;
				$this->Message->id = $id;
				//pr($data['0']['InboxUpload']['status']);die;
				$this->Message->saveField('status', $status);
				if ($this->Message->saveField('status', $status)) {
					$this->Session->setFlash('Upload deleted', "success");
					$this->redirect(array('action' => 'inbox'));
				}
				//echo "hello"; die;
			}
		} else {

			$this->Session->setFlash('Upload was not deleted', "error");
			$this->redirect(array('action' => 'index'));
		}
	}

	public function delete_sent($id = null) {
		$this->loadModel('Message');
		//echo $id;die;
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}


		$data = $this->Message->find('all', array('conditions' => array('Message.id' => $id), 'recursive' => -1)
		);
		//pr($data);die;
		//pr($data['0']['InboxUpload']['status']);die;
		if ($data['0']['Message']['status'] != '1') {

			if ($data['0']['Message']['status'] != '2') {
				$status = 1;
				$this->Message->id = $id;
				//	pr($data['0']['Message']);die;
				$this->Message->saveField('status', $status);
				if ($this->Message->saveField('status', $status)) {
					$this->Session->setFlash('Upload deleted', "success");
					$this->redirect(array('action' => 'sent'));
				}
			} else {
				$status = 3;
				$this->Message->id = $id;
				//pr($data['0']['InboxUpload']['status']);die;
				$this->Message->saveField('status', $status);
				if ($this->Message->saveField('status', $status)) {
					$this->Session->setFlash('Upload deleted', "success");
					$this->redirect(array('action' => 'sent'));
				}
				//echo "hello"; die;
			}
		} else {
			$this->Session->setFlash('Upload was not deleted', "error");
			$this->redirect(array('action' => 'index', 'admin' => true));
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

	public function admin_inbox($id = 0) {
		$this->_admin_list(0, false, true, $id);
	}

	public function admin_sent($id = 0) {
		$this->_admin_list(5, false, true, $id);
	}

	public function admin_draft($id = 0) {
		$this->_admin_list(4, false, true, $id);
	}

	public function admin_folder($id) {
		$this->_admin_list(0, true, true, $id);
	}

	public function _admin_list($status = 0, $folder = false, $admin = 1, $folder_id) {
		$this->User = new User();
		$this->Message = new Message();

		
		if ($admin) {
			$_current_login_user = $this->_admin_data['id'];
		} else {
			$_current_login_user = $this->_user_data['id'];
		}

		$_label = '';
		if (!$folder) {
			switch ($status) {
				case 0:
					$this->set('uploads', $this->paginate('Message', array("Message.user2id" => $_current_login_user, 'Message.status' => 0)));
//					$_messages = $this->Message->find(
//						"all", array(
//						"conditions" => array("Message.user2id" => $_current_login_user, 'Message.status' => 0),
//						"order" => array("Message.id DESC")
//							)
//					);
					$this->paginate['conditions'] =array("Message.user2id" => $_current_login_user, 'Message.status' => 0);
					$_label = 'Inbox';
					break;
				case 4:
					$this->set('uploads', $this->paginate('Message', array("Message.user_id" => $_current_login_user, 'Message.status' => 4)));
//					$_messages = $this->Message->find(
//							"all", array(
//						"conditions" => array("Message.user_id" => $_current_login_user, 'Message.status' => 4),
//						"order" => array("Message.id DESC")
//							)
//					);
					$this->paginate['conditions'] = array("Message.user_id" => $_current_login_user, 'Message.status' => 4);
					$_label = 'Drafts';
					break;
				case 5:
					$this->set('uploads', $this->paginate('Message', array("Message.user_id" => $_current_login_user, 'Message.status' => 0)));
					$this->paginate['conditions'] = array("Message.user_id" => $_current_login_user, 'Message.user2id !=' => 0, 'Message.status' => 0);
					
					$_label = 'Sent';
					break;
				default :
					$this->set('uploads', $this->paginate('Message', array("Message.user_id" => $_current_login_user, 'Message.status' => 0)));
//					$_messages = $this->Message->find(
//							"all", array(
//						"conditions" => array("Message.user_id" => $_current_login_user, 'Message.status' => 0),
//						"order" => array("Message.id DESC")
//							)
//					);
					$this->paginate['conditions'] = array("Message.user_id" => $_current_login_user, 'Message.status' => 0);
					
					
					//pr($_messages);die;
					$_label = 'Inbox';
					break;
			}

			$this->set('folder_id', 0);
		} else {

			$this->set(
					'uploads', $this->paginate(
							'Message', array(
						"Message.user_id" => $_current_login_user,
						'Message.status' => $status,
						'Message.folder_id' => $folder_id
							)
					)
			);
			//$_messages=$this->Message->findByUserIdOrUser2id($_current_login_user);
//			$_messages = $this->Message->find(
//					"all", array(
//				"conditions" => array('OR' => array('AND' => array('Message.user_id' => $_current_login_user, 'user2id' => 0),
//						array('Message.user2id' => $_current_login_user)
//					),
//					'Message.status' => $status, 'Message.folder_id' => $folder_id),
//				"order" => array("Message.id DESC")
//					)
//			);

			$this->paginate['conditions'] =array('OR' => array('AND' => array('Message.user_id' => $_current_login_user, 'user2id' => 0),
						array('Message.user2id' => $_current_login_user)
					),
					'Message.status' => $status, 'Message.folder_id' => $folder_id);
			$this->ManageFolder = new ManageFolder();
			$folder = $this->ManageFolder->read(null, $folder_id);
			$_label = ucwords(strtolower($folder['ManageFolder']['Name']));
			//$this->set('_messages',$_messages);
			$this->set('folder_id', $folder_id);
		}

		$this->set('users', $this->User->find('list', array('fields' => array('username'))));
		//pr($this->paginate);
		//pr($this->paginate);
		$this->Paginator->settings = $this->paginate;
		$_messages = $this->paginate('Message');
		//pr($_messages);
		$this->set("messages", $_messages);
		$this->set("_label", $_label);
	}
	public function _client_list($status = 0, $folder = false, $admin = 1, $folder_id){
		$this->User = new User();
		$this->Message = new Message();

		
		
			$_current_login_user = $this->_client_data['id'];
				

		$_label = '';
		if (!$folder) {
			switch ($status) {
				case 0:
					$this->set('uploads', $this->paginate('Message', array("Message.user2id" => $_current_login_user, 'Message.status' => 0)));
//					$_messages = $this->Message->find(
//						"all", array(
//						"conditions" => array("Message.user2id" => $_current_login_user, 'Message.status' => 0),
//						"order" => array("Message.id DESC")
//							)
//					);
					$this->paginate['conditions'] =array("Message.user2id" => $_current_login_user, 'Message.status' => 0);
					$_label = 'Inbox';
					break;
				case 4:
					$this->set('uploads', $this->paginate('Message', array("Message.user_id" => $_current_login_user, 'Message.status' => 4)));
//					$_messages = $this->Message->find(
//							"all", array(
//						"conditions" => array("Message.user_id" => $_current_login_user, 'Message.status' => 4),
//						"order" => array("Message.id DESC")
//							)
//					);
					$this->paginate['conditions'] = array("Message.user_id" => $_current_login_user, 'Message.status' => 4);
					$_label = 'Drafts';
					break;
				case 5:
					$this->set('uploads', $this->paginate('Message', array("Message.user_id" => $_current_login_user, 'Message.status' => 0)));
					$this->paginate['conditions'] = array("Message.user_id" => $_current_login_user, 'Message.user2id !=' => 0, 'Message.status' => 0);
					
					$_label = 'Sent';
					break;
				default :
					$this->set('uploads', $this->paginate('Message', array("Message.user_id" => $_current_login_user, 'Message.status' => 0)));
//					$_messages = $this->Message->find(
//							"all", array(
//						"conditions" => array("Message.user_id" => $_current_login_user, 'Message.status' => 0),
//						"order" => array("Message.id DESC")
//							)
//					);
					$this->paginate['conditions'] = array("Message.user_id" => $_current_login_user, 'Message.status' => 0);
					
					
					//pr($_messages);die;
					$_label = 'Inbox';
					break;
			}

			$this->set('folder_id', 0);
		} else {

			$this->set(
					'uploads', $this->paginate(
							'Message', array(
						"Message.user_id" => $_current_login_user,
						'Message.status' => $status,
						'Message.folder_id' => $folder_id
							)
					)
			);
			//$_messages=$this->Message->findByUserIdOrUser2id($_current_login_user);
//			$_messages = $this->Message->find(
//					"all", array(
//				"conditions" => array('OR' => array('AND' => array('Message.user_id' => $_current_login_user, 'user2id' => 0),
//						array('Message.user2id' => $_current_login_user)
//					),
//					'Message.status' => $status, 'Message.folder_id' => $folder_id),
//				"order" => array("Message.id DESC")
//					)
//			);

			$this->paginate['conditions'] =array('OR' => array('AND' => array('Message.user_id' => $_current_login_user, 'user2id' => 0),
						array('Message.user2id' => $_current_login_user)
					),
					'Message.status' => $status, 'Message.folder_id' => $folder_id);
			$this->ManageFolder = new ManageFolder();
			$folder = $this->ManageFolder->read(null, $folder_id);
			$_label = ucwords(strtolower($folder['ManageFolder']['Name']));
			//$this->set('_messages',$_messages);
			$this->set('folder_id', $folder_id);
		}

		$this->set('users', $this->User->find('list', array('fields' => array('username'))));
		//pr($this->paginate);
		//pr($this->paginate);
		$this->Paginator->settings = $this->paginate;
		$_messages = $this->paginate('Message');
		//pr($_messages);
		$this->set("messages", $_messages);
		$this->set("_label", $_label);
		
	}
	public function _client_list1($status = 0, $folder = false, $admin = 1) {
		$this->User = new User();
		$this->Message = new Message();
		if ($admin) {
			$_current_login_user = $this->_admin_data['id'];
		} else {
			$_current_login_user = $this->_client_data['id'];
		}
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
					'uploads', $this->paginate(
							'Message', array(
						"Message.user2id" => $_current_login_user,
						'Message.status' => 0,
						'Message.folder_id' => $status
							)
					)
			);
			$_messages = $this->Message->find(
					"all", array(
				"conditions" => array("Message.user2id" => $_current_login_user, 'Message.status' => 0, 'Message.folder_id' => $status),
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

	function inbox() {
		$this->_admin_list(0, 0, 0, NULL);
	}

	public function sent() {
		$this->_admin_list(5, 0, 0, NULL);
	}

	public function draft() {
		$this->_admin_list(4, 0, 0, NULL);
	}

	public function folder($id) {
		//echo $id;die;
		$this->_admin_list(0, true, false, $id);
	}

	function client_inbox() {
		$this->_client_list(0, 0, 0,NULL);
	}

	public function client_sent() {
		$this->_client_list(5, 0, 0,NULL);
	}

	public function client_draft() {
		$this->_client_list(4, 0, 0,NULL);
	}

	public function client_folder($id) {
		$this->_client_list(0, true,false,$id);
	}

	/**
	 * add method
	 *
	 * @return void
	 */
	public function add($folder_id = 0) {
		if ($this->request->is('post')) {
			//	pr($this->request->data);
			//	die;
			foreach ($this->request->data['Upload']['filename'] as $filename) {
				if ($filename['error'] == '0') {
					$tmp_name = $filename['tmp_name'];

					$_ext = explode('.', $filename['name']);
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
							$document['Document']['name'] = $filename['name'];
							//	$document['Document']['title'] = $this->request->data['Upload']['title'];
							$document['Document']['filename'] = $file_name;
							//pr($document);die;
							if ($this->Document->save($document)) {
								$_insert_id = $this->Document->getLastInsertID();

								$message = array(
									'Message' => array(
										'status' => 0,
										'document_id' => $_insert_id,
										'folder_id' => $folder_id,
										'message' => $this->request->data['Upload']['description'],
										'user_id' => $this->_user_data['id'],
									)
								);
								//pr($this->request->data['Upload']['folder_id']);die;
								$this->Message = new Message();
								$this->Message->create();
								foreach ($this->request->data['Upload']['folder_id'] as $folder_id) {
									if ($this->request->data['Upload']['checkbox'] == 1 && $folder_id == 0) {
										$message['Message']['user2id'] = 0;
										$message['Message']['status'] = 4;
										pr($message);
										$this->Message->save($message);
									} else if ($this->request->data['Upload']['checkbox'] == 1 && $folder_id != 0) {

										$message['Message']['user2id'] = 0;
										//$message['Message']['status'] = $this->request->data['Upload']['folder_id'];
										$message['Message']['folder_id'] = $folder_id;
										//pr($message);
										$this->Message->save($message);
									} else {
										$message['Message']['user2id'] = 1;
										$message['Message']['folder_id'] = $folder_id;
										//pr($message);
										$this->Message->save($message);
									}
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
				} else {
					$this->Session->setFlash('Please make sure required options are selected');
				}
			}
			if ($folder_id) {
				$this->redirect('/uploads/folder/' . $folder_id);
			} else {
				$this->redirect(array('action' => 'inbox'));
			}
		}
		$this->set('_folder_id', $folder_id);
	}

	/**
	 * client_add method
	 *
	 * @return void
	 */
	public function client_add($folder_id =0){
		if ($this->request->is('post')) {
			//	pr($this->request->data);
			//die;
			foreach ($this->request->data['Upload']['filename'] as $filename) {
				if ($filename['error'] == '0') {
					$tmp_name = $filename['tmp_name'];

					$_ext = explode('.', $filename['name']);
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
							$document['Document']['name'] = $filename['name'];
							//	$document['Document']['title'] = $this->request->data['Upload']['title'];
							$document['Document']['filename'] = $file_name;
						//	pr($document);die('done in document table');
							if ($this->Document->save($document)) {
								$_insert_id = $this->Document->getLastInsertID();

								$message = array(
									'Message' => array(
										'status' => 0,
										'document_id' => $_insert_id,
										'folder_id' => $folder_id,
										'message' => $this->request->data['Upload']['description'],
										'user_id' => $this->_client_data['id'],
									)
								);
								pr($message);
								//echo $folder_id;
								//pr($this->request->data['Upload']);
								//die;
								$this->Message = new Message();
								$this->Message->create();
								foreach ($this->request->data['Upload']['folder_id'] as $folder_id) {
									if ($this->request->data['Upload']['checkbox'] == 1 && $folder_id == 0) {
										$message['Message']['user2id'] = 0;
										$message['Message']['status'] = 4;
										pr($message);
										$this->Message->save($message);
									} else if ($this->request->data['Upload']['checkbox'] == 1 && $folder_id != 0) {

										$message['Message']['user2id'] = 0;
										//$message['Message']['status'] = $this->request->data['Upload']['folder_id'];
										$message['Message']['folder_id'] = $folder_id;
										//pr($message);
										$this->Message->save($message);
									} else {
										$message['Message']['user2id'] = 1;
										$message['Message']['folder_id'] = $folder_id;
										//pr($message);die;
										$this->Message->save($message);
										
									}
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
				} else {
					$this->Session->setFlash('Please make sure required options are selected');
				}
			}
			if ($folder_id) {
				$this->redirect('/uploads/folder/' . $folder_id);
			} else {
				$this->redirect(array('action' => 'inbox'));
			}
		}
		$this->set('_folder_id', $folder_id);
	}
	public function client_add1($folder_id = 0) {
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
						$document['Document']['title'] = $this->request->data['Upload']['title'];
						$document['Document']['filename'] = $file_name;
						if ($this->Document->save($document)) {
							$_insert_id = $this->Document->getLastInsertID();

							$message = array(
								'Message' => array(
									'status' => 0,
									'document_id' => $_insert_id,
									'folder_id' => $folder_id,
									'message' => $this->request->data['Upload']['description'],
									'user_id' => $this->_client_data['id'],
								)
							);
							$this->Message = new Message();
							//if (isset($this->request->data['Upload']['filetouser']) && is_array($this->request->data['Upload']['filetouser']) && count($this->request->data['Upload']['filetouser'])) {
							foreach ($this->request->data['Upload']['filetouser'] as $filetouser) {
								$this->Message->create();
								$message['Message']['user2id'] = 1;
								$this->Message->save($message);
							}
							//} else {
							//$message['Message']['status'] = 4;
							//$this->Message->save($message);
							//}
						} else {
							$this->Session->setFlash('File could not be saved. Please try again');
						}
					} else {
						$this->Session->setFlash('File could not be uploaded. Please try again');
					}
				} else {
					$this->Session->setFlash('Could not upload file due to folder permissions.');
				}
				if ($folder_id) {
					$this->redirect('/client/uploads/folder/' . $folder_id);
				} else {
					$this->redirect(array('action' => 'inbox', 'client' => true));
				}
			} else {
				$this->Session->setFlash('Please make sure required options are selected');
			}
			die;
		}
		$this->set('_folder_id', $folder_id);
	}

}
