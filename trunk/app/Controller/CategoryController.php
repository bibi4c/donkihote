<?php

class CategoryController extends AppController {

    var $uses = array('Category', 'Property', 'Document', 'Audit_detail', 'Store', 'Item', 'User', 'AuditManager', 'Audit', 'Audit_detail_file');
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
        // $this->Cookie->delete('calendar_searchForm');
        if (!empty($aryUser)) {
            $this->layout = 'user';
        }
    }

    public function view() {
        $this->layout = 'user1';
        $page_tittle = "監査項目登録";
        $this->set("page_tittle", $page_tittle);

        $category_id = $this->request->pass['0'];
        $audit_id = $this->request->pass['1'];
        if (isset($this->request->pass['2'])) {
            $var11 = $this->request->pass['2'];
            $var12 = $this->request->pass['3'];
        } else {
            $var11 = 0;
            $var12 = 0;
        }

// 	debug($audit_id);
        $someone = $this->Category->find('first', array(
            'conditions' => array('category_id' => $category_id)
        ));
        //debug($someone);

        $data_audit = $this->Audit->find('all', array('conditions' => array('Audit.audit_id' => $audit_id)));
        $this->set('data_audit', $data_audit);
        $data_store = $this->Store->find('first', array('conditions' => array('Store.store_id' => $data_audit['0']['Audit']['store_id']), 'fields' => array('store_no')));
        $this->set('data_store', $data_store['Store']['store_no']);
        $array_document_id = $this->Cookie->read('arr_document_id');
        //debug($array_document_id);
        $array_audit_detail = $this->Audit_detail->find('all', array(
            'conditions' => array('Audit_detail.audit_id' => $audit_id),
            'fields' => array('document_id')
        ));
        $arr_bibi = array();
        foreach ($array_audit_detail as $bibi) {
            array_push($arr_bibi, $bibi['Audit_detail']['document_id']);
        }
        if ($someone['Category']['item_id'] == 1 && isset($array_document_id)) {
            //debug($array_document_id);
            $data_document_all = $this->Document->find('all', array('conditions' => array('Document.category_id' => $category_id, 'Document.document_id' => $array_document_id)));
            //debug($data_document_all);
        } else {
            $data_document_all = $this->Document->find('all', array('conditions' => array('Document.category_id' => $category_id, 'Document.document_id' => $arr_bibi)));
        }
        $this->set('document_all', $data_document_all);

        $arr_data = array();
        $arr_data['Category']['audit_id'] = $audit_id;
        $arr_data['Category']['status'] = $data_audit['0']['Audit']['status'];
        $arr_data['Category']['category_id'] = $someone['Category']['category_id'];
        $arr_data['Category']['category_name'] = $someone['Category']['category_name'];

        $data_audit_detail_file = array();
        foreach ($data_document_all as $document) {
            $data_audit_detail_all = $this->Audit_detail->find('first', array('conditions' => array('Audit_detail.audit_id' => $audit_id, 'Audit_detail.document_id' => $document['Document']['document_id'])));
            if ($data_audit_detail_all['Audit_detail']['valid_flag'] == '' || $data_audit_detail_all['Audit_detail']['valid_flag'] == '0') {
                $arr_data['Category']['valid_flag'] = '1';
            } else {
                $arr_data['Category']['valid_flag'] = $data_audit_detail_all['Audit_detail']['valid_flag'];
            }
            //debug($data_audit_detail_all);
            $arr_data['Category']['judgment_' . $document['Document']['document_id']] = $data_audit_detail_all['Audit_detail']['judgment'];
            $arr_data['Category']['document_id_' . $document['Document']['document_id']] = $data_audit_detail_all['Audit_detail']['document_id'];
            $arr_data['Category']['contents_' . $document['Document']['document_id']] = $document['Document']['contents'];
            $arr_data['Category']['audit_' . $document['Document']['document_id']] = $data_audit_detail_all['Audit_detail']['audit_detail_id'];
            $audit_bibi = $data_audit_detail_all['Audit_detail']['audit_detail_id'];
            $data_audit_detail_file[$document['Document']['document_id']] = $this->Audit_detail_file->find('all', array('fields' => array('audit_detail_file_id', 'audit_detail_id', 'audit_detail_file_name'), 'conditions' => array('Audit_detail_file.audit_detail_id' => $audit_bibi)));
        }
        //debug($arr_data);
        $this->set('data', $arr_data);

        $this->set('data_audit_detail_file', $data_audit_detail_file);
        //debug($arr_data);
        if ($this->request->is('post')) {
            $data = $this->request->data;
// 		debug($this->request->data);die();
// 		$cancel_ok = $this->request->params['pass']['2'];
            //debug($cancel_ok);	
            if (isset($cancel_ok)) {
                $aryDataCategory = $data;
            } else {
                $err1 = 0;
                $err2 = 0;
                if (!isset($data['Category']['valid_flag'])) {
                    $err1 = 1;
                    $data['Category']['valid_flag'] = '0';
                } else {
                    if ($data['Category']['valid_flag'] == 2) {
                        $err1 = 0;
                        $err2 = 0;
                    } else {
                        foreach ($data_document_all as $document) {
                            if ($data['Category']['judgment_' . $document['Document']['document_id']] == '0') {
                                $err2 = 1;
                            }
                        }
                    }
                }
// 		debug($err1);
// 		debug($err2); die;
                if ($err1 == 0 && $err2 == 0) {
                    $this->Cookie->write("dataCategory", $data);
                    //debug($data);
                    return $this->redirect(array('controller' => 'Category', 'action' => 'change_confirm', $category_id, $audit_id, $var11, $var12));
                } else {
                    if ($err1 == 1) {
                        $this->set('err_message', '[評価有無]を選択してください。');
                    } else if ($err2 == 1) {
                        $this->set('err_message', '[評価]入力がありません。');
                    }
                }
            }
        }

        $aryDataCategory = $this->Cookie->read("dataCategory");
        if (isset($aryDataCategory)) {
            //debug($aryDataCategory);	
            // debug("sadasdasdasdas");
            $aryDataCategory['Category']['audit_id'] = $audit_id;
            $aryDataCategory['Category']['status'] = $data_audit['0']['Audit']['status'];
            $aryDataCategory['Category']['category_id'] = $someone['Category']['category_id'];
            $aryDataCategory['Category']['category_name'] = $someone['Category']['category_name'];
            foreach ($data_document_all as $document) {
                $aryDataCategory['Category']['contents_' . $document['Document']['document_id']] = $document['Document']['contents'];
                $data_audit_detail_all = $this->Audit_detail->find('all', array('conditions' => array('Audit_detail.audit_id' => $audit_id, 'Audit_detail.document_id' => $document['Document']['document_id'])));
                $aryDataCategory['Category']['audit_' . $document['Document']['document_id']] = $data_audit_detail_all['0']['Audit_detail']['audit_detail_id'];
            }
            $this->set("data", $aryDataCategory);
            //debug($aryStoreRegister);
            $this->Cookie->delete('dataCategory');
        }
    }

    public function search_file() {
        $this->layout = 'ajax';
        if ($this->request->is('post')) {
            $data = $this->request->data;
            $id = $data['id'];
            $someone = $this->Audit_detail_file->find('all', array(
                'conditions' => array('audit_detail_id' => $id),
                'fields' => array('audit_detail_file_id', 'audit_detail_id', 'audit_detail_file_name')
            ));
            $this->set('fileuploads', $someone);
        }
    }

    public function change_confirm($category_id = null, $audit_id = null) {
        $this->layout = 'user1';
        $page_tittle = "監査項目入力確認";
        $this->set("page_tittle", $page_tittle);
        $data_audit_detail_file = array();
        $category_id = $this->request->pass['0'];
        $audit_id = $this->request->pass['1'];
        // 	debug($audit_id);
        $someone = $this->Category->find('first', array(
            'conditions' => array('category_id' => $category_id)
        ));
        $array_document_id = $this->Cookie->read('arr_document_id');
        //debug($array_document_id);
        $array_audit_detail = $this->Audit_detail->find('all', array(
            'conditions' => array('Audit_detail.audit_id' => $audit_id),
            'fields' => array('document_id')
        ));
        $arr_bibi = array();
        foreach ($array_audit_detail as $bibi) {
            array_push($arr_bibi, $bibi['Audit_detail']['document_id']);
        }
        if ($someone['Category']['item_id'] == 1 && isset($array_document_id)) {
            $data_document_all = $this->Document->find('all', array('conditions' => array('Document.category_id' => $category_id, 'Document.document_id' => $array_document_id)));
        } else {
            $data_document_all = $this->Document->find('all', array('conditions' => array('Document.category_id' => $category_id, 'Document.document_id' => $arr_bibi)));
        }
        foreach ($data_document_all as $document) {
            $data_audit_detail_all = $this->Audit_detail->find('first', array('conditions' => array('Audit_detail.audit_id' => $audit_id, 'Audit_detail.document_id' => $document['Document']['document_id'])));
            $audit_bibi = $data_audit_detail_all['Audit_detail']['audit_detail_id'];
            $data_audit_detail_file[$document['Document']['document_id']] = $this->Audit_detail_file->find('all', array('fields' => array('audit_detail_file_id', 'audit_detail_id', 'audit_detail_file_name'), 'conditions' => array('Audit_detail_file.audit_detail_id' => $audit_bibi)));
        }
        $this->set('data_audit_detail_file', $data_audit_detail_file);
        $aryDataCategory = $this->Cookie->read('dataCategory');

        //debug($aryDataCategory);
        if (isset($aryDataCategory)) {

            $this->Cookie->write("audit_id", $aryDataCategory['Category']['audit_id']);
            $this->set('data', $aryDataCategory);

            if ($aryDataCategory['Category']['valid_flag'] == 1) {
                $valid = 'あり';
            } else {
                $valid = 'なし';
            }
            $this->set('valid_flag', $valid);
            if ($someone['Category']['item_id'] == 1 && isset($array_document_id)) {
                $data_document_all = $this->Document->find('all', array('conditions' => array('Document.category_id' => $aryDataCategory['Category']['category_id'], 'Document.document_id' => $array_document_id)));
            } else {
                $data_document_all = $this->Document->find('all', array('conditions' => array('Document.category_id' => $aryDataCategory['Category']['category_id'], 'Document.document_id' => $arr_bibi)));
            }
            $this->set('document_all', $data_document_all);


            if ($this->request->is('post')) {
                $data = $this->request->data;
                //debug($data);
                $aryUser = $this->Session->read('Auth.User');
                $bibi_impos = 0;
                foreach ($data_document_all as $data_document) {
                    $temp1 = $data['Category'][$data_document['Document']['document_id']];
                    $temp2 = $data['Category']['audit_id'];
                    $judgment_change = $data['Category']['judgment_' . $data_document['Document']['document_id']];
                    // debug($judgment_change);
                    $valid_change = $data['Category']['valid_flag'];
                    $date1 = "'" . date('Y-m-d H:i:s') . "'";
                    $user1 = "'" . $aryUser['user_name'] . "'";
                    $data_update = array('judgment' => $judgment_change, 'valid_flag' => $valid_change, 'user_update_date' => $date1, 'user_update_name' => $user1);
                    $data_audit_detail_all = $this->Audit_detail->find('all', array('conditions' => array('Audit_detail.audit_id' => $temp2, 'Audit_detail.document_id' => $data_document['Document']['document_id'])));
                    $data_file = $this->Audit_detail_file->find('all', array('conditions' => array('Audit_detail_file.audit_detail_id' => $data_audit_detail_all['0']['Audit_detail']['audit_detail_id'], 'Audit_detail_file.register_user' => '0')));
                    $check = $this->Audit_detail->updateAll($data_update, array('document_id' => $temp1, 'audit_id' => $temp2));

                    if ($data_audit_detail_all[0]['Audit_detail']['judgment'] != '3' && $judgment_change == '3')
                        $bibi_impos++;
                    if ($data_audit_detail_all[0]['Audit_detail']['judgment'] == '3' && $judgment_change != '3')
                        $bibi_impos--;
                    foreach ($data_file as $babi) {
                        $id = $babi['Audit_detail_file']['audit_detail_file_id'];
                        $data_update = array('register_user' => $aryUser['user_id']);
                        $check = $this->Audit_detail_file->updateAll($data_update, array('audit_detail_file_id' => $id));
                    }
                }

                if ($check) {
                    $this->Cookie->delete('dataCategory');
                    $var12 = $this->request->pass['2'];
                    $array_audit_detail1 = $this->AuditManager->find('all', array(
                        'conditions' => array('AuditManager.audit_id' => $audit_id),
                        'fields' => array('store_id', 'item_id', 'audit_create_user', 'impossible')
                    ));
                    $bibi_ttt = $array_audit_detail1[0]['AuditManager']['impossible'] + $bibi_impos;
                    $data_update = array('impossible' => $bibi_ttt);
                    $this->AuditManager->id = $audit_id;
                    $check1 = $this->AuditManager->save($data_update);
                    // debug($bibi_ttt);die();
                    if ($var12 == 102) {

                        $data_store = $this->Store->find('all', array('conditions' => array('Store.store_id' => $array_audit_detail1['0']['AuditManager']['store_id'])));
                        $data_item = $this->Item->find('all', array('conditions' => array('Item.item_id' => $array_audit_detail1['0']['AuditManager']['item_id'])));
                        $var11 = $this->request->pass['3'];
                        $data_update = array('status' => '2');
                        $this->AuditManager->id = $audit_id;
                        $check1 = $this->AuditManager->save($data_update);
                        $data_users = $this->User->find('all', array(
                            'conditions' => array('User.authority_id' => '2', 'User.valid_flag' => '1'),
                            'fields' => array('mail_address')
                        ));
                        $createUser = $this->User->find('all', array(
                            'conditions' => array('User.user_id' => $array_audit_detail1['0']['AuditManager']['audit_create_user']),
                            'fields' => array('user_name')
                        ));
                        foreach ($data_users as $user_mail) {
                            $this->__sendReportMail($user_mail['User']['mail_address'], $createUser['0']['User']['user_name'], $data_store['0']['Store']['store_no'], $data_item['0']['Item']['name']);
                        }
                    }

                    $this->redirect(array('controller' => 'AuditManager', 'action' => 'index', $audit_id));
                }
            }
        } else {
            return $this->redirect(array('controller' => 'calendar', 'action' => 'index'));
        }
    }

    private function __sendReportMail($emailAddress, $var1, $var2, $var3) {
        $mailSubject = str_replace('%%_SENDMAIL_SHOP%%', $var2, SENDMAIL_SUBJECT);
        $textBody = str_replace('%%_SENDMAIL_RECEIVER%%', $var1, SENDMAIL_CONTENT);
        $textBody = str_replace('%%_SENDMAIL_SHOP%%', $var2, $textBody);
        $textBody = str_replace('%%_SENDMAIL_GENRE%%', $var3, $textBody);

        App::uses('CakeEmail', 'Network/Email');
        $email = new CakeEmail('smtp');

        $email->from(array(SENDMAIL_SENDER_MAIL => SENDMAIL_SENDER_NAME));
        //$email->delivery = 'smtp';
        $email->to($emailAddress);
        $email->subject($mailSubject);
        $email->emailFormat('html');
        $email->send($textBody);
    }

    public function success_change() {
        $this->layout = 'user';
        $page_tittle = "監査項目登録完了";
        $this->set("page_tittle", $page_tittle);

        $audit_id = $this->Cookie->read('audit_id');
// 	debug($audit_id);die;
        $this->set('audit_id', $audit_id);
        $this->Cookie->delete('audit_id');
    }

    public function filedrag() {
        $this->layout = 'user';
        $page_tittle = "ファイル添付";
        $this->set("page_tittle", $page_tittle);
    }

    public function view1() {
        $this->layout = 'user1';
        $page_tittle = "監査項目登録";
        $this->set("page_tittle", $page_tittle);
        //debug($this->Session->read());
        $category_id = $this->request->pass['0'];
        $audit_id = $this->request->pass['1'];
        // 	debug($audit_id);
        $someone = $this->Category->find('first', array(
            'conditions' => array('category_id' => $category_id)
        ));
        //debug($someone);

        $array_document_id = $this->Cookie->read('arr_document_id');
        //debug($array_document_id);
        $array_audit_detail = $this->Audit_detail->find('all', array(
            'conditions' => array('Audit_detail.audit_id' => $audit_id),
            'fields' => array('document_id')
        ));
        $arr_bibi = array();
        foreach ($array_audit_detail as $bibi) {
            array_push($arr_bibi, $bibi['Audit_detail']['document_id']);
        }
        //debug($arr_bibi);
        if ($someone['Category']['item_id'] == 1 && isset($array_document_id)) {
            $data_document_all = $this->Document->find('all', array('conditions' => array('Document.category_id' => $category_id, 'Document.document_id' => $array_document_id)));
        } else {
            $data_document_all = $this->Document->find('all', array('conditions' => array('Document.category_id' => $category_id, 'Document.document_id' => $arr_bibi)));
        }
        $this->set('document_all', $data_document_all);

        $data_audit = $this->Audit->find('first', array('conditions' => array('Audit.audit_id' => $audit_id)));
        $this->set('data_audit', $data_audit);
        $data_store = $this->Store->find('first', array('conditions' => array('Store.store_id' => $data_audit['Audit']['store_id']), 'fields' => array('store_no')));
        $this->set('data_store', $data_store['Store']['store_no']);
        //debug($data_audit);die;

        $arr_data = array();
        $arr_data['Category']['audit_id'] = $audit_id;
        $arr_data['Category']['status'] = $data_audit['Audit']['status'];
        $arr_data['Category']['category_id'] = $someone['Category']['category_id'];
        $arr_data['Category']['category_name'] = $someone['Category']['category_name'];
        // 	$arr_data['Category']['valid_flag'] = $data_audit_detail['0']['Audit_detail']['valid_flag'];
        $data_audit_detail_file = array();
        foreach ($data_document_all as $document) {
            $data_audit_detail_all = $this->Audit_detail->find('all', array('conditions' => array('Audit_detail.audit_id' => $audit_id, 'Audit_detail.document_id' => $document['Document']['document_id'])));
            $arr_data['Category']['valid_flag'] = $data_audit_detail_all['0']['Audit_detail']['valid_flag'];
            $arr_data['Category']['judgment_' . $document['Document']['document_id']] = $data_audit_detail_all['0']['Audit_detail']['judgment'];
            $arr_data['Category']['document_id_' . $document['Document']['document_id']] = $data_audit_detail_all['0']['Audit_detail']['document_id'];
            $arr_data['Category']['contents_' . $document['Document']['document_id']] = $document['Document']['contents'];
            $arr_data['Category']['date_' . $document['Document']['document_id']] = $data_audit_detail_all['0']['Audit_detail']['user_update_date'];
            $arr_data['Category']['user_' . $document['Document']['document_id']] = $data_audit_detail_all['0']['Audit_detail']['user_update_name'];
            $arr_data['Category']['audit_' . $document['Document']['document_id']] = $data_audit_detail_all['0']['Audit_detail']['audit_detail_id'];
            $audit_bibi = $data_audit_detail_all['0']['Audit_detail']['audit_detail_id'];
            $data_audit_detail_file[$document['Document']['document_id']] = $this->Audit_detail_file->find('all', array('fields' => array('audit_detail_file_id', 'audit_detail_id', 'audit_detail_file_name'), 'conditions' => array('Audit_detail_file.audit_detail_id' => $audit_bibi)));
        }
        $this->set('data_audit_detail_file', $data_audit_detail_file);
        $this->set('data', $arr_data);
        //debug($arr_data);
        if ($this->request->is('post')) {
            $data = $this->request->data;
            //debug($data);die;
            $this->Cookie->write("dataCategory", $data);

            if ($this->Category->validates()) {
                return $this->redirect(array('controller' => 'Category', 'action' => 'change_confirm', $category_id, $audit_id));
            }
        }
        $aryDataCategory = $this->Cookie->read('dataCategory');
        if (isset($aryDataCategory)) {
            foreach ($data_document_all as $document) {
                $aryDataCategory['Category']['audit_id'] = $audit_id;
                $aryDataCategory['Category']['status'] = $data_audit['0']['Audit']['status'];
                $aryDataCategory['Category']['category_id'] = $someone['Category']['category_id'];
                $aryDataCategory['Category']['category_name'] = $someone['Category']['category_name'];
                $aryDataCategory['Category']['contents_' . $document['Document']['document_id']] = $document['Document']['contents'];
                $data_audit_detail_all = $this->Audit_detail->find('all', array('conditions' => array('Audit_detail.audit_id' => $audit_id, 'Audit_detail.document_id' => $document['Document']['document_id'])));
                $aryDataCategory['Category']['audit_' . $document['Document']['document_id']] = $data_audit_detail_all['0']['Audit_detail']['audit_detail_id'];
                $arr_data['Category']['date_' . $document['Document']['document_id']] = $data_audit_detail_all['0']['Audit_detail']['user_update_date'];
                $arr_data['Category']['user_' . $document['Document']['document_id']] = $data_audit_detail_all['0']['Audit_detail']['user_update_name'];
            }
            $this->set("data", $aryDataCategory);
            //debug($aryStoreRegister);
            $this->Cookie->delete('dataCategory');
        }
    }

    function mb_rawurlencode($url) {
        $encoded = '';
        $length = mb_strlen($url);
        for ($i = 0; $i < $length; $i++) {
            $encoded.='%' . wordwrap(bin2hex(mb_substr($url, $i, 1)), 2, '%', true);
        }
        return $encoded;
    }

    public function detail_download() {
        //mb_internal_encoding('UTF-8');
//    mb_http_output('UTF-8');
//    mb_http_input('UTF-8');
//    mb_language('uni');
//    mb_regex_encoding('UTF-8');
//    ob_start('mb_output_handler');
        $num = $u_id = $this->request->pass['0'];
        $aryfile = $this->Audit_detail_file->find('first', array('conditions' => array('Audit_detail_file.audit_detail_file_id' => $num)));
        $file = $aryfile['Audit_detail_file']['audit_detail_file_path'];
        $fileOutput = $aryfile['Audit_detail_file']['audit_detail_file_name'];
        $file = 'files/audit_details' . DS . $file;
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
