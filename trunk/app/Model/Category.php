<?php

App::uses('AppModel', 'Model');

/**
 * Teacher Model
 */
class Category extends AppModel {

    var $useTable = 'categories';
    public $primaryKey = 'category_id';
    public $validate = array(
        'valid_flag' => array(
            'notempty' => array(
                'rule' => array('notempty'),
                'message' => '[店舗]選択がありません。'
            )
        ),
    );

}
