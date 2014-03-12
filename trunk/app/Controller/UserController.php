<?php

class UserController extends AppController {

    var $uses = array('User', 'Authority');
    public $layout = null;
    public $components = array('RequestHandler', 'Cookie');
    public $helpers = array(
        'Html', 'Form',
        'Session', 'Paginator', 'Js',
    );
    var $paginate = array();

    public function beforeFilter() {
        parent::beforeFilter();
        $aryUser = $this->Session->read('Auth.User');
        $this->Cookie->delete('searchForm');
        $this->Cookie->delete('storeRegister');
        $this->Cookie->delete('store_searchForm');
        $this->Cookie->delete('calendar_searchForm');
        if (!empty($aryUser)) {
            $this->layout = 'user';
        }
    }

    public function search() {
        $this->layout = 'user';
        $page_tittle = "ユーザ一覧";
        $this->set("page_tittle", $page_tittle);
        if ($this->request->is('post')) {
            $data = $this->request->data;
            $this->Cookie->write("user_searchForm", $data);
        }
        return $this->redirect(array('action' => 'index'));
    }

    public function index() {
        $this->layout = 'user';

        $condition = array();
        $search = $this->Cookie->read('user_searchForm');

        $start_f = 0;
        $err_mmmm = 0;
        if (isset($search)) {
            if ($search['searchForm']['担当者名'] != '') {
                $name = $search['searchForm']['担当者名'];
                $condition += array('User.user_name LIKE' => "%$name%");
            }
            if ($search['searchForm']['権限'] != '0') {
                $authority = $search['searchForm']['権限'];
                $condition += array('User.authority_id' => $authority);
            }
            if ($search['searchForm']['有効／無効'] != '2') {
                $effective = $search['searchForm']['有効／無効'];
                $condition += array('User.valid_flag' => $effective);
            }
        } else {
            $search['searchForm']['担当者名'] = '';
            $search['searchForm']['権限'] = '0';
            $search['searchForm']['有効／無効'] = '2';
            $start_f = 1;
        }

        $this->paginate = array(
            'limit' => '10',
            'conditions' => $condition,
            'order' => array(
                'user_id' => 'asc'
            )
        );
        $this->set('search', $search);
        $data_authority = $this->Authority->find('all');
        $this->set('authoritys', $data_authority);

        $data_users = $this->User->find('all', array('conditions' => $condition));
        $this->set('data_all_user', $data_users);

        $data = $this->paginate('User');
        $this->set('users', $data);

        if (count($data) == 0 && $start_f == 0)
            $this->set('e_message', "検索結果はありません。再検索してください。<br>");
        if (count($data_users) == 0 || $start_f == 1)
            $this->set('paging_show', '1');
        $page_tittle = "ユーザ一覧";
        $this->set("page_tittle", $page_tittle);
    }

    public function register() {
        $this->layout = 'user';
        $someone = array();
        $someone['User']['user_id'] = "";
        $someone['User']['user_name'] = "";
        $someone['User']['password'] = "";
        $someone['User']['authority_id'] = "1";
        $someone['User']['valid_flag'] = "1";
        $someone['User']['mail_address'] = "";
        if ($this->request->is('post')) {
            $data = $this->request->data;
            $this->User->set($data);
            $this->Cookie->write("userRegister", $data);
            if ($data['User']['権限'] != '2')
                unset($this->User->validate['mail_address']['notempty']);
            if ($data['User']['権限'] != '2' && strlen($data['User']['mail_address']) < 1)
                unset($this->User->validate['mail_address']);
            if ($this->User->validates()) {
                return $this->redirect(array('action' => 'register_confirm'));
            }
        }
        $aryUserRegister = $this->Cookie->read('userRegister');
        if (isset($aryUserRegister)) {
            $someone['User']['user_id'] = $aryUserRegister['User']['user_id'];
            $someone['User']['user_name'] = $aryUserRegister['User']['user_name'];
            $someone['User']['password'] = $aryUserRegister['User']['password'];
            $someone['User']['authority_id'] = $aryUserRegister['User']['権限'];
            $someone['User']['valid_flag'] = $aryUserRegister['User']['有効／無効'];
            $someone['User']['mail_address'] = $aryUserRegister['User']['mail_address'];
            $this->Cookie->delete('userRegister');
        }
        $data_authority = $this->Authority->find('all');
        $this->set('authoritys', $data_authority);
        $this->set("user_info", $someone['User']);
        $page_tittle = "ユーザー登録";
        $this->set("page_tittle", $page_tittle);
    }

    public function register_confirm() {
        $this->layout = 'user';
        $page_tittle = "ユーザー入力確認";
        $this->set("page_tittle", $page_tittle);

        $aryUserRegister = $this->Cookie->read('userRegister');
        if (isset($aryUserRegister)) {
            //debug($aryUserRegister);
            if ($aryUserRegister['User']['有効／無効'] == 1) {
                $this->set('valid', '有効');
            } else {
                $this->set('valid', '無効');
            }
            $this->set('user_data', $aryUserRegister);
            $data_authority = $this->Authority->find('all', array('conditions' => array('Authority.idauthority_id' => $aryUserRegister['User']['権限'])));
            $this->set('authority', $data_authority);
        } else {
            return $this->redirect(array('action' => 'register'));
        }
    }

