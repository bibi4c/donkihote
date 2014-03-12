<?php

App::uses('AppModel', 'Model');

/**
 * Teacher Model
 */
class Document extends AppModel {

    var $useTable = 'documents';
    public $primaryKey = 'document_id';

    /**
     * Validation rules
     */
    public $validate = array(
        'item' => array(
            'notempty' => array(
                'rule' => array('notempty'),
                'message' => '[ジャンル]入力がありません。'
            )
        ),
        'category' => array(
            'notempty' => array(
                'rule' => array('notempty'),
                'message' => ' [カテゴリ]入力がありません。',
            )
        ),
        'transfer_flag' => array(
            'notempty' => array(
                'rule' => array('notEmpty'),
                'message' => '[引き継ぎ対象]選択がありません。'
            )
        ),
        'start_date' => array(
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
//		'end_date' => array(
//				'date' => array(
//						'rule' => array('date', 'ymd'),
//						'message' => '[有効終了日]日の形式で入力してください。',
//						'allowEmpty' => true
//				),
//				'min' => array(
//						'rule' => array('minLength', 10),
//						'message' => '[有効開始日]日の形式で入力してください。',
//						'allowEmpty' => true
//				),
//				'max' => array(
//						'rule' => array('maxLength', 10),
//						'message' => '[有効開始日]日の形式で入力してください。',
//						'allowEmpty' => true
//				),
//		),
        'contents' => array(
            'notempty' => array(
                'rule' => array('notempty'),
                'message' => '[内容]入力がありません。'
            ),
        )
    );

}
