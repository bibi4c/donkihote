<?php

define('CHR_TAB', chr(9));
CakePlugin::load('FileUpload');

class AuditManagerController extends AppController {

    var $uses = array('Calendar', 'Item', 'Category', 'Property', 'Audit', 'Store', 'AuditManager', 'Audit_file', 'Audit_detail', 'Document', 'User', 'Auditfileupload');
    public $layout = null;
    public $components = array('RequestHandler', 'Cookie', 'Csv' => array(
        //'settings' => array('delimiter'=>CHR_TAB)
    ));
    public $helpers = array(
        'Html', 'Form',
        'Session', 'Paginator', 'Js',
    );
    var $paginate = array();

    public function beforeFilter() {
        parent::beforeFilter();
        $aryUser = $this->Session->read('Auth.User');
        $this->Cookie->delete('userRegister');
        $this->Cookie->delete('store_searchForm');
        $this->Cookie->delete('user_searchForm');
        if (!empty($aryUser)) {
            $this->layout = 'user';
        }
    }

    public function index() {
        $this->layout = 'calendar';
        $page_tittle = "予定詳細・監査表";
        $this->set("page_tittle", $page_tittle);

        $audit_id = $this->request->pass['0'];
        $this->set("audit_id", $audit_id);
        //debug($audit_id);die;
        $status_arr = array('1', '2', '3');
        $item_arr = array('1', '2');
        if (isset($this->request->pass['1'])) {
            $audit_id2 = $this->request->pass['1'];
            $this->set('back_search', $audit_id2);
// 	 	debug($audit_id2);die;
        }

        $data_audit_file = $this->Audit_file->find('all', array('conditions' => array('Audit_file.audit_id' => $audit_id)));
        $this->set('data_audit_file', $data_audit_file);
        $someone = $this->AuditManager->find('first', array(
            'conditions' => array('AuditManager.audit_id' => $audit_id)
        ));

        $user_create = $this->User->find('first', array('conditions' => array('User.user_id' => $someone['AuditManager']['audit_create_user'])));
        $this->set('user_create', $user_create);

        $array_audit_detail = $this->Audit_detail->find('all', array(
            'conditions' => array('Audit_detail.audit_id' => $audit_id),
            'group' => array('Audit_detail.document_id'),
            'fields' => array('document_id')
        ));
        //debug($array_audit_detail);
        $arr_catogaty = array();
        $bibi_item = $someone['AuditManager']['item_id'];
        foreach ($array_audit_detail as $bibi_audit) {
            $id111 = $bibi_audit['Audit_detail']['document_id'];
            $data_1 = $this->Document->find('first', array(
                'conditions' => array('Document.document_id' => $id111),
                'fields' => array('category_id')
                    )
            );
            //debug($data_1['Document']['category_id']);
            if (!in_array($data_1['Document']['category_id'], $arr_catogaty)) {
                $data_2 = $this->Category->find('first', array(
                    'conditions' => array('Category.category_id' => $data_1['Document']['category_id']),
                    'fields' => array('item_id')
                        )
                );
                if ($data_2['Category']['item_id'] == $bibi_item)
                    array_push($arr_catogaty, $data_1['Document']['category_id']);
            }
        }
        //debug($arr_catogaty);
// 	 debug($someone);die;
//tim audit cau store gan nhat co item_id = 1  
        if ($someone['AuditManager']['item_id'] == 2) {
            // debug($someone1);
            $arr_data_audit_detail = $this->Audit_detail->find('list', array(
                'conditions' => array('Audit_detail.audit_id' => $audit_id),
                'fields' => array('audit_detail_id', 'document_id')
            ));
            $data_document2s = $this->Document->find('list', array(
                'conditions' => array('Document.transfer_flag' => '1', 'Document.item_id' => '1', 'Document.document_id' => $arr_data_audit_detail),
                'fields' => array('document_id', 'document_id'),
                'order' => array('Document.category_id' => 'asc')
            ));
            $data_document1s = $this->Document->find('all', array(
                'conditions' => array('Document.transfer_flag' => '1', 'Document.item_id' => '1', 'Document.document_id' => $arr_data_audit_detail),
                'fields' => array('item_id', 'transfer_flag', 'contents', 'category_id'),
                'order' => array('Document.category_id' => 'asc')
            ));
            $arr_audit_detail = array();
            foreach ($arr_data_audit_detail as $bibi => $arr_data_audit_detail1) {

                if (in_array($arr_data_audit_detail1, $data_document2s)) {
                    $arr_audit_detail += array($bibi => $arr_data_audit_detail1);
                }
            }

            if (count($arr_audit_detail) > 0) {
                $c = 0;
                $c1 = 0;
                $c2 = 0;
                $c3 = 0;
                $c4 = 0;
                $count_all = 0;
                $count1_all = 0;
                $count2_all = 0;
                $count3_all = 0;
                $arr_document = array();

                //tim xem co bao nhieu category co document_id  trong array $arr_audit_detail
                $data_document_cate = $this->Document->find('all', array(
                    'conditions' => array('Document.document_id' => $arr_audit_detail),
                    'group' => array('Document.category_id'),
                    'fields' => array('category_id')
                        )
                );
                $this->set('data_document_cate', $data_document_cate);

                // tim tat ca document co document_id trong array $arr_audit_detail
                $document1 = $this->Document->find('all', array('conditions' => array('Document.document_id' => $arr_audit_detail),));
                $this->set('document1', $document1);

                $arr_data_audit_detail_all = $this->Audit_detail->find('all', array(
                    'conditions' => array('Audit_detail.audit_id' => $someone['AuditManager']['audit_id'], 'Audit_detail.document_id' => $arr_audit_detail),
                    'group' => array('Audit_detail.document_id'),
                ));
                $this->set('arr_data_audit_detail_all', $arr_data_audit_detail_all);

                $arr_cate1 = array();
                foreach ($data_document_cate as $cate1) {
                    $data_document_all = $this->Document->find('all', array(
                        'conditions' => array('Document.document_id' => $arr_audit_detail, 'Document.category_id' => $cate1['Document']['category_id']),
                            )
                    );
                    $arr_cate1 += array($cate1['Document']['category_id'] => count($data_document_all));

                    foreach ($document1 as $doc1) {
                        if ($cate1['Document']['category_id'] == $doc1['Document']['category_id']) {
                            foreach ($arr_data_audit_detail_all as $audit1) {
                                if ($audit1['Audit_detail']['document_id'] == $doc1['Document']['document_id']) {
                                    $c++;
                                    if ($audit1['Audit_detail']['judgment'] == 1)
                                        $c1++;
                                    if ($audit1['Audit_detail']['judgment'] == 2)
                                        $c2++;
                                    if ($audit1['Audit_detail']['judgment'] == 3)
                                        $c3++;
                                    if ($audit1['Audit_detail']['judgment'] == 4)
                                        $c4++;
                                }
                            }
                        }
                    }
                }
                if ($c1 > 0 || $c2 > 0 || $c3 > 0) {
                    $c = $c1 + $c2 + $c3;
                }
                if ($c4 == $c) {
                    $c = 0;
                }
                $count_all = $c;
                $count1_all = $c1;
                $count2_all = $c2;
                $count3_all = $c3;
                $this->set('arr_cate1', $arr_cate1);
            }
        }


        $category_all = $this->Category->find('all');
        $arr_cate = array();
        foreach ($category_all as $cate) {
            $arr_cate += array($cate['Category']['category_id'] => $cate['Category']['category_name']);
        }
        $this->set('arr_cate', $arr_cate);

        $data_store = $this->Store->find('all', array('conditions' => array('Store.store_id' => $someone['AuditManager']['store_id'])));
        $this->set('stores', $data_store);
        //debug($data_store);

        $data_property = $this->Property->find('all', array('conditions' => array('Property.puroperty_id' => $data_store['0']['Store']['property_id'])));
        $this->set('property', $data_property);

        $data_item = $this->Item->find('all', array('conditions' => array('Item.item_id' => $someone['AuditManager']['item_id'])));
        $this->set('items', $data_item);
        //debug($data_item);die;

        $data_audit_file = $this->Audit_file->find('all', array('conditions' => array('Audit_file.audit_file_id' => $someone['AuditManager']['audit_file_id'])));
        $this->set('audit_files', $data_audit_file);
        // debug($arr_catogaty);
        $data_category = $this->Category->find('all', array('conditions' => array('Category.category_id' => $arr_catogaty)));
        $this->set('category', $data_category);

        $data_audit_details = $this->Audit_detail->find('all', array('conditions' => array('Audit_detail.audit_id' => $audit_id)));
        $this->set('data_audit_details', $data_audit_details);

        $data_documents = $this->Document->find('all', array(
            'conditions' => array('Document.item_id' => $someone['AuditManager']['item_id']),
            'fields' => array('document_id', 'category_id')
        ));

        $this->set('data_documents', $data_documents);
        if ($someone['AuditManager']['status'] != 0) {
            $status_change_ok = 1;
            if (count($data_category) == 0)
                $status_change_ok = 0;
            if (!isset($count_all) && !isset($count1_all) && !isset($count2_all) && !isset($count3_all)) {
                $count_all = 0;
                $count1_all = 0;
                $count2_all = 0;
                $count3_all = 0;
            }
            foreach ($data_category as $cate) {
                $count1 = 0;
                $count2 = 0;
                $count3 = 0;
                $count = 0;
                $count4 = 0;
                foreach ($data_documents as $babi) {
                    if ($babi['Document']['category_id'] == $cate['Category']['category_id']) {
                        foreach ($data_audit_details as $bibi) {
                            if ($bibi['Audit_detail']['document_id'] == $babi['Document']['document_id']) {
                                $count++;
                                if ($bibi['Audit_detail']['judgment'] == 1)
                                    $count1++;
                                if ($bibi['Audit_detail']['judgment'] == 2)
                                    $count2++;
                                if ($bibi['Audit_detail']['judgment'] == 3)
                                    $count3++;
                                if ($bibi['Audit_detail']['judgment'] == 4)
                                    $count4++;
                            }
                        }
                    }
                }
                if ($count1 > 0 || $count2 > 0 || $count3 > 0) {
                    $count = $count1 + $count2 + $count3;
                }
                if ($count4 == $count)
                    $count = 0;
                if ($count > 0) {
                    if ($count != $count1 + $count2 + $count3) {
                        $status_change_ok = 0;
                    }
                }
                $count_all = $count_all + $count;
                $count1_all = $count1_all + $count1;
                $count2_all = $count2_all + $count2;
                $count3_all = $count3_all + $count3;
            }
            $array_audit_detail1 = $this->AuditManager->find('all', array(
                'conditions' => array('AuditManager.audit_id' => $audit_id),
                'fields' => array('store_id', 'item_id', 'audit_create_user', 'impossible')
            ));
            $bibi_ttt = $count3_all;
            $data_update = array('impossible' => $bibi_ttt);
            $this->AuditManager->id = $audit_id;
            $check1 = $this->AuditManager->save($data_update);
// 	  debug($count_all);
// 	  debug($count1_all);
// 	  debug($count2_all);
// 	  debug($count3_all);
            $this->set('count_all', $count_all);
            $this->set('count1_all', $count1_all);
            $this->set('count2_all', $count2_all);
            $this->set('count3_all', $count3_all);
            if ($someone['AuditManager']['status'] == 4 && $status_change_ok == 1) {
//			$data_update = array('status' => '2','impossible'=>$count3_all);
//  			$this->AuditManager->id =  $audit_id;
//  			$check = $this->AuditManager->save($data_update);
//			$someone['AuditManager']['status'] = 2;	
//			$data_users= $this->User->find('all', array(
//													'conditions'=> array('User.authority_id' => '2','User.valid_flag'=>'1'),
//													'fields' => array('mail_address')
//													));
//			$createUser = $this->User->find('all', array(
//													'conditions'=> array('User.user_id' => $someone['AuditManager']['audit_create_user']),
//													'fields' => array('user_name')
//													));
//			foreach ($data_users as $user_mail){
//			  $this->__sendReportMail($user_mail['User']['mail_address'],$createUser['0']['User']['user_name'], $data_store['0']['Store']['store_no'], $data_item['0']['Item']['name']);
//			} 
            }
        }

        $this->set('data', $someone);

        if ($someone['AuditManager']['status'] == 0) {
            $this->set('data_status', '未実施');
        } else if ($someone['AuditManager']['status'] == 1) {
            $this->set('data_status', '監査完了');
        } else if ($someone['AuditManager']['status'] == 2) {
            $this->set('data_status', '承認待ち');
        } else if ($someone['AuditManager']['status'] == 3) {
            $this->set('data_status', '是正中');
        } else if ($someone['AuditManager']['status'] == 4) {
            $this->set('data_status', '実施中');
        }

        //debug($data_documents);die;
        if ($this->request->is('post')) {
// 	 	$data = $this->request->data;
// 	 	debug($data);die;
            $this->Cookie->write("auditRegister", $someone);
            return $this->redirect(array('action' => 'register_confirm', $audit_id));
        }
    }

