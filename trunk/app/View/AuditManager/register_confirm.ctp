<?php
// 	debug($data);
// 	die;
// debug($items_new);die;
?>
<div class="mainarea">
    <div class="error_mes clearfix" style="display:block"><h4 style="top: 10px; font-weight: bold;"> 監査を開始します。よろしければOKボタンを押してください。</h4></div><br>
    <?php echo $this->Form->create('AuditManager', array('url' => array('controller' => 'AuditManager', 'action' => 'register_confirm', $data['AuditManager']['audit_id']))); ?>
    <table id="summaryField">
        <col width="10%" />
        <col width="15%" />
        <col width="10%" />
        <col width="15%" />
        <col width="10%" />
        <col width="15%" />
        <tr>
            <th>監査予定日</th>
            <td colspan="2">
                <?php
                if (strlen($data['AuditManager']['audit_scheduled_date']) > 0) {
                    $date = $data['AuditManager']['audit_scheduled_date'];
                    $date = date('Y年n月j日', strtotime($date));
                } else
                    $date = '';
                echo $date;
                echo $this->Form->hidden('date', array('label' => false, 'value' => $data['AuditManager']['audit_scheduled_date']));
                echo $this->Form->hidden('audit_id', array('label' => false, 'value' => $data['AuditManager']['audit_id']));
                echo $this->Form->hidden('status', array('label' => false, 'value' => $data['AuditManager']['status']));
                ?>
            </td>
            <th>店舗</th>
            <td colspan="2">
                <?php
                echo $stores['0']['Store']['name'];
                echo $this->Form->hidden('store_id', array('label' => false, 'value' => $stores['0']['Store']['store_id']));
                ?>
            </td>
        </tr>
        <tr>
            <th>ジャンル</th>
            <td colspan="2">
                <?php
                echo $items['0']['Item']['name'];
                echo $this->Form->hidden('item_id', array('label' => false, 'value' => $items['0']['Item']['item_id']));
                ?>
            </td>
            <th>担当者</th>
            <td colspan="4">
                <?php
                echo $user_create['User']['user_name'];
                ?>
            </td>
        </tr>
        <tr>
            <th>前回監査実施日</th>
            <td colspan="5">
                <?php
                if ($data['AuditManager']['item_id'] == 2) {
                    if (isset($someone1)) {
                        //echo $someone1['AuditManager']['audit_end_date'];
                        if (strlen($someone1['AuditManager']['audit_date']) > 0) {
                            $date = $someone1['AuditManager']['audit_date'];
                            $date = date('Y年n月j日', strtotime($date));
                        } else
                            $date = '';
                        echo $date;
                    }
                }
                ?>
            </td>
        </tr>
        <tr>
            <th>前回監査ジャンル</th>
            <td colspan="5">
                <?php
                if ($data['AuditManager']['item_id'] == 2) {
                    if (isset($items_new)) {
                        echo $items_new['Item']['name'];
                    }
                }
                ?>
            </td>
        </tr>
    </table>
</div>

<div id="actionField" class="clearfix">
<?php echo $this->Html->link('キャンセル', array('controller' => 'AuditManager', 'action' => 'index', $data['AuditManager']['audit_id']), array('class' => 'btnCanceller linkCanceller posLeft')); ?>
    <button class="btnStandard linkCanceller posright" type="submit">OK</button>
</div>
<?php echo $this->Form->end(); ?>