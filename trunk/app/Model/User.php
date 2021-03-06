<?php

App::uses('AppModel', 'Model');

/**
 * Teacher Model
 */
class User extends AppModel {

    var $useTable = 'users';
    public $primaryKey = 'no';

    /**
     * Validation rules
     */
    public $validate = array(
        'password' => array(
            'notempty' => array(
                'rule' => array('notempty'),
                'message' => '[パスワード]入力がありません。'
            ),
            'min' => array(
                'rule' => array('minLength', 6),
                'message' => '[パスワード]６文字以上で入力してください。',
            ),
            'max' => array(
                'rule' => array('maxLength', 12),
                'message' => '[パスワード]12文字以下で入力してください。',
            ),
        ),
        'user_id' => array(
            'notempty' => array(
                'rule' => array('notempty'),
                'message' => ' [ID]入力がありません。',
            ),
            'min' => array(
                'rule' => array('minLength', 6),
                'message' => '[ID]６文字で入力してください。',
            ),
            'max' => array(
                'rule' => array('maxLength', 6),
                'message' => '[ID]6文字で入力してください。',
            ),
            'unique' => array(
                'rule' => array('isUnique'),
                'message' => '[ID]既に登録されています。',
            ),
        ),
        'user_name' => array(
            'notempty' => array(
                'rule' => array('notempty'),
                'message' => '[名前]入力がありません。'
            ),
            'max' => array(
                'rule' => array('maxLength', 30),
                'message' => '[名前]30文字以下で入力してください。',
            ),
        ),
        'authority_id' => array(
            'notempty' => array(
                'rule' => array('notempty'),
                'message' => '[権限]入力がありません。'
            )
        ),
        'mail_address' => array(
            'notempty' => array(
                'rule' => array('notempty'),
                'message' => '[メールアドレス]入力がありません。'
            ),
            'email' => array(
                'rule' => 'email',
                'message' => '[メールアドレス]メールアドレスの形式で入力してください。',
            ),
        ),
        'valid_flag' => array(
            'notempty' => array(
                'rule' => array('notempty'),
                'message' => '[有効／無効]入力がありません。'
            )
        ),
    );

}
