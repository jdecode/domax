<?php
App::uses('AppModel', 'Model');
/**
 * Upload Model
 *
 * @property User $User
 */
class Upload extends AppModel {
/**
 * Validation rules
 *
 * @var array
 */
	//public $validate = array(
		/*'user_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),*/
	//	'filename' => array(
//
  //                          'rule' => array('extension', array('zip')),
    //                        'message' => 'Please Upload only zip file.'

		//),
		/*'upload_by' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),*/
	//);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);	
	
	
	public $hasOne = array(
		'InboxUpload' => array(
			'className' => 'InboxUpload',
			'foreignKey' => 'upload_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'SentUpload' => array(
			'className' => 'SentUpload',
			'foreignKey' => 'upload_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
	);	
}
