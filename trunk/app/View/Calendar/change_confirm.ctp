<div class="mainarea">
    <div class="error_mes clearfix" style="display:block;margin: 5px 0 20px;"><h4 style="top: 10px; font-weight: bold;">以下の内容を登録します。よろしければOKボタンを押してください。</h4></div><br>
    <table id="summaryField">
        <col width="30%" />
        <col width="70%" />
        <?php echo $this->Form->create('Document', array('url' => array('controller' => 'Document', 'action' => 'change_confirm'))); ?>
        <tr>
            <th>ジャンル</th>
            <td>
                <?php
                echo $items['0']['Item']['name'];
                echo $this->Form->hidden('item_id', array('value' => $items['0']['Item']['item_id'], 'label' => false));
                ?>
            </td>
        </tr>
        <tr>
            <th>カテゴリ</th>
            <td>
                <?php
                echo $category['0']['Category']['category_name'];
                echo $this->Form->hidden('category_id', array('value' => $category['0']['Category']['category_id'], 'label' => false));
                ?>
            </td>
        </tr>
        <tr>
            <th>引き継ぎ対象</th>
            <td>
                <?php
                if ($document_data['Document']['transfer_flag'] == 1) {
                    echo '臨点チェックシート引き継ぎあり';
                } else {
                    echo '臨点チェックシート引き継ぎなし';
                }
                echo $this->Form->hidden('transfer_flag', array('value' => $document_data['Document']['transfer_flag'], 'label' => false, 'type' => 'text'));
                ?>
            </td>
        </tr>
        <tr>
            <th>有効開始日</th>
            <td>
                <?php
                echo $document_data['Document']['start_date'];
                echo $this->Form->hidden('start_date', array('value' => $document_data['Document']['start_date'], 'label' => false, 'type' => 'text'));
                ?>
            </td>
        </tr>
        <tr>
            <th>有効終了日</th>
            <td>
<?php
echo $document_data['Document']['end_date'];
echo $this->Form->hidden('end_date', array('value' => $document_data['Document']['end_date'], 'label' => false, 'type' => 'text'));
?>
            </td>
        </tr>
    </table>

    <table class="summaryObject">
        <caption id="MA020_content">内容</caption>
        <tr>
            <td>
<?php
echo $document_data['Document']['contents'];
echo $this->Form->hidden('contents', array('value' => $document_data['Document']['contents'], 'label' => false, 'type' => 'text'));
?>
            </td>
        </tr>
    </table>

    <div id="actionField" class="clearfix">
<?php echo $this->Html->link('キャンセル', array('controller' => 'Document', 'action' => 'view', $document_data['Document']['document_id']), array('class' => 'btnCanceller linkCanceller posLeft')); ?>
        <button class="btnStandard linkCanceller posright" type="submit">OK</button>
    </div>
</div>
<?php echo $this->Form->end(); ?>