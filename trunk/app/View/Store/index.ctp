<?php
echo $this->Html->script('jquery-ui');
echo $this->Html->script('jquery-ui-timepicker-addon');
?>
<script>
    jQuery(function() {
        jQuery('.timePicker').datepicker({
            timeFormat: 'yyyy/m/d',
            'controlType': 'select'
        });
    });
</script>
<style>
    #resultAction {
        width: 100%;
    }

    table#serchfield input.shopcode {
        width: 62%;
    }

    table#serchfield input.shopname {
        width: 50%;
    }

    .shortern {
        width: 100px;
    }
</style>
<h4 style="top: 10px; color: red">

    <?php if (isset($e_message)) echo '<div class="error_mes clearfix" style="display:block">' . $e_message . '</div>' ?> 
</h4>
<div class="mainarea">
    <?php echo $this->Form->create('searchForm', array('url' => array('controller' => 'Store', 'action' => 'search'))); ?>
    <table id="serchfield">
        <col width="5%" />
        <col width="25%" />
        <col width="5%" />
        <col width="25%" />
        <col width="9%" />
        <col width="23%" />
        <tr>
            <th style="font-size: 16px"></th>
        <tr>
        <tr>
            <th>店番</th>
            <td>
                <?php echo $this->Form->input('storenum', array('type' => 'text', 'value' => $search['searchForm']['storenum'], 'class' => 'shopcode', 'label' => false)); ?>
            </td>
            <th>店舗名</th>
            <td colspan="3">
                <?php echo $this->Form->input('name', array('type' => 'text', 'class' => 'shopname', 'value' => $search['searchForm']['name'], 'label' => false)); ?>
            </td>
        </tr>

        <tr>
            <th>有効開始日</th>
            <td colspan="3">
                <?php
// 				if (strlen($search['searchForm']['start_date1'])>0){ 
// 						  $date = $search['searchForm']['start_date1'];
// 						  $date = date('Y年n月j日',  strtotime($date));
// 						} else  $date ='';
                $date = $search['searchForm']['start_date1'];
                echo $this->Form->input('start_date1', array('type' => 'text', 'class' => 'shortern timePicker', 'value' => $date, 'div' => false, 'label' => false));
                ?> 
                〜 
                <?php
// 				if (strlen($search['searchForm']['start_date2'])>0){ 
// 						  $date = $search['searchForm']['start_date2'];
// 						  $date = date('Y年n月j日',  strtotime($date));
// 						} else  $date ='';
                $date = $search['searchForm']['start_date2'];
                echo $this->Form->input('start_date2', array('type' => 'text', 'class' => 'shortern timePicker', 'value' => $date, 'div' => false, 'label' => false));
                ?>
            </td>
        </tr>

        <tr>
            <th>有効終了日</th>
            <td colspan="3">
                <?php
// 				if (strlen($search['searchForm']['end_date1'])>0){ 
// 						  $date = $search['searchForm']['end_date1'];
// 						  $date = date('Y年n月j日',  strtotime($date));
// 						} else  $date ='';
                $date = $search['searchForm']['end_date1'];
                echo $this->Form->input('end_date1', array('type' => 'text', 'class' => 'shortern timePicker', 'value' => $date, 'div' => false, 'label' => false));
                ?>
                〜
                <?php
// 				if (strlen($search['searchForm']['end_date2'])>0){ 
// 						  $date = $search['searchForm']['end_date2'];
// 						  $date = date('Y年n月j日',  strtotime($date));
// 						} else  $date ='';
                $date = $search['searchForm']['end_date2'];
                echo $this->Form->input('end_date2', array('type' => 'text', 'class' => 'shortern timePicker', 'value' => $date, 'div' => false, 'label' => false));
                ?>	
            </td>
        </tr>

        <tr>
            <td colspan="6">
                <div class="btn">
                    <div class="MCC010_btn_color ">
<?php echo $this->Form->input('この条件で検索する', array('type' => 'submit', 'class' => 'btnStandard posright', 'label' => false, 'style' => 'height: 30px;')); ?>
                    </div>
                </div>
            </td>
        </tr>

    </table>
        <?php echo $this->Form->end(); ?>
</div>

<div id="resultSummary">
    <div id="resultAction">
        <?php echo $this->Html->link('新規作成', array('action' => 'register'), array('class' => 'btnStandard linkCanceller posright postop', 'style' => 'height: 30px;')); ?>
    </div>
    <div id="resultCount">

        <?php
        if (!isset($paging_show))
            echo $this->Paginator->counter(array(
                'format' => __('全<strong>{:count}</strong>件中　<strong>{:start}</strong>件～<strong>{:end}</strong>件を表示')
            ));
        ?>
    </div>
</div>
<?php
if (!isset($paging_show)) {
    echo $this->element('store_paging');
} else {
    echo "<style>#actionField {margin:75px 0 0;}</style>";
}
?>
<div id="actionField" class="clearfix">
<?php echo $this->Html->link('戻る', array('controller' => 'menu', 'action' => 'index'), array('class' => 'btnCanceller linkCanceller posLeft')); ?>
</div>