    public function register_confirm($audit_id = null) {
        $this->layout = 'user';
        $page_tittle = "予定入力確認";
        $this->set("page_tittle", $page_tittle);
        $this->set('audit_id', $audit_id);
        $aryAuditRegister = $this->Cookie->read('auditRegister');
        //debug($aryAuditRegister);die;
        $status_arr = array('1', '2', '3');
        $item_arr = array('1', '2');
        if (isset($aryAuditRegister)) {
            // debug($aryAuditRegister);

            $user_create = $this->User->find('first', array('conditions' => array('User.user_id' => $aryAuditRegister['AuditManager']['audit_create_user'])));
            $this->set('user_create', $user_create);

            $someone1 = $this->AuditManager->find('first', array(
                'conditions' => array('AuditManager.store_id' => $aryAuditRegister['AuditManager']['store_id'], 'AuditManager.status' => $status_arr, 'AuditManager.item_id' => $item_arr),
                'order' => array('AuditManager.audit_date' => 'desc')
            ));
            if (isset($someone1) && count($someone1) > 0) {
                $this->set('someone1', $someone1);

                $data_item_new = $this->Item->find('first', array('conditions' => array('Item.item_id' => $someone1['AuditManager']['item_id'])));
                $this->set('items_new', $data_item_new);
                // 		debug($data_item_new);die;
            }

            $someone2 = $this->AuditManager->find('first', array(
                'conditions' => array('AuditManager.store_id' => $aryAuditRegister['AuditManager']['store_id'], 'AuditManager.item_id' => '1'),
                'order' => array('AuditManager.audit_end_date' => 'desc')
            ));



            $this->set('data', $aryAuditRegister);
            $this->Cookie->delete('auditRegister');

            $data_store = $this->Store->find('all', array('conditions' => array('Store.store_id' => $aryAuditRegister['AuditManager']['store_id'])));
            $this->set('stores', $data_store);

            $data_item = $this->Item->find('all', array('conditions' => array('Item.item_id' => $aryAuditRegister['AuditManager']['item_id'])));
            $this->set('items', $data_item);
        }
        if ($this->request->is('post')) {
            $data = $this->request->data;
// 			debug($data);
            $temp = $data['AuditManager']['audit_id'];
            $this->AuditManager->id = $temp;
            $data_change = array('status' => '4', 'audit_date' => date('Y-m-d'));
            $check = $this->AuditManager->save($data_change);
            $temp1 = array();
            $date1 = date('Y-m-d');
            $item_id = $data['AuditManager']['item_id'];
            $condition = array();
            $condition += array('Document.item_id' => $item_id);
            $condition += array('Document.start_date <=' => $date1);
            $data_documents = $this->Document->find('all', array(
                'conditions' => $condition,
                'fields' => array('document_id', 'start_date', 'end_date')
            ));
            //debug($data_documents);
            $temp1['Audit_detail']['audit_id'] = $temp;
            $temp1['Audit_detail']['user_update_date'] = date('Y-m-d H:i:s');
            $temp1['Audit_detail']['valid_flag'] = 1;
            //debug($data_documents);
            $i = 0;
            $aryUser = $this->Session->read('Auth.User');
            $data_audit_details = $this->Audit_detail->find('first', array(
                'fields' => array('audit_detail_id'),
                'order' => array(
                    'audit_detail_id DESC')
            ));
            //debug($data_audit_details);
            if ($data_audit_details != NULL)
                $i = $data_audit_details['Audit_detail']['audit_detail_id'];

            foreach ($data_documents as $data_docum) {
                $vail = 1;
                if ($data_docum['Document']['end_date'] != NULL && $data_docum['Document']['end_date'] < $date1) {
                    $vail = 0;

                    //debug($data_docum['Document']['end_date']);
                }
                if ($vail == 1) {
                    $temp1 = array();
                    $i++;
                    $temp1['Audit_detail']['audit_detail_id'] = $i;
                    $temp1['Audit_detail']['audit_id'] = $temp;
                    $temp1['Audit_detail']['user_update_date'] = date('Y-m-d H:i:s');
                    $temp1['Audit_detail']['user_update_name'] = $aryUser['user_name'];
                    $temp1['Audit_detail']['valid_flag'] = 0;
                    $temp1['Audit_detail']['document_id'] = $data_docum['Document']['document_id'];
                    //debug($temp1);
                    if (!$this->Audit_detail->save($temp1, false))
                        die();
                }
            }
            //debug($date1);die();
            if ($data['AuditManager']['item_id'] == 2) {


                $status_arr = array('1', '2', '3');
                $item_arr = array('1', '2');
                // debug($aryAuditRegister);

                $some1 = $this->AuditManager->find('first', array(
                    'conditions' => array('AuditManager.store_id' => $data['AuditManager']['store_id'], 'AuditManager.status' => $status_arr, 'AuditManager.item_id' => $item_arr),
                    'order' => array('AuditManager.audit_date DESC'),
                ));

                if (count($some1) > 0) {
                    $arr_audit_detail = array();
                    $arr_data_audit_detail = $this->Audit_detail->find('all', array('conditions' => array('Audit_detail.audit_id' => $some1['AuditManager']['audit_id'], 'Audit_detail.judgment' => '3', 'Audit_detail.valid_flag' => '1'), 'group' => array('document_id')));
                    //debug($arr_data_audit_detail);
                    if ($arr_data_audit_detail != null) {
                        $tem = array();

                        foreach ($arr_data_audit_detail as $arr_data_audit_detail) {
                            $data_document1s = $this->Document->find('all', array(
                                'conditions' => array('Document.transfer_flag' => '1', 'Document.item_id' => '1', 'Document.document_id' => $arr_data_audit_detail['Audit_detail']['document_id']),
                                'fields' => array('item_id', 'transfer_flag', 'contents')
                            ));
                            //debug($data_document1s);
                            if ($data_document1s != null) {
                                $i++;

                                $tem['Audit_detail']['audit_detail_id'] = $i;
                                $tem['Audit_detail']['audit_id'] = $data['AuditManager']['audit_id'];
                                $tem['Audit_detail']['document_id'] = $arr_data_audit_detail['Audit_detail']['document_id'];
                                $tem['Audit_detail']['user_update_date'] = date('Y-m-d H:i:s');
                                $tem['Audit_detail']['user_update_name'] = $aryUser['user_name'];
                                $tem['Audit_detail']['judgment'] = '0';
                                $tem['Audit_detail']['valid_flag'] = '0';
                                $this->Audit_detail->save($tem);

                                array_push($arr_audit_detail, $arr_data_audit_detail);
                                //debug($data_document1s);
                            }
                        }
                    }
                    //die();
                    if (count($arr_audit_detail) > 0) {
                        $arr_document = array();
                        foreach ($arr_audit_detail as $arr_audit_detail1) {
                            $data_document1 = $this->Document->find('all', array('conditions' => array('Document.document_id' => $arr_audit_detail1['Audit_detail']['document_id'])));
                            foreach ($data_document1 as $data_document1) {
                                array_push($arr_document, $data_document1);
                            }
                        }
                    }
                }
            }


            if ($check) {
// 					$this->Cookie->delete('storeRegister');
                $this->redirect(array('controller' => 'AuditManager', 'action' => 'success_change', $temp));
            }
        }
    }

