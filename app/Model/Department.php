<?php

App::uses('AppModel', 'Model');

/**
 * Client Model
 *
 * @property User $User
 */
class Department extends AppModel {
    public $validate = array(
        'name' => array(
        
        'rule' => array('notEmpty'),

     )
    );    
}

?>
