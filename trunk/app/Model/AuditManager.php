<?php

App::uses('AppModel', 'Model');

/**
 * Teacher Model
 */
class AuditManager extends AppModel {

    var $useTable = 'audits';
    public $primaryKey = 'audit_id';
    public $validate = array(
        'comment' => array(
            'max' => array(
                'rule' => array('maxLength', 512),
                'message' => '[コメント]512文字以内で入力してください。',
            ),
        )
    );

}