    public function success_register() {
        $this->layout = 'user';
        $page_tittle = "予定入力完了";
        $this->set("page_tittle", $page_tittle);
    }

    public function delete_confirm() {
        $this->layout = 'user';
        $page_tittle = "削除確認";
        $this->set("page_tittle", $page_tittle);

        $audit_id = $this->request->pass['0'];
        //debug($audit_id);die;
        $someone = $this->AuditManager->find('first', array(
            'conditions' => array('audit_id' => $audit_id)
        ));
        //debug($someone);die;
        $this->set('data', $someone);

        $user_create = $this->User->find('first', array('conditions' => array('User.user_id' => $someone['AuditManager']['audit_create_user'])));
        $this->set('user_create', $user_create);

        if ($someone['AuditManager']['status'] == 0) {
            $this->set('data_status', '未実施');
        } else if ($someone['AuditManager']['status'] == 1) {
            $this->set('data_status', '監査完了');
        } else if ($someone['AuditManager']['status'] == 2) {
            $this->set('data_status', '承認待ち');
        } else if ($someone['AuditManager']['status'] == 3) {
            $this->set('data_status', '是正中');
        } else if ($someone['AuditManager']['status'] == 4) {
            $this->set('data_status', '監査完了');
        }

        $data_store = $this->Store->find('all', array('conditions' => array('Store.store_id' => $someone['AuditManager']['store_id'])));
        $this->set('stores', $data_store);
        //debug($data_store);
        $data_property = $this->Property->find('all', array('conditions' => array('Property.puroperty_id' => $data_store['0']['Store']['property_id'])));
        $this->set('property', $data_property);

        $data_item = $this->Item->find('all', array('conditions' => array('Item.item_id' => $someone['AuditManager']['item_id'])));
        $this->set('items', $data_item);

        if ($this->request->is('post')) {
            $data_delete = $this->request->data;
            //debug($data_delete);die;
            if ($this->AuditManager->delete($data_delete['AuditManager']['audit_id'])) {
                return $this->redirect(array('action' => 'success_delete'));
            }
        }
    }

    public function success_delete() {
        $this->layout = 'user';
        $page_tittle = "削除完了";
        $this->set("page_tittle", $page_tittle);
    }

    public function success_change() {
        $this->layout = 'user';
        $page_tittle = "監査表更新完了";
        $this->set("page_tittle", $page_tittle);

        $audit_id = $this->request->pass['0'];
//   	debug($audit_id);die;
        $this->set("audit_id", $audit_id);
    }

    public function view() {
        $this->layout = 'user1';
        $page_tittle = "監査表更新画面";
        $this->set("page_tittle", $page_tittle);
        //debug($this->Session->read());
        $audit_id = $this->request->pass['0'];
//   	debug($audit_id);die;
        $id = $audit_id;
        $someone = $this->Audit_file->find('all', array(
            'conditions' => array('audit_id' => $id),
            'fields' => array('audit_file_id', 'audit_id', 'audit_file_name')
        ));
        $this->set('data_audit_files', $someone);
        //debug($someone);die();
        $this->set('audit_id', $audit_id);
        $someone = $this->AuditManager->find('first', array(
            'conditions' => array('AuditManager.audit_id' => $audit_id)
        ));

        $user_create = $this->User->find('first', array('conditions' => array('User.user_id' => $someone['AuditManager']['audit_create_user'])));
        $this->set('user_create', $user_create);
//   	 	debug($someone);die;
        $this->set('data', $someone);
        $this->Cookie->write("status_cookei", $someone['AuditManager']['status']);

        $data_store = $this->Store->find('all', array('conditions' => array('Store.store_id' => $someone['AuditManager']['store_id'])));
        $this->set('stores', $data_store);
        // debug($data_store);

        $data_property = $this->Property->find('all', array('conditions' => array('Property.puroperty_id' => $data_store['0']['Store']['property_id'])));
        $this->set('property', $data_property);

        $data_item = $this->Item->find('all', array('conditions' => array('Item.item_id' => $someone['AuditManager']['item_id'])));
        $this->set('items', $data_item);

        if ($this->request->is('post')) {
            $data = $this->request->data;
            $this->set("comment_data", $data['AuditManager']['comment']);
            if ($data['AuditManager']['status'] == 3) {
                if ($data['AuditManager']['correct_information_date'] == '') {
                    $this->set('error_message', '[是正通知日]入力がありません。');
                    $data['AuditManager']['correct_information_date'] = '';
                    $this->Cookie->write("dataAudit", $data);
                } else if ($data['AuditManager']['correct_end_scheduled_date'] == '') {
                    $this->set('error_message', '[是正完了予定日]入力がありません。');
                    $data['AuditManager']['correct_end_scheduled_date'] = '';
                    $this->Cookie->write("dataAudit", $data);
                } else {
                    $this->AuditManager->set($data);
                    if ($this->AuditManager->validates()) {
                        $this->Cookie->write("dataAudit", $data);
                        return $this->redirect(array('controller' => 'AuditManager', 'action' => 'change_confirm', $audit_id));
                    } else
                        $this->set('error_message', '[コメント]512文字以内で入力してください。');
                }
            }else {
                $this->AuditManager->set($data);
                if ($this->AuditManager->validates()) {
                    if ($data['AuditManager']['status'] == 2 && $someone['AuditManager']['status'] != 2) {
                        $data['AuditManager']['correct_information_date'] = '';
                        $data['AuditManager']['correct_end_scheduled_date'] = '';
                    }
                    $this->Cookie->write("dataAudit", $data);
                    return $this->redirect(array('controller' => 'AuditManager', 'action' => 'change_confirm', $audit_id));
                } else
                    $this->set('error_message', '[コメント]512文字以内で入力してください。');
            }
        }
        $aryAuditManager = $this->Cookie->read('dataAudit');
        if (isset($aryAuditManager)) {
            $this->set("data", $aryAuditManager);
            //debug($aryStoreRegister);
            $this->Cookie->delete('dataAudit');
        }
    }