    public function success_register() {
        $this->layout = 'user';
        if ($this->request->is('post')) {
            $this->Cookie->delete('userRegister');
            $data = $this->request->data;
            $aryUser = $this->Session->read('Auth.User');
            $temp = array();
            $temp['User']['user_id'] = $data['User_confirm']['user_id'];
            $temp['User']['user_name'] = $data['User_confirm']['user_name'];
            $temp['User']['authority_id'] = $data['User_confirm']['authority_id'];
            $temp['User']['valid_flag'] = $data['User_confirm']['valid_flag'];
            $temp['User']['register_user'] = $aryUser['user_id'];
            $temp['User']['mail_address'] = $data['User_confirm']['mail_address'];
            $temp['User']['password'] = $this->Auth->password($data['User_confirm']['password']);
            $temp['User']['register_datetime'] = date('Y-m-d H:i:s');
            if (!$this->User->save($temp, false))
                die();
            $page_tittle = "ユーザー登録完了";
            $this->set("page_tittle", $page_tittle);
        }
        else {
            return $this->redirect(array('action' => 'register'));
        }
    }

    public function view() {
        $this->layout = 'user';
        $page_tittle = "ユーザー編集";
        $this->set("page_tittle", $page_tittle);

        $u_id = $this->request->pass['0'];
        $someone = $this->User->find('first', array(
            'conditions' => array('user_id' => $u_id)
        ));

        if (!isset($u_id))
            return $this->redirect(array('action' => 'index'));
        $someone['User']['password'] = "";
        if ($this->request->is('post')) {
            $data = $this->request->data;
            $this->User->set($data);
            if ($data['User']['権限'] != '2')
                unset($this->User->validate['mail_address']['notempty']);
            if ($data['User']['権限'] != '2' && strlen($data['User']['mail_address']) < 1)
                unset($this->User->validate['mail_address']);
            $someone['User']['mail_address'] = $data['User']['mail_address'];
            $someone['User']['user_name'] = $data['User']['user_name'];
            unset($this->User->validate['user_id']);
            if (strlen($data['User']['password']) < 1) {
                unset($this->User->validate['password']);
            }
            if ($this->User->validates()) {
                $this->Cookie->write("userRegister", $data);
                // debug($data['User']['password']);
                return $this->redirect(array('action' => 'change_confirm'));
            } else {
                $errors = $this->User->validationErrors;
                //debug($errors['user_name']['0']);
            }
        }
        $aryUserRegister = $this->Cookie->read('userRegister');
        if (isset($aryUserRegister)) {
            $someone['User']['user_name'] = $aryUserRegister['User']['user_name'];
            $someone['User']['password'] = $aryUserRegister['User']['password'];
            $someone['User']['authority_id'] = $aryUserRegister['User']['権限'];
            $someone['User']['valid_flag'] = $aryUserRegister['User']['有効／無効'];
            $someone['User']['mail_address'] = $aryUserRegister['User']['mail_address'];

            $this->Cookie->delete('userRegister');
        }
        $data_authority = $this->Authority->find('all');
        $this->set('authoritys', $data_authority);
        $this->set("user_info", $someone['User']);
    }

    public function change_confirm() {
        $this->layout = 'user';
        $page_tittle = "ユーザー入力確認";
        $this->set("page_tittle", $page_tittle);
        $aryUserRegister = $this->Cookie->read('userRegister');
        $aryUser = $this->Session->read('Auth.User');

        if (isset($aryUserRegister)) {
            if ($this->request->is('post')) {
                $user_id = $aryUserRegister['User']['user_id'];
                $name_change = $aryUserRegister['User']['user_name'];
                $password = $aryUserRegister['User']['password'];
                if (strlen($password) > 0)
                    $password = $this->Auth->password($password);
                else {
                    $someone = $this->User->find('first', array(
                        'conditions' => array('user_id' => $user_id)
                    ));
                    $password = $someone['User']['password'];
                }
                $authority_change = $aryUserRegister['User']['権限'];
                $valid_flag_change = $aryUserRegister['User']['有効／無効'];
                $mail_change = $aryUserRegister['User']['mail_address'];
                $var1 = $aryUser['user_id'];
                $var2 = date('Y-m-d H:i:s');
                if ($this->User->updateAll(array(
                            'user_name' => "'$name_change'",
                            'password' => "'$password'",
                            'authority_id' => "'$authority_change'",
                            'valid_flag' => "'$valid_flag_change'",
                            'mail_address' => "'$mail_change'",
                            'update_user' => "'$var1'",
                            'update_datetime' => "'$var2'"), array('user_id' => $user_id))) {
                    $this->Cookie->delete('userRegister');
                    $this->redirect(array('action' => 'success_change'));
                }
            }
            if ($aryUserRegister['User']['有効／無効'] == 1) {
                $this->set('valid', '有効');
            } else {
                $this->set('valid', '無効');
            }
            $this->set('user_data', $aryUserRegister);
            $data_authority = $this->Authority->find('all', array('conditions' => array('Authority.idauthority_id' => $aryUserRegister['User']['権限'])));
            $this->set('authority', $data_authority);
        } else {
            return $this->redirect(array('action' => 'index'));
        }
    }

    public function change_info() {
        $page_tittle = "ユーザー編集";
        $this->set("page_tittle", $page_tittle);
    }

    public function success_change() {
        $this->layout = 'user';
        $page_tittle = "ユーザー編集完了";
        $this->set("page_tittle", $page_tittle);
    }

}

?>
