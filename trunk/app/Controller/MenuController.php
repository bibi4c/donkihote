<?php

class MenuController extends AppController {

    var $uses = array('User');
    public $layout = null;
    public $helpers = array(
        'Html', 'Form',
        'Session',
    );

    public function beforeFilter() {
        parent::beforeFilter();
        $aryUser = $this->Session->read('Auth.User');
        $this->Cookie->delete('searchForm');
        $this->Cookie->delete('userRegister');
        $this->Cookie->delete('storeRegister');
        $this->Cookie->delete('store_searchForm');
        $this->Cookie->delete('user_searchForm');
        $this->Cookie->delete('auditRegister');
        $this->Cookie->delete('calendar_searchForm');
        $this->Cookie->delete('audit_searchForm');
        $this->Cookie->delete('audit_id');
        $this->Cookie->delete('dataCategory');
        $this->Cookie->delete('arr_document_id');
        $this->Cookie->delete('data_export');
        $this->Cookie->delete('conditions_search');
        $this->Cookie->delete('documentRegister');

        if (!empty($aryUser)) {
            $this->layout = 'menu';
        }
    }

    public function index() {
        $this->layout = 'menu';
    }

}

?>
