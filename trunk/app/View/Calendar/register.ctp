<style>
    table#serchfield th {
        text-align: center;
        color: black;
    }
    #error_mes{
        background: none repeat scroll 0 0 #FFFFFF;
        border: 1px solid #999999;
        margin: 5px 0 30px;
        padding: 10px;
        display: none;
        font-weight: bold;
        font-size: 15px;
        color: red;
    }
</style>
<div id="error_mes" class="clearfix"></div>
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
                if (strlen($date_audit) > 0) {
                    $date = $date_audit;
                    $date = date('Y年n月j日', strtotime($date));
                } else
                    $date = '';
                echo $date;
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
                if (isset($stores_search) && count($stores_search) > 0) {
                    $options = array('' => '');
                    for ($i = 0; $i < count($stores_search); $i++) {
                        $options += array(
                            $stores_search[$i]['Store']['store_id'] => $stores_search[$i]['Store']['name']
                        );
                    }
                } else {
                    $options = array('' => '');
                    foreach ($stores as $store) {
                        $options += array(
                            $store ['Store'] ['store_id'] => $store['Store'] ['name']
                        );
                    }
                }
                echo $this->Form->input('store_id', array(
                    'options' => $options,
                    'default' => $data['Calendar']['store_id'],
                    'style' => 'width: 200px; margin-left: 30px;',
                    'label' => false,
                    'class' => 'select_box',
                    'div' => false,
                ));
                ?>
            </td>
        </tr>
        <tr>
            <th>ジャンル</th>
            <td colspan="5">
                <?php
                $options = array('' => '');
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
    $('#CalendarNameStore').keydown(function(e) {
        if (e.keyCode == 13) {
            e.preventDefault();
        }
    });
</script>

<script>
    function loadStore() {
        var curr = $("input[name='data[Calendar][name_store]']").val();
        var date = $("input[name='data[Calendar][date]']").val();
        //alert(date);
        if (curr != '') {
            $.ajax({
                type: 'POST',
                url: '<?php echo $this->Html->url(array('controller' => 'Calendar', 'action' => 'storesearch')) ?>',
                data:
                        {
                            curr: curr,
                            date: date
                        },
                success: function(data) {
                    //alert(data);
                    $('#CalendarStoreId').html(data);
                    if ($("select[name='data[Calendar][store_id]']").val() == 0) {
                        $("#error_mes").text("検索結果はありません。再検索してください。");
                        $("#error_mes").show();
                    }
                    else
                        $("#error_mes").hide();
                },
                error: function() {
                    alert("error");
                }

            });
        } else {
            $("#error_mes").text("[店舗]入力がありません。");
            $("#error_mes").show();
        }
    }
</script>