    public function change_confirm() {
        $this->layout = 'user1';
        $page_tittle = "監査表更新確認";
        $this->set("page_tittle", $page_tittle);

        $audit_id = $this->request->pass['0'];
        $this->set('audit_id', $audit_id);
//   	debug($audit_id);die;

        $someone = $this->AuditManager->find('first', array(
            'conditions' => array('AuditManager.audit_id' => $audit_id)
        ));
        $user_create = $this->User->find('first', array('conditions' => array('User.user_id' => $someone['AuditManager']['audit_create_user'])));
        $this->set('user_create', $user_create);

        $aryAuditManager = $this->Cookie->read('dataAudit');
        $status = $this->Cookie->read('status_cookei');
        //debug($aryAuditManager);die;
        if (isset($aryAuditManager)) {
            $this->set('data', $aryAuditManager);

            $data_property = $this->Property->find('all', array('conditions' => array('Property.puroperty_id' => $aryAuditManager['AuditManager']['property_id'])));
            $this->set('property', $data_property);

            $data_item = $this->Item->find('all', array('conditions' => array('Item.item_id' => $aryAuditManager['AuditManager']['item_id'])));
            $this->set('items', $data_item);

            $data_audit_file = $this->Audit_file->find('all', array('conditions' => array('Audit_file.audit_id' => $aryAuditManager['AuditManager']['audit_id'])));
            $this->set('data_audit_file', $data_audit_file);

            if ($aryAuditManager['AuditManager']['status'] == 0) {
                $this->set('data_status', '未実施');
            } else if ($aryAuditManager['AuditManager']['status'] == 1) {
                $this->set('data_status', '監査完了');
            } else if ($aryAuditManager['AuditManager']['status'] == 2) {
                $this->set('data_status', '承認待ち');
            } else if ($aryAuditManager['AuditManager']['status'] == 3) {
                $this->set('data_status', '是正中');
            } else if ($aryAuditManager['AuditManager']['status'] == 4) {
                $this->set('data_status', '監査完了');
            }

            if ($this->request->is('post')) {
                $data = $this->request->data;
//   				debug($data);die;
                $aryUser = $this->Session->read('Auth.User');
                //debug($aryUser);die;
                $temp = $data['AuditManager']['audit_id'];

                $status_change = $data['AuditManager']['status'];

                $date_check = str_replace('年', '-', $data['AuditManager']['correct_information_date']);
                $date_check = str_replace('月', '-', $date_check);
                $date_check = str_replace('日', '', $date_check);
                $correct_information_date_change = $date_check;
                $date_check = str_replace('年', '-', $data['AuditManager']['correct_end_scheduled_date']);
                $date_check = str_replace('月', '-', $date_check);
                $date_check = str_replace('日', '', $date_check);
                $correct_end_scheduled_date_change = $date_check;
                $comment_change = $data['AuditManager']['comment'];

                $data_updates = array('status' => $status_change,
                    'correct_information_date' => $correct_information_date_change,
                    'correct_end_scheduled_date' => $correct_end_scheduled_date_change,
                    'comment' => $comment_change
                );
                if ($status == 1 && $status_change == 2) {
                    $data_updates = array(
                        'status' => $status_change,
                        'audit_end_date' => '',
                        'correct_status' => '0',
                        'approver' => '',
                        'approval_date' => '',
                        'correct_information_date' => '',
                        'correct_end_scheduled_date' => '',
                        'correct_end_date' => '',
                        'comment' => $comment_change
                    );
                    $this->Cookie->delete('status');
                }
                if ($status == 1 && $status_change == 3) {
                    $data_updates = array(
                        'status' => $status_change,
                        'audit_end_date' => '',
                        'correct_status' => '0',
                        'approver' => $aryUser['user_id'],
                        'approval_date' => date('Y-m-d H:i:s'),
                        'correct_end_date' => '',
                        'correct_information_date' => $correct_information_date_change,
                        'correct_end_scheduled_date' => $correct_end_scheduled_date_change,
                        'comment' => $comment_change
                    );
                    $this->Cookie->delete('status');
                }
                if ($status == 2 && $status_change == 1) {
                    $data_updates = array(
                        'status' => $status_change,
                        'approval_date' => date('Y-m-d H:i:s'),
                        'audit_end_date' => date('Y-m-d H:i:s'),
                        'correct_value' => '0',
                        'correct_status' => '1',
                        'approver' => $aryUser['user_id'],
                        'correct_information_date' => $correct_information_date_change,
                        'correct_end_scheduled_date' => $correct_end_scheduled_date_change,
                        'comment' => $comment_change
                    );
                    $this->Cookie->delete('status');
                }
                if ($status == 2 && $status_change == 3) {
                    $data_updates = array(
                        'status' => $status_change,
                        'approval_date' => date('Y-m-d H:i:s'),
                        'correct_value' => '1',
                        'approver' => $aryUser['user_id'],
                        'correct_information_date' => $correct_information_date_change,
                        'correct_end_scheduled_date' => $correct_end_scheduled_date_change,
                        'comment' => $comment_change
                    );
                    $this->Cookie->delete('status');
                }
                if ($status == 3 && $status_change == 1) {
                    $data_updates = array(
                        'status' => $status_change,
                        'approval_date' => date('Y-m-d H:i:s'),
                        'correct_status' => '2',
                        'approver' => $aryUser['user_id'],
                        'correct_end_date' => date('Y-m-d H:i:s'),
                        'audit_end_date' => date('Y-m-d H:i:s'),
                        'correct_information_date' => $correct_information_date_change,
                        'correct_end_scheduled_date' => $correct_end_scheduled_date_change,
                        'comment' => $comment_change
                    );
                    $this->Cookie->delete('status');
                }
                if ($status == 3 && $status_change == 2) {
                    $data_updates = array(
                        'status' => $status_change,
                        'approver' => '',
                        'correct_value' => '0',
                        'correct_information_date' => '',
                        'correct_end_scheduled_date' => '',
                        'correct_end_date' => '',
                        'comment' => $comment_change
                    );
                    $this->Cookie->delete('status');
                }
                $this->AuditManager->id = $temp;
                $check = $this->AuditManager->save($data_updates);
                if ($check) {
                    $this->Cookie->delete('dataAudit');
                    //$this->Cookie->write("audit_id",$data['AuditManager']['audit_id']);
                    $this->redirect(array('controller' => 'AuditManager', 'action' => 'index', $audit_id));
                }
            }
        }
    }

