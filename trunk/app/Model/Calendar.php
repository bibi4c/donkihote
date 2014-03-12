<?php

App::uses('AppModel', 'Model');

/**
 * Teacher Model
 */
class Calendar extends AppModel {

    var $useTable = 'audits';
    public $primaryKey = 'audit_id';

    /**
     * Validation rules
     */
    public $validate = array(
        'store_id' => array(
            'notempty' => array(
                'rule' => array('notempty'),
                'message' => '[店舗]選択がありません。'
            )
        ),
        'item_id' => array(
            'notempty' => array(
                'rule' => array('notempty'),
                'message' => ' [ジャンル]選択がありません。',
            )
        ),
    );

}
