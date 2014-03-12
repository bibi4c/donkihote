<style>
    table#serchfield th {
        background: #4F81BD;
        text-align: center;
        color: black;
    }
    select {
        color: black;
    }
</style>

<?php
echo $this->Html->script('jquery.fancybox');
echo $this->Html->css('jquery.fancybox');
// 	debug($data);
//debug($data_audit_detail_file);
$urlsearch = $this->Html->url(array('controller' => 'Fileuploads', 'action' => 'delete'));
if (isset($this->request->pass['2'])) {
    $var11 = $this->request->pass['2'];
    $var12 = $this->request->pass['3'];
} else {
    $var11 = 0;
    $var12 = 0;
}
?>
<?php $user = $this->Session->read('Auth.User'); ?>
<?php //debug($user)
?>
<h4 style="top: 10px; color: red">
    <?php if (isset($err_message)) echo '<div class="error_mes clearfix" style="display:block">' . $err_message . '</div>' ?> 
</h4>
<div class="mainarea">
    <?php echo $this->Form->create('Category', array('type' => 'post', 'url' => array('controller' => 'Category', 'action' => 'view', $data['Category']['category_id'], $data['Category']['audit_id'], $var11, $var12))); ?>
    <table class="TB040_table1">
        <tr>
            <td id="TB040_table1_column1">監査カテゴリ</td>
            <td id="TB040_table1_column2">
                <?php
                echo $data['Category']['category_name'];
                echo $this->Form->hidden('category_name', array('label' => false, 'value' => $data['Category']['category_name']));
                echo $this->Form->hidden('category_id', array('label' => false, 'value' => $data['Category']['category_id']));
                echo $this->Form->hidden('audit_id', array('label' => false, 'value' => $data['Category']['audit_id']));
                ?>
            </td>
            <td id="TB040_table1_column3">評価有無</td>
            <td id="TB040_table1_column4">
                <?php
                //debug($user['authority_id']);
                if ($user['authority_id'] == 1 && ($data['Category']['status'] == 1 || $data['Category']['status'] == 2 || $data['Category']['status'] == 3)) {
                    echo $this->Form->input('valid_flag', array(
                        'type' => 'radio',
                        'options' => array(
                            '1' => '　あり　',
                            '2' => '　なし ',
                        ),
                        'label' => false,
                        'legend' => false,
                        'default' => $data['Category']['valid_flag'],
                        'required' => false,
                        'disabled' => 'true'
                    ));
                } else if ($user['authority_id'] == 3) {
                    echo $this->Form->input('valid_flag', array(
                        'type' => 'radio',
                        'options' => array(
                            '1' => '　あり　',
                            '2' => '　なし ',
                        ),
                        'label' => false,
                        'legend' => false,
                        'default' => $data['Category']['valid_flag'],
                        'required' => false,
                        'disabled' => 'true'
                    ));
                } else if ($user['authority_id'] == 2 && ($data['Category']['status'] == 0 || $data['Category']['status'] == 4)) {
                    echo $this->Form->input('valid_flag', array(
                        'type' => 'radio',
                        'options' => array(
                            '1' => '　あり　',
                            '2' => '　なし ',
                        ),
                        'label' => false,
                        'legend' => false,
                        'default' => $data['Category']['valid_flag'],
                        'required' => false,
                        'disabled' => 'true'
                    ));
                } else {
                    echo $this->Form->input('valid_flag', array(
                        'type' => 'radio',
                        'options' => array(
                            '1' => '　あり　',
                            '2' => '　なし ',
                        ),
                        'label' => false,
                        'legend' => false,
                        'default' => $data['Category']['valid_flag'],
                        'required' => false,
                    ));
                }
                ?>
            </td>
        </tr>
    </table>
    <table class="TB040_table2 detailInspectionlist">
        <tr>
            <th class="TB040_table2_column1"></th>
            <th class="TB040_table2_column2">評価</th>
            <th class="TB040_table2_column3">ファイル</th>
            <th class="TB040_table2_column4">添付</th>
        </tr>