    public function report_work() {
        $this->layout = '';
        $audit_id = $this->request->pass['0'];
        //debug($audit_id);die;
        $someone = $this->AuditManager->find('first', array(
            'conditions' => array('audit_id' => $audit_id)
        ));
        //  	debug($someone);die;

        $user_create = $this->User->find('first', array('conditions' => array('User.user_id' => $someone['AuditManager']['audit_create_user'])));
        $this->set('user_create', $user_create);

        if ($someone['AuditManager']['status'] == 0) {
            $this->set('data_status', '未実施');
        } else if ($someone['AuditManager']['status'] == 1) {
            $this->set('data_status', '監査完了');
        } else if ($someone['AuditManager']['status'] == 2) {
            $this->set('data_status', '承認待ち');
        } else if ($someone['AuditManager']['status'] == 3) {
            $this->set('data_status', '是正中');
        } else if ($someone['AuditManager']['status'] == 4) {
            $this->set('data_status', '監査完了');
        }
        $this->set('data', $someone);

        $data_store = $this->Store->find('all', array('conditions' => array('Store.store_id' => $someone['AuditManager']['store_id'])));
        $this->set('stores', $data_store);
        // debug($data_store);

        $data_property = $this->Property->find('all', array('conditions' => array('Property.puroperty_id' => $data_store['0']['Store']['property_id'])));
        $this->set('property', $data_property);

        $data_item = $this->Item->find('all', array('conditions' => array('Item.item_id' => $someone['AuditManager']['item_id'])));
        $this->set('items', $data_item);
        //debug($data_item);die;

        $data_audit_file = $this->Audit_file->find('all', array('conditions' => array('Audit_file.audit_file_id' => $someone['AuditManager']['audit_file_id'])));
        $this->set('audit_files', $data_audit_file);

        $data_category = $this->Category->find('all', array('conditions' => array('Category.item_id' => $data_item['0']['Item']['item_id'])));
        $this->set('category', $data_category);
        $arr_name_category = array();
        foreach ($data_category as $arr) {
            $arr_name_category += array($arr['Category']['category_id'] => $arr['Category']['category_name']);
        }
        $this->set('arr_name_category', $arr_name_category);

        $data_audit_details = $this->Audit_detail->find('all', array('conditions' => array('Audit_detail.audit_id' => $audit_id)));
        $this->set('data_audit_details', $data_audit_details);

        $audit_details_judgment = $this->Audit_detail->find('all', array('conditions' => array('Audit_detail.audit_id' => $audit_id, 'Audit_detail.judgment' => '3')));
        //debug($audit_details_judgment);
        $data_documents_judgment = array();
        foreach ($audit_details_judgment as $audit_judgment) {
            $arr_data = $this->Document->find('all', array(
                'conditions' => array('Document.document_id' => $audit_judgment['Audit_detail']['document_id']),
                'fields' => array('document_id', 'category_id', 'contents', 'document_no'),
                'order' => array('category_id' => 'asc', 'document_no' => 'asc')
            ));
            foreach ($arr_data as $arr) {
                array_push($data_documents_judgment, $arr);
            }
        }
        $this->set('data_documents_judgment', $data_documents_judgment);

        $data_documents = $this->Document->find('all', array(
            'conditions' => array('Document.item_id' => $someone['AuditManager']['item_id']),
            'fields' => array('document_id', 'category_id'),
            'order' => array('category_id' => 'asc', 'document_no' => 'asc')
        ));
        $this->set('data_documents', $data_documents);

        $count_all = 0;
        $count1_all = 0;
        $count2_all = 0;
        $count3_all = 0;

        foreach ($data_category as $cate) {
            $count1 = 0;
            $count2 = 0;
            $count3 = 0;
            $count = 0;
            $count4 = 0;
            foreach ($data_documents as $babi) {
                if ($babi['Document']['category_id'] == $cate['Category']['category_id']) {
                    $count++;
                    foreach ($data_audit_details as $bibi) {
                        if ($bibi['Audit_detail']['document_id'] == $babi['Document']['document_id']) {
                            if ($bibi['Audit_detail']['judgment'] == 1)
                                $count1++;
                            if ($bibi['Audit_detail']['judgment'] == 2)
                                $count2++;
                            if ($bibi['Audit_detail']['judgment'] == 3)
                                $count3++;
                        }
                    }
                }
            }
            if ($count1 > 0 || $count2 > 0 || $count3 > 0) {
                $count = $count1 + $count2 + $count3;
            }
            if ($count > 0) {
                if ($count != $count1 + $count2 + $count3) {
                    $status_change_ok = 0;
                }
            }
            $count_all = $count_all + $count;
            $count1_all = $count1_all + $count1;
            $count2_all = $count2_all + $count2;
            $count3_all = $count3_all + $count3;
        }
        $this->set('count_all', $count_all);
        $this->set('count1_all', $count1_all);
        $this->set('count2_all', $count2_all);
        $this->set('count3_all', $count3_all);
    }

    public function report_edit() {
        $this->layout = '';
        $audit_id = $this->request->pass['0'];
        //debug($audit_id);die;
        $someone = $this->AuditManager->find('first', array(
            'conditions' => array('audit_id' => $audit_id)
        ));
        //  	debug($someone);die;

        $user_create = $this->User->find('first', array('conditions' => array('User.user_id' => $someone['AuditManager']['audit_create_user'])));
        $this->set('user_create', $user_create);

        if ($someone['AuditManager']['status'] == 0) {
            $this->set('data_status', '未実施');
        } else if ($someone['AuditManager']['status'] == 1) {
            $this->set('data_status', '監査完了');
        } else if ($someone['AuditManager']['status'] == 2) {
            $this->set('data_status', '承認待ち');
        } else if ($someone['AuditManager']['status'] == 3) {
            $this->set('data_status', '是正中');
        } else if ($someone['AuditManager']['status'] == 4) {
            $this->set('data_status', '実施中');
        }
        $this->set('data', $someone);

        $data_store = $this->Store->find('all', array('conditions' => array('Store.store_id' => $someone['AuditManager']['store_id'])));
        $this->set('stores', $data_store);
        // debug($data_store);

        $data_property = $this->Property->find('all', array('conditions' => array('Property.puroperty_id' => $data_store['0']['Store']['property_id'])));
        $this->set('property', $data_property);

        $data_item = $this->Item->find('all', array('conditions' => array('Item.item_id' => $someone['AuditManager']['item_id'])));
        $this->set('items', $data_item);
        //debug($data_item);die;

        $data_audit_file = $this->Audit_file->find('all', array('conditions' => array('Audit_file.audit_file_id' => $someone['AuditManager']['audit_file_id'])));
        $this->set('audit_files', $data_audit_file);

        $data_category = $this->Category->find('all', array('conditions' => array('Category.item_id' => $data_item['0']['Item']['item_id'])));
        $this->set('category', $data_category);
        $arr_name_category = array();
        foreach ($data_category as $arr) {
            $arr_name_category += array($arr['Category']['category_id'] => $arr['Category']['category_name']);
        }
        $this->set('arr_name_category', $arr_name_category);

        $data_audit_details = $this->Audit_detail->find('all', array('conditions' => array('Audit_detail.audit_id' => $audit_id)));
        $this->set('data_audit_details', $data_audit_details);

        $audit_details_judgment = $this->Audit_detail->find('all', array('conditions' => array('Audit_detail.audit_id' => $audit_id, 'Audit_detail.judgment' => '3')));
        //debug($audit_details_judgment);
        $data_documents_judgment = array();
        foreach ($audit_details_judgment as $audit_judgment) {
            $arr_data = $this->Document->find('all', array(
                'conditions' => array('Document.document_id' => $audit_judgment['Audit_detail']['document_id']),
                'fields' => array('document_id', 'category_id', 'contents', 'document_no'),
                'order' => array('category_id' => 'asc', 'document_no' => 'asc')
            ));
            foreach ($arr_data as $arr) {
                array_push($data_documents_judgment, $arr);
            }
        }
        $this->set('data_documents_judgment', $data_documents_judgment);

        $data_documents = $this->Document->find('all', array(
            'conditions' => array('Document.item_id' => $someone['AuditManager']['item_id']),
            'fields' => array('document_id', 'category_id'),
            'order' => array('category_id' => 'asc', 'document_no' => 'asc')
        ));
        $this->set('data_documents', $data_documents);

        $count_all = 0;
        $count1_all = 0;
        $count2_all = 0;
        $count3_all = 0;

        foreach ($data_category as $cate) {
            $count1 = 0;
            $count2 = 0;
            $count3 = 0;
            $count = 0;
            $count4 = 0;
            foreach ($data_documents as $babi) {
                if ($babi['Document']['category_id'] == $cate['Category']['category_id']) {
                    $count++;
                    foreach ($data_audit_details as $bibi) {
                        if ($bibi['Audit_detail']['document_id'] == $babi['Document']['document_id']) {
                            if ($bibi['Audit_detail']['judgment'] == 1)
                                $count1++;
                            if ($bibi['Audit_detail']['judgment'] == 2)
                                $count2++;
                            if ($bibi['Audit_detail']['judgment'] == 3)
                                $count3++;
                        }
                    }
                }
            }
            if ($count1 > 0 || $count2 > 0 || $count3 > 0) {
                $count = $count1 + $count2 + $count3;
            }
            if ($count > 0) {
                if ($count != $count1 + $count2 + $count3) {
                    $status_change_ok = 0;
                }
            }
            $count_all = $count_all + $count;
            $count1_all = $count1_all + $count1;
            $count2_all = $count2_all + $count2;
            $count3_all = $count3_all + $count3;
        }
        $this->set('count_all', $count_all);
        $this->set('count1_all', $count1_all);
        $this->set('count2_all', $count2_all);
        $this->set('count3_all', $count3_all);
    }

