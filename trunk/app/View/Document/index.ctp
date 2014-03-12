<?php ?>
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

    table#serchfield input.shopcode1 {
        width: 60%;
    }

    .shortern {
        width: 100px;
    }
</style>
<h4 style="top: 10px; color: red">
    <?php if (isset($e_message)) echo '<div class="error_mes clearfix" style="display:block">' . $e_message . '</div>' ?> 
</h4>
<?php echo $this->Form->create('searchForm', array('type' => 'post', 'url' => array('controller' => 'Document', 'action' => 'search'))); ?>
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
        <th>ジャンル</th>
        <td>
            <?php
            $options = array('0' => '');
            foreach ($items as $item) {
                $options += array(
                    $item ['Item'] ['item_id'] => $item ['Item'] ['name']
                );
            }
            echo $this->Form->input('item', array(
                'options' => $options,
                'default' => $search ['searchForm'] ['item'],
                'style' => 'width:80%; height:22px;',
                'label' => false
            ));
            ?>
        </td>
        <th>カテゴリ</th>
        <td colspan="1">
            <?php
            $options = array('0' => '');
            foreach ($categories as $cate) {
                $options += array(
                    $cate ['Category'] ['category_id'] => $cate ['Category'] ['category_name']
                );
            }
            echo $this->Form->input('category', array(
                'options' => $options,
                'default' => $search ['searchForm'] ['category'],
                'style' => 'width:80%; height:22px;',
                'label' => false,
            ));
            ?>
        </td>
    </tr>

    <tr>
        <th>有効開始日</th>
        <td colspan="3">
            <?php
// 						if (strlen($search['searchForm']['start_date1'])>0){ 
// 						  $date = $search['searchForm']['start_date1'];
// 						  $date = date('Y年n月j日',  strtotime($date));
// 						} else  $date ='';
            $date = $search['searchForm']['start_date1'];
            echo $this->Form->input('start_date1', array('label' => false, 'class' => 'shortern timePicker', 'value' => $date, 'type' => 'text', 'div' => FALSE));
            ?>
            〜
            <?php
// 						if (strlen($search['searchForm']['start_date2'])>0){ 
// 						  $date = $search['searchForm']['start_date2'];
// 						  $date = date('Y年n月j日',  strtotime($date));
// 						} else  $date ='';
            $date = $search['searchForm']['start_date2'];
            echo $this->Form->input('start_date2', array('label' => false, 'class' => 'shortern timePicker', 'value' => $date, 'type' => 'text', 'div' => FALSE));
            ?>
        </td>
    </tr>

    <tr>
        <th>有効終了日</th>
        <td colspan="3">
            <?php
// 						if (strlen($search['searchForm']['end_date1'])>0){ 
// 						  $date = $search['searchForm']['end_date1'];
// 						  $date = date('Y年n月j日',  strtotime($date));
// 						} else  $date ='';
            $date = $search['searchForm']['end_date1'];
            echo $this->Form->input('end_date1', array('label' => false, 'class' => 'shortern timePicker', 'value' => $date, 'type' => 'text', 'div' => FALSE));
            ?>
            〜
            <?php
// 						if (strlen($search['searchForm']['end_date2'])>0){ 
// 						  $date = $search['searchForm']['end_date2'];
// 						  $date = date('Y年n月j日',  strtotime($date));
// 						} else  $date ='';
            $date = $search['searchForm']['end_date2'];
            echo $this->Form->input('end_date2', array('label' => false, 'class' => 'shortern timePicker', 'value' => $date, 'type' => 'text', 'div' => FALSE));
            ?>
        </td>
    </tr>
    <tr>
        <td colspan="6">
            <div class="btn">
                <input type="submit" name="" value="この条件で検索する"
                       class="btnStandard posright" style="height: 30px;"/>
            </div>
        </td>
    </tr>
</table>
        <?php echo $this->Form->end(); ?>
<div id="resultSummary">
    <div id="resultAction">
<?php echo $this->Html->link('新規作成', array('controller' => 'Document', 'action' => 'register'), array('class' => 'btnStandard linkCanceller posright postop', 'style' => 'height: 30px;')); ?>
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
if (!isset($paging_show))
    echo $this->element('document_paging');
else {
    echo "<style>#actionField {margin:75px 0 0;}</style>";
}
?>

    <?php //echo $this->Paginator->counter(); ?>
<div id="actionField" class="clearfix">
<?php echo $this->Html->link('戻る', array('controller' => 'menu', 'action' => 'index'), array('class' => 'btnCanceller linkCanceller posLeft')); ?>
</div>
<script>
    $("select[name='data[searchForm][item]']").change(function() {
        var curr = $("select[name='data[searchForm][item]']").val();
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->Html->url(array('controller' => 'document', 'action' => 'itemsearch')) ?>',
            data:
                    {
                        curr: curr
                    },
            success: function(data) {//alert(data);
                $('#searchFormCategory').html(data).show();
            },
            error: function() {
                alert("error");
            }

        });
    })
</script>


