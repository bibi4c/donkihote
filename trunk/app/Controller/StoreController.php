<?php

class StoreController extends AppController {

    var $uses = array('Store', 'Property');
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
        $this->Cookie->delete('userRegister');
        $this->Cookie->delete('user_searchForm');
        $this->Cookie->delete('calendar_searchForm');
        if (!empty($aryUser)) {
            $this->layout = 'user';
        }
    }

    public function search() {
        $this->layout = 'user';
        $page_tittle = "店舗一覧";
        $this->set("page_tittle", $page_tittle);
        if ($this->request->is('post')) {
            $data = $this->request->data;
            $this->Cookie->write("store_searchForm", $data);
        }
        return $this->redirect(array('action' => 'index'));
    }

    public function index() {
        $condition = array();
        $search = $this->Cookie->read('store_searchForm');
        //debug($search);
        $start_f = 0;
        $err_mmmm = 0;
        if (isset($search)) {
            $date_check = str_replace('年', '-', $search['searchForm']['start_date1']);
            $date_check = str_replace('月', '-', $date_check);
            $date_check = str_replace('日', '', $date_check);
            $start_date1 = $date_check;
            $date_check = str_replace('年', '-', $search['searchForm']['start_date2']);
            $date_check = str_replace('月', '-', $date_check);
            $date_check = str_replace('日', '', $date_check);
            $start_date2 = $date_check;
            $date_check = str_replace('年', '-', $search['searchForm']['end_date1']);
            $date_check = str_replace('月', '-', $date_check);
            $date_check = str_replace('日', '', $date_check);
            $end_date1 = $date_check;
            $date_check = str_replace('年', '-', $search['searchForm']['end_date2']);
            $date_check = str_replace('月', '-', $date_check);
            $date_check = str_replace('日', '', $date_check);
            $end_date2 = $date_check;


            $name1 = $search['searchForm']['storenum'];
            $name2 = $search['searchForm']['name'];
            $condition += array('Store.store_no LIKE' => "%$name1%");
            $condition += array('Store.name LIKE' => "%$name2%");
            if (strlen($search['searchForm']['start_date1']) > 0)
                $condition += array('Store.valid_start_day >=' => $start_date1);
            if (strlen($search['searchForm']['start_date2']) > 0)
                $condition += array('Store.valid_start_day <=' => $start_date2);
            if (strlen($search['searchForm']['end_date1']) > 0)
                $condition += array('Store.valid_end_day >=' => $end_date1);
            if (strlen($search['searchForm']['end_date2']) > 0)
                $condition += array('Store.valid_end_day <=' => $end_date2);
            if ($search['searchForm']['end_date1'] > $search['searchForm']['end_date2'])
                $err_mmmm = 2;
            if ($search['searchForm']['start_date1'] > $search['searchForm']['start_date2'])
                $err_mmmm = 1;
        }
        else {
            $search['searchForm']['storenum'] = '';
            $search['searchForm']['name'] = '';
            $search['searchForm']['start_date1'] = '';
            $search['searchForm']['start_date2'] = '';
            $search['searchForm']['end_date1'] = '';
            $search['searchForm']['end_date2'] = '';
            $start_f = 1;
        }

        $this->paginate = array(
            'limit' => '10',
            'conditions' => $condition,
            'order' => array(
                'Store.store_no' => 'asc',
                'Store.store_id' => 'asc'
            )
        );

        $data = $this->paginate('Store');
        $this->set('stores', $data);
        $this->set('search', $search);
        $data_property = $this->Property->find('all');
        $this->set('properties', $data_property);

        $data_store = $this->Store->find('all', array('conditions' => $condition));
        $this->set('data_all_store', $data_store);

        if ($err_mmmm == 0)
            $text = "検索結果はありません。再検索してください。<br>";
        else
        if ($err_mmmm == 1)
            $text = "[有効開始日]日付が逆転しました。<br>";
        else
            $text = "[有効終了日]日付が逆転しました。<br>";
        if (count($data) == 0 && $start_f == 0)
            $this->set('e_message', $text);
        if (count($data) == 0 || $start_f == 1)
            $this->set('paging_show', '1');
        $this->layout = 'user';
        $page_tittle = "店舗一覧";
        $this->set("page_tittle", $page_tittle);
    }

    public function register() {
        $data_store = array();
        $data_store['Store']['store_no'] = '';
        $data_store['Store']['name'] = '';
        $data_store['Store']['property_id'] = '1';
        $data_store['Store']['valid_start_day'] = '';
        $data_store['Store']['valid_end_day'] = '';

        if ($this->request->is('post')) {
            $data = $this->request->data;
            //debug($data);
            $this->Store->set($data);
            $this->Cookie->write("storeRegister", $data);
            if ($this->Store->validates()) {
                return $this->redirect(array('action' => 'register_confirm'));
            }
        }

        $aryStoreRegister = $this->Cookie->read('storeRegister');
        if (isset($aryStoreRegister)) {
            $data_store['Store']['store_no'] = $aryStoreRegister['Store']['store_no'];
            $data_store['Store']['name'] = $aryStoreRegister['Store']['name'];
            $data_store['Store']['property_id'] = $aryStoreRegister['Store']['puroperty_id'];
            $data_store['Store']['valid_start_day'] = $aryStoreRegister['Store']['valid_start_day'];
            $data_store['Store']['valid_end_day'] = $aryStoreRegister['Store']['valid_end_day'];
            $this->Cookie->delete('storeRegister');
        }
        $data_property = $this->Property->find('all');
        $this->set('properties', $data_property);

        $data_property_name = $this->Property->find('all', array('conditions' => array('Property.puroperty_id' => $data_store['Store']['property_id'])));
        $this->set('property_name', $data_property_name);

        $this->set('data_store', $data_store);
        $this->layout = 'user';
        $page_tittle = "店舗登録";
        $this->set("page_tittle", $page_tittle);
    }

    public function register_confirm() {
        $this->layout = 'user';
        $page_tittle = "店舗入力確認";
        $this->set("page_tittle", $page_tittle);

        $aryStoreRegister = $this->Cookie->read('storeRegister');
        if (isset($aryStoreRegister)) {
            $this->set('store_data', $aryStoreRegister);
            $data_properties = $this->Property->find('all', array('conditions' => array('Property.puroperty_id' => $aryStoreRegister['Store']['puroperty_id'])));
            $this->set('properties', $data_properties);
        } else {
            return $this->redirect(array('action' => 'register'));
        }

        if ($this->request->is('post')) {
            $data = $this->request->data;
            $aryUser = $this->Session->read('Auth.User');
            //debug($data);die;
            $temp = array();
            $temp['Store']['store_no'] = $data['Store']['store_no'];
            $temp['Store']['name'] = $data['Store']['name'];
            $temp['Store']['property_id'] = $data['Store']['puroperty_id'];
            $date_check = str_replace('年', '-', $data['Store']['valid_start_day']);
            $date_check = str_replace('月', '-', $date_check);
            $date_check = str_replace('日', '', $date_check);
            $temp['Store']['valid_start_day'] = $date_check;
            $date_check = str_replace('年', '-', $data['Store']['valid_end_day']);
            $date_check = str_replace('月', '-', $date_check);
            $date_check = str_replace('日', '', $date_check);
            $temp['Store']['valid_end_day'] = $date_check;
            $temp['Store']['register_datetime'] = date('Y-m-d H:i:s');
            $temp['Store']['register_user'] = $aryUser['user_id'];

            if ($this->Store->save($temp)) {
                $this->Cookie->delete('storeRegister');
                $this->redirect(array('controller' => 'Store', 'action' => 'success_register'));
            }
        }
    }

    public function success_register() {
        $this->layout = 'user';
        $page_tittle = "店舗登録完了";
        $this->set("page_tittle", $page_tittle);
    }

    public function view() {
        $this->layout = 'user';
        $page_tittle = "店舗編集";
        $this->set("page_tittle", $page_tittle);

        $store_id = $this->request->pass['0'];
        $someone = $this->Store->find('first', array(
            'conditions' => array('store_id' => $store_id)
        ));
        $this->set('data', $someone);

        $data_property_all = $this->Property->find('all');
        $this->set('properties_all', $data_property_all);

        if ($this->request->is('post')) {
            $data = $this->request->data;
            //debug($data);
            $this->Store->set($data);
            $this->Cookie->write("storeRegister", $data);
            if ($this->Store->validates()) {
                return $this->redirect(array('action' => 'change_confirm'));
            }
        }
        $aryStoreRegister = $this->Cookie->read('storeRegister');
        if (isset($aryStoreRegister)) {
            $this->set("data", $aryStoreRegister);
            $this->Cookie->delete('storeRegister');
        }
    }

    public function change_confirm() {
        $this->layout = 'user';
        $page_tittle = "店舗入力確認";
        $this->set("page_tittle", $page_tittle);

        $aryStoreRegister = $this->Cookie->read('storeRegister');
        $aryUser = $this->Session->read('Auth.User');
        if (isset($aryStoreRegister)) {
            if ($this->request->is('post')) {
                $data = $this->request->data;
                $temp = $data['Store']['store_id'];
                $name_change = $data['Store']['name'];
                $property_change = $data['Store']['property_id'];
                $date_check = str_replace('年', '-', $data['Store']['valid_start_day']);
                $date_check = str_replace('月', '-', $date_check);
                $date_check = str_replace('日', '', $date_check);
                $valid_start_day_change = $date_check;
                $date_check = str_replace('年', '-', $data['Store']['valid_end_day']);
                $date_check = str_replace('月', '-', $date_check);
                $date_check = str_replace('日', '', $date_check);
                $valid_end_day_change = $date_check;
                $register_datetime_change = date('Y-m-d H:i:s');
                $register_user = $aryUser['user_id'];
                $this->Store->id = $temp;
                $data = array(
                    'name' => $name_change,
                    'property_id' => $property_change,
                    'valid_start_day' => $valid_start_day_change,
                    'valid_end_day' => $valid_end_day_change,
                    'register_datetime' => $register_datetime_change,
                    'register_user' => $register_user);
                $check = $this->Store->save($data);
                if ($check) {
                    $this->Cookie->delete('storeRegister');
                    $this->redirect(array('controller' => 'Store', 'action' => 'success_change'));
                }
            }
            $this->set('store_data', $aryStoreRegister);
            $data_properties = $this->Property->find('all', array('conditions' => array('Property.puroperty_id' => $aryStoreRegister['Store']['property_id'])));
            $this->set('properties', $data_properties);
        } else {
            return $this->redirect(array('action' => 'register'));
        }
    }

    public function success_change() {
        $this->layout = 'user';
        $page_tittle = "店舗編集完了";
        $this->set("page_tittle", $page_tittle);
    }

    public function change_info() {
        $page_tittle = "ユーザ編集";
        $this->set("page_tittle", $page_tittle);
    }

}

?>
