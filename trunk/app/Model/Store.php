<?php

App::uses('AppModel', 'Model');

/**
 * Teacher Model
 */
class Store extends AppModel {

    var $useTable = 'stores';
    public $primaryKey = 'store_id';

    /**
     * Validation rules
     */
    public $validate = array(
        'store_no' => array(
            'notempty' => array(
                'rule' => array('notempty'),
                'message' => '[店番]入力がありません。'
            ),
            'min' => array(
                'rule' => array('minLength', 4),
                'message' => '[店番]4文字で入力してください。',
            ),
            'max' => array(
                'rule' => array('maxLength', 4),
                'message' => '[店番]4文字で入力してください。',
            ),
        ),
        'name' => array(
            'notempty' => array(
                'rule' => array('notempty'),
                'message' => ' [店舗名]入力がありません。',
            ),
            'max' => array(
                'rule' => array('maxLength', 30),
                'message' => '[店舗名]30以下で入力してください。',
            )
        ),
        'puroperty_id' => array(
            'notempty' => array(
                'rule' => array('notempty'),
                'message' => '[属性]入力がありません。'
            )
        ),
        'valid_start_day' => array(
            'notempty' => array(
                'rule' => array('notempty'),
                'message' => '[有効開始日]入力がありません。'
            ),
//			'date' => array(
//				'rule' => array('date', 'ymd'),
//				'message' => '[有効開始日]日の形式で入力してください。',
//			),
//			'min' => array(
//					'rule' => array('minLength', 10),
//					'message' => '[有効開始日]日の形式で入力してください。',
//			),
//			'max' => array(
//					'rule' => array('maxLength', 10),
//					'message' => '[有効開始日]日の形式で入力してください。',
//			),
        ),
        'valid_end_day' => array(
//					'date' => array(
//						'rule' => array('date', 'ymd'),
//						'message' => '[有効終了日]日の形式で入力してください。',
//						'allowEmpty' => true
//					),
//					'min' => array(
//							'rule' => array('minLength', 10),
//							'message' => '[有効開始日]日の形式で入力してください。',
//							'allowEmpty' => true
//					),
//					'max' => array(
//							'rule' => array('maxLength', 10),
//							'message' => '[有効開始日]日の形式で入力してください。',
//							'allowEmpty' => true
//					),
        ),
    );

}
