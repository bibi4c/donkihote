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
    table#serchfield th {
        text-align:center;
        color:black;
        width: 15%;
    }
    #error_mes{
        background: none repeat scroll 0 0 #FFFFFF;
        border: 1px solid #999999;
        margin: 5px 0 30px;
        padding: 10px;
        font-weight: bold;
        font-size: 15px;
        display: none;
        color: red;
    }
</style>
<h4 id="error_mes" class="clearfix" style="top: 10px; color: red"></h4>
<div class="mainarea">
    <div id="MCC020_content_part1">
        <table id="summaryField">
            <col width="10%" />
            <col width="15%" />
            <col width="10%" />
            <col width="15%" />
            <col width="10%" />
            <col width="15%" />
            <tr>
                <?php echo $this->Form->create('Store', array('url' => array('controller' => 'Store', 'action' => 'register'))); ?>
                <th>店番</th>
                <td>
                    <?php echo $this->Form->input('store_no', array('type' => 'text', 'value' => $data_store['Store']['store_no'], 'class' => 'dateinput', 'label' => false, 'required' => FALSE)); ?>
                </td>
                <th>属性</th>
                <td>
                    <?php
                    $options = array();
                    foreach ($properties as $property) {
                        $options += array($property['Property']['puroperty_id'] => $property['Property']['name']);
                    }
                    echo $this->Form->input('puroperty_id', array(
                        'options' => $options,
                        'style' => '',
                        'default' => $property_name['0']['Property']['puroperty_id'],
                        'label' => false
                    ));
                    ?>
                </td>
                <th>店舗名</th>
                <td>
                    <?php echo $this->Form->input('name', array('type' => 'text', 'class' => 'dateinput', 'value' => $data_store['Store']['name'], 'label' => false, 'required' => FALSE)); ?>
                </td>
            </tr>
            <tr>
                <th>有効開始日</th>
                <td colspan="5">
                    <?php echo $this->Form->input('valid_start_day', array('type' => 'text', 'value' => $data_store['Store']['valid_start_day'], 'style' => 'width: 30%', 'class' => 'dateinput timePicker', 'label' => false, 'required' => FALSE)); ?>	
                </td>
            </tr>
            <tr>
                <th>有効終了日</th>
                <td colspan="5">
                    <?php echo $this->Form->input('valid_end_day', array('type' => 'text', 'value' => $data_store['Store']['valid_end_day'], 'style' => 'width: 30%', 'class' => 'dateinput timePicker', 'label' => false, 'required' => FALSE)); ?>	
                </td>
            </tr>
        </table>
    </div>

</div>

<div id="actionField" class="clearfix">
    <button class="btnStandard linkCanceller posright" type="submit">登録</button>
    <?php echo $this->Html->link('戻る', array('controller' => 'Store', 'action' => 'index'), array('class' => 'btnCanceller linkCanceller posLeft')); ?>

</div>
<?php echo $this->Form->end(); ?>
<script>
    var tt = ($(".error-message:first").text());
    $("#error_mes").text(tt);
    if (tt.length > 0)
        $("#error_mes").show();
</script>