    // function get data conditions search
    public function get_conditions_search() {
        $this->layout = 'user';
        $page_tittle = "監査表検索";
        $this->set("page_tittle", $page_tittle);

        if ($this->request->is('post')) {
            $data = $this->request->data;
            $this->Cookie->write("audit_searchForm", $data);
        }
        return $this->redirect(array('action' => 'search'));
    }

    // Search Audit of Store
    public function search() {
        $this->layout = 'user';
        $page_tittle = "監査表検索";
        $this->set("page_tittle", $page_tittle);

        $item_all = $this->Item->find('all');
        $this->set('item_all', $item_all);
        $arr_item_data = array();
        foreach ($item_all as $items) {
            $arr_item_data += array($items['Item']['item_id'] => $items['Item']['name']);
        }
        $this->set('arr_item_data', $arr_item_data);
        $arr_list_user_creater = $this->Audit->find('list', array('fields' => array('audit_create_user', 'audit_create_user'),
            'group' => array('audit_create_user'),
        ));

        $user_all = $this->User->find('all', array('conditions' => array('user_id' => $arr_list_user_creater)));
        $this->set('user_all', $user_all);
        $property_all = $this->Property->find('all');
        $this->set('property_all', $property_all);

        $data1 = array();
        $conditions_audit = array();
        $start_f = 0;
        $data_search = $this->Cookie->read('audit_searchForm');
//   	debug($data_search);
        if (isset($data_search)) {
            if ($data_search['AuditManager']['item'] != '') {
                $data1['Search']['item_id'] = $data_search['AuditManager']['item'];
                $data1['Search']['user_id'] = $data_search['AuditManager']['user'];
                $data1['Search']['property_id'] = $data_search['AuditManager']['property'];
                $data1['Search']['store_no'] = $data_search['AuditManager']['store_no'];
                $data1['Search']['store_name'] = $data_search['AuditManager']['store_name'];
                $data1['Search']['status'] = $data_search['AuditManager']['status'];
                $data1['Search']['correct_value'] = $data_search['AuditManager']['correct_value'];
                $data1['Search']['impossible'] = $data_search['AuditManager']['impossible'];
                $data1['Search']['date_type'] = $data_search['AuditManager']['date_type'];
                $data1['Search']['date1'] = $data_search['AuditManager']['date1'];
                $data1['Search']['date2'] = $data_search['AuditManager']['date2'];
                $start_f = 0;

                $conditions_store = array();
                $store_name = $data_search['AuditManager']['store_name'];
                if ($data_search['AuditManager']['store_no'] != '') {
                    $conditions_store += array('Store.store_no' => $data_search['AuditManager']['store_no']);
                }
                if ($data_search['AuditManager']['property'] != '') {
                    $conditions_store += array('Store.property_id' => $data_search['AuditManager']['property']);
                }
                if ($store_name != '') {
                    $conditions_store += array('Store.name LIKE' => "%$store_name%");
                }

                $store_search = $this->Store->find('all', array('conditions' => $conditions_store));
                $this->set('data_store', $store_search);
                //   		debug($store_search);die;

                $arr_store_id = array();
                //   		debug($store_search);
                $arr_store_data = array();
                foreach ($store_search as $stores) {
                    array_push($arr_store_id, $stores ['Store'] ['store_id']);
                    $arr_store_data += array($stores ['Store'] ['store_id'] => $stores ['Store'] ['name']);
                }
                $this->set('arr_store_data', $arr_store_data);

                $conditions_audit += array('Audit.store_id' => $arr_store_id);
                if ($data_search ['AuditManager'] ['item'] != '') {
                    $conditions_audit += array('Audit.item_id' => $data_search ['AuditManager'] ['item']);
                }
                if ($data_search ['AuditManager'] ['user'] != '') {
                    $conditions_audit += array('Audit.audit_create_user' => $data_search ['AuditManager'] ['user']);
                }
                if ($data_search ['AuditManager'] ['status'] != '') {
                    $conditions_audit += array('Audit.status' => $data_search ['AuditManager'] ['status']);
                }
                if ($data_search ['AuditManager'] ['impossible'] != '') {
                    if ($data_search ['AuditManager'] ['impossible'] == '0') {
                        $conditions_audit += array('Audit.impossible' => $data_search ['AuditManager'] ['impossible']);
                    } else {
                        $conditions_audit += array('Audit.impossible >=' => $data_search ['AuditManager'] ['impossible']);
                    }
                }
                if ($data_search['AuditManager']['correct_value'] != '') {
                    $conditions_audit += array('Audit.correct_value' => $data_search['AuditManager']['correct_value']);
                }

                if ($data_search['AuditManager']['date1'] != '' && $data_search['AuditManager']['date2'] == '') {
                    //debug($data_search['AuditManager']['date1']);
                    $date_check = str_replace('年', '-', $data_search['AuditManager']['date1']);
                    $date_check = str_replace('月', '-', $date_check);
                    $date_check = str_replace('日', '', $date_check);

                    $date1 = $date_check;
                    //$date1 = $date1->format('Y-m-d');
                    //debug($date1);die();
                    if ($data_search['AuditManager']['date_type'] == 1) {
                        $conditions_audit += array('Audit.audit_scheduled_date >=' => $date1);
                    }
                    if ($data_search['AuditManager']['date_type'] == 2) {
                        $conditions_audit += array('Audit.audit_scheduled_date >=' => $date1);
                    }
                    if ($data_search['AuditManager']['date_type'] == 3) {
                        $conditions_audit += array('Audit.correct_information_date >=' => $date1);
                    }
                }

                if ($data_search['AuditManager']['date1'] == '' && $data_search['AuditManager']['date2'] != '') {
                    //$date2 = new DateTime($data_search['AuditManager']['date2']);
                    //$date2 = $date2->format('Y-m-d');
                    //debug($date1);die();
                    $date_check = str_replace('年', '-', $data_search['AuditManager']['date2']);
                    $date_check = str_replace('月', '-', $date_check);
                    $date_check = str_replace('日', '', $date_check);
                    $date2 = $date_check;
                    if ($data_search['AuditManager']['date_type'] == 1) {
                        $conditions_audit += array('Audit.audit_scheduled_date <=' => $date2);
                    }
                    if ($data_search['AuditManager']['date_type'] == 2) {
                        $conditions_audit += array('Audit.audit_scheduled_date <=' => $date2);
                    }
                    if ($data_search['AuditManager']['date_type'] == 3) {
                        $conditions_audit += array('Audit.correct_information_date <=' => $date2);
                    }
                }

                if ($data_search['AuditManager']['date1'] != '' && $data_search['AuditManager']['date2'] != '') {
                    $date_check = str_replace('年', '-', $data_search['AuditManager']['date1']);
                    $date_check = str_replace('月', '-', $date_check);
                    $date_check = str_replace('日', '', $date_check);

                    $date1 = $date_check;
                    //$date1 = new DateTime($data_search['AuditManager']['date1']);
                    //$date1 = $date1->format('Y-m-d');
                    //$date2 = new DateTime($data_search['AuditManager']['date2']);
                    //$date2 = $date2->format('Y-m-d');
                    $date_check = str_replace('年', '-', $data_search['AuditManager']['date2']);
                    $date_check = str_replace('月', '-', $date_check);
                    $date_check = str_replace('日', '', $date_check);
                    $date2 = $date_check;
                    if ($data_search['AuditManager']['date_type'] == 1) {
                        $conditions_audit += array('Audit.audit_scheduled_date <=' => $date2, 'Audit.audit_scheduled_date >=' => $date1);
                    }
                    if ($data_search['AuditManager']['date_type'] == 2) {
                        $conditions_audit += array('Audit.approval_date <=' => $date2, 'Audit.approval_date >=' => $date1);
                    }
                    if ($data_search['AuditManager']['date_type'] == 3) {
                        $conditions_audit += array('Audit.correct_information_date <=' => $date2, 'Audit.correct_information_date >=' => $date1);
                    }
                }
                $audit_find_all = $this->Audit->find('all', array('conditions' => $conditions_audit));

                if (count($audit_find_all) == 0) {
                    $this->set('message_data_null', '検索結果はありません。再検索してください。');
                }
            } else {
                $this->set('error_message', '[ジャンル]選択がありません。');
                $data1['Search']['item_id'] = $data_search['AuditManager']['item'];
                $data1['Search']['user_id'] = $data_search['AuditManager']['user'];
                $data1['Search']['property_id'] = $data_search['AuditManager']['property'];
                $data1['Search']['store_no'] = $data_search['AuditManager']['store_no'];
                $data1['Search']['store_name'] = $data_search['AuditManager']['store_name'];
                $data1['Search']['status'] = $data_search['AuditManager']['status'];
                $data1['Search']['correct_value'] = $data_search['AuditManager']['correct_value'];
                $data1['Search']['impossible'] = $data_search['AuditManager']['impossible'];
                $data1['Search']['date_type'] = $data_search['AuditManager']['date_type'];
                $data1['Search']['date1'] = $data_search['AuditManager']['date1'];
                $data1['Search']['date2'] = $data_search['AuditManager']['date2'];
                $start_f = 1;
            }
            //$this->Cookie->delete('audit_searchForm');
        }//end if(isset($data_search))
        else {
            $data1['Search']['item_id'] = '';
            $data1['Search']['user_id'] = '';
            $data1['Search']['property_id'] = '';
            $data1['Search']['store_no'] = '';
            $data1['Search']['store_name'] = '';
            $data1['Search']['status'] = '';
            $data1['Search']['correct_value'] = '';
            $data1['Search']['impossible'] = '';
            $data1['Search']['date_type'] = '1';
            $data1['Search']['date1'] = '';
            $data1['Search']['date2'] = '';
            $start_f = 1;
        }
        $this->set('data1', $data1);

//   	debug($conditions_audit);die;
        $this->paginate = array(
            'limit' => '10',
            'conditions' => $conditions_audit,
            'order' => array('audit_id' => 'asc')
        );

        $audit_find_all = $this->Audit->find('all', array('conditions' => $conditions_audit));
        $this->set('audit_find_all', $audit_find_all);
        $this->Cookie->write('data_export', $audit_find_all);

        $this->Cookie->write('conditions_search', $conditions_audit);

        $datas = $this->paginate('Audit');
        if ($start_f == 0 && count($audit_find_all) > 0) {
            $this->set('data', $datas);
        }
        //debug($datas);die;
    }

// end function search()

