<?php

/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       Cake.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
App::uses('Controller', 'Controller');
App::uses('ManageFolder', 'Model');
App::uses('User', 'Model');
App::uses('Message', 'Model');

/**
 * This is a placeholder class.
 * Create the same file in app/Controller/AppController.php
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package       Cake.Controller
 * @link http://book.cakephp.org/view/957/The-App-Controller
 */
App::uses('Folder', 'Utility');
App::uses('File', 'Utility');

class AppController extends Controller {

	public $paginate = array(
		'limit' => 10,
	);
	var $helpers = array('Html', 'Form', 'Session', 'Js', 'Time');
	var $components = array('RequestHandler', 'Session', 'Cookie', 'Paginator'
	);
	//var $uses = array('User', 'Client', 'Upload', 'Department');
	var $_user_data = array();
	var $_client_data = array();
	var $_admin_data = array();

	/**
	 * beforeRender method
	 */
	function beforeRender() {
		$_user_data = $this->Session->read('user.User');
		$this->set('_user_data', $_user_data);

		$_client_data = $this->Session->read('client.User');

		$this->set('_client_data', $_client_data);

		$_admin_data = $this->Session->read('admin.User');
		$this->set('_admin_data', $_admin_data);

		if ($_admin_data['group_id'] == 1) {
			$this->set('_is_admin', 1);
		} else {
			$this->set('_is_admin', 0);
		}

		if ($_admin_data) {
			$_current_login_user = $_admin_data;
		} else if ($_client_data) {
			$_current_login_user = $_client_data;
		} else {
			$_current_login_user = $_user_data;
		}
		//pr($this->Session->read('user.User'))die('hello');
		/**
		 * Load Folders
		 */
		$this->Message = new Message();
		$_Inbox = $this->Message->find('count', array('conditions' => array('AND' => array('user2id' => $_current_login_user['id']), array('Message.status' => 0))));
		$_Sent = $this->Message->find('count', array('conditions' => array('AND' => array('user_id' => $_current_login_user['id']), array('Message.status' => 0))));
		$_Draft = $this->Message->find('count', array('conditions' => array('AND' => array('user_id' => $_current_login_user['id']), array('user2id' => 0), array('Message.status' => 4))));
		$this->ManageFolder = new ManageFolder();
		$_folders = $this->ManageFolder->find(
				'all', array(
			'conditions' => array(
				'ManageFolder.status' => 1,
				'ManageFolder.user_id ' => 1  // $this->_admin_data['id']
			)
				)
		);
		$__folders = array();
		$_folder = array();
		$i = 0;
		foreach ($_folders as $_f) {
			$_f_data = $this->Message->find(
					'count', array(
				'conditions' => array(
					'Message.user_id' => $_current_login_user['id'],
					'Message.status' => 0,
					'Message.folder_id' => $_f['ManageFolder']['id'],
				)
					)
			);
			$__folders[$i] = $_f;
			$__folders[$i]['ManageFolder']['count'] = $_f_data;
			$i++;
		}
		$this->set('_folderf', $_folder);
		$this->set('_folders', $__folders);
		$this->set('_Inbox', $_Inbox);
		$this->set('_Sent', $_Sent);
		$this->set('_Draft', $_Draft);
	}

	/**
	 * beforeFilter method
	 */
	function beforeFilter() {
		$_user_data = $this->Session->read('user.User');
		$this->_user_data = $_user_data;

		$_client_data = $this->Session->read('client.User');

		$this->_client_data = $_client_data;

		$_admin_data = $this->Session->read('admin.User');
		$this->_admin_data = $_admin_data;
		$this->_paginatorURL();
	}

	/**
	 * _admin_auth_check method
	 * 
	 * @return true, if logged in as admin, false otherwise
	 */
	function _admin_auth_check() {
		$_user = $this->Session->read('admin.User');
		//pr($_user); die('admin');	
		if (isset($_user['id']) && is_numeric($_user['id']) && $_user['group_id'] == ADMIN_GROUP_ID) { // Admin group_id is 1
			$this->layout = 'admin_dashboard';
			return true;
		} else {
			$this->layout = 'admin_login';
			return false;
		}
	}

	/**
	 * _user_auth_check method
	 *
	 * @return true, if logged in as admin, false otherwise
	 */
	function _user_auth_check() {
		//	pr($this->Session->read('user.User')); die('Session');
		$_user = $this->Session->read('user.User');
		if (
				isset($_user['id']) &&
				is_numeric($_user['id']) &&
				( $_user['group_id'] == STAFF_GROUP_ID)	//
		) {
			$this->layout = 'dashboard';
			return true;
		} else {
			$this->layout = 'login';
			return false;
		}
	}

	/**
	 * _client_auth_check method
	 *
	 * @return true, if logged in as client, false otherwise
	 */
	function _client_auth_check() {

		$_user = $this->Session->read('client.User');

		if (
				isset($_user['id']) &&
				is_numeric($_user['id']) &&
				( $_user['group_id'] == CLIENT_GROUP_ID )
		) {
			$this->layout = 'client_dashboard';
			return true;
		} else {
			$this->layout = 'client_login';
			return false;
		}
	}

	function _deny_url() {
		$action = $this->params->params['action'];
		// If method requires login then redirect to login page[if logged out] with referer URL, and to dashboard otherwise
		if (!empty($this->_deny['admin'])) {
			if (in_array($action, $this->_deny['admin'])) {
				if (!$this->_admin_auth_check()) {
					$this->Session->write('admin_redirect', "/" . $this->params->url);
					$this->redirect('/admin');
				}
			}
		}
		// If method requires login then redirect to login page[if logged out] with referer URL, and to homepage otherwise
		if (!empty($this->_deny['user'])) {
			if (in_array($action, $this->_deny['user'])) {
				if (!$this->_user_auth_check()) {
					//$this->Session->write('redirect', "/".$this->params->url);
					$this->redirect('/login');
				}
			}
		}
		// If method requires login then redirect to login page[if logged out] with referer URL, and to homepage otherwise
		if (!empty($this->_deny['client'])) {
			if (in_array($action, $this->_deny['client'])) {
				if (!$this->_client_auth_check()) {
					//$this->Session->write('redirect', "/".$this->params->url);
					$this->redirect('/client');
				}
			}
		}
	}

	public function _isArrayReadyToUse($array = array()) {
		if (isset($array) && is_array($array) && count($array)) {
			return true;
		}
		return false;
	}

	function _paginatorURL() {
		$passed = "";
		$retain = $this->params['url'];
		unset($retain['url']);
		$this->set('paginatorURL', array($passed, '?' => http_build_query($retain)));
	}

	function _login_user_name() {
		$_user_id = $this->_admin_data['id'];
		$_user_info = $this->User->find(
				'all', array(
			'conditions' => array(
				'User.id' => $_user_id
			)
				)
		);
		$this->set('_user_info', $_user_info);
	}

}
