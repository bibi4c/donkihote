<?php
//$this->Paginator->options(
//        array('update'=>'#content',
//                'url'=>array('controller'=>'User', 
//'action'=>'postlist')));
?>
<table class="resultlist">
        <!--<col width="15%" /><col width="20%" /><col width="33%" /><col width="17%" /><col width="15%" />-->
    <tr>
        <th>店番</th>
        <th>店舗名</th>
        <th>有効開始日</th>
        <th>有効終了日</th>
    </tr>
    <?php foreach ($stores as $store): ?>
        <tr>
            <td>
                <?php echo $this->Html->link($store['Store']['store_no'], array('action' => 'view', $store['Store']['store_id'])); ?>
            </td>
            <td width=480px><?php echo $store['Store']['name']; ?></td>
            <td><?php
                if (strlen($store['Store']['valid_start_day']) > 0) {
                    $date = $store['Store']['valid_start_day'];
                    $date = date('Y年n月j日', strtotime($date));
                } else
                    $date = '';
                echo $date;
                ?></td>
            <td><?php
                if (strlen($store['Store']['valid_end_day']) > 0) {
                    $date = $store['Store']['valid_end_day'];
                    $date = date('Y年n月j日', strtotime($date));
                } else
                    $date = '';
                echo $date;
                ?></td>
        </tr>
<?php endforeach; ?>
</table>
<?php
$pos = strrpos($this->here, "page");
?>
<?php if (count($data_all_store) > 10 || $pos == TRUE) { ?>
    <ul class="paging">
        <li><?php echo $this->Paginator->prev('<', null, null, array('class' => 'nolink')); ?></li>
        <li><?php echo $this->Paginator->numbers(array('separator' => '', 'style' => 'width:20px;')); ?></li>
        <li><?php echo $this->Paginator->next('>', null, null, array('class' => 'nolink')); ?></li>
    </ul>
<?php
}?>