    public function search_file() {
        $this->layout = 'ajax';
        if ($this->request->is('post')) {
            $data = $this->request->data;
            $id = $data['id'];
            $someone = $this->Audit_file->find('all', array(
                'conditions' => array('audit_id' => $id),
                'fields' => array('audit_file_id', 'audit_id', 'audit_file_name')
            ));
            $this->set('fileuploads', $someone);
        }
    }

    /*     * **********************************
      /*
      /*		CSV
      /*
      /**************** */

    public function get_data_export() {
        $arr_data_export1 = $this->Cookie->read('conditions_search');

        $audit_find_all2 = $this->Audit->find('all', array('conditions' => $arr_data_export1));
        return $audit_find_all2;
    }

    public function export() {
        $this->autoRender = false;
        $audit_data = $this->get_data_export();
        $this->Cookie->delete('conditions_search');

        $fix_header = array(
            'ジャンル',
            '店番',
            '属性',
            '店舗名',
            '監査予定日',
            '監査日',
            '承認日',
            '是正通知日',
            '是正完了予定日',
            '是正完了日',
            '監査完了日',
            '状態',
            '監査項目数',
            '良数',
            '可数',
            '不可数',
            '是正有無',
            '担当者名',
            '承認者名'
        );


        switch ($audit_data['0']['Audit']['item_id']) {
            /* 現金実査表 */
            case '1':
                /* Headers */
                $mov_header = $this->header_category(1);

                $all_headers = array();
                $all_headers = $fix_header;

                foreach ($mov_header as $_head) {
                    array_push($all_headers, $_head[1], $_head[2], $_head[3]);
                }
                $this->Csv->addRow($all_headers);

                foreach ($audit_data as $audit_item) {
                    $this->export_records($audit_item, $mov_header);
                }

                echo $this->Csv->export(true);
                break;

            /* 臨店チェックシート */
            case '2':
                /* Headers 1 + 2 */
                $cat_header_1 = $this->header_category(1);
                $cat_header_2 = $this->header_category(2);

                $mov_header = $cat_header_1 + $cat_header_2;

                /* Writing hearders to csv */
                $all_headers = array();
                $all_headers = $fix_header;
                foreach ($cat_header_1 as $_head) {
                    array_push($all_headers, $_head[1], $_head[2], $_head[3]);
                }

                foreach ($cat_header_2 as $_head) {
                    array_push($all_headers, $_head[1], $_head[2], $_head[3]);
                }

                $this->Csv->addRow($all_headers);
                foreach ($audit_data as $audit_item) {
                    $this->export_records($audit_item, $mov_header);
                }

                echo $this->Csv->export(true);

                break;

            /* 　現物実査表　 */
            case '3':
                /* Headers */
                $mov_header = $this->header_category(3);

                $all_headers = array();
                $all_headers = $fix_header;

                foreach ($mov_header as $_head) {
                    array_push($all_headers, $_head[1], $_head[2], $_head[3]);
                }
                $this->Csv->addRow($all_headers);

                foreach ($audit_data as $audit_item) {
                    $this->export_records($audit_item, $mov_header);
                }

                echo $this->Csv->export(true);

                break;

            default:
                $error_sms = array("検索したジャンルが間違っている。再確認してください。");
                $this->Csv->addRow($error_sms);
                echo $this->Csv->export(true);
                break;
        }
    }

    /*     * **********************************
      /*
      /*		固定ヘッダーレコードを作成
      /*
      /**************** */

    public function fix_headers_records($audit_item) {
        /* ジャンル */
        if ($audit_item['Audit']['item_id']) {
            $item_name = $this->Item->find('all', array(
                'fields' => array('name'),
                'conditions' => array('item_id' => $audit_item['Audit']['item_id'])
                    )
            );

            if (count($item_name) > 0) {
                $fix_headers_records['ジャンル'] = $item_name[0]['Item']['name'];
            }
        } else {
            $fix_headers_records['ジャンル'] = '';
        }

        /* 店番 */
        $fix_headers_records['店番'] = $audit_item['Audit']['store_id'];

        /* 店舗名と属性　 */
        if ($audit_item['Audit']['store_id']) {
            $store_name = $this->Store->find('all', array(
                'fields' => array('name', 'property_id'),
                'conditions' => array('store_id' => $audit_item['Audit']['store_id'])
                    )
            );

            if (count($store_name) > 0) {
                $property_name = $this->Property->find('all', array(
                    'fields' => array('name'),
                    'conditions' => array('puroperty_id' => $store_name[0]['Store']['property_id'])
                        )
                );

                $fix_headers_records['属性'] = $property_name[0]['Property']['name'];
                $fix_headers_records['店舗名'] = $store_name[0]['Store']['name'];
            } else {
                $fix_headers_records['属性'] = '';
                $fix_headers_records['店舗名'] = '';
            }
        } else {
            $fix_headers_records['属性'] = '';
            $fix_headers_records['店舗名'] = '';
        }

        /* 　監査日 */
        $fix_headers_records['監査予定日'] = $audit_item['Audit']['audit_scheduled_date'];
        $fix_headers_records['監査日'] = $audit_item['Audit']['audit_date'];
        $fix_headers_records['承認日'] = $audit_item['Audit']['approval_date'];
        $fix_headers_records['是正通知日'] = $audit_item['Audit']['correct_information_date'];
        $fix_headers_records['是正完了予定日'] = $audit_item['Audit']['correct_end_scheduled_date'];
        $fix_headers_records['是正完了日'] = $audit_item['Audit']['correct_end_date'];
        $fix_headers_records['監査完了日'] = $audit_item['Audit']['audit_end_date'];


        /* 状態 */
        switch ($audit_item['Audit']['status']) {
            case '0':
                $fix_headers_records['状態'] = '未実地';
                break;
            case '1':
                $fix_headers_records['状態'] = '監査完了';
                break;
            case '2':
                $fix_headers_records['状態'] = '承認待ち';
                break;
            case '3':
                $fix_headers_records['状態'] = '是正中';
                break;
            case '4':
                $fix_headers_records['状態'] = '実地中';
                break;
            default:
                $fix_headers_records['状態'] = '';
                break;
        }

        /* 監査項目数　 */
        $fix_headers_records['監査項目数'] = '';
        $fix_headers_records['良数'] = '';
        $fix_headers_records['可数'] = '';
        $fix_headers_records['不可数'] = '';


        /* 是正有無 */
        if ($audit_item['Audit']['correct_value']) {
            $fix_headers_records['是正有無'] = 'あり';
        } else {
            $fix_headers_records['是正有無'] = 'なし';
        }

        /* 担当者名 */
        if ($audit_item['Audit']['audit_create_user']) {
            $create_user = $this->User->find('all', array(
                'fields' => array('user_name'),
                'conditions' => array('user_id' => $audit_item['Audit']['audit_create_user'])
                    )
            );

            if (count($create_user) > 0) {
                $fix_headers_records['担当者名'] = $create_user[0]['User']['user_name'];
            }
        } else {
            $fix_headers_records['担当者名'] = '';
        }

        /* 承認者名 */
        if ($audit_item['Audit']['approver']) {
            $approver = $this->User->find('all', array(
                'fields' => array('user_name'),
                'conditions' => array('user_id' => $audit_item['Audit']['approver'])
                    )
            );

            if (count($approver) > 0) {
                $fix_headers_records['承認者名'] = $approver[0]['User']['user_name'];
            }
        } else {
            $fix_headers_records['承認者名'] = '';
        }

        return $fix_headers_records;
    }

