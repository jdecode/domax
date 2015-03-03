<?php

class PagesController extends AppController {

    public $name = 'Pages';

    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('display');
    }

    public function display() {

        $this->layout = 'home';
    }

}

?>
   