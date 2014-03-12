<style>
    table#serchfield th {
        background:	#4F81BD;
        text-align:center;
        color:black;
    }
</style>
<?php
//debug($items);
//debug($stores);	
?>
<?php echo $this->Form->create('Calendar', array('url' => array('controller' => 'Calendar', 'action' => 'register_confirm'))); ?>
<div class="mainarea">
    <div class="error_mes clearfix" style="display:block;margin: 5px 0 20px;"><h4 style="top: 10px; font-weight: bold;">以下の内容を登録します。よろしければOKボタンを押してください。</h4></div><br>
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
                if (strlen($data['Calendar']['date']) > 0) {
                    $date = $data['Calendar']['date'];
                    $date = date('Y年n月j日', strtotime($date));
                } else
                    $date = '';
                echo $date;
                echo $this->Form->hidden('date', array('label' => false, 'value' => $data['Calendar']['date']));
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
            <td colspan="2">
                <?php
                echo $aryUser['user_name'];
                ?>
            </td>
        </tr>
    </table>
</div>

<div id="actionField" class="clearfix">
<?php echo $this->Html->link('戻る', array('controller' => 'Calendar', 'action' => 'register', $data['Calendar']['date']), array('class' => 'btnCanceller linkCanceller posLeft')); ?>
    <button class="btnStandard linkCanceller posright" type="submit">OK</button>
</div>
<?php echo $this->Form->end(); ?>