<?php foreach ($document_all as $document) { ?>
            <tr>
    <?php //debug($document);die; ?>
                <td class="TB040_table2_column1"><h3>
            <?php
            echo $data['Category']['contents_' . $document['Document']['document_id']];
            //echo $this->Form->hidden('contents_'.$document['Document']['document_id'], array('label'=>false, 'value'=>$data['Category']['contents_'.$document['Document']['document_id']]));
            ?>
                    </h3></td>
                <td class="TB040_table2_column2">
                        <?php
                        if ($data_audit['0']['Audit']['item_id'] == 3) {
                            $options = array('0' => '', '1' => '良', '2' => '可', '3' => '不可', '4' => '該当なし');
                        } else {
                            $options = array('0' => '', '1' => '良', '2' => '可', '3' => '不可');
                        }
                        $options_bibi = array('0' => array('0' => ''), '1' => array('1' => '良'), '2' => array('2' => '可'), '3' => array('3' => '不可'), '4' => array('4' => 'なし'));
                        if ($user['authority_id'] == 1 && ($data['Category']['status'] == 1 || $data['Category']['status'] == 2 || $data['Category']['status'] == 3)) {
                            echo $this->Form->input('judgment_' . $document['Document']['document_id'], array(
                                'options' => $options_bibi[$data['Category']['judgment_' . $document['Document']['document_id']]],
                                'style' => '',
                                'default' => $data['Category']['judgment_' . $document['Document']['document_id']],
                                'label' => false, 'disabled' => 'true',
                                'class' => 'CategoryJudgment'
                            ));
                        } else if ($user['authority_id'] == 3) {
                            echo $this->Form->input('judgment_' . $document['Document']['document_id'], array(
                                'options' => $options_bibi[$data['Category']['judgment_' . $document['Document']['document_id']]],
                                'style' => '',
                                'default' => $data['Category']['judgment_' . $document['Document']['document_id']],
                                'label' => false, 'disabled' => 'true',
                                'class' => 'CategoryJudgment'
                            ));
                        } else if ($user['authority_id'] == 2 && ($data['Category']['status'] == 0 || $data['Category']['status'] == 4)) {
                            echo $this->Form->input('judgment_' . $document['Document']['document_id'], array(
                                'options' => $options_bibi[$data['Category']['judgment_' . $document['Document']['document_id']]],
                                'style' => '',
                                'default' => $data['Category']['judgment_' . $document['Document']['document_id']],
                                'label' => false,
                                'class' => 'CategoryJudgment'
                            ));
                        } else {
                            echo $this->Form->input('judgment_' . $document['Document']['document_id'], array(
                                'options' => $options,
                                'style' => '',
                                'default' => $data['Category']['judgment_' . $document['Document']['document_id']],
                                'label' => false,
                                'class' => 'Category_Judgment'
                            ));
                        }
                        ?>
                </td>
                <td
                    id="bibi<?php echo $data['Category']['audit_' . $document['Document']['document_id']] ?>">
                    <?php
                    $bibi_stt = 2;
                    if ($user['authority_id'] == 1 && ($data['Category']['status'] == 1 || $data['Category']['status'] == 2 || $data['Category']['status'] == 3)) {
                        $bibi_stt = 1;
                    } else if ($user['authority_id'] == 3) {
                        $bibi_stt = 1;
                    } else if ($user['authority_id'] == 2 && ($data['Category']['status'] == 0 || $data['Category']['status'] == 4)) {
                        $bibi_stt = 1;
                    } else {
                        $bibi_stt = 2;
                    }
                    $data1 = $data_audit_detail_file[$document['Document']['document_id']];
                    foreach ($data1 as $data2) {
                        $linkDownload = $this->Html->url(array(
                            "controller" => "Category",
                            "action" => "detail_download", $data2['Audit_detail_file']['audit_detail_file_id']
                        ));
                        echo "<p><a href='$linkDownload'>" . $data2['Audit_detail_file']['audit_detail_file_name'] . '</a>';
                        //echo $this->Form->postLink(__(' 削除'), array('controller'=>'Fileuploads','action' => 'delete', $data2['Audit_detail_file']['audit_detail_file_id']), null, __('Are you sure you want to delete %s?', $data2['Audit_detail_file']['audit_detail_file_name']));
                        $urldelete = $this->Html->url(array('controller' => 'Fileuploads', 'action' => 'delete', $data2['Audit_detail_file']['audit_detail_file_id']));
                        ?>
                        <a
                            class="file_bibi_<?php if ($bibi_stt == 1) echo '1';
                    else echo '2'; ?> file_<?php echo $data2['Audit_detail_file']['audit_detail_file_id']; ?>"
                            href="javascript:void(0)"
                            onclick='deleteFile("<?php echo $urldelete ?>", "<?php echo $data2['Audit_detail_file']['audit_detail_file_id']; ?>")'>削除</a>
                            <?php
                            echo "</p>";
                        }
                        ?>						    		
                </td>
                <td class="TB040_table2_column4">
                        <!--						    		<a onclick="dragablefile(<?php echo $document['Document']['document_id'] ?>)" href="javascript:void(0)">添付</a>-->
                        <?php
                        // debug($bibi_stt);
                        if ($bibi_stt == 1) {
                            echo '';
                        } else {
                            echo $this->Html->link('添付', array('controller' => 'Fileuploads', 'action' => 'add', $data['Category']['audit_' . $document['Document']['document_id']], $data_store)
                                    , array('class' => 'fancybox fancybox.iframe', 'id' => 'facy' . $data['Category']['audit_' . $document['Document']['document_id']]));
                        }
                        ?>
                </td>
            </tr>
                <?php } ?>
    </table>
</div>
<div id="actionField" class="clearfix">
        <?php echo $this->Html->link('戻る', array('controller' => 'AuditManager', 'action' => 'index', $data['Category']['audit_id']), array('class' => 'btnCanceller linkCanceller posLeft')); ?>

<?php
if ($user['authority_id'] == 1 && ($data['Category']['status'] == 1 || $data['Category'] ['status'] == 2 || $data['Category'] ['status'] == 3)) {
    echo '';
} else if ($user ['authority_id'] == 3) {
    echo '';
} else if ($user ['authority_id'] == 2 && ($data ['Category'] ['status'] == 0 || $data ['Category'] ['status'] == 4)) {
    echo '';
} else {
    ?>
        <button class="btnStandard linkCanceller posright" type="submit">登録</button>
    <?php } ?>
</div>
    <?php echo $this->Form->end(); ?>
    <?php ?>
<script>


    $(document).ready(function() {

        $('.fancybox').click(function(event) {
            event.preventDefault();
            var idsave = $(this).attr("id");
            $('.fancybox').fancybox({
                'autoDimensions': false,
                'autoSize': false,
                'height': 400,
                'width': 530,
                'z-index': 10000,
                afterClose: function() {
                    var bibi = idsave;
                    var id = bibi.substr(4);
                    //alert(id);
                    reloadajax(id);
                }
            });
        });
    });
    function reloadajax(id) {
        var url = "<?php echo $this->Html->url(array('controller' => 'Category', 'action' => 'search_file')) ?>";
        $.ajax({
            type: 'POST',
            url: url,
            data:
                    {
                        id: id
                    },
            success: function(data) {//
                // alert(data);
                $('#bibi' + id).html(data).show();
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


<style>
    .file_bibi_1 {
        display: none;
    }
</style>