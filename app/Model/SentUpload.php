<?php

App::uses('AppModel', 'Model');

/**
 * Upload Model
 *
 * @property User $User
 */
class SentUpload extends AppModel {
	public $belongsTo = array(
	'User' => array(
	'className' => 'User',
	'foreignKey' => 'receive_to',
	'conditions' => '',
	'fields' => '',
	'order' => ''
	),
	
	'Uploads' => array(
	'className' => 'Uploads',
	'foreignKey' => 'upload_id',
	'conditions' => '',
	'fields' => '',
	'order' => ''
		)
	);


	public $hasOne = array(
	'InboxUpload' => array(
	'className' => 'InboxUpload',
	'foreignKey' => 'sent_from',
	'conditions' => '',
	'fields' => '',
	'order' => ''
	)
	);
}
