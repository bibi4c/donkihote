<?php

App::uses('AppModel', 'Model');

/**
 * Teacher Model
 */
class Audit extends AppModel {

    var $useTable = 'audits';
    public $primaryKey = 'audit_id';

}
