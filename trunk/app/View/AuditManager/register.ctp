<style>
    table#serchfield th {
        text-align: center;
        color: black;
    }
    #error_mes{
        background: none repeat scroll 0 0 #FFFFFF;
        border: 1px solid #999999;
        margin: 5px 0 40px;
        padding: 10px;
        display: none;
        color: red;
    }
</style>

<div id="error_mes" class="clearfix">
    <h4 style="top: 10px; color: red"></h4>
</div>
<div class="mainarea">
    <table id="summaryField">
        <col width="10%" />
        <col width="15%" />
        <col width="10%" />
        <col width="15%" />
        <col width="10%" />
        <col width="15%" />
        <?php echo $this->Form->create('Calendar', array('url' => array('controller' => 'Calendar', 'action' => 'register', $date_audit))); ?>
        <tr>
            <th>監査予定日</th>
            <td colspan="5">
                <?php
                echo $date_audit;
                echo $this->Form->hidden('date', array('label' => false, 'value' => $date_audit));
                ?>
            </td>
        </tr>
        <tr>
            <th>店舗</th>
            <td colspan="5">
                <?php echo $this->Form->input('name_store', array('class' => 'nameinput', 'type' => 'text', 'label' => false, 'div' => false, 'value' => $data['Calendar']['name_store'])); ?>			
                <button value="true" class="seach_class_btn" id="scbar_btn" onclick="loadStore()" type="button">選択</button>

                <?php
                if (!isset($store_search)) {
                    $options1 = array('' => '');
                    foreach ($stores as $store) {
                        $options1 += array(
                            $store ['Store'] ['store_id'] => $store['Store'] ['name']
                        );
                    }
                    echo $this->Form->input('store_id', array(
                        'options' => $options1,
                        'default' => $data['Calendar']['store_id'],
                        'style' => 'width: 200px; margin-left: 30px;',
                        'label' => false,
                        'class' => 'select_box',
                        'div' => false,
                    ));
                } else {
                    $option2 = array('' => '');
                    for ($i = 0; $i < count($store_search); $i++) {
                        $option2 += array($store_search[$i]['Store']['store_id'] => $store_search[$i]['Store']['name']);
                    }
                    echo $this->Form->input('store_id', array(
                        'options' => $option2,
                        'default' => $data['Calendar']['store_id'],
                        'style' => 'width: 200px; margin-left: 30px;',
                        'label' => false,
                        'class' => 'select_box',
                        'div' => false,
                    ));
                }
                ?>
            </td>
        </tr>
        <tr>
            <th>ジャンル</th>
            <td colspan="5">
                <?php
                $options = array('0' => '');
                foreach ($items as $item) {
                    $options += array(
                        $item ['Item'] ['item_id'] => $item ['Item'] ['name']
                    );
                }
                echo $this->Form->input('item_id', array(
                    'options' => $options,
                    'default' => $data['Calendar']['item_id'],
                    'style' => '',
                    'label' => false
                ));
                ?>
            </td>
        </tr>

    </table>
</div>

<div id="actionField" class="clearfix">
    <?php echo $this->Html->link('戻る', array('controller' => 'Calendar', 'action' => 'index'), array('class' => 'btnCanceller linkCanceller posLeft')); ?>
    <button class="btnStandard linkCanceller posright" type="submit">登録</button>
</div>
<?php echo $this->Form->end(); ?>
<script>
    jQuery(function() {
        jQuery('.timePicker').datepicker({
            timeFormat: 'yyyy/m/d',
            'controlType': 'select'
        });
    });
    var tt = ($(".error-message:first").text());
    $("#error_mes").text(tt);
    if (tt.length > 0)
        $("#error_mes").show();
</script>
<script>
    function loadStore() {
        var curr = $("input[name='data[Calendar][name_store]']").val();
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->Html->url(array('controller' => 'Calendar', 'action' => 'storesearch')) ?>',
            data:
                    {
                        curr: curr
                    },
            success: function(data) {//alert(data);
                $('#CalendarStoreId').html(data).show();
            },
            error: function() {
                alert("error");
            }

        });
    }
</script>