<script>
    jQuery(function() {
        jQuery('.timePicker').datepicker({
            timeFormat: 'yyyy/mm/dd',
            'controlType': 'select'
        });
    });
    function hideTempu1() {
        document.getElementById('my_file').click();

    }
    function hiddenText(element) {
        var e = element.parentNode;
        e.style.display = "none";
    }
</script>
<?php
echo $this->Html->script('jquery.fancybox');
echo $this->Html->css('jquery.fancybox');
?>
<style>
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
<h4 style="top: 10px; color: red">
    <?php
    if (isset($error_message)) {
        echo '<div class="error_mes clearfix" style="display:block">' . $error_message . '</div>';
    }
    ?> 
</h4>
<?php echo $this->Form->create('AuditManager', array('type' => 'post', 'url' => array('controller' => 'AuditManager', 'action' => 'view', $audit_id))); ?>

<div class="mainarea">
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
                echo $stores ['0'] ['Store'] ['store_no'];

                echo $this->Form->hidden('store_no', array(
                    'label' => false,
                    'div' => false,
                    'value' => $stores ['0'] ['Store'] ['store_no']
                ));
                echo $this->Form->hidden('audit_id', array('label' => false, 'value' => $data['AuditManager']['audit_id']))
                ?>
            </td>
            <th>店舗名</th>
            <td>
                <?php
                echo $stores ['0'] ['Store'] ['name'];
                echo $this->Form->hidden('store_name', array(
                    'label' => false,
                    'div' => false,
                    'value' => $stores ['0'] ['Store'] ['name']
                ));
                ?>
            </td>
            <th>属性</th>
            <td>
                <?php
                echo $property ['0'] ['Property'] ['name'];
                echo $this->Form->hidden('property_id', array(
                    'label' => false,
                    'div' => false,
                    'value' => $property ['0'] ['Property'] ['puroperty_id']
                ));
                ?>
            </td>
        </tr>
        <tr>
            <th>ジャンル</th>
            <td colspan="1">
                <?php
                echo $items ['0'] ['Item'] ['name'];
                echo $this->Form->hidden('item_id', array(
                    'label' => false,
                    'div' => false,
                    'value' => $items ['0'] ['Item'] ['item_id']
                ));
                ?>
            </td>
            <th>担当者</th>
            <td colspan="3">
                <?php
                echo $user_create['User']['user_name'];
                ?>
            </td>
        </tr>
        <tr>
            <th>状態</th>
            <td colspan="5">
                <?php
                $options = array(
                    '2' => '承認待ち',
                    '3' => '是正中',
                    '1' => '監査完了',
                );
                echo $this->Form->input('status', array(
                    'options' => $options,
                    'style' => '',
                    'default' => $data ['AuditManager'] ['status'],
                    'label' => false,
                    'id' => 'TB050_select'
                ));
                ?>
            </td>
        </tr>
        <tr>
            <th>是正通知日</th>
            <td colspan="5">
                <?php echo $this->Form->input('correct_information_date', array('type' => 'text', 'style' => 'width: 30%', 'class' => 'dateinput timePicker', 'value' => $data['AuditManager']['correct_information_date'], 'label' => false)); ?>	
            </td>
        </tr>
        <tr>
            <th>是正完了予定日</th>
            <td colspan="5">
                <?php echo $this->Form->input('correct_end_scheduled_date', array('type' => 'text', 'style' => 'width: 30%', 'class' => 'dateinput timePicker', 'value' => $data['AuditManager']['correct_end_scheduled_date'], 'label' => false)); ?>	
            </td>
        </tr>
    </table>

    <table class="summaryObject">
        <caption>コメント</caption>
        <tr>
            <td>
                <?php
                //debug($data);
                if (isset($error_message))
                    $data['AuditManager']['comment'] = $comment_data;
                echo $this->Form->input('comment', array('type' => 'textarea', 'style' => 'width: 100%', 'rows' => '3', 'clos' => '117', 'label' => false, 'required' => false, 'value' => $data['AuditManager']['comment']));
                ?>
            </td>
        </tr>
    </table>

    <div>
        <div id="TB050_displayfile">
            <div id="TB050_title">是正勧告書</div>
            <div id="messages1">
