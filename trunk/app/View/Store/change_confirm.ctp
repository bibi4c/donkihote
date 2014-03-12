<div class="mainarea">
    <div class="error_mes clearfix" style="display:block;margin: 5px 0 20px;"><h4 style="top: 10px; font-weight: bold;">以下の内容を登録します。よろしければOKボタンを押してください。</h4></div><br>
    <?php //debug($store_data);?>
    <?php echo $this->Form->create('Store', array('url' => array('controller' => 'Store', 'action' => 'change_confirm'))); ?>
    <table id="summaryField">
        <col width="10%" />
        <col width="15%" />
        <col width="10%" />
        <col width="15%" />
        <col width="10%" />
        <col width="15%" />
        <tr>
            <th>店番</th>
            <td>
                <?php
                echo $store_data['Store']['store_no'];
                echo $this->Form->hidden('store_id', array('label' => false, 'value' => $store_data['Store']['store_id']));
                echo $this->Form->hidden('store_no', array('label' => false, 'value' => $store_data['Store']['store_no']));
                ?>
            </td>

            <th>属性</th>
            <td>
                <?php
                echo $properties['0']['Property']['name'];
                echo $this->Form->hidden('property_id', array('label' => false, 'value' => $store_data['Store']['property_id']));
                ?>
            </td>

            <th>店舗名</th>
            <td>
                <?php
                echo $store_data['Store']['name'];
                echo $this->Form->hidden('name', array('label' => false, 'value' => $store_data['Store']['name']));
                ?>
            </td>
        </tr>
        <tr>
            <th>有効開始日</th>
            <td colspan="5">
                <?php
                if (strlen($store_data['Store']['valid_start_day']) > 0) {
                    $date = $store_data['Store']['valid_start_day'];
                    $date = date('Y年n月j日', strtotime($date));
                } else
                    $date = '';
                echo $date;
                echo $this->Form->hidden('valid_start_day', array('label' => false, 'value' => $store_data['Store']['valid_start_day']));
                ?>
            </td>
        </tr>
        <tr>
            <th>有効終了日</th>
            <td colspan="5">
                <?php
                if (strlen($store_data['Store']['valid_end_day']) > 0) {
                    $date = $store_data['Store']['valid_end_day'];
                    $date = date('Y年n月j日', strtotime($date));
                } else
                    $date = '';
                echo $date;
                echo $this->Form->hidden('valid_end_day', array('label' => false, 'value' => $store_data['Store']['valid_end_day']));
                ?>
            </td>
        </tr>
    </table>
</div>

<div id="actionField" class="clearfix">
<?php echo $this->Html->link('キャンセル', array('controller' => 'Store', 'action' => 'view', $store_data['Store']['store_id']), array('class' => 'btnCanceller linkCanceller posLeft')); ?>
    <button class="btnStandard linkCanceller posright"
            type="submit">OK</button>
</div>
<?php echo $this->Form->end(); ?>