    /*     * **********************************
      /*
      /*		ジャンルヘッダー
      /*
      /**************** */

    public function header_category($category_id) {
        $category_item = $this->Category->find('all', array('conditions' => array('Category.item_id' => $category_id)));

        $cat_header = array();
        foreach ($category_item as $_item) {
            $_id = $_item['Category']['category_id'];
            $cat_header[$_id]['0'] = $_item['Category']['category_id'];
            $cat_header[$_id]['1'] = '[' . $_item['Category']['category_name'] . ']良';
            $cat_header[$_id]['2'] = '[' . $_item['Category']['category_name'] . ']可';
            $cat_header[$_id]['3'] = '[' . $_item['Category']['category_name'] . ']不可';
        }

        return $cat_header;
    }

    /* Group documents to the same category */

    public function group_doc_to_category($document_ids) {
        /* Recreate document_id for sql search */
        $doc_ids = array();
        foreach ($document_ids as $key) {
            $doc_ids[] = (int) $key['Audit_detail']['document_id'];
        }

        $category_ids = $this->Document->find('all', array(
            'fields' => array('DISTINCT category_id'),
            'conditions' => array('Document.document_id' => $doc_ids)
                )
        );


        $cat_docid = array();
        foreach ($category_ids as $cat_id) {
            $_id = $cat_id['Document']['category_id'];
            $cat_docid[$_id]['0'] = $cat_id['Document']['category_id'];
            $cat_docid[$_id]['1'] = $this->Document->find('all', array(
                'fields' => array('document_id'),
                'conditions' => array('Document.category_id' => $cat_id['Document']['category_id']),
                    )
            );
        }

        return $cat_docid;
    }

    /*     * **********************************
      /*
      /*		レコードからCSVへ
      /*
      /**************** */

    /* Start Counting records by its categories matching with its headers */

    public function export_records($audit_item, $mov_header) {

        /* 監査項目数 */
        $audit_number = 0;
        $audit_good = 0;
        $audit_possible = 0;
        $audit_impossible = 0;

        $fix_header_rec = $this->fix_headers_records($audit_item);

        /* search all doc in audit_details */
        $document_ids = $this->Audit_detail->find('all', array(
            'fields' => array('Audit_detail.document_id', 'Audit_detail.judgment'),
            'conditions' => array('Audit_detail.audit_id' => $audit_item['Audit']['audit_id']
            ))
        );

        $cat_docid = $this->group_doc_to_category($document_ids);

        $mov_records = array();
        foreach ($mov_header as $_header) {
            $_found = false;
            foreach ($cat_docid as $_id) { /* Search each available category */
                if ($_header[0] == $_id['0']) { /* matching header position & category */

                    $_found = TRUE;
                    $j_good = 0;
                    $j_possible = 0;
                    $j_impossible = 0;
                    $j_undone = 0;

                    foreach ($_id[1] as $_doc) { /* Search in each category */
                        foreach ($document_ids as $_ids) { /* match document and take judgement */
                            if ($_doc['Document']['document_id'] == $_ids['Audit_detail']['document_id']) {
                                $audit_number += 1;
                                switch ($_ids['Audit_detail']['judgment']) {
                                    case '1':
                                        $j_good += 1;
                                        $audit_good += 1;
                                        break;
                                    case '2':
                                        $j_possible += 1;
                                        $audit_possible += 1;
                                        break;
                                    case '3':
                                        $j_impossible += 1;
                                        $audit_impossible += 1;
                                        break;
                                    default:
                                        $j_undone += 1;
                                        break;
                                }
                            }
                        }
                    } /* end foreach */
                } /* End if */

                /* write out array */
                if ($_found) {
                    $mov_records[$_header[0]]['1'] = $j_good;
                    $mov_records[$_header[0]]['2'] = $j_possible;
                    $mov_records[$_header[0]]['3'] = $j_impossible;
                } else {
                    $mov_records[$_header[0]]['1'] = '';
                    $mov_records[$_header[0]]['2'] = '';
                    $mov_records[$_header[0]]['3'] = '';
                }
            }
        } /* end of counting records */

        /* Add Fix header records */
        $fix_header_rec['良数'] = $audit_good;
        $fix_header_rec['可数'] = $audit_possible;
        $fix_header_rec['不可数'] = $audit_impossible;
        $fix_header_rec['監査項目数'] = $audit_number;

        /* fix_headers_records */
        $all_records = array();
        foreach ($fix_header_rec as $_h) {
            array_push($all_records, $_h);
        }

        /* data records */
        foreach ($mov_records as $_rec) {
            array_push($all_records, $_rec[1], $_rec[2], $_rec[3]);
        }

        /* Write out to csv */
        $this->Csv->addRow($all_records);
    }

    function mb_rawurlencode($url) {
        $encoded = '';
        $length = mb_strlen($url);
        for ($i = 0; $i < $length; $i++) {
            $encoded.='%' . wordwrap(bin2hex(mb_substr($url, $i, 1)), 2, '%', true);
        }
        return $encoded;
    }

    public function download() {
        //mb_internal_encoding('UTF-8');
//    mb_http_output('UTF-8');
//    mb_http_input('UTF-8');
//    mb_language('uni');
//    mb_regex_encoding('UTF-8');
//    ob_start('mb_output_handler');
        $num = $u_id = $this->request->pass['0'];
        $aryfile = $this->Audit_file->find('first', array('conditions' => array('Audit_file.audit_file_id' => $num)));
        $file = $aryfile['Audit_file']['audit_file_path'];
        $fileOutput = $aryfile['Audit_file']['audit_file_name'];
        $file = 'files/audits' . DS . $file;
        if (isset($_SERVER['HTTP_USER_AGENT']) && (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== false)) {
            $fileOutputTmp = explode('.pdf', $fileOutput);
            $fileOutput = $this->mb_rawurlencode($fileOutput);
            // $fileOutput .= '.pdf';
        }
        if (file_exists($file)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Type: application/msword');
            header("Content-Type: application/force-download");
            header('Content-Disposition: attachment; filename=' . $fileOutput);
            header('Content-Transfer-Encoding: binary');
            header('Pragma: public');
            header('Cache-Control: max-age=0');
            header('Content-Length: ' . filesize($file));
            ob_clean();
            flush();
            readfile($file);
            exit;
        } else {
            echo 'File does not exist';
            exit;
        }
    }

}

?>