<?php if (count($data_audit_files) == 0) { ?>
                    <p id="begintext">
                        <font color="#000000" size="2px">添付ファイルがありません</font>
                    </p>
                <?php } else { ?>

                    <?php
                    foreach ($data_audit_files as $file) {
                        echo "<p>" . $file['Audit_file']['audit_file_name'];
                        //echo $this->Form->postLink(__(' 削除'), array('controller'=>'Fileuploads','action' => 'delete', $data2['Audit_detail_file']['audit_detail_file_id']), null, __('Are you sure you want to delete %s?', $data2['Audit_detail_file']['audit_detail_file_name']));
                        $urldelete = $this->Html->url(array('controller' => 'Auditfileuploads', 'action' => 'delete', $file['Audit_file']['audit_file_id']));
                        ?>
                        <a class="file_<?php echo $file['Audit_file']['audit_file_id']; ?>" href="javascript:void(0)" onclick='deleteFile("<?php echo $urldelete ?>", "<?php echo $file['Audit_file']['audit_file_id']; ?>")'>削除</a>
                        <?php
                        echo "</p>";
                    }
                }
                ?>
            </div>
        </div>

    </div>
    <div id="file_open" style="padding-bottom : 40px">


        <?php echo $this->Html->link('添付', array('controller' => 'Auditfileuploads', 'action' => 'add', $this->request->pass['0'], $stores ['0'] ['Store'] ['store_no'])
                , array('class' => 'fancybox fancybox.iframe btnStandard linkCanceller posright', 'style' => 'height:33px; margin-top: 10px'));
        ?> 
<!-- 		<input type="file" id="my_file"> -->
    </div>
    <div>

<!-- 		<input type="hidden" id="MAX_FILE_SIZE" name="MAX_FILE_SIZE" value="300000" /> -->
<?php echo $this->Form->hidden('maxsize', array('id' => 'MAX_FILE_SIZE', 'name' => 'MAX_FILE_SIZE', 'value' => '300000', 'label' => false)); ?>

    </div>

    <div id="actionField" class="clearfix">
<?php echo $this->Html->link('戻る', array('controller' => 'AuditManager', 'action' => 'index', $data['AuditManager']['audit_id']), array('class' => 'btnCanceller linkCanceller posLeft')); ?>
        <button class="btnStandard linkCanceller posright" type="submit">登録</button>
    </div>
</div>
<?php echo $this->Form->end(); ?>
<script>
    var tt = ($(".error-message:first").text());
    $("#error_mes").text(tt);
    if (tt.length > 0)
        $("#error_mes").show();

    $(document).ready(function() {

        $('.fancybox').click(function(event) {
            $('.fancybox').fancybox({
                'autoDimensions': false,
                'autoSize': false,
                'height': 400,
                'width': 530,
                'z-index': 10000,
                afterClose: function() {
                    //alert(id);
                    var id = "<?php echo $data['AuditManager']['audit_id'] ?>";
                    reloadajax(id);
                }
            });
        });
    });
    function reloadajax(id) {
        var url = "<?php echo $this->Html->url(array('controller' => 'AuditManager', 'action' => 'search_file')) ?>";
        $.ajax({
            type: 'POST',
            url: url,
            data:
                    {
                        id: id
                    },
            success: function(data) {//
                //alert(data);
                //alert(id);
                $('#messages1').html(data).show();
            },
            error: function() {
                alert("error");
            }

        });
    }
    function deleteFile(url, id) {
//alert(url);
        if (confirm('本当にこのファイルを削除しますか？')) {
            $.ajax({
                type: 'POST',
                url: url,
                data:
                        {
                        },
                success: function(data) {//alert(data);
                    $('.file_' + id).parent().hide();
                },
                error: function() {
                    alert("error");
                }

            });
        }
    